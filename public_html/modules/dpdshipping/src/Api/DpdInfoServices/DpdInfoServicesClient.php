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

namespace DpdShipping\Api\DpdInfoServices;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiHelper;
use DpdShipping\Api\DpdInfoServices\Type\GetEventsForWaybillV1;

class DpdInfoServicesClient
{
    private $soapClient;
    private $eventDispatcher;

    public function __construct(\SoapClient $soapClient, $eventDispatcher)
    {
        $this->soapClient = $soapClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getEventsForWaybillV1(GetEventsForWaybillV1 $parameters)
    {
        return $this->soapCall('getEventsForWaybillV1', $parameters);
    }

    /**
     * @throws \Exception
     */
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
