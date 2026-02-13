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

namespace DpdShipping\Domain\Tracking;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Tracking\Query\GetEventsForWaybill;
use DpdShipping\Domain\Tracking\Query\GetShippingListForOrder;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;

class TrackingService
{
    private $queryBus;

    public function __construct(CommandBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function getTrackingInformation($orderId): array
    {
        $shippingNumbers = $this->queryBus->handle(new GetShippingListForOrder($orderId));

        if (empty($shippingNumbers)) {
            return [];
        }

        $shippingResult = [];
        foreach ($shippingNumbers as $shippingNumber) {
            $tracking = $this->queryBus->handle(new GetEventsForWaybill($shippingNumber['waybill']));
            $shippingResult = array_merge($shippingResult, $tracking);
        }

        return $shippingResult;
    }
}
