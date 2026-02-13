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

namespace DpdShipping\Domain\Configuration\Carrier\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Repository\DpdshippingConfigurationRepository;
use Module;
use PrestaShop\PrestaShop\Adapter\Validate;

class GetCodPaymentModulesHandler
{
    /**
     * @var DpdshippingConfigurationRepository
     */
    private $dpdshippingConfigurationRepository;

    public function __construct(DpdshippingConfigurationRepository $dpdshippingConfigurationRepository)
    {
        $this->dpdshippingConfigurationRepository = $dpdshippingConfigurationRepository;
    }

    public function handle(GetCodPaymentModules $query)
    {
        $paymentMethodsJson = $this->dpdshippingConfigurationRepository->findOneByName($query->getType());

        return self::getCodPaymentMethods($paymentMethodsJson);
    }

    private static function getShopPaymentMethods()
    {
        $result = [];
        foreach (Module::getPaymentModules() as $payment_module) {
            $module = Module::getInstanceByName($payment_module['name']);

            if (!Validate::isLoadedObject($module)) {
                continue;
            }

            $result[] = [
                'displayName' => $module->displayName,
                'name' => $payment_module['name'],
                'enable' => false,
            ];
        }

        return $result;
    }

    public static function isCodPaymentMethod($paymentMethodsJson, $orderPaymentModule): bool
    {
        if ($paymentMethodsJson == null) {
            return false;
        }

        $methods = self::getCodPaymentMethods($paymentMethodsJson);

        foreach ($methods as $method) {
            if ($method['name'] === $orderPaymentModule && $method['enable'] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param mixed $paymentMethodsJson
     * @param array $result
     * @return array
     */
    public static function getCodPaymentMethods($paymentMethodsJson): array
    {
        $shopPaymentMethods = Module::getPaymentModules();
        if (empty($paymentMethodsJson)) {
            return self::getShopPaymentMethods();
        }

        $paymentMethodsConfig = json_decode($paymentMethodsJson->getValue(), true);

        $normalizedConfig = self::getNormalizedConfig($paymentMethodsConfig);

        $configByName = self::getName($normalizedConfig);

        foreach ($shopPaymentMethods as $shopPaymentMethod) {
            $isEnabled = false;

            if (isset($configByName[$shopPaymentMethod['name']])) {
                $isEnabled = $configByName[$shopPaymentMethod['name']]['enable'];
            }

            $module = Module::getInstanceByName($shopPaymentMethod['name']);

            if (!Validate::isLoadedObject($module)) {
                continue;
            }

            $result[] = [
                'name' => $shopPaymentMethod['name'],
                'displayName' => $module->displayName,
                'enable' => $isEnabled,
            ];
        }

        return $result;
    }

    /**
     * @param $paymentMethodsConfig
     * @return array|mixed
     */
    private static function getNormalizedConfig($paymentMethodsConfig)
    {
        if (isset($paymentMethodsConfig[0])) {
            $normalizedConfig = $paymentMethodsConfig;
        } else {
            $normalizedConfig = array_values($paymentMethodsConfig);
        }

        return $normalizedConfig;
    }

    /**
     * @param $normalizedConfig
     * @return array
     */
    private static function getName($normalizedConfig): array
    {
        $configByName = [];
        foreach ($normalizedConfig as $configMethod) {
            $configByName[$configMethod['name']] = $configMethod;
        }

        return $configByName;
    }
}
