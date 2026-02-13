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

namespace DpdShipping\Domain\Configuration\PickupCourier\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

class AddPickupCourierCommand
{
    private $request;
    /**
     * @var string
     */
    private $operationType;
    /**
     * @var null
     */
    private $orderNumber;
    /**
     * @var null
     */
    private $checkSum;

    public function __construct($request, $operationType = "INSERT", $orderNumber = null, $checkSum = null)
    {
        $this->request = $request;
        $this->operationType = $operationType;
        $this->orderNumber = $orderNumber;
        $this->checkSum = $checkSum;
    }

    /**
     * @return mixed
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return mixed|string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @return mixed|null
     */
    public function getCheckSum()
    {
        return $this->checkSum;
    }

}
