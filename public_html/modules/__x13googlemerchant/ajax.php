<?php

define('_PS_ADMIN_DIR_', getcwd().'/..');
define('_PRESTA_DIR_', dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))));

require_once(_PRESTA_DIR_ . '/config/config.inc.php');
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'x13googlemerchant.php');

if(class_exists('Context', false))
	if( !Context::getContext()->employee->isLoggedBack() ) { die('Zostałeś wylogowany.'); }

if(Tools::isSubmit('data')) {
	if(isset($_POST['data']['method'])) {
		$id_shop = (int)$_POST['data']['data']['id_shop'];
		$id_lang = (int)$_POST['data']['data']['id_lang'];
		switch($_POST['data']['method']) {
			case 'setGoogleName': {
				$id_category = (int)$_POST['data']['data']['id_category'];
				$google_name = $_POST['data']['data']['google_name'];
				if(_x13googlemerchant::assignCategoryName($id_category, $id_lang, $id_shop, $google_name)) die('ok');
				die('name-error');
			} break;
			case 'setGoogleStatus': {
				parse_str($_POST['data']['data']['param'], $var_array);
				$id_category = $var_array['id_category'];
				$active = $_POST['data']['data']['active'];
				if(_x13googlemerchant::assignCategoryStatus($id_category, $id_shop, $active)) die('ok'.$active);
				die('active-error');
			} break;
			default : {
				die('Nieprawidłowa metoda.');
			}
		}
	}
	else {
		die('Brak metoday');
	}
}
