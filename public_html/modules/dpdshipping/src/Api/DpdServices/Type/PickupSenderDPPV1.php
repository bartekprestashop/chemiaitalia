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

class PickupSenderDPPV1
{
    /**
     * @var string
     */
    private $senderAddress;

    /**
     * @var string
     */
    private $senderCity;

    /**
     * @var string
     */
    private $senderFullName;

    /**
     * @var string
     */
    private $senderName;

    /**
     * @var string
     */
    private $senderPhone;

    /**
     * @var string
     */
    private $senderPostalCode;

    /**
     * @return string
     */
    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    /**
     * @param string $senderAddress
     * @return PickupSenderDPPV1
     */
    public function withSenderAddress($senderAddress)
    {
        $new = clone $this;
        $new->senderAddress = $senderAddress;

        return $new;
    }

    /**
     * @return string
     */
    public function getSenderCity()
    {
        return $this->senderCity;
    }

    /**
     * @param string $senderCity
     * @return PickupSenderDPPV1
     */
    public function withSenderCity($senderCity)
    {
        $new = clone $this;
        $new->senderCity = $senderCity;

        return $new;
    }

    /**
     * @return string
     */
    public function getSenderFullName()
    {
        return $this->senderFullName;
    }

    /**
     * @param string $senderFullName
     * @return PickupSenderDPPV1
     */
    public function withSenderFullName($senderFullName)
    {
        $new = clone $this;
        $new->senderFullName = $senderFullName;

        return $new;
    }

    /**
     * @return string
     */
    public function getSenderName()
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     * @return PickupSenderDPPV1
     */
    public function withSenderName($senderName)
    {
        $new = clone $this;
        $new->senderName = $senderName;

        return $new;
    }

    /**
     * @return string
     */
    public function getSenderPhone()
    {
        return $this->senderPhone;
    }

    /**
     * @param string $senderPhone
     * @return PickupSenderDPPV1
     */
    public function withSenderPhone($senderPhone)
    {
        $new = clone $this;
        $new->senderPhone = $senderPhone;

        return $new;
    }

    /**
     * @return string
     */
    public function getSenderPostalCode()
    {
        return $this->senderPostalCode;
    }

    /**
     * @param string $senderPostalCode
     * @return PickupSenderDPPV1
     */
    public function withSenderPostalCode($senderPostalCode)
    {
        $new = clone $this;
        $new->senderPostalCode = $senderPostalCode;

        return $new;
    }
}
