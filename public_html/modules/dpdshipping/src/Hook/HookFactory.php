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

namespace DpdShipping\Hook;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Context;
use Symfony\Component\HttpFoundation\Request;

class HookFactory
{
    public const MODULES_DPDSHIPPING_VIEWS_TEMPLATES_ADMIN = '@Modules/dpdshipping/views/templates/admin/';

    private $repository;

    public function __construct(HookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function render($hookName, array $params, Context $context)
    {
        $hook = $this->repository->getHook($hookName);
        if ($hookName == Hook::$DISPLAY_ADMIN_ORDER_MAIN) {
            $controller = $context->container->get('prestashop.module.dpdshipping.controller.dpdshipping_generate_shipping');

            return $controller->index($params, $params['request']);
        } elseif ($hookName == Hook::$DISPLAY_ADMIN_ORDER_TAB_CONTENT) {
            $controller = $context->container->get('prestashop.module.dpdshipping.controller.dpdshipping_tracking');

            if (!isset($params['request']) && !isset($params['id_order'])) {
                return '';
            }

            return $controller->index($params['request'] ?? new Request(['orderId' => $params['id_order']]));
        }

        return $this->getTwig($context)->render(self::MODULES_DPDSHIPPING_VIEWS_TEMPLATES_ADMIN . $hook->getForm(), []);
    }

    /**
     * @throws \Exception
     */
    public function getTwig($context)
    {
        return $context->container->get('twig');
    }
}
