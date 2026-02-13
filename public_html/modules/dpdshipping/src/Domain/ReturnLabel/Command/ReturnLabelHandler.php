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

namespace DpdShipping\Domain\ReturnLabel\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Api\DpdApiService;
use DpdShipping\Api\DpdServices\Type\GenerateDomesticReturnLabelV1;
use DpdShipping\Api\DpdServices\Type\GenerateReturnLabelV1;
use DpdShipping\Api\DpdServices\Type\PudoReturnReceiver;
use DpdShipping\Api\DpdServices\Type\ReturnedWaybillsV1;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Order\Query\GetCountryIsoCode;
use DpdShipping\Repository\DpdshippingShippingHistoryRepository;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use Psr\Log\LoggerInterface;

class ReturnLabelHandler
{
    private $dpdApiService;
    /**
     * @var DpdshippingShippingHistoryRepository
     */
    private $dpdshippingShippingHistoryRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var CommandBusInterface
     */
    private $commandBus;

    public function __construct(
        DpdApiService $dpdApiService,
        DpdshippingShippingHistoryRepository $dpdshippingShippingHistoryRepository,
        CommandBusInterface $commandBus
    ) {
        $this->dpdApiService = $dpdApiService;
        $this->dpdshippingShippingHistoryRepository = $dpdshippingShippingHistoryRepository;
        $this->commandBus = $commandBus;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(ReturnLabelCommand $command)
    {
        $this->logger->info('DPDSHIPPING: Generate return label for: ' . $command->getWaybill());

        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($command->getCountryCode()));
        if ($countryIsoCode != Config::PL_CONST) {
            $call = $this->dpdApiService
                ->getServicesClient()
                ->generateReturnLabelV1($this->getReturnLabelV1($command));
        } else {
            $call = $this->dpdApiService
                ->getServicesClient()
                ->generateDomesticReturnLabelV1($this->getDomesticReturnLabelV1($command));
        }

        if ($call->return != null && $call->return->session->statusInfo->status == 'OK') {
            return [
                'status' => 'OK',
                'data' => $call->return,
            ];
        }

        return [
            'status' => 'ERROR',
            'data' => $this->getErrorMessages($call->return),
        ];
    }

    /**
     * @param ReturnLabelCommand $command
     * @param string $outputDocPageFormatV1
     * @return GenerateDomesticReturnLabelV1
     */
    public function getDomesticReturnLabelV1(ReturnLabelCommand $command): GenerateDomesticReturnLabelV1
    {
        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($command->getCountryCode()));

        return new GenerateDomesticReturnLabelV1(
            (new ReturnedWaybillsV1())
                ->withWaybill($command->getWaybill()),
            (new PudoReturnReceiver())
                ->withCompany($command->getCompany())
                ->withName($command->getName())
                ->withAddress($command->getStreet())
                ->withPostalCode($command->getPostalCode())
                ->withCountryCode($countryIsoCode)
                ->withCity($command->getCity())
                ->withEmail($command->getEmail())
                ->withPhone($command->getPhone()),
            'PDF',
            'A4',
            'RETURN',
            '',
            $this->dpdApiService->getAuth()
        );
    }

    public function getReturnLabelV1(ReturnLabelCommand $command): GenerateReturnLabelV1
    {
        $countryIsoCode = $this->commandBus->handle(new GetCountryIsoCode($command->getCountryCode()));

        return new GenerateReturnLabelV1(
            (new ReturnedWaybillsV1())
                ->withWaybill($command->getWaybill()),
            (new PudoReturnReceiver())
                ->withCompany($command->getCompany())
                ->withName($command->getName())
                ->withAddress($command->getStreet())
                ->withPostalCode($command->getPostalCode())
                ->withCountryCode($countryIsoCode)
                ->withCity($command->getCity())
                ->withEmail($command->getEmail())
                ->withPhone($command->getPhone()),
            'PDF',
            'A4',
            'RETURN',
            '',
            $this->dpdApiService->getAuth()
        );
    }

    public function getErrorMessages($response): array
    {
        if (!isset($response) && $response->session != null) {
            return [];
        }

        return [$response->session->statusInfo->description];
    }
}
