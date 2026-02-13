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

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Carrier\Command\UpdateCarrierActionCommand;
use DpdShipping\Domain\Configuration\Carrier\DpdCarrierPrestashopConfiguration;
use DpdShipping\Domain\Configuration\Carrier\DpdIframe;
use DpdShipping\Domain\Configuration\Configuration\Query\GetConfiguration;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration as ConfigurationAlias;
use DpdShipping\Domain\Legacy\SpecialPrice\SpecialPriceService;
use DpdShipping\Hook\Hook;
use DpdShipping\Hook\HookRepository;
use DpdShipping\Install\AdminMenuTab;
use DpdShipping\Install\InstallerFactory;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;
use PrestaShop\PrestaShop\Core\Exception\ContainerNotFoundException;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\Type\SubmitBulkAction;

class DpdShipping extends CarrierModule
{
    public $id_carrier;

    public function __construct()
    {
        $this->name = 'dpdshipping';
        $this->version = '1.2.0';
        $this->author = 'DPD Poland sp. z o. o.';
        $this->need_instance = 1;

        parent::__construct();

        $this->displayName = $this->trans(
            'DPD Poland sp. z o. o. shipping module',
            [],
            'Modules.Dpdshipping.Admin'
        );
        $this->description =
            $this->trans(
                'DPD Poland sp. z o. o. shipping module',
                [],
                'Modules.Dpdshipping.Admin'
            );

        $this->ps_versions_compliancy = [
            'min' => '1.7.8.0',
            'max' => '8.99.99',
        ];
    }

    public function hookActionFrontControllerSetMedia()
    {
        $idAddressDelivery = (int)$this->context->cart->id_address_delivery;

        Media::addJsDef([
            'dpdshipping_pickup_save_point_ajax_url' => $this->context->link->getModuleLink('dpdshipping', 'PickupSavePointAjax'),
            'dpdshipping_pickup_get_address_ajax_url' => $this->context->link->getModuleLink('dpdshipping', 'PickupGetAddressAjax'),
            'dpdshipping_pickup_is_point_with_cod_ajax_url' => $this->context->link->getModuleLink('dpdshipping', 'PickupIsCodPointAjax'),
            'dpdshipping_token' => sha1(_COOKIE_KEY_ . 'dpdshipping'),
            'dpdshipping_csrf' => Tools::getToken(false),
            'dpdshipping_id_cart' => (int)$this->context->cart->id,
            'dpdshipping_iframe_url' => DpdIframe::getPickupIframeUrl(Config::DPD_PICKUP_MAP_URL_WITH_FILTERS, Config::PICKUP_MAP_BASE_URL, $idAddressDelivery),
            'dpdshipping_iframe_cod_url' => DpdIframe::getPickupIframeUrl(Config::DPD_PICKUP_COD_MAP_URL_WITH_FILTERS, Config::PICKUP_MAP_BASE_URL . '&direct_delivery_cod=1', $idAddressDelivery),
            'dpdshipping_id_pudo_carrier' => DpdCarrierPrestashopConfiguration::getConfig(Config::DPD_PICKUP),
            'dpdshipping_id_pudo_cod_carrier' => DpdCarrierPrestashopConfiguration::getConfig(Config::DPD_PICKUP_COD),
        ]);

        $this->context->controller->registerJavascript(
            'dpdshipping-pudo-common-js',
            'modules/' . $this->name . '/views/js/dpdshipping-common.js'
        );

        $this->context->controller->registerStylesheet(
            'dpdshipping-pudo-common-css',
            'modules/' . $this->name . '/views/css/dpdshipping-common.css'
        );

        $custom_cart = DpdCarrierPrestashopConfiguration::getConfig(ConfigurationAlias::CUSTOM_CHECKOUT);

        if ($custom_cart == ConfigurationAlias::CUSTOM_CHECKOUT_SUPERCHECKOUT) {
            $this->context->controller->registerJavascript(
                'dpdshipping-pudo-supercheckout-js',
                'modules/' . $this->name . '/views/js/dpdshipping-pudo-supercheckout.js'
            );

            $this->context->controller->registerStylesheet(
                'dpdshipping-pudo-supercheckout-css',
                'modules/' . $this->name . '/views/css/dpdshipping-pudo-supercheckout.css'
            );
        } else {
            $this->context->controller->registerJavascript(
                'dpdshipping-pudo-default-js',
                'modules/' . $this->name . '/views/js/dpdshipping-pudo-default.js'
            );

            $this->context->controller->registerStylesheet(
                'dpdshipping-pudo-default-css',
                'modules/' . $this->name . '/views/css/dpdshipping-pudo-default.css'
            );
        }
    }

