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

namespace DpdShipping\Domain\Order\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Exception;

class GetCountryIsoCodeHandler
{
    private $logger;

    public function __construct($logger)
    {
        $this->logger = $logger;
    }

    public function handle(GetCountryIsoCode $query): string
    {
        $countryName = trim($query->getCountry());
        try {

            if (strlen($countryName) == 2)
                return strtoupper($countryName);

            $db = \Db::getInstance();

            $query = 'SELECT  `iso_code` FROM `' . _DB_PREFIX_ . 'country_lang` cl
                  LEFT JOIN `' . _DB_PREFIX_ . 'country` c ON cl.`id_country` = c.`id_country`
                  WHERE cl.`name` = "' . pSQL($countryName) . '"
                  OR c.`iso_code` = "' . pSQL($countryName) . '"';

            return $db->getValue($query);
        } catch (Exception $e) {
            $this->logger->error('DPDSHIPPING: Cannot get country ISO for:' . $countryName . ' error: ' . $e->getMessage());
        }

        return $countryName;
    }
}
