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

use DateTimeInterface;

class SessionPGRV2
{
    /**
     * @var string
     */
    private $Status;

    /**
     * @var int
     */
    private $SessionId;

    /**
     * @var DateTimeInterface
     */
    private $BeginTime;

    /**
     * @var DateTimeInterface
     */
    private $EndTime;

    /**
     * @var Packages
     */
    private $Packages;

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param string $Status
     * @return SessionPGRV2
     */
    public function withStatus($Status)
    {
        $new = clone $this;
        $new->Status = $Status;

        return $new;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->SessionId;
    }

    /**
     * @param int $SessionId
     * @return SessionPGRV2
     */
    public function withSessionId($SessionId)
    {
        $new = clone $this;
        $new->SessionId = $SessionId;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getBeginTime()
    {
        return $this->BeginTime;
    }

    /**
     * @param DateTimeInterface $BeginTime
     * @return SessionPGRV2
     */
    public function withBeginTime($BeginTime)
    {
        $new = clone $this;
        $new->BeginTime = $BeginTime;

        return $new;
    }

    /**
     * @return DateTimeInterface
     */
    public function getEndTime()
    {
        return $this->EndTime;
    }

    /**
     * @param DateTimeInterface $EndTime
     * @return SessionPGRV2
     */
    public function withEndTime($EndTime)
    {
        $new = clone $this;
        $new->EndTime = $EndTime;

        return $new;
    }

    /**
     * @return Packages
     */
    public function getPackages()
    {
        return $this->Packages;
    }

    /**
     * @param Packages $Packages
     * @return SessionPGRV2
     */
    public function withPackages($Packages)
    {
        $new = clone $this;
        $new->Packages = $Packages;

        return $new;
    }
}
