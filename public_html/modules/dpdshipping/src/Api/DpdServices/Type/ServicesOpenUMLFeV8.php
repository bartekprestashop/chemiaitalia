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

namespace DpdShipping\Api\DpdServices\Type;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ServicesOpenUMLFeV8
{
    /**
     * @var ServiceCarryInOpenUMLFeV1
     */
    private $carryIn;

    /**
     * @var ServiceCODOpenUMLFeV1
     */
    private $cod;

    /**
     * @var ServiceCODDedicatedAccountOpenUMLFeV1
     */
    private $codDedicatedAccount;

    /**
     * @var ServiceCUDOpenUMLeFV1
     */
    private $cud;

    /**
     * @var ServiceDeclaredValueOpenUMLFeV1
     */
    private $declaredValue;

    /**
     * @var ServiceDedicatedDeliveryOpenUMLFeV1
     */
    private $dedicatedDelivery;

    /**
     * @var ServiceDigitalLabelUMLFeV1
     */
    private $digitalLabel;

    /**
     * @var ServiceFlagOpenUMLF
     */
    private $documentsInternational;

    /**
     * @var ServicePalletOpenUMLFeV1
     */
    private $dox;

    /**
     * @var ServiceFlagOpenUMLF
     */
    private $dpdExpress;

    /**
     * @var ServiceDPDFoodOpenUMLFeV1
     */
    private $dpdFood;

    /**
     * @var ServiceDPDLqOpenUMLFeV1
     */
    private $dpdLQ;

    /**
     * @var ServiceDpdPickupOpenUMLFeV1
     */
    private $dpdPickup;

    /**
     * @var ServiceDutyOpenUMLeFV2
     */
    private $duty;

    /**
     * @var ServiceGuaranteeOpenUMLFeV1
     */
    private $guarantee;

    /**
     * @var ServiceInPersOpenUMLFeV1
     */
    private $inPers;

    /**
     * @var ServicePalletOpenUMLFeV1
     */
    private $pallet;

    /**
     * @var ServicePrivPersOpenUMLFeV1
     */
    private $privPers;

    /**
     * @var ServiceRODOpenUMLFeV1
     */
    private $rod;

    /**
     * @var ServiceSelfColOpenUMLFeV1
     */
    private $selfCol;

    /**
     * @var ServiceTiresOpenUMLFeV1
     */
    private $tires;

    /**
     * @var ServiceTiresExportOpenUMLFeV1
     */
    private $tiresExport;

    /**
     * @return ServiceCarryInOpenUMLFeV1
     */
    public function getCarryIn()
    {
        return $this->carryIn;
    }

    /**
     * @param ServiceCarryInOpenUMLFeV1 $carryIn
     * @return ServicesOpenUMLFeV8
     */
    public function withCarryIn($carryIn)
    {
        $new = clone $this;
        $new->carryIn = $carryIn;

        return $new;
    }

    /**
     * @return ServiceCODOpenUMLFeV1
     */
    public function getCod()
    {
        return $this->cod;
    }

    /**
     * @param ServiceCODOpenUMLFeV1 $cod
     * @return ServicesOpenUMLFeV8
     */
    public function withCod($cod)
    {
        $new = clone $this;
        $new->cod = $cod;

        return $new;
    }

    /**
     * @return ServiceCODDedicatedAccountOpenUMLFeV1
     */
    public function getCodDedicatedAccount()
    {
        return $this->codDedicatedAccount;
    }

    /**
     * @param ServiceCODDedicatedAccountOpenUMLFeV1 $codDedicatedAccount
     * @return ServicesOpenUMLFeV8
     */
    public function withCodDedicatedAccount($codDedicatedAccount)
    {
        $new = clone $this;
        $new->codDedicatedAccount = $codDedicatedAccount;

        return $new;
    }

    /**
     * @return ServiceCUDOpenUMLeFV1
     */
    public function getCud()
    {
        return $this->cud;
    }

