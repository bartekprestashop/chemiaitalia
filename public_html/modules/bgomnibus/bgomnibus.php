<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Bgomnibus extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'bgomnibus';
        $this->tab = 'administration';
        $this->version = '1.0.2';
        $this->author = 'BG';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Omnibus ');
        $this->description = $this->l('Collecting and displaying history of price drops');

        $this->confirmUninstall = $this->l('');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('ROXOMNIBUS_LIVE_MODE', false);

        include(dirname(__FILE__).'/sql/install.php');

        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayOmnibusInfo');
    }

    public function uninstall()
    {
        Configuration::deleteByName('ROXOMNIBUS_LIVE_MODE');

        include(dirname(__FILE__).'/sql/uninstall.php');

        return parent::uninstall();
    }

    /**
     * Load the configuration form
     */
    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitBgomnibusModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitBgomnibusModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                'title' => $this->l('Settings'),
                'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Show omnibus message'),
                        'name' => 'ROXOMNIBUS_LIVE_MODE',
                        'is_bool' => true,
                        'desc' => $this->l('Show or hide price history'),
                        'values' => array(
                            array(
                                'id' => 'active_on',
                                'value' => true,
                                'label' => $this->l('Enabled')
                            ),
                            array(
                                'id' => 'active_off',
                                'value' => false,
                                'label' => $this->l('Disabled')
                            )
                        ),
                    ), 
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'ROXOMNIBUS_LIVE_MODE' => Configuration::get('ROXOMNIBUS_LIVE_MODE', true),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
    * Add the CSS & JavaScript files you want to be loaded in the BO.
    */
    public function hookDisplayBackOfficeHeader()
    {
        if (Tools::getValue('configure') == $this->name) {
            $this->context->controller->addJS($this->_path.'views/js/back.js');
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookDisplayHeader()
    {

        if(Configuration::get('ROXOMNIBUS_LIVE_MODE') == true){

            $this->context->controller->addJS($this->_path.'/views/js/front.js');
            $this->context->controller->addCSS($this->_path.'/views/css/front.css');

        }

    }




    public function hookDisplayOmnibusInfo($params)
    {

        $output ='<!-- omnibus -->';
        if(Configuration::get('ROXOMNIBUS_LIVE_MODE') == true){

            $id_product = $params['product']['id_product'];
            $id_shop = (int)Context::getContext()->shop->id;

            $id_product_attribute = 0;
            $omnibus = new ProductOmnibus($id_product);

            $dane_omnibus['show'] = $omnibus->show;
            $dane_omnibus['date'] = $omnibus->date;
            $dane_omnibus['price_wt'] = $omnibus->price_wt;
            $dane_omnibus['price_wt_formated'] = $omnibus->price_wt_formated;
            $dane_omnibus['old_price'] = $omnibus->old_price;
 
            $this->context->smarty->assign(array( 'price_history' => $dane_omnibus ));
            $output .= $this->context->smarty->fetch($this->local_path.'views/templates/hook/displayOmnibusInfo.tpl');

     
        }
        return $output;
    }



    public static function getOldPrice($id_product,$id_product_attribute){

        //tutaj pobierz z bazy cena normalna brutto
        $sql = 'SELECT price, (SELECT rate FROM '._DB_PREFIX_.'tax where id_tax=product.id_tax_rules_group) as rate  FROM '._DB_PREFIX_.'product product where id_product="'.$id_product.'" ';
        $price_data = DB::getInstance()->executeS($sql);
        $price = $price_data[0]['price'] * (1+($price_data[0]['rate']/100));

        return round($price,2);

    }
}
