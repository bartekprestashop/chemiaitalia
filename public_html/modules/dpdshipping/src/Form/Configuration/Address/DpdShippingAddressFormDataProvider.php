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

namespace DpdShipping\Form\Configuration\Address;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\Configuration\SenderAddress\Command\AddSenderAddressCommand;
use DpdShipping\Domain\Configuration\SenderAddress\Query\GetSenderAddress;
use DpdShipping\Entity\DpdshippingSenderAddress;
use DpdShipping\Form\CommonFormDataProvider;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use Tools;

class DpdShippingAddressFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus)
    {
        parent::__construct($queryBus, $commandBus);
    }

    public function getData(): array
    {
        $senderAddressId = Tools::getValue('senderAddressId');
        $senderAddress = $this->queryBus->handle(new GetSenderAddress($senderAddressId));
        if (!isset($senderAddress)) {
            return [];
        }

        return [
            'senderAddressId' => $senderAddressId,
            'alias' => $senderAddress->getAlias(),
            'company' => $senderAddress->getCompany(),
            'name' => $senderAddress->getName(),
            'street' => $senderAddress->getStreet(),
            'city' => $senderAddress->getCity(),
            'country' => $senderAddress->getCountryCode(),
            'postcode' => $senderAddress->getPostalCode(),
            'mail' => $senderAddress->getMail(),
            'phone' => $senderAddress->getPhone(),
            'isDefault' => $senderAddress->isDefault() ?? false,
        ];
    }

    public function setData(array $data): array
    {
        $entity = new DpdshippingSenderAddress();
        if (isset($data['senderAddressId'])) {
            $entity
                ->setId((int) $data['senderAddressId']);
        }
        $entity
            ->setAlias($data['alias'])
            ->setCompany($data['company'])
            ->setName($data['name'])
            ->setStreet($data['street'])
            ->setCity($data['city'])
            ->setCountryCode($data['country'])
            ->setPostalCode($data['postcode'])
            ->setMail($data['mail'])
            ->setPhone($data['phone'])
            ->setIsDefault($data['isDefault'] ?? false);

        $this->queryBus->handle(new AddSenderAddressCommand($entity));

        return [];
    }
}
