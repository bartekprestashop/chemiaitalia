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

class GeneratePackagesNumbersV8
{
    /**
     * @var OpenUMLFeV9
     */
    private $openUMLFeV9;

    /**
     * @var string
     */
    private $pkgNumsGenerationPolicyV1;

    /**
     * @var string
     */
    private $langCode;

    /**
     * @var AuthDataV1
     */
    private $authDataV1;

    /**
     * Constructor
     *
     * @var OpenUMLFeV9 $openUMLFeV9
     * @var string $pkgNumsGenerationPolicyV1
     * @var string $langCode
     * @var AuthDataV1 $authDataV1
     */
    public function __construct($openUMLFeV9, $pkgNumsGenerationPolicyV1, $langCode, $authDataV1)
    {
        $this->openUMLFeV9 = $openUMLFeV9;
        $this->pkgNumsGenerationPolicyV1 = $pkgNumsGenerationPolicyV1;
        $this->langCode = $langCode;
        $this->authDataV1 = $authDataV1;
    }

    /**
     * @return OpenUMLFeV9
     */
    public function getOpenUMLFeV9()
    {
        return $this->openUMLFeV9;
    }

    /**
     * @param OpenUMLFeV9 $openUMLFeV9
     * @return GeneratePackagesNumbersV8
     */
    public function withOpenUMLFeV9($openUMLFeV9)
    {
        $new = clone $this;
        $new->openUMLFeV9 = $openUMLFeV9;

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
     * @return GeneratePackagesNumbersV8
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
     * @return GeneratePackagesNumbersV8
     */
    public function withLangCode($langCode)
    {
        $new = clone $this;
        $new->langCode = $langCode;

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
     * @return GeneratePackagesNumbersV8
     */
    public function withAuthDataV1($authDataV1)
    {
        $new = clone $this;
        $new->authDataV1 = $authDataV1;

        return $new;
    }
}
