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

namespace DpdShipping\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Context;
use Doctrine\ORM\EntityRepository;
use DpdShipping\Api\DpdServices\Type\DpdPickupCallParamsV3;
use DpdShipping\Entity\DpdshippingPickupCourier;
use Psr\Log\LoggerInterface;

class DpdshippingPickupCourierRepository extends EntityRepository
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function findAll(): array
    {
        return $this->findBy(['idShop' => (int)Context::getContext()->shop->id]);
    }

    public function add($pickupCourier)
    {
        $this->logger->info("DPDSHIPPING: Add courier pickup");

    }

    public function save(DpdPickupCallParamsV3 $dpdPickupCallParams, string $status, string $orderNumber, string $checkSum, string $countryCode)
    {
        $customer = $dpdPickupCallParams->getPickupCallSimplifiedDetails()->getPickupCustomer();
        $payer = $dpdPickupCallParams->getPickupCallSimplifiedDetails()->getPickupPayer();
        $sender = $dpdPickupCallParams->getPickupCallSimplifiedDetails()->getPickupSender();
        $params = $dpdPickupCallParams->getPickupCallSimplifiedDetails()->getPackagesParams();

        $entity = (new DpdshippingPickupCourier())
            ->setStatus($status)
            ->setOrderNumber($orderNumber)
            ->setChecksum($checkSum)
            ->setOperationType($dpdPickupCallParams->getOperationType())
            ->setOrderType($dpdPickupCallParams->getOrderType())
            ->setPickupDate(new \DateTime($dpdPickupCallParams->getPickupDate()))
            ->setPickupTimeFrom($dpdPickupCallParams->getPickupTimeFrom() ?? "")
            ->setPickupTimeTo($dpdPickupCallParams->getPickupTimeTo() ?? "")
            ->setCustomerFullName($customer->getCustomerFullName())
            ->setCustomerName($customer->getCustomerName())
            ->setCustomerPhone($customer->getCustomerPhone())
            ->setPayerNumber($payer->getPayerNumber())
            ->setPayerName($payer->getPayerName())
            ->setSenderAddress($sender->getSenderAddress())
            ->setSenderCity($sender->getSenderCity())
            ->setSenderFullName($sender->getSenderFullName())
            ->setSenderName($sender->getSenderName())
            ->setSenderPhone($sender->getSenderPhone())
            ->setSenderPostalCode($sender->getSenderPostalCode())
            ->setSenderCountryCode($countryCode)
            ->setDox($params->getDox() === true || $params->getDox() == "true" || $params->getDox() == "1")
            ->setDoxCount($params->getDoxCount() ?? 0)
            ->setPallet($params->getPallet() === true || $params->getPallet() == "true" || $params->getPallet() == "1")
            ->setPalletMaxHeight($params->getPalletMaxHeight() ?? 0)
            ->setPalletMaxWeight($params->getPalletMaxWeight() ?? 0)
            ->setPalletsCount($params->getPalletsCount() ?? 0)
            ->setPalletsWeight($params->getPalletsWeight() ?? 0)
            ->setStandardParcel($params->getStandardParcel() === true || $params->getStandardParcel() == "true" || $params->getStandardParcel() == "1")
            ->setParcelMaxDepth($params->getParcelMaxDepth() ?? 0)
            ->setParcelMaxHeight($params->getParcelMaxHeight() ?? 0)
            ->setParcelMaxWeight($params->getParcelMaxWeight() ?? 0)
            ->setParcelMaxWidth($params->getParcelMaxWidth() ?? 0)
            ->setParcelsCount($params->getParcelsCount() ?? 0)
            ->setParcelsWeight($params->getParcelsWeight() ?? 0)
            ->setDateAdd(new \DateTime())
            ->setDateUpd(new \DateTime());

        $this->_em->persist($entity);
        $this->logger->info('DPDSHIPPING: Added courier pickup:' . json_encode($entity));

        $this->_em->flush();

        return true;
    }

    public function saveStatusCancel($pickupCourierEntity)
    {
        $pickupCourierEntity->setStatus("CANCELLED");
        $pickupCourierEntity->setDateUpd(new \DateTime());

        $this->_em->persist($pickupCourierEntity);
        $this->logger->info('DPDSHIPPING: Cancelled courier pickup:' . json_encode($pickupCourierEntity));

        $this->_em->flush();
    }

}
