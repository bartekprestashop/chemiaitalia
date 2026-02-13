<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_5_5()
{
    Configuration::updateValue('X13_GOOGLEMERCHANT_CURRENCY_URL', 1);

    // fix for not set shipping handling method
    if (!Configuration::get('X13_GOOGLEMERCHANT_SHIP_BEHAVIOR')) {
        Configuration::updateValue('X13_GOOGLEMERCHANT_SHIP_BEHAVIOR', 1);
    }

    return true;
}
