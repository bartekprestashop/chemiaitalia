<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_5_6()
{
    Configuration::updateValue('X13_GOOGLEMERCHANT_NOTAX_CR', '');

    return true;
}
