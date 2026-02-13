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
use DpdShipping\Repository\DpdshippingShippingHistoryParcelRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingShippingHistoryParcelRepository::class)
 */
class DpdshippingShippingHistoryParcel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many Parcels may belong to one Shipping History.
     * @ORM\ManyToOne(targetEntity="DpdshippingShippingHistory", inversedBy="parcels")
     * @ORM\JoinColumn(name="shipping_history_id", referencedColumnName="id", nullable=true)
     */
    private $shippingHistory;

    /**
     * @ORM\Column(type="integer")
     */
    private $parcelIndex;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $waybill;

    /**
     * @ORM\Column(type="boolean", options={"default":0})
     */
    private $isMainWaybill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $parentWaybill;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $returnLabel;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2)
     */
    private $weight;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $weightAdr;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customerData;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $sizeX;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $sizeY;

    /**
     * @ORM\Column(type="decimal", precision=14, scale=2, nullable=true)
     */
    private $sizeZ;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getShippingHistory()
    {
        return $this->shippingHistory;
    }

    /**
     * @param mixed $shippingHistory
     */
    public function setShippingHistory($shippingHistory): void
    {
        $this->shippingHistory = $shippingHistory;
    }

    /**
     * @return mixed
     */
    public function getParcelIndex()
    {
        return $this->parcelIndex;
    }

    /**
     * @param mixed $index
     */
    public function setParcelIndex($parcelIndex): void
    {
        $this->parcelIndex = $parcelIndex;
    }

    /**
     * @return mixed
     */
    public function getWaybill()
    {
        return $this->waybill;
    }

    /**
     * @param mixed $waybill
     */
    public function setWaybill($waybill): void
    {
        $this->waybill = $waybill;
    }

    /**
     * @return mixed
     */
    public function getIsMainWaybill()
    {
        return $this->isMainWaybill;
    }

    /**
     * @param mixed $isMainWaybill
     */
    public function setIsMainWaybill($isMainWaybill): void
    {
        $this->isMainWaybill = $isMainWaybill;
    }

    /**
     * @return mixed
     */
    public function getParentWaybill()
    {
        return $this->parentWaybill;
    }

    /**
     * @param mixed $parentWaybill
     */
    public function setParentWaybill($parentWaybill): void
    {
        $this->parentWaybill = $parentWaybill;
    }

    /**
     * @return mixed
     */
    public function getReturnLabel()
    {
        return $this->returnLabel;
    }

    /**
     * @param mixed $returnLabel
     */
    public function setReturnLabel($returnLabel): void
    {
        $this->returnLabel = $returnLabel;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getWeightAdr()
    {
        return $this->weightAdr;
    }

    /**
     * @param mixed $weightAdr
     */
    public function setWeightAdr($weightAdr): void
    {
        $this->weightAdr = $weightAdr;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCustomerData()
    {
        return $this->customerData;
    }

    /**
     * @param mixed $customerData
     */
    public function setCustomerData($customerData): void
    {
        $this->customerData = $customerData;
    }

    /**
     * @return mixed
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * @param mixed $sizeX
     */
    public function setSizeX($sizeX): void
    {
        $this->sizeX = $sizeX;
    }

    /**
     * @return mixed
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }

    /**
     * @param mixed $sizeY
     */
    public function setSizeY($sizeY): void
    {
        $this->sizeY = $sizeY;
    }

    /**
     * @return mixed
     */
    public function getSizeZ()
    {
        return $this->sizeZ;
    }

    /**
     * @param mixed $sizeZ
     */
    public function setSizeZ($sizeZ): void
    {
        $this->sizeZ = $sizeZ;
    }
}
