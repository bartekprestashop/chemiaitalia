<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

if (!defined('X13_ION_VERSION_GM')) {
    if (PHP_VERSION_ID >= 80100) {
        $x13IonVer = '-81';
    } elseif (PHP_VERSION_ID >= 70100) {
        $x13IonVer = '-71';
    } elseif (PHP_VERSION_ID >= 70000) {
        $x13IonVer = '-7';
    } else {
        $x13IonVer = '';
    }

    if (file_exists(_PS_MODULE_DIR_ . 'x13googlemerchant/dev')) {
        $x13IonVer = '';
    }

    define('X13_ION_VERSION_GM', $x13IonVer);
}

require_once _PS_MODULE_DIR_ . 'x13googlemerchant/x13googlemerchant.db' . X13_ION_VERSION_GM . '.php';
require_once _PS_MODULE_DIR_ . 'x13googlemerchant/x13googlemerchant.core' . X13_ION_VERSION_GM . '.php';
require_once _PS_MODULE_DIR_ . 'x13googlemerchant/x13googlemerchant.schema' . X13_ION_VERSION_GM . '.php';

class x13googlemerchant extends x13googlemerchantCore
{
    public function __construct()
    {
        $this->name = 'x13googlemerchant';
        $this->tab = 'export';
        $this->version = '1.8.0';
        $this->author = 'X13.pl';
        $this->bootstrap = true;
        $this->need_instance = 1;

        parent::__construct();

        $this->ps_version = (float) substr(_PS_VERSION_, 0, 3);

        // Retrocompatibility
        if ($this->ps_version < 1.5) {
            $this->initContext();
            require_once _PS_MODULE_DIR_ . '__x13googlemerchant/helpers.1.4/helper.php';
            require_once _PS_MODULE_DIR_ . '__x13googlemerchant/helpers.1.4/helper_list.php';
            require_once _PS_MODULE_DIR_ . '__x13googlemerchant/helpers.1.4/helper_option.php';
            require_once _PS_MODULE_DIR_ . '__x13googlemerchant/helpers.1.4/helper_form.php';
        }

        if ($this->ps_version == 1.5) {
            $this->bootstrap = false;
            $this->context->smarty->assign('is_bootstrap', false);
        } else {
            $this->bootstrap = true;
            $this->context->smarty->assign('is_bootstrap', true);
        }

        $this->displayName = $this->l('Google merchant XML');
        $this->description = $this->l('Umożliwia eksport produktów sklepu do pliku XML dla Google Merchant Center.');
    }

    public function hookDisplayAdminProductsExtra($params)
    {
        if (version_compare(_PS_VERSION_, '1.7', '>')) {
            $id_product = (int) $params['id_product'];
        } else {
            $id_product = (int) Tools::getValue('id_product');
        }

        $product = new Product($id_product);

        if (!Validate::isLoadedObject($product)) {
            return '<div></div>';
        }

        $this->context->smarty->assign([
            'languages' => Language::getLanguages(false),
            'default_language' => (int) Configuration::get('PS_LANG_DEFAULT'),
            'custom_labels' => _x13googlemerchant::getCustomLabels($product->id, (class_exists('Context', false) ? $this->context->shop->id : null)),
            'custom_export' => _x13googlemerchant::getCustomExport($product->id, (class_exists('Context', false) ? $this->context->shop->id : null)),
            'custom_title' => _x13googlemerchant::getCustomTitle($product->id, (class_exists('Context', false) ? $this->context->shop->id : null)),
            'is_custom_export' => Configuration::get('X13_GOOGLEMERCHANT_EXPORT_CUSTOM'),
            'displayX13GoogleMerchantAdminProductsExtra' => Hook::exec('displayX13GoogleMerchantAdminProductsExtra', ['id_product' => $id_product])
        ]);

        return $this->display(__FILE__, 'views/templates/admin/tab.tpl');
    }

    public function hookActionProductSave($params)
    {
        if (!isset($params['id_product']) || !Tools::getValue('x13googlemerchant_product_extra')) {
            return false;
        }

        return _x13googlemerchant::assignCustomProduct(
            $params['id_product'],
            Tools::getValue('custom_label', []),
            Tools::getValue('custom_title', []),
            (int) Tools::getValue('custom_export', 0),
            (class_exists('Context', false) ? $this->context->shop->id : null)
        );
    }

    public function hookActionProductDelete($params)
    {
        if (!isset($params['product']) || !Validate::isLoadedObject($params['product'])) {
            return false;
        }

        return _x13googlemerchant::unassignCustomProduct(
            $params['product']->id,
            (class_exists('Context', false) ? $this->context->shop->id : null)
        );
    }

    public function hookActionFeatureDelete(array $params)
    {
        $configuration = Configuration::getMultiple([
            'X13_GOOGLEMERCHANT_ENERGY_ID',
            'X13_GOOGLEMERCHANT_UNIT_ID',
            'X13_GOOGLEMERCHANT_UNIT_BASE_ID',
            'X13_GOOGLEMERCHANT_SHIP_LABEL_ID'
        ]);

        foreach ($configuration as $configName => $featureId) {
            if ((int)$featureId == (int)$params['id_feature']) {
                Configuration::updateValue($configName, 0);
            }
        }
    }

    /**
     * Retrocompatibility 1.4/1.5
     */
    private function initContext()
    {
        if (class_exists('Context')) {
            $this->context = Context::getContext();
        } else {
            global $smarty, $cookie;
            $this->context = new stdClass();
            $this->context->smarty = $smarty;
            $this->context->cookie = $cookie;
        }
    }
}
