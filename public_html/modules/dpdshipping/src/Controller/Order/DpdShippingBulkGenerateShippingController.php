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
use DpdShipping\Domain\Configuration\Carrier\Query\GetCodPaymentModulesHandler;
use DpdShipping\Domain\Configuration\Carrier\Query\GetOrderCarrier;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Configuration\Payer\Query\GetPayerList;
use DpdShipping\Domain\Order\Command\AddDpdOrderCommand;
use DpdShipping\Domain\Order\Query\GetOrderPudoCode;
use Order;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class DpdShippingBulkGenerateShippingController extends FrameworkBundleAdminController
{
    private $commandBus;
    private $twig;
    private $translator;

    public function __construct($commandBus, $twig, $translator)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function index(Request $request)
    {
        list($successCount, $ids) = $this->generateShippingList($request);

        $this->addFlash(
            'success',
            $this->translator->trans(
                'The shipment has been generated success: %successCount% errors: %errors%',
                [
                    '%successCount%' => $successCount,
                    '%errors%' => count($ids) - $successCount,
                ],
                'Admin.Notifications.Success'
            )
        );

        return $this->redirectToRoute('admin_orders_index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function generateShippingList(Request $request): array
    {
        $successCount = 0;
        $successIds = [];
        $ids = $request->get('order_orders_bulk');
        foreach ($ids as $orderId) {
            $order = new Order($orderId);
            $dpdCarrier = $this->commandBus->handle(new GetOrderCarrier($order));

            if (!$dpdCarrier) {
                continue; // for not DPD Poland orders
            }

            $shippingFormProvider = $this->get('prestashop.module.dpdshipping.form.dpdshipping_generate_shipping_form_data_provider');
            $orderData = $shippingFormProvider->getData($orderId);

            $payerList = $this->commandBus->handle(new GetPayerList(true));

            $parcels = [ // TODO
                'weight' => '1',
                'weightAdr' => '',
                'content' => '',
                'customerData' => '',
                'sizeX' => '',
                'sizeY' => '',
                'sizeZ' => '',
            ];

            $orderData['payer_number'] = !empty($payerList) ? $payerList[0]->getFid() : null;
            $orderData['packages'] = [$parcels];

            if ($this->isCodPayment($order)) {
                $currency_from = new Currency($order->id_currency);
                $orderData['service_cod'] = '1';
                $orderData['service_cod_value'] = $order->total_paid_tax_incl;
                $orderData['service_cod_currency'] = $currency_from->iso_code;
            }

            if (DpdShippingGenerateShippingController::isPickup($dpdCarrier)) {
                $orderData['service_dpd_pickup'] = '1';
                $orderData['service_dpd_pickup_value'] = $this->commandBus->handle(new GetOrderPudoCode($order->id_shop, $order->id_cart));
            }

            $generateShippingResult = $this->commandBus->handle(new AddDpdOrderCommand($orderId, $orderData, $dpdCarrier));

            if (empty($generateShippingResult['errors'])) {
                $successCount = $successCount + 1;
                $successIds[] = $orderId;
            }
        }

        return [$successCount, $ids, $successIds];
    }

    public function isCodPayment($order): bool
    {
        $paymentMethodsCod = $this->commandBus->handle(new GetConfiguration(Configuration::DPD_COD_PAYMENT_METHODS));

        return GetCodPaymentModulesHandler::isCodPaymentMethod($paymentMethodsCod, $order->module);
    }

    public function generateShippingAndPrintLabels(Request $request)
    {
        list($successCount, $ids, $successIds) = $this->generateShippingList($request);

        $shippingHistoryController = $this->get('DpdShipping\Controller\ShippingHistory\DpdShippingShippingHistoryController');
        $shippingHistoryController->setContainer($this->container);

        return $shippingHistoryController->printLabelActionAjax(new Request(['order_orders_bulk' => $successIds]));
    }
}
