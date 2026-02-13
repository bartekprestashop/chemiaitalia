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

namespace DpdShipping\Domain\Tracking\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdInfoServices\Type\GetEventsForWaybillV1;
use DpdShipping\Config\Config;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;
use Exception;
use Psr\Log\LoggerInterface;
use TypeError;

class GetEventsForWaybillHandler
{
    public const EVENT_SELECT_ALL = 'ALL';
    private $dpdApiService;

    private $logger;
    /**
     * @var DpdshippingShippingHistoryRepository
     */
    private $dpdshippingShippingHistoryRepository;

    public function __construct(DpdApiService $dpdApiService, DpdshippingShippingHistoryRepository $dpdshippingShippingHistoryRepository)
    {
        $this->dpdApiService = $dpdApiService;
        $this->dpdshippingShippingHistoryRepository = $dpdshippingShippingHistoryRepository;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(GetEventsForWaybill $query): array
    {
        try {
            $shippingNumber = $query->getShippingNumber();

            if ($shippingNumber == null) {
                return [];
            }

            $response = $this->dpdApiService
                ->getInfoServicesClient()
                ->getEventsForWaybillV1(
                    new GetEventsForWaybillV1(
                        $shippingNumber,
                        GetEventsForWaybillHandler::EVENT_SELECT_ALL,
                        Config::PL_CONST,
                        $this->dpdApiService->getAuthInfoServices()
                    )
                );

            $mappedData = [];

            if ($response->return !== null && $response->return->eventsList != null) {
                if (is_array($response->return->eventsList)) {
                    foreach ($response->return->eventsList as $event) {
                        $eventData = [
                            'state' => $event->description,
                            'dateTime' => $event->eventTime,
                        ];
                        $mappedData[] = $eventData;
                    }
                } else {
                    $eventData = [
                        'state' => $response->return->eventsList->description,
                        'dateTime' => $response->return->eventsList->eventTime,
                    ];
                    $mappedData[] = $eventData;
                }
            }
            $this->dpdshippingShippingHistoryRepository->setStatus($shippingNumber, $mappedData);
            $shippingResult[] = [
                'shippingNumber' => $shippingNumber,
                'states' => $mappedData,
            ];
        } catch (TypeError $e) {
            $this->logger->error('DPDSHIPPING: Cannot get tracking ' . $e->getMessage());
            $shippingResult[] = [
                'shippingNumber' => $shippingNumber,
                'states' => [],
            ];
        } catch (Exception $e) {
            $this->logger->error('DPDSHIPPING: Cannot get tracking ' . $e->getMessage());
            $shippingResult[] = [
                'shippingNumber' => $shippingNumber,
                'states' => [],
            ];
        }

        return $shippingResult;
    }
}
