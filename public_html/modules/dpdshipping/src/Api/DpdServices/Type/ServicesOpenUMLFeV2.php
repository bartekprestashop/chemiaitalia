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

class ServicesOpenUMLFeV2
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
     * @var ServicePalletOpenUMLFeV1
     */
    private $dox;

    /**
     * @var ServiceDutyOpenUMLeFV1
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
     */
    public function withCod($cod)
    {
        $new = clone $this;
        $new->cod = $cod;

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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
     */
    public function withDedicatedDelivery($dedicatedDelivery)
    {
        $new = clone $this;
        $new->dedicatedDelivery = $dedicatedDelivery;

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
     * @return ServicesOpenUMLFeV2
     */
    public function withDox($dox)
    {
        $new = clone $this;
        $new->dox = $dox;

        return $new;
    }

    /**
     * @return ServiceDutyOpenUMLeFV1
     */
    public function getDuty()
    {
        return $this->duty;
    }

    /**
     * @param ServiceDutyOpenUMLeFV1 $duty
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
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
     * @return ServicesOpenUMLFeV2
     */
    public function withTiresExport($tiresExport)
    {
        $new = clone $this;
        $new->tiresExport = $tiresExport;

        return $new;
    }
}
