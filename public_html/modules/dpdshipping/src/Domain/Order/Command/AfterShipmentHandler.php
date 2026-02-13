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

namespace DpdShipping\Domain\Order\Command;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Carrier;
use Customer;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use Hook;
use Mail;
use Order;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Translation\TranslatorInterface;
use Psr\Log\LoggerInterface;

class AfterShipmentHandler
{
    private $logger;
    /**
     * @var CommandBusInterface
     */
    private $commandBus;
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(CommandBusInterface $commandBus, TranslatorInterface $translator)
    {
        $this->commandBus = $commandBus;
        $this->translator = $translator;
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function handle(AfterShipmentCommand $command)
    {
        $sendEmail = $this->commandBus->handle(new GetConfiguration(Configuration::SEND_MAIL_WHEN_SHIPPING_GENERATED));

        $order = new Order((int) $command->getIdOrder());
        $customer = new Customer($order->id_customer);
        $carrier = new Carrier($order->id_carrier);

        Hook::exec('actionAdminOrdersTrackingNumberUpdate', ['order' => $order, 'customer' => $customer, 'carrier' => $carrier]);

        if ($sendEmail != null && $sendEmail->getValue() == '1') {
            $templateVars = [
                '{followup}' => str_replace('@', $command->getMainWaybill(), $carrier->url),
                '{firstname}' => $customer->firstname,
                '{lastname}' => $customer->lastname,
                '{id_order}' => $order->id,
                '{shipping_number}' => $command->getMainWaybill(),
                '{order_name}' => $order->getUniqReference(),
                '{meta_products}' => '',
            ];

            if (!@Mail::Send(
                $order->id_lang,
                'in_transit',
                $this->translator->trans('Package in transit', [], 'Admin.Dpdshipping.Email'),
                $templateVars,
                $customer->email,
                $customer->firstname . ' ' . $customer->lastname,
                null,
                null,
                null,
                null,
                _PS_MAIL_DIR_,
                false,
                (int) $order->id_shop
            )) {
                $this->logger->info('DPDSHIPPING: The email has been sent ' . $command->getMainWaybill());
            } else {
                $this->logger->error('DPDSHIPPING: Cannot send email after shimpent' . $command->getMainWaybill());
            }
        }

        return true;
    }
}
