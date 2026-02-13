<?php

header('Access-Control-Allow-Origin: *');

$errorReportingLevel = E_ALL & ~E_DEPRECATED & ~E_NOTICE; 
@ini_set('display_errors', 'on');
@error_reporting($errorReportingLevel);
 
class bgomnibuscronModuleFrontController extends ModuleFrontController
{
    public $auth = false;  
    public $ajax;
 
    public function display()
    {

        $this->ajax = 1; 
 
        //for each shop
        //for each lang
        //for each product active=1

        //get price
        // Product::getPriceStatic(
        // $id_product,
        // $usetax = true,
        // $id_product_attribute = null,
        // $decimals = 6,
        // $divisor = null,
        // $only_reduc = false,
        // $usereduc = true,
        // $quantity = 1,
        // $force_associated_tax = false,
        // $id_customer = null,
        // $id_cart = null,
        // $id_address = null,
        // &$specific_price_output = null,
        // $with_ecotax = true,
        // $use_group_reduction = true,
        // Context $context = null,
        // $use_customer_price = true,
        // $id_customization = null);
    


        $time_s=date('U');


        $sql1='SELECT id_shop FROM '._DB_PREFIX_.'shop where active=1';
        $active_shops = DB::getInstance()->executeS($sql1);

        foreach($active_shops as $shop){
 
            $sql2 = 'SELECT * FROM '._DB_PREFIX_.'product_shop where active=1 and id_shop='.$shop['id_shop'].' ';
            $products = DB::getInstance()->executeS($sql2);

            foreach($products as $product){

                $specific_price_output=null;
                //TODO dodac obsluge atrybutow
                $id_product_attribute=$product['cache_default_attribute'];

                $product_price_wt = Product::getPriceStatic(
                                $product['id_product'],
                                true,
                                $id_product_attribute,
                                2,
                                null,
                                false,
                                true,
                                1,
                                false,
                                null,
                                null,
                                null,
                                $specific_price_output,//&$specific_price_output = 
                                false,
                                true,
                                null,
                                true,
                                null);


                $product_price = Product::getPriceStatic(
                                $product['id_product'],
                                false,
                                $id_product_attribute,
                                2,
                                null,
                                false,
                                true,
                                1,
                                false,
                                null,
                                null,
                                null,
                                $specific_price_output,//&$specific_price_output = 
                                false,
                                true,
                                null,
                                true,
                                null);



                                // null,//&$specific_price_output = 
                                // false,
                                // true,
                                // null,
                                // true,
                                // null);

                $sql3 = 'INSERT INTO `'._DB_PREFIX_.'bg_omnibus` 
                (`id_shop`, `id_product`, `id_product_attribute`, `price`, `price_wt`, `date_unix`) 
                VALUES 
                ("'.$shop['id_shop'].'", "'.$product['id_product'].'", "'.$product['cache_default_attribute'].'", "'.$product_price.'", "'.$product_price_wt.'", "'.date('U').'");';

                // echo $product['id_product'] . " -> ". $product_price."<br>";
                // echo $sql3."<br>";

                DB::getInstance()->execute($sql3);



            }


        }

        $time_e=date('U');


        




        $sql4 = 'INSERT INTO `'._DB_PREFIX_.'bg_omnibus_log` (`message`,`date`) VALUES ("Aktualizacja rekordow trwala '.($time_e-$time_s).'s","'.date('Ymd H:i:s').'");';
 
        // echo $sql4;
        DB::getInstance()->execute($sql4);





        $sql5 = 'DELETE FROM  `'._DB_PREFIX_.'bg_omnibus` where `date_unix` < "'.(date('U')-86400*32).'";';
        // echo $sql5;
        DB::getInstance()->execute($sql5);




        $this->ajaxDie('Stats generated in '.($time_e-$time_s).'s');
    }

 


}