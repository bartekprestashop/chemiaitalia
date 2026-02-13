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

namespace DpdShipping\Repository;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Context;
use DateTime;
use Doctrine\ORM\EntityRepository;
use DpdShipping\Entity\DpdshippingSpecialPrice;
use Psr\Log\LoggerInterface;

class DpdshippingSpecialPriceRepository extends EntityRepository
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function findAll(): array
    {
        return $this->findBy(['idShop' => (int) Context::getContext()->shop->id]);
    }

    public function save($specialPriceList): array
    {
        $toDelete = $this->findBy(['idShop' => (int) Context::getContext()->shop->id]);

        foreach ($toDelete as $item) {
            $recordToDelete = $this->find($item);
            $this->getEntityManager()->remove($recordToDelete);
            $this->logger->info('DPDSHIPPING: Delete specialPrice: ' . $item->getId());
        }

        $this->_em->flush();

        foreach ($specialPriceList as $item) {
            $entity = new DpdshippingSpecialPrice();

            $entity->setIdShop((int) Context::getContext()->shop->id);
            $entity->setIsoCountry($item['isoCountry']);
            $entity->setPriceFrom($item['priceFrom']);
            $entity->setPriceTo($item['priceTo']);
            $entity->setWeightFrom($item['weightFrom']);
            $entity->setWeightTo($item['weightTo']);
            $entity->setParcelPrice($item['parcelPrice']);
            $entity->setCodPrice($item['codPrice'] ?? 0);
            $entity->setCarrierType($item['carrierType']);
            $entity->setDateAdd(new DateTime());
            $entity->setDateUpd(new DateTime());

            $this->_em->persist($entity);
            $this->logger->info('DPDSHIPPING: Add new special price for:' . $entity->getIsoCountry());
        }
        $this->_em->flush();

        return [];
    }

    public function findPriceRules($isoCountry, $total_weight, $cart_total_price, $carrierType)
    {
        $query = $this->_em->createQuery(
            "SELECT sp
            FROM DpdShipping\Entity\DpdshippingSpecialPrice sp
            WHERE (sp.isoCountry = :isoCountry OR sp.isoCountry = '*')
                AND 
                (
                    (sp.weightFrom <= :totalWeight  AND sp.weightTo >= :totalWeight)
                    OR
                    (sp.priceFrom <= :cartTotalPrice AND sp.priceTo >= :cartTotalPrice)
                )
                AND sp.carrierType = :carrierType 
                AND sp.idShop = :idShop"
        );

        $query->setParameter('isoCountry', $isoCountry);
        $query->setParameter('totalWeight', (float) $total_weight);
        $query->setParameter('cartTotalPrice', (float) $cart_total_price);
        $query->setParameter('carrierType', $carrierType);
        $query->setParameter('idShop', (int) Context::getContext()->shop->id);

        return $query->getResult();
    }
}
