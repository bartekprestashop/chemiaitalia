<?php
/**
 * Copyright 2021-2024 InPost S.A.
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
 * @author    InPost S.A.
 * @copyright 2021-2024 InPost S.A.
 * @license   https://joinup.ec.europa.eu/software/page/eupl
 */
class Order extends OrderCore
{
    /*
    * module: inpostshipping
    * date: 2025-01-07 16:50:45
    * version: 2.11.2
    */
    public function getWebserviceParameters($ws_params_attribute_name = null)
    {
        if (($module = Module::getInstanceByName('inpostshipping')) && $module->active) {
            $this->webserviceParameters['fields']['inpost_point'] = [
                'getter' => 'getWsInPostPoint',
                'setter' => false,
            ];
        }
        return parent::getWebserviceParameters($ws_params_attribute_name);
    }
    /*
    * module: inpostshipping
    * date: 2025-01-07 16:50:45
    * version: 2.11.2
    */
    public function getWsInPostPoint()
    {
        
        $module = Module::getInstanceByName('inpostshipping');
        if (!$module || !$module->active) {
            return null;
        }
        $choice = new InPostCartChoiceModel($this->id_cart);
        if (!Validate::isLoadedObject($choice) || 'inpost_locker_standard' !== $choice->service) {
            return null;
        }
        $choice = new InPostCartChoiceModel($this->id_cart);
        if ($this instanceof BaseLinkerOrder) {
            
            $pointDataProvider = $module->getService('inpost.shipping.data_provider.point');
            if ($point = $pointDataProvider->getPointData($choice->point)) {
                $this->bl_delivery_point_id = $point->getId();
                $this->bl_delivery_point_name = $point->name;
                $this->bl_delivery_point_address = $point->address['line1'];
                $this->bl_delivery_point_city = $point->address_details['city'];
                $this->bl_delivery_point_postcode = $point->address_details['post_code'];
            }
        }
        return $choice->point;
    }
}
