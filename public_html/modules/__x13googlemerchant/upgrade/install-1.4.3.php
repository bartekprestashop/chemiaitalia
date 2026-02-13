<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once (dirname(__FILE__) . '/../x13googlemerchant.php');

function upgrade_module_1_4_3($module)
{
    Configuration::updateValue('X13_GOOGLEMERCHANT_EXCLUDE_EAN', 0);
    
    return true;
}
