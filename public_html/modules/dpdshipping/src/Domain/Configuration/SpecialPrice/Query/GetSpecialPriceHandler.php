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

namespace DpdShipping\Domain\Configuration\SpecialPrice\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Address;
use Cart;
use Context;
use Country;
use Currency;
use DpdShipping\Config\Config;
use DpdShipping\Repository\DpdshippingSpecialPriceRepository;
use Tools;

class GetSpecialPriceHandler
{
    public const PLN = 'PLN';
    /**
     * @var DpdshippingSpecialPriceRepository
     */
    private $repository;

    public function __construct(DpdshippingSpecialPriceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetSpecialPrice $query)
    {
        return $this->getPrice(
            $query->getTotalWeight(),
            $query->getDpdCarrierType(),
            $query->getCart(),
            $query->getIdCountry()
        );
    }

    public function getPrice($totalWeight, $carrierType, Cart $cart, $idCountry)
    {
        $cartTotalPrice = $cart->getOrderTotal(true, Cart::BOTH_WITHOUT_SHIPPING);
        $idCurrencyPln = Currency::getIdByIsoCode(self::PLN, (int) Context::getContext()->shop->id);
        $cartCurrency = new Currency($cart->id_currency);
        $currencyPLN = new Currency($idCurrencyPln);
        $cartTotalPrice = Tools::convertPriceFull($cartTotalPrice, $cartCurrency, $currencyPLN);

        $isoCountry = $this->getIsoCountry($idCountry, $cart);
        $price_rules = $this->repository->findPriceRules($isoCountry, $totalWeight, $cartTotalPrice, $carrierType);

        $price_rules = array_filter($price_rules, function ($rule) {
            return $rule->getIsoCountry() === '*' || Country::getByIso($rule->getIsoCountry());
        });

        if (empty($price_rules)) {
            return false;
        }

        $matchingPriceRule = $this->getMatchingPriceRule($price_rules, $cartTotalPrice, $totalWeight);

        if ($matchingPriceRule == null) {
            return false;
        }

        $price = $matchingPriceRule->getParcelPrice();

        if ($carrierType == Config::DPD_STANDARD_COD || $carrierType == Config::DPD_PICKUP_COD) {
            $price += $matchingPriceRule->getCodPrice();
        }

        if ($price === false) {
            return false;
        }

        return Tools::convertPriceFull($price, $currencyPLN, $cartCurrency);
    }

    /**
     * @param $idCountry
     * @param Cart $cart
     * @return bool|string
     */
    public function getIsoCountry($idCountry, Cart $cart)
    {
        if ($idCountry) {
            $isoCountry = Country::getIsoById($idCountry);
        } else {
            $address = new Address((int) $cart->id_address_delivery);
            $isoCountry = Country::getIsoById($address->id_country);
        }

        if (!$isoCountry) {
            $isoCountry = self::PLN;
        }

        return $isoCountry;
    }

    /**
     * @param array $price_rules
     * @param float $cartTotalPrice
     * @param $totalWeight
     * @return mixed|null
     */
    public function getMatchingPriceRule(array $price_rules, float $cartTotalPrice, $totalWeight)
    {
        $matchingPriceRule = null;
        if (is_array($price_rules)) {
            foreach ($price_rules as $price_rule) {
                if ($price_rule->getPriceFrom() <= $cartTotalPrice &&
                    $price_rule->getPriceTo() > $cartTotalPrice &&
                    $price_rule->getWeightFrom() <= $totalWeight &&
                    $price_rule->getWeightTo() > $totalWeight
                ) {
                    $matchingPriceRule = $price_rule;
                    break;
                }
            }
        }

        return $matchingPriceRule;
    }
}
