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

namespace DpdShipping\Entity;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\ORM\Mapping as ORM;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingShippingHistoryRepository::class)
 */
class DpdshippingShippingHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idOrder;

    /**
     * @ORM\Column(type="integer")
     */
    private $idShop;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="DpdshippingShippingHistorySender")
     * @ORM\JoinColumn(name="shipping_history_sender_id", referencedColumnName="id", nullable=true)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity="DpdshippingShippingHistoryReceiver")
     * @ORM\JoinColumn(name="shipping_history_receiver_id", referencedColumnName="id", nullable=true)
     */
    private $receiver;

    /**
     * @ORM\ManyToOne(targetEntity="DpdshippingShippingHistoryServices")
     * @ORM\JoinColumn(name="shipping_history_services_id", referencedColumnName="id", nullable=true)
     */
    private $services;

    /**
     * @ORM\OneToMany(targetEntity="DpdshippingShippingHistoryParcel", mappedBy="shippingHistory")
     */
    private $parcels;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $shippingDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $carrierName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $labelDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $protocolNumber;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $protocolDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryZone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $fid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $payerType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ref2;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDeleted;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastStatus;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $returnLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelWaybill;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDelivered;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateModify;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver): void
    {
        $this->receiver = $receiver;
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services): void
    {
        $this->services = $services;
    }

    /**
     * @return mixed
     */
    public function getShippingDate()
    {
        return $this->shippingDate;
    }

    /**
     * @param mixed $shippingDate
     */
    public function setShippingDate($shippingDate): void
    {
        $this->shippingDate = $shippingDate;
    }

    /**
     * @return mixed
     */
    public function getLabelDate()
    {
        return $this->labelDate;
    }

    /**
     * @param mixed $labelDate
     */
    public function setLabelDate($labelDate): void
    {
        $this->labelDate = $labelDate;
    }

    /**
     * @return mixed
     */
    public function getProtocolNumber()
    {
        return $this->protocolNumber;
    }

    /**
     * @param mixed $protocolNumber
     */
    public function setProtocolNumber($protocolNumber): void
    {
        $this->protocolNumber = $protocolNumber;
    }

    /**
     * @return mixed
     */
    public function getProtocolDate()
    {
        return $this->protocolDate;
    }

    /**
     * @param mixed $protocolDate
     */
    public function setProtocolDate($protocolDate): void
    {
        $this->protocolDate = $protocolDate;
    }

    /**
     * @return mixed
     */
    public function getDeliveryZone()
    {
        return $this->deliveryZone;
    }

    /**
     * @param mixed $deliveryZone
     */
    public function setDeliveryZone($deliveryZone): void
    {
        $this->deliveryZone = $deliveryZone;
    }

    /**
     * @return mixed
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * @param mixed $fid
     */
    public function setFid($fid): void
    {
        $this->fid = $fid;
    }

    /**
     * @return mixed
     */
    public function getPayerType()
    {
        return $this->payerType;
    }

    /**
     * @param mixed $payerType
     */
    public function setPayerType($payerType): void
    {
        $this->payerType = $payerType;
    }

    /**
     * @return mixed
     */
    public function getRef1()
    {
        return $this->ref1;
    }

    /**
     * @param mixed $ref1
     */
    public function setRef1($ref1): void
    {
        $this->ref1 = $ref1;
    }

    /**
     * @return mixed
     */
    public function getRef2()
    {
        return $this->ref2;
    }

    /**
     * @param mixed $ref2
     */
    public function setRef2($ref2): void
    {
        $this->ref2 = $ref2;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * @param mixed $isDeleted
     */
    public function setIsDeleted($isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return mixed
     */
    public function getLastStatus()
    {
        return $this->lastStatus;
    }

    /**
     * @param mixed $lastStatus
     */
    public function setLastStatus($lastStatus): void
    {
        $this->lastStatus = $lastStatus;
    }

    /**
     * @return mixed
     */
    public function getReturnLabel()
    {
        return $this->returnLabel;
    }

    /**
     * @param mixed $returnLabel
     */
    public function setReturnLabel($returnLabel): void
    {
        $this->returnLabel = $returnLabel;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelWaybill()
    {
        return $this->returnLabelWaybill;
    }

    /**
     * @param mixed $returnLabelWaybill
     */
    public function setReturnLabelWaybill($returnLabelWaybill): void
    {
        $this->returnLabelWaybill = $returnLabelWaybill;
    }

    /**
     * @return mixed
     */
    public function getIsDelivered()
    {
        return $this->isDelivered;
    }

    /**
     * @param mixed $isDelivered
     */
    public function setIsDelivered($isDelivered): void
    {
        $this->isDelivered = $isDelivered;
    }

    /**
     * @return mixed
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * @param mixed $dateAdd
     */
    public function setDateAdd($dateAdd): void
    {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return mixed
     */
    public function getDateModify()
    {
        return $this->dateModify;
    }

    /**
     * @param mixed $dateModify
     */
    public function setDateModify($dateModify): void
    {
        $this->dateModify = $dateModify;
    }

    /**
     * @return mixed
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * @param mixed $idOrder
     */
    public function setIdOrder($idOrder): void
    {
        $this->idOrder = $idOrder;
    }

    /**
     * @return mixed
     */
    public function getCarrierName()
    {
        return $this->carrierName;
    }

    /**
     * @param mixed $carrierName
     */
    public function setCarrierName($carrierName): void
    {
        $this->carrierName = $carrierName;
    }

    /**
     * @return mixed
     */
    public function getIdShop()
    {
        return $this->idShop;
    }

    /**
     * @param mixed $idShop
     */
    public function setIdShop($idShop): void
    {
        $this->idShop = $idShop;
    }

    /**
     * @return mixed
     */
    public function getParcels()
    {
        return $this->parcels;
    }
}
