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

class DocumentGenerationResponseV2
{
    /**
     * @var DestinationDataList
     */
    private $DestinationDataList;

    /**
     * @var string
     */
    private $DocumentData;

    /**
     * @var NonMatchingData
     */
    private $nonMatchingDataList;

    /**
     * @var SessionDGRV2
     */
    private $Session;

    /**
     * @return DestinationDataList
     */
    public function getDestinationDataList()
    {
        return $this->DestinationDataList;
    }

    /**
     * @param DestinationDataList $DestinationDataList
     * @return DocumentGenerationResponseV2
     */
    public function withDestinationDataList($DestinationDataList)
    {
        $new = clone $this;
        $new->DestinationDataList = $DestinationDataList;

        return $new;
    }

    /**
     * @return string
     */
    public function getDocumentData()
    {
        return $this->DocumentData;
    }

    /**
     * @param string $DocumentData
     * @return DocumentGenerationResponseV2
     */
    public function withDocumentData($DocumentData)
    {
        $new = clone $this;
        $new->DocumentData = $DocumentData;

        return $new;
    }

    /**
     * @return NonMatchingData
     */
    public function getNonMatchingDataList()
    {
        return $this->nonMatchingDataList;
    }

    /**
     * @param NonMatchingData $nonMatchingDataList
     * @return DocumentGenerationResponseV2
     */
    public function withNonMatchingDataList($nonMatchingDataList)
    {
        $new = clone $this;
        $new->nonMatchingDataList = $nonMatchingDataList;

        return $new;
    }

    /**
     * @return SessionDGRV2
     */
    public function getSession()
    {
        return $this->Session;
    }

    /**
     * @param SessionDGRV2 $Session
     * @return DocumentGenerationResponseV2
     */
    public function withSession($Session)
    {
        $new = clone $this;
        $new->Session = $Session;

        return $new;
    }
}