    /**
     * @param ServiceCUDOpenUMLeFV1 $cud
     * @return ServicesOpenUMLFeV8
     */
    public function withCud($cud)
    {
        $new = clone $this;
        $new->cud = $cud;

        return $new;
    }

    /**
     * @return ServiceDeclaredValueOpenUMLFeV1
     */
    public function getDeclaredValue()
    {
        return $this->declaredValue;
    }

    /**
     * @param ServiceDeclaredValueOpenUMLFeV1 $declaredValue
     * @return ServicesOpenUMLFeV8
     */
    public function withDeclaredValue($declaredValue)
    {
        $new = clone $this;
        $new->declaredValue = $declaredValue;

        return $new;
    }

    /**
     * @return ServiceDedicatedDeliveryOpenUMLFeV1
     */
    public function getDedicatedDelivery()
    {
        return $this->dedicatedDelivery;
    }

    /**
     * @param ServiceDedicatedDeliveryOpenUMLFeV1 $dedicatedDelivery
     * @return ServicesOpenUMLFeV8
     */
    public function withDedicatedDelivery($dedicatedDelivery)
    {
        $new = clone $this;
        $new->dedicatedDelivery = $dedicatedDelivery;

        return $new;
    }

    /**
     * @return ServiceDigitalLabelUMLFeV1
     */
    public function getDigitalLabel()
    {
        return $this->digitalLabel;
    }

    /**
     * @param ServiceDigitalLabelUMLFeV1 $digitalLabel
     * @return ServicesOpenUMLFeV8
     */
    public function withDigitalLabel($digitalLabel)
    {
        $new = clone $this;
        $new->digitalLabel = $digitalLabel;

        return $new;
    }

    /**
     * @return ServiceFlagOpenUMLF
     */
    public function getDocumentsInternational()
    {
        return $this->documentsInternational;
    }

    /**
     * @param ServiceFlagOpenUMLF $documentsInternational
     * @return ServicesOpenUMLFeV8
     */
    public function withDocumentsInternational($documentsInternational)
    {
        $new = clone $this;
        $new->documentsInternational = $documentsInternational;

        return $new;
    }

    /**
     * @return ServicePalletOpenUMLFeV1
     */
    public function getDox()
    {
        return $this->dox;
    }

    /**
     * @param ServicePalletOpenUMLFeV1 $dox
     * @return ServicesOpenUMLFeV8
     */
    public function withDox($dox)
    {
        $new = clone $this;
        $new->dox = $dox;

        return $new;
    }

    /**
     * @return ServiceFlagOpenUMLF
     */
    public function getDpdExpress()
    {
        return $this->dpdExpress;
    }

    /**
     * @param ServiceFlagOpenUMLF $dpdExpress
     * @return ServicesOpenUMLFeV8
     */
    public function withDpdExpress($dpdExpress)
    {
        $new = clone $this;
        $new->dpdExpress = $dpdExpress;

        return $new;
    }

    /**
     * @return ServiceDPDFoodOpenUMLFeV1
     */
    public function getDpdFood()
    {
        return $this->dpdFood;
    }

    /**
     * @param ServiceDPDFoodOpenUMLFeV1 $dpdFood
     * @return ServicesOpenUMLFeV8
     */
    public function withDpdFood($dpdFood)
    {
        $new = clone $this;
        $new->dpdFood = $dpdFood;

        return $new;
    }

    /**
     * @return ServiceDPDLqOpenUMLFeV1
     */
    public function getDpdLQ()
    {
        return $this->dpdLQ;
    }

    /**
     * @param ServiceDPDLqOpenUMLFeV1 $dpdLQ
     * @return ServicesOpenUMLFeV8
     */
    public function withDpdLQ($dpdLQ)
    {
        $new = clone $this;
        $new->dpdLQ = $dpdLQ;

        return $new;
    }

    /**
     * @return ServiceDpdPickupOpenUMLFeV1
     */
    public function getDpdPickup()
    {
        return $this->dpdPickup;
    }

