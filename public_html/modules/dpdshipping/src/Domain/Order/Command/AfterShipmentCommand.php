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

namespace DpdShipping\Domain\Order\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdServices\Type\GeneratePackagesNumbersV9;
use DpdShipping\Api\DpdServices\Type\PackageDGRV2;

class AfterShipmentCommand
{
    private $idOrder;
    private $dpdResponsePackage;
    private $shipping;
    private $dpdCarrier;
    private $mainWaybill;

    public function __construct($idOrder, $dpdResponsePackage, $shipping, $dpdCarrier, $mainWaybill)
    {
        $this->dpdResponsePackage = $dpdResponsePackage;
        $this->shipping = $shipping;
        $this->idOrder = $idOrder;
        $this->dpdCarrier = $dpdCarrier;
        $this->mainWaybill = $mainWaybill;
    }

    /**
     * @return PackageDGRV2
     */
    public function getDpdResponsePackage()
    {
        return $this->dpdResponsePackage;
    }

    /**
     * @return GeneratePackagesNumbersV9
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @return mixed
     */
    public function getIdOrder()
    {
        return $this->idOrder;
    }

    /**
     * @return mixed
     */
    public function getDpdCarrier()
    {
        return $this->dpdCarrier;
    }

    public function getMainWaybill()
    {
        return $this->mainWaybill;
    }
}
