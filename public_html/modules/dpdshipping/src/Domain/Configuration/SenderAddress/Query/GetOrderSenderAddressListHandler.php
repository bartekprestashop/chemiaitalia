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

namespace DpdShipping\Domain\Configuration\SenderAddress\Query;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Repository\DpdshippingSenderAddressRepository;

class GetOrderSenderAddressListHandler
{
    /**
     * @var DpdshippingSenderAddressRepository
     */
    private $repository;

    public function __construct(DpdshippingSenderAddressRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(GetOrderSenderAddressList $query)
    {
        $addresses = $this->repository->findAll();

        $senderAddressList = [];
        foreach ($addresses as $item) {
            $senderAddressList[] = [
                'company' => $item->getCompany(),
                'name' => $item->getName(),
                'street' => $item->getStreet(),
                'postcode' => $item->getPostalCode(),
                'city' => $item->getCity(),
                'country' => $item->getCountryCode(),
                'phone' => $item->getPhone(),
                'email' => $item->getMail(),
            ];
        }

        return $senderAddressList;
    }
}
