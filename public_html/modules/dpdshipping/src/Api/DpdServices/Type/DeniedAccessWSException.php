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

class DeniedAccessWSException
{
    /**
     * @var int
     */
    private $errorCode;

    /**
     * @var string
     */
    private $exceptionDetails;

    /**
     * @var string
     */
    private $message;

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param int $errorCode
     * @return DeniedAccessWSException
     */
    public function withErrorCode($errorCode)
    {
        $new = clone $this;
        $new->errorCode = $errorCode;

        return $new;
    }

    /**
     * @return string
     */
    public function getExceptionDetails()
    {
        return $this->exceptionDetails;
    }

    /**
     * @param string $exceptionDetails
     * @return DeniedAccessWSException
     */
    public function withExceptionDetails($exceptionDetails)
    {
        $new = clone $this;
        $new->exceptionDetails = $exceptionDetails;

        return $new;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return DeniedAccessWSException
     */
    public function withMessage($message)
    {
        $new = clone $this;
        $new->message = $message;

        return $new;
    }
}
