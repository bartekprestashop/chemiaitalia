<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_5_2($module)
{
    Configuration::updateValue('X13_GOOGLEMERCHANT_ATTR_TITLE', 1);
    Configuration::updateValue('X13_GOOGLEMERCHANT_ATTR_DESC', 1);

    return true;
}
