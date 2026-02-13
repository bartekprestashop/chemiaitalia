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
use DpdShipping\Entity\DpdshippingPayer;
use Psr\Log\LoggerInterface;

class DpdshippingPayerRepository extends EntityRepository
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function addOrUpdate(array $payerList): bool
    {
        $toDelete = [];

        $currentList = $this->findAllActive(false);

        foreach ($currentList as $item) {
            if (!in_array($item, $payerList)) {
                $toDelete[] = $item;
            }
        }

        foreach ($toDelete as $item) {
            $recordToDelete = $this->find($item);
            $this->getEntityManager()->remove($recordToDelete);
            $this->logger->info('DPDSHIPPING: Delete payer id: ' . $item->getId());
        }
        $this->_em->flush();

        foreach ($payerList as $payer) {
            $entity = $payer->getFid() != null ? $this->findOneByFid($payer->getFid()) : null;

            if (!isset($entity)) {
                $newEntity = new DpdshippingPayer();
                $newEntity
                    ->setIdShop((int) Context::getContext()->shop->id)
                    ->setName($payer->getName())
                    ->setFid((string) $payer->getFid())
                    ->setDefault($payer->isDefault())
                    ->setDateAdd(new DateTime())
                    ->setDateUpd(new DateTime());

                $this->_em->persist($newEntity);
                $this->logger->info('DPDSHIPPING: Add new payer fid:' . $payer->getFid());
            } else {
                $entity
                    ->setName($payer->getName())
                    ->setFid((string) $payer->getFid())
                    ->setDefault($payer->isDefault())
                    ->setDateAdd(new DateTime())
                    ->setDateUpd(new DateTime());
                $this->logger->info('DPDSHIPPING: Update payer fid:' . $payer->getFid());

                $this->_em->persist($entity);
            }
        }

        $this->_em->flush();

        return true;
    }

    public function findAllActive(bool $defaultFirst): array
    {
        if ($defaultFirst) {
            return $this->findBy(['idShop' => (int) Context::getContext()->shop->id], ['isDefault' => 'DESC']);
        }

        return $this->findBy(['idShop' => (int) Context::getContext()->shop->id]);
    }

    public function findOneByFid(int $fid): ?DpdshippingPayer
    {
        return $this->findOneBy(['fid' => $fid, 'idShop' => (int) Context::getContext()->shop->id]);
    }

    public function findDefault(): ?DpdshippingPayer
    {
        return $this->findOneBy(['idShop' => (int) Context::getContext()->shop->id, 'isDefault' => true]);
    }
}
