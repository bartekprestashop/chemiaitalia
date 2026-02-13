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

use Configuration;
use DpdShipping\Config\Config;
use Shop;

class DpdCarrierPrestashopConfiguration
{
    public static function isPickup($id): bool
    {
        return DpdCarrierPrestashopConfiguration::getConfig(Config::DPD_PICKUP) == $id;
    }

    public static function isPickupCod($id): bool
    {
        return DpdCarrierPrestashopConfiguration::getConfig(Config::DPD_PICKUP_COD) == $id;
    }

    public static function getConfig($key)
    {
        $id_shop = Shop::getContextShopID(true);
        $id_shop_group = Shop::getContextShopGroupID(true);

        return Configuration::get($key, null, $id_shop_group, $id_shop);
    }

    public static function setConfig($key, $value)
    {
        $id_shop = Shop::getContextShopID(true);
        $id_shop_group = Shop::getContextShopGroupID(true);

        return Configuration::updateValue($key, $value, false, $id_shop_group, $id_shop);
    }
}
