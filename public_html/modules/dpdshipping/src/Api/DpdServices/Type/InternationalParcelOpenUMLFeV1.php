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

class InternationalParcelOpenUMLFeV1
{
    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $weight;

    /**
     * @var string
     */
    private $sizeX;

    /**
     * @var string
     */
    private $sizeY;

    /**
     * @var string
     */
    private $sizeZ;

    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $customerData1;

    /**
     * @var string
     */
    private $customerData2;

    /**
     * @var string
     */
    private $customerData3;

    /**
     * @var string
     */
    private $weightAdr;

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withReference($reference)
    {
        $new = clone $this;
        $new->reference = $reference;

        return $new;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withWeight($weight)
    {
        $new = clone $this;
        $new->weight = $weight;

        return $new;
    }

    /**
     * @return string
     */
    public function getSizeX()
    {
        return $this->sizeX;
    }

    /**
     * @param string $sizeX
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withSizeX($sizeX)
    {
        $new = clone $this;
        $new->sizeX = $sizeX;

        return $new;
    }

    /**
     * @return string
     */
    public function getSizeY()
    {
        return $this->sizeY;
    }

    /**
     * @param string $sizeY
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withSizeY($sizeY)
    {
        $new = clone $this;
        $new->sizeY = $sizeY;

        return $new;
    }

    /**
     * @return string
     */
    public function getSizeZ()
    {
        return $this->sizeZ;
    }

    /**
     * @param string $sizeZ
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withSizeZ($sizeZ)
    {
        $new = clone $this;
        $new->sizeZ = $sizeZ;

        return $new;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withContent($content)
    {
        $new = clone $this;
        $new->content = $content;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerData1()
    {
        return $this->customerData1;
    }

    /**
     * @param string $customerData1
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withCustomerData1($customerData1)
    {
        $new = clone $this;
        $new->customerData1 = $customerData1;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerData2()
    {
        return $this->customerData2;
    }

    /**
     * @param string $customerData2
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withCustomerData2($customerData2)
    {
        $new = clone $this;
        $new->customerData2 = $customerData2;

        return $new;
    }

    /**
     * @return string
     */
    public function getCustomerData3()
    {
        return $this->customerData3;
    }

    /**
     * @param string $customerData3
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withCustomerData3($customerData3)
    {
        $new = clone $this;
        $new->customerData3 = $customerData3;

        return $new;
    }

    /**
     * @return string
     */
    public function getWeightAdr()
    {
        return $this->weightAdr;
    }

    /**
     * @param string $weightAdr
     * @return InternationalParcelOpenUMLFeV1
     */
    public function withWeightAdr($weightAdr)
    {
        $new = clone $this;
        $new->weightAdr = $weightAdr;

        return $new;
    }
}
