<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once (dirname(__FILE__) . '/../x13googlemerchant.php');

function upgrade_module_1_4_0($module)
{
    Configuration::updateValue('X13_GOOGLEMERCHANT_USE_TAX', 1);
    Configuration::updateValue('X13_GOOGLEMERCHANT_LANG_SUFFIX', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_EXPORT_CUSTOM', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_EXCLUDE_OOS', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_CRON_TOKEN', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_TOKEN', Tools::passwdGen());

    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'x13googlemerchant` DROP INDEX `id_category`');

    Db::getInstance()->execute('
        ALTER TABLE `'._DB_PREFIX_.'x13googlemerchant`
            ADD `id_shop` INT(10) UNSIGNED NOT NULL DEFAULT 0 AFTER `id_lang`,
            ADD UNIQUE INDEX (`id_category`, `id_lang`, `id_shop`)'
    );

    Db::getInstance()->execute('ALTER TABLE `'._DB_PREFIX_.'x13googlemerchant_product` RENAME `'._DB_PREFIX_.'x13googlemerchant_product_lang`');

    Db::getInstance()->execute('
        ALTER TABLE `'._DB_PREFIX_.'x13googlemerchant_product_lang`
            ADD `custom_title` char(255) NULL'
    );

    Db::getInstance()->execute('
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'x13googlemerchant_product`(
            `id_product`           INT(10) UNSIGNED NOT NULL,
            `id_shop`              INT(10) UNSIGNED NOT NULL DEFAULT 0,
            `export`               tinyint(1) unsigned NULL,
            
            PRIMARY KEY(`id_product`, `id_shop`),
            INDEX(`export`)
        ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8'
    );

    if (version_compare(_PS_VERSION_, '1.5' , '>=')) {
        Db::getInstance()->execute('
            UPDATE `'._DB_PREFIX_.'x13googlemerchant`
            SET `id_shop` = ' . (int)Configuration::get('PS_SHOP_DEFAULT')
        );
    }

    return true;
}
