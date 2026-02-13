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

namespace DpdShipping\Form;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Configuration\Command\SaveConfigurationCommand;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\ConfigurationRepository;

class CommonFormDataProvider
{
    protected $queryBus;
    protected $commandBus;

    public function __construct($queryBus, $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    protected function saveConfiguration($param, $value): void
    {
        $this->commandBus->handle(new SaveConfigurationCommand($param, $value ?? ''));
    }

    protected function loadField($fieldName, $configurationParamName): array
    {
        $return = [];
        $param = ConfigurationRepository::getByName($configurationParamName);
        if (!isset($param)) {
            $dbValue = $this->queryBus->handle(new GetConfiguration($configurationParamName));
            if (isset($dbValue)) {
                $return[$fieldName] = $dbValue->getValue();
            }

            return $return;
        }
        $currentValue = $this->queryBus->handle(new GetConfiguration($param->getName()));

        if (isset($currentValue)) {
            $return[$fieldName] = $currentValue->getValue();
        } else {
            $return[$fieldName] = $param->getDefaultValue();
        }

        return $return;
    }
}
