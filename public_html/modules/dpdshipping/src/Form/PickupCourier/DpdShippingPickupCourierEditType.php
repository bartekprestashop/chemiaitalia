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

namespace DpdShipping\Form\PickupCourier;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\DatePickerType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DpdShippingPickupCourierEditType extends TranslatorAwareType
{
    private $formDataProvider;

    public function __construct($translator, array $locales, $formDataProvider)
    {
        parent::__construct($translator, $locales);
        $this->formDataProvider = $formDataProvider;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dpdshipping_pickup_courier_sender_address', ChoiceType::class, [
                'label' => $this->trans('Sender address', 'Modules.Dpdshipping.AdminPickupCourier'),
                'attr' => ['class' => 'mb-3'],
                'choices' => $this->formDataProvider->getSenderAddress(),
                'required' => false,
            ])
            ->add('customer_company', TextType::class, [
                'label' => $this->trans('Company name', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('customer_name', TextType::class, [
                'label' => $this->trans('Name', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('customer_phone', TextType::class, [
                'label' => $this->trans('Phone number', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('pickup_date', DatePickerType::class, [
                'label' => $this->trans('Pickup date', 'Modules.Dpdshipping.AdminPickupCourier'),
            ])
            ->add('pickup_time', ChoiceType::class, [
                'label' => $this->trans('Pickup date', 'Modules.Dpdshipping.AdminPickupCourier'),
                'choices' => [],
                'required' => false,
            ])
            ->add('letters', CheckboxType::class, [
                'label' => $this->trans('Letters', 'Modules.Dpdshipping.AdminPickupCourier'),
                'attr' => ['class' => 'mb-3'],
                'required' => false,
            ])
            ->add('letters_count', IntegerType::class, [
                'label' => $this->trans('Letters', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages', CheckboxType::class, [
                'label' => $this->trans('Packages', 'Modules.Dpdshipping.AdminPickupCourier'),
                'attr' => ['class' => 'mt-3 mb-3'],
                'required' => false,
            ])
            ->add('packages_count', IntegerType::class, [
                'label' => $this->trans('Packages', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages_weight_sum', IntegerType::class, [
                'label' => $this->trans('Weight sum [kg]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages_weight_max', IntegerType::class, [
                'label' => $this->trans('Weight max [kg]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages_size_x_max', IntegerType::class, [
                'label' => $this->trans('Size X max [cm]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages_size_y_max', IntegerType::class, [
                'label' => $this->trans('Size Y max [cm]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('packages_size_z_max', IntegerType::class, [
                'label' => $this->trans('Size Z max [cm]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('palette', CheckboxType::class, [
                'label' => $this->trans('Palette', 'Modules.Dpdshipping.AdminPickupCourier'),
                'attr' => ['class' => 'mt-3 mb-3'],
                'required' => false,
            ])
            ->add('palette_count', IntegerType::class, [
                'label' => $this->trans('Palette', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('palette_weight_sum', IntegerType::class, [
                'label' => $this->trans('Weight sum [kg]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('palette_weight_max', IntegerType::class, [
                'label' => $this->trans('Weight max [kg]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ])
            ->add('palette_size_y_max', IntegerType::class, [
                'label' => $this->trans('Size Y max [cm]', 'Modules.Dpdshipping.AdminPickupCourier'),
                'required' => false,
                'attr' => [
                    'min' => 0,
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'sender_address' => [],
        ]);
    }
}
