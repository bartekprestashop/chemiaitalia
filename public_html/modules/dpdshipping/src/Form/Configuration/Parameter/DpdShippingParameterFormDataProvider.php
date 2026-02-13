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

namespace DpdShipping\Form\Configuration\Parameter;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Form\CommonFormDataProvider;
use DpdShipping\Util\ArrayUtil;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingParameterFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $return = [
            $this->loadField('ref1', Configuration::DEFAULT_PARAM_REF1),
            $this->loadField('ref1StaticValue', Configuration::DEFAULT_PARAM_REF1_STATIC_VALUE),
            $this->loadField('ref2', Configuration::DEFAULT_PARAM_REF2),
            $this->loadField('ref2StaticValue', Configuration::DEFAULT_PARAM_REF2_STATIC_VALUE),
            $this->loadField('customerData', Configuration::DEFAULT_PARAM_CUSTOMER_DATA),
            $this->loadField('customerDataStaticValue', Configuration::DEFAULT_PARAM_CUSTOMER_DATA_STATIC_VALUE),
            $this->loadField('content', Configuration::DEFAULT_PARAM_CONTENT),
            $this->loadField('contentStaticValue', Configuration::DEFAULT_PARAM_CONTENT_STATIC_VALUE),
            $this->loadField('weight', Configuration::DEFAULT_PARAM_WEIGHT),
            $this->loadField('printFormat', Configuration::DEFAULT_PRINT_FORMAT),
            $this->loadField('labelType', Configuration::DEFAULT_LABEL_TYPE),
            $this->loadField('package_group_type', Configuration::DEFAULT_PACKAGE_GROUPING_WAY),
        ];

        return ArrayUtil::flatArray($return);
    }

    public function setData(array $data): array
    {
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_REF1, $data['ref1']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_REF1_STATIC_VALUE, $data['ref1StaticValue']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_REF2, $data['ref2']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_REF2_STATIC_VALUE, $data['ref2StaticValue']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_CUSTOMER_DATA, $data['customerData']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_CUSTOMER_DATA_STATIC_VALUE, $data['customerDataStaticValue']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_CONTENT, $data['content']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_CONTENT_STATIC_VALUE, $data['contentStaticValue']);
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_WEIGHT, (float) $data['weight']);
        $this->saveConfiguration(Configuration::DEFAULT_PRINT_FORMAT, $data['printFormat']);
        $this->saveConfiguration(Configuration::DEFAULT_LABEL_TYPE, $data['labelType']);
        $this->saveConfiguration(Configuration::DEFAULT_PACKAGE_GROUPING_WAY, $data['package_group_type'] ?? 'single');

        return [];
    }
}