    public function hookDisplayCarrierExtraContent($params)
    {
        $this->context->smarty->assign(array(
            'dpdshipping_pudo_iframe_js' => $this->context->link->getBaseLink() . '/modules/dpdshipping/views/js/dpdshipping-pudo-iframe.js',
            'dpdshipping_pudo_cod_iframe_js' => $this->context->link->getBaseLink() . '/modules/dpdshipping/views/js/dpdshipping-pudo-cod-iframe.js',
        ));

        if (DpdCarrierPrestashopConfiguration::isPickup($params['carrier']['id'])) {
            return $this->display(
                __FILE__,
                'views/templates/hook/carrier-extra-content-pudo.tpl'
            );
        }

        if (DpdCarrierPrestashopConfiguration::isPickupCod($params['carrier']['id'])) {
            return $this->display(
                __FILE__,
                'views/templates/hook/carrier-extra-content-pudo-cod.tpl'
            );
        }

        return false;
    }

    public function install(): bool
    {
        if (!parent::install()) {
            return false;
        }
        $installer = InstallerFactory::create(new HookRepository(), $this->get('doctrine.dbal.default_connection'));

        if (!$installer->install($this)) {
            return false;
        }

        return true;
    }

    public function uninstall(): bool
    {
        $installer = InstallerFactory::create($this->get('prestashop.module.dpdshipping.hook.repository'), $this->get('doctrine.dbal.default_connection'));

        return $installer->uninstall() && parent::uninstall();
    }

    public function getTabs(): array
    {
        $name = $this->trans('DPD Poland shipping', [], 'Modules.Dpdshipping.Admin');
        return AdminMenuTab::getTabs($name);
    }

    public function getContent()
    {
        $needOnboarding = $this->get('prestashop.core.query_bus')->handle(new GetConfiguration(ConfigurationAlias::NEED_ONBOARDING));

        if ($needOnboarding == null || $needOnboarding->getValue() == '1') {
            Tools::redirectAdmin(SymfonyContainer::getInstance()->get('router')->generate('dpdshipping_onboarding_form'));
        } else {
            Tools::redirectAdmin(SymfonyContainer::getInstance()->get('router')->generate('dpdshipping_connection_form'));
        }
    }

    /**
     * @throws ContainerNotFoundException
     */
    public function hookDisplayAdminOrderTabLink(array $params)
    {
        return $this->get('prestashop.module.dpdshipping.hook.factory')->render(Hook::$DISPLAY_ADMIN_ORDER_TAB_LINK, $params, $this->context);
    }

    /**
     * @throws ContainerNotFoundException
     */
    public function hookDisplayAdminOrderTabContent(array $params)
    {
        return $this->get('prestashop.module.dpdshipping.hook.factory')->render(Hook::$DISPLAY_ADMIN_ORDER_TAB_CONTENT, $params, $this->context);
    }

