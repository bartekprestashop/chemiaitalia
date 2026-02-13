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

namespace DpdShipping\Api\DpdInfoServices;

if (!defined('_PS_VERSION_')) {
    exit;
}

class DpdInfoServicesClassmap
{
    public static function getCollection(): array
    {
        return [
            'markEventsAsProcessedV1' => Type\MarkEventsAsProcessedV1::class,
            'authDataV1' => Type\AuthDataV1::class,
            'markEventsAsProcessedV1Response' => Type\MarkEventsAsProcessedV1Response::class,
            'Exception' => Type\Exception::class,
            'getEventsForCustomerV4' => Type\GetEventsForCustomerV4::class,
            'getEventsForCustomerV4Response' => Type\GetEventsForCustomerV4Response::class,
            'customerEventsResponseV2' => Type\CustomerEventsResponseV2::class,
            'customerEventV2' => Type\CustomerEventV2::class,
            'customerEventDataV2' => Type\CustomerEventDataV2::class,
            'getEventsForCustomerV3' => Type\GetEventsForCustomerV3::class,
            'getEventsForCustomerV3Response' => Type\GetEventsForCustomerV3Response::class,
            'getEventsForCustomerV2' => Type\GetEventsForCustomerV2::class,
            'getEventsForCustomerV2Response' => Type\GetEventsForCustomerV2Response::class,
            'customerEventsResponseV1' => Type\CustomerEventsResponseV1::class,
            'customerEventV1' => Type\CustomerEventV1::class,
            'getEventsForCustomerV1' => Type\GetEventsForCustomerV1::class,
            'getEventsForCustomerV1Response' => Type\GetEventsForCustomerV1Response::class,
            'getEventsForWaybillV1' => Type\GetEventsForWaybillV1::class,
            'getEventsForWaybillV1Response' => Type\GetEventsForWaybillV1Response::class,
            'customerEventsResponseV3' => Type\CustomerEventsResponseV3::class,
            'customerEventV3' => Type\CustomerEventV3::class,
            'customerEventDataV3' => Type\CustomerEventDataV3::class,
        ];
    }
}
