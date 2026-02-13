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

namespace DpdShipping\Grid\Configuration\PickupCourierSettings\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use DpdShipping\Grid\Configuration\PickupCourierSettings\Definition\Factory\PickupCourierSettingsGridDefinitionFactory;
use DpdShipping\Grid\Configuration\PickupCourierSettings\PickupCourierSettingsFilter;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\DoctrineFilterApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\SqlFilters;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

/**
 * Defines all required sql statements to render products list.
 */
class PickupCourierSettingsQueryBuilder extends AbstractDoctrineQueryBuilder
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

    public function __construct(
        Connection $connection,
        string $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
        int $contextLanguageId,
        int $contextShopId,
        int $contextShopGroupId,
        bool $isStockSharingBetweenShopGroupEnabled,
        DoctrineFilterApplicatorInterface $filterApplicator
    ) {
        parent::__construct($connection, $dbPrefix);
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->contextLanguageId = $contextLanguageId;
        $this->contextShopId = $contextShopId;
        $this->isStockSharingBetweenShopGroupEnabled = $isStockSharingBetweenShopGroupEnabled;
        $this->contextShopGroupId = $contextShopGroupId;
        $this->filterApplicator = $filterApplicator;
    }

    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
            ->select('pcs.`id` as id')
            ->addSelect('pcs.`customer_full_name` as customer_full_name')
            ->addSelect('pcs.`customer_name` as customer_name')
            ->addSelect('pcs.`customer_phone` as customer_phone')
            ->addSelect('pcs.`payer_number` as payer_number')
            ->addSelect('pcs.`sender_address` as sender_address')
            ->addSelect('pcs.`sender_city` as sender_city')
            ->addSelect('pcs.`sender_full_name` as sender_full_name')
            ->addSelect('pcs.`sender_name` as sender_name')
            ->addSelect('pcs.`sender_phone` as sender_phone')
            ->addSelect('pcs.`sender_postal_code` as sender_postal_code')
            ->addSelect('pcs.`sender_country_code` as sender_country_code')
        ;
        $this->searchCriteriaApplicator
            ->applyPagination($searchCriteria, $qb);
        return $qb;
    }

    private function getQueryBuilder(array $filterValues): QueryBuilder
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix . PickupCourierSettingsGridDefinitionFactory::GRID_ID, 'pcs');

        $sqlFilters = new SqlFilters();
        $sqlFilters
            ->addFilter(
                'id',
                'pcs.`id`',
                SqlFilters::WHERE_STRICT
            );

        $this->filterApplicator->apply($qb, $sqlFilters, $filterValues);
        return $qb;
    }

    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('COUNT(pcs.`id`)');

        return $qb;
    }
}
