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

use DpdShipping\Config\Config;

if (!defined('_PS_VERSION_')) {
    exit;
}

class dpdshippingPickupIsCodPointAjaxModuleFrontController extends ModuleFrontController
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
                $pudoAddress = $this->isPudoPointWithCod();
                if ($pudoAddress != null) {
                    $response = ['success' => true, 'data' => $pudoAddress];
                } else {
                    $response = ['success' => false, 'message' => 'Undefined error'];
                }
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
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
            die(json_encode(['success' => false, 'message' => 'Method not allowed']));
        }

        if ($this->getCsrf() != Tools::getToken(false)) {
            die(json_encode(['success' => false, 'message' => 'Invalid token.']));
        }

        if ($this->getToken() != sha1(_COOKIE_KEY_ . 'dpdshipping')) {
            die(json_encode(['success' => false, 'message' => 'Invalid token']));
        }

        if (empty($this->getPudoCode())) {
            die(json_encode(['success' => false, 'message' => 'Invalid params']));
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

    public function isPudoPointWithCod()
    {
        if (empty($this->getPudoCode())) {
            return 0;
        }

        $ch = curl_init();

        $url = sprintf(Config::DPD_PUDO_WS_URL, $this->getPudoCode());
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate, sdch, br');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding: gzip, deflate, sdch, br',
            'Accept-Language: en-US,en;q=0.8',
            'Cache-Control: max-age=0',
            'Connection: keep-alive',
            'Host: mypudo.dpd.com.pl',
            'Upgrade-Insecure-Requests: 1',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
        ]);

        $result = curl_exec($ch);
        curl_close($ch);
        if (!$result) {
            return null;
        }

        $xml = new SimpleXMLElement($result);

        if (!isset($xml->PUDO_ITEMS) || !isset($xml->PUDO_ITEMS->PUDO_ITEM) || !isset($xml->PUDO_ITEMS->PUDO_ITEM->SERVICE_PUDO)) {
            return 0;
        }

        if (strpos($xml->PUDO_ITEMS->PUDO_ITEM->SERVICE_PUDO, '101') !== false) {
            return 1;
        }

        return 0;
    }
}
