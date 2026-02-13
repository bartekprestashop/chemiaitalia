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

namespace DpdShipping\Form\Order\GenerateShipping;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DateTime;
use DpdShipping\Config\Config;
use DpdShipping\Util\Currency;
use DpdShipping\Validator\Constraints\AtLeastOne;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class DpdShippingGenerateShippingType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
// SENDER
            ->add('sender_address_company', TextType::class, [
                'label' => $this->trans('Company name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter company...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('sender_address_name', TextType::class, [
                'label' => $this->trans('Name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter name...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('sender_address_street', TextType::class, [
                'label' => $this->trans('Street:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter street...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('sender_address_postcode', TextType::class, [
                'label' => $this->trans('Postcode:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter postcode...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('sender_address_city', TextType::class, [
                'label' => $this->trans('City:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter city...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('sender_address_country', TextType::class, [
                'label' => $this->trans('Country:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter country...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('sender_address_phone', TextType::class, [
                'label' => $this->trans('Phone:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter phone...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('sender_address_email', TextType::class, [
                'label' => $this->trans('Email:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter email...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
// Receiver
            ->add('receiver_address_company', TextType::class, [
                'label' => $this->trans('Receiver company name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter company...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('receiver_address_name', TextType::class, [
                'label' => $this->trans('Receiver name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter name...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('receiver_address_street', TextType::class, [
                'label' => $this->trans('Receiver street:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter street...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('receiver_address_postcode', TextType::class, [
                'label' => $this->trans('Receiver postcode:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter postcode...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('receiver_address_city', TextType::class, [
                'label' => $this->trans('Receiver city:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter city...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('receiver_address_country', TextType::class, [
                'label' => $this->trans('Receiver country:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter country...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => true,
            ])
            ->add('receiver_address_phone', TextType::class, [
                'label' => $this->trans('Receiver phone:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter phone...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
            ->add('receiver_address_email', TextType::class, [
                'label' => $this->trans('Receiver email:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control', 'placeholder' => $this->trans('Enter email...', 'Modules.Dpdshipping.AdminOrder')],
                'required' => false,
            ])
// PAYER
            ->add('payer_number', ChoiceType::class, [
                'choices' => $options['payer_number_list'] ?? [],
                'label' => false,
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
//ADDITIONAL FIELDS
            ->add('ref1', TextType::class, [
                'label' => $this->trans('Ref1:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('ref2', TextType::class, [
                'label' => $this->trans('Ref2:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
// SERVICES
            ->add('service_guarantee', CheckboxType::class, [
                'label' => $this->trans('Service guarantee', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_guarantee_type', ChoiceType::class, [
                'choices' => [
                    '09:30' => 'TIME0930',
                    '12:00' => 'TIME1200',
                    $this->trans('DPD on hour', 'Modules.Dpdshipping.AdminOrder') => 'TIMEFIXED',
                    $this->trans('Saturday', 'Modules.Dpdshipping.AdminOrder') => 'SATURDAY',
                    $this->trans('DPD NEXTDAY', 'Modules.Dpdshipping.AdminOrder') => 'DPDNEXTDAY',
                    $this->trans('DPD TODAY', 'Modules.Dpdshipping.AdminOrder') => 'DPDTODAY',
                    $this->trans('Guarantee international ', 'Modules.Dpdshipping.AdminOrder') => 'INTER',
                    $this->trans('B2C', 'Modules.Dpdshipping.AdminOrder') => 'B2C',
                ],
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'required' => false,
                ],
            ])
            ->add('service_guarantee_value', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => '',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('HH:MM', 'Modules.Dpdshipping.AdminOrder'),
                    'required' => false,
                ],
                'required' => false,
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/',
                        'message' => 'Please enter a valid time in the format XX:XX.',
                    ]),
                ],
            ])
            ->add('service_in_pers', CheckboxType::class, [
                'label' => $this->trans('Service in pers', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_priv_pers', CheckboxType::class, [
                'label' => $this->trans('Service priv pers', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_cod', CheckboxType::class, [
                'label' => $this->trans('Service COD', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'data' => $this->isCod($options['dpd_carrier']),
            ])
            ->add('service_cod_value', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => !$this->isCod($options['dpd_carrier']),
                    'min' => 0,
                    'placeholder' => $this->trans('Enter value...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
                'data' => $options['order_amount'],

            ])
            ->add('service_cod_currency', ChoiceType::class, [
                'choices' => $options['currencies'],
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => !$this->isCod($options['dpd_carrier']),
                ],
                'required' => false,
                'data' => $options['order_currency'] ?? 'PLN',
            ])
            ->add('service_self_con', CheckboxType::class, [
                'label' => $this->trans('Service self con', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_self_con_value', ChoiceType::class, [
                'choices' => [
                    $this->trans('Company', 'Modules.Dpdshipping.AdminOrder') => 'COMP',
                    $this->trans('Private', 'Modules.Dpdshipping.AdminOrder') => 'PRIV',
                ],
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                ],
                'required' => false,
            ])
            ->add('service_dpd_pickup', CheckboxType::class, [
                'label' => $this->trans('Service DPD Pickup', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'data' => $this->isPickup($options['dpd_carrier']),
            ])
            ->add('service_dpd_pickup_value', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => !$this->isPickup($options['dpd_carrier']),
                ],
                'required' => false,
                'data' => $options['order_pickup_number'],
            ])
            ->add('service_dpd_pickup_map', ButtonType::class, [
                'label' => $this->trans('Open map', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control btn-sm btn-secondary dpdshipping-pudo-change-map-btn',
                    'data-attribute' => true,
                    'data-hidden' => !$this->isPickup($options['dpd_carrier']),
                ],
            ])
            ->add('service_rod', CheckboxType::class, [
                'label' => $this->trans('Service rod', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_dox', CheckboxType::class, [
                'label' => $this->trans('Service dox', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_cud', CheckboxType::class, [
                'label' => $this->trans('Service cud', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_tires', CheckboxType::class, [
                'label' => $this->trans('Service Tires', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_declared_value', CheckboxType::class, [
                'label' => $this->trans('Service Declared value', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_declared_value_value', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'min' => 0,
                    'placeholder' => $this->trans('Enter value...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
                'data' => $options['order_amount'],
            ])
            ->add('service_declared_value_currency', ChoiceType::class, [
                'choices' => $options['currencies'],
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                ],
                'required' => false,
                'data' => $options['order_currency'] ?? 'PLN',
            ])
            ->add('service_dpd_express', CheckboxType::class, [
                'label' => $this->trans('Service DPD Express', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_dpd_food', CheckboxType::class, [
                'label' => $this->trans('Service DPD Food', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_dpd_food_value', DateType::class, [
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'min' => (new DateTime('+2 days'))->format('Y-m-d')],
                'required' => false,
            ])
            ->add('service_duty', CheckboxType::class, [
                'label' => $this->trans('Service duty', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_duty_value', NumberType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'min' => 0,
                ],
                'required' => false,
                'data' => $options['order_amount'],
            ])
            ->add('service_duty_currency', ChoiceType::class, [
                'choices' => $options['currencies'],
                'label' => false,
                'attr' => [
                    'class' => 'form-control ',
                    'data-attribute' => true,
                    'data-hidden' => true,
                ],
                'required' => false,
                'data' => $options['order_currency'] ?? 'PLN',
            ])
            ->add('service_adr', CheckboxType::class, [
                'label' => $this->trans('Service ADR', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
            ->add('service_return_label', CheckboxType::class, [
                'label' => $this->trans('Service return label', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => ['class' => 'form-control'],
                'required' => false,
            ])
// RETURN LABEL
            ->add('service_return_label_address_company', TextType::class, [
                'label' => $this->trans('Company name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter company...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_name', TextType::class, [
                'label' => $this->trans('Name:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter name...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_street', TextType::class, [
                'label' => $this->trans('Street:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter street...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_city', TextType::class, [
                'label' => $this->trans('City:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter city...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_postcode', TextType::class, [
                'label' => $this->trans('Postcode:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter postcode...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_country', TextType::class, [
                'label' => $this->trans('Country:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter country...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_phone', TextType::class, [
                'label' => $this->trans('Phone:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter phone...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
            ->add('service_return_label_address_email', TextType::class, [
                'label' => $this->trans('Email:', 'Modules.Dpdshipping.AdminOrder'),
                'attr' => [
                    'class' => 'form-control',
                    'data-attribute' => true,
                    'data-hidden' => true,
                    'placeholder' => $this->trans('Enter email...', 'Modules.Dpdshipping.AdminOrder'),
                ],
                'required' => false,
            ])
//        packages

            ->add('packages', CollectionType::class, [
                'entry_type' => PackageType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__package_dpd_prototype__',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'payer_number_list' => [],
            'dpd_carrier' => '',
            'currencies' => Currency::getDpdCurrencies(),
            'order_amount' => '',
            'order_pickup_number' => '',
            'order_currency' => '',
            'is_dpd_carrier' => 'false',
            'constraints' => [
                new AtLeastOne([
                    'fields' => ['sender_address_company', 'sender_address_name'],
                ]),
                new AtLeastOne([
                    'fields' => ['receiver_address_company', 'receiver_address_name'],
                ]),
            ],
        ]);
    }

    /**
     * @param $dpd_carrier
     * @return bool
     */
    public function isPickup($dpd_carrier): bool
    {
        return $dpd_carrier == Config::DPD_PICKUP || $dpd_carrier == Config::DPD_PICKUP_COD;
    }

    /**
     * @param $dpd_carrier
     * @return bool
     */
    public function isCod($dpd_carrier): bool
    {
        return $dpd_carrier == Config::DPD_STANDARD_COD || $dpd_carrier == Config::DPD_PICKUP_COD;
    }
}
