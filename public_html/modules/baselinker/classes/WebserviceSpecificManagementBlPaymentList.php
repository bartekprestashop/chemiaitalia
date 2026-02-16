<?php

class WebserviceSpecificManagementBlPaymentList implements WebserviceSpecificManagementInterface
{
    protected $objOutput;
    protected $output;
    protected $wsObject;
    public function setUrlSegment($segments)
    {
        $this->urlSegment = $segments;
        return $this;
    }
    public function getUrlSegment()
    {
        return $this->urlSegment;
    }

    public function getWsObject()
    {
        return $this->wsObject;
    }

    public function getObjectOutput()
    {
        return $this->objOutput;
    }

    public function getContent()
    {
        return $this->objOutput->getObjectRender()->overrideContent($this->output);
    }

    public function setWsObject(WebserviceRequest $obj)
    {
        $this->wsObject = $obj;
        return $this;
    }

    public function setObjectOutput(WebserviceOutputBuilder $obj)
    {
        $this->objOutput = $obj;
        return $this;
    }

    private static function getPaymentModules()
    {
        $sql = 'SELECT m.* FROM `' . _DB_PREFIX_ . 'hook_module` h 
INNER JOIN ' . _DB_PREFIX_ . 'module m ON m.id_module=h.id_module 
WHERE `id_hook` IN (SELECT id_hook FROM ' . _DB_PREFIX_ . 'hook WHERE name = "paymentOptions") AND 
m.active=1 GROUP BY m.id_module';
        
        return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
    }

    public function manage()
    {
        if (isset($this->wsObject->urlFragments['display']) && $this->wsObject->urlFragments['display'] === 'full') {
            $this->wsObject->fieldsToDisplay = 'full';
        }
        $objects_products = array();
        $objects_products['empty'] = new ModuleWs();
        $module_list = self::getPaymentModules();
        foreach ($module_list as $list) {
            $objects_products[] = new ModuleWs($list['id_module']);
        }
        $this->_resourceConfiguration = $objects_products['empty']->getWebserviceParameters();
        $this->output .= $this->objOutput->getContent(
            $objects_products, 
            null, 
            $this->wsObject->fieldsToDisplay,
            $this->wsObject->depth, 
            WebserviceOutputBuilder::VIEW_LIST,
            false
        );
    }
}
