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
use DpdShipping\Repository\DpdshippingPickupCourierSettingsRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingPickupCourierSettingsRepository::class)
 */
class DpdshippingPickupCourierSettings
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idShop;

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
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateAdd;

    /**
     * @ORM\Column(type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     */
    private $dateUpd;


    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdShop(): ?int
    {
        return $this->idShop;
    }

    public function setIdShop(int $idShop): self
    {
        $this->idShop = $idShop;
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