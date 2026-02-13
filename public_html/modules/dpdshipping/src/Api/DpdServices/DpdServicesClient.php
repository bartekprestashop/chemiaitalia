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

namespace DpdShipping\Api\DpdServices;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiHelper;
use DpdShipping\Api\DpdServices\Type\FindPostalCodeV1;
use DpdShipping\Api\DpdServices\Type\GenerateDomesticReturnLabelV1;
use DpdShipping\Api\DpdServices\Type\GeneratePackagesNumbersV9;
use DpdShipping\Api\DpdServices\Type\GenerateProtocolV2;
use DpdShipping\Api\DpdServices\Type\GenerateReturnLabelV1;
use DpdShipping\Api\DpdServices\Type\GenerateSpedLabelsV4;
use DpdShipping\Api\DpdServices\Type\GetCourierOrderAvailabilityV1;
use DpdShipping\Api\DpdServices\Type\PackagesPickupCallV4;

class DpdServicesClient
{
    private $soapClient;
    private $eventDispatcher;

    public function __construct(\SoapClient $soapClient, $eventDispatcher)
    {
        $this->soapClient = $soapClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @throws \Exception
     */
    public function generateProtocolV2(GenerateProtocolV2 $parameters)
    {
        return $this->soapCall('generateProtocolV2', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function generateDomesticReturnLabelV1(GenerateDomesticReturnLabelV1 $parameters)
    {
        return $this->soapCall('generateDomesticReturnLabelV1', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function generateSpedLabelsV4(GenerateSpedLabelsV4 $parameters)
    {
        return $this->soapCall('generateSpedLabelsV4', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function generatePackagesNumbersV9(GeneratePackagesNumbersV9 $parameters)
    {
        return $this->soapCall('generatePackagesNumbersV9', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function findPostalCodeV1(FindPostalCodeV1 $parameters)
    {
        return $this->soapCall('findPostalCodeV1', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function generateReturnLabelV1(GenerateReturnLabelV1 $parameters)
    {
        return $this->soapCall('generateReturnLabelV1', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function getCourierOrderAvailability(GetCourierOrderAvailabilityV1 $parameters)
    {
        return $this->soapCall('getCourierOrderAvailabilityV1', $parameters);
    }

    /**
     * @throws \Exception
     */
    public function packagesPickupCall(PackagesPickupCallV4 $parameters)
    {
        return $this->soapCall('packagesPickupCallV4', $parameters);
    }

    private function soapCall($name, $parameters)
    {
        try {
            $arrayRequest = $this->objectToArray($parameters);
            return $this->soapClient->__soapCall($name, [$arrayRequest]);
        } catch (\SoapFault $fault) {
            throw new \Exception("SOAP Fault: {$fault->faultcode}, {$fault->faultstring}");
        }
    }

    public function objectToArray($obj)
    {
        $dpdApiUtils = new DpdApiHelper($this);

        return $dpdApiUtils->objectToArray($obj);
    }
}
