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

declare(strict_types=1);

namespace DpdShipping\Form\PickupCourier;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\PickupCourierSettings\Query\GetPickupCourierSettingsList;
use DpdShipping\Form\CommonFormDataProvider;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingPickupCourierEditFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {

        return [];
    }

    public function getSenderAddress()
    {
        $senderAddresses = $this->queryBus->handle(new GetPickupCourierSettingsList(true));

        $result = [];
        foreach ($senderAddresses as $senderAddress) {
            $label = implode(' ', [
                $senderAddress->getCustomerFullName(),
                $senderAddress->getCustomerName(),
                $senderAddress->getCustomerPhone(),
                $senderAddress->getPayerNumber(),
                $senderAddress->getSenderAddress(),
                $senderAddress->getSenderCity(),
                $senderAddress->getSenderFullName(),
                $senderAddress->getSenderName(),
                $senderAddress->getSenderPhone(),
                $senderAddress->getSenderPostalCode(),
                $senderAddress->getSenderCountryCode(),

            ]);
            $result[$label] = $senderAddress->getId();
        }

        return $result;
    }

    public function setData(array $data): array
    {
        return [];
    }
}
