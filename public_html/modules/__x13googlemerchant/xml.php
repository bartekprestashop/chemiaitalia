<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('_PRESTA_DIR_', dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME']))));

require_once(_PRESTA_DIR_ . '/config/config.inc.php');

if (Configuration::get('X13_GOOGLEMERCHANT_CRON_TOKEN') && Tools::getValue('token') != Configuration::get('X13_GOOGLEMERCHANT_TOKEN')) {
    echo 'Token error';
    exit;
}

$x13googlemerchant = Module::getInstanceByName('x13googlemerchant');

$id_lang = (Tools::getIsset('id_lang')) ? (int)Tools::getValue('id_lang') : (int)Configuration::get('PS_DEFAULT_LANG');
$id_shop = (Tools::getIsset('id_shop')) ? (int)Tools::getValue('id_shop') : Context::getContext()->shop->id;
$id_currency = (Tools::getIsset('id_currency')) ? (int)Tools::getValue('id_currency') : (int)Configuration::get('PS_DEFAULT_CURRENCY');

// initialize Context variables for other external modules fired by hooks
$context = Context::getContext();
$context->shop = new Shop($id_shop);
$context->language = new Language($id_lang);
$context->currency = new Currency($id_currency);

$x13googlemerchant->createXml($id_lang, $id_shop, $id_currency, 1);
