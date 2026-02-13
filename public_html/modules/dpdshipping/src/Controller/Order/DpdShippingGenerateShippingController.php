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

namespace DpdShipping\Controller\Order;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Currency;
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Carrier\Query\GetCodPaymentModulesHandler;
use DpdShipping\Domain\Configuration\Carrier\Query\GetOrderCarrier;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\Payer\Query\GetPayerList;
use DpdShipping\Domain\Configuration\SenderAddress\Query\GetOrderSenderAddressList;
use DpdShipping\Domain\Order\Command\AddDpdOrderCommand;
use DpdShipping\Domain\Order\Query\GetOrderPudoCode;
use DpdShipping\Domain\Order\Query\GetReceiverAddressList;
use Module;
use Order;
use PrestaShop\PrestaShop\Adapter\Validate;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class DpdShippingGenerateShippingController extends FrameworkBundleAdminController
{
    private $textFormDataHandler;
    private $commandBus;
    private $twig;
    private $translator;

    public function __construct($textFormDataHandler, $commandBus, $twig, $translator)
    {
        parent::__construct();
        $this->textFormDataHandler = $textFormDataHandler;
        $this->commandBus = $commandBus;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function index($params, Request $request = null)
    {
        $successMsg = '';
        $errors = [];

        $commandBus = $this->commandBus;

        if ($request == null) {
            $request = Request::createFromGlobals();
            $orderId = $params['id_order'];
        } else {
            $orderId = (int) $request->get('orderId');
        }

        $payerList = $commandBus->handle(new GetPayerList(true));
        $payerNumberList = [];

        foreach ($payerList as $payer) {
            $payerNumberList[$payer->getName() . ' - ' . $payer->getFid()] = $payer->getFid();
        }

        $order = new Order($orderId);
        $dpdCarrier = $commandBus->handle(new GetOrderCarrier($order));

        $currency_from = new Currency($order->id_currency);

        $orderPickupNumber = '';
        if ($this->isPickup($dpdCarrier)) {
            $orderPickupNumber = $commandBus->handle(new GetOrderPudoCode($order->id_shop, $order->id_cart));
        }

        $dpdCarrierType = isset($dpdCarrier['dpd_carrier']) ? $dpdCarrier['dpd_carrier']->getType() : '';

        $textForm = $this->textFormDataHandler->getFormFor($orderId, [], [
            'payer_number_list' => $payerNumberList,
            'dpd_carrier' => $dpdCarrierType,
            'is_dpd_carrier' => !empty($dpdCarrierType) && substr($dpdCarrierType, 0, 3) === "DPD",
            'order_currency' => $currency_from->iso_code,
            'order_amount' => $order->total_paid_tax_incl,
            'order_pickup_number' => $orderPickupNumber,
        ]);

        if ($request != null) {
            $textForm->handleRequest($request);
        }

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $generateShippingResult = $commandBus->handle(new AddDpdOrderCommand($orderId, $textForm->getData(), $dpdCarrier));

            if (empty($generateShippingResult['errors'])) {
                $successMsg = $this->translator->trans('The shipment has been generated: %waybills%', ['%waybills%' => $this->getWaybills($generateShippingResult)], 'Admin.Notifications.Success');

                return $this->twig->render('@Modules/dpdshipping/views/templates/admin/order/generate-shipping-success.html.twig', [
                    'form' => [],
                    'successMsg' => $successMsg,
                    'errorMsg' => '',
                    'isShippingGenerated' => true,
                    'showReturnLabel' => $this->isReturnLabel($textForm->getData()),
                    'orderId' => $orderId,
                    'shippingHistoryId' => $this->getShippingHistoryId($generateShippingResult),
                ]);
            } else {
                $errors = $generateShippingResult['errors'];
            }
        }

        $orderDetails = $order->getOrderDetailList();
        $products = [];

        $contentSource = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_CONTENT));
        $contentSourceStatic = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_CONTENT_STATIC_VALUE));
        $customerDataSource = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_CUSTOMER_DATA));
        $customerDataSourceStatic = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_CUSTOMER_DATA_STATIC_VALUE));

        foreach ($orderDetails as $orderDetail) {
            $products[] = [
                'product_id' => $orderDetail['product_id'],
                'product_name' => $orderDetail['product_name'],
                'product_quantity' => $orderDetail['product_quantity'],
                'product_weight' => $orderDetail['product_weight'],
                'product_reference' => $orderDetail['product_reference'],
            ];
        }

        $senderAddressList = $commandBus->handle(new GetOrderSenderAddressList());
        $receiverAddressList = $commandBus->handle(new GetReceiverAddressList($order, true));
        $packageGroupWay = $commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PACKAGE_GROUPING_WAY));

        $isCodPayment = $this->isCodPayment($commandBus, $order);
        $defaultWeight = $this->commandBus->handle(new GetConfiguration(Configuration::DEFAULT_PARAM_WEIGHT));

        $result = [
            'form' => $textForm->createView(),
            'successMsg' => $successMsg,
            'errors' => empty($errors) ? [] : $errors,
            'products' => $products,
            'receiver_address_list' => $receiverAddressList,
            'sender_address_list' => $senderAddressList,
            'dpd_carrier' => $dpdCarrier['carrier'] ?? '',
            'is_dpd_carrier' => !empty($dpdCarrierType) && substr($dpdCarrierType, 0, 3) === "DPD",
            'package_group_type' => $packageGroupWay != null ? $packageGroupWay->getValue() : 'single',
            'is_cod_payment' => $isCodPayment,
            'payment_method' => $this->getPaymentMethodDisplayName($order->module),
            'content_source' => $contentSource != null ? $contentSource->getValue() : '',
            'content_source_static' => $contentSourceStatic != null ? $contentSourceStatic->getValue() : '',
            'customer_source' => $customerDataSource != null ? $customerDataSource->getValue() : '',
            'customer_source_static' => $customerDataSourceStatic != null ? $customerDataSourceStatic->getValue() : '',
            'order_reference' => $order->reference,
            'order_id' => $orderId,
            'invoice_number' => $order->invoice_number,
            'default_weight' => $defaultWeight != null ? $defaultWeight->getValue() : '0'
        ];

        return $this->twig->render('@Modules/dpdshipping/views/templates/admin/order/generate-shipping.html.twig', $result);
    }

    private function getWaybills($generateShippingResult)
    {
        $waybills = '';
        foreach ($generateShippingResult as $item) {
            $waybills .= implode(', ', $item['waybills']) . ', ';
        }

        return rtrim($waybills, ', ');
    }

    public static function isPickup($dpdCarrier)
    {
        if (!isset($dpdCarrier['dpd_carrier'])) {
            return false;
        }

        return $dpdCarrier['dpd_carrier']->getType() == Config::DPD_PICKUP || $dpdCarrier['dpd_carrier']->getType() == Config::DPD_PICKUP_COD;
    }

    /**
     * @param string $dpdCarrierType
     * @param $commandBus
     * @param Order $order
     * @return bool
     */
    public function isCodPayment($commandBus, Order $order): bool
    {
        $paymentMethodsCod = $commandBus->handle(new GetConfiguration(Configuration::DPD_COD_PAYMENT_METHODS));

        return GetCodPaymentModulesHandler::isCodPaymentMethod($paymentMethodsCod, $order->module);
    }

    private function getPaymentMethodDisplayName($module)
    {
        if ($module == null) {
            return '';
        }
        $module = Module::getInstanceByName($module);

        if (!Validate::isLoadedObject($module)) {
            return '';
        }

        return $module->displayName;
    }

    private function isReturnLabel($form): bool
    {
        return isset($form['service_return_label']) && $form['service_return_label'] == '1';
    }

    /**
     * @param $generateShippingResult
     * @return mixed
     */
    public function getShippingHistoryId($generateShippingResult)
    {
        if (is_array($generateShippingResult) && isset($generateShippingResult[0]['shippingHistoryList'][0])) {
            return $generateShippingResult[0]['shippingHistoryList'][0]->getId();
        }

        return null;
    }
}
