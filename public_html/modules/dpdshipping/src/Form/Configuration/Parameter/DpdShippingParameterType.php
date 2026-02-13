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

namespace DpdShipping\Form\Configuration\Parameter;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingParameterType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref1', ChoiceType::class, [
                'choices' => [
                    $this->trans('Order number', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_NUMBER',
                    $this->trans('Order ID', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_ID',
                    $this->trans('Invoice number', 'Modules.Dpdshipping.AdminParameter') => 'INVOICE_NUMBER',
                    $this->trans('Static value', 'Modules.Dpdshipping.AdminParameter') => 'STATIC_VALUE',
                ],
                'label' => $this->trans('Ref 1', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'select-with-static-value'],
            ])
            ->add('ref1StaticValue', TextType::class, [
                'label' => $this->trans('Ref 1 - static value', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'input-static-value d-none'],
            ])
            ->add('ref2', ChoiceType::class, [
                'choices' => [
                    $this->trans('Order number', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_NUMBER',
                    $this->trans('Order ID', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_ID',
                    $this->trans('Invoice number', 'Modules.Dpdshipping.AdminParameter') => 'INVOICE_NUMBER',
                    $this->trans('Static value', 'Modules.Dpdshipping.AdminParameter') => 'STATIC_VALUE',
                ],
                'label' => $this->trans('Ref 2', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'select-with-static-value'],

            ])
            ->add('ref2StaticValue', TextType::class, [
                'label' => $this->trans('Ref 2 - static value', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'input-static-value d-none'],
            ])
            ->add('customerData', ChoiceType::class, [
                'choices' => [
                    $this->trans('Order number', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_NUMBER',
                    $this->trans('Order ID', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_ID',
                    $this->trans('Invoice number', 'Modules.Dpdshipping.AdminParameter') => 'INVOICE_NUMBER',
                    $this->trans('Product index', 'Modules.Dpdshipping.AdminParameter') => 'PRODUCT_INDEX',
                    $this->trans('Product name', 'Modules.Dpdshipping.AdminParameter') => 'PRODUCT_NAME',
                    $this->trans('Static value', 'Modules.Dpdshipping.AdminParameter') => 'STATIC_VALUE',
                ],
                'label' => $this->trans('Customer data', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'select-with-static-value'],

            ])
            ->add('customerDataStaticValue', TextType::class, [
                'label' => $this->trans('Customer data - static value', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'input-static-value d-none'],
            ])
            ->add('content', ChoiceType::class, [
                'choices' => [
                    $this->trans('Order number', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_NUMBER',
                    $this->trans('Order ID', 'Modules.Dpdshipping.AdminParameter') => 'ORDER_ID',
                    $this->trans('Invoice number', 'Modules.Dpdshipping.AdminParameter') => 'INVOICE_NUMBER',
                    $this->trans('Product index', 'Modules.Dpdshipping.AdminParameter') => 'PRODUCT_INDEX',
                    $this->trans('Product name', 'Modules.Dpdshipping.AdminParameter') => 'PRODUCT_NAME',
                    $this->trans('Static value', 'Modules.Dpdshipping.AdminParameter') => 'STATIC_VALUE',
                ],
                'label' => $this->trans('Content', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'select-with-static-value'],

            ])
            ->add('contentStaticValue', TextType::class, [
                'label' => $this->trans('Content - static value', 'Modules.Dpdshipping.AdminParameter'),
                'required' => false,
                'attr' => ['class' => 'input-static-value d-none'],
            ])
            ->add('package_group_type', ChoiceType::class, [
                'choices' => [
                    $this->trans('Single shipping', 'Modules.Dpdshipping.AdminParameter') => 'single',
                    $this->trans('Shipping for products group', 'Modules.Dpdshipping.AdminParameter') => 'group',
                    $this->trans('Shipping for each product', 'Modules.Dpdshipping.AdminParameter') => 'package',
                ],
                'label' => $this->trans('Method of Package Grouping', 'Modules.Dpdshipping.AdminParameter'),
                'required' => true,
            ])
            ->add('weight', NumberType::class, [
                'label' => $this->trans('Weight [kg]', 'Modules.Dpdshipping.AdminParameter'),
            ])
            ->add('printFormat', ChoiceType::class, [
                'choices' => [
                    $this->trans('A4', 'Modules.Dpdshipping.AdminParameter') => 'A4',
                    $this->trans('Label', 'Modules.Dpdshipping.AdminParameter') => 'LBL_PRINTER',
                ],
                'label' => $this->trans('Print format', 'Modules.Dpdshipping.AdminParameter'),
            ])
            ->add('labelType', ChoiceType::class, [
                'choices' => [
                    $this->trans('Standard label', 'Modules.Dpdshipping.AdminParameter') => 'BIC3',
                    $this->trans('RUCH label', 'Modules.Dpdshipping.AdminParameter') => 'RUCH',
                    $this->trans('APOLLO label', 'Modules.Dpdshipping.AdminParameter') => 'APOLLO',
                ],
                'label' => $this->trans('Label type', 'Modules.Dpdshipping.AdminParameter'),
            ]);
    }
}
