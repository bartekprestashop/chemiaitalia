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

namespace DpdShipping\Entity;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\ORM\Mapping as ORM;
use DpdShipping\Repository\DpdshippingSpecialPriceRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingSpecialPriceRepository::class)
 */
class DpdshippingSpecialPrice
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="id_shop", type="integer")
     */
    private $idShop;

    /**
     * @ORM\Column(name="iso_country", type="string", length=255)
     */
    private $isoCountry;

    /**
     * @ORM\Column(name="price_from", type="decimal", precision=20, scale=6)
     */
    private $priceFrom;

    /**
     * @ORM\Column(name="price_to", type="decimal", precision=20, scale=6)
     */
    private $priceTo;

    /**
     * @ORM\Column(name="weight_from", type="decimal", precision=20, scale=6)
     */
    private $weightFrom;

    /**
     * @ORM\Column(name="weight_to", type="decimal", precision=20, scale=6)
     */
    private $weightTo;

    /**
     * @ORM\Column(name="parcel_price", type="float")
     */
    private $parcelPrice;

    /**
     * @ORM\Column(name="cod_price", type="string", length=255)
     */
    private $codPrice;

    /**
     * @ORM\Column(name="carrier_type", type="string", length=50)
     */
    private $carrierType;

    /**
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $dateAdd;

    /**
     * @ORM\Column(name="date_upd", type="datetime")
     */
    private $dateUpd;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getIdShop()
    {
        return $this->idShop;
    }

    /**
     * @param mixed $idShop
     */
    public function setIdShop($idShop): void
    {
        $this->idShop = $idShop;
    }

    /**
     * @return mixed
     */
    public function getIsoCountry()
    {
        return $this->isoCountry;
    }

    /**
     * @param mixed $isoCountry
     */
    public function setIsoCountry($isoCountry): void
    {
        $this->isoCountry = $isoCountry;
    }

    /**
     * @return mixed
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * @param mixed $priceFrom
     */
    public function setPriceFrom($priceFrom): void
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @return mixed
     */
    public function getWeightFrom()
    {
        return $this->weightFrom;
    }

    /**
     * @param mixed $weightFrom
     */
    public function setWeightFrom($weightFrom): void
    {
        $this->weightFrom = $weightFrom;
    }

    /**
     * @return mixed
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * @param mixed $priceTo
     */
    public function setPriceTo($priceTo): void
    {
        $this->priceTo = $priceTo;
    }

    /**
     * @return mixed
     */
    public function getWeightTo()
    {
        return $this->weightTo;
    }

    /**
     * @param mixed $weightTo
     */
    public function setWeightTo($weightTo): void
    {
        $this->weightTo = $weightTo;
    }

    /**
     * @return mixed
     */
    public function getParcelPrice()
    {
        return $this->parcelPrice;
    }

    /**
     * @param mixed $parcelPrice
     */
    public function setParcelPrice($parcelPrice): void
    {
        $this->parcelPrice = $parcelPrice;
    }

    /**
     * @return mixed
     */
    public function getCodPrice()
    {
        return $this->codPrice;
    }

    /**
     * @param mixed $codPrice
     */
    public function setCodPrice($codPrice): void
    {
        $this->codPrice = $codPrice;
    }

    /**
     * @return mixed
     */
    public function getDateAdd()
    {
        return $this->dateAdd;
    }

    /**
     * @param mixed $dateAdd
     */
    public function setDateAdd($dateAdd): void
    {
        $this->dateAdd = $dateAdd;
    }

    /**
     * @return mixed
     */
    public function getDateUpd()
    {
        return $this->dateUpd;
    }

    /**
     * @param mixed $dateUpd
     */
    public function setDateUpd($dateUpd): void
    {
        $this->dateUpd = $dateUpd;
    }

    /**
     * @return mixed
     */
    public function getCarrierType()
    {
        return $this->carrierType;
    }

    /**
     * @param mixed $carrierType
     */
    public function setCarrierType($carrierType): void
    {
        $this->carrierType = $carrierType;
    }
}
