<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once (dirname(__FILE__) . '/../x13googlemerchant.php');

function upgrade_module_1_3_3($module)
{
    $module->registerHook('displayAdminProductsExtra');
    $module->registerHook('actionProductSave');
    $module->registerHook('actionProductDelete');

    Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'x13googlemerchant_product`(
            `id_product`           INT(10) UNSIGNED NOT NULL,
            `id_lang`              INT(10) UNSIGNED NOT NULL,
            `id_shop`              INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `custom_label`         TEXT NULL,
        PRIMARY KEY(`id_product`, `id_lang`, `id_shop`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
    );

    return true;
}
