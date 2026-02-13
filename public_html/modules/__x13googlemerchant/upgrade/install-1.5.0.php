<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

function upgrade_module_1_5_0($module)
{
    $module->registerHook('displayBackOfficeHeader');
    
    return true;
}
