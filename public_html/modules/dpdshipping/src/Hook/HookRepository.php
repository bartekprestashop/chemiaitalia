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

class HookRepository
{
    private $hooks;

    public function __construct()
    {
        $this->hooks = [
            Hook::$DISPLAY_ADMIN_ORDER_TAB_LINK => new DisplayHook(Hook::$DISPLAY_ADMIN_ORDER_TAB_LINK, 'order/tracking-link.html.twig'),
            Hook::$DISPLAY_ADMIN_ORDER_TAB_CONTENT => new DisplayHook(Hook::$DISPLAY_ADMIN_ORDER_TAB_CONTENT, ''),
            Hook::$DISPLAY_ADMIN_ORDER_MAIN => new DisplayHook(Hook::$DISPLAY_ADMIN_ORDER_MAIN, ''),
            Hook::$DISPLAY_CARRIER_EXTRA_CONTENT => new DisplayHook(Hook::$DISPLAY_CARRIER_EXTRA_CONTENT, 'views/templates/hook/carrier-extra-content-pudo.tpl'),
            Hook::$ACTION_FRONT_CONTROLLER_SET_MEDIA => new DisplayHook(Hook::$ACTION_FRONT_CONTROLLER_SET_MEDIA, ''),
            Hook::$DISPLAY_BACKOFFICE_HEADER => new DisplayHook(Hook::$DISPLAY_BACKOFFICE_HEADER, ''),
            Hook::$ACTION_ORDER_GRID_DEFINITION_MODIFIER => new DisplayHook(Hook::$ACTION_ORDER_GRID_DEFINITION_MODIFIER, ''),
            Hook::$ACTION_CARRIER_UPDATE => new DisplayHook(Hook::$ACTION_CARRIER_UPDATE, ''),
        ];
    }

    public function getHooks(): array
    {
        return array_keys($this->hooks);
    }

    public function getHook($hookName): DisplayHook
    {
        return $this->hooks[$hookName];
    }
}
