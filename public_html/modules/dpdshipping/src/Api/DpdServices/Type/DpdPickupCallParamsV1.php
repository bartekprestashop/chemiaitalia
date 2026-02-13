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

use DateTimeInterface;

class DpdPickupCallParamsV1
{
    /**
     * @var ContactInfoDPPV1
     */
    private $contactInfo;

    /**
     * @var PickupAddressDSPV1
     */
    private $pickupAddress;

    /**
     * @var DateTimeInterface
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
    private $policy;

    /**
     * @var ProtocolDPPV1
     */
    private $protocols;

    /**
     * @return ContactInfoDPPV1
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * @param ContactInfoDPPV1 $contactInfo
     * @return DpdPickupCallParamsV1
     */
    public function withContactInfo($contactInfo)
    {
        $new = clone $this;
        $new->contactInfo = $contactInfo;

        return $new;
    }

    /**
     * @return PickupAddressDSPV1
     */
    public function getPickupAddress()
    {
        return $this->pickupAddress;
    }

    /**
     * @param PickupAddressDSPV1 $pickupAddress
     * @return DpdPickupCallParamsV1
     */
    public function withPickupAddress($pickupAddress)
    {
        $new = clone $this;
        $new->pickupAddress = $pickupAddress;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getPickupDate()
    {
        return $this->pickupDate;
    }

    /**
     * @param DateTimeInterface $pickupDate
     * @return DpdPickupCallParamsV1
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
     * @return DpdPickupCallParamsV1
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
     * @return DpdPickupCallParamsV1
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
    public function getPolicy()
    {
        return $this->policy;
    }

    /**
     * @param string $policy
     * @return DpdPickupCallParamsV1
     */
    public function withPolicy($policy)
    {
        $new = clone $this;
        $new->policy = $policy;

        return $new;
    }

    /**
     * @return ProtocolDPPV1
     */
    public function getProtocols()
    {
        return $this->protocols;
    }

    /**
     * @param ProtocolDPPV1 $protocols
     * @return DpdPickupCallParamsV1
     */
    public function withProtocols($protocols)
    {
        $new = clone $this;
        $new->protocols = $protocols;

        return $new;
    }
}
