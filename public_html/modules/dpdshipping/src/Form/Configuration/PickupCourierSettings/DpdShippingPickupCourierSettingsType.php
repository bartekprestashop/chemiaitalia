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

namespace DpdShipping\Form\Configuration\PickupCourierSettings;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingPickupCourierSettingsType extends TranslatorAwareType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('customer_full_name', TextType::class, [
                'label' => $this->trans('Customer company', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('customer_name', TextType::class, [
                'label' => $this->trans('Customer Name', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('customer_phone', TextType::class, [
                'label' => $this->trans('Customer Phone number', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('payer_number', IntegerType::class, [
                'label' => $this->trans('Payer number', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_full_name', TextType::class, [
                'label' => $this->trans('Sender company', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_name', TextType::class, [
                'label' => $this->trans('Sender name', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_address', TextType::class, [
                'label' => $this->trans('Sender address', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_city', TextType::class, [
                'label' => $this->trans('Sender city', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_phone', TextType::class, [
                'label' => $this->trans('Sender phone', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_postal_code', TextType::class, [
                'label' => $this->trans('Sender postal code', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('sender_country_code', TextType::class, [
                'label' => $this->trans('Sender country code', 'Modules.Dpdshipping.AdminPickupCourier'),
            ]);
    }
}
