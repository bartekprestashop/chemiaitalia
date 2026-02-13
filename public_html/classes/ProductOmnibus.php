<?php

class ProductOmnibus
{

    public $show;
    public $date;
    public $price_wt;
    public $price_wt_formated;
    public $old_price;

    public function __construct($id_product, $id_product_attribute = 0, $id_shop = 0)
    {

        if($id_shop == 0){
            $id_shop = (int)Context::getContext()->shop->id;
            $id_currency = (int)Context::getContext()->currency->id;
        }
        else {
            $id_currency = (int)Configuration::get('PS_CURRENCY_DEFAULT');
        }

        $sql_id_product_attribute = "";
        if((int)$id_product_attribute <> 0){
            $sql_id_product_attribute = 'and id_product_attribute='.$id_product_attribute.' ';
        }

        $sql2 = '
            SELECT price, price_wt, price_formated, price_wt_formated, date_unix FROM ' . _DB_PREFIX_ . 'bg_omnibus 
            where 
                id_shop='.$id_shop.' and 
                id_currency='.$id_currency.' and 
                id_product='.$id_product.' 
                '.$sql_id_product_attribute.'  
            order by price asc, date_unix asc
            ';


        $products_info = DB::getInstance()->executeS($sql2);

        if(is_array($products_info) && count($products_info) > 0){
            $product_info = $products_info[0];
        }
        else {
            $product_info = array();
        }


        $current_price = Product::getPriceStatic($id_product,true, null, 2, null, false);
        $regular_price = Product::getPriceStatic($id_product,true, null, 2, null, false, false);
        $product_old_price = $this->getOldPrice($id_product,$id_product_attribute);

        if($products_info){

            if($product_info['price_wt_formated'] <> ''){
                //new method

                $this->show = 2;
                $this->date = date('Y-m-d',$product_info['date_unix']);
                $this->price_wt = $product_info['price_wt'];
                $this->price_wt_formated = $product_info['price_wt_formated'];
                $this->old_price = $product_old_price;

            }
            else {
                //old

                $this->show = 1;
                $this->date = date('Y-m-d',$product_info['date_unix']);
                $this->price_wt = $product_info['price_wt'];
                $this->old_price = $product_old_price;

            }

        }
        else {
            $this->show = 1;
            $this->date = '-';
            $this->price_wt =  $regular_price;
            $this->old_price = '-';
        }


    }


    public static function getOldPrice($id_product,$id_product_attribute){

        //tutaj pobierz z bazy cena normalna brutto
        $sql = 'SELECT price, (SELECT rate FROM '._DB_PREFIX_.'tax where id_tax=product.id_tax_rules_group) as rate  FROM '._DB_PREFIX_.'product product where id_product="'.$id_product.'" ';
        $price_data = DB::getInstance()->executeS($sql);
        $price = $price_data[0]['price'] * (1+($price_data[0]['rate']/100));

        return round($price,2);

    }

}