    /**
     * @param ServiceDpdPickupOpenUMLFeV1 $dpdPickup
     * @return ServicesOpenUMLFeV8
     */
    public function withDpdPickup($dpdPickup)
    {
        $new = clone $this;
        $new->dpdPickup = $dpdPickup;

        return $new;
    }

    /**
     * @return ServiceDutyOpenUMLeFV2
     */
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * @param ServiceDutyOpenUMLeFV2 $duty
     * @return ServicesOpenUMLFeV8
     */
    public function withDuty($duty)
    {
        $new = clone $this;
        $new->duty = $duty;

        return $new;
    }

    /**
     * @return ServiceGuaranteeOpenUMLFeV1
     */
    public function getGuarantee()
    {
        return $this->guarantee;
    }

    /**
     * @param ServiceGuaranteeOpenUMLFeV1 $guarantee
     * @return ServicesOpenUMLFeV8
     */
    public function withGuarantee($guarantee)
    {
        $new = clone $this;
        $new->guarantee = $guarantee;

        return $new;
    }

    /**
     * @return ServiceInPersOpenUMLFeV1
     */
    public function getInPers()
    {
        return $this->inPers;
    }

    /**
     * @param ServiceInPersOpenUMLFeV1 $inPers
     * @return ServicesOpenUMLFeV8
     */
    public function withInPers($inPers)
    {
        $new = clone $this;
        $new->inPers = $inPers;

        return $new;
    }

    /**
     * @return ServicePalletOpenUMLFeV1
     */
    public function getPallet()
    {
        return $this->pallet;
    }

    /**
     * @param ServicePalletOpenUMLFeV1 $pallet
     * @return ServicesOpenUMLFeV8
     */
    public function withPallet($pallet)
    {
        $new = clone $this;
        $new->pallet = $pallet;

        return $new;
    }

    /**
     * @return ServicePrivPersOpenUMLFeV1
     */
    public function getPrivPers()
    {
        return $this->privPers;
    }

    /**
     * @param ServicePrivPersOpenUMLFeV1 $privPers
     * @return ServicesOpenUMLFeV8
     */
    public function withPrivPers($privPers)
    {
        $new = clone $this;
        $new->privPers = $privPers;

        return $new;
    }

    /**
     * @return ServiceRODOpenUMLFeV1
     */
    public function getRod()
    {
        return $this->rod;
    }

    /**
     * @param ServiceRODOpenUMLFeV1 $rod
     * @return ServicesOpenUMLFeV8
     */
    public function withRod($rod)
    {
        $new = clone $this;
        $new->rod = $rod;

        return $new;
    }

    /**
     * @return ServiceSelfColOpenUMLFeV1
     */
    public function getSelfCol()
    {
        return $this->selfCol;
    }

    /**
     * @param ServiceSelfColOpenUMLFeV1 $selfCol
     * @return ServicesOpenUMLFeV8
     */
    public function withSelfCol($selfCol)
    {
        $new = clone $this;
        $new->selfCol = $selfCol;

        return $new;
    }

    /**
     * @return ServiceTiresOpenUMLFeV1
     */
    public function getTires()
    {
        return $this->tires;
    }

    /**
     * @param ServiceTiresOpenUMLFeV1 $tires
     * @return ServicesOpenUMLFeV8
     */
    public function withTires($tires)
    {
        $new = clone $this;
        $new->tires = $tires;

        return $new;
    }

    /**
     * @return ServiceTiresExportOpenUMLFeV1
     */
    public function getTiresExport()
    {
        return $this->tiresExport;
    }

    /**
     * @param ServiceTiresExportOpenUMLFeV1 $tiresExport
     * @return ServicesOpenUMLFeV8
     */
    public function withTiresExport($tiresExport)
    {
        $new = clone $this;
        $new->tiresExport = $tiresExport;

        return $new;
    }
}
