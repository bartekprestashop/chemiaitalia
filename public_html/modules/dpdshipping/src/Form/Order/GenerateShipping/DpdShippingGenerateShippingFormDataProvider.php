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

namespace DpdShipping\Form\Order\GenerateShipping;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\SenderAddress\Query\GetDefaultOrderSenderAddress;
use DpdShipping\Domain\Order\Query\GetDefaultOrderReceiverAddress;
use DpdShipping\Form\CommonFormDataProvider;
use Order;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\IdentifiableObject\DataProvider\FormDataProviderInterface;

class DpdShippingGenerateShippingFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData($id): array
    {
        $order = new Order($id);

        $senderAddress = $this->queryBus->handle(new GetDefaultOrderSenderAddress());
        $receiverAddress = $this->queryBus->handle(new GetDefaultOrderReceiverAddress($order));

        $ref1Source = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_REF1));
        $ref1SourceStatic = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_REF1_STATIC_VALUE));

        $ref2Source = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_REF2));
        $ref2SourceStatic = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_REF2_STATIC_VALUE));

        return [
            'sender_address_company' => $senderAddress['company'] ?? '',
            'sender_address_name' => $senderAddress['name'] ?? '',
            'sender_address_street' => $senderAddress['street'] ?? '',
            'sender_address_city' => $senderAddress['city'] ?? '',
            'sender_address_postcode' => $senderAddress['postcode'] ?? '',
            'sender_address_country' => $senderAddress['country'] ?? '',
            'sender_address_phone' => $senderAddress['phone'] ?? '',
            'sender_address_email' => $senderAddress['email'] ?? '',

            'receiver_address_company' => $receiverAddress['company'] ?? '',
            'receiver_address_name' => $receiverAddress['name'] ?? '',
            'receiver_address_street' => $receiverAddress['street'] ?? '',
            'receiver_address_city' => $receiverAddress['city'] ?? '',
            'receiver_address_postcode' => $receiverAddress['postcode'] ?? '',
            'receiver_address_country' => $receiverAddress['country'] ?? '',
            'receiver_address_phone' => $receiverAddress['phone'] ?? '',
            'receiver_address_email' => $receiverAddress['email'] ?? '',
            'packages' => [[]],
            'ref1' => self::getDynamicData($order, $ref1Source, $ref1SourceStatic),
            'ref2' => self::getDynamicData($order, $ref2Source, $ref2SourceStatic),
        ];
    }

    public function getDefaultData()
    {
    }

    public static function getDynamicData($order, $dataSource, $dataSourceStatic): string
    {
        if ($dataSource == null) {
            return '';
        }

        if ($dataSource->getValue() == 'STATIC_VALUE') {
            return $dataSourceStatic != null ? $dataSourceStatic->getValue() : '';
        } elseif ($dataSource->getValue() == 'ORDER_NUMBER') {
            return $order->reference;
        } elseif ($dataSource->getValue() == 'ORDER_ID') {
            return (string) $order->id;
        } elseif ($dataSource->getValue() == 'INVOICE_NUMBER') {
            return (string) $order->invoice_number;
        }

        return '';
    }
}
