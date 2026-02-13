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

declare(strict_types=1);

namespace DpdShipping\Grid\Configuration\Address;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Grid\Configuration\Address\Definition\Factory\AddressGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class AddressFilters extends Filters
{
    protected $filterId = AddressGridDefinitionFactory::GRID_ID;

    public static function getDefaults(): array
    {
        return [
            'limit' => 100,
            'offset' => 0,
            'orderBy' => 'id',
            'sortOrder' => 'desc',
            'filters' => [],
        ];
    }
}
