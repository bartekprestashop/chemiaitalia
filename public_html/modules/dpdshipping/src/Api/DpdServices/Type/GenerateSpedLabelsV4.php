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

class GenerateSpedLabelsV4
{
    /**
     * @var DpdServicesParamsV1
     */
    private $dpdServicesParamsV1;

    /**
     * @var string
     */
    private $outputDocFormatV1;

    /**
     * @var string
     */
    private $outputDocPageFormatV1;

    /**
     * @var string
     */
    private $outputLabelType;

    /**
     * @var string
     */
    private $labelVariant;

    /**
     * @var AuthDataV1
     */
    private $authDataV1;

    /**
     * Constructor
     *
     * @var DpdServicesParamsV1 $dpdServicesParamsV1
     * @var string $outputDocFormatV1
     * @var string $outputDocPageFormatV1
     * @var string $outputLabelType
     * @var string $labelVariant
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($dpdServicesParamsV1, $outputDocFormatV1, $outputDocPageFormatV1, $outputLabelType, $labelVariant, $authDataV1)
    {
        $this->dpdServicesParamsV1 = $dpdServicesParamsV1;
        $this->outputDocFormatV1 = $outputDocFormatV1;
        $this->outputDocPageFormatV1 = $outputDocPageFormatV1;
        $this->outputLabelType = $outputLabelType;
        $this->labelVariant = $labelVariant;
        $this->authDataV1 = $authDataV1;
    }

    /**
     * @return DpdServicesParamsV1
     */
    public function getDpdServicesParamsV1()
    {
        return $this->dpdServicesParamsV1;
    }

    /**
     * @param DpdServicesParamsV1 $dpdServicesParamsV1
     * @return GenerateSpedLabelsV4
     */
    public function withDpdServicesParamsV1($dpdServicesParamsV1)
    {
        $new = clone $this;
        $new->dpdServicesParamsV1 = $dpdServicesParamsV1;

        return $new;
    }

    /**
     * @return string
     */
    public function getOutputDocFormatV1()
    {
        return $this->outputDocFormatV1;
    }

    /**
     * @param string $outputDocFormatV1
     * @return GenerateSpedLabelsV4
     */
    public function withOutputDocFormatV1($outputDocFormatV1)
    {
        $new = clone $this;
        $new->outputDocFormatV1 = $outputDocFormatV1;

        return $new;
    }

    /**
     * @return string
     */
    public function getOutputDocPageFormatV1()
    {
        return $this->outputDocPageFormatV1;
    }

    /**
     * @param string $outputDocPageFormatV1
     * @return GenerateSpedLabelsV4
     */
    public function withOutputDocPageFormatV1($outputDocPageFormatV1)
    {
        $new = clone $this;
        $new->outputDocPageFormatV1 = $outputDocPageFormatV1;

        return $new;
    }

    /**
     * @return string
     */
    public function getOutputLabelType()
    {
        return $this->outputLabelType;
    }

    /**
     * @param string $outputLabelType
     * @return GenerateSpedLabelsV4
     */
    public function withOutputLabelType($outputLabelType)
    {
        $new = clone $this;
        $new->outputLabelType = $outputLabelType;

        return $new;
    }

    /**
     * @return string
     */
    public function getLabelVariant()
    {
        return $this->labelVariant;
    }

    /**
     * @param string $labelVariant
     * @return GenerateSpedLabelsV4
     */
    public function withLabelVariant($labelVariant)
    {
        $new = clone $this;
        $new->labelVariant = $labelVariant;

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
     * @return GenerateSpedLabelsV4
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
