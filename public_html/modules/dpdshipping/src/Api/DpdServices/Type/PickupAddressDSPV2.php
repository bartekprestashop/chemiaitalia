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

class PickupAddressDSPV2
{
    /**
     * @var string
     */
    private $Address;

    /**
     * @var string
     */
    private $City;

    /**
     * @var string
     */
    private $Company;

    /**
     * @var string
     */
    private $CountryCode;

    /**
     * @var string
     */
    private $Email;

    /**
     * @var int
     */
    private $Fid;

    /**
     * @var string
     */
    private $Name;

    /**
     * @var string
     */
    private $Phone;

    /**
     * @var string
     */
    private $PostalCode;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->Address;
    }

    /**
     * @param string $Address
     * @return PickupAddressDSPV2
     */
    public function withAddress($Address)
    {
        $new = clone $this;
        $new->Address = $Address;

        return $new;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->City;
    }

    /**
     * @param string $City
     * @return PickupAddressDSPV2
     */
    public function withCity($City)
    {
        $new = clone $this;
        $new->City = $City;

        return $new;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->Company;
    }

    /**
     * @param string $Company
     * @return PickupAddressDSPV2
     */
    public function withCompany($Company)
    {
        $new = clone $this;
        $new->Company = $Company;

        return $new;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->CountryCode;
    }

    /**
     * @param string $CountryCode
     * @return PickupAddressDSPV2
     */
    public function withCountryCode($CountryCode)
    {
        $new = clone $this;
        $new->CountryCode = $CountryCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     * @return PickupAddressDSPV2
     */
    public function withEmail($Email)
    {
        $new = clone $this;
        $new->Email = $Email;

        return $new;
    }

    /**
     * @return int
     */
    public function getFid()
    {
        return $this->Fid;
    }

    /**
     * @param int $Fid
     * @return PickupAddressDSPV2
     */
    public function withFid($Fid)
    {
        $new = clone $this;
        $new->Fid = $Fid;

        return $new;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return PickupAddressDSPV2
     */
    public function withName($Name)
    {
        $new = clone $this;
        $new->Name = $Name;

        return $new;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->Phone;
    }

    /**
     * @param string $Phone
     * @return PickupAddressDSPV2
     */
    public function withPhone($Phone)
    {
        $new = clone $this;
        $new->Phone = $Phone;

        return $new;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    /**
     * @param string $PostalCode
     * @return PickupAddressDSPV2
     */
    public function withPostalCode($PostalCode)
    {
        $new = clone $this;
        $new->PostalCode = $PostalCode;

        return $new;
    }
}
