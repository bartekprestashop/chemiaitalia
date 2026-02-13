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

namespace DpdShipping\Install;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Hook\HookRepository;
use Module;

class Installer
{
    private $hookRepository;
    private $dbInstaller;

    public function __construct(HookRepository $hookRepository, $connection)
    {
        $this->hookRepository = $hookRepository;
        $this->dbInstaller = new DatabaseInstaller($connection);
    }

    public function install(Module $module): bool
    {
        if (!$this->registerHooks($module)) {
            return false;
        }

        if (!empty($this->dbInstaller->createTables())) {
            return false;
        }

        return true;
    }

    private function registerHooks(Module $module): bool
    {
        $hooks = $this->hookRepository->getHooks();

        return $module->registerHook($hooks);
    }

    public function uninstall(): bool
    {
        return empty($this->dbInstaller->dropTables());
    }
}
