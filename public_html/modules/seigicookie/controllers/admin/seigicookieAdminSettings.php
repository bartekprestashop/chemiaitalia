<?php
    class seigicookieAdminSettingsController extends ModuleAdminControllerCore
    { public function display() {
          ToolsCore::redirectAdmin(Context::getContext()->link->getAdminLink('AdminModules', true).'&configure='.urlencode($this->module->name).'&tab_module='.$this->module->tab.'&module_name='.urlencode($this->module->name));
    }}