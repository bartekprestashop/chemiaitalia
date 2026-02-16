<?php
class BaseLinkerOrder extends Order {
	public $bl_delivery_point_id;
	public $bl_delivery_point_name;
	public $bl_delivery_point_address;
	public $bl_delivery_point_city;
	public $bl_delivery_point_postcode;
	public $bl_delivery_method_id;
	public $bl_delivery_method;
	public $bl_want_invoice = -1;
	public $bl_test;
	public $bl_override = '';
	public $bl_module_version = '0.0.0';
	public $bl_block_sendmail = false; // do not send e-mail notification after order validation

	public function addWs($autodate = true, $null_values = false) {

		if ($this->bl_block_sendmail) {
			define('BL_BLOCK_NOTIFICATION', 1);
		}

		$payment_module = Module::getInstanceByName($this->module);
		$customer = new Customer($this->id_customer);
		$payment_module->validateOrder($this->id_cart, $this->current_state, $this->total_paid, $this->payment, null, array(), null, true, $customer->secure_key);
		$this->id = $payment_module->currentOrder;

        $pdInpostPaczkomatyExists = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
            'SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'pdinpostpaczkomatylist"'
        );

        if (isset($pdInpostPaczkomatyExists[0])) {
            $orderFields = $this->getFields();
            if (!empty($this->bl_delivery_point_id) && !empty($orderFields['id_cart'])) {
                $deliveryPoint = pSQL($this->bl_delivery_point_id);
                $sql = sprintf(
                    'INSERT INTO `%s` (id_cart, machine) VALUES (%s, \'%s\') ON DUPLICATE KEY UPDATE machine = \'%s\'',
                    _DB_PREFIX_ . 'pdinpostpaczkomatylist',
                    (int)$orderFields['id_cart'],
                    $deliveryPoint,
                    $deliveryPoint
                );
                Db::getInstance(_PS_USE_SQL_SLAVE_)->execute($sql);
            }
        }

