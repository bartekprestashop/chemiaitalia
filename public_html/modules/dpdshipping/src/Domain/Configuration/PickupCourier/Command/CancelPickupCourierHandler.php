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

namespace DpdShipping\Domain\Configuration\PickupCourier\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\DpdPickupCallParamsV3;
use DpdShipping\Api\DpdServices\Type\PackagesPickupCallV4;
use DpdShipping\Api\DpdServices\Type\PickupCallSimplifiedDetailsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupCustomerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPackagesParamsDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupPayerDPPV1;
use DpdShipping\Api\DpdServices\Type\PickupSenderDPPV1;
use DpdShipping\Repository\DpdshippingPickupCourierRepository;
use Psr\Log\LoggerInterface;
use stdClass;

class CancelPickupCourierHandler
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
    private $translator;

    public function __construct(DpdshippingPickupCourierRepository $repository, DpdApiService $dpdApiService, LoggerInterface $logger, $translator)
    {
        $this->repository = $repository;
        $this->dpdApiService = $dpdApiService;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * @throws \Exception
     */
    public function handle(CancelPickupCourierCommand $query)
    {
        try {

            $pickupCourierEntity = $this->repository->findOneBy(['id' => $query->getId()]);

            $dpdPickupCallParams = (new DpdPickupCallParamsV3())
                ->withOrderNumber($pickupCourierEntity->getOrderNumber())
                ->withCheckSum($pickupCourierEntity->getCheckSum())
                ->withOperationType("CANCEL");

            $request = new PackagesPickupCallV4($dpdPickupCallParams, $this->dpdApiService->getAuth());
            $result = $this->dpdApiService->getServicesClient()->packagesPickupCall($request);

            if ($result != null && $result->return != null && $result->return->statusInfo->status == "OK") {
                $this->repository->saveStatusCancel($pickupCourierEntity);
                return ['success' => true];
            }
            return ['success' => false, 'errors' => $this->getErrorMessages($result)];

        } catch (\Exception $e) {
            $this->logger->error('DPDSHIPPING: Error cancel pickup courier:' . $e->getMessage());
            $errorMessage = [$this->translator->trans('It is not possible to cancel the collection of a courier shipment', [], 'Modules.Dpdshipping.Admin')];

            return ['success' => false, 'errors' => $errorMessage];
        }
    }

    public function getErrorMessages($response): array
    {
        if (!isset($response) || !isset($response->return)) {
            return ['Unknown error'];
        }

        return [$response->return->statusInfo->errorDetails->description];

    }
}
