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

class GetEventsForWaybillV1
{
    /**
     * @var string
     */
    private $waybill;

    /**
     * @var string
     */
    private $eventsSelectType;

    /**
     * @var string
     */
    private $language;

    /**
     * @var AuthDataV1
     */
    private $authDataV1;

    /**
     * Constructor
     *
     * @var string $waybill
     * @var string $eventsSelectType
     * @var string $language
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($waybill, $eventsSelectType, $language, $authDataV1)
    {
        $this->waybill = $waybill;
        $this->eventsSelectType = $eventsSelectType;
        $this->language = $language;
        $this->authDataV1 = $authDataV1;
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
     * @return GetEventsForWaybillV1
     */
    public function withWaybill($waybill)
    {
        $new = clone $this;
        $new->waybill = $waybill;

        return $new;
    }

    /**
     * @return string
     */
    public function getEventsSelectType()
    {
        return $this->eventsSelectType;
    }

    /**
     * @param string $eventsSelectType
     * @return GetEventsForWaybillV1
     */
    public function withEventsSelectType($eventsSelectType)
    {
        $new = clone $this;
        $new->eventsSelectType = $eventsSelectType;

        return $new;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return GetEventsForWaybillV1
     */
    public function withLanguage($language)
    {
        $new = clone $this;
        $new->language = $language;

        return $new;
    }

    /**
     * @return AuthDataV1
     */
    public function getAuthDataV1()
    {
        return $this->authDataV1;
    }

    /**
     * @param AuthDataV1 $authDataV1
     * @return GetEventsForWaybillV1
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
