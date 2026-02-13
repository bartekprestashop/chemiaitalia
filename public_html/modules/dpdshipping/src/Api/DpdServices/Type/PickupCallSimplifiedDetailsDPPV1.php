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

class PickupCallSimplifiedDetailsDPPV1
{
    /**
     * @var PickupPackagesParamsDPPV1
     */
    private $packagesParams;

    /**
     * @var PickupCustomerDPPV1
     */
    private $pickupCustomer;

    /**
     * @var PickupPayerDPPV1
     */
    private $pickupPayer;

    /**
     * @var PickupSenderDPPV1
     */
    private $pickupSender;

    /**
     * @return PickupPackagesParamsDPPV1
     */
    public function getPackagesParams()
    {
        return $this->packagesParams;
    }

    /**
     * @param PickupPackagesParamsDPPV1 $packagesParams
     * @return PickupCallSimplifiedDetailsDPPV1
     */
    public function withPackagesParams($packagesParams)
    {
        $new = clone $this;
        $new->packagesParams = $packagesParams;

        return $new;
    }

    /**
     * @return PickupCustomerDPPV1
     */
    public function getPickupCustomer()
    {
        return $this->pickupCustomer;
    }

    /**
     * @param PickupCustomerDPPV1 $pickupCustomer
     * @return PickupCallSimplifiedDetailsDPPV1
     */
    public function withPickupCustomer($pickupCustomer)
    {
        $new = clone $this;
        $new->pickupCustomer = $pickupCustomer;

        return $new;
    }

    /**
     * @return PickupPayerDPPV1
     */
    public function getPickupPayer()
    {
        return $this->pickupPayer;
    }

    /**
     * @param PickupPayerDPPV1 $pickupPayer
     * @return PickupCallSimplifiedDetailsDPPV1
     */
    public function withPickupPayer($pickupPayer)
    {
        $new = clone $this;
        $new->pickupPayer = $pickupPayer;

        return $new;
    }

    /**
     * @return PickupSenderDPPV1
     */
    public function getPickupSender()
    {
        return $this->pickupSender;
    }

    /**
     * @param PickupSenderDPPV1 $pickupSender
     * @return PickupCallSimplifiedDetailsDPPV1
     */
    public function withPickupSender($pickupSender)
    {
        $new = clone $this;
        $new->pickupSender = $pickupSender;

        return $new;
    }
}
