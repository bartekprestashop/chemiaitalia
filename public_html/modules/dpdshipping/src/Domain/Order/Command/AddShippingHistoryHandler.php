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

use Context;
use DateTime;
use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\ServicesOpenUMLFeV11;
use DpdShipping\Entity\DpdshippingShippingHistory;
use DpdShipping\Entity\DpdshippingShippingHistoryParcel;
use DpdShipping\Entity\DpdshippingShippingHistoryReceiver;
use DpdShipping\Entity\DpdshippingShippingHistorySender;
use DpdShipping\Entity\DpdshippingShippingHistoryServices;
use DpdShipping\Repository\DpdshippingShippingHistoryParcelRepository;
use DpdShipping\Repository\DpdshippingShippingHistoryReceiverRepository;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;
use DpdShipping\Repository\DpdshippingShippingHistorySenderRepository;
use DpdShipping\Repository\DpdshippingShippingHistoryServicesRepository;
use Order;
use OrderCarrier;
use PrestaShopDatabaseException;
use PrestaShopException;
use Psr\Log\LoggerInterface;

class AddShippingHistoryHandler
{
    private $logger;
    /**
     * @var DpdApiService
     */
    private $dpdshippingShippingHistoryRepository;
    /**
     * @var DpdshippingShippingHistorySenderRepository
     */
    private $dpdshippingShippingHistorySenderRepository;
    /**
     * @var DpdshippingShippingHistoryReceiverRepository
     */
    private $dpdshippingShippingHistoryReceiverRepository;
    /**
     * @var DpdshippingShippingHistoryParcelRepository
     */
    private $dpdshippingShippingHistoryParcelRepository;
    /**
     * @var DpdshippingShippingHistoryServicesRepository
     */
    private $dpdshippingShippingHistoryServicesRepository;

