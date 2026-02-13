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

use DateTimeInterface;

class DpdParcelBusinessEventV1
{
    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $eventCode;

    /**
     * @var DpdParcelBusinessEventDataV1
     */
    private $eventDataList;

    /**
     * @var DateTimeInterface
     */
    private $eventTime;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $waybill;

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return DpdParcelBusinessEventV1
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
    public function getEventCode()
    {
        return $this->eventCode;
    }

    /**
     * @param string $eventCode
     * @return DpdParcelBusinessEventV1
     */
    public function withEventCode($eventCode)
    {
        $new = clone $this;
        $new->eventCode = $eventCode;

        return $new;
    }

    /**
     * @return DpdParcelBusinessEventDataV1
     */
    public function getEventDataList()
    {
        return $this->eventDataList;
    }

    /**
     * @param DpdParcelBusinessEventDataV1 $eventDataList
     * @return DpdParcelBusinessEventV1
     */
    public function withEventDataList($eventDataList)
    {
        $new = clone $this;
        $new->eventDataList = $eventDataList;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEventTime()
    {
        return $this->eventTime;
    }

    /**
     * @param DateTimeInterface $eventTime
     * @return DpdParcelBusinessEventV1
     */
    public function withEventTime($eventTime)
    {
        $new = clone $this;
        $new->eventTime = $eventTime;

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
     * @return DpdParcelBusinessEventV1
     */
    public function withPostalCode($postalCode)
    {
        $new = clone $this;
        $new->postalCode = $postalCode;

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
     * @return DpdParcelBusinessEventV1
     */
    public function withWaybill($waybill)
    {
        $new = clone $this;
        $new->waybill = $waybill;

        return $new;
    }
}
