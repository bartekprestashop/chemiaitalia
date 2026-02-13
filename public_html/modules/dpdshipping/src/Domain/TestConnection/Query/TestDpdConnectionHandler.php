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

namespace DpdShipping\Domain\TestConnection\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\AuthDataV1;
use DpdShipping\Api\DpdServices\Type\FindPostalCodeV1;
use DpdShipping\Api\DpdServices\Type\PostalCodeV1;
use Exception;

class TestDpdConnectionHandler
{
    private $dpdApiService;

    public function __construct(DpdApiService $dpdApiService)
    {
        $this->dpdApiService = $dpdApiService;
    }

    public function handle(TestDpdConnection $query)
    {
        try {
            $postalCode = (new PostalCodeV1())
                ->withCountryCode('PL')
                ->withZipCode('02274');

            $authData = (new AuthDataV1())
                ->withLogin($query->getLogin())
                ->withPassword($query->getPassword())
                ->withMasterFid($query->getMasterFid());

            $call = $this->dpdApiService->getServicesClientEnv($query->getEnvironment())->findPostalCodeV1(new FindPostalCodeV1($postalCode, $authData));

            return $call->return->status == 'OK';
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
