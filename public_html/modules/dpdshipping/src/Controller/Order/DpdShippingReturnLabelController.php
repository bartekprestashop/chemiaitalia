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

use DpdShipping\Domain\ReturnLabel\Command\ReturnLabelCommand;
use DpdShipping\Domain\ShippingHistory\Query\GetShipping;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class DpdShippingReturnLabelController extends FrameworkBundleAdminController
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

    public function index(Request $request): Response
    {
        $orderId = (int) $request->get('orderId');
        $shippingHistoryId = (int) $request->get('shippingHistoryId');

        $shipping = $this->commandBus->handle(new GetShipping($shippingHistoryId));

        $returnLabel = $this->commandBus->handle(new ReturnLabelCommand(
            $orderId,
            $shipping['parcel']->getWaybill(),
            $shippingHistoryId,
            $shipping['services']->getReturnLabelCompany(),
            $shipping['services']->getReturnLabelName(),
            $shipping['services']->getReturnLabelStreet(),
            $shipping['services']->getReturnLabelPostalcode(),
            $shipping['services']->getReturnLabelCity(),
            $shipping['services']->getReturnLabelCountryCode(),
            $shipping['services']->getReturnLabelEmail(),
            $shipping['services']->getReturnLabelPhone()
        ));

        if ($returnLabel['status'] == 'OK') {
            $fileName = 'return-label-' . sprintf('%04d', rand(0, 1000)) . '-' . date('Y-m-d-H-i-s');
            $fileContent = $returnLabel['data']->documentData;
            $response = new Response($fileContent);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$fileName\"");
            $response->headers->set('Content-Length', strlen($fileContent));

            return $response;
        }

        return new JsonResponse(
            ['status' => 'ERROR', 'message' => implode(' ', $returnLabel['data'])],
            400,
            ['Content-Type' => 'application/json']
        );
    }
}
