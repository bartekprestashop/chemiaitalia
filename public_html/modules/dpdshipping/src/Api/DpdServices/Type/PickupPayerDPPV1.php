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

class PickupPayerDPPV1
{
    /**
     * @var string
     */
    private $payerCostCenter;

    /**
     * @var string
     */
    private $payerName;

    /**
     * @var int
     */
    private $payerNumber;

    /**
     * @return string
     */
    public function getPayerCostCenter()
    {
        return $this->payerCostCenter;
    }

    /**
     * @param string $payerCostCenter
     * @return PickupPayerDPPV1
     */
    public function withPayerCostCenter($payerCostCenter)
    {
        $new = clone $this;
        $new->payerCostCenter = $payerCostCenter;

        return $new;
    }

    /**
     * @return string
     */
    public function getPayerName()
    {
        return $this->payerName;
    }

    /**
     * @param string $payerName
     * @return PickupPayerDPPV1
     */
    public function withPayerName($payerName)
    {
        $new = clone $this;
        $new->payerName = $payerName;

        return $new;
    }

    /**
     * @return int
     */
    public function getPayerNumber()
    {
        return $this->payerNumber;
    }

    /**
     * @param int $payerNumber
     * @return PickupPayerDPPV1
     */
    public function withPayerNumber($payerNumber)
    {
        $new = clone $this;
        $new->payerNumber = $payerNumber;

        return $new;
    }
}
