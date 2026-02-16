<?php
class BaseLinkerCart extends Cart {
	public $bl_shipping_cost = 0; // BaseLinker imposed shipping costs

	public function __construct($id = null, $idLang = null) {

		if (isset($_SERVER['REQUEST_METHOD']) and $_SERVER['REQUEST_METHOD'] == 'POST') // new cart
		{
			$this->webserviceParameters['fields']['bl_shipping_cost'] = array();
		}

		parent::__construct($id);
	}

	public function add($autoDate = true, $nullValues = false) {

		define('BL_SHIPPING_COST', $this->bl_shipping_cost);

		return parent::add($autoDate, $nullValues);
	}

	public function getDeliveryOption($default_country = null, $dontAutoSelectOptions = false, $use_cache = true) {

		return array($this->id_address_delivery => $this->id_carrier);
	}

	public function getPackageShippingCost($id_carrier = null, $use_tax = true, Country $default_country = null, $product_list = null, $id_zone = null, bool $keepOrderPrices = false) {

		if (defined(BL_SHIPPING_COST)) {
			return BL_SHIPPING_COST;
		}

		return parent::getPackageShippingCost($id_carrier, $use_tax, $default_country, $product_list, $id_zone, $keepOrderPrices);
	}
}
?>
