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

class DestinationsData
{
    /**
     * @var string
     */
    private $DestinationName;

    /**
     * @var string
     */
    private $DocumentId;

    /**
     * @var bool
     */
    private $Domestic;

    /**
     * @return string
     */
    public function getDestinationName()
    {
        return $this->DestinationName;
    }

    /**
     * @param string $DestinationName
     * @return DestinationsData
     */
    public function withDestinationName($DestinationName)
    {
        $new = clone $this;
        $new->DestinationName = $DestinationName;

        return $new;
    }

    /**
     * @return string
     */
    public function getDocumentId()
    {
        return $this->DocumentId;
    }

    /**
     * @param string $DocumentId
     * @return DestinationsData
     */
    public function withDocumentId($DocumentId)
    {
        $new = clone $this;
        $new->DocumentId = $DocumentId;

        return $new;
    }

    /**
     * @return bool
     */
    public function getDomestic()
    {
        return $this->Domestic;
    }

    /**
     * @param bool $Domestic
     * @return DestinationsData
     */
    public function withDomestic($Domestic)
    {
        $new = clone $this;
        $new->Domestic = $Domestic;

        return $new;
    }
}