    public function hookDisplayBackOfficeHeader($params)
    {
        $controller = Tools::getValue('controller');
        $this->context->controller->addJS('modules/' . $this->name . '/views/js/dpdshipping-ajax.js');

        if ($controller == 'AdminOrders') {
            $ajaxUrl = $this->context->link->getAdminLink('AdminModules', true, [], [
                'route' => 'dpdshipping_generate_shipping_bulk_action',
            ]);

            Media::addJsDef([
                'dpdshipping_bulk_generate_shipping' => $ajaxUrl,
                'dpdshipping_translations' => [
                    'dpdshipping_return_label_success_text' => $this->trans('The return label has been generated.', [], 'Modules.Dpdshipping.ReturnLabel'),
                    'dpdshipping_return_label_error_text' => $this->trans('The return label cannot be generated.', [], 'Modules.Dpdshipping.ReturnLabel'),
                    'dpdshipping_label_success_text' => $this->trans('The label has been generated.', [], 'Modules.Dpdshipping.ReturnLabel'),
                    'dpdshipping_label_error_text' => $this->trans('The label cannot be generated.', [], 'Modules.Dpdshipping.ReturnLabel'),
                ],
            ]);
        } else {
            Media::addJsDef([
                'dpdshipping_pickup_courier_ajax_url' => $this->get('router')->generate('dpdshipping_pickup_courier_get_pickup_courier_settings_ajax'),
                'dpdshipping_pickup_courier_get_pickup_time_frames_ajax_url' => $this->get('router')->generate('dpdshipping_pickup_courier_get_pickup_courier_time_frames_ajax'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_url' => $this->get('router')->generate('dpdshipping_pickup_courier_pickup_courier_ajax'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_customer' => $this->trans('Please complete the customer details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_sender' => $this->trans('Please complete the sender details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_payer' => $this->trans('Please complete the payer details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_pickup_date_time' => $this->trans('Please complete pickup date and time range details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_parcel' => $this->trans('Please complete parcels details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_letters' => $this->trans('Please complete letters details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_packages' => $this->trans('Please complete all packages details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_ajax_empty_palette' => $this->trans('Please complete all palette details.', [], 'Modules.Dpdshipping.PickupCourier'),
                'dpdshipping_pickup_courier_pickup_courier_empty_configuration' => $this->trans('Please complete the configuration in the module settings before ordering a courier', [], 'Modules.Dpdshipping.PickupCourier')
            ]);
        }
        Media::addJsDef([
            'dpdshipping_token' => sha1(_COOKIE_KEY_ . 'dpdshipping')
        ]);
    }

    public function hookActionOrderGridDefinitionModifier($params)
    {
        $params['definition']->getBulkActions()->add(
            (new SubmitBulkAction('dpdshipping_generate_shipping_bulk_action'))
                ->setName($this->trans('DPD Poland - generate shipping', [], 'Modules.Dpdshipping.Bulk'))
                ->setOptions([
                    'submit_route' => 'dpdshipping_generate_shipping_bulk_action',
                    'submit_method' => 'POST',
                ])
        );

        $params['definition']->getBulkActions()->add(
            (new SubmitBulkAction('dpdshipping_generate_labels_bulk_action'))
                ->setName($this->trans('DPD Poland - generate labels', [], 'Modules.Dpdshipping.Bulk'))
                ->setOptions([
                    'submit_route' => 'dpdshipping_shipping_history_print_labels_form',
                    'submit_method' => 'POST',
                ])
        );
        $params['definition']->getBulkActions()->add(
            (new SubmitBulkAction('dpdshipping_generate_shipping_and_labels_bulk_action'))
                ->setName($this->trans('DPD Poland - generate shipping and labels', [], 'Modules.Dpdshipping.Bulk'))
                ->setOptions([
                    'submit_route' => 'dpdshipping_generate_shipping_and_labels_bulk_action',
                    'submit_method' => 'POST',
                ])
        );
    }

    /**
     * @throws ContainerNotFoundException
     */
    public function hookDisplayAdminOrderMain(array $params)
    {
        return $this->get('prestashop.module.dpdshipping.hook.factory')->render(Hook::$DISPLAY_ADMIN_ORDER_MAIN, $params, $this->context);
    }

    public function getOrderShippingCost($params, $shipping_cost)
    {
        if (Configuration::get(ConfigurationAlias::SPECIAL_PRICE_ENABLED) == '1') {
            return $this->getOrderShippingCostExternal($params);
        }

        return $shipping_cost;
    }

    public function getOrderShippingCostExternal($params)
    {
        $specialPrice = new SpecialPriceService($params, $this->id_carrier);

        return $specialPrice->handle();
    }

    public function hookActionCarrierUpdate(array $params)
    {
        $this->get('prestashop.core.command_bus')->handle(new UpdateCarrierActionCommand($params));
    }

    public function isUsingNewTranslationSystem(): bool
    {
        return true;
    }
}