        return true;
	}

	public function __construct($id = null, $id_lang = null) {

		if (isset($_SERVER['REQUEST_METHOD']) and $_SERVER['REQUEST_METHOD'] == 'POST') // OrderAdd
		{
			$this->webserviceParameters['fields']['current_state'] = array('xlink_resource' => 'order_states');
			$this->webserviceParameters['fields']['bl_block_sendmail'] = array();
            $this->webserviceParameters['fields']['bl_delivery_point_id'] = array();
            parent::__construct($id, $id_lang);
		}
		else // OrdersGet
		{
			if (!$id_lang)
			{
				$id_lang = Configuration::get('PS_LANG_DEFAULT');
			}

			self::$definition = parent::$definition;
			self::$definition['fields']['bl_delivery_point_id'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_point_name'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_point_address'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_point_city'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_point_postcode'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_method_id'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_delivery_method'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_want_invoice'] = array('type' => self::TYPE_INT);
			self::$definition['fields']['bl_test'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_override'] = array('type' => self::TYPE_STRING);
			self::$definition['fields']['bl_module_version'] = array('type' => self::TYPE_STRING);
			parent::__construct($id, $id_lang);
			$override = array();

			$module = Module::getInstanceByName('baselinker');
			$this->bl_module_version = $module->version;
		}

		if (!empty($id))
		{
			// X13 Allegro
			if ((string)$this->module == 'x13allegro')
			{
				$x13order = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT * FROM `' . _DB_PREFIX_ . 'xallegro_order` WHERE id_order = ' . (int)$this->id);
				if (isset($x13order[0]['checkout_form_content']))
				{
					$x13o = @json_decode($x13order[0]['checkout_form_content'], true);

					if (isset($x13o['delivery']))
					{
						$this->bl_delivery_method_id = $x13o['delivery']['method']['id'];
						$this->bl_delivery_method = $x13o['delivery']['method']['name'];
					}

					if (isset($x13o['delivery']['pickupPoint']))
					{
						$this->bl_delivery_point_name = $x13o['delivery']['pickupPoint']['name'];
						$this->bl_delivery_point_id = $x13o['delivery']['pickupPoint']['id'];

						if (isset($x13o['delivery']['pickupPoint']['address']))
						{
							$addr = $x13o['delivery']['pickupPoint']['address'];

							foreach (array('street' => 'address', 'zipCode' => 'postcode', 'city' => 'city') as $ps_fld => $bl_fld)
							{
								if (isset($addr[$ps_fld]))
								{
									$bl_fld = "bl_delivery_point_$bl_fld";
									$this->$bl_fld = $addr[$ps_fld];
								}
							}
						}
					}
				}

			}

			$carrier_name = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
				'SELECT name FROM `' . _DB_PREFIX_ . 'carrier` WHERE id_carrier = ' . (int)$this->id_carrier);
			$carrier_name = isset($carrier_name[0]) ? $carrier_name[0]['name'] : '';

			$res = array();

			if (preg_match('/paczkomat|inpost/i', $carrier_name))
			{
				// moduły sensbit
				if (Module::isInstalled('sensbitinpost') and Module::isEnabled('sensbitinpost'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT parcel_locker_name, address
						FROM `' . _DB_PREFIX_ . 'sensbitinpost_cart` sc
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitinpost_point` sp ON sp.name = sc.parcel_locker_name
						WHERE id_cart = ' . (int)$this->id_cart);
				}
				elseif (Module::isInstalled('sensbitpaczkomatymap') and Module::isEnabled('sensbitpaczkomatymap'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT parcel_locker_name, address
						FROM `' . _DB_PREFIX_ . 'sensbitpaczkomatymap_cart` sc
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitpaczkomatymap_point` sp ON sp.name = sc.parcel_locker_name
						WHERE id_cart = ' . (int)$this->id_cart);
				}

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['parcel_locker_name'];
					$this->bl_delivery_point_id = $res[0]['parcel_locker_name'];

					if (!empty($res[0]['address']) && preg_match('/^(.+?), (\d\d-\d{3}) (.+)$/', $res[0]['address'], $m))
					{
						$this->bl_delivery_point_address = $m[1];
						$this->bl_delivery_point_postcode = $m[2];
						$this->bl_delivery_point_city = $m[3];
					}
				}

				// pozostałe moduły paczkomatów
				if (empty($this->bl_delivery_point_name) and Module::isInstalled('pminpostpaczkomaty') and Module::isEnabled('pminpostpaczkomaty'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW FIELDS FROM `' . _DB_PREFIX_ . 'pminpostpaczkomatylist` LIKE "id_%"');

					if (isset($res[0]))
					{
						foreach ($res as $row)
						{
							if (preg_match('/order|cart/', $row['Field']))
							{
								$fld = $row['Field'];
								$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
									'SELECT machine
									FROM `' . _DB_PREFIX_ . 'pminpostpaczkomatylist` 
									WHERE `' . $fld . '` = ' . (int)$this->$fld);

								if (isset($res[0]))
								{
									$this->bl_delivery_point_name = $res[0]['machine'];
									$this->bl_delivery_point_id = $res[0]['machine'];
								}

								break;
							}
						}
					}
				}

				if (empty($this->bl_delivery_point_name) and Module::isInstalled('inpostship') and Module::isEnabled('inpostship'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT isc.receiver_machine delivery_point_name, isp.point_address1 delivery_point_address, substr(isp.point_address2, 1, 6) delivery_point_postcode, substr(isp.point_address2, 8) delivery_point_city

						FROM `' . _DB_PREFIX_ . 'inpostship_cart` isc
						LEFT JOIN `' . _DB_PREFIX_ . 'inpostship_points` isp ON isc.receiver_machine = isp.point_code
						WHERE `id_cart` = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_name = $res[0]['delivery_point_name'];
						$this->bl_delivery_point_id = $res[0]['delivery_point_name'];
						$this->bl_delivery_point_address = $res[0]['delivery_point_address'];
						$this->bl_delivery_point_postcode = $res[0]['delivery_point_postcode'];
						$this->bl_delivery_point_city = $res[0]['delivery_point_city'];
					}
				}

				// wtyczka Inpost od PrestaDev
				if (empty($this->bl_delivery_point_name) and Module::isInstalled('pdinpostpaczkomaty') and Module::isEnabled('pdinpostpaczkomaty'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW FIELDS FROM `' . _DB_PREFIX_ . 'pdinpostpaczkomatylist` LIKE "id_%"');

					if (isset($res[0]))
					{
						foreach ($res as $row)
						{
							if (preg_match('/order|cart/', $row['Field']))
							{
								$fld = $row['Field'];
								$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
									'SELECT machine
									FROM `' . _DB_PREFIX_ . 'pdinpostpaczkomatylist` 
									WHERE `' . $fld . '` = ' . (int)$this->$fld);

								if (isset($res[0]))
								{
									$this->bl_delivery_point_name = $res[0]['machine'];
									$this->bl_delivery_point_id = $res[0]['machine'];
								}

								break;
							}
						}
					}
				}

				// InPost Shipping
				if (empty($this->bl_delivery_point_name) and Module::isInstalled('inpostshipping') and Module::isEnabled('inpostshipping'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT * FROM `' . _DB_PREFIX_ . 'inpost_cart_choice`
						WHERE `id_cart` = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_name = $res[0]['point'];
						$this->bl_delivery_point_id = $res[0]['point'];

						if (!empty($res[0]['phone']))
						{
							$override['phone'] = $res[0]['phone'];
						}
					}
				}

                // Sendcloud
                if (empty($this->bl_delivery_point_name) && Module::isInstalled('sendcloudv2') && Module::isEnabled('sendcloudv2')) {
                    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                        'SELECT * FROM `' . _DB_PREFIX_ . 'service_points_v2`
						WHERE `id_cart` = ' . (int)$this->id_cart);

                    if (isset($res[0]) && !empty($res[0]['details'])) {
                        $pointDetails = json_decode($res[0]['details'], true);

                        if (!empty($pointDetails['code'])) {
                            $this->bl_delivery_point_id = $pointDetails['code'];
                        }
                        if (!empty($pointDetails['name'])) {
                            $this->bl_delivery_point_name = $pointDetails['name'];
                        }
                        if (!empty($pointDetails['street'])) {
                            $this->bl_delivery_point_address = $pointDetails['street'];
                        }
                        if (!empty($pointDetails['house_number'])) {
                            $this->bl_delivery_point_address .= ' ' . $pointDetails['house_number'];
                        }
                        if (!empty($pointDetails['postal_code'])) {
                            $this->bl_delivery_point_postcode = $pointDetails['postal_code'];
                        }
                        if (!empty($pointDetails['city'])) {
                            $this->bl_delivery_point_city = $pointDetails['city'];
                        }
                    }
                }
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/dpd/i', $carrier_name) and preg_match('/punk/i', $carrier_name))
			{
				if (Module::isInstalled('dpdpoland') and Module::isEnabled('dpdpoland'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT pudo_code
						FROM `' . _DB_PREFIX_ . 'dpdpoland_pudo_cart`
						WHERE id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['pudo_code'];
						$this->bl_delivery_point_name = $res[0]['pudo_code'];
					}
				}

			}

			if (empty($this->bl_delivery_point_name) and preg_match('/gls/i', $carrier_name) and preg_match('/punk/i', $carrier_name))
			{
				if (empty($this->bl_delivery_point_name) and Module::isInstalled('sensbitgls') and Module::isEnabled('sensbitgls'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT sgls.id_point, address
						FROM `' . _DB_PREFIX_ . 'sensbitgls_cart` sgls
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitgls_point` sp ON sp.name = sgls.id_point
						WHERE sgls.id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['id_point'];
						$addr = explode(', ', $res[0]['address']);
						array_pop($addr); // country
						$this->bl_delivery_point_city = array_pop($addr);

						if (preg_match('/(\d\d-\d{3}) (.+)$/', $this->bl_delivery_point_city, $m))
						{
							$this->bl_delivery_point_postcode = $m[1];
							$this->bl_delivery_point_city = $m[2];
						}

						$this->bl_delivery_point_address = array_pop($addr);
						$this->bl_delivery_point_name = array_pop($addr);
					}
				}

			}

			if (empty($this->bl_delivery_point_name) and preg_match('/ruch|poczta|paczkomat|inpost international|dhl pop|orlen|dpd|dhl/i', $carrier_name))
			{
				if (Module::isInstalled('furgonetka') and Module::isEnabled('furgonetka'))
				{
					$check_table = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'furgonetka_cart_delivery_machine"');

					if (isset($check_table[0]))
					{
						$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
							'SELECT machine_name, machine_code, machine_type
							FROM `' . _DB_PREFIX_ . 'furgonetka_cart_delivery_machine` fm 
							WHERE id_cart = ' . (int)$this->id_cart);

						if (isset($res[0]))
						{
							$dp = $res[0];
							$this->bl_delivery_point_id = $dp['machine_code'];
							$this->bl_delivery_point_name = $dp['machine_code'];

							if ($dp['machine_type'] == 'ruch' and preg_match('/^(.+), ([^,]+)$/', $dp['machine_name'], $m))
							{
								$this->bl_delivery_point_city = $m[2];
								$this->bl_delivery_point_address = $m[1];
							}
							elseif ($dp['machine_type'] == 'inpost' and preg_match('/^(\w+ - )?(.+), ([^,]+) (\d\d-\d{3})$/', $dp['machine_name'], $m))
							{
								$this->bl_delivery_point_city = $m[3];
								$this->bl_delivery_point_address = $m[2];
								$this->bl_delivery_point_postcode = $m[4];
							}
							elseif ($dp['machine_type'] == 'dhl')
							{
								$this->bl_delivery_point_id = $dp['machine_code'];
								$this->bl_delivery_point_address = $dp['machine_name'];

								if (preg_match('/^(.+?) - (.+?), (\d\d-\d{3}) (.+)/', $dp['machine_name'], $m))
								{
									$this->bl_delivery_point_name = $m[1];
									$this->bl_delivery_point_address = $m[2];
									$this->bl_delivery_point_postcode = $m[3];
									$this->bl_delivery_point_city = $m[4];
								}
							}
							else // dpd
							{
								$this->bl_delivery_point_address = $dp['machine_name'];

								if (preg_match('/^(.+?) -\s*(.+?), (\d\d-\d{3}) (.+)/', $dp['machine_name'], $m))
								{
									if ($m[1] == $this->bl_delivery_point_id)
									{
										$this->bl_delivery_point_address = $m[2];
									}
									else
									{
										$this->bl_delivery_point_address = $m[1] . ' - ' . $m[2];
									}

									$this->bl_delivery_point_postcode = $m[3];
									$this->bl_delivery_point_city = $m[4];
								}
							}
						}
					}
				}
			}

			if (preg_match('/parcelshop|punk.+?dhl|dhl.+?punk/i', $carrier_name))
			{
				if (empty($this->bl_delivery_point_name) and Module::isInstalled('sensbitdhl') and Module::isEnabled('sensbitdhl'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT sdhl.id_point, address
						FROM `' . _DB_PREFIX_ . 'sensbitdhl_cart` sdhl
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitdhl_point` sp ON sp.name = sdhl.id_point
						WHERE sdhl.id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['id_point'];
						$addr = explode(', ', $res[0]['address']);
						array_pop($addr);
						$this->bl_delivery_point_city = array_pop($addr);

						if (preg_match('/(\d\d-\d{3}) (.+)$/', $this->bl_delivery_point_city, $m))
						{
							$this->bl_delivery_point_postcode = $m[1];
							$this->bl_delivery_point_city = $m[2];
						}

						$this->bl_delivery_point_address = array_pop($addr);
						$this->bl_delivery_point_name = array_pop($addr);
					}
				}

			}

			if (empty($this->bl_delivery_point_name) and preg_match('/ruch|poczta|paczkomat|inpost international|dhl pop|orlen|dpd|dhl/i', $carrier_name))
			{
				if (Module::isInstalled('furgonetka') and Module::isEnabled('furgonetka'))
				{
					$check_table = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'furgonetka_cart_delivery_machine"');

					if (isset($check_table[0]))
					{
						$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
							'SELECT machine_name, machine_code, machine_type
							FROM `' . _DB_PREFIX_ . 'furgonetka_cart_delivery_machine` fm 
							WHERE id_cart = ' . (int)$this->id_cart);

						if (isset($res[0]))
						{
							$dp = $res[0];
							$this->bl_delivery_point_name = $dp['machine_code'];

							if ($dp['machine_type'] == 'ruch' and preg_match('/^(.+), ([^,]+)$/', $dp['machine_name'], $m))
							{
								$this->bl_delivery_point_city = $m[2];
								$this->bl_delivery_point_address = $m[1];
							}
							elseif ($dp['machine_type'] == 'inpost' and preg_match('/^(\w+ - )?(.+), ([^,]+) (\d\d-\d{3})$/', $dp['machine_name'], $m))
							{
								$this->bl_delivery_point_city = $m[3];
								$this->bl_delivery_point_address = $m[2];
								$this->bl_delivery_point_postcode = $m[4];
							}
							elseif ($dp['machine_type'] == 'dhl')
							{
								$this->bl_delivery_point_id = $dp['machine_code'];
								$this->bl_delivery_point_address = $dp['machine_name'];

								if (preg_match('/^(.+?) - (.+?), (\d\d-\d{3}) (.+)/', $dp['machine_name'], $m))
								{
									$this->bl_delivery_point_name = $m[1];
									$this->bl_delivery_point_address = $m[2];
									$this->bl_delivery_point_postcode = $m[3];
									$this->bl_delivery_point_city = $m[4];
								}
							}
							else
							{
								$this->bl_delivery_point_address = $dp['machine_name'];
							}
						}
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/ruchu/i', $carrier_name))
			{
				if (Module::isInstalled('paczkawruchu') and Module::isEnabled('paczkawruchu'))
				{
					$check_table = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'paczkawruchu"');

					if (isset($check_table[0]))
					{
						$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
							'SELECT poper
							FROM `' . _DB_PREFIX_ . 'paczkawruchu` 
							WHERE id_cart = ' . (int)$this->id_cart . ' OR id_order = ' . (int)$this->id);

						if (isset($res[0]))
						{
							$dp = $res[0];
							$this->bl_delivery_point_name = $dp['poper'];
						}
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/inpost|paczkoma/i', $carrier_name))
			{
				if ($checkout_session_data = Db::getInstance()->getValue('
					SELECT `checkout_session_data`
					FROM `' . _DB_PREFIX_ . 'cart`
					JOIN `' . _DB_PREFIX_ . 'orders` USING (`id_cart`)
					WHERE `id_order` = ' . (int)$this->id)) {

					$checkout_session_data = json_decode($checkout_session_data, true);

					if (isset($checkout_session_data['st-checkout-delivery-step']['selected_paczkomat'])) {
						$this->bl_delivery_point_name = $checkout_session_data['st-checkout-delivery-step']['selected_paczkomat'];
						$this->bl_delivery_point_id = $checkout_session_data['st-checkout-delivery-step']['selected_paczkomat'];
					}
				}
			}

			if (empty($this->bl_delivery_point_name) 
				and ((Module::isInstalled('gmparcellocker') and Module::isEnabled('gmparcellocker'))
			       	or (Module::isInstalled('gmpickup') and Module::isEnabled('gmpickup'))))
			{
				// kod od udostępniony przez GreenMouseStudio, ref #7n4ojpwayx12626
				$carrier = new Carrier($this->id_carrier);

				if ($carrier->external_module_name == 'gmparcellocker')
				{
                    $m = Module::getInstanceByName('gmparcellocker');
                    if (method_exists($m, 'getParcelAddressForCart')) {
                        $parcel = $m->getParcelAddressForCart((int) $this->id_cart);
                        $this->bl_delivery_point_name = $parcel['parcel_name'];
                        $this->bl_delivery_point_id = $parcel['parcel_name'];
                        $this->bl_delivery_point_address = $parcel['address'];
                        $this->bl_delivery_point_postcode = $parcel['postcode'];
                        $this->bl_delivery_point_city = $parcel['city'];
                    } elseif (method_exists($m, 'getPointDataForCart')) {
                        $parcel = $m->getPointDataForCart((int) $this->id_cart);
                        $pattern = '/^(\w+)\s+([\p{L}\s]+\d+)\s+(\d{2}-\d{3})\s+([\p{L}\s]+)$/u';
                        if (preg_match($pattern, $parcel, $matches)) {
                            $this->bl_delivery_point_id = $matches[1];
                            $this->bl_delivery_point_name = $matches[1];
                            $this->bl_delivery_point_address = $matches[2];
                            $this->bl_delivery_point_postcode = $matches[3];
                            $this->bl_delivery_point_city = $matches[4];
                        }
                    }
				}

				if ($carrier->external_module_name == 'gmpickup')
				{
					$m = Module::getInstanceByName('gmpickup');
					$storeId = $m->getSelectedStoreIdForCart((int) $this->id_cart);
					$store = new Store($storeId, $id_lang);
					$this->bl_delivery_point_name = $store->name;
					$this->bl_delivery_point_id = $store->name;
					$this->bl_delivery_point_address = $store->address1.' '.$store->address2;
					$this->bl_delivery_point_postcode = $store->postcode;
					$this->bl_delivery_point_city = $store->city;
				}
				// GM end
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/punk|pocz|żabka|orlen|ruch/iu', $carrier_name) and Module::isInstalled('sensbitpocztapolska') and Module::isEnabled('sensbitpocztapolska'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT sppc.id_place, name, address
					FROM `' . _DB_PREFIX_ . 'sensbitpocztapolska_cart` sppc
					JOIN `' . _DB_PREFIX_ . 'sensbitpocztapolska_place` sppp ON sppc.id_place = sppp.id_place
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['name'];
					$this->bl_delivery_point_address = $res[0]['address'];
					$this->bl_delivery_point_id = $res[0]['id_place'];

					if (preg_match('/^(.+?), (\d\d-\d{3}) (.+)$/', $res[0]['address'], $m))
					{
						$this->bl_delivery_point_address = $m[1];
						$this->bl_delivery_point_postcode = $m[2];
						$this->bl_delivery_point_city = $m[3];
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/punk|pocz|żabka|orlen|ruch/iu', $carrier_name) and Module::isInstalled('sensbitpocztapolskamap') and Module::isEnabled('sensbitpocztapolskamap'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT sppc.id_place, name, address
					FROM `' . _DB_PREFIX_ . 'sensbitpocztapolskamap_cart` sppc
					LEFT JOIN `' . _DB_PREFIX_ . 'sensbitpocztapolskamap_place` sppp ON sppc.id_place = sppp.id_place
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['name'];
					$this->bl_delivery_point_address = $res[0]['address'];
					$this->bl_delivery_point_id = $res[0]['id_place'];

					if (preg_match('/^(.+?), (\d\d-\d{3}) (.+)$/', $res[0]['address'], $m))
					{
						$this->bl_delivery_point_address = $m[1];
						$this->bl_delivery_point_postcode = $m[2];
						$this->bl_delivery_point_city = $m[3];
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and preg_match('/w ruchu|paczka|orlen/iu', $carrier_name) and Module::isInstalled('sensbitpaczkawruchumap') and Module::isEnabled('sensbitpaczkawruchumap'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT sppp.id_place, name, address
					FROM `' . _DB_PREFIX_ . 'sensbitpaczkawruchumap_cart` sppc
					LEFT JOIN `' . _DB_PREFIX_ . 'sensbitpaczkawruchumap_place` sppp ON sppc.id_place = sppp.name
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['name'];
					$this->bl_delivery_point_address = $res[0]['address'];
					$this->bl_delivery_point_id = $res[0]['id_place'];

					if (preg_match('/^(.+?), (.+)$/', $res[0]['address'], $m))
					{
						$this->bl_delivery_point_address = $m[1];
						$this->bl_delivery_point_city = $m[2];
					}
				}
			}

			// starsza wersja
			if (empty($this->bl_delivery_point_name) and preg_match('/w ruchu|paczka|orlen/iu', $carrier_name) and Module::isInstalled('sensbitpaczkawruchu') and Module::isEnabled('sensbitpaczkawruchu'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT sppc.point, address
					FROM `' . _DB_PREFIX_ . 'sensbitpaczkawruchu_cart` sppc
					LEFT JOIN `' . _DB_PREFIX_ . 'sensbitpaczkawruchu_point` sppp ON sppc.point = sppp.name
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['point'];
					$this->bl_delivery_point_address = $res[0]['address'];

					if (preg_match('/^(.+?), (\d\d-\d{3}) (.+)$/', $res[0]['address'], $m))
					{
						$this->bl_delivery_point_address = $m[1];
						$this->bl_delivery_point_postcode = $m[2];
						$this->bl_delivery_point_city = $m[3];
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and empty($this->bl_delivery_point_id) and preg_match('/poczt|punk/iu', $carrier_name) and Module::isInstalled('pocztapolskaen') and Module::isEnabled('pocztapolskaen'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT point, pni
					FROM `' . _DB_PREFIX_ . 'pocztapolskaen_order`
					WHERE id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $res[0]['pni'];
					$this->bl_delivery_point_address = $res[0]['point'];
					$this->bl_delivery_point_id = $res[0]['pni'];

					if (preg_match('/^(.+?), (.+?), (\d\d-\d{3}) (.+)$/', $res[0]['point'], $m))
					{
						$this->bl_delivery_point_name = $m[1];
						$this->bl_delivery_point_address = $m[2];
						$this->bl_delivery_point_postcode = $m[3];
						$this->bl_delivery_point_city = $m[4];
					}
				}
			}

			if (empty($this->bl_delivery_point_name) and empty($this->bl_delivery_point_id) and preg_match('/ruch/i', $carrier_name) and Module::isInstalled('ruch') and Module::isEnabled('ruch'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT point
					FROM `' . _DB_PREFIX_ . 'ruch_cart_point`
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['point'];
					$this->bl_delivery_point_name = $res[0]['point'];
				}
			}

			// Moduł Orlen Paczka (RUCH)
			if (empty($this->bl_delivery_point_name) and preg_match('/orlen|ruch/i', $carrier_name) and Module::isInstalled('ruch') and Module::isEnabled('ruch'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT point
					FROM `' . _DB_PREFIX_ . 'ruch_cart_point`
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $this->bl_delivery_point_id = preg_replace('/^\w+:/', '', $res[0]['point']);
				}
			}

			// Zasilkovny Packeta.com
			if (empty($this->bl_delivery_point_name) and preg_match('/sie?lkov|packeta/i', $carrier_name) and Module::isInstalled('packetery') and Module::isEnabled('packetery'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'packetery_order`
					WHERE id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_name = $this->bl_delivery_point_id = $res[0]['id_branch'];
					$this->bl_delivery_point_address = $res[0]['name_branch'];
				}
			}

			// Venipak
			if (empty($this->bl_delivery_point_name) and preg_match('/venipak/i', $carrier_name) and Module::isInstalled('mijoravenipak') and Module::isEnabled('mijoravenipak'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'mjvp_orders`
					WHERE id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['terminal_id'];

					if ($addr = @json_decode($res[0]['terminal_info'], true))
					{
						$this->bl_delivery_point_name = $addr['name'];
						$this->bl_delivery_point_city = $addr['city'];
						$this->bl_delivery_point_postcode = $addr['post_code'];
						$this->bl_delivery_point_address = $addr['address'];
					}
				}
			}

			// Magyar Posta: PostaPont and MPL  by PWS Online Kft.
			if (empty($this->bl_delivery_point_name) and preg_match('/postapont/i', $carrier_name) and Module::isInstalled('magyarposta') and Module::isEnabled('magyarposta'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'order2postapont`
					WHERE id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['id_postapont'];

					if ($dp = @unserialize(stripslashes($res[0]['selected_data'])))
					{
						$this->bl_delivery_point_name = $dp['name'];
						$this->bl_delivery_point_address = $dp['address'];
						$this->bl_delivery_point_city = $dp['county'];
						$this->bl_delivery_point_postcode = $dp['zip'];
					}
				}
			}

			// DPD Pickup
			if (preg_match('/dpd/i', $carrier_name))
			{
				// moduł sensbit
				if (Module::isInstalled('sensbitdpdmap') and Module::isEnabled('sensbitdpdmap'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT id_point, address
						FROM `' . _DB_PREFIX_ . 'sensbitdpdmap_cart` sc
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitdpdmap_point` sp ON sp.name = sc.id_point
						WHERE id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['id_point'];
						$this->bl_delivery_point_address = $res[0]['address'];

						if (preg_match('/^(.+?), (.+?), (\d\d-\d{3}) ([\w\s\-]+)$/u', $res[0]['address'], $m))
						{
							$this->bl_delivery_point_name = $m[1];
							$this->bl_delivery_point_address = $m[2];
							$this->bl_delivery_point_city = $m[4];
							$this->bl_delivery_point_postcode = $m[3];
						}
					}
				}
				if (Module::isInstalled('sensbitdpd') and Module::isEnabled('sensbitdpd'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT id_point, address
						FROM `' . _DB_PREFIX_ . 'sensbitdpd_cart` sc
						LEFT JOIN `' . _DB_PREFIX_ . 'sensbitdpd_point` sp ON sp.name = sc.id_point
						WHERE id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['id_point'];
						$this->bl_delivery_point_address = $res[0]['address'];

						if (preg_match('/^(.+?), (.+?), (\d\d-\d{3}) ([\w\s\-]+)$/u', $res[0]['address'], $m))
						{
							$this->bl_delivery_point_name = $m[1];
							$this->bl_delivery_point_address = $m[2];
							$this->bl_delivery_point_city = $m[4];
							$this->bl_delivery_point_postcode = $m[3];
						}
					}
				}
			}

			// DHL Parcelshop
			if (preg_match('/dhl/i', $carrier_name))
			{
				if (Module::isInstalled('dhlassistant') and Module::isEnabled('dhlassistant'))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT ParcelIdent point_id
						FROM `' . _DB_PREFIX_ . 'dhla_sourceorderadditionalparams` 
						WHERE IdSourceObject = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_delivery_point_id = $res[0]['point_id'];
						$this->bl_delivery_point_name = $res[0]['point_id'];
					}
				}
			}

            // DPDPoland Pickup
            if (empty($this->bl_delivery_point_name) && preg_match('/dpd/i', $carrier_name))
            {
                if (count(DB::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'dpdpoland_pudo_cart"'))) {
                    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                        'SELECT pudo_code 
						FROM `' . _DB_PREFIX_ . 'dpdpoland_pudo_cart` d
						WHERE id_cart = ' . (int)$this->id_cart);

                    if (isset($res[0]))
                    {
                        $this->bl_delivery_point_id = $res[0]['pudo_code'];

                    }
                }
            }

            if (empty($this->bl_delivery_point_id) && preg_match('/dpd/i', $carrier_name))
            {
                if (count(DB::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'dpdshipping_cart_pickup"'))) {
                    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                        'SELECT pudo_code 
						FROM `' . _DB_PREFIX_ . 'dpdshipping_cart_pickup` d
						WHERE id_cart = ' . (int)$this->id_cart);

                    if (isset($res[0]))
                    {
                        $this->bl_delivery_point_id = $res[0]['pudo_code'];

                    }
                }
            }

            if (empty($this->bl_delivery_point_name) and preg_match('/sie?lkov/i', $carrier_name) and Module::isInstalled('shaim_zasilkovna_widget') and Module::isEnabled('shaim_zasilkovna_widget'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'shaim_zasilkovna_widget_data`
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['id'];
					$this->bl_delivery_point_name = $res[0]['place'];
					$this->bl_delivery_point_address = $res[0]['street'];
					$this->bl_delivery_point_city = $res[0]['city'];
					$this->bl_delivery_point_postcode = $res[0]['psc'];
				}
			}

			// Balík na Poštu
			if (empty($this->bl_delivery_point_name) and preg_match('/bal[ií]k na p/iu', $carrier_name) and Module::isInstalled('shaim_baliknapostu') and Module::isEnabled('shaim_baliknapostu'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'shaim_baliknapostu_data` bnpd
					LEFT JOIN `' . _DB_PREFIX_ . 'shaim_baliknapostu` bnp ON bnp.psc = bnpd.psc
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['psc'];
					$this->bl_delivery_point_name = $res[0]['naz_prov'];
					$this->bl_delivery_point_address = $res[0]['adresa'];

					if (preg_match('/^(.+), (\d{5}), ([^,]+)$/', $this->bl_delivery_point_address, $m))
					{
						$this->bl_delivery_point_city = $m[3];
						$this->bl_delivery_point_postcode = $m[2];
						$this->bl_delivery_point_address = $m[1];
					}
				}
			}

			// Balikovna
			if (empty($this->bl_delivery_point_name) and Module::isInstalled('shaim_balikovna') and Module::isEnabled('shaim_balikovna'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT *
					FROM `' . _DB_PREFIX_ . 'shaim_balikovna_data` bd
					LEFT JOIN `' . _DB_PREFIX_ . 'shaim_balikovna` b ON b.psc = bd.psc
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['psc'];
					$this->bl_delivery_point_name = $res[0]['naz_prov'];
					$this->bl_delivery_point_address = $res[0]['adresa'];

					if (preg_match('/^(.+?), (\d{5}), ([^,]+)$/', $res[0]['adresa'], $m))
					{
						if ($m[3] == $res[0]['okres'])
						{
							$this->bl_delivery_point_address = $m[1];
							$this->bl_delivery_point_postcode = $m[2];
							$this->bl_delivery_point_city = $m[3];
						}
					}
				}
			}

			// b4n_gls_parcelshop
			if (empty($this->bl_delivery_point_name) and (preg_match('/gls/i', $carrier_name)) and Module::isInstalled('b4n_gls_parcelshop') and Module::isEnabled('b4n_gls_parcelshop'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT gpso.*
					FROM `' . _DB_PREFIX_ . 'b4n_gls_parcelshop_orders` gpso
					WHERE gpso.id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['branch_id'];
					$this->bl_delivery_point_name = $res[0]['branch_name'];
					$this->bl_delivery_point_address = $res[0]['branch_address'];
					$this->bl_delivery_point_city = $res[0]['branch_city'];
					$this->bl_delivery_point_postcode = $res[0]['branch_zip'];
				}
			}

			// shaim_glsparcelshop
			if (empty($this->bl_delivery_point_name) and (preg_match('/gls/i', $carrier_name)) and Module::isInstalled('shaim_glsparcelshop') and Module::isEnabled('shaim_glsparcelshop'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT g.*
					FROM `' . _DB_PREFIX_ . 'shaim_glsparcelshop_data` gd
					LEFT JOIN `' . _DB_PREFIX_ . 'shaim_glsparcelshop` g ON g.id = gd.id
					WHERE gd.id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['id'];
					$this->bl_delivery_point_postcode = $res[0]['psc'];
					$this->bl_delivery_point_name = $res[0]['naz_prov'];
					$this->bl_delivery_point_address = $res[0]['adresa'];
					$this->bl_delivery_point_city = $res[0]['okres'];
				}
			}

			// shaim_pplparcelshop
			if (empty($this->bl_delivery_point_name) and (preg_match('/ppl/i', $carrier_name) ) and Module::isInstalled('shaim_pplparcelshop') and Module::isEnabled('shaim_pplparcelshop'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT g.*
					FROM `' . _DB_PREFIX_ . 'shaim_pplparcelshop_data` gd
					LEFT JOIN `' . _DB_PREFIX_ . 'shaim_pplparcelshop` g ON g.id = gd.id
					WHERE gd.id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['id'];
					$this->bl_delivery_point_postcode = $res[0]['psc'];
					$this->bl_delivery_point_name = $res[0]['naz_prov'];
					$this->bl_delivery_point_address = $res[0]['adresa'];
					$this->bl_delivery_point_city = $res[0]['okres'];
				}
			}

			// Sameday
			if (empty($this->bl_delivery_point_name) and preg_match('/sameday/i', $carrier_name) and Module::isInstalled('samedaycourier') and Module::isEnabled('samedaycourier'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT * 
					FROM `' . _DB_PREFIX_ . 'sameday_order_locker` sol
					JOIN `' . _DB_PREFIX_ . 'sameday_lockers` sl ON sl.id_locker = sol.id_locker
					WHERE sol.id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_delivery_point_id = $res[0]['id_locker'];
					$this->bl_delivery_point_name = $res[0]['name'];
					$this->bl_delivery_point_address = $res[0]['address'];
					$this->bl_delivery_point_postcode = $res[0]['postal_code'];
					$this->bl_delivery_point_city = $res[0]['postal_city'];

					if (!empty($res[0]['county']))
					{
						$this->bl_delivery_point_city .= ', ' . $res[0]['county'];
					}
				}
			}
			if(empty($this->bl_delivery_point_name) && Module::isInstalled('globkurier2') && Module::isEnabled('globkurier2')) {
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					"SELECT * FROM "._DB_PREFIX_."gk_terminal_pickup WHERE cart_id = ".(int)$this->id_cart);
                if (isset($res[0])) {
                    $this->bl_delivery_point_id = $res[0]['id'];
				}
			}

			// wybór faktury
			if (Module::isInstalled('fakturaparagon') and Module::isEnabled('fakturaparagon'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT status
					FROM `' . _DB_PREFIX_ . 'fakturaparagon` 
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_want_invoice = ($res[0]['status'] == 1) ? 1 : 0;
				}
			}

			if (Module::isInstalled('paragonfaktura') and Module::isEnabled('paragonfaktura'))
			{
				if (count(DB::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'invoice_bill"')))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT document_type
						FROM `' . _DB_PREFIX_ . 'invoice_bill` 
						WHERE id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_want_invoice = ($res[0]['document_type'] == 1) ? 1 : 0;
					}
				}
				else
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT choice
						FROM `' . _DB_PREFIX_ . 'pf` 
						WHERE id_cart = ' . (int)$this->id_cart);

					if (isset($res[0]))
					{
						$this->bl_want_invoice = ($res[0]['choice'] == 1) ? 1 : 0;
					}
				}
			}

			if (Module::isInstalled('twparagonfaktura') and Module::isEnabled('twparagonfaktura'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT document_type
					FROM `' . _DB_PREFIX_ . 'tw_paragonfaktura` 
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_want_invoice = ($res[0]['document_type'] == 'Invoice') ? 1 : 0;
				}
			}

			if (Module::isInstalled('x13paragonlubfaktura') and Module::isEnabled('x13paragonlubfaktura'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT recieptorinvoice doc
					FROM `' . _DB_PREFIX_ . 'x13recieptorinvoice` 
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_want_invoice = ($res[0]['doc'] == 'invoice') ? 1 : 0;
				}
			}

			if (Module::isInstalled('paragonczyfaktura') and Module::isEnabled('paragonczyfaktura'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT invoice_or_bill
					FROM `' . _DB_PREFIX_ . 'orders` 
					WHERE id_order = ' . (int)$this->id);

				if (isset($res[0]))
				{
					$this->bl_want_invoice = ($res[0]['invoice_or_bill'] == 1) ? 1 : 0;
				}
			}

			if (Module::isInstalled('pdinvoicebillpro') and Module::isEnabled('pdinvoicebillpro'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT chosen
					FROM `' . _DB_PREFIX_ . 'pdinvoicebillpro` 
					WHERE id_cart = ' . (int)$this->id_cart);

				if (isset($res[0]))
				{
					$this->bl_want_invoice = ($res[0]['chosen'] == 1) ? 1 : 0;
				}
			}

			// -- contributed by seigi.eu --
			if (empty($this->bl_delivery_point_name) and Module::isInstalled('seigideliverymanager') and Module::isEnabled('seigideliverymanager'))
			{
				$sdm = Module::getInstanceByName('seigideliverymanager');
				$sdm->getPointDataForOrder($this);
			}
			// -- end contribution --

            if(empty($this->bl_delivery_point_id) && Module::isInstalled('polkurier') && Module::isEnabled('polkurier'))
            {
                $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                    'SELECT *
					FROM `' . _DB_PREFIX_ . 'pk_collection_point`
					WHERE id_cart = ' . (int)$this->id_cart);

                if (isset($res[0]))
                {
                    $this->bl_delivery_point_id = $res[0]['collection_point'];
                    $this->bl_delivery_point_name = $res[0]['collection_point'];
                }
            }

            if(empty($this->bl_delivery_point_id) && Module::isInstalled('dhlassistant') && Module::isEnabled('dhlassistant'))
            {
                $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                    'SELECT *
					FROM `' . _DB_PREFIX_ . 'dhla_shipment`
					WHERE Id = ' . (int)$this->id_cart);

                if (isset($res[0]))
                {
                    $this->bl_delivery_point_id = $res[0]['ParcelIdent'];
                    $this->bl_delivery_point_postcode = $res[0]['ParcelPostalCode'];
                    $this->bl_delivery_point_name = $res[0]['ParcelIdent'];
                }
            }

            // wtyczka paxypresta
            if (empty($this->bl_delivery_point_id) && preg_match('/venipak/i', $carrier_name)) {
                if (Module::isInstalled('paxypresta') && Module::isEnabled('paxypresta')) {
                    $checkTable = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'paxy_order_point"');
                    if (isset($checkTable[0])) {
                        $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                            'SELECT pickup_point_id
							FROM `' . _DB_PREFIX_ . 'paxy_order_point` 
							WHERE order_id = ' . (int)$this->id);
                        if (isset($res[0])) {
                            $this->bl_delivery_point_id = $res[0]['pickup_point_id'];
                        }
                    }
                }
            }

            if (empty($this->bl_delivery_point_id) and preg_match('/gls/i', $carrier_name) and preg_match('/punk/i', $carrier_name)) {
                $checkTable = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' .  _DB_PREFIX_ . 'gls_poland_checkout_session"');
                if (isset($checkTable[0])) {
                    if ($checkoutSessionData = Db::getInstance()->getValue('
					SELECT `parcel_shops`
					FROM `' . _DB_PREFIX_ . 'gls_poland_checkout_session`
					WHERE `id_cart` = ' . (int)$this->id_cart)) {
                        $checkoutSessionData = json_decode($checkoutSessionData, true);
                        if (!empty($checkoutSessionData)) {
                            $pointId = array_values($checkoutSessionData)[0];
                            $this->bl_delivery_point_name = $pointId;
                            $this->bl_delivery_point_id = $pointId;
                        }
                    }
                }
            }

            // blpaczka
            if (empty($this->bl_delivery_point_id) && Module::isInstalled('blpaczka') && Module::isEnabled('blpaczka')) {
                if (count(DB::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'blpaczka_order"'))) {
                    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                        'SELECT pudo_code 
                        FROM `' . _DB_PREFIX_ . 'blpaczka_order` d
                        WHERE order_id = ' . (int)$this->id);

                    if (isset($res[0])) {
                        $this->bl_delivery_point_name = $res[0]['pudo_code'];
                        $this->bl_delivery_point_id = $res[0]['pudo_code'];
                    }
                }
            }

			// Reguły koszyka
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
				'SELECT id_cart_rule, name, value, free_shipping FROM `' . _DB_PREFIX_ . 'order_cart_rule`
				WHERE id_order = ' . (int)$this->id);

			if (isset($res[0]))
			{
				$override['cart_rules'] = $res;
			}

			// Gratisy
			if (Module::isInstalled('bestkit_gifts') and Module::isEnabled('bestkit_gifts'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT gc.id_product, gc.id_product_attribute, grl.name ident, pla.name
					FROM `' . _DB_PREFIX_ . 'bestkit_gift_cart` gc
					LEFT JOIN `' . _DB_PREFIX_ . 'bestkit_gift_rule_lang` grl ON grl.id_bestkit_gift_rule = gc.id_bestkit_gift_rule AND grl.id_lang = ' . (int)$id_lang . '
					LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pla ON pla.id_product = gc.id_product AND pla.id_lang = ' . (int)$id_lang . '
					WHERE gc.id_order = ' . (int)$this->id . ' OR gc.id_cart = ' . (int)$this->id_cart . ' ORDER BY gc.id_order DESC');

				if (isset($res[0]))
				{
					$freebie = array(
						'id' => $res[0]['id_product'],
						'variant_id' => $res[0]['id_product_attribute'],
						'name' => $res[0]['name'] . ' - ' . $res[0]['ident'],
						'quantity' => 1,
						'price' => 0,
						'tax' => 0,
					);

					$override['products'][-1] = $freebie;
				}
			}

			// opłaty dodatkowe
			if ((string)$this->module == 'paypalfeeplus')
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT payment_name 
					FROM `' . _DB_PREFIX_ . 'paypalfeeplus_configuration` c 
					LEFT JOIN `'. _DB_PREFIX_ . 'paypalfeeplus_configuration_lang` cl ON c.id_paypalfeeplus_configuration = cl.id_paypalfeeplus_configuration
					WHERE (countries = "" OR concat(";", countries, ";") LIKE concat("%;", (SELECT id_country FROM `' . _DB_PREFIX_ . 'address` WHERE id_address = "' . $this->id_address_delivery . '"), ";%")) AND (currencies = "" OR concat(";", currencies, ";") LIKE "%;' . $this->id_currency . ';%") AND active = 1 AND id_lang = "' . $this->id_lang . '"');
				$fee_name = isset($res[0]['payment_name']) ? $res[0]['payment_name'] : 'Dopłata do płatności';

				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT amount, fee, fee_without_taxes, iso_code currency
					FROM `' . _DB_PREFIX_ . 'paypalfeeplus_transaction` t
					LEFT JOIN `' . _DB_PREFIX_ . 'currency` c ON t.id_currency = c.id_currency
					WHERE id_order = "' . $this->id . '" AND id_cart = "' . $this->id_cart . '" AND result = "OK"');
				if (isset($res[0]))
				{
					$override['products'][-2] = array(
						'id' => '',
						'name' => str_replace('{fee}', $res[0]['fee'] . ' ' . $res[0]['currency'], $fee_name),
						'quantity' => 1,
						'price' => number_format($res[0]['fee'], 2, '.', ''),
						'tax' => ((float)$res[0]['fee_without_taxes'] >= 0.01) ? number_format($res[0]['fee']/$res[0]['fee_without_taxes']*100-100, 1, '.', '') : 0,
					);
				}
			}

			if ((string)$this->module == 'stripejs')
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT fee/100 fee
					FROM `' . _DB_PREFIX_ . 'stripejs_transaction`
					WHERE id_order = "' . $this->id . '" AND id_cart = "' . $this->id_cart . '" AND status = "paid"');
				if (isset($res[0]))
				{
					$override['products'][-2] = array(
						'id' => '',
						'name' => 'Stripe fee',
						'quantity' => 1,
						'price' => number_format($res[0]['fee'], 2, '.', ''),
						'tax' => number_format((float)$this->total_products_wt/(float)$this->total_products*100-100, 1, '.', ''),
					);
				}
			}

			if ((string)$this->module == 'przelewy24' and Module::isInstalled('przelewy24') and Module::isEnabled('przelewy24'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'przelewy24_extra_charges"');

				if (isset($res[0]))
				{
					$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
						'SELECT extra_charge_amount amt
						FROM `' . _DB_PREFIX_ . 'przelewy24_extra_charges`
						WHERE id_order = ' . (int)$this->id); 

					if (isset($res[0]))
					{
						$override['products'][-3] = array(
							'id' => '-',
							'name' => 'Dopłata Przelewy24',
							'quantity' => 1,
							'price' => $res[0]['amt']/100,
							'tax' => 0,
						);
					}
				}
			}

            if ((string)$this->module == 'inpostizi' and Module::isInstalled('inpostizi') and Module::isEnabled('inpostizi')) {
                $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('SHOW TABLES LIKE "' . _DB_PREFIX_ . 'inpostizi_basket_session"');
                if (isset($res[0])) {
                    $res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
                        'SELECT order_details
						FROM `' . _DB_PREFIX_ . 'inpostizi_basket_session`
						WHERE order_id = ' . (int)$this->id);

                    if (isset($res[0])) {
                        $orderDetails = @json_decode(base64_decode($res[0]['order_details']), true);
                        if (!empty($orderDetails['delivery']) && !empty($orderDetails['delivery']['delivery_point'])) {
                            $this->bl_delivery_point_name = $orderDetails['delivery']['delivery_point'];
                            $this->bl_delivery_point_id = $orderDetails['delivery']['delivery_point'];
                        }
                    }
                }
            }

			// SuperCheckout
			if (Module::isInstalled('supercheckout') and Module::isEnabled('supercheckout'))
			{
				$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
					'SELECT field_label, field_value 
					FROM `' . _DB_PREFIX_ . 'velsof_supercheckout_fields_data` fd
					LEFT JOIN `' . _DB_PREFIX_ . 'velsof_supercheckout_custom_fields_lang` fl ON fd.id_velsof_supercheckout_custom_fields = fl.id_velsof_supercheckout_custom_fields AND fl.id_lang = ' . (int)$id_lang . '
					WHERE fd.id_order = ' . (int)$this->id); 

				if (isset($res[0]))
				{
					foreach  ($res as $cf)
					{
						$override['supercheckout_fields'][] = array(
							'name' => $cf['field_label'],
							'value' => $cf['field_value'],
						);
					}
				}
			}

			// dostosowania
			$res = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS(
				'SELECT cd.*
				FROM `' . _DB_PREFIX_ . 'customization` c
				LEFT JOIN `' . _DB_PREFIX_ . 'customized_data` cd ON c.id_customization = cd.id_customization
				WHERE id_cart = ' . (int)$this->id_cart); 

			if (isset($res[0]))
			{
				foreach ($res as $row)
				{
					$override['customizations'][(int)$row['id_customization']] = $row;
				}
			}

			if ($override)
			{
				$this->bl_override = json_encode($override);
			}
		}
	}
}
