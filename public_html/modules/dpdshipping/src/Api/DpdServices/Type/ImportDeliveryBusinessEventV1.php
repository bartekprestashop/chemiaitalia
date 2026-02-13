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

class ImportDeliveryBusinessEventV1
{
    /**
     * @var DpdParcelBusinessEventV1
     */
    private $dpdParcelBusinessEventV1;

    /**
     * @var AuthDataV1
     */
    private $authDataV1;

    /**
     * Constructor
     *
     * @var DpdParcelBusinessEventV1 $dpdParcelBusinessEventV1
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($dpdParcelBusinessEventV1, $authDataV1)
    {
        $this->dpdParcelBusinessEventV1 = $dpdParcelBusinessEventV1;
        $this->authDataV1 = $authDataV1;
    }

    /**
     * @return DpdParcelBusinessEventV1
     */
    public function getDpdParcelBusinessEventV1()
    {
        return $this->dpdParcelBusinessEventV1;
    }

    /**
     * @param DpdParcelBusinessEventV1 $dpdParcelBusinessEventV1
     * @return ImportDeliveryBusinessEventV1
     */
    public function withDpdParcelBusinessEventV1($dpdParcelBusinessEventV1)
    {
        $new = clone $this;
        $new->dpdParcelBusinessEventV1 = $dpdParcelBusinessEventV1;

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
     * @return ImportDeliveryBusinessEventV1
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
