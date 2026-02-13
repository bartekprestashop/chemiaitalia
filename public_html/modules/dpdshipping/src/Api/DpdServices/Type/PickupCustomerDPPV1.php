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

class PickupCustomerDPPV1
{
    /**
     * @var string
     */
    private $customerFullName;

    /**
     * @var string
     */
    private $customerName;

    /**
     * @var string
     */
    private $customerPhone;

    /**
     * @return string
     */
    public function getCustomerFullName()
    {
        return $this->customerFullName;
    }

    /**
     * @param string $customerFullName
     * @return PickupCustomerDPPV1
     */
    public function withCustomerFullName($customerFullName)
    {
        $new = clone $this;
        $new->customerFullName = $customerFullName;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerName()
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     * @return PickupCustomerDPPV1
     */
    public function withCustomerName($customerName)
    {
        $new = clone $this;
        $new->customerName = $customerName;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerPhone()
    {
        return $this->customerPhone;
    }

    /**
     * @param string $customerPhone
     * @return PickupCustomerDPPV1
     */
    public function withCustomerPhone($customerPhone)
    {
        $new = clone $this;
        $new->customerPhone = $customerPhone;

        return $new;
    }
}
