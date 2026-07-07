<?php

class Cart extends CartCore
{
    public function getPackageShippingCost(
        $id_carrier = null,
        $use_tax = true,
        Country $default_country = null,
        $product_list = null,
        $id_zone = null,
        bool $keepOrderPrices = false
    ) {
        $freeShippingPrice = (float) Configuration::get('PS_SHIPPING_FREE_PRICE');

        if ($freeShippingPrice > 0 && !$this->isVirtualCart()) {
            $freeShippingPrice = Tools::convertPrice(
                $freeShippingPrice,
                Currency::getCurrencyInstance((int) $this->id_currency)
            );

            $orderTotal = $this->getOrderTotal(
                true,
                self::BOTH_WITHOUT_SHIPPING,
                $product_list,
                $id_carrier,
                false,
                $keepOrderPrices
            );

            if (
                Tools::ps_round($orderTotal, 2) >= Tools::ps_round($freeShippingPrice, 2)
                || $this->getRoundedProductsTotalForFreeShipping($product_list, $keepOrderPrices) >= Tools::ps_round($freeShippingPrice, 2)
            ) {
                return 0;
            }
        }

        return parent::getPackageShippingCost(
            $id_carrier,
            $use_tax,
            $default_country,
            $product_list,
            $id_zone,
            $keepOrderPrices
        );
    }

    private function getRoundedProductsTotalForFreeShipping($product_list, bool $keepOrderPrices): float
    {
        $products = $product_list;

        if (null === $products) {
            $products = $this->getProducts(false, false, null, true, $keepOrderPrices);
        }

        $total = 0.0;

        foreach ($products as $product) {
            if (!empty($product['is_virtual'])) {
                continue;
            }

            $quantity = isset($product['cart_quantity']) ? (int) $product['cart_quantity'] : 1;
            $total += Tools::ps_round((float) $product['price_wt'] * $quantity, 2);
        }

        return Tools::ps_round($total, 2);
    }
}
