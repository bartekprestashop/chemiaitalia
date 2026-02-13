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

class CourierOrderAvailabilityRangeV1
{
    /**
     * @var int
     */
    private $offset;

    /**
     * @var string
     */
    private $range;

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     * @return CourierOrderAvailabilityRangeV1
     */
    public function withOffset($offset)
    {
        $new = clone $this;
        $new->offset = $offset;

        return $new;
    }

    /**
     * @return string
     */
    public function getRange()
    {
        return $this->range;
    }

    /**
     * @param string $range
     * @return CourierOrderAvailabilityRangeV1
     */
    public function withRange($range)
    {
        $new = clone $this;
        $new->range = $range;

        return $new;
    }
}
