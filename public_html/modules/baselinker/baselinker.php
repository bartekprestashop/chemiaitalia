<?php
if (!defined('_PS_VERSION_')) {
	exit;
}

require_once(_PS_MODULE_DIR_ . 'baselinker/classes/BaseLinkerOrder.php');
require_once(_PS_MODULE_DIR_ . 'baselinker/classes/BaseLinkerCart.php');
require_once(_PS_MODULE_DIR_ . 'baselinker/classes/WebserviceSpecificManagementBlPaymentList.php');
require_once(_PS_MODULE_DIR_ . 'baselinker/classes/ModuleWs.php');

class Baselinker extends Module {
	public function __construct() {
		$this->name = 'baselinker';
		$this->tab = 'other';
		$this->version = '8.0.10';
		$this->author = 'BaseLinker';
		$this->need_instance = 0;
		$this->ps_versions_compliancy = array('min' => '1.7.0.0', 'max' => _PS_VERSION_);
		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('Baselinker', 'baselinker');
		$this->description = $this->l('Rozszerzenia API na potrzeby integracji z BaseLinkerem', 'baselinker');
		$this->confirmUninstall = $this->l('Czy na pewno chcesz odinstalować', 'baselinker');
	}

	public function install() {
		parent::install();
		$this->registerHook('addWebserviceResources');
		$this->registerHook('actionEmailSendBefore');
		return true;
	}

	public function uninstall() {
		return parent::uninstall();
	}

	public function hookAddWebserviceResources() {
		return array(
			'bl_order' => array('description' => 'Extended order data for use by BaseLinker', 'class' => 'BaseLinkerOrder'),
			'bl_cart' => array('description' => 'Extended cart data for use by BaseLinker', 'class' => 'BaseLinkerCart'),
            'bl_payment_list' => array(
                'description' => 'Payment method list for use by BaseLinker',
                'specific_management' => true
            ),
            'bl_modules' => array('description' => 'Modules list for use by BaseLinker', 'class' => 'ModuleWs'),
		);
	}

	public function hookActionEmailSendBefore($params) {
		if (isset($params['template']) and $params['template'] == 'order_conf') {
			if (defined('BL_BLOCK_NOTIFICATION')) {
				return false;
			}
		}

		return true;
	}
}

