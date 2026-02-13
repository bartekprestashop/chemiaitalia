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

namespace DpdShipping\Api\DpdInfoServices\Type;

if (!defined('_PS_VERSION_')) {
    exit;
}

class CustomerEventV2
{
    /**
     * @var string
     */
    private $businessCode;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $depot;

    /**
     * @var string
     */
    private $description;

    /**
     * @var CustomerEventDataV2
     */
    private $eventDataList;

    /**
     * @var string
     */
    private $eventTime;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $objectId;

    /**
     * @var string
     */
    private $operationType;

    /**
     * @var string
     */
    private $packageReference;

    /**
     * @var string
     */
    private $parcelReference;

    /**
     * @var string
     */
    private $waybill;

    /**
     * @return string
     */
    public function getBusinessCode()
    {
        return $this->businessCode;
    }

    /**
     * @param string $businessCode
     * @return CustomerEventV2
     */
    public function withBusinessCode($businessCode)
    {
        $new = clone $this;
        $new->businessCode = $businessCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return CustomerEventV2
     */
    public function withCountry($country)
    {
        $new = clone $this;
        $new->country = $country;

        return $new;
    }

    /**
     * @return string
     */
    public function getDepot()
    {
        return $this->depot;
    }

    /**
     * @param string $depot
     * @return CustomerEventV2
     */
    public function withDepot($depot)
    {
        $new = clone $this;
        $new->depot = $depot;

        return $new;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return CustomerEventV2
     */
    public function withDescription($description)
    {
        $new = clone $this;
        $new->description = $description;

        return $new;
    }

    /**
     * @return CustomerEventDataV2
     */
    public function getEventDataList()
    {
        return $this->eventDataList;
    }

    /**
     * @param CustomerEventDataV2 $eventDataList
     * @return CustomerEventV2
     */
    public function withEventDataList($eventDataList)
    {
        $new = clone $this;
        $new->eventDataList = $eventDataList;

        return $new;
    }

    /**
     * @return string
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    /**
     * @param string $eventTime
     * @return CustomerEventV2
     */
    public function withEventTime($eventTime)
    {
        $new = clone $this;
        $new->eventTime = $eventTime;

        return $new;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return CustomerEventV2
     */
    public function withId($id)
    {
        $new = clone $this;
        $new->id = $id;

        return $new;
    }

    /**
     * @return int
     */
    public function getObjectId()
    {
        return $this->objectId;
    }

    /**
     * @param int $objectId
     * @return CustomerEventV2
     */
    public function withObjectId($objectId)
    {
        $new = clone $this;
        $new->objectId = $objectId;

        return $new;
    }

    /**
     * @return string
     */
    public function getOperationType()
    {
        return $this->operationType;
    }

    /**
     * @param string $operationType
     * @return CustomerEventV2
     */
    public function withOperationType($operationType)
    {
        $new = clone $this;
        $new->operationType = $operationType;

        return $new;
    }

    /**
     * @return string
     */
    public function getPackageReference()
    {
        return $this->packageReference;
    }

    /**
     * @param string $packageReference
     * @return CustomerEventV2
     */
    public function withPackageReference($packageReference)
    {
        $new = clone $this;
        $new->packageReference = $packageReference;

        return $new;
    }

    /**
     * @return string
     */
    public function getParcelReference()
    {
        return $this->parcelReference;
    }

    /**
     * @param string $parcelReference
     * @return CustomerEventV2
     */
    public function withParcelReference($parcelReference)
    {
        $new = clone $this;
        $new->parcelReference = $parcelReference;

        return $new;
    }

    /**
     * @return string
     */
    public function getWaybill()
    {
        return $this->waybill;
    }

    /**
     * @param string $waybill
     * @return CustomerEventV2
     */
    public function withWaybill($waybill)
    {
        $new = clone $this;
        $new->waybill = $waybill;

        return $new;
    }
}
