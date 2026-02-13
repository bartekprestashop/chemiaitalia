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

class ValidationInfoPGRV2
{
    /**
     * @var int
     */
    private $ErrorId;

    /**
     * @var string
     */
    private $ErrorCode;

    /**
     * @var string
     */
    private $FieldNames;

    /**
     * @var string
     */
    private $Info;

    /**
     * @return int
     */
    public function getErrorId()
    {
        return $this->ErrorId;
    }

    /**
     * @param int $ErrorId
     * @return ValidationInfoPGRV2
     */
    public function withErrorId($ErrorId)
    {
        $new = clone $this;
        $new->ErrorId = $ErrorId;

        return $new;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->ErrorCode;
    }

    /**
     * @param string $ErrorCode
     * @return ValidationInfoPGRV2
     */
    public function withErrorCode($ErrorCode)
    {
        $new = clone $this;
        $new->ErrorCode = $ErrorCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getFieldNames()
    {
        return $this->FieldNames;
    }

    /**
     * @param string $FieldNames
     * @return ValidationInfoPGRV2
     */
    public function withFieldNames($FieldNames)
    {
        $new = clone $this;
        $new->FieldNames = $FieldNames;

        return $new;
    }

    /**
     * @return string
     */
    public function getInfo()
    {
        return $this->Info;
    }

    /**
     * @param string $Info
     * @return ValidationInfoPGRV2
     */
    public function withInfo($Info)
    {
        $new = clone $this;
        $new->Info = $Info;

        return $new;
    }
}
