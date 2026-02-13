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

namespace DpdShipping\Api;

if (!defined('_PS_VERSION_')) {
    exit;
}
class DpdApiHelper
{
    private $dpdApiClient;

    public function __construct($dpdApiClient)
    {
        $this->dpdApiClient = $dpdApiClient;
    }

    public function objectToArray($obj)
    {
        if (is_object($obj)) {
            $reflect = new \ReflectionClass($obj);
            $props = $reflect->getProperties();
            $arr = [];
            foreach ($props as $prop) {
                $prop->setAccessible(true);
                $arr[$prop->getName()] = $this->objectToArray($prop->getValue($obj));
            }

            return $arr;
        }

        if (is_array($obj)) {
            return array_map([$this->dpdApiClient, 'objectToArray'], $obj);
        }

        return $obj;
    }
}
