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

class GenerateProtocolsWithDestinationsV1
{
    /**
     * @var DpdServicesParamsV2
     */
    private $dpdServicesParamsV2;

    /**
     * @var AuthDataV1
     */
    private $authDataV1;

    /**
     * Constructor
     *
     * @var DpdServicesParamsV2 $dpdServicesParamsV2
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($dpdServicesParamsV2, $authDataV1)
    {
        $this->dpdServicesParamsV2 = $dpdServicesParamsV2;
        $this->authDataV1 = $authDataV1;
    }

    /**
     * @return DpdServicesParamsV2
     */
    public function getDpdServicesParamsV2()
    {
        return $this->dpdServicesParamsV2;
    }

    /**
     * @param DpdServicesParamsV2 $dpdServicesParamsV2
     * @return GenerateProtocolsWithDestinationsV1
     */
    public function withDpdServicesParamsV2($dpdServicesParamsV2)
    {
        $new = clone $this;
        $new->dpdServicesParamsV2 = $dpdServicesParamsV2;

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
     * @return GenerateProtocolsWithDestinationsV1
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
