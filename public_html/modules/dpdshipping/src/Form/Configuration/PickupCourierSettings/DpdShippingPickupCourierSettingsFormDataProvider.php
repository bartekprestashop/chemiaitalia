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

namespace DpdShipping\Form\Configuration\PickupCourierSettings;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\PickupCourierSettings\Command\AddPickupOrderSettingsCommand;
use DpdShipping\Domain\Configuration\PickupCourierSettings\Query\GetPickupCourierSettingsList;
use DpdShipping\Entity\DpdshippingPickupCourierSettings;
use DpdShipping\Form\CommonFormDataProvider;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use Tools;

class DpdShippingPickupCourierSettingsFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $pickupCourierId = Tools::getValue('pickupCourierId');

        $pickupCourier = $this->queryBus->handle(new GetPickupCourierSettingsList(false, $pickupCourierId ?: "0"));

        if (!isset($pickupCourier) || $pickupCourier == null) {
            return [];
        }

        return [
            'pickupCourierId' => $pickupCourierId,
            'customer_full_name' => $pickupCourier->getCustomerFullName(),
            'customer_name' => $pickupCourier->getCustomerName(),
            'customer_phone' => $pickupCourier->getCustomerPhone(),
            'payer_number' => $pickupCourier->getPayerNumber(),
            'sender_address' => $pickupCourier->getSenderAddress(),
            'sender_city' => $pickupCourier->getSenderCity(),
            'sender_full_name' => $pickupCourier->getSenderFullName(),
            'sender_name' => $pickupCourier->getSenderName(),
            'sender_phone' => $pickupCourier->getSenderPhone(),
            'sender_postal_code' => $pickupCourier->getSenderPostalCode(),
            'sender_country_code' => $pickupCourier->getSenderCountryCode(),
        ];
    }

    public function setData(array $data): array
    {
        $entity = new DpdshippingPickupCourierSettings();
        if (isset($data['pickupCourierId'])) {
            $entity
                ->setId((int)$data['pickupCourierId']);
        }
        $entity
            ->setCustomerName($data['customer_name'])
            ->setCustomerFullName($data['customer_full_name'])
            ->setCustomerPhone($data['customer_phone'])
            ->setPayerNumber($data['payer_number'])
            ->setSenderFullName($data['sender_full_name'])
            ->setSenderName($data['sender_name'])
            ->setSenderAddress($data['sender_address'])
            ->setSenderCity($data['sender_city'])
            ->setSenderPhone($data['sender_phone'])
            ->setSenderPostalCode($data['sender_postal_code'])
            ->setSenderCountryCode($data['sender_country_code']);

        $this->queryBus->handle(new AddPickupOrderSettingsCommand($entity));

        return [];
    }
}
