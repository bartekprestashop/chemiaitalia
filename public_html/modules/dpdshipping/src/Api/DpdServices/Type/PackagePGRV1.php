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

class PackagePGRV1
{
    /**
     * @var InvalidFieldPGRV1
     */
    private $invalidFields;

    /**
     * @var int
     */
    private $packageId;

    /**
     * @var ParcelPGRV1
     */
    private $parcels;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $status;

    /**
     * @return InvalidFieldPGRV1
     */
    public function getInvalidFields()
    {
        return $this->invalidFields;
    }

    /**
     * @param InvalidFieldPGRV1 $invalidFields
     * @return PackagePGRV1
     */
    public function withInvalidFields($invalidFields)
    {
        $new = clone $this;
        $new->invalidFields = $invalidFields;

        return $new;
    }

    /**
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * @param int $packageId
     * @return PackagePGRV1
     */
    public function withPackageId($packageId)
    {
        $new = clone $this;
        $new->packageId = $packageId;

        return $new;
    }

    /**
     * @return ParcelPGRV1
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param ParcelPGRV1 $parcels
     * @return PackagePGRV1
     */
    public function withParcels($parcels)
    {
        $new = clone $this;
        $new->parcels = $parcels;

        return $new;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return PackagePGRV1
     */
    public function withReference($reference)
    {
        $new = clone $this;
        $new->reference = $reference;

        return $new;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return PackagePGRV1
     */
    public function withStatus($status)
    {
        $new = clone $this;
        $new->status = $status;

        return $new;
    }
}
