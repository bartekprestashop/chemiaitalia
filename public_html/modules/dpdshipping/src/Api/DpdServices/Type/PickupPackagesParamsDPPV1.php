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

class PickupPackagesParamsDPPV1
{
    /**
     * @var bool
     */
    private $dox;

    /**
     * @var int
     */
    private $doxCount;

    /**
     * @var bool
     */
    private $pallet;

    /**
     * @var float
     */
    private $palletMaxHeight;

    /**
     * @var float
     */
    private $palletMaxWeight;

    /**
     * @var int
     */
    private $palletsCount;

    /**
     * @var float
     */
    private $palletsWeight;

    /**
     * @var float
     */
    private $parcelMaxDepth;

    /**
     * @var float
     */
    private $parcelMaxHeight;

    /**
     * @var float
     */
    private $parcelMaxWeight;

    /**
     * @var float
     */
    private $parcelMaxWidth;

    /**
     * @var int
     */
    private $parcelsCount;

    /**
     * @var float
     */
    private $parcelsWeight;

    /**
     * @var bool
     */
    private $standardParcel;

    /**
     * @return bool
     */
    public function getDox()
    {
        return $this->dox;
    }

    /**
     * @param bool $dox
     * @return PickupPackagesParamsDPPV1
     */
    public function withDox($dox)
    {
        $new = clone $this;
        $new->dox = $dox;

        return $new;
    }

    /**
     * @return int
     */
    public function getDoxCount()
    {
        return $this->doxCount;
    }

    /**
     * @param int $doxCount
     * @return PickupPackagesParamsDPPV1
     */
    public function withDoxCount($doxCount)
    {
        $new = clone $this;
        $new->doxCount = $doxCount;

        return $new;
    }

    /**
     * @return bool
     */
    public function getPallet()
    {
        return $this->pallet;
    }

    /**
     * @param bool $pallet
     * @return PickupPackagesParamsDPPV1
     */
    public function withPallet($pallet)
    {
        $new = clone $this;
        $new->pallet = $pallet;

        return $new;
    }

    /**
     * @return float
     */
    public function getPalletMaxHeight()
    {
        return $this->palletMaxHeight;
    }

    /**
     * @param float $palletMaxHeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withPalletMaxHeight($palletMaxHeight)
    {
        $new = clone $this;
        $new->palletMaxHeight = $palletMaxHeight;

        return $new;
    }

    /**
     * @return float
     */
    public function getPalletMaxWeight()
    {
        return $this->palletMaxWeight;
    }

    /**
     * @param float $palletMaxWeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withPalletMaxWeight($palletMaxWeight)
    {
        $new = clone $this;
        $new->palletMaxWeight = $palletMaxWeight;

        return $new;
    }

    /**
     * @return int
     */
    public function getPalletsCount()
    {
        return $this->palletsCount;
    }

    /**
     * @param int $palletsCount
     * @return PickupPackagesParamsDPPV1
     */
    public function withPalletsCount($palletsCount)
    {
        $new = clone $this;
        $new->palletsCount = $palletsCount;

        return $new;
    }

    /**
     * @return float
     */
    public function getPalletsWeight()
    {
        return $this->palletsWeight;
    }

    /**
     * @param float $palletsWeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withPalletsWeight($palletsWeight)
    {
        $new = clone $this;
        $new->palletsWeight = $palletsWeight;

        return $new;
    }

    /**
     * @return float
     */
    public function getParcelMaxDepth()
    {
        return $this->parcelMaxDepth;
    }

    /**
     * @param float $parcelMaxDepth
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelMaxDepth($parcelMaxDepth)
    {
        $new = clone $this;
        $new->parcelMaxDepth = $parcelMaxDepth;

        return $new;
    }

    /**
     * @return float
     */
    public function getParcelMaxHeight()
    {
        return $this->parcelMaxHeight;
    }

    /**
     * @param float $parcelMaxHeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelMaxHeight($parcelMaxHeight)
    {
        $new = clone $this;
        $new->parcelMaxHeight = $parcelMaxHeight;

        return $new;
    }

    /**
     * @return float
     */
    public function getParcelMaxWeight()
    {
        return $this->parcelMaxWeight;
    }

    /**
     * @param float $parcelMaxWeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelMaxWeight($parcelMaxWeight)
    {
        $new = clone $this;
        $new->parcelMaxWeight = $parcelMaxWeight;

        return $new;
    }

    /**
     * @return float
     */
    public function getParcelMaxWidth()
    {
        return $this->parcelMaxWidth;
    }

    /**
     * @param float $parcelMaxWidth
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelMaxWidth($parcelMaxWidth)
    {
        $new = clone $this;
        $new->parcelMaxWidth = $parcelMaxWidth;

        return $new;
    }

    /**
     * @return int
     */
    public function getParcelsCount()
    {
        return $this->parcelsCount;
    }

    /**
     * @param int $parcelsCount
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelsCount($parcelsCount)
    {
        $new = clone $this;
        $new->parcelsCount = $parcelsCount;

        return $new;
    }

    /**
     * @return float
     */
    public function getParcelsWeight()
    {
        return $this->parcelsWeight;
    }

    /**
     * @param float $parcelsWeight
     * @return PickupPackagesParamsDPPV1
     */
    public function withParcelsWeight($parcelsWeight)
    {
        $new = clone $this;
        $new->parcelsWeight = $parcelsWeight;

        return $new;
    }

    /**
     * @return bool
     */
    public function getStandardParcel()
    {
        return $this->standardParcel;
    }

    /**
     * @param bool $standardParcel
     * @return PickupPackagesParamsDPPV1
     */
    public function withStandardParcel($standardParcel)
    {
        $new = clone $this;
        $new->standardParcel = $standardParcel;

        return $new;
    }
}
