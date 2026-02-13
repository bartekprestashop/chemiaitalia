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

namespace DpdShipping\Grid\PickupCourier\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use DpdShipping\Grid\PickupCourier\Definition\Factory\PickupCourierGridDefinitionFactory;
use DpdShipping\Grid\ShippingHistory\Query\ShippingHistoryQueryBuilder;
use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\DoctrineFilterApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\SqlFilters;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

/**
 * Defines all required sql statements to render products list.
 */
class PickupCourierQueryBuilder extends AbstractDoctrineQueryBuilder
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
        Connection                                $connection,
        string                                    $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
        int                                       $contextLanguageId,
        int                                       $contextShopId,
        int                                       $contextShopGroupId,
        bool                                      $isStockSharingBetweenShopGroupEnabled,
        DoctrineFilterApplicatorInterface         $filterApplicator,
        Configuration                             $configuration
    )
    {
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
            ->select('pc.`id` as id')
            ->addSelect('pc.`status` as state')
            ->addSelect('pc.`order_number` as order_number')
            ->addSelect($this->getSenderAddress() . ' AS sender_address')
            ->addSelect('pc.`operation_type` as type')
            ->addSelect('pc.`dox_count` as letter')
            ->addSelect('pc.`parcels_count` as packages')
            ->addSelect('pc.`pallets_count` as palette')
            ->addSelect($this->getPickupTime() . 'as pickup_time')
            ->addSelect('DATE_FORMAT(pc.`pickup_date`, "%d-%m-%Y") as pickup_date');

        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $qb)
            ->applySorting($searchCriteria, $qb);

        return $qb;
    }

    private function getQueryBuilder(array $filterValues): QueryBuilder
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . PickupCourierGridDefinitionFactory::GRID_ID, 'pc');

        $sqlFilters = new SqlFilters();
        $sqlFilters
            ->addFilter(
                'id',
                'pc.`id`',
                SqlFilters::WHERE_STRICT
            );

        $this->filterApplicator->apply($qb, $sqlFilters, $filterValues);

        foreach ($filterValues as $filterName => $filter) {
            switch ($filterName) {
                case 'pickup_date':
                    if (isset($filter['from']) && isset($filter['to'])) {
                        $start = (new DateTime($filter['from']))->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                        $end = (new DateTime($filter['to']))->setTime(23, 59, 59)->format('Y-m-d H:i:s');

                        $qb->andWhere('pc.`pickup_date` BETWEEN :pickup_date_start AND :pickup_date_end');
                        $qb->setParameter('pickup_date_start', $start);
                        $qb->setParameter('pickup_date_end', $end);
                    }
                    break;
                case 'sender_address':
                    $qb->andWhere($this->getSenderAddress() . ' LIKE :sender_address');
                    $qb->setParameter('sender_address', '%' . $filter . '%');
                    break;
                case 'state':
                    $qb->andWhere('pc.`status` LIKE :state');
                    $qb->setParameter('state', '%' . $filter . '%');
                    break;
                case 'order_number':
                    $qb->andWhere('pc.`order_number` LIKE :order_number');
                    $qb->setParameter('order_number', '%' . $filter . '%');
                    break;
                case 'type':
                    $qb->andWhere('pc.`operation_type` LIKE :type');
                    $qb->setParameter('type', '%' . $filter . '%');
                    break;
                case 'letter':
                    $qb->andWhere('pc.`dox_count` LIKE :letter');
                    $qb->setParameter('letter', '%' . $filter . '%');
                    break;
                case 'packages':
                    $qb->andWhere('pc.`parcels_count` LIKE :packages');
                    $qb->setParameter('packages', '%' . $filter . '%');
                    break;
                case 'palette':
                    $qb->andWhere('pc.`parcels_count` LIKE :palette');
                    $qb->setParameter('palette', '%' . $filter . '%');
                    break;
                case 'pickup_time':
                    $qb->andWhere($this->getPickupTime().' LIKE :pickup_time');
                    $qb->setParameter('pickup_time', '%' . $filter . '%');
                    break;
                default:
                    break;
            }
        }

        return $qb;
    }

    private function getCustomerAddress()
    {
        return 'CONCAT(
            COALESCE(pc . `customer_full_name`,"") ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `customer_name`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `customer_phone`,"")
        )';
    }

    private function getSenderAddress()
    {
        return 'CONCAT(
            COALESCE(pc . `sender_name`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_full_name`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_address`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_postal_code`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_city`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_country_code`,""), ' . ShippingHistoryQueryBuilder::getTextSeparator() . ',
            COALESCE(pc . `sender_phone`,"")
        )';
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('COUNT(pc.`id`)');

        return $qb;
    }

    private function getPickupTime()
    {
        return 'CONCAT(
            pc . `pickup_time_from`, " - " ,
            pc . `pickup_time_to`
        )';
    }
}
