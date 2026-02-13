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

namespace DpdShipping\Form\Configuration\Onboarding;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Carrier\DpdCarrier;
use DpdShipping\Domain\Configuration\Carrier\Query\GetCarrier;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\Payer\Command\AddPayerCommand;
use DpdShipping\Domain\Configuration\Payer\Query\GetDefaultPayer;
use DpdShipping\Domain\Configuration\SenderAddress\Command\AddSenderAddressCommand;
use DpdShipping\Domain\Configuration\SenderAddress\Query\GetSenderAddressList;
use DpdShipping\Domain\TestConnection\Query\TestDpdConnection;
use DpdShipping\Entity\DpdshippingPayer;
use DpdShipping\Entity\DpdshippingSenderAddress;
use DpdShipping\Form\CommonFormDataProvider;
use DpdShipping\Util\ArrayUtil;
use PhpEncryption;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

class DpdShippingOnboardingFormDataProvider extends CommonFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var DpdCarrier
     */
    private $dpdCarrier;

    public function __construct(CommandBusInterface $queryBus, CommandBusInterface $commandBus, DpdCarrier $dpdCarrier)
    {
        parent::__construct($queryBus, $commandBus);
        $this->dpdCarrier = $dpdCarrier;
    }

    public function getData(): array
    {
        $return = [
            $this->loadField('login', Configuration::DPD_API_LOGIN),
            $this->loadField('masterfid', Configuration::DPD_API_MASTER_FID),
            $this->loadField('environment', Configuration::DPD_API_ENVIRONMENT),
        ];

        $defaultPayer = $this->queryBus->handle(new GetDefaultPayer());
        if (isset($defaultPayer)) {
            $return[] = ['defaultFidNumber' => $defaultPayer->getFid()];
        }

        $senderAddress = $this->getSenderAddress();

        if (isset($senderAddress)) {
            $return[] = [
                'senderAddressId' => $senderAddress->getId(),
                'alias' => $senderAddress->getAlias(),
                'company' => $senderAddress->getCompany(),
                'name' => $senderAddress->getName(),
                'street' => $senderAddress->getStreet(),
                'city' => $senderAddress->getCity(),
                'country' => $senderAddress->getCountryCode(),
                'postcode' => $senderAddress->getPostalCode(),
                'mail' => $senderAddress->getMail(),
                'phone' => $senderAddress->getPhone(),
            ];
        }

        $standardCarrier = $this->queryBus->handle(new GetCarrier(Config::DPD_STANDARD));
        $standardCodCarrier = $this->queryBus->handle(new GetCarrier(Config::DPD_STANDARD_COD));
        $pickupCarrier = $this->queryBus->handle(new GetCarrier(Config::DPD_PICKUP));
        $pickupCodCarrier = $this->queryBus->handle(new GetCarrier(Config::DPD_PICKUP_COD));

        $return[] = [
            'carrierDpdPoland' => isset($standardCarrier) && $standardCarrier !== false,
            'carrierDpdPolandCod' => isset($standardCodCarrier) && $standardCodCarrier !== false,
            'carrierDpdPolandPickup' => isset($pickupCarrier) && $pickupCarrier !== false,
            'carrierDpdPolandPickupCod' => isset($pickupCodCarrier) && $pickupCodCarrier !== false,
        ];

        return ArrayUtil::flatArray($return);
    }

    public function setData(array $data): array
    {
        $errors = [];

        $testConnection = $this->queryBus->handle(new TestDpdConnection($data['login'], $data['password'], $data['masterfid'], $data['environment']));

        if ($testConnection !== true) {
            $errors[] = $testConnection;

            return $errors;
        }

        $phpEncryption = new PhpEncryption(_NEW_COOKIE_KEY_);

        $this->saveConfiguration(Configuration::DPD_API_LOGIN, $data['login']);
        $this->saveConfiguration(Configuration::DPD_API_PASSWORD, $phpEncryption->encrypt($data['password']));
        $this->saveConfiguration(Configuration::DPD_API_MASTER_FID, $data['masterfid']);
        $this->saveConfiguration(Configuration::DPD_API_ENVIRONMENT, $data['environment']);

        $payer = new DpdshippingPayer();
        $payer
            ->setName('FID')
            ->setFid((string) $data['defaultFidNumber'])
            ->setDefault(true);

        $this->commandBus->handle(new AddPayerCommand([$payer]));
        $this->saveConfiguration(Configuration::DEFAULT_PARAM_WEIGHT, 1.0);

        $this->setSenderAddress($data);

        $this->dpdCarrier->handleCarrier(Config::DPD_STANDARD, 'DPD Poland', $data['carrierDpdPoland']);
        $this->dpdCarrier->handleCarrier(Config::DPD_STANDARD_COD, 'DPD Poland - COD', $data['carrierDpdPolandCod']);
        $this->dpdCarrier->handleCarrier(Config::DPD_PICKUP, 'DPD Poland - Pickup', $data['carrierDpdPolandPickup']);
        $this->dpdCarrier->handleCarrier(Config::DPD_PICKUP_COD, 'DPD Poland - Pickup COD', $data['carrierDpdPolandPickupCod']);

        $this->saveConfiguration(Configuration::NEED_ONBOARDING, '0');

        return $errors;
    }

    private function getSenderAddress(): ?DpdshippingSenderAddress
    {
        $senderAddressList = $this->queryBus->handle(new GetSenderAddressList(true));
        if (isset($senderAddressList) && count($senderAddressList) > 0 && $senderAddressList[0]->isDefault()) {
            return $senderAddressList[0];
        }

        return null;
    }

    private function setSenderAddress(array $data)
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
            ->setIsDefault(true);

        $this->queryBus->handle(new AddSenderAddressCommand($entity));
    }
}
