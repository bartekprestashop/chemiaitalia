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

class PackageDSPV1
{
    /**
     * @var int
     */
    private $packageId;

    /**
     * @var ParcelDSPV1
     */
    private $parcels;

    /**
     * @var string
     */
    private $reference;

    /**
     * @return int
     */
    public function getPackageId()
    {
        return $this->packageId;
    }

    /**
     * @param int $packageId
     * @return PackageDSPV1
     */
    public function withPackageId($packageId)
    {
        $new = clone $this;
        $new->packageId = $packageId;

        return $new;
    }

    /**
     * @return ParcelDSPV1
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param array $parcels
     * @return PackageDSPV1
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
     * @return PackageDSPV1
     */
    public function withReference($reference)
    {
        $new = clone $this;
        $new->reference = $reference;

        return $new;
    }
}
