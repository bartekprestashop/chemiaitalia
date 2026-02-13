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

namespace DpdShipping\Form\Configuration\Configuration;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Carrier\DpdCarrierPrestashopConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\Configuration\Repository\ConfigurationRepository;
use DpdShipping\Form\CommonFormDataProvider;
use DpdShipping\Util\ArrayUtil;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingConfigurationFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $return = [
            $this->loadField('logLevel', Configuration::LOG_LEVEL),
            $this->loadField('customCheckout', Configuration::CUSTOM_CHECKOUT),
            $this->loadField('sendMailWhenShippingGenerated', Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED),
            $this->loadField('checkTrackingOrderView', Configuration::CHECK_TRACKING_ORDER_VIEW),
        ];

        return ArrayUtil::flatArray($return);
    }

    public function setData(array $data): array
    {
        $this->saveConfiguration(Configuration::LOG_LEVEL, $data['logLevel'] ?? ConfigurationRepository::getDefaultValue(Configuration::LOG_LEVEL));
        $customCheckout = $data['customCheckout'] ?? ConfigurationRepository::getDefaultValue(Configuration::CUSTOM_CHECKOUT);
        $this->saveConfiguration(Configuration::CUSTOM_CHECKOUT, $customCheckout);
        DpdCarrierPrestashopConfiguration::setConfig(Configuration::CUSTOM_CHECKOUT, $customCheckout);

        $this->saveConfiguration(Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED, $data['sendMailWhenShippingGenerated'] ?? ConfigurationRepository::getDefaultValue(Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED));
        $this->saveConfiguration(Configuration::CHECK_TRACKING_ORDER_VIEW, $data['checkTrackingOrderView'] ?? ConfigurationRepository::getDefaultValue(Configuration::CHECK_TRACKING_ORDER_VIEW));

        return [];
    }
}
