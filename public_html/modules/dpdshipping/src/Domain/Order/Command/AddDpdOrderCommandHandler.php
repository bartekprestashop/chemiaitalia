<?php
/**
 * Copyright 2024 DPD Polska Sp. z o.o.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the EUPL-1.2 or later.
 * You may not use this work except in compliance with the Licence.
 *
 * You may obtain a copy of the Licence at:
 * https://joinup.ec.europa.eu/software/page/eupl
 * It is also bundled with this package in the file LICENSE.txt
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the Licence is distributed on an AS IS basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the Licence for the specific language governing permissions
 * and limitations under the Licence.
 *
 * @author    DPD Polska Sp. z o.o.
 * @copyright 2024 DPD Polska Sp. z o.o.
 * @license   https://joinup.ec.europa.eu/software/page/eupl
 */

namespace DpdShipping\Domain\Order\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\GeneratePackagesNumbersV9;
use DpdShipping\Api\DpdServices\Type\OpenUMLFeV11;
use DpdShipping\Api\DpdServices\Type\PackageAddressOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\PackageOpenUMLFeV11;
use DpdShipping\Api\DpdServices\Type\ParcelOpenUMLFeV3;
use DpdShipping\Api\DpdServices\Type\ServiceCODOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceCUDOpenUMLeFV1;
use DpdShipping\Api\DpdServices\Type\ServiceDeclaredValueOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceDPDFoodOpenUMLFeV2;
use DpdShipping\Api\DpdServices\Type\ServiceDPDLqOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceDpdPickupOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceDutyOpenUMLeFV2;
use DpdShipping\Api\DpdServices\Type\ServiceFlagOpenUMLF;
use DpdShipping\Api\DpdServices\Type\ServiceGuaranteeOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceInPersOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServicePalletOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServicePrivPersOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceRODOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceSelfColOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServicesOpenUMLFeV11;
use DpdShipping\Api\DpdServices\Type\ServiceTiresExportOpenUMLFeV1;
use DpdShipping\Api\DpdServices\Type\ServiceTiresOpenUMLFeV1;
use DpdShipping\Domain\Order\Query\GetCountryIsoCode;
use Exception;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use Psr\Log\LoggerInterface;
use TypeError;

class AddDpdOrderCommandHandler
{
    private $logger;
    /**
     * @var DpdApiService
     */
    private $dpdApiService;
    /**
     * @var CommandBusInterface
     */
    private $commandBus;
    private $translator;

    public function __construct(DpdApiService $dpdApiService, CommandBusInterface $commandBus, $translator)
    {
        $this->dpdApiService = $dpdApiService;
        $this->commandBus = $commandBus;
        $this->translator = $translator;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(AddDpdOrderCommand $command): array
    {
        try {
            $request = $command->getRequestData();
            $errors = $this->validateConfiguration($request);

            if (!empty($errors)) {
                return [
                    'status' => 'ERROR',
                    'errors' => $errors,
                ];
            }

            $shipping = $this->mapShippingApi($request);

            $response = $this->dpdApiService
                ->getServicesClient()
                ->generatePackagesNumbersV9($shipping);

            $result = [];

            if ($response->return->Status == 'OK') {
                $packages = $response->return->Packages;
                $packageIndex = 0;

                if (is_array($packages)) {
                    foreach ($packages as $index => $package) {
                        $result = $this->saveShipping($package->Package, $command, $shipping, $packageIndex, $request, $result);
                        $packageIndex = $packageIndex + 1;
                    }
                } else {
                    $result = $this->saveShipping($packages->Package, $command, $shipping, $packageIndex, $request, $result);
                }

                return $result;
            }

            return [
                'status' => 'ERROR',
                'errors' => $this->getErrorMessages($response->return),
            ];
        } catch (TypeError $e) {
            $this->logger->error('DPDSHIPPING: Cannot generate shipping - invalid type: ' . $e->getMessage());

            return [
                'status' => 'ERROR',
                'errors' => [$e->getMessage()],
            ];
        } catch (Exception $e) {
            $this->logger->error('DPDSHIPPING: Cannot generate shipping: ' . $e->getMessage());

            return [
                'status' => 'ERROR',
                'errors' => [$e->getMessage()],
            ];
        }
    }

    public function validateConfiguration(array $request): array
    {
        $errors = [];
        if (empty($request['packages'])) {
            $errors[] = $this->translator->trans('Please add packages', [], 'Modules.Dpdshipping.Admin');
        }
        foreach ($request['packages'] as $parcel) {
            if (!isset($parcel['weight']) || $parcel['weight'] <= 0) {
                $errors[] = $this->translator->trans('The package weight must be greater than 0.', [], 'Modules.Dpdshipping.Admin');
            }
        }

        if (empty($request['sender_address_company']) && empty($request['sender_address_name'])) {
            $errors[] = $this->translator->trans('You must specify at least one of the fields: Sender company, Sender name.', [], 'Modules.Dpdshipping.Admin');
        }

        if (empty($request['receiver_address_company']) && empty($request['receiver_address_name'])) {
            $errors[] = $this->translator->trans('You must specify at least one of the fields: Receiver company, Receiver name.', [], 'Modules.Dpdshipping.Admin');
        }

        return $errors;
    }

    private function mapShippingApi($request): GeneratePackagesNumbersV9
    {
        $package = new PackageOpenUMLFeV11();
        $package = $package
            ->withSender($this->getSender($request))
            ->withReceiver($this->getReceiver($request))
            ->withParcels($this->getParcels($request))
            ->withRef1($request['ref1'])
            ->withRef2($request['ref2'])
            ->withRef3('PSMODUL#')
            ->withPayerType('THIRD_PARTY')
            ->withThirdPartyFID($request['payer_number'])
            ->withReference(null)
            ->withServices($this->getServices($request));

        $openUMLFeV11 = (new OpenUMLFeV11())
            ->withPackages([$package]);

        return new GeneratePackagesNumbersV9($openUMLFeV11, 'STOP_ON_FIRST_ERROR', 'PL', $this->dpdApiService->getAuth());
    }

    private function getSender($request): PackageAddressOpenUMLFeV1
    {
        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($request['sender_address_country'] ?? ''));
        return (new PackageAddressOpenUMLFeV1())
            ->withCompany($request['sender_address_company'] ?? '')
            ->withName($request['sender_address_name'] ?? '')
            ->withAddress($request['sender_address_street'] ?? '')
            ->withPostalCode(str_replace('-', '', $request['sender_address_postcode'] ?? ''))
            ->withCountryCode($countryIsoCode)
            ->withCity($request['sender_address_city'] ?? '')
            ->withPhone($request['sender_address_phone'] ?? '')
            ->withEmail($request['sender_address_email'] ?? '');
    }

