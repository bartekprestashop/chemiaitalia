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

namespace DpdShipping\Form\Configuration\SpecialPrice;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Config\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isoCountry', TextType::class, [
                'required' => true,
            ])
            ->add('priceFrom', NumberType::class, [
                'required' => true,
            ])
            ->add('priceTo', NumberType::class, [
                'required' => true,
            ])
            ->add('weightFrom', NumberType::class, [
                'required' => true,
            ])
            ->add('weightTo', NumberType::class, [
                'required' => true,
            ])
            ->add('parcelPrice', NumberType::class, [
                'required' => true,
            ])
            ->add('codPrice', NumberType::class, [
                'required' => false,
            ])
            ->add('carrierType', ChoiceType::class, [
                'choices' => [
                    Config::DPD_STANDARD => Config::DPD_STANDARD,
                    Config::DPD_STANDARD_COD => Config::DPD_STANDARD_COD,
                    Config::DPD_PICKUP => Config::DPD_PICKUP,
                    Config::DPD_PICKUP_COD => Config::DPD_PICKUP_COD,
                ],
                'required' => true,
                'label' => 'deliveryMethod',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
