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

class PackagePGRV2
{
    /**
     * @var string
     */
    private $Status;

    /**
     * @var int
     */
    private $PackageId;

    /**
     * @var string
     */
    private $Reference;

    /**
     * @var ValidationDetails
     */
    private $ValidationDetails;

    /**
     * @var Parcels
     */
    private $Parcels;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return PackagePGRV2
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return int
     */
    public function getPackageId()
    {
        return $this->PackageId;
    }

    /**
     * @param int $PackageId
     * @return PackagePGRV2
     */
    public function withPackageId($PackageId)
    {
        $new = clone $this;
        $new->PackageId = $PackageId;

        return $new;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->Reference;
    }

    /**
     * @param string $Reference
     * @return PackagePGRV2
     */
    public function withReference($Reference)
    {
        $new = clone $this;
        $new->Reference = $Reference;

        return $new;
    }

    /**
     * @return ValidationDetails
     */
    public function getValidationDetails()
    {
        return $this->ValidationDetails;
    }

    /**
     * @param ValidationDetails $ValidationDetails
     * @return PackagePGRV2
     */
    public function withValidationDetails($ValidationDetails)
    {
        $new = clone $this;
        $new->ValidationDetails = $ValidationDetails;

        return $new;
    }

    /**
     * @return Parcels
     */
    public function getParcels()
    {
        return $this->Parcels;
    }

    /**
     * @param Parcels $Parcels
     * @return PackagePGRV2
     */
    public function withParcels($Parcels)
    {
        $new = clone $this;
        $new->Parcels = $Parcels;

        return $new;
    }
}
