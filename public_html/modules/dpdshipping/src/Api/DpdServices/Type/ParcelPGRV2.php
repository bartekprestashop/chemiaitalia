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

class ParcelPGRV2
{
    /**
     * @var string
     */
    private $Status;

    /**
     * @var int
     */
    private $ParcelId;

    /**
     * @var string
     */
    private $Reference;

    /**
     * @var string
     */
    private $Waybill;

    /**
     * @var ValidationDetails
     */
    private $ValidationDetails;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return ParcelPGRV2
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
    public function getParcelId()
    {
        return $this->ParcelId;
    }

    /**
     * @param int $ParcelId
     * @return ParcelPGRV2
     */
    public function withParcelId($ParcelId)
    {
        $new = clone $this;
        $new->ParcelId = $ParcelId;

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
     * @return ParcelPGRV2
     */
    public function withReference($Reference)
    {
        $new = clone $this;
        $new->Reference = $Reference;

        return $new;
    }

    /**
     * @return string
     */
    public function getWaybill()
    {
        return $this->Waybill;
    }

    /**
     * @param string $Waybill
     * @return ParcelPGRV2
     */
    public function withWaybill($Waybill)
    {
        $new = clone $this;
        $new->Waybill = $Waybill;

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
     * @return ParcelPGRV2
     */
    public function withValidationDetails($ValidationDetails)
    {
        $new = clone $this;
        $new->ValidationDetails = $ValidationDetails;

        return $new;
    }
}
