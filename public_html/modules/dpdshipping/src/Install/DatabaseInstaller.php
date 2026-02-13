<?php
/**
 * Copyright 2024 DPD Polska Sp. z o.o.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the EUPL-1.2 or later.
 * You may not use this work except in compliance with the Licence.
 *
 * You may obtain a copy of the Licence at:
 * https://joinup.ec.europa.eu/software/page/eupl
 * It is also bundled with this package in the file LICENSE.txt
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the Licence is distributed on an AS IS basis,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the Licence for the specific language governing permissions
 * and limitations under the Licence.
 *
 * @author    DPD Polska Sp. z o.o.
 * @copyright 2024 DPD Polska Sp. z o.o.
 * @license   https://joinup.ec.europa.eu/software/page/eupl
 */

declare(strict_types=1);

namespace DpdShipping\Install;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Context;
use DpdShipping\Domain\Configuration\Configuration\Repository\Configuration;

class DatabaseInstaller
{
    private $connection;

    //Tables are deleted for uninstall process
    private $tableNames = [
        'dpdshipping_cart_pickup',
        'dpdshipping_configuration',
        'dpdshipping_payer',
        'dpdshipping_sender_address',
        'dpdshipping_carrier',
        'dpdshipping_carrier_pickup',
        'dpdshipping_pickup_courier',
        'dpdshipping_pickup_courier_settings',
        'dpdshipping_special_price',
        'dpdshipping_shipping_history_sender',
        'dpdshipping_shipping_history_receiver',
        'dpdshipping_shipping_history_services',
        'dpdshipping_shipping_history',
        'dpdshipping_shipping_history_parcel',
    ];

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function createTables(): array
    {
        $errors = [];

        $sqlQueries = $this->getSqlQueries();

        foreach ($sqlQueries as $query) {
            if (empty($query)) {
                continue;
            }
            $statement = $this->connection->executeQuery($query);
            if (0 != (int)$statement->errorCode()) {
                $errors[] = [
                    'key' => json_encode($statement->errorInfo()),
                    'parameters' => [],
                    'domain' => 'Admin.Modules.Dpdshipping',
                ];
            }
        }

        return $errors;
    }

    public function dropTables(): array
    {
        $errors = [];
        foreach ($this->tableNames as $tableName) {
            $sql = 'DROP TABLE IF EXISTS ' . _DB_PREFIX_ . $tableName;
            $statement = $this->connection->executeQuery($sql);
            if ($statement instanceof Statement && 0 != (int)$statement->errorCode()) {
                $errors[] = [
                    'key' => json_encode($statement->errorInfo()),
                    'parameters' => [],
                    'domain' => 'Admin.Modules.Dpdshipping',
                ];
            }
        }

        return $errors;
    }

