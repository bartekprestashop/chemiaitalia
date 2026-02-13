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

namespace DpdShipping\Domain\Configuration\Configuration\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Config\Config;

class ConfigurationRepository
{
    public static function getAll(): array
    {
        return array_keys(self::getParameters());
    }

    public static function getParameters(): array
    {
        return [
            Configuration::DPD_STATUS_INFO_URL => new Parameter(Configuration::DPD_STATUS_INFO_URL, 'https://dpdinfoservices.dpd.com.pl/DPDInfoServicesObjEventsService/DPDInfoServicesObjEvents?wsdl'),
            Configuration::NEED_ONBOARDING => new Parameter(Configuration::NEED_ONBOARDING, '1'),
            Configuration::LOG_LEVEL => new Parameter(Configuration::LOG_LEVEL, 'info'),
            Configuration::DPD_API_ENVIRONMENT => new Parameter(Configuration::DPD_API_ENVIRONMENT, Config::DPD_API_URL_LIVE),
            Configuration::CUSTOM_CHECKOUT => new Parameter(Configuration::CUSTOM_CHECKOUT, 'standard'),
            Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED => new Parameter(Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED, '1'),
            Configuration::CHECK_TRACKING_ORDER_VIEW => new Parameter(Configuration::CHECK_TRACKING_ORDER_VIEW, '1'),
        ];
    }

    public static function getDefaultValue($name): ?string
    {
        $param = self::getByName($name);

        if (isset($param)) {
            return self::getByName($name)->getDefaultValue();
        }

        return null;
    }

    public static function getByName($name): ?Parameter
    {
        return self::getParameters()[$name] ?? null;
    }
}
