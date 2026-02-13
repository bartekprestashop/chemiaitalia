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

namespace DpdShipping\Controller\ShippingHistory;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Domain\ShippingHistory\Command\DeleteShipping;
use DpdShipping\Domain\ShippingHistory\Query\GetLabel;
use DpdShipping\Domain\ShippingHistory\Query\GetProtocol;
use DpdShipping\Domain\ShippingHistory\Query\GetShippingByOrderId;
use DpdShipping\Grid\ShippingHistory\Definition\Factory\ShippingHistoryGridDefinitionFactory;
use DpdShipping\Grid\ShippingHistory\ShippingHistoryFilters;
use DpdShipping\Util\ValidateUserUtil;
use PrestaShop\PrestaShop\Core\CommandBus\CommandBusInterface;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use PrestaShopBundle\Translation\TranslatorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Tools;
use Twig\Environment;
use ZipArchive;

class DpdShippingShippingHistoryController extends FrameworkBundleAdminController
{
    private $commandBus;
    private $twig;
    private $translator;

    public function __construct(CommandBusInterface $commandBus, Environment $twig, TranslatorInterface $translator)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
        $this->twig = $twig;
        $this->translator = $translator;
    }

    public function setContainer($container = null): ?ContainerInterface //TODO check in PS 1.7.8
    {
        if ($container == null) {
            return null;
        }

        $this->container = $container;

        return parent::setContainer($container);
    }

    public function index(ShippingHistoryFilters $filters)
    {
        $quoteGridFactory = $this->get('dpdshipping.grid.factory.shipping.history');
        $quoteGrid = $quoteGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/dpdshipping/views/templates/admin/shippingHistory/shipping-history-form.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->translator->trans('Shipping history', [], 'Modules.Dpdshipping.Admin'),
                'quoteGrid' => $this->presentGrid($quoteGrid),
            ]
        );
    }

    public function searchAction(Request $request)
    {
        $responseBuilder = $this->get('prestashop.bundle.grid.response_builder');

        return $responseBuilder->buildSearchResponse(
            $this->get('dpdshipping.grid.definition.factory.shipping.history'),
            $request,
            ShippingHistoryGridDefinitionFactory::GRID_ID,
            'dpdshipping_shipping_history_form'
        );
    }

    public function printLabelActionAjax(Request $request)
    {
        $sourcePage = 'dpdshipping_shipping_history_form';
        $ids = $request->get('dpdshipping_shipping_history_bulk') ?? [$request->get('shippingHistoryId')];

        if (empty($ids) || $ids[0] == null) {
            $ids = $this->getShippingIdsFromOrderBulk($request, $ids);
            $sourcePage = 'admin_orders_index';
        }

        $labels = $this->commandBus->handle(new GetLabel($ids));
        if (!empty($labels)) {
            if (count($labels) > 1) {
                return $this->getZip($labels, 'label');
            } else {
                return $this->getPdf($labels[0], 'label');
            }
        } else {
            $errors = [$this->translator->trans('Unable to generate labels', [], 'Modules.Dpdshipping.Admin')];
            $this->flashErrors($errors);
        }

        return $this->redirectToRoute($sourcePage);
    }

    public function printProtocolActionAjax(Request $request)
    {
        $ids = $request->get('dpdshipping_shipping_history_bulk') ?? [$request->get('shippingHistoryId')];

        $protocols = $this->get('prestashop.core.query_bus')->handle(new GetProtocol($ids));

        if ($protocols['status'] == 'OK') {
            if (count($protocols['data']) > 1) {
                return $this->getZip($protocols['data'], 'protocol');
            } else {
                return $this->getPdf($protocols['data'][0], 'protocol');
            }
        } else {
            $errors = [$this->translator->trans('Unable to generate protocols', [], 'Modules.Dpdshipping.Admin')];
            $this->flashErrors($errors);
        }

        return $this->redirectToRoute('dpdshipping_shipping_history_form');
    }

    public function deleteAction(Request $request)
    {
        $ids = $request->get('dpdshipping_shipping_history_bulk') ?? [$request->get('shippingHistoryId')];

        $deleteShipping = $this->get('prestashop.core.query_bus')->handle(new DeleteShipping($ids));
        if ($deleteShipping) {
            $this->addFlash(
                'success',
                $this->translator->trans('Success', [], 'Modules.Dpdshipping.Admin')
            );
        } else {
            $errors = [$this->translator->trans('Unable to delete shipping', [], 'Modules.Dpdshipping.Admin')];
            $this->flashErrors($errors);
        }

        return $this->redirectToRoute('dpdshipping_shipping_history_form');
    }

    /**
     * @param $data
     * @return RedirectResponse|Response
     */
    public function getZip($data, $documentType)
    {
        $zip = new ZipArchive();
        $zipFileName = $documentType . 's-' . sprintf('%04d', rand(0, 1000)) . '-' . date('Y-m-d-H-i-s') . '.zip';

        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            foreach ($data as $index => $response) {
                $filename = $documentType . '-' . sprintf('%04d', rand(0, 1000)) . '-' . date('Y-m-d-H-i-s') . '.pdf';
                $pdfData = $response->documentData;
                $zip->addFromString($filename, $pdfData);
            }
            $zip->close();
            $zipContent = Tools::file_get_contents($zipFileName);

            $response = new Response($zipContent);
            $response->headers->set('Content-Type', 'application/zip');
            $response->headers->set('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$zipFileName\"");
            $response->headers->set('Content-Length', strlen($zipContent));

            unlink($zipFileName);

            return $response;
        } else {
            $errors = [$this->translator->trans('Unable to generate protocols', [], 'Modules.Dpdshipping.Admin')];
            $this->flashErrors($errors);

            return $this->redirectToRoute('dpdshipping_shipping_history_form');
        }
    }

    /**
     * @param Request $request
     * @param array $ids
     * @return array
     */
    public function getShippingIdsFromOrderBulk(Request $request, array $ids): array
    {
        $ids = [];

        foreach ($request->get('order_orders_bulk') as $key => $id) {
            $shippingIds = $this->getQueryBus()->handle(new GetShippingByOrderId($id));
            if (isset($shippingIds['shipping'])) {
                $ids[] = $shippingIds['shipping']->getId();
            }
        }

        return $ids;
    }

    /**
     * @param $protocols
     * @return Response
     */
    public function getPdf($protocols, $documentType): Response
    {
        $fileName = $documentType . '-' . sprintf('%04d', rand(0, 1000)) . '-' . date('Y-m-d-H-i-s') . '.pdf';
        $fileContent = $protocols->documentData;
        $response = new Response($fileContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', ResponseHeaderBag::DISPOSITION_ATTACHMENT . "; filename=\"$fileName\"");
        $response->headers->set('Content-Length', strlen($fileContent));

        return $response;
    }
}
