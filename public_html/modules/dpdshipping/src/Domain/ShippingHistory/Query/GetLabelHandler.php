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

namespace DpdShipping\Domain\ShippingHistory\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTime;
use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\DpdServicesParamsV1;
use DpdShipping\Api\DpdServices\Type\GenerateSpedLabelsV4;
use DpdShipping\Api\DpdServices\Type\PackageDSPV1;
use DpdShipping\Api\DpdServices\Type\ParcelDSPV1;
use DpdShipping\Api\DpdServices\Type\PickupAddressDSPV1;
use DpdShipping\Api\DpdServices\Type\SessionDSPV1;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Order\Query\GetCountryIsoCode;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;
use Exception;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use Psr\Log\LoggerInterface;

class GetLabelHandler
{
    private $dpdApiService;
    /**
     * @var DpdshippingShippingHistoryRepository
     */
    private $dpdshippingShippingHistoryRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    public function __construct(
        DpdApiService $dpdApiService,
        DpdshippingShippingHistoryRepository $dpdshippingShippingHistoryRepository,
        CommandBusInterface $commandBus
    ) {
        $this->dpdApiService = $dpdApiService;
        $this->dpdshippingShippingHistoryRepository = $dpdshippingShippingHistoryRepository;
        $this->commandBus = $commandBus;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(GetLabel $query)
    {
        if (empty($query->getIds())) {
            return [];
        }

        $result = [];
        $shippingHistoryGroupedByDeliveryZone = $this->dpdshippingShippingHistoryRepository
            ->getShippingHistoryByIdsGroupByDeliveryZone($query->getIds());

        $printFormat = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PRINT_FORMAT));
        $outputDocPageFormatV1 = $printFormat ? $printFormat->getValue() : 'A4';

        $labelTypeParam = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_LABEL_TYPE));
        $labelType = $labelTypeParam ? $labelTypeParam->getValue() : 'BIC3';

        foreach ($shippingHistoryGroupedByDeliveryZone as $sessionType => $shippingHistoryList) {
            try {
                if (empty($shippingHistoryList)) {
                    continue;
                }

                $sender = $shippingHistoryList[0]->getSender();
                $waybills = $this->getWaybills($shippingHistoryList);
                $parcels = $this->getParcels($waybills);

                $dpdServicesParamsV1 = $this->getDpdServicesParamsV1($sessionType, $parcels, $sender);

                $outputLabelType = $labelType == 'BIC3' ? 'BIC3' : 'EXTENDED';
                $labelVariant = $labelType == 'BIC3' ? '' : $labelType;

                $generateSpedLabelsV4 = new GenerateSpedLabelsV4($dpdServicesParamsV1, 'PDF', $outputDocPageFormatV1, $outputLabelType, $labelVariant, $this->dpdApiService->getAuth());

                $call = $this->dpdApiService
                    ->getServicesClient()
                    ->generateSpedLabelsV4($generateSpedLabelsV4);

                if ($call->return->session->statusInfo->status == 'OK') {
                    $result[] = $call->return;
                    $this->dpdshippingShippingHistoryRepository->setLabelDate($waybills, new DateTime());
                }
            } catch (Exception $ex) {
                $this->logger->error('DPDSHIPPING: Cannot generate label ' . $ex->getMessage());
            }
        }

        return $result;
    }

    /**
     * @param $sessionType
     * @param array $parcels
     * @param $sender
     * @return DpdServicesParamsV1
     */
    public function getDpdServicesParamsV1($sessionType, array $parcels, $sender): DpdServicesParamsV1
    {
        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($sender->getCountryCode()));

        return (new DpdServicesParamsV1())
            ->withSession(
                (new SessionDSPV1())
                ->withSessionType($sessionType)
                ->withPackages((new PackageDSPV1())->withParcels($parcels))
            )
            ->withPickupAddress(
                (new PickupAddressDSPV1())
                ->withCompany($sender->getCompany())
                ->withName($sender->getName())
                ->withAddress($sender->getStreet())
                ->withPostalCode($sender->getPostalCode())
                ->withCity($sender->getCity())
                ->withPhone($sender->getPhone())
                ->withEmail($sender->getEmail())
                ->withCountryCode($countryIsoCode)
            )
            ->withPolicy('IGNORE_ERRORS');
    }

    /**
     * @param array $waybills
     * @return array
     */
    public function getParcels(array $waybills): array
    {
        $parcels = [];
        foreach ($waybills as $waybill) {
            $parcels[] = (new ParcelDSPV1())->withWaybill($waybill);
        }

        return $parcels;
    }

    /**
     * @param $shippingHistoryList
     * @return array
     */
    public function getWaybills($shippingHistoryList): array
    {
        $waybills = [];
        foreach ($shippingHistoryList as $shippingHistory) {
            foreach ($shippingHistory->getParcels() as $parcel) {
                $waybills[] = $parcel->getWaybill();
            }
        }

        return $waybills;
    }
}
