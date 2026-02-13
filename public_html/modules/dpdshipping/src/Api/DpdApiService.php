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

namespace DpdShipping\Api;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdInfoServices\DpdInfoServicesClientFactory;
use DpdShipping\Api\DpdInfoServices\Type\AuthDataV1;
use DpdShipping\Api\DpdServices\DpdServicesClientFactory;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use Exception;
use PhpEncryption;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;

class DpdApiService
{
    public const ITC = 'ITC';

    /**
     * @var CommandBusInterface
     */
    private $queryBus;

    public function __construct(CommandBusInterface $queryBus)
    {
        $this->queryBus = $queryBus;
    }

    public function getAuthInfoServices()
    {
        $login = $this->queryBus->handle(new GetConfiguration(Configuration::DPD_API_LOGIN));

        if ($login == null) {
            return null;
        }

        return (new AuthDataV1())
            ->withLogin($login->getValue())
            ->withPassword($this->getPassword())
            ->withChannel(self::ITC);
    }

    public function getAuth()
    {
        $login = $this->queryBus->handle(new GetConfiguration(Configuration::DPD_API_LOGIN));

        if ($login == null) {
            return null;
        }

        return (new DpdServices\Type\AuthDataV1())
            ->withLogin($login->getValue())
            ->withPassword($this->getPassword())
            ->withMasterFid($this->getMasterFid());
    }

    public function getInfoServicesClient(): DpdInfoServices\DpdInfoServicesClient
    {
        return DpdInfoServicesClientFactory::factory(Config::DPD_INFO_SERVICES_LIVE);
    }

    public function getServicesClient(): ?DpdServices\DpdServicesClient
    {
        $environment = $this->queryBus->handle(new GetConfiguration(Configuration::DPD_API_ENVIRONMENT));

        if ($environment == null) {
            return DpdServicesClientFactory::factory(Config::DPD_API_URL_LIVE);
        }

        return DpdServicesClientFactory::factory($environment->getValue());
    }

    public function getServicesClientEnv($environmentUrl): DpdServices\DpdServicesClient
    {
        return DpdServicesClientFactory::factory($environmentUrl);
    }

    private function getPassword()
    {
        try {
            $password = $this->queryBus->handle(new GetConfiguration(Configuration::DPD_API_PASSWORD));
            $phpEncryption = new PhpEncryption(_NEW_COOKIE_KEY_);

            return $phpEncryption->decrypt($password->getValue());
        } catch (Exception $exception) {
            return '';
        }
    }

    private function getMasterFid()
    {
        $masterFid = $this->queryBus->handle(new GetConfiguration(Configuration::DPD_API_MASTER_FID));
        if ($masterFid != null)
            return $masterFid->getValue();

        return null;
    }
}
