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

namespace DpdShipping\Domain\Legacy\SpecialPrice;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Address;
use Context;
use Country;
use Doctrine\ORM\EntityManagerInterface;
use DpdShipping\Domain\Configuration\Carrier\Query\GetAvailableCarrier;
use DpdShipping\Domain\Configuration\Carrier\Query\GetAvailableCarrierHandler;
use DpdShipping\Domain\Configuration\SpecialPrice\Query\GetSpecialPrice;
use DpdShipping\Domain\Configuration\SpecialPrice\Query\GetSpecialPriceHandler;
use DpdShipping\Entity\DpdshippingCarrier;
use DpdShipping\Entity\DpdshippingSpecialPrice;
use DpdShipping\Repository\DpdshippingCarrierRepository;
use DpdShipping\Repository\DpdshippingSpecialPriceRepository;
use Exception;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use Tools;

class SpecialPriceService
{
    private $cart;

    private $id_carrier;

    /**
     * @var DpdshippingSpecialPriceRepository
     */
    private $specialPriceRepository;

    /**
     * @var DpdshippingCarrierRepository
     */
    private $carrierRepository;

    public function __construct($cart, $id_carrier)
    {
        $this->cart = $cart;
        $this->id_carrier = $id_carrier;

        $entityManager = $this->getEntityManager();
        $this->specialPriceRepository = $entityManager->getRepository(DpdshippingSpecialPrice::class);
        $this->carrierRepository = $entityManager->getRepository(DpdshippingCarrier::class);
    }

    /**
     * @return bool|float
     */
    public function handle()
    {
        try {
            if (!class_exists('SoapClient') || !function_exists('curl_init')) {
                return false;
            }

            $idCountry = $this->getIdCountry();

            if (!$this->id_carrier) {
                return false;
            }

            $currentCarriers = (new GetAvailableCarrierHandler($this->carrierRepository))
                ->handle(new GetAvailableCarrier());

            $dpdCarrierType = array_search($this->id_carrier, $currentCarriers);

            if ($dpdCarrierType === false) {
                return false;
            }

            $totalWeight = $this->cart->getTotalWeight();

            return (new GetSpecialPriceHandler($this->specialPriceRepository))
                ->handle(
                    new GetSpecialPrice(
                        $totalWeight,
                        $dpdCarrierType,
                        $this->cart,
                        $idCountry
                    )
                );
        } catch (Exception $exception) {
            return false;
        }
    }

    /**
     * @return bool|int|mixed
     */
    public function getIdCountry()
    {
        $idCountry = (int) Tools::getValue('id_country');

        if (!$idCountry) {
            $country = Address::getCountryAndState((int) $this->cart->id_address_delivery);
            $idCountry = is_array($country) ? $country['id_country'] : $country;

            if (!$idCountry) {
                $idCountry = Country::getByIso('PL');
            }
        }

        return $idCountry;
    }

    private function getEntityManager(): EntityManagerInterface
    {
        //GET for FE
        if (method_exists(Context::getContext()->controller, 'getContainer')) {
            $container = Context::getContext()->controller->getContainer();
            if ($container) {
                return $container->get('doctrine.orm.entity_manager');
            }
        }

        // GET for BO
        return SymfonyContainer::getInstance()->get('doctrine.orm.entity_manager');
    }
}
