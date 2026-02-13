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

class PackagesPickupCallResponseV1
{
    /**
     * @var string
     */
    private $orderNumber;

    /**
     * @var ProtocolPCRV1
     */
    private $prototocols;

    /**
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param string $orderNumber
     * @return PackagesPickupCallResponseV1
     */
    public function withOrderNumber($orderNumber)
    {
        $new = clone $this;
        $new->orderNumber = $orderNumber;

        return $new;
    }

    /**
     * @return ProtocolPCRV1
     */
    public function getPrototocols()
    {
        return $this->prototocols;
    }

    /**
     * @param ProtocolPCRV1 $prototocols
     * @return PackagesPickupCallResponseV1
     */
    public function withPrototocols($prototocols)
    {
        $new = clone $this;
        $new->prototocols = $prototocols;

        return $new;
    }
}
