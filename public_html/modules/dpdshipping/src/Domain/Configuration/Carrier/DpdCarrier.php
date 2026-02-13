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

namespace DpdShipping\Domain\Configuration\Carrier;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Carrier\Command\AddCarrierCommand;
use DpdShipping\Domain\Configuration\Carrier\Query\GetCarrier;

class DpdCarrier
{
    /**
     * @var mixed
     */
    private $queryBus;
    /**
     * @var mixed
     */
    private $commandBus;

    public function __construct($commandBus, $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function handleCarrier($carrierType, $carrierName, $dpdSettingsCarrierActive)
    {
        $carrier = $this->queryBus->handle(new GetCarrier($carrierType));
        if ($this->needSaveCarrier($carrier, $dpdSettingsCarrierActive)) {
            return $this->commandBus->handle(new AddCarrierCommand($carrierName, 'dpdshipping', $carrierType, $dpdSettingsCarrierActive, $carrier));
        }

        return true;
    }

    /**
     * @param $carrier
     * @param $dpdCarrierActive
     * @return bool
     */
    public static function needSaveCarrier($carrier, $dpdCarrierActive): bool
    {
        if ($carrier === false && $dpdCarrierActive) {
            return true;
        }

        if ($carrier && !$carrier->active && !$dpdCarrierActive) {
            return true;
        }

        return $carrier && $carrier->active && !$dpdCarrierActive;
    }
}
