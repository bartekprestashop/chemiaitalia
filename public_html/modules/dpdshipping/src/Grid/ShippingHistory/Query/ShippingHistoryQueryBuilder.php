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

namespace DpdShipping\Grid\ShippingHistory\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use DpdShipping\Grid\ShippingHistory\Definition\Factory\ShippingHistoryGridDefinitionFactory;
use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\DoctrineFilterApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\SqlFilters;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

/**
 * Defines all required sql statements to render products list.
 */
class ShippingHistoryQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @var int
     */
    private $contextLanguageId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @var bool
     */
    private $isStockSharingBetweenShopGroupEnabled;

    /**
     * @var int
     */
    private $contextShopGroupId;

    /**
     * @var DoctrineFilterApplicatorInterface
     */
    private $filterApplicator;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        Connection $connection,
        string $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
        int $contextLanguageId,
        int $contextShopId,
        int $contextShopGroupId,
        bool $isStockSharingBetweenShopGroupEnabled,
        DoctrineFilterApplicatorInterface $filterApplicator,
        Configuration $configuration
    ) {
        parent::__construct($connection, $dbPrefix);
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->contextLanguageId = $contextLanguageId;
        $this->contextShopId = $contextShopId;
        $this->isStockSharingBetweenShopGroupEnabled = $isStockSharingBetweenShopGroupEnabled;
        $this->contextShopGroupId = $contextShopGroupId;
        $this->filterApplicator = $filterApplicator;
        $this->configuration = $configuration;
    }

    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
            ->select('dsh.`id_order` as id_order')
            ->addSelect('dsh.`id` as id')
            ->addSelect('COALESCE(dshp.`waybill`,"EMPTY")  as shipping_number')
            ->addSelect($this->getSenderAddress() . ' AS sender_address')
            ->addSelect($this->getReceiverAddress() . ' AS receiver_address')
            ->addSelect($this->getServices() . ' AS services')
            ->addSelect('dsh.`ref1` as ref1')
            ->addSelect('dsh.`ref2` as ref2')
            ->addSelect('dsh.`carrier_name` as carrier_name')
            ->addSelect('dsh.`label_date` as label_datetime')
            ->addSelect('dsh.`is_delivered` as is_delivered')
            ->addSelect('dsh.`protocol_date` as protocol_datetime')
            ->addSelect('dsh.`shipping_date` as shipping_date');

        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $qb)
            ->applySorting($searchCriteria, $qb);

        return $qb;
    }

    private function getQueryBuilder(array $filterValues): QueryBuilder
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . ShippingHistoryGridDefinitionFactory::GRID_ID, 'dsh')
            ->leftJoin('dsh', $this->dbPrefix . 'dpdshipping_shipping_history_parcel', 'dshp', 'dsh.id = dshp.shipping_history_id AND dshp.is_main_waybill = 1')
            ->leftJoin('dsh', $this->dbPrefix . 'dpdshipping_shipping_history_sender', 'dshs', 'dshs.id = dsh.shipping_history_sender_id')
            ->leftJoin('dsh', $this->dbPrefix . 'dpdshipping_shipping_history_receiver', 'dshr', 'dshr.id = dsh.shipping_history_receiver_id')
            ->leftJoin('dsh', $this->dbPrefix . 'dpdshipping_shipping_history_services', 'dshsv', 'dshsv.id = dsh.shipping_history_services_id');
        $sqlFilters = new SqlFilters();
        $sqlFilters
            ->addFilter(
                'id',
                'dsh.`id`',
                SqlFilters::WHERE_STRICT
            );

        $this->filterApplicator->apply($qb, $sqlFilters, $filterValues);

        foreach ($filterValues as $filterName => $filter) {
            switch ($filterName) {
                case 'ref1':
                    $qb->andWhere('dsh.`ref1` LIKE :ref1');
                    $qb->setParameter('ref1', '%' . $filter . '%');
                    break;
                case 'ref2':
                    $qb->andWhere('dsh.`ref2` LIKE :ref2');
                    $qb->setParameter('ref2', '%' . $filter . '%');
                    break;
                case 'is_delivered':
                    $qb->andWhere('dsh.`is_delivered` = :is_delivered');
                    $qb->setParameter('is_delivered', $filter);
                    break;
                case 'id_order':
                    $qb->andWhere('dsh.`id_order` = :id_order');
                    $qb->setParameter('id_order', $filter);
                    break;
                case 'id':
                    $qb->andWhere('dsh.`id` = :id');
                    $qb->setParameter('id', $filter);
                    break;
                case 'shipping_number':
                    $qb->andWhere('dshp.`waybill` LIKE :shipping_number');
                    $qb->setParameter('shipping_number', '%' . $filter . '%');
                    break;
                case 'carrier_name':
                    $qb->andWhere('dsh.`carrier_name` LIKE :carrier_name');
                    $qb->setParameter('carrier_name', '%' . $filter . '%');
                    break;
                case 'label_datetime':
                    if (isset($filter['from']) && isset($filter['to'])) {
                        $start = (new DateTime($filter['from']))->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                        $end = (new DateTime($filter['to']))->setTime(23, 59, 59)->format('Y-m-d H:i:s');

                        $qb->andWhere('dsh.`label_date` BETWEEN :label_start AND :label_end');
                        $qb->setParameter('label_start', $start);
                        $qb->setParameter('label_end', $end);
                    }
                    break;
                case 'protocol_datetime':
                    if (isset($filter['from']) && isset($filter['to'])) {
                        $start = (new DateTime($filter['from']))->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                        $end = (new DateTime($filter['to']))->setTime(23, 59, 59)->format('Y-m-d H:i:s');

                        $qb->andWhere('dsh.`protocol_date` BETWEEN :protocol_start AND :protocol_end');
                        $qb->setParameter('protocol_start', $start);
                        $qb->setParameter('protocol_end', $end);
                    }
                    break;
                case 'shipping_date':
                    if (isset($filter['from']) && isset($filter['to'])) {
                        $start = (new DateTime($filter['from']))->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                        $end = (new DateTime($filter['to']))->setTime(23, 59, 59)->format('Y-m-d H:i:s');

                        $qb->andWhere('dsh.`shipping_date` BETWEEN :shipping_start AND :shipping_end');
                        $qb->setParameter('shipping_start', $start);
                        $qb->setParameter('shipping_end', $end);
                    }
                    break;
                case 'sender_address':
                    $qb->andWhere($this->getSenderAddress() . ' LIKE :sender_address');
                    $qb->setParameter('sender_address', '%' . $filter . '%');
                    break;
                case 'receiver_address':
                    $qb->andWhere($this->getReceiverAddress() . ' LIKE :receiver_address');
                    $qb->setParameter('receiver_address', '%' . $filter . '%');
                    break;
                case 'services':
                    $qb->andWhere($this->getServices() . ' LIKE :services');
                    $qb->setParameter('services', '%' . $filter . '%');
                    break;
                default:
                    break;
            }
        }

        return $qb;
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('COUNT(dsh.`id`)');

        return $qb;
    }

    private function getSenderAddress()
    {
        return 'CONCAT(
            COALESCE(dshs . `company`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshs . `name`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshs . `street`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshs . `postal_code`,""), " ", COALESCE(dshs.`city`,""), " ",COALESCE(dshs.`country_code`,""),' . self::getTextSeparator() . ',
            COALESCE(dshs . `phone`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshs . `email`,"")
        )';
    }

    public static function getTextSeparator(): string
    {
        if (version_compare(_PS_VERSION_, '8.1.0', '>=')) {
            return '"<br>"';
        } else {
            return '" "';
        }
    }

    private function getReceiverAddress()
    {
        return 'CONCAT(
            COALESCE(dshr . `company`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshr . `name`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshr . `street`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshr . `postal_code`,""), " ", COALESCE(dshr.`city`,""), " ",COALESCE(dshr.`country_code`,""),' . self::getTextSeparator() . ',
            COALESCE(dshr . `phone`,""), ' . self::getTextSeparator() . ',
            COALESCE(dshr . `email`,"")
        )';
    }

    private function getServices()
    {
        return "TRIM(TRAILING ', ' FROM CONCAT(
                    IF(is_adr = 1, 'ADR " . self::getTextSeparator() . "', ''),
                    IF(is_cod = 1, CONCAT('COD: ', dshsv.`cod_amount`, ' ', dshsv.`cod_currency`, " . self::getTextSeparator() . "), ''),
                    IF(is_guarantee = 1, 'Guarantee" . self::getTextSeparator() . "', ''),
                    IF(is_pallet = 1, 'Pallet" . self::getTextSeparator() . "', ''),
                    IF(is_tires = 1, 'Tires" . self::getTextSeparator() . "', ''),
                    IF(is_declared_value = 1, CONCAT('Declared Value: ', dshsv.`declared_value_amount`, ' ', dshsv.`declared_value_currency`, " . self::getTextSeparator() . "), ''),
                    IF(is_cud = 1, 'CUD" . self::getTextSeparator() . "', ''),
                    IF(is_dox = 1, 'DOX" . self::getTextSeparator() . "', ''),
                    IF(is_duty = 1, 'Duty" . self::getTextSeparator() . "', ''),
                    IF(is_rod = 1, 'ROD" . self::getTextSeparator() . "', ''),
                    IF(is_dedicated_delivery = 1, 'Dedicated Delivery" . self::getTextSeparator() . "', ''),
                    IF(is_dpd_express = 1, 'DPD Express" . self::getTextSeparator() . "', ''),
                    IF(is_dpd_food = 1, 'DPD Food" . self::getTextSeparator() . "', ''),
                    IF(is_carry_in = 1, 'Carry In" . self::getTextSeparator() . "', ''),
                    IF(is_dpd_pickup = 1, CONCAT('DPD Pickup: ', dshsv.`dpd_pickup_pudo`, " . self::getTextSeparator() . "), ''),
                    IF(is_in_pers = 1, 'In Pers" . self::getTextSeparator() . "', ''),
                    IF(is_priv_pers = 1, 'Priv Pers" . self::getTextSeparator() . " ', ''),
                    IF(is_self_con = 1, 'Self Con" . self::getTextSeparator() . " ', ''),
                    IF(is_documents_international = 1, 'Documents International" . self::getTextSeparator() . " ', ''),
                    IF(is_adr = 1, 'ADR" . self::getTextSeparator() . " ', '')
                ))";
    }
}
