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

class ParcelDSPV1
{
    /**
     * @var int
     */
    private $parcelId;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $waybill;

    /**
     * @return int
     */
    public function getParcelId()
    {
        return $this->parcelId;
    }

    /**
     * @param int $parcelId
     * @return ParcelDSPV1
     */
    public function withParcelId($parcelId)
    {
        $new = clone $this;
        $new->parcelId = $parcelId;

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
     * @return ParcelDSPV1
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
    public function getWaybill()
    {
        return $this->waybill;
    }

    /**
     * @param string $waybill
     * @return ParcelDSPV1
     */
    public function withWaybill($waybill)
    {
        $new = clone $this;
        $new->waybill = $waybill;

        return $new;
    }
}
