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

namespace DpdShipping\Form\Configuration\Connection;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\Payer\Command\AddPayerCommand;
use DpdShipping\Domain\Configuration\Payer\Query\GetPayerList;
use DpdShipping\Domain\TestConnection\Query\TestDpdConnection;
use DpdShipping\Form\CommonFormDataProvider;
use DpdShipping\Util\ArrayUtil;
use PhpEncryption;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingConnectionFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $return = [
            $this->loadField('login', Configuration::DPD_API_LOGIN),
            $this->loadField('masterfid', Configuration::DPD_API_MASTER_FID),
            $this->loadField('environment', Configuration::DPD_API_ENVIRONMENT),
        ];

        $return[] = ['payerList' => $this->queryBus->handle(new GetPayerList(false)) ?? []];

        return ArrayUtil::flatArray($return);
    }

    public function setData(array $data): array
    {
        $errors = [];

        $testConnection = $this->queryBus->handle(new TestDpdConnection($data['login'], $data['password'], $data['masterfid'], $data['environment']));

        if ($testConnection !== true) {
            $errors[] = $testConnection;

            return $errors;
        }

        $phpEncryption = new PhpEncryption(_NEW_COOKIE_KEY_);

        $this->saveConfiguration(Configuration::DPD_API_LOGIN, $data['login']);
        $this->saveConfiguration(Configuration::DPD_API_PASSWORD, $phpEncryption->encrypt($data['password']));
        $this->saveConfiguration(Configuration::DPD_API_MASTER_FID, $data['masterfid']);
        $this->saveConfiguration(Configuration::DPD_API_ENVIRONMENT, $data['environment']);

        $this->commandBus->handle(new AddPayerCommand($data['payerList']));

        return $errors;
    }
}
