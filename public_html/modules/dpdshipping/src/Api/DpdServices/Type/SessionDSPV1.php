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

class SessionDSPV1
{
    /**
     * @var PackageDSPV1
     */
    private $packages;

    /**
     * @var int
     */
    private $sessionId;

    /**
     * @var string
     */
    private $sessionType;

    /**
     * @return PackageDSPV1
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * @param PackageDSPV1 $packages
     * @return SessionDSPV1
     */
    public function withPackages($packages)
    {
        $new = clone $this;
        $new->packages = $packages;

        return $new;
    }

    /**
     * @return int
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param int $sessionId
     * @return SessionDSPV1
     */
    public function withSessionId($sessionId)
    {
        $new = clone $this;
        $new->sessionId = $sessionId;

        return $new;
    }

    /**
     * @return string
     */
    public function getSessionType()
    {
        return $this->sessionType;
    }

    /**
     * @param string $sessionType
     * @return SessionDSPV1
     */
    public function withSessionType($sessionType)
    {
        $new = clone $this;
        $new->sessionType = $sessionType;

        return $new;
    }
}