    private function getReceiver($request): PackageAddressOpenUMLFeV1
    {
        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($request['receiver_address_country'] ?? ''));

        return (new PackageAddressOpenUMLFeV1())
            ->withCompany($request['receiver_address_company'] ?? '')
            ->withName($request['receiver_address_name'] ?? '')
            ->withAddress($request['receiver_address_street'] ?? '')
            ->withPostalCode(str_replace('-', '', $request['receiver_address_postcode'] ?? ''))
            ->withCountryCode($countryIsoCode)
            ->withCity($request['receiver_address_city'] ?? '')
            ->withPhone($request['receiver_address_phone'] ?? '')
            ->withEmail($request['receiver_address_email'] ?? '');
    }

    private function getParcels($request): array
    {
        $result = [];
        foreach ($request['packages'] as $parcel) {
            $result[] = (new ParcelOpenUMLFeV3())
                ->withWeight((string)($parcel['weight'] ?? '1'))
                ->withWeightAdr((string)($parcel['weightAdr'] ?? ''))
                ->withContent((string)($parcel['content']))
                ->withCustomerData1((string)($parcel['customerData']))
                ->withSizeX((string)($parcel['sizeX']))
                ->withSizeY((string)($parcel['sizeY']))
                ->withSizeZ((string)($parcel['sizeZ']));
        }

        return $result;
    }

    private function getServices($request): ServicesOpenUMLFeV11
    {
        $services = new ServicesOpenUMLFeV11();

        if (isset($request['service_cod']) && $request['service_cod'] == 1) {
            $cod = (new ServiceCODOpenUMLFeV1())
                ->withAmount((string)($request['service_cod_value']))
                ->withCurrency($request['service_cod_currency']);

            $services = $services->withCod($cod);
        }

        if (isset($request['service_guarantee']) && $request['service_guarantee'] == 1) {
            $guarantee = (new ServiceGuaranteeOpenUMLFeV1())
                ->withType($request['service_guarantee_type'])
                ->withValue($request['service_guarantee_value']);

            $services = $services->withGuarantee($guarantee);
        }

        if (isset($request['service_in_pers']) && $request['service_in_pers'] == 1) {
            $services = $services->withInPers(new ServiceInPersOpenUMLFeV1());
        }

        if (isset($request['service_priv_pers']) && $request['service_priv_pers'] == 1) {
            $services = $services->withPrivPers(new ServicePrivPersOpenUMLFeV1());
        }
        if (isset($request['service_self_con']) && $request['service_self_con'] == 1) {
            $services = $services->withSelfCol((new ServiceSelfColOpenUMLFeV1())->withReceiver($request['service_self_con_value']));
        }

        if (isset($request['service_dpd_pickup']) && $request['service_dpd_pickup'] == 1) {
            $services = $services->withDpdPickup((new ServiceDpdPickupOpenUMLFeV1())->withPudo($request['service_dpd_pickup_value']));
        }

        if (isset($request['service_rod']) && $request['service_rod'] == 1) {
            $services = $services->withRod(new ServiceRODOpenUMLFeV1());
        }

        if (isset($request['service_dox']) && $request['service_dox'] == 1) {
            $services = $services->withDox(new ServicePalletOpenUMLFeV1());
        }

        if (isset($request['service_cud']) && $request['service_cud'] == 1) {
            $services = $services->withCud(new ServiceCUDOpenUMLeFV1());
        }

        if (isset($request['service_tires']) && $request['service_tires'] == 1) {
            if ($request['receiver_address_country'] == 'PL') {
                $services = $services->withTires(new ServiceTiresOpenUMLFeV1());
            } else {
                $services = $services->withTiresExport(new ServiceTiresExportOpenUMLFeV1());
            }
        }

        if (isset($request['service_declared_value']) && $request['service_declared_value'] == 1) {
            $declaredValue = (new ServiceDeclaredValueOpenUMLFeV1())
                ->withAmount((string)($request['service_declared_value_value']))
                ->withCurrency($request['service_declared_value_currency']);

            $services = $services->withDeclaredValue($declaredValue);
        }

        if (isset($request['service_dpd_express']) && $request['service_dpd_express'] == 1) {
            $services = $services->withDpdExpress(new ServiceFlagOpenUMLF());
        }

        if (isset($request['service_dpd_food']) && $request['service_dpd_food'] == 1) {
            $date = $request['service_dpd_food_value'];
            $services = $services->withDpdFood((new ServiceDPDFoodOpenUMLFeV2())->withLimitDate($date->format('Y-m-d')));
        }
        if (isset($request['service_duty']) && $request['service_duty'] == 1) {
            $services = $services->withDuty((new ServiceDutyOpenUMLeFV2())
                ->withCurrency($request['service_duty_currency'])
                ->withAmount((string)($request['service_duty_value'])));
        }

        if (isset($request['service_adr']) && $request['service_adr'] == 1) {
            $services = $services->withDpdLQ(new ServiceDPDLqOpenUMLFeV1());
        }

        return $services;
    }

    public function getErrorMessages($response): array
    {
        $errorMessages = [];

        if (!isset($response->Packages)) {
            if (isset($response->Status)) {
                return [$response->Status];
            }
            return [];
        }


        foreach ($response->Packages as $package) {
            if ($package->Status !== 'OK' && isset($package->ValidationDetails)) {
                if (is_array($package->ValidationDetails->ValidationInfo)) {
                    foreach ($package->ValidationDetails->ValidationInfo as $validationInfo) {
                        $errorMessages[] = $validationInfo->Info;
                    }
                } else {
                    $errorMessages[] = $package->ValidationDetails->ValidationInfo->Info;
                }
            }

            if (isset($package->Parcels->Parcel)) {
                foreach ($package->Parcels as $parcel) {
                    if ($parcel->Status !== 'OK' && isset($parcel->ValidationDetails->ValidationInfo)) {
                        if (is_array($parcel->ValidationDetails->ValidationInfo)) {
                            foreach ($parcel->ValidationDetails->ValidationInfo as $validationInfo) {
                                $errorMessages[] = $validationInfo->Info;
                            }
                        } else {
                            $errorMessages[] = $parcel->ValidationDetails->ValidationInfo->Info;
                        }
                    }
                }
            }
        }

        return $errorMessages;
    }

    /**
     * @param AddDpdOrderCommand $command
     * @param $package
     * @param GeneratePackagesNumbersV9 $shipping
     * @param $mainWaybill
     * @return void
     */
    private function callActionsAfterShipment(AddDpdOrderCommand $command, $package, GeneratePackagesNumbersV9 $shipping, $mainWaybill): void
    {
        try {
            $this->commandBus->handle(new AfterShipmentCommand($command->getIdOrder(), $package, $shipping, $command->getDpdCarrier(), $mainWaybill));
        } catch (Exception $e) {
            $this->logger->error('DPDSHIPPING: Cannot do actions after generate shipment: ' . $e->getMessage());
        }
    }

    private function getReturnLabel($request)
    {
        if (isset($request['service_return_label']) && $request['service_return_label'] == 1) {
            return [
                'company' => $request['service_return_label_address_company'],
                'name' => $request['service_return_label_address_name'],
                'street' => $request['service_return_label_address_street'],
                'postalCode' => $request['service_return_label_address_postcode'],
                'countryCode' => $request['service_return_label_address_country'],
                'city' => $request['service_return_label_address_city'],
                'phone' => $request['service_return_label_address_phone'],
                'email' => $request['service_return_label_address_email'],
            ];
        }

        return null;
    }

    /**
     * @param $package
     * @param AddDpdOrderCommand $command
     * @param $shipping
     * @param $packageIndex
     * @param $request
     * @param array $result
     * @return array
     */
    public function saveShipping($package, AddDpdOrderCommand $command, $shipping, $packageIndex, $request, array $result): array
    {
        if (is_array($package->Parcels->Parcel)) {
            $mainWaybill = $package->Parcels->Parcel[0]->Waybill;
        } else {
            $mainWaybill = $package->Parcels->Parcel->Waybill;
        }

        $result[] = $this->commandBus->handle(new AddShippingHistoryCommand($command->getIdOrder(), $package, $shipping, $packageIndex, $command->getDpdCarrier(), $mainWaybill, $this->getReturnLabel($request)));
        $this->callActionsAfterShipment($command, $package, $shipping, $mainWaybill);

        return $result;
    }
}
