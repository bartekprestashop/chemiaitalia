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

class PackageOpenUMLFeV4
{
    /**
     * @var ParcelOpenUMLFeV1
     */
    private $parcels;

    /**
     * @var string
     */
    private $payerType;

    /**
     * @var PackageAddressOpenUMLFeV1
     */
    private $receiver;

    /**
     * @var string
     */
    private $ref1;

    /**
     * @var string
     */
    private $ref2;

    /**
     * @var string
     */
    private $ref3;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var PackageAddressOpenUMLFeV1
     */
    private $sender;

    /**
     * @var ServicesOpenUMLFeV5
     */
    private $services;

    /**
     * @var int
     */
    private $thirdPartyFID;

    /**
     * @return ParcelOpenUMLFeV1
     */
    public function getParcels()
    {
        return $this->parcels;
    }

    /**
     * @param ParcelOpenUMLFeV1 $parcels
     * @return PackageOpenUMLFeV4
     */
    public function withParcels($parcels)
    {
        $new = clone $this;
        $new->parcels = $parcels;

        return $new;
    }

    /**
     * @return string
     */
    public function getPayerType()
    {
        return $this->payerType;
    }

    /**
     * @param string $payerType
     * @return PackageOpenUMLFeV4
     */
    public function withPayerType($payerType)
    {
        $new = clone $this;
        $new->payerType = $payerType;

        return $new;
    }

    /**
     * @return PackageAddressOpenUMLFeV1
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param PackageAddressOpenUMLFeV1 $receiver
     * @return PackageOpenUMLFeV4
     */
    public function withReceiver($receiver)
    {
        $new = clone $this;
        $new->receiver = $receiver;

        return $new;
    }

    /**
     * @return string
     */
    public function getRef1()
    {
        return $this->ref1;
    }

    /**
     * @param string $ref1
     * @return PackageOpenUMLFeV4
     */
    public function withRef1($ref1)
    {
        $new = clone $this;
        $new->ref1 = $ref1;

        return $new;
    }

    /**
     * @return string
     */
    public function getRef2()
    {
        return $this->ref2;
    }

    /**
     * @param string $ref2
     * @return PackageOpenUMLFeV4
     */
    public function withRef2($ref2)
    {
        $new = clone $this;
        $new->ref2 = $ref2;

        return $new;
    }

    /**
     * @return string
     */
    public function getRef3()
    {
        return $this->ref3;
    }

    /**
     * @param string $ref3
     * @return PackageOpenUMLFeV4
     */
    public function withRef3($ref3)
    {
        $new = clone $this;
        $new->ref3 = $ref3;

        return $new;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return PackageOpenUMLFeV4
     */
    public function withReference($reference)
    {
        $new = clone $this;
        $new->reference = $reference;

        return $new;
    }

    /**
     * @return PackageAddressOpenUMLFeV1
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param PackageAddressOpenUMLFeV1 $sender
     * @return PackageOpenUMLFeV4
     */
    public function withSender($sender)
    {
        $new = clone $this;
        $new->sender = $sender;

        return $new;
    }

    /**
     * @return ServicesOpenUMLFeV5
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param ServicesOpenUMLFeV5 $services
     * @return PackageOpenUMLFeV4
     */
    public function withServices($services)
    {
        $new = clone $this;
        $new->services = $services;

        return $new;
    }

    /**
     * @return int
     */
    public function getThirdPartyFID()
    {
        return $this->thirdPartyFID;
    }

    /**
     * @param int $thirdPartyFID
     * @return PackageOpenUMLFeV4
     */
    public function withThirdPartyFID($thirdPartyFID)
    {
        $new = clone $this;
        $new->thirdPartyFID = $thirdPartyFID;

        return $new;
    }
}
