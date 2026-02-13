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
use DpdShipping\Config\Config;
use DpdShipping\Domain\Configuration\Carrier\DpdCarrierPrestashopConfiguration;
use DpdShipping\Entity\DpdShippingCarrier;
use Psr\Log\LoggerInterface;

class DpdshippingCarrierRepository extends EntityRepository
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

    public function add($idCarrier, $type, $active)
    {
        $this->logger->info("DPDSHIPPING: Add new carrier id: $idCarrier, type: $type");

        $newEntity = new DpdshippingCarrier();
        $newEntity
            ->setIdShop((int) Context::getContext()->shop->id)
            ->setIdCarrier($idCarrier)
            ->setActive($active)
            ->setType($type)
            ->setDateAdd(new DateTime())
            ->setDateUpd(new DateTime());

        $this->_em->persist($newEntity);

        $this->_em->flush();

        if ($newEntity->getId() && $active) {
            $this->setOtherCarrierAsInactive($newEntity->getId(), $type);
        }
    }

    private function setOtherCarrierAsInactive(int $id, $type)
    {
        $currentList = $this->findBy(
            [
                'idShop' => (int) Context::getContext()->shop->id,
                'type' => $type,
            ]
        );

        foreach ($currentList as $item) {
            if ($item->getId() != $id) {
                $item->setActive(false);
            }

            $this->_em->persist($item);
        }
        $this->_em->flush();
    }

    public function setInactive($id): bool
    {
        $current = $this->findOneBy(['id' => $id]);

        if (isset($current)) {
            $current->setActive(false);
        } else {
            return false;
        }

        $this->_em->persist($current);
        $this->_em->flush();

        return true;
    }

    public function joinCarrier($currentId, $newId)
    {
        $current = $this->findOneBy(['idCarrier' => $currentId]);

        if (isset($current)) {
            $current->setIdCarrier($newId);
            $this->_em->persist($current);
            $this->_em->flush();

            if ($current->getType() == Config::DPD_PICKUP) {
                DpdCarrierPrestashopConfiguration::setConfig(Config::DPD_PICKUP, $newId);
            } elseif ($current->getType() == Config::DPD_PICKUP_COD) {
                DpdCarrierPrestashopConfiguration::setConfig(Config::DPD_PICKUP_COD, $newId);
            }
        }
    }
}
