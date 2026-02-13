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

if (!defined('_PS_VERSION_')) {
    exit;
}

class DpdshippingPickupSavePointAjaxModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();
        $this->ajax = true;
    }

    public function displayAjax()
    {
        if ($this->validate() === true) {
            try {
                $db = Db::getInstance();
                $idShop = (int) Context::getContext()->shop->id;

                $sql = '
                    INSERT INTO `' . _DB_PREFIX_ . 'dpdshipping_cart_pickup` (`id_shop`, `id_cart`, `pudo_code`)
                    VALUES (' . $idShop . ', ' . $this->getIdCart() . ', "' . pSQL($this->getPudoCode()) . '")';
                $db->execute($sql);

                $response = ['success' => true, 'message' => $this->getPudoCode(), 'cart' => $this->getIdCart()];
            } catch (Exception $e) {
                $response = ['success' => false, 'message' => $e->getMessage()];
            }
            die(json_encode($response));
        } else {
            die(json_encode(['success' => false, 'message' => 'Undefined error']));
        }
    }

    private function validate(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die(json_encode(['success' => false, 'message' => 'Method not allowed']));
        }

        if ($this->getCsrf() != Tools::getToken(false)) {
            die(json_encode(['success' => false, 'message' => 'Invalid token.']));
        }

        if ($this->getToken() != sha1(_COOKIE_KEY_ . 'dpdshipping')) {
            die(json_encode(['success' => false, 'message' => 'Invalid token']));
        }

        if (empty($this->getPudoCode()) || empty($this->getIdCart())) {
            die(json_encode(['success' => false, 'message' => 'Invalid params']));
        }

        $cart = new Cart($this->getIdCart());
        if (!Validate::isLoadedObject($cart)) {
            die(json_encode(['success' => false, 'message' => 'Cart error']));
        }

        if ($cart->orderExists()) {
            die(json_encode(['success' => false, 'message' => 'Order exist']));
        }

        if (Validate::isLoadedObject($this->context->customer) && $cart->id_customer != $this->context->customer->id) {
            die(json_encode(['success' => false, 'message' => 'Invalid customer']));
        }

        return true;
    }

    /**
     * @return false|mixed
     */
    public function getCsrf()
    {
        return Tools::getValue('dpdshipping_csrf');
    }

    /**
     * @return false|mixed
     */
    public function getToken()
    {
        return Tools::getValue('dpdshipping_token');
    }

    /**
     * @return false|mixed
     */
    public function getPudoCode()
    {
        return Tools::getValue('dpdshipping_pudo_code');
    }

    /**
     * @return int
     */
    public function getIdCart(): int
    {
        return Tools::getValue('dpdshipping_id_cart');
    }
}
