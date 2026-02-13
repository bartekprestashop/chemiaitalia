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

class ParcelsAppendResponseV1
{
    /**
     * @var InvalidFieldPAV1
     */
    private $invalidFields;

    /**
     * @var ParcelsAppendParcelPAV1
     */
    private $parcels;

    /**
     * @var string
     */
    private $status;

    /**
     * @return InvalidFieldPAV1
     */
    public function getInvalidFields()
    {
        return $this->invalidFields;
    }

    /**
     * @param InvalidFieldPAV1 $invalidFields
     * @return ParcelsAppendResponseV1
     */
    public function withInvalidFields($invalidFields)
    {
        $new = clone $this;
        $new->invalidFields = $invalidFields;

        return $new;
    }

    /**
     * @return ParcelsAppendParcelPAV1
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param ParcelsAppendParcelPAV1 $parcels
     * @return ParcelsAppendResponseV1
     */
    public function withParcels($parcels)
    {
        $new = clone $this;
        $new->parcels = $parcels;

        return $new;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return ParcelsAppendResponseV1
     */
    public function withStatus($status)
    {
        $new = clone $this;
        $new->status = $status;

        return $new;
    }
}
