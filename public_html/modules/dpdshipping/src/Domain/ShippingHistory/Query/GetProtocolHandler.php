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
use DpdShipping\Api\DpdServices\Type\GenerateProtocolV2;
use DpdShipping\Api\DpdServices\Type\PackageDSPV1;
use DpdShipping\Api\DpdServices\Type\ParcelDSPV1;
use DpdShipping\Api\DpdServices\Type\PickupAddressDSPV1;
use DpdShipping\Api\DpdServices\Type\SessionDSPV1;
use DpdShipping\Domain\Order\Query\GetCountryIsoCode;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;
use Exception;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use Psr\Log\LoggerInterface;

class GetProtocolHandler
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
        DpdApiService                        $dpdApiService,
        DpdshippingShippingHistoryRepository $dpdshippingShippingHistoryRepository,
        CommandBusInterface                  $commandBus
    )
    {
        $this->dpdApiService = $dpdApiService;
        $this->dpdshippingShippingHistoryRepository = $dpdshippingShippingHistoryRepository;
        $this->commandBus = $commandBus;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(GetProtocol $query)
    {
        $status = 'OK';

        $result = [];
        $shippingHistoryGroupedByDeliveryZone = $this->dpdshippingShippingHistoryRepository
            ->getShippingHistoryByIdsGroupByDeliveryZone($query->getIds());

        $groupedHistories = $this->getGroupedBySender($shippingHistoryGroupedByDeliveryZone);

        foreach ($groupedHistories as $sessionType => $groupedBySender) {
            foreach ($groupedBySender as $sender => $shippingHistoryList) {
                try {
                    if (empty($shippingHistoryList)) {
                        continue;
                    }

                    $sender = $shippingHistoryList[0]->getSender();
                    $waybills = $this->getWaybills($shippingHistoryList);
                    $parcels = $this->getParcels($waybills);

                    $dpdServicesParamsV1 = $this->getDpdServicesParamsV1($sessionType, $parcels, $sender);
                    $generateProtocolV2 = new GenerateProtocolV2($dpdServicesParamsV1, 'PDF', 'LBL_PRINTER', $this->dpdApiService->getAuth());

                    $call = $this->dpdApiService
                        ->getServicesClient()
                        ->generateProtocolV2($generateProtocolV2);

                    if ($call->return->session->statusInfo->status == 'OK') {
                        $result[] = $call->return;
                        $this->dpdshippingShippingHistoryRepository->setProtocolDate($waybills, new DateTime());
                    } else {
                        $status = 'SOME_ERROR';
                    }
                } catch (Exception $ex) {
                    $this->logger->error('DPDSHIPPING: Cannot generate label ' . $ex->getMessage());
                    $status = 'SOME_ERROR';
                }
            }
        }

        return ['status' => $status, 'data' => $result];
    }

    /**
     * @param array $shippingHistoryGroupedByDeliveryZone
     * @return array
     */
    public function getGroupedBySender(array $shippingHistoryGroupedByDeliveryZone): array
    {
        $groupedHistories = [];
        foreach ($shippingHistoryGroupedByDeliveryZone as $zone => $histories) {
            foreach ($histories as $entry) {
                $sender = $this->getSenderKey($entry);
                if (!isset($groupedHistories[$zone][$sender])) {
                    $groupedHistories[$zone][$sender] = [];
                }
                $groupedHistories[$zone][$sender][] = $entry;
            }
        }

        return $groupedHistories;
    }

    /**
     * @param $entry
     * @return string
     */
    public function getSenderKey($entry): string
    {
        return
            $entry->getSender()->getCompany() .
            $entry->getSender()->getName() .
            $entry->getSender()->getStreet() .
            $entry->getSender()->getPostalCode() .
            $entry->getSender()->getCountryCode() .
            $entry->getSender()->getCity() .
            $entry->getSender()->getPhone() .
            $entry->getSender()->getEmail();
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
            ->withPolicy('STOP_ON_FIRST_ERROR');
    }
}
