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

class GenerateShipmentV1
{
    /**
     * @var OpenUMLFeV10
     */
    private $openUMLFeV10;

    /**
     * @var string
     */
    private $pkgNumsGenerationPolicyV1;

    /**
     * @var string
     */
    private $langCode;

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
     * @var OpenUMLFeV10 $openUMLFeV10
     * @var string $pkgNumsGenerationPolicyV1
     * @var string $langCode
     * @var string $outputDocFormatV1
     * @var string $outputDocPageFormatV1
     * @var string $outputLabelType
     * @var string $labelVariant
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($openUMLFeV10, $pkgNumsGenerationPolicyV1, $langCode, $outputDocFormatV1, $outputDocPageFormatV1, $outputLabelType, $labelVariant, $authDataV1)
    {
        $this->openUMLFeV10 = $openUMLFeV10;
        $this->pkgNumsGenerationPolicyV1 = $pkgNumsGenerationPolicyV1;
        $this->langCode = $langCode;
        $this->outputDocFormatV1 = $outputDocFormatV1;
        $this->outputDocPageFormatV1 = $outputDocPageFormatV1;
        $this->outputLabelType = $outputLabelType;
        $this->labelVariant = $labelVariant;
        $this->authDataV1 = $authDataV1;
    }

    /**
     * @return OpenUMLFeV10
     */
    public function getOpenUMLFeV10()
    {
        return $this->openUMLFeV10;
    }

    /**
     * @param OpenUMLFeV10 $openUMLFeV10
     * @return GenerateShipmentV1
     */
    public function withOpenUMLFeV10($openUMLFeV10)
    {
        $new = clone $this;
        $new->openUMLFeV10 = $openUMLFeV10;

        return $new;
    }

    /**
     * @return string
     */
    public function getPkgNumsGenerationPolicyV1()
    {
        return $this->pkgNumsGenerationPolicyV1;
    }

    /**
     * @param string $pkgNumsGenerationPolicyV1
     * @return GenerateShipmentV1
     */
    public function withPkgNumsGenerationPolicyV1($pkgNumsGenerationPolicyV1)
    {
        $new = clone $this;
        $new->pkgNumsGenerationPolicyV1 = $pkgNumsGenerationPolicyV1;

        return $new;
    }

    /**
     * @return string
     */
    public function getLangCode()
    {
        return $this->langCode;
    }

    /**
     * @param string $langCode
     * @return GenerateShipmentV1
     */
    public function withLangCode($langCode)
    {
        $new = clone $this;
        $new->langCode = $langCode;

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
     * @return GenerateShipmentV1
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
     * @return GenerateShipmentV1
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
     * @return GenerateShipmentV1
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
     * @return GenerateShipmentV1
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
     * @return GenerateShipmentV1
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
