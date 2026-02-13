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

/** @noinspection ALL */

namespace DpdShipping\Grid;

if (!defined('_PS_VERSION_')) {
    exit;
}

class HtmlColumnFactory
{
    public static function create($columnName)
    {
        if (version_compare(_PS_VERSION_, '8.1.0', '>=')) {
            // PrestaShop 8 or higher
            return new \PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\HtmlColumn($columnName);
        } else {
            // PrestaShop 1.7
            return new \PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn($columnName);
        }
    }
}
