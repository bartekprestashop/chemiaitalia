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

use Address;
use Country;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use Exception;
use PrestaShopLogger;

class DpdIframe
{
    public static function getPickupIframeUrl($key, $baseUrl, $idAddressDelivery)
    {
        $countryIso = Config::PL_CONST;
        try {
            $orderAddress = new Address($idAddressDelivery);
            $countryIso = Country::getIsoById($orderAddress->id_country);
        } catch (Exception $e) {
            PrestaShopLogger::addLog('DPDSHIPPING: cannot get country ISO for cart. Set default PL');
        }

        $customCart = DpdCarrierPrestashopConfiguration::getConfig(Configuration::CUSTOM_CHECKOUT);

        $config = DpdCarrierPrestashopConfiguration::getConfig($key);
        if ($customCart == Configuration::CUSTOM_CHECKOUT_SUPERCHECKOUT) {
            if (!empty($config))
                return $config . '&query=PL';
            return $baseUrl . '&query=PL';
        } else {
            if (!empty($config))
                return $config . '&query=' . $countryIso;
            return $baseUrl . '&query=' . $countryIso;
        }
    }
}
