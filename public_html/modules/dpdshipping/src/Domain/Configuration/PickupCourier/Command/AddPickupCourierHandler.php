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

namespace DpdShipping\Domain\Configuration\PickupCourier\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\DpdPickupCallParamsV3;
use DpdShipping\Api\DpdServices\Type\PackagesPickupCallV4;
use DpdShipping\Api\DpdServices\Type\PickupCallSimplifiedDetailsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupCustomerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPackagesParamsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPayerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupSenderDPPV1;
use DpdShipping\Domain\Order\Query\GetCountryIsoCode;
use DpdShipping\Repository\DpdshippingPickupCourierRepository;
use Exception;
use stdClass;

class AddPickupCourierHandler
{
    /**
     * @var DpdshippingPickupCourierRepository
     */
    private $repository;
    /**
     * @var DpdApiService
     */
    private $dpdApiService;
    /**
     * @var mixed
     */
    private $router;
    private $queryBus;

    public function __construct(DpdshippingPickupCourierRepository $repository, DpdApiService $dpdApiService, $router, $queryBus)
    {
        $this->repository = $repository;
        $this->dpdApiService = $dpdApiService;
        $this->router = $router;
        $this->queryBus = $queryBus;
    }

    /**
     * @throws Exception
     */
    public function handle(AddPickupCourierCommand $query)
    {
        $queryParam = $query->getRequest();

        list($pickupTimeFrom, $pickupTimeTo) = explode('-', $queryParam->get('pickupTime'));
        $countryIsoCode = $this->queryBus->handle(new GetCountryIsoCode($this->getQueryValue($queryParam, 'senderCountryCode', "")));

        $dpdPickupCallParams = (new DpdPickupCallParamsV3())
            ->withOrderNumber($query->getOrderNumber())
            ->withCheckSum($query->getCheckSum())
            ->withOrderType($countryIsoCode == "PL" ? "DOMESTIC" : "INTERNATIONAL")
            ->withOperationType($query->getOperationType())
            ->withPickupDate($this->getQueryValue($queryParam, 'pickupDate'))
            ->withPickupTimeFrom($pickupTimeFrom ?? null)
            ->withPickupTimeTo($pickupTimeTo ?? null)
            ->withWaybillsReady(true)
            ->withPickupCallSimplifiedDetails(
                (new PickupCallSimplifiedDetailsDPPV1())
                    ->withPickupCustomer(
                        (new PickupCustomerDPPV1())
                            ->withCustomerFullName($this->getQueryValue($queryParam, 'customerFullName'))
                            ->withCustomerName($this->getQueryValue($queryParam, 'customerName'))
                            ->withCustomerPhone($this->getQueryValue($queryParam, 'customerPhone'))
                    )
                    ->withPickupPayer(
                        (new PickupPayerDPPV1())
                            ->withPayerCostCenter($this->getQueryValue($queryParam, 'payerCostCenter'))
                            ->withPayerName($this->getQueryValue($queryParam, 'payerName'))
                            ->withPayerNumber($this->getQueryValue($queryParam, 'payerNumber'))
                    )
                    ->withPickupSender(
                        (new PickupSenderDPPV1())
                            ->withSenderAddress($this->getQueryValue($queryParam, 'senderAddress'))
                            ->withSenderName($this->getQueryValue($queryParam, 'senderName'))
                            ->withSenderPhone($this->getQueryValue($queryParam, 'senderPhone'))
                            ->withSenderCity($this->getQueryValue($queryParam, 'senderCity'))
                            ->withSenderFullName($this->getQueryValue($queryParam, 'senderFullName'))
                            ->withSenderPostalCode(str_replace('-', '', $this->getQueryValue($queryParam, 'senderPostalCode') ?? '')))
                    ->withPackagesParams(
                        (new PickupPackagesParamsDPPV1())
                            ->withDox($this->getQueryValue($queryParam, 'letters'))
                            ->withDoxCount($this->getQueryValue($queryParam, 'lettersCount', 0))
                            ->withPallet($this->getQueryValue($queryParam, 'palette'))
                            ->withPalletsCount($this->getQueryValue($queryParam, 'paletteCount', 0))
                            ->withPalletMaxHeight($this->getQueryValue($queryParam, 'paletteSizeYMax'))
                            ->withPalletMaxWeight($this->getQueryValue($queryParam, 'paletteWeightMx'))
                            ->withPalletsWeight($this->getQueryValue($queryParam, 'paletteWeightSum'))
                            ->withStandardParcel($this->getQueryValue($queryParam, 'packages'))
                            ->withParcelsCount($this->getQueryValue($queryParam, 'packagesCount', 0))
                            ->withParcelsWeight($this->getQueryValue($queryParam, 'packagesWeightSum'))
                            ->withParcelMaxDepth($this->getQueryValue($queryParam, 'packagesSizeZMax'))
                            ->withParcelMaxHeight($this->getQueryValue($queryParam, 'packagesSizeYMax'))
                            ->withParcelMaxWidth($this->getQueryValue($queryParam, 'packagesSizeXMax'))
                            ->withParcelMaxWeight($this->getQueryValue($queryParam, 'packagesWeightMax'))
                    ));

        $request = new PackagesPickupCallV4($dpdPickupCallParams, $this->dpdApiService->getAuth());
        $result = $this->dpdApiService->getServicesClient()->packagesPickupCall($request);

        if ($result != null && $result->return != null && $result->return->statusInfo->status == "OK") {
            $this->repository->save($dpdPickupCallParams, $result->return->statusInfo->status, $result->return->orderNumber, $result->return->checkSum, $countryIsoCode);

            $url = $this->router->generate('dpdshipping_pickup_courier_form');
            return ['success' => true, 'data' => array('redirectPath' => $url)];
        } else {
            return ['success' => false, 'errors' => $this->getErrorMessages($result)];
        }
    }

    private function getQueryValue($queryParam, $field, $defaultValue = null)
    {
        $val = $queryParam->get($field);
        if ($val != null && $val != "") {
            return $val;
        }
        return $defaultValue;
    }

    public function getErrorMessages($response): array
    {
        if (!isset($response) || !isset($response->return)) {
            return ['Unknown error'];
        }

        return [$response->return->statusInfo->errorDetails->description];

    }
}
