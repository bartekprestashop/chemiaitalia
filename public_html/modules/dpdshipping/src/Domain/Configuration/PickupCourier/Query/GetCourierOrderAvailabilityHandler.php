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

namespace DpdShipping\Domain\Configuration\PickupCourier\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\DpdPickupCallParamsV3;
use DpdShipping\Api\DpdServices\Type\GetCourierOrderAvailabilityV1;
use DpdShipping\Api\DpdServices\Type\PackagesPickupCallV4;
use DpdShipping\Api\DpdServices\Type\PickupCallSimplifiedDetailsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupCustomerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPackagesParamsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPayerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupSenderDPPV1;
use DpdShipping\Repository\DpdshippingPickupCourierRepository;
use Exception;
use Psr\Log\LoggerInterface;
use stdClass;

class GetCourierOrderAvailabilityHandler
{
    /**
     * @var DpdshippingPickupCourierRepository
     */
    private $repository;
    /**
     * @var DpdApiService
     */
    private $dpdApiService;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(DpdshippingPickupCourierRepository $repository, DpdApiService $dpdApiService, LoggerInterface $logger)
    {
        $this->repository = $repository;
        $this->dpdApiService = $dpdApiService;
        $this->logger = $logger;
    }

    /**
     * @throws Exception
     */
    public function handle(GetCourierOrderAvailability $query)
    {
        $result = $this->dpdApiService->getServicesClient()
            ->getCourierOrderAvailability(new GetCourierOrderAvailabilityV1($query->getSenderPlace(), $this->dpdApiService->getAuth()));

        if (isset($result->return->ranges)) {
            if (is_array($result->return->ranges)) {
                return ['success' => true, 'data' => $result->return->ranges];
            } else {
                return ['success' => true, 'data' => array(
                    [
                        'offset' => $result->return->ranges->offset,
                        'range' => $result->return->ranges->range
                    ])
                ];
            }
        } else {
            return ['success' => false, 'errors' => $this->getErrorMessages($result)];
        }
    }

    public function getErrorMessages($response): array
    {
        if (!isset($response) || !isset($response->return)) {
            return ['Unknown error'];
        }
        return [$response->return->status];
    }

}
