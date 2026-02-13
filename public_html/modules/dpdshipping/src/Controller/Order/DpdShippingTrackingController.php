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

use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;
use DpdShipping\Domain\Tracking\TrackingService;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;

class DpdShippingTrackingController extends FrameworkBundleAdminController
{
    private $trackingService;
    private $commandBus;
    private $twig;
    private $translator;

    public function __construct(TrackingService $trackingService, CommandBusInterface $commandBus, $twig, $translator)
    {
        parent::__construct();
        $this->trackingService = $trackingService;
        $this->commandBus = $commandBus;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function index(Request $request)
    {
        $checkTrackingOrderView = $this->commandBus->handle(new GetConfiguration(Configuration::CHECK_TRACKING_ORDER_VIEW));

        if ($checkTrackingOrderView != null && $checkTrackingOrderView->getValue() != '1') {
            return $this->translator->trans('To enable tracking for shipments, please visit the DPD Poland configuration page.', [], 'Modules.Dpdshipping.AdminOrder');
        }

        return $this->twig->render('@Modules/dpdshipping/views/templates/admin/order/tracking.html.twig', [
            'shippingHistory' => $this->trackingService->getTrackingInformation($request->get('orderId')),
        ]);
    }
}