    public function __construct(
        DpdshippingShippingHistoryRepository $dpdshippingShippingHistoryRepository,
        DpdshippingShippingHistorySenderRepository $dpdshippingShippingHistorySenderRepository,
        DpdshippingShippingHistoryReceiverRepository $dpdshippingShippingHistoryReceiverRepository,
        DpdshippingShippingHistoryParcelRepository $dpdshippingShippingHistoryParcelRepository,
        DpdshippingShippingHistoryServicesRepository $dpdshippingShippingHistoryServicesRepository
    ) {
        $this->dpdshippingShippingHistoryRepository = $dpdshippingShippingHistoryRepository;
        $this->dpdshippingShippingHistorySenderRepository = $dpdshippingShippingHistorySenderRepository;
        $this->dpdshippingShippingHistoryReceiverRepository = $dpdshippingShippingHistoryReceiverRepository;
        $this->dpdshippingShippingHistoryParcelRepository = $dpdshippingShippingHistoryParcelRepository;
        $this->dpdshippingShippingHistoryServicesRepository = $dpdshippingShippingHistoryServicesRepository;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(AddShippingHistoryCommand $command)
    {
        $currentShipping = $command->getShipping()->getOpenUMLFeV11()->getPackages()[$command->getPackageIndex()];

        if ($currentShipping == null) {
            return false;
        }

        $shippingSender = $this->setShippingHistorySender($currentShipping);
        $shippingReceiver = $this->setShippingHistoryReceiver($currentShipping);
        $shippingServices = $this->setShippingHistoryServices($currentShipping->getServices(), $command->getReturnLabel());

        $shippingHistory = $this->setShippingHistory($command, $shippingSender, $shippingReceiver, $shippingServices, $currentShipping);

        $this->setOrderShippingNumber($command);

        return $this->setShippingHistoryParcels($currentShipping, $shippingHistory, $command);
    }

    /**
     * @param $currentShipping
     * @return DpdshippingShippingHistorySender|null
     */
    public function setShippingHistorySender($currentShipping): ?DpdshippingShippingHistorySender
    {
        $sender = $currentShipping->getSender();

        $shippingSenderEntity = new DpdshippingShippingHistorySender();
        $shippingSenderEntity = $shippingSenderEntity
            ->setCompany($sender->getCompany())
            ->setName($sender->getName())
            ->setStreet($sender->getAddress())
            ->setCity($sender->getCity())
            ->setPostalCode($sender->getPostalCode())
            ->setCountryCode($sender->getCountryCode())
            ->setEmail($sender->getEmail())
            ->setPhone($sender->getPhone());

        return $this->dpdshippingShippingHistorySenderRepository->save($shippingSenderEntity);
    }

    /**
     * @param $currentShipping
     * @return array
     */
    public function setShippingHistoryReceiver($currentShipping): ?DpdshippingShippingHistoryReceiver
    {
        $receiver = $currentShipping->getReceiver();
        $shippingReceiverEntity = new DpdshippingShippingHistoryReceiver();
        $shippingReceiverEntity = $shippingReceiverEntity
            ->setCompany($receiver->getCompany())
            ->setName($receiver->getName())
            ->setStreet($receiver->getAddress())
            ->setCity($receiver->getCity())
            ->setPostalCode($receiver->getPostalCode())
            ->setCountryCode($receiver->getCountryCode())
            ->setEmail($receiver->getEmail())
            ->setPhone($receiver->getPhone());

        return $this->dpdshippingShippingHistoryReceiverRepository->save($shippingReceiverEntity);
    }

    /**
     * @param ServicesOpenUMLFeV11 $currentShippingServices
     * @return DpdshippingShippingHistoryServices|null
     */
    public function setShippingHistoryServices($currentShippingServices, $returnLabel): ?DpdshippingShippingHistoryServices
    {
        $shippingServicesEntity = new DpdshippingShippingHistoryServices();

        $shippingServicesEntity->setIsCod($currentShippingServices->getCod() != null);
        if ($currentShippingServices->getCod() != null) {
            $shippingServicesEntity->setIsCod(true);
            $shippingServicesEntity->setCodCurrency($currentShippingServices->getCod()->getCurrency());
            $shippingServicesEntity->setCodAmount($currentShippingServices->getCod()->getAmount());
        }

        $shippingServicesEntity->setIsDpdPickup($currentShippingServices->getDpdPickup() != null);
        if ($currentShippingServices->getDpdPickup() != null) {
            $shippingServicesEntity->setIsDpdPickup(true);
            $shippingServicesEntity->setDpdPickupPudo($currentShippingServices->getDpdPickup()->getPudo());
        }

        $shippingServicesEntity->setIsAdr($currentShippingServices->getDpdLQ() != null);
        $shippingServicesEntity->setIsCarryIn($currentShippingServices->getCarryIn() != null);
        $shippingServicesEntity->setIsCud($currentShippingServices->getCud() != null);
        $shippingServicesEntity->setIsDox($currentShippingServices->getDox() != null);
        $shippingServicesEntity->setIsDeclaredValue($currentShippingServices->getDeclaredValue() != null);
        if ($currentShippingServices->getDeclaredValue() != null) {
            $shippingServicesEntity->setDeclaredValueCurrency($currentShippingServices->getCod()->getCurrency());
            $shippingServicesEntity->setDeclaredValueAmount($currentShippingServices->getCod()->getAmount());
        }

        $shippingServicesEntity->setIsDocumentsInternational($currentShippingServices->getDocumentsInternational() != null);
        $shippingServicesEntity->setIsDpdFood($currentShippingServices->getDpdFood() != null);
        $shippingServicesEntity->setIsDpdExpress($currentShippingServices->getDpdExpress() != null);
        $shippingServicesEntity->setIsDedicatedDelivery($currentShippingServices->getDedicatedDelivery() != null);
        $shippingServicesEntity->setIsPallet($currentShippingServices->getPallet() != null);
        $shippingServicesEntity->setIsPrivPers($currentShippingServices->getPrivPers() != null);
        $shippingServicesEntity->setIsInPers($currentShippingServices->getInPers() != null);
        $shippingServicesEntity->setIsGuarantee($currentShippingServices->getGuarantee() != null);

        if ($currentShippingServices->getGuarantee() != null) {
            $shippingServicesEntity->setGuaranteeType($currentShippingServices->getGuarantee()->getType());
            $shippingServicesEntity->setGuaranteeValue($currentShippingServices->getGuarantee()->getValue());
        }

        $shippingServicesEntity->setIsTires($currentShippingServices->getTires() != null || $currentShippingServices->getTiresExport() != null);

        $shippingServicesEntity->setIsDuty($currentShippingServices->getDuty() != null);
        if ($currentShippingServices->getDuty() != null) {
            $shippingServicesEntity->setDutyAmount($currentShippingServices->getDuty()->getAmount());
            $shippingServicesEntity->setDutyCurrency($currentShippingServices->getDuty()->getCurrency());
        }

        $shippingServicesEntity->setIsRod($currentShippingServices->getRod() != null);

        $shippingServicesEntity->setIsSelfCon($currentShippingServices->getSelfCol() != null);
        if ($currentShippingServices->getSelfCol() != null) {
            $shippingServicesEntity->setSelfConType($currentShippingServices->getSelfCol()->getReceiver());
        }

        $shippingServicesEntity->setIsReturnLabel($returnLabel != null);
        if ($returnLabel != null) {
            $shippingServicesEntity->setReturnLabelCompany($returnLabel['company']);
            $shippingServicesEntity->setReturnLabelName($returnLabel['name']);
            $shippingServicesEntity->setReturnLabelStreet($returnLabel['street']);
            $shippingServicesEntity->setReturnLabelPostalCode($returnLabel['postalCode']);
            $shippingServicesEntity->setReturnLabelCountryCode($returnLabel['countryCode']);
            $shippingServicesEntity->setReturnLabelCity($returnLabel['city']);
            $shippingServicesEntity->setReturnLabelPhone($returnLabel['phone']);
            $shippingServicesEntity->setReturnLabelEmail($returnLabel['email']);
        }

        return $this->dpdshippingShippingHistoryServicesRepository->save($shippingServicesEntity);
    }

    /**
     * @param $currentShipping
     * @param DpdshippingShippingHistory|null $shippingHistory
     * @param AddShippingHistoryCommand $command
     * @return array
     */
    public function setShippingHistoryParcels($currentShipping, ?DpdshippingShippingHistory $shippingHistory, AddShippingHistoryCommand $command): array
    {
        $waybills = [];
        $result = [];

        $parcels = $currentShipping->getParcels();

        foreach ($parcels as $index => $parcel) {
            $shippingParcelEntity = new DpdshippingShippingHistoryParcel();
            $shippingParcelEntity->setParcelIndex($index);
            $shippingParcelEntity->setWeight((float) number_format((float) $parcel->getWeight(), 2));
            $shippingParcelEntity->setShippingHistory($shippingHistory);
            $shippingParcelEntity->setContent($parcel->getContent());
            $shippingParcelEntity->setCustomerData($parcel->getCustomerData1());
            $shippingParcelEntity->setSizeX((float) $parcel->getSizeX());
            $shippingParcelEntity->setSizeY((float) $parcel->getSizeY());
            $shippingParcelEntity->setSizeZ((float) $parcel->getSizeZ());
            $shippingParcelEntity->setWeightAdr((float) $parcel->getWeightAdr());
            $shippingParcelEntity->setIsMainWaybill($index == 0);

            if (is_array($command->getDpdResponsePackage()->Parcels->Parcel)) {
                $waybill = $command->getDpdResponsePackage()->Parcels->Parcel[$index]->Waybill;
            } else {
                $waybill = $command->getDpdResponsePackage()->Parcels->Parcel->Waybill;
            }

            $shippingParcelEntity->setWaybill($waybill);

            $this->dpdshippingShippingHistoryParcelRepository->save($shippingParcelEntity);
            $waybills[] = $waybill;
        }

        $result[] = $shippingHistory;

        return ['shippingHistoryList' => $result, 'waybills' => $waybills];
    }

    /**
     * @param AddShippingHistoryCommand $command
     * @param DpdshippingShippingHistorySender|null $shippingSender
     * @param $shippingReceiver
     * @param DpdshippingShippingHistoryServices|null $shippingServices
     * @param $currentShipping
     * @return DpdshippingShippingHistory|null
     */
    public function setShippingHistory(AddShippingHistoryCommand $command, ?DpdshippingShippingHistorySender $shippingSender, $shippingReceiver, ?DpdshippingShippingHistoryServices $shippingServices, $currentShipping): ?DpdshippingShippingHistory
    {
        $shippingHistoryEntity = new DpdshippingShippingHistory();
        $shippingHistoryEntity->setIdOrder($command->getIdOrder());
        $shippingHistoryEntity->setIdShop((int) Context::getContext()->shop->id);
        $shippingHistoryEntity->setSender($shippingSender);
        $shippingHistoryEntity->setReceiver($shippingReceiver);
        $shippingHistoryEntity->setServices($shippingServices);
        $shippingHistoryEntity->setFid($currentShipping->getThirdPartyFID());
        $shippingHistoryEntity->setRef1($currentShipping->getRef1());
        $shippingHistoryEntity->setRef2($currentShipping->getRef2());
        $shippingHistoryEntity->setPayerType($currentShipping->getPayerType());
        $shippingHistoryEntity->setIsDeleted(false);
        $shippingHistoryEntity->setIsDelivered(false);
        $shippingHistoryEntity->setShippingDate(new DateTime());

        $dpdCarrier = $command->getDpdCarrier();
        $dpdCarrierType = isset($dpdCarrier['dpd_carrier']) ? $dpdCarrier['dpd_carrier']->getType() : 'OTHER';
        $shippingHistoryEntity->setCarrierName($dpdCarrierType);
        $shippingHistoryEntity->setDeliveryZone($currentShipping->getReceiver()->getCountryCode() == 'PL' ? 'DOMESTIC' : 'INTERNATIONAL');
        $shippingHistoryEntity->setDateAdd(new DateTime());
        $shippingHistoryEntity->setDateModify(new DateTime());

        return $this->dpdshippingShippingHistoryRepository->save($shippingHistoryEntity);
    }

    /**
     * @param AddShippingHistoryCommand $command
     * @return void
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function setOrderShippingNumber(AddShippingHistoryCommand $command): void
    {
        $order = new Order((int) $command->getIdOrder());
        $order_carrier = new OrderCarrier($order->getIdOrderCarrier());
        $order_carrier->tracking_number = $command->getMainWaybill();
        $order_carrier->update();
    }
}
