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

namespace DpdShipping\Hook;

if (!defined('_PS_VERSION_')) {
    exit;
}

class Hook
{
    public static $DISPLAY_ADMIN_ORDER_TAB_LINK = 'displayAdminOrderTabLink';
    public static $DISPLAY_ADMIN_ORDER_TAB_CONTENT = 'displayAdminOrderTabContent';
    public static $DISPLAY_ADMIN_ORDER_MAIN = 'displayAdminOrderMain';
    public static $DISPLAY_CARRIER_EXTRA_CONTENT = 'displayCarrierExtraContent';
    public static $DISPLAY_BACKOFFICE_HEADER = 'displayBackOfficeHeader';
    public static $ACTION_FRONT_CONTROLLER_SET_MEDIA = 'actionFrontControllerSetMedia';
    public static $ACTION_ORDER_GRID_DEFINITION_MODIFIER = 'actionOrderGridDefinitionModifier';
    public static $ACTION_CARRIER_UPDATE = 'actionCarrierUpdate';
}
