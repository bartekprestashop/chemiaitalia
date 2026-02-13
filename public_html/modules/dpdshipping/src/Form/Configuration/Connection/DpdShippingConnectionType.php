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

namespace DpdShipping\Form\Configuration\Connection;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Config\Config;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingConnectionType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'label' => $this->trans('Login', 'Modules.Dpdshipping.AdminConnection'),
            ])
            ->add('password', PasswordType::class, [
                'label' => $this->trans('Password', 'Modules.Dpdshipping.AdminConnection'),
            ])
            ->add('masterfid', TextType::class, [
                'label' => $this->trans('Master FID', 'Modules.Dpdshipping.AdminConnection'),
            ])
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    $this->trans('DPD Poland Production', 'Modules.Dpdshipping.AdminOnboarding') => Config::DPD_API_URL_LIVE,
                    $this->trans('DPD Poland DEMO', 'Modules.Dpdshipping.AdminOnboarding') => Config::DPD_API_URL_DEMO,
                ],
                'label' => $this->trans('Environment', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('payerList', CollectionType::class, [
                'entry_type' => PayerType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'prototype_name' => '__payer_prototype__',
            ]);
    }
}
