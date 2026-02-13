<?php 




class bgomnibusajaxModuleFrontController extends ModuleFrontController
{   
    public $auth = false;  
    public $ajax;
 
    public function initContent()
    {
        header('Content-Type: application/json');
        $this->ajax = 1; 
 
       $data = Tools::getValue('products');

       if(empty($data))
       {
        echo Tools::jsonEncode('no products');
        die();
       }
       $res = [];
       foreach($data as $product)
       {    
       
            $sql2 = 'SELECT price_wt FROM ' . _DB_PREFIX_ . 'bg_omnibus where id_shop= 1 and id_product='.$product['id_product'].'  order by price desc, date_unix asc limit 1 ';
            $product_info = DB::getInstance()->executeS($sql2);

            if(!empty($product_info))
            {
                $res[] = array($product['id_product'],$product_info[0]['price_wt']);
            }else{
                $res[] = array($product['id_product'],'error');
            }
       }
        echo  Tools::jsonEncode($res);
        die();
        // $this->ajaxDie('Stats generated in '.($time_e-$time_s).'s');
    }

 
}