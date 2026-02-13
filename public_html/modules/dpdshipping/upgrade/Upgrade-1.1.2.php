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

if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_1_2($module)
{
    $alterContent = Db::getInstance()->execute(
        'ALTER TABLE ' . _DB_PREFIX_ . 'dpdshipping_shipping_history_parcel MODIFY COLUMN content VARCHAR(500) NULL');

    $alterCustomerData = Db::getInstance()->execute(
        'ALTER TABLE ' . _DB_PREFIX_ . 'dpdshipping_shipping_history_parcel MODIFY COLUMN customer_data VARCHAR(500) NULL');

    return $alterContent && $alterCustomerData;
}
