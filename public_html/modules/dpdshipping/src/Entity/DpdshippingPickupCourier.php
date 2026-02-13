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
use DpdShipping\Repository\DpdshippingPickupCourierRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingPickupCourierRepository::class)
 */
class DpdshippingPickupCourier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $orderNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $checksum;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $operationType;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $orderType;

    /**
     * @ORM\Column(type="datetime")
     */
    private $pickupDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pickupTimeFrom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pickupTimeTo;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $customerFullName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $customerName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $customerPhone;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $payerNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $payerName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $senderAddress;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $senderCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $senderFullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $senderName;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $senderPhone;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $senderPostalCode;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $senderCountryCode;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $dox;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $doxCount;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $pallet;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $palletMaxHeight;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $palletMaxWeight;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $palletsCount;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $palletsWeight;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $standardParcel;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parcelMaxDepth;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parcelMaxHeight;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $parcelMaxWeight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $parcelMaxWidth;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $parcelsCount;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $parcelsWeight;

    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $dateAdd;

    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $dateUpd;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    public function getChecksum(): ?string
    {
        return $this->checksum;
    }

    public function setChecksum(?string $checksum): self
    {
        $this->checksum = $checksum;

        return $this;
    }

    public function getOperationType(): ?string
    {
        return $this->operationType;
    }

    public function setOperationType(string $operationType): self
    {
        $this->operationType = $operationType;

        return $this;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType;
    }

    public function setOrderType(string $orderType): self
    {
        $this->orderType = $orderType;

        return $this;
    }

    public function getPickupDate(): ?\DateTimeInterface
    {
        return $this->pickupDate;
    }

    public function setPickupDate(\DateTimeInterface $pickupDate): self
    {
        $this->pickupDate = $pickupDate;

        return $this;
    }

    public function getPickupTimeFrom(): ?string
    {
        return $this->pickupTimeFrom;
    }

    public function setPickupTimeFrom(string $pickupTimeFrom): self
    {
        $this->pickupTimeFrom = $pickupTimeFrom;

        return $this;
    }

    public function getPickupTimeTo(): ?string
    {
        return $this->pickupTimeTo;
    }

    public function setPickupTimeTo(string $pickupTimeTo): self
    {
        $this->pickupTimeTo = $pickupTimeTo;

        return $this;
    }

    public function getCustomerFullName(): ?string
    {
        return $this->customerFullName;
    }

    public function setCustomerFullName(?string $customerFullName): self
    {
        $this->customerFullName = $customerFullName;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(?string $customerName): self
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getCustomerPhone(): ?string
    {
        return $this->customerPhone;
    }

    public function setCustomerPhone(?string $customerPhone): self
    {
        $this->customerPhone = $customerPhone;

        return $this;
    }

    public function getPayerNumber(): ?int
    {
        return $this->payerNumber;
    }

    public function setPayerNumber(?int $payerNumber): self
    {
        $this->payerNumber = $payerNumber;

        return $this;
    }

    public function getPayerName(): ?string
    {
        return $this->payerName;
    }

    public function setPayerName(?string $payerName): self
    {
        $this->payerName = $payerName;

        return $this;
    }

    public function getSenderAddress(): ?string
    {
        return $this->senderAddress;
    }

    public function setSenderAddress(?string $senderAddress): self
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    public function getSenderCity(): ?string
    {
        return $this->senderCity;
    }

    public function setSenderCity(?string $senderCity): self
    {
        $this->senderCity = $senderCity;

        return $this;
    }

    public function getSenderFullName(): ?string
    {
        return $this->senderFullName;
    }

    public function setSenderFullName(?string $senderFullName): self
    {
        $this->senderFullName = $senderFullName;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(?string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getSenderPhone(): ?string
    {
        return $this->senderPhone;
    }

    public function setSenderPhone(?string $senderPhone): self
    {
        $this->senderPhone = $senderPhone;

        return $this;
    }

    public function getSenderPostalCode(): ?string
    {
        return $this->senderPostalCode;
    }

    public function setSenderPostalCode(?string $senderPostalCode): self
    {
        $this->senderPostalCode = $senderPostalCode;

        return $this;
    }

    public function getSenderCountryCode(): ?string
    {
        return $this->senderCountryCode;
    }

    public function setSenderCountryCode(?string $senderCountryCode): self
    {
        $this->senderCountryCode = $senderCountryCode;

        return $this;
    }

    public function getDox(): ?bool
    {
        return $this->dox;
    }

    public function setDox(bool $dox): self
    {
        $this->dox = $dox;

        return $this;
    }

    public function getDoxCount(): ?int
    {
        return $this->doxCount;
    }

    public function setDoxCount(int $doxCount): self
    {
        $this->doxCount = $doxCount;

        return $this;
    }

    public function getPallet(): ?bool
    {
        return $this->pallet;
    }

    public function setPallet(bool $pallet): self
    {
        $this->pallet = $pallet;

        return $this;
    }

    public function getPalletMaxHeight(): ?string
    {
        return $this->palletMaxHeight;
    }

    public function setPalletMaxHeight(?string $palletMaxHeight): self
    {
        $this->palletMaxHeight = $palletMaxHeight;

        return $this;
    }

    public function getPalletMaxWeight(): ?string
    {
        return $this->palletMaxWeight;
    }

    public function setPalletMaxWeight(?string $palletMaxWeight): self
    {
        $this->palletMaxWeight = $palletMaxWeight;

        return $this;
    }

    public function getPalletsCount(): ?int
    {
        return $this->palletsCount;
    }

    public function setPalletsCount(int $palletsCount): self
    {
        $this->palletsCount = $palletsCount;

        return $this;
    }

    public function getPalletsWeight(): ?string
    {
        return $this->palletsWeight;
    }

    public function setPalletsWeight(?string $palletsWeight): self
    {
        $this->palletsWeight = $palletsWeight;

        return $this;
    }

    public function getStandardParcel(): ?bool
    {
        return $this->standardParcel;
    }

    public function setStandardParcel(bool $standardParcel): self
    {
        $this->standardParcel = $standardParcel;

        return $this;
    }

    public function getParcelMaxDepth(): ?int
    {
        return $this->parcelMaxDepth;
    }

    public function setParcelMaxDepth(?int $parcelMaxDepth): self
    {
        $this->parcelMaxDepth = $parcelMaxDepth;

        return $this;
    }

    public function getParcelMaxHeight(): ?int
    {
        return $this->parcelMaxHeight;
    }

    public function setParcelMaxHeight(?int $parcelMaxHeight): self
    {
        $this->parcelMaxHeight = $parcelMaxHeight;

        return $this;
    }

    public function getParcelMaxWeight(): ?string
    {
        return $this->parcelMaxWeight;
    }

    public function setParcelMaxWeight(?string $parcelMaxWeight): self
    {
        $this->parcelMaxWeight = $parcelMaxWeight;

        return $this;
    }

    public function getParcelMaxWidth(): ?int
    {
        return $this->parcelMaxWidth;
    }

    public function setParcelMaxWidth(?int $parcelMaxWidth): self
    {
        $this->parcelMaxWidth = $parcelMaxWidth;

        return $this;
    }

    public function getParcelsCount(): ?int
    {
        return $this->parcelsCount;
    }

    public function setParcelsCount(int $parcelsCount): self
    {
        $this->parcelsCount = $parcelsCount;

        return $this;
    }

    public function getParcelsWeight(): ?string
    {
        return $this->parcelsWeight;
    }

    public function setParcelsWeight(?string $parcelsWeight): self
    {
        $this->parcelsWeight = $parcelsWeight;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(\DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?\DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(\DateTimeInterface $dateUpd): self
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }
}
