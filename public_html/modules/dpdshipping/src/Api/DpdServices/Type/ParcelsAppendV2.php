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

class ParcelsAppendV2
{
    /**
     * @var ParcelsAppendSearchCriteriaPAV1
     */
    private $packagesearchCriteria;

    /**
     * @var ParcelAppendPAV2
     */
    private $parcels;

    /**
     * @return ParcelsAppendSearchCriteriaPAV1
     */
    public function getPackagesearchCriteria()
    {
        return $this->packagesearchCriteria;
    }

    /**
     * @param ParcelsAppendSearchCriteriaPAV1 $packagesearchCriteria
     * @return ParcelsAppendV2
     */
    public function withPackagesearchCriteria($packagesearchCriteria)
    {
        $new = clone $this;
        $new->packagesearchCriteria = $packagesearchCriteria;

        return $new;
    }

    /**
     * @return ParcelAppendPAV2
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param ParcelAppendPAV2 $parcels
     * @return ParcelsAppendV2
     */
    public function withParcels($parcels)
    {
        $new = clone $this;
        $new->parcels = $parcels;

        return $new;
    }
}
