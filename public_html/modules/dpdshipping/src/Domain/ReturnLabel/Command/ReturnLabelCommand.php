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

namespace DpdShipping\Domain\ReturnLabel\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

class ReturnLabelCommand
{
    private $orderId;
    private $shippingHistoryId;
    private $waybill;
    private $company;
    private $name;
    private $street;
    private $postalCode;
    private $city;
    private $countryCode;
    private $email;
    private $phone;

    public function __construct($orderId, $waybill, $shippingHistoryId = null, $company = null, $name = null, $street = null, $postalCode = null, $city = null, $countryCode = null, $email = null, $phone = null)
    {
        $this->orderId = $orderId;
        $this->company = $company;
        $this->name = $name;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->email = $email;
        $this->phone = $phone;
        $this->shippingHistoryId = $shippingHistoryId;
        $this->waybill = $waybill;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return mixed
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getShippingHistoryId()
    {
        return $this->shippingHistoryId;
    }

    /**
     * @return mixed
     */
    public function getWaybill()
    {
        return $this->waybill;
    }
}
