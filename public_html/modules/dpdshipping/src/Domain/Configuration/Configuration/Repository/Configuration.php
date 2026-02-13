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

class Configuration
{
    public const DPD_STATUS_INFO_URL = 'DPD_STATUS_INFO_URL';
    public const NEED_ONBOARDING = 'NEED_ONBOARDING';
    public const LOG_LEVEL = 'LOG_LEVEL';
    public const DPD_API_LOGIN = 'DPD_API_LOGIN';
    public const DPD_API_PASSWORD = 'DPD_API_PASSWORD';
    public const DPD_API_MASTER_FID = 'DPD_API_MASTER_FID';
    public const DPD_API_DEFAULT_FID = 'DPD_API_DEFAULT_FID';
    public const DPD_API_ENVIRONMENT = 'DPD_API_ENVIRONMENT';
    public const CUSTOM_CHECKOUT = 'DPDSHIPPING_CUSTOM_CHECKOUT';
    public const CUSTOM_CHECKOUT_SUPERCHECKOUT = 'supercheckout';
    public const SEND_MAIL_WHEN_SHIPPING_GENERATED = 'SEND_MAIL_WHEN_SHIPPING_GENERATED';
    public const CHECK_TRACKING_ORDER_VIEW = 'CHECK_TRACKING_ORDER_VIEW';
    public const SPECIAL_PRICE_ENABLED = 'SPECIAL_PRICE_ENABLED';

    public const DEFAULT_PARAM_REF1 = 'DEFAULT_PARAM_REF1';
    public const DEFAULT_PARAM_REF1_STATIC_VALUE = 'DEFAULT_PARAM_REF1_STATIC_VALUE';
    public const DEFAULT_PARAM_REF2 = 'DEFAULT_PARAM_REF2';
    public const DEFAULT_PARAM_REF2_STATIC_VALUE = 'DEFAULT_PARAM_REF2_STATIC_VALUE';
    public const DEFAULT_PARAM_CONTENT = 'DEFAULT_PARAM_CONTENT';
    public const DEFAULT_PARAM_CONTENT_STATIC_VALUE = 'DEFAULT_PARAM_CONTENT_STATIC_VALUE';
    public const DEFAULT_PARAM_CUSTOMER_DATA = 'DEFAULT_PARAM_CUSTOMER_DATA';
    public const DEFAULT_PARAM_CUSTOMER_DATA_STATIC_VALUE = 'DEFAULT_PARAM_CUSTOMER_DATA_STATIC_VALUE';
    public const DEFAULT_PARAM_WEIGHT = 'DEFAULT_PARAM_WEIGHT';
    public const DEFAULT_PRINT_FORMAT = 'DEFAULT_PRINT_FORMAT';
    public const DEFAULT_LABEL_TYPE = 'DEFAULT_LABEL_TYPE';
    public const DEFAULT_PACKAGE_GROUPING_WAY = 'DEFAULT_PACKAGE_GROUPING_WAY';
    public const DPD_COD_PAYMENT_METHODS = 'DPD_COD_PAYMENT_METHODS';
}
