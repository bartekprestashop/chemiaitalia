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
use DpdShipping\Domain\Configuration\Carrier\Command\AddCarrierPickupCommand;
use DpdShipping\Entity\DpdShippingCarrierPickup;
use Psr\Log\LoggerInterface;

class DpdshippingCarrierPickupRepository extends EntityRepository
{
    private $logger;

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function save(AddCarrierPickupCommand $command): bool
    {
        //DELETE CURRENT
        $this->logger->info('DPDSHIPPING: Add new carrier pickup');

        $param = $this->findOneBy(['name' => $command->getName()]);
        if (!isset($param)) {
            $entity = new DpdshippingCarrierPickup();
            $entity
                ->setIdShop((int) Context::getContext()->shop->id)
                ->setIdDpdshippingCarrier($command->getDpdCarrierId())
                ->setName($command->getName())
                ->setValue($command->getValue())
                ->setDateAdd(new DateTime())
                ->setDateUpd(new DateTime());

            $this->_em->persist($entity);
        } else {
            $param
                ->setIdDpdshippingCarrier($command->getDpdCarrierId())
                ->setValue($command->getValue())
                ->setDateUpd(new DateTime());

            $this->_em->persist($param);
        }

        $this->_em->flush();

        return true;
    }

    public function findByCarrierType(string $type)
    {
        $query = $this->_em->createQuery(
            'SELECT cp
            FROM DpdShipping\Entity\DpdshippingCarrierPickup cp
            LEFT JOIN DpdShipping\Entity\DpdshippingCarrier c WITH cp.idDpdshippingCarrier = c.idCarrier
            WHERE c.type = :type AND c.idShop = :idShop'
        );

        $query->setParameter('type', $type);
        $query->setParameter('idShop', (int) Context::getContext()->shop->id);

        return $query->getResult();
    }
}
