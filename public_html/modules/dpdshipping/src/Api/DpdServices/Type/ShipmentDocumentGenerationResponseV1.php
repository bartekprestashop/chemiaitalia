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

class ShipmentDocumentGenerationResponseV1
{
    /**
     * @var string
     */
    private $documentData;

    /**
     * @var string
     */
    private $documentId;

    /**
     * @var ShipmentDocumentGenerationSessionV1
     */
    private $session;

    /**
     * @return string
     */
    public function getDocumentData()
    {
        return $this->documentData;
    }

    /**
     * @param string $documentData
     * @return ShipmentDocumentGenerationResponseV1
     */
    public function withDocumentData($documentData)
    {
        $new = clone $this;
        $new->documentData = $documentData;

        return $new;
    }

    /**
     * @return string
     */
    public function getDocumentId()
    {
        return $this->documentId;
    }

    /**
     * @param string $documentId
     * @return ShipmentDocumentGenerationResponseV1
     */
    public function withDocumentId($documentId)
    {
        $new = clone $this;
        $new->documentId = $documentId;

        return $new;
    }

    /**
     * @return ShipmentDocumentGenerationSessionV1
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param ShipmentDocumentGenerationSessionV1 $session
     * @return ShipmentDocumentGenerationResponseV1
     */
    public function withSession($session)
    {
        $new = clone $this;
        $new->session = $session;

        return $new;
    }
}
