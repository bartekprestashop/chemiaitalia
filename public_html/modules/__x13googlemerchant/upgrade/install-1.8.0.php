<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_8_0($module)
{
    if (version_compare(_PS_VERSION_, '1.6.0.0', '>=')) {
        Configuration::updateValue('X13_GOOGLEMERCHANT_NOTAX_CR', Configuration::get('X13_GOOGLEMERCHANT_NOTAX_CURRENCIES'));
    }

    Configuration::updateValue('X13_GOOGLEMERCHANT_ENERGY', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_ENERGY_ID', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_UNIT', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_UNIT_ID', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_UNIT_BASE_ID', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_SHIP_LABEL', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_SHIP_LABEL_ID', 0);
    Configuration::updateValue('X13_GOOGLEMERCHANT_IMG_ADDITION', 1);

    $module->registerHook('actionFeatureDelete');

    return true;
}
