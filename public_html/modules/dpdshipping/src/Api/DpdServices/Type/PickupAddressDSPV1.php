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

namespace DpdShipping\Api\DpdServices\Type;

if (!defined('_PS_VERSION_')) {
    exit;
}

class PickupAddressDSPV1
{
    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $company;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $fid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return PickupAddressDSPV1
     */
    public function withAddress($address)
    {
        $new = clone $this;
        $new->address = $address;

        return $new;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return PickupAddressDSPV1
     */
    public function withCity($city)
    {
        $new = clone $this;
        $new->city = $city;

        return $new;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return PickupAddressDSPV1
     */
    public function withCompany($company)
    {
        $new = clone $this;
        $new->company = $company;

        return $new;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return PickupAddressDSPV1
     */
    public function withCountryCode($countryCode)
    {
        $new = clone $this;
        $new->countryCode = $countryCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return PickupAddressDSPV1
     */
    public function withEmail($email)
    {
        $new = clone $this;
        $new->email = $email;

        return $new;
    }

    /**
     * @return int
     */
    public function getFid()
    {
        return $this->fid;
    }

    /**
     * @param int $fid
     * @return PickupAddressDSPV1
     */
    public function withFid($fid)
    {
        $new = clone $this;
        $new->fid = $fid;

        return $new;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return PickupAddressDSPV1
     */
    public function withName($name)
    {
        $new = clone $this;
        $new->name = $name;

        return $new;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return PickupAddressDSPV1
     */
    public function withPhone($phone)
    {
        $new = clone $this;
        $new->phone = $phone;

        return $new;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return PickupAddressDSPV1
     */
    public function withPostalCode($postalCode)
    {
        $new = clone $this;
        $new->postalCode = $postalCode;

        return $new;
    }
}
