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

class DpdPickupCallParamsV2
{
    /**
     * @var string
     */
    private $operationType;

    /**
     * @var string
     */
    private $orderNumber;

    /**
     * @var string
     */
    private $orderType;

    /**
     * @var PickupCallSimplifiedDetailsDPPV1
     */
    private $pickupCallSimplifiedDetails;

    /**
     * @var string
     */
    private $pickupDate;

    /**
     * @var string
     */
    private $pickupTimeFrom;

    /**
     * @var string
     */
    private $pickupTimeTo;

    /**
     * @var string
     */
    private $updateMode;

    /**
     * @var bool
     */
    private $waybillsReady;

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @param string $operationType
     * @return DpdPickupCallParamsV2
     */
    public function withOperationType($operationType)
    {
        $new = clone $this;
        $new->operationType = $operationType;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     * @return DpdPickupCallParamsV2
     */
    public function withOrderNumber($orderNumber)
    {
        $new = clone $this;
        $new->orderNumber = $orderNumber;

        return $new;
    }

    /**
     * @return string
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     * @return DpdPickupCallParamsV2
     */
    public function withOrderType($orderType)
    {
        $new = clone $this;
        $new->orderType = $orderType;

        return $new;
    }

    /**
     * @return PickupCallSimplifiedDetailsDPPV1
     */
    public function getPickupCallSimplifiedDetails()
    {
        return $this->pickupCallSimplifiedDetails;
    }

    /**
     * @param PickupCallSimplifiedDetailsDPPV1 $pickupCallSimplifiedDetails
     * @return DpdPickupCallParamsV2
     */
    public function withPickupCallSimplifiedDetails($pickupCallSimplifiedDetails)
    {
        $new = clone $this;
        $new->pickupCallSimplifiedDetails = $pickupCallSimplifiedDetails;

        return $new;
    }

    /**
     * @return string
     */
    public function getPickupDate()
    {
        return $this->pickupDate;
    }

    /**
     * @param string $pickupDate
     * @return DpdPickupCallParamsV2
     */
    public function withPickupDate($pickupDate)
    {
        $new = clone $this;
        $new->pickupDate = $pickupDate;

        return $new;
    }

    /**
     * @return string
     */
    public function getPickupTimeFrom()
    {
        return $this->pickupTimeFrom;
    }

    /**
     * @param string $pickupTimeFrom
     * @return DpdPickupCallParamsV2
     */
    public function withPickupTimeFrom($pickupTimeFrom)
    {
        $new = clone $this;
        $new->pickupTimeFrom = $pickupTimeFrom;

        return $new;
    }

    /**
     * @return string
     */
    public function getPickupTimeTo()
    {
        return $this->pickupTimeTo;
    }

    /**
     * @param string $pickupTimeTo
     * @return DpdPickupCallParamsV2
     */
    public function withPickupTimeTo($pickupTimeTo)
    {
        $new = clone $this;
        $new->pickupTimeTo = $pickupTimeTo;

        return $new;
    }

    /**
     * @return string
     */
    public function getUpdateMode()
    {
        return $this->updateMode;
    }

    /**
     * @param string $updateMode
     * @return DpdPickupCallParamsV2
     */
    public function withUpdateMode($updateMode)
    {
        $new = clone $this;
        $new->updateMode = $updateMode;

        return $new;
    }

    /**
     * @return bool
     */
    public function getWaybillsReady()
    {
        return $this->waybillsReady;
    }

    /**
     * @param bool $waybillsReady
     * @return DpdPickupCallParamsV2
     */
    public function withWaybillsReady($waybillsReady)
    {
        $new = clone $this;
        $new->waybillsReady = $waybillsReady;

        return $new;
    }
}
