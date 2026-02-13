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

class GetCourierOrderAvailabilityResponseV1
{
    /**
     * @var CourierOrderAvailabilityRangeV1
     */
    private $ranges;

    /**
     * @var string
     */
    private $status;

    /**
     * @return CourierOrderAvailabilityRangeV1
     */
    public function getRanges()
    {
        return $this->ranges;
    }

    /**
     * @param CourierOrderAvailabilityRangeV1 $ranges
     * @return GetCourierOrderAvailabilityResponseV1
     */
    public function withRanges($ranges)
    {
        $new = clone $this;
        $new->ranges = $ranges;

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
     * @return GetCourierOrderAvailabilityResponseV1
     */
    public function withStatus($status)
    {
        $new = clone $this;
        $new->status = $status;

        return $new;
    }
}
