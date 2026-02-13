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

namespace DpdShipping\Form\Configuration\SpecialPrice;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Configuration as ConfigurationPrestashop;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\SpecialPrice\Command\AddSpecialPriceCommand;
use DpdShipping\Domain\Configuration\SpecialPrice\Query\GetSpecialPriceList;
use DpdShipping\Form\CommonFormDataProvider;
use DpdShipping\Util\ArrayUtil;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingSpecialPriceFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $return = [
            $this->loadField('specialPrice', Configuration::SPECIAL_PRICE_ENABLED),
        ];

        $result = ArrayUtil::flatArray($return);
        $result['specialPrice'] = boolval($result['specialPrice'] ?? '0');
        $result['specialPriceList'] = $this->getSpecialPriceList();

        return $result;
    }

    public function setData(array $data): array
    {
        $this->saveConfiguration(Configuration::SPECIAL_PRICE_ENABLED, $data['specialPrice']);
        ConfigurationPrestashop::updateValue(Configuration::SPECIAL_PRICE_ENABLED, $data['specialPrice']);

        return $this->commandBus->handle(new AddSpecialPriceCommand($data['specialPriceList']));
    }

    /**
     * @return array
     */
    public function getSpecialPriceList(): array
    {
        $specialPriceList = $this->queryBus->handle(new GetSpecialPriceList());
        $specialPriceListResult = [];
        foreach ($specialPriceList as $item) {
            $array = [];
            $array['isoCountry'] = $item->getIsoCountry();
            $array['priceFrom'] = $item->getPriceFrom();
            $array['priceTo'] = $item->getPriceTo();
            $array['weightFrom'] = $item->getWeightFrom();
            $array['weightTo'] = $item->getWeightTo();
            $array['parcelPrice'] = $item->getParcelPrice();
            $array['codPrice'] = $item->getCodPrice();
            $array['carrierType'] = $item->getCarrierType();

            $specialPriceListResult[] = $array;
        }
        if (!empty($specialPriceListResult)) {
            return $specialPriceListResult;
        } else {
            $emptyRow = [];
            $emptyRow[] = [
                'isoCountry' => 'PL',
                'priceFrom' => 0,
                'priceTo' => 999,
                'weightFrom' => 0,
                'weightTo' => 999,
                'parcelPrice' => null,
                'codPrice' => null,
                'carrierType' => Config::DPD_STANDARD,
            ];

            return $emptyRow;
        }
    }
}
