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

use DateTime;
use Doctrine\ORM\EntityRepository;
use DpdShipping\Entity\DpdshippingShippingHistory;
use DpdShipping\Entity\DpdshippingShippingHistoryParcel;

class DpdshippingShippingHistoryRepository extends EntityRepository
{
    public function save(DpdshippingShippingHistory $entity): ?DpdshippingShippingHistory
    {
        $this->_em->persist($entity);
        $this->_em->flush();

        return $entity;
    }

    public function setStatus($shippingNumber, array $mappedData)
    {
        if (empty($mappedData)) {
            return;
        }

        $shippingHistoryEntity = $this->_em->getRepository(DpdshippingShippingHistoryParcel::class)->findOneBy(['waybill' => $shippingNumber]);

        if (isset($shippingHistoryEntity)) {
            $entity = $this->findOneBy(['id' => $shippingHistoryEntity->getShippingHistory()->getId()]);

            $entity->setLastStatus($mappedData[0]['state']);
            $isDelivered = false;

            foreach ($mappedData as $shipment) {
                if (isset($shipment['state']) && strpos($shipment['state'], 'Przesyłka doręczona') !== false) {
                    $isDelivered = true;
                    break;
                }
            }
            $entity->setIsDelivered($isDelivered);

            $this->_em->persist($entity);
            $this->_em->flush();
        }
    }

    public function getShippingHistoryByIdsGroupByDeliveryZone(array $ids)
    {
        $qb = $this->createQueryBuilder('sh');
        $qb->select('sh', 'shp', 'shs')
            ->leftJoin('sh.parcels', 'shp')
            ->join('sh.sender', 'shs')
            ->where($qb->expr()->in('sh.id', $ids));

        $result = $qb->getQuery()->getResult();

        $groupedResults = [
            'DOMESTIC' => [],
            'INTERNATIONAL' => [],
        ];

        foreach ($result as $order) {
            $zone = $order->getDeliveryZone();
            if (!array_key_exists($zone, $groupedResults)) {
                $groupedResults[$zone] = [];
            }
            $groupedResults[$zone][] = $order;
        }

        return $groupedResults;
    }

    public function setLabelDate(array $waybills, DateTime $labelDate)
    {
        $qb = $this->createQueryBuilder('sh');
        $qb->select('sh', 'shp')
            ->leftJoin('sh.parcels', 'shp', 'WITH', 'shp.isMainWaybill = 1')
            ->where($qb->expr()->in('shp.waybill', $waybills));

        $result = $qb->getQuery()->getResult();

        foreach ($result as $order) {
            $order->setLabelDate($labelDate);
            $this->_em->persist($order);
        }

        $this->_em->flush();
    }

    public function setProtocolDate(array $waybills, DateTime $protocolDate)
    {
        $qb = $this->createQueryBuilder('sh');
        $qb->select('sh', 'shp')
            ->leftJoin('sh.parcels', 'shp', 'WITH', 'shp.isMainWaybill = 1')
            ->where($qb->expr()->in('shp.waybill', $waybills));

        $result = $qb->getQuery()->getResult();

        foreach ($result as $order) {
            $order->setProtocolDate($protocolDate);
            $this->_em->persist($order);
        }

        $this->_em->flush();
    }

    public function getShippingById($shippingHistoryId): array
    {
        $query = $this->_em->createQuery(
            'SELECT sh, shp, shs
            FROM DpdShipping\Entity\DpdshippingShippingHistoryParcel shp
            LEFT JOIN DpdShipping\Entity\DpdshippingShippingHistory sh WITH sh.id = shp.shippingHistory
            LEFT JOIN DpdShipping\Entity\DpdshippingShippingHistoryServices shs WITH sh.services = shs.id
            WHERE sh.id = :shippingHistoryId and shp.isMainWaybill = true'
        );

        $query->setParameter('shippingHistoryId', $shippingHistoryId);
        $query->setMaxResults(1);

        $result = $query->getResult();

        if (empty($result)) {
            return [];
        }

        return [
            'parcel' => $result[0],
            'shipping' => $result[1],
            'services' => $result[2],
        ];
    }

    public function getLastShippingByOrderId($orderId)
    {
        $query = $this->_em->createQuery(
            'SELECT sh, shp, shs
            FROM DpdShipping\Entity\DpdshippingShippingHistoryParcel shp
            LEFT JOIN DpdShipping\Entity\DpdshippingShippingHistory sh WITH sh.id = shp.shippingHistory
            LEFT JOIN DpdShipping\Entity\DpdshippingShippingHistoryServices shs WITH sh.services = shs.id
            WHERE sh.idOrder = :orderId and shp.isMainWaybill = true
            ORDER BY sh.id DESC'
        );

        $query->setParameter('orderId', $orderId);
        $query->setMaxResults(1);

        $result = $query->getResult();

        if (empty($result)) {
            return [];
        }

        return [
            'parcel' => $result[0],
            'shipping' => $result[1],
            'services' => $result[2],
        ];
    }

    public function delete($ids)
    {
        foreach ($ids as $id) {
            $shippingHistory = $this->find($id);

            if ($shippingHistory) {
                $shippingHistoryParcels = $this->_em->getRepository(DpdshippingShippingHistoryParcel::class)->findBy(['shippingHistory' => $shippingHistory]);
                $shippingHistoryReceiver = $shippingHistory->getReceiver();
                $shippingHistorySender = $shippingHistory->getSender();
                $shippingHistoryServices = $shippingHistory->getServices();

                foreach ($shippingHistoryParcels as $parcel) {
                    $this->_em->remove($parcel);
                }

                if ($shippingHistoryReceiver) {
                    $this->_em->remove($shippingHistoryReceiver);
                }

                if ($shippingHistorySender) {
                    $this->_em->remove($shippingHistorySender);
                }

                if ($shippingHistoryServices) {
                    $this->_em->remove($shippingHistoryServices);
                }
                $this->_em->remove($shippingHistory);

                $this->_em->flush();
            }
        }

        return true;
    }
}
