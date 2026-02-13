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

namespace DpdShipping\Form\Configuration\Carrier;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingCarrierType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dpdPolandCarrierStandard', CheckboxType::class, [
                'label' => $this->trans('DPD Poland', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierStandardCod', CheckboxType::class, [
                'label' => $this->trans('DPD Poland COD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickup', CheckboxType::class, [
                'label' => $this->trans('DPD Poland Pickup', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterOpenLate', CheckboxType::class, [
                'label' => $this->trans('Open late', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterOpenSaturdays', CheckboxType::class, [
                'label' => $this->trans('Open Saturdays', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterOpenSundays', CheckboxType::class, [
                'label' => $this->trans('Open Sundays', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDisabledFriendly', CheckboxType::class, [
                'label' => $this->trans('Disabled friendly', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterParking', CheckboxType::class, [
                'label' => $this->trans('Parking', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDirectDelivery', CheckboxType::class, [
                'label' => $this->trans('Direct delivery', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDirectDeliveryCod', CheckboxType::class, [
                'label' => $this->trans('Direct delivery COD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDropoffOnline', CheckboxType::class, [
                'label' => $this->trans('Dropoff online', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDropoffOffline', CheckboxType::class, [
                'label' => $this->trans('Dropoff offline', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterSwapParcel', CheckboxType::class, [
                'label' => $this->trans('Swap parcel', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterFresh', CheckboxType::class, [
                'label' => $this->trans('Fresh', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterFittingRoom', CheckboxType::class, [
                'label' => $this->trans('Fitting room', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterCardPayment', CheckboxType::class, [
                'label' => $this->trans('Card payment', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterRod', CheckboxType::class, [
                'label' => $this->trans('ROD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterLQ', CheckboxType::class, [
                'label' => $this->trans('LQ', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterDigitalLabel', CheckboxType::class, [
                'label' => $this->trans('Digital label', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterSwipBox', CheckboxType::class, [
                'label' => $this->trans('Swip box', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupFilterPointsWithServices', CheckboxType::class, [
                'label' => $this->trans('Points with services', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
//            ->add('dpdPolandCarrierPickupFilterHideFilters', CheckboxType::class, [
//                'label' => $this->trans('Hide filters', 'Modules.Dpdshipping.AdminCarrier'),
//                'required' => false,
//            ])
            ->add('dpdPolandCarrierPickupCOD', CheckboxType::class, [
                'label' => $this->trans('DPD Poland Pickup COD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterOpenLate', CheckboxType::class, [
                'label' => $this->trans('Open late', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterOpenSaturdays', CheckboxType::class, [
                'label' => $this->trans('Open Saturdays', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterOpenSundays', CheckboxType::class, [
                'label' => $this->trans('Open Sundays', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterDisabledFriendly', CheckboxType::class, [
                'label' => $this->trans('Disabled friendly', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterParking', CheckboxType::class, [
                'label' => $this->trans('Parking', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterDirectDelivery', CheckboxType::class, [
                'label' => $this->trans('Direct delivery', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterDirectDeliveryCod', CheckboxType::class, [
                'label' => $this->trans('Direct delivery COD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
                'data' => true,
                'attr' => ['disabled' => 'disabled'],
            ])
            ->add('dpdPolandCarrierPickupCODFilterDropoffOnline', CheckboxType::class, [
                'label' => $this->trans('Dropoff online', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterDropoffOffline', CheckboxType::class, [
                'label' => $this->trans('Dropoff offline', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterSwapParcel', CheckboxType::class, [
                'label' => $this->trans('Swap parcel', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterFresh', CheckboxType::class, [
                'label' => $this->trans('Fresh', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterFittingRoom', CheckboxType::class, [
                'label' => $this->trans('Fitting room', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterCardPayment', CheckboxType::class, [
                'label' => $this->trans('Card payment', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterRod', CheckboxType::class, [
                'label' => $this->trans('ROD', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterLQ', CheckboxType::class, [
                'label' => $this->trans('LQ', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterDigitalLabel', CheckboxType::class, [
                'label' => $this->trans('Digital label', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterSwipBox', CheckboxType::class, [
                'label' => $this->trans('Swip box', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
            ->add('dpdPolandCarrierPickupCODFilterPointsWithServices', CheckboxType::class, [
                'label' => $this->trans('Points with services', 'Modules.Dpdshipping.AdminCarrier'),
                'required' => false,
            ])
//            ->add('dpdPolandCarrierPickupCODFilterHideFilters', CheckboxType::class, [
//                'label' => $this->trans('Hide filters', 'Modules.Dpdshipping.AdminCarrier'),
//                'required' => false
//            ])
            ->add('dpdCarrierCodPaymentMethods', CollectionType::class, [
                'entry_type' => CodPaymentMethodType::class,
                'entry_options' => ['label' => false],
                'allow_add' => false,
                'allow_delete' => false,
                'prototype' => true,
                'prototype_name' => '__payment_cod_prototype__',
            ]);
    }
}
