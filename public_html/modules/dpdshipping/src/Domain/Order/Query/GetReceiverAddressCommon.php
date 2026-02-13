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

namespace DpdShipping\Domain\Order\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Address;
use Country;
use Customer;

class GetReceiverAddressCommon
{
    protected function getOrderDeliveryAddress($query, Customer $customer): array
    {
        $orderAddress = new Address((int) $query->getOrder()->id_address_delivery);

        return $this->mapToAddress($orderAddress, Country::getIsoById($orderAddress->id_country), $customer);
    }

    /**
     * @param $item
     * @param $countryCode
     * @return array
     */
    private function mapToAddress($item, $countryCode, $customer): array
    {
        if (is_array($item)) {
            $email = isset($item['other']) && !empty(trim($item['other'])) ? $item['other'] : $customer->email;
        } else {
            $email = isset($item->other) && !empty(trim($item->other)) ? $item->other : $customer->email;
        }

        return [
            'company' => is_array($item) ? $item['company'] : $item->company,
            'name' => $this->concatenateAndClean($this->getName($item)),
            'street' => $this->concatenateAndClean($this->getAddress($item)),
            'postcode' => is_array($item) ? $item['postcode'] : $item->postcode,
            'city' => is_array($item) ? $item['city'] : $item->city,
            'country' => $countryCode,
            'phone' => (is_array($item) ? $item['phone'] : $item->phone) ?? (is_array($item) ? $item['phone_mobile'] : $item->phone_mobile),
            'email' => $email,
        ];
    }

    private function concatenateAndClean(array $items): string
    {
        $cleanItems = array_filter(array_map('trim', $items), function ($value) {
            return !empty($value);
        });

        return implode(' ', $cleanItems);
    }

    /**
     * @param $item
     * @return array
     */
    private function getName($item): array
    {
        return [is_array($item) ? $item['firstname'] : $item->firstname, is_array($item) ? $item['lastname'] : $item->lastname];
    }

    /**
     * @param $item
     * @return array
     */
    private function getAddress($item): array
    {
        return [is_array($item) ? $item['address1'] : $item->address1, is_array($item) ? $item['address2'] : $item->address2];
    }

    /**
     * @param Customer $customer
     * @param GetReceiverAddressList $query
     * @return array
     */
    protected function getAdditionalAddresses(Customer $customer, GetReceiverAddressList $query): array
    {
        $receiverAddressList = [];
        $customerAddresses = $customer->getAddresses($query->getOrder()->id_lang);
        foreach ($customerAddresses as $item) {
            $countryCode = Country::getIsoById($item['id_country']);
            $receiverAddressList[] = $this->mapToAddress($item, $countryCode, $customer);
        }

        return $receiverAddressList;
    }
}
