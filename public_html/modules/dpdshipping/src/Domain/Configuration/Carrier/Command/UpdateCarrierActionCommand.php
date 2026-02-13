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

namespace DpdShipping\Domain\Configuration\Carrier\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

class UpdateCarrierActionCommand
{
    /**
     * @var mixed
     */
    private $id_carrier;
    /**
     * @var mixed
     */
    private $newCarrier;

    public function __construct($param)
    {
        if (isset($param['id_carrier'])) {
            $this->id_carrier = $param['id_carrier'];
        }

        if (isset($param['carrier'])) {
            $this->newCarrier = $param['carrier'];
        }
    }

    /**
     * @return mixed
     */
    public function getNewCarrier()
    {
        return $this->newCarrier;
    }

    /**
     * @return mixed
     */
    public function getIdCarrier()
    {
        return $this->id_carrier;
    }
}
