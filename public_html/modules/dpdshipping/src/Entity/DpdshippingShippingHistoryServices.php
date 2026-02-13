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
use DpdShipping\Repository\DpdshippingShippingHistoryServicesRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingShippingHistoryServicesRepository::class)
 */
class DpdshippingShippingHistoryServices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isCod;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $codAmount;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $codCurrency;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isGuarantee;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $guaranteeType;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $guaranteeValue;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isPallet;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isTires;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDeclaredValue;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $declaredValueAmount;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $declaredValueCurrency;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isCud;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDox;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDuty;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $dutyAmount;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $dutyCurrency;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isRod;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDedicatedDelivery;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDpdExpress;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDpdFood;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isCarryIn;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDpdPickup;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $dpdPickupPudo;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isInPers;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isPrivPers;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isSelfCon;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $selfConType;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isDocumentsInternational;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isAdr;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $dpdFoodLimitDate;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isReturnLabel;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelStreet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelCity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelPostalCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelCountryCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelPhone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabelEmail;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIsCod()
    {
        return $this->isCod;
    }

    /**
     * @param mixed $isCod
     */
    public function setIsCod($isCod): void
    {
        $this->isCod = $isCod;
    }

    /**
     * @return mixed
     */
    public function getCodAmount()
    {
        return $this->codAmount;
    }

    /**
     * @param mixed $codAmount
     */
    public function setCodAmount($codAmount): void
    {
        $this->codAmount = $codAmount;
    }

    /**
     * @return mixed
     */
    public function getCodCurrency()
    {
        return $this->codCurrency;
    }

    /**
     * @param mixed $codCurrency
     */
    public function setCodCurrency($codCurrency): void
    {
        $this->codCurrency = $codCurrency;
    }

    /**
     * @return mixed
     */
    public function getIsGuarantee()
    {
        return $this->isGuarantee;
    }

    /**
     * @param mixed $isGuarantee
     */
    public function setIsGuarantee($isGuarantee): void
    {
        $this->isGuarantee = $isGuarantee;
    }

    /**
     * @return mixed
     */
    public function getGuaranteeType()
    {
        return $this->guaranteeType;
    }

    /**
     * @param mixed $guaranteeType
     */
    public function setGuaranteeType($guaranteeType): void
    {
        $this->guaranteeType = $guaranteeType;
    }

    /**
     * @return mixed
     */
    public function getGuaranteeValue()
    {
        return $this->guaranteeValue;
    }

    /**
     * @param mixed $guaranteeValue
     */
    public function setGuaranteeValue($guaranteeValue): void
    {
        $this->guaranteeValue = $guaranteeValue;
    }

    /**
     * @return mixed
     */
    public function getIsPallet()
    {
        return $this->isPallet;
    }

    /**
     * @param mixed $isPallet
     */
    public function setIsPallet($isPallet): void
    {
        $this->isPallet = $isPallet;
    }

    /**
     * @return mixed
     */
    public function getIsTires()
    {
        return $this->isTires;
    }

    /**
     * @param mixed $isTires
     */
    public function setIsTires($isTires): void
    {
        $this->isTires = $isTires;
    }

    /**
     * @return mixed
     */
    public function getIsDeclaredValue()
    {
        return $this->isDeclaredValue;
    }

    /**
     * @param mixed $isDeclaredValue
     */
    public function setIsDeclaredValue($isDeclaredValue): void
    {
        $this->isDeclaredValue = $isDeclaredValue;
    }

    /**
     * @return mixed
     */
    public function getDeclaredValueAmount()
    {
        return $this->declaredValueAmount;
    }

    /**
     * @param mixed $declaredValueAmount
     */
    public function setDeclaredValueAmount($declaredValueAmount): void
    {
        $this->declaredValueAmount = $declaredValueAmount;
    }

    /**
     * @return mixed
     */
    public function getDeclaredValueCurrency()
    {
        return $this->declaredValueCurrency;
    }

    /**
     * @param mixed $declaredValueCurrency
     */
    public function setDeclaredValueCurrency($declaredValueCurrency): void
    {
        $this->declaredValueCurrency = $declaredValueCurrency;
    }

    /**
     * @return mixed
     */
    public function getIsCud()
    {
        return $this->isCud;
    }

    /**
     * @param mixed $isCud
     */
    public function setIsCud($isCud): void
    {
        $this->isCud = $isCud;
    }

    /**
     * @return mixed
     */
    public function getIsDox()
    {
        return $this->isDox;
    }

    /**
     * @param mixed $isDox
     */
    public function setIsDox($isDox): void
    {
        $this->isDox = $isDox;
    }

    /**
     * @return mixed
     */
    public function getIsDuty()
    {
        return $this->isDuty;
    }

    /**
     * @param mixed $isDuty
     */
    public function setIsDuty($isDuty): void
    {
        $this->isDuty = $isDuty;
    }

    /**
     * @return mixed
     */
    public function getDutyAmount()
    {
        return $this->dutyAmount;
    }

    /**
     * @param mixed $dutyAmount
     */
    public function setDutyAmount($dutyAmount): void
    {
        $this->dutyAmount = $dutyAmount;
    }

    /**
     * @return mixed
     */
    public function getDutyCurrency()
    {
        return $this->dutyCurrency;
    }

    /**
     * @param mixed $dutyCurrency
     */
    public function setDutyCurrency($dutyCurrency): void
    {
        $this->dutyCurrency = $dutyCurrency;
    }

    /**
     * @return mixed
     */
    public function getIsRod()
    {
        return $this->isRod;
    }

    /**
     * @param mixed $isRod
     */
    public function setIsRod($isRod): void
    {
        $this->isRod = $isRod;
    }

    /**
     * @return mixed
     */
    public function getIsDedicatedDelivery()
    {
        return $this->isDedicatedDelivery;
    }

    /**
     * @param mixed $isDedicatedDelivery
     */
    public function setIsDedicatedDelivery($isDedicatedDelivery): void
    {
        $this->isDedicatedDelivery = $isDedicatedDelivery;
    }

    /**
     * @return mixed
     */
    public function getIsDpdExpress()
    {
        return $this->isDpdExpress;
    }

    /**
     * @param mixed $isDpdExpress
     */
    public function setIsDpdExpress($isDpdExpress): void
    {
        $this->isDpdExpress = $isDpdExpress;
    }

    /**
     * @return mixed
     */
    public function getIsDpdFood()
    {
        return $this->isDpdFood;
    }

    /**
     * @param mixed $isDpdFood
     */
    public function setIsDpdFood($isDpdFood): void
    {
        $this->isDpdFood = $isDpdFood;
    }

    /**
     * @return mixed
     */
    public function getIsCarryIn()
    {
        return $this->isCarryIn;
    }

    /**
     * @param mixed $isCarryIn
     */
    public function setIsCarryIn($isCarryIn): void
    {
        $this->isCarryIn = $isCarryIn;
    }

    /**
     * @return mixed
     */
    public function getIsDpdPickup()
    {
        return $this->isDpdPickup;
    }

    /**
     * @param mixed $isDpdPickup
     */
    public function setIsDpdPickup($isDpdPickup): void
    {
        $this->isDpdPickup = $isDpdPickup;
    }

    /**
     * @return mixed
     */
    public function getDpdPickupPudo()
    {
        return $this->dpdPickupPudo;
    }

    /**
     * @param mixed $dpdPickupPudo
     */
    public function setDpdPickupPudo($dpdPickupPudo): void
    {
        $this->dpdPickupPudo = $dpdPickupPudo;
    }

    /**
     * @return mixed
     */
    public function getIsInPers()
    {
        return $this->isInPers;
    }

    /**
     * @param mixed $isInPers
     */
    public function setIsInPers($isInPers): void
    {
        $this->isInPers = $isInPers;
    }

    /**
     * @return mixed
     */
    public function getIsPrivPers()
    {
        return $this->isPrivPers;
    }

    /**
     * @param mixed $isPrivPers
     */
    public function setIsPrivPers($isPrivPers): void
    {
        $this->isPrivPers = $isPrivPers;
    }

    /**
     * @return mixed
     */
    public function getIsSelfCon()
    {
        return $this->isSelfCon;
    }

    /**
     * @param mixed $isSelfCon
     */
    public function setIsSelfCon($isSelfCon): void
    {
        $this->isSelfCon = $isSelfCon;
    }

    /**
     * @return mixed
     */
    public function getSelfConType()
    {
        return $this->selfConType;
    }

    /**
     * @param mixed $selfConType
     */
    public function setSelfConType($selfConType): void
    {
        $this->selfConType = $selfConType;
    }

    /**
     * @return mixed
     */
    public function getIsDocumentsInternational()
    {
        return $this->isDocumentsInternational;
    }

    /**
     * @param mixed $isDocumentsInternational
     */
    public function setIsDocumentsInternational($isDocumentsInternational): void
    {
        $this->isDocumentsInternational = $isDocumentsInternational;
    }

    /**
     * @return mixed
     */
    public function getIsAdr()
    {
        return $this->isAdr;
    }

    /**
     * @param mixed $isAdr
     */
    public function setIsAdr($isAdr): void
    {
        $this->isAdr = $isAdr;
    }

    /**
     * @return mixed
     */
    public function getDpdFoodLimitDate()
    {
        return $this->dpdFoodLimitDate;
    }

    /**
     * @param mixed $dpdFoodLimitDate
     */
    public function setDpdFoodLimitDate($dpdFoodLimitDate): void
    {
        $this->dpdFoodLimitDate = $dpdFoodLimitDate;
    }

    /**
     * @return mixed
     */
    public function getIsReturnLabel()
    {
        return $this->isReturnLabel;
    }

    /**
     * @param mixed $isReturnLabel
     */
    public function setIsReturnLabel($isReturnLabel): void
    {
        $this->isReturnLabel = $isReturnLabel;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelCompany()
    {
        return $this->returnLabelCompany;
    }

    /**
     * @param mixed $returnLabelCompany
     */
    public function setReturnLabelCompany($returnLabelCompany): void
    {
        $this->returnLabelCompany = $returnLabelCompany;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelName()
    {
        return $this->returnLabelName;
    }

    /**
     * @param mixed $returnLabelName
     */
    public function setReturnLabelName($returnLabelName): void
    {
        $this->returnLabelName = $returnLabelName;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelStreet()
    {
        return $this->returnLabelStreet;
    }

    /**
     * @param mixed $returnLabelStreet
     */
    public function setReturnLabelStreet($returnLabelStreet): void
    {
        $this->returnLabelStreet = $returnLabelStreet;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelCity()
    {
        return $this->returnLabelCity;
    }

    /**
     * @param mixed $returnLabelCity
     */
    public function setReturnLabelCity($returnLabelCity): void
    {
        $this->returnLabelCity = $returnLabelCity;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelPostalCode()
    {
        return $this->returnLabelPostalCode;
    }

    /**
     * @param mixed $returnLabelPostalCode
     */
    public function setReturnLabelPostalCode($returnLabelPostalCode): void
    {
        $this->returnLabelPostalCode = $returnLabelPostalCode;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelCountryCode()
    {
        return $this->returnLabelCountryCode;
    }

    /**
     * @param mixed $returnLabelCountryCode
     */
    public function setReturnLabelCountryCode($returnLabelCountryCode): void
    {
        $this->returnLabelCountryCode = $returnLabelCountryCode;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelPhone()
    {
        return $this->returnLabelPhone;
    }

    /**
     * @param mixed $returnLabelPhone
     */
    public function setReturnLabelPhone($returnLabelPhone): void
    {
        $this->returnLabelPhone = $returnLabelPhone;
    }

    /**
     * @return mixed
     */
    public function getReturnLabelEmail()
    {
        return $this->returnLabelEmail;
    }

    /**
     * @param mixed $returnLabelEmail
     */
    public function setReturnLabelEmail($returnLabelEmail): void
    {
        $this->returnLabelEmail = $returnLabelEmail;
    }
}
