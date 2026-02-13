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
use DpdShipping\Entity\DpdshippingSenderAddress;

class DpdshippingSenderAddressRepository extends EntityRepository
{
    public function findAll(): array
    {
        return $this->findBy(['idShop' => (int) Context::getContext()->shop->id], ['isDefault' => 'DESC']);
    }

    public function addOrUpdate($senderAddress)
    {
        $entity = $senderAddress != null ? $this->findOneBy(['id' => $senderAddress->getId()]) : null;

        if ($senderAddress->isDefault()) {
            $this->setDefaultToZero();
        }

        if (!isset($entity)) {
            $newEntity = new DpdshippingSenderAddress();
            $newEntity
                ->setIdShop((int) Context::getContext()->shop->id)
                ->setAlias($senderAddress->getAlias())
                ->setCompany($senderAddress->getCompany())
                ->setName($senderAddress->getName())
                ->setStreet($senderAddress->getStreet())
                ->setCity($senderAddress->getCity())
                ->setCountryCode($senderAddress->getCountryCode())
                ->setPostalCode($senderAddress->getPostalCode())
                ->setMail($senderAddress->getMail())
                ->setPhone($senderAddress->getPhone())
                ->setIsDefault($senderAddress->isDefault())
                ->setDateAdd(new DateTime())
                ->setDateUpd(new DateTime());

            $this->_em->persist($newEntity);
        } else {
            $entity
                ->setIdShop((int) Context::getContext()->shop->id)
                ->setAlias($senderAddress->getAlias())
                ->setCompany($senderAddress->getCompany())
                ->setName($senderAddress->getName())
                ->setStreet($senderAddress->getStreet())
                ->setCity($senderAddress->getCity())
                ->setCountryCode($senderAddress->getCountryCode())
                ->setPostalCode($senderAddress->getPostalCode())
                ->setMail($senderAddress->getMail())
                ->setPhone($senderAddress->getPhone())
                ->setIsDefault($senderAddress->isDefault())
                ->setDateAdd(new DateTime())
                ->setDateUpd(new DateTime());

            $this->_em->persist($entity);
        }

        $this->_em->flush();
    }

    public function deleteById($id)
    {
        $entity = $this->findOneBy(['id' => $id]);

        if (!isset($entity)) {
            return false;
        }

        $this->_em->remove($entity);
        $this->_em->flush();

        return true;
    }

    private function setDefaultToZero()
    {
        $entities = $this->findAll();

        foreach ($entities as $entity) {
            $entity->setIsDefault(false);
        }

        $this->_em->flush();
    }

    public function findDefault()
    {
        return $this->findOneBy(['idShop' => (int) Context::getContext()->shop->id, 'isDefault' => true]);
    }
}
