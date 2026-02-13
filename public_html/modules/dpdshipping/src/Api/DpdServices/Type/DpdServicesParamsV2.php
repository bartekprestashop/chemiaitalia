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

class DpdServicesParamsV2
{
    /**
     * @var string
     */
    private $Policy;

    /**
     * @var SessionDSPV2
     */
    private $Session;

    /**
     * @var PickupAddressDSPV2
     */
    private $PickupAddress;

    /**
     * @var DeliveryDestinations
     */
    private $DeliveryDestinations;

    /**
     * @var bool
     */
    private $GenProtForNonMatching;

    /**
     * @return string
     */
    public function getPolicy()
    {
        return $this->Policy;
    }

    /**
     * @param string $Policy
     * @return DpdServicesParamsV2
     */
    public function withPolicy($Policy)
    {
        $new = clone $this;
        $new->Policy = $Policy;

        return $new;
    }

    /**
     * @return SessionDSPV2
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * @param SessionDSPV2 $Session
     * @return DpdServicesParamsV2
     */
    public function withSession($Session)
    {
        $new = clone $this;
        $new->Session = $Session;

        return $new;
    }

    /**
     * @return PickupAddressDSPV2
     */
    public function getPickupAddress()
    {
        return $this->PickupAddress;
    }

    /**
     * @param PickupAddressDSPV2 $PickupAddress
     * @return DpdServicesParamsV2
     */
    public function withPickupAddress($PickupAddress)
    {
        $new = clone $this;
        $new->PickupAddress = $PickupAddress;

        return $new;
    }

    /**
     * @return DeliveryDestinations
     */
    public function getDeliveryDestinations()
    {
        return $this->DeliveryDestinations;
    }

    /**
     * @param DeliveryDestinations $DeliveryDestinations
     * @return DpdServicesParamsV2
     */
    public function withDeliveryDestinations($DeliveryDestinations)
    {
        $new = clone $this;
        $new->DeliveryDestinations = $DeliveryDestinations;

        return $new;
    }

    /**
     * @return bool
     */
    public function getGenProtForNonMatching()
    {
        return $this->GenProtForNonMatching;
    }

    /**
     * @param bool $GenProtForNonMatching
     * @return DpdServicesParamsV2
     */
    public function withGenProtForNonMatching($GenProtForNonMatching)
    {
        $new = clone $this;
        $new->GenProtForNonMatching = $GenProtForNonMatching;

        return $new;
    }
}
