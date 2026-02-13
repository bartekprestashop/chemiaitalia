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

namespace DpdShipping\Domain\Configuration\Carrier\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Carrier;
use Context;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Carrier\DpdCarrierPrestashopConfiguration;
use DpdShipping\Repository\DpdshippingCarrierRepository;
use Group;
use Language;
use Zone;

class AddCarrierHandler
{
    /**
     * @var DpdshippingCarrierRepository
     */
    private $repository;

    public function __construct(DpdshippingCarrierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(AddCarrierCommand $command): bool
    {
        if (!$command->getActive() && $command->getCarrier() != null) {
            return $this->deleteCarrier($command);
        } else {
            return $this->addCarrier($command);
        }
    }

    private function deleteCarrier(AddCarrierCommand $command): bool
    {
        $current = $this->repository->findOneBy(['idCarrier' => $command->getCarrier()->id, 'active' => true]);

        if (isset($current)) {
            $carrier = new Carrier($current->getIdCarrier());
            $carrier->deleted = true;

            if (!$carrier->save()) {
                return false;
            }

            return $this->repository->setInactive($current->getId());
        }

        return true;
    }

    private function addCarrier(AddCarrierCommand $command): bool
    {
        $carrier = new Carrier();
        $carrier->name = $command->getName();
        $carrier->active = 1;
        $carrier->deleted = 0;
        $carrier->is_free = 0;
        $carrier->shipping_handling = 1;
        $carrier->shipping_external = 1;
        $carrier->shipping_method = 1;
        $carrier->max_width = 0;
        $carrier->max_height = 0;
        $carrier->max_depth = 0;
        $carrier->max_weight = 0;
        $carrier->grade = 0;
        $carrier->is_module = 1;
        $carrier->need_range = 1;
        $carrier->range_behavior = 1;
        $carrier->external_module_name = $command->getModuleName();
        $delay = [];

        foreach (Language::getLanguages(false) as $language) {
            $delay[$language['id_lang']] = $command->getName();
        }

        $carrier->delay = $delay;
        $carrier->url = Config::DPD_TRACKING_URL;

        if (!$carrier->add()) {
            return false;
        }

        if (!$this->copyLogo((int) $carrier->id, $command->getType())) {
            return false;
        }

        $zones = Zone::getZones();
        foreach ($zones as $zone) {
            $carrier->addZone((int) $zone['id_zone']);
        }

        if (!$range_obj = $carrier->getRangeObject()) {
            return false;
        }

        $range_obj->id_carrier = (int) $carrier->id;
        $range_obj->delimiter1 = 0;
        $range_obj->delimiter2 = 1;

        if (!$range_obj->add()) {
            return false;
        }

        if (!$this->assignCustomerGroupsForCarrier($carrier)) {
            return false;
        }

        $this->repository->add($carrier->id, $command->getType(), $carrier->active);

        if (!DpdCarrierPrestashopConfiguration::setConfig($command->getType(), $carrier->id)) {
            return false;
        }

        return (int) $carrier->id;
    }

    protected static function assignCustomerGroupsForCarrier($carrier): bool
    {
        $groups = [];

        foreach (Group::getGroups(Context::getContext()->language->id) as $group) {
            $groups[] = $group['id_group'];
        }

        if (!$carrier->setGroups($groups)) {
            return false;
        }

        return true;
    }

    private function copyLogo(int $carrierId, $type): bool
    {
        $image = '';

        if ($type == Config::DPD_STANDARD || $type == Config::DPD_STANDARD_COD) {
            $image = '/dpdshipping/views/img/dpd_carrier_logo.png';
        } elseif ($type == Config::DPD_PICKUP || $type == Config::DPD_PICKUP_COD) {
            $image = '/dpdshipping/views/img/dpd_carrier_pickup_logo.png';
        }

        if (!copy(_PS_MODULE_DIR_ . $image, _PS_SHIP_IMG_DIR_ . '/' . $carrierId . '.jpg')) {
            return false;
        }

        return true;
    }
}