    /**
     * @return array
     */
    public static function getSqlQueries(): array
    {
        $sqlQueries = [];

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_cart_pickup` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`id_shop` int(11) NOT NULL,
				`id_cart` int(11) NOT NULL,
				`pudo_code` varchar(100) NOT NULL,
				`date_add` datetime DEFAULT CURRENT_TIMESTAMP,
				`date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_configuration` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`id_shop` int(11) NOT NULL,
				`name` varchar(100) NOT NULL,
				`value` varchar(8000) NOT NULL,
				`date_add` datetime DEFAULT CURRENT_TIMESTAMP,
				`date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_payer` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `fid` varchar(30) NOT NULL,
                    `is_default` tinyint(1) NOT NULL DEFAULT 0,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_sender_address` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `alias` varchar(255) NULL,
                    `company` varchar(255) NULL,
                    `name` varchar(255) NULL,
                    `street` varchar(255) NULL,
                    `city` varchar(255) NULL,
                    `postal_code` varchar(255) NULL,
                    `country_code` varchar(255) NULL,
                    `phone` varchar(255) NULL,
                    `email` varchar(255) NULL,
                    `is_default` tinyint(1) NOT NULL DEFAULT 0,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_carrier` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `id_carrier` int(11) NOT NULL,
                    `type` varchar(255) NOT NULL,
                    `active` tinyint(1) NOT NULL DEFAULT 0,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_carrier_pickup` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `id_dpdshipping_carrier` int(11) NOT NULL,
                    `name` varchar(255) NOT NULL,
                    `value` tinyint(1) NOT NULL DEFAULT 0,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_pickup_courier` (
                    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    status VARCHAR(100) NOT NULL,
                    order_number VARCHAR(100) NULL,
                    checksum VARCHAR(255) NULL,
                    operation_type VARCHAR(50) NOT NULL,
                    order_type VARCHAR(50) NOT NULL,
                    pickup_date datetime NOT NULL,
                    pickup_time_from VARCHAR(50) NOT NULL,
                    pickup_time_to VARCHAR(50) NOT NULL,
                    customer_full_name VARCHAR(100) NULL,
                    customer_name VARCHAR(100) NULL,
                    customer_phone VARCHAR(100) NULL,
                    payer_number INT NULL,
                    payer_name VARCHAR(100) NULL,
                    sender_address VARCHAR(255) NULL,
                    sender_city VARCHAR(100) NULL,
                    sender_full_name VARCHAR(255) NULL,
                    sender_name VARCHAR(255) NULL,
                    sender_phone VARCHAR(100) NULL,
                    sender_postal_code VARCHAR(50) NULL,
                    sender_country_code VARCHAR(10) NULL,
                    dox tinyint(1) NOT NULL DEFAULT 0,
                    dox_count INT NOT NULL DEFAULT 0,
                    pallet tinyint(1) NOT NULL DEFAULT 0,
                    pallet_max_height DECIMAL(14, 2) NULL,
                    pallet_max_weight DECIMAL(14, 2) NULL,
                    pallets_count INT NOT NULL DEFAULT 0,
                    pallets_weight DECIMAL(14, 2) NULL,
                    standard_parcel tinyint(1) NOT NULL DEFAULT 0,
                    parcel_max_depth INT NULL,
                    parcel_max_height INT NULL,
                    parcel_max_weight DECIMAL(14, 2) NULL,
                    parcel_max_width INT NULL,
                    parcels_count INT NOT NULL DEFAULT 0,
                    parcels_weight DECIMAL(14, 2) NULL,
                    date_add datetime DEFAULT CURRENT_TIMESTAMP,
                    date_upd datetime DEFAULT CURRENT_TIMESTAMP
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_pickup_courier_settings` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `customer_full_name` VARCHAR(100) NULL,
                    `customer_name` VARCHAR(100) NULL,
                    `customer_phone` VARCHAR(100) NULL,
                    `payer_number` INT NULL,
                    `sender_address` VARCHAR(255) NULL,
                    `sender_city` VARCHAR(100) NULL,
                    `sender_full_name` VARCHAR(255) NULL,
                    `sender_name` VARCHAR(255) NULL,
                    `sender_phone` VARCHAR(100) NULL,
                    `sender_postal_code` VARCHAR(50) NULL,
                    `sender_country_code` VARCHAR(10) NULL,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';


        $sqlQueries[] = '
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_special_price` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`id_shop` int(11) NOT NULL,
                    `iso_country` varchar(255) NOT NULL,
                    `price_from` decimal(20,6) NOT NULL,
                    `price_to` decimal(20,6) NOT NULL,
                    `weight_from` decimal(20,6) NOT NULL,
                    `weight_to` decimal(20,6) NOT NULL,
                    `parcel_price` float NOT NULL,
                    `cod_price` varchar(255) NOT NULL,
                    `carrier_type` varchar(50) NOT NULL,
                    `date_add` datetime DEFAULT CURRENT_TIMESTAMP,
                    `date_upd` datetime DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_shipping_history_sender`
            (
                `id`                int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `name`              varchar(255) NULL,
                `company`           varchar(255) NULL,
                `street`            varchar(255) NULL,
                `postal_code`       varchar(255) NULL,
                `country_code`      varchar(255) NULL,
                `city`              varchar(255) NULL,
                `phone`             varchar(255) NULL,
                `email`             varchar(255) NULL
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_shipping_history_receiver`
            (
                `id`           int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `address_id`   int          NULL,
                `name`         varchar(255) NULL,
                `company`      varchar(255) NULL,
                `street`       varchar(255) NULL,
                `postal_code`  varchar(255) NULL,
                `country_code` varchar(255) NULL,
                `city`         varchar(255) NULL,
                `phone`        varchar(255) NULL,
                `email`        varchar(255) NULL
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_shipping_history_services`
            (
                `id`                         int            NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `is_cod`                     bit            NOT NULL default 0,
                `cod_amount`                 decimal(14, 2) NULL,
                `cod_currency`               varchar(10)    NULL,
                `is_guarantee`               bit            NOT NULL default 0,
                `guarantee_type`             varchar(50)    NULL,
                `guarantee_value`            varchar(50)    NULL,
                `is_pallet`                  bit            NOT NULL default 0,
                `is_tires`                   bit            NOT NULL default 0,
                `is_declared_value`          bit            NOT NULL default 0,
                `declared_value_amount`      decimal(14, 2) NULL,
                `declared_value_currency`    varchar(10)    NULL,
                `is_cud`                     bit            NOT NULL default 0,
                `is_dox`                     bit            NOT NULL default 0,
                `is_duty`                    bit            NOT NULL default 0,
                `duty_amount`                decimal(14, 2) NULL,
                `duty_currency`              varchar(10)    NULL,
                `is_rod`                     bit            NOT NULL default 0,
                `is_dedicated_delivery`      bit            NOT NULL default 0,
                `is_dpd_express`             bit            NOT NULL default 0,
                `is_dpd_food`                bit            NOT NULL default 0,
                `is_carry_in`                bit            NOT NULL default 0,
                `is_dpd_pickup`              bit            NOT NULL default 0,
                `dpd_pickup_pudo`            varchar(200)   NULL,
                `is_in_pers`                 bit            NOT NULL default 0,
                `is_priv_pers`               bit            NOT NULL default 0,
                `is_self_con`                bit            NOT NULL default 0,
                `self_con_type`              varchar(200)   NULL,
                `is_documents_international` bit            NOT NULL default 0,
                `is_adr`                     bit            NOT NULL default 0,
                `dpd_food_limit_date`        varchar(20)    NULL,
                `is_return_label`            bit            NOT NULL default 0,
                `return_label_name`          varchar(255)   NULL,
                `return_label_company`       varchar(255)   NULL,
                `return_label_street`        varchar(255)   NULL,
                `return_label_postal_code`   varchar(255)   NULL,
                `return_label_country_code`  varchar(255)   NULL,
                `return_label_city`          varchar(255)   NULL,
                `return_label_phone`         varchar(255)   NULL,
                `return_label_email`         varchar(255)   NULL
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_shipping_history`
            (
            `id`                           int          NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `id_order`                     int          NOT NULL,
            `id_shop`                      int          NOT NULL,
            `reference`                    varchar(255) NULL,
            `shipping_history_sender_id`   int          NULL,
            `shipping_history_receiver_id` int          NULL,
            `shipping_history_services_id` int          NULL,
            `carrier_name`                 varchar(255) NULL,
            `shipping_date`                datetime     NULL,
            `label_date`                   datetime     NULL,
            `protocol_number`              varchar(255) NULL,
            `protocol_date`                datetime     NULL,
            `delivery_zone`                varchar(255) NULL,
            `fid`                          int          NULL,
            `payer_type`                   varchar(255) NULL,
            `ref1`                         varchar(255) NULL,
            `ref2`                         varchar(255) NULL,
            `is_deleted`                   bit          NOT NULL default 0,
            `last_status`                  varchar(255) NULL,
            `return_label`                 datetime     NULL,
            `return_label_waybill`         varchar(255) NULL,
            `is_delivered`                 bit          NOT NULL default 0,
            `date_add`                     datetime     NOT NULL default CURRENT_TIMESTAMP,
            `date_modify`                  datetime     NOT NULL default CURRENT_TIMESTAMP
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
        CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'dpdshipping_shipping_history_parcel`
        (
            `id`                  int            NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `shipping_history_id` int            NULL,
            `parcel_index`        int            NOT NULL,
            `waybill`             varchar(255)   NULL,
            `is_main_waybill`     bit            NOT NULL default 0,
            `parent_waybill`      varchar(255)   NULL,
            `return_label`        varchar(255)   NULL,
            `weight`              decimal(14, 2) NOT NULL,
            `weight_adr`          decimal(14, 2) NULL,
            `content`             varchar(255)   NULL,
            `customer_data`       varchar(255)   NULL,
            `size_x`              decimal(14, 2) NULL,
            `size_y`              decimal(14, 2) NULL,
            `size_z`              decimal(14, 2) NULL
			) ENGINE=' . _MYSQL_ENGINE_ . '  DEFAULT CHARSET=utf8';

        $sqlQueries[] = '
            INSERT INTO `' . _DB_PREFIX_ . 'dpdshipping_configuration` (`id_shop`, `name`, `value`)  
            VALUES (' . (int)Context::getContext()->shop->id . ', "' . Configuration::NEED_ONBOARDING . '", "1") 
            ON DUPLICATE KEY UPDATE 
                `id_shop` = VALUES(`id_shop`), 
                `name` = VALUES(`name`)';

        return $sqlQueries;
    }
}
