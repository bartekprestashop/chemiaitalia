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

namespace DpdShipping\Entity;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use DpdShipping\Repository\DpdshippingCartPickupRepository;

/**
 * @ORM\Entity(repositoryClass=DpdshippingCartPickupRepository::class)
 */
class DpdshippingCartPickup
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idShop;

    /**
     * @ORM\Column(type="integer")
     */
    private $idCart;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $pudoCode;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAdd;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpd;

    // Getters and Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdShop(): ?int
    {
        return $this->idShop;
    }

    public function setIdShop(int $idShop): self
    {
        $this->idShop = $idShop;

        return $this;
    }

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function setIdCart(int $idCart): self
    {
        $this->idCart = $idCart;

        return $this;
    }

    public function getPudoCode(): ?string
    {
        return $this->pudoCode;
    }

    public function setPudoCode(string $pudoCode): self
    {
        $this->pudoCode = $pudoCode;

        return $this;
    }

    public function getDateAdd(): ?DateTimeInterface
    {
        return $this->dateAdd;
    }

    public function setDateAdd(DateTimeInterface $dateAdd): self
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    public function getDateUpd(): ?DateTimeInterface
    {
        return $this->dateUpd;
    }

    public function setDateUpd(DateTimeInterface $dateUpd): self
    {
        $this->dateUpd = $dateUpd;

        return $this;
    }
}
