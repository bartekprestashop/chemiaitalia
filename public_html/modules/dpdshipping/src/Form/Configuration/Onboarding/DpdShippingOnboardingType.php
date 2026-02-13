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

namespace DpdShipping\Form\Configuration\Onboarding;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Config\Config;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingOnboardingType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login', TextType::class, [
                'label' => $this->trans('Login', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('password', PasswordType::class, [
                'label' => $this->trans('Password', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('masterfid', TextType::class, [
                'label' => $this->trans('Master FID', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('defaultFidNumber', IntegerType::class, [
                'label' => $this->trans('Default FID', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('environment', ChoiceType::class, [
                'choices' => [
                    $this->trans('DPD Poland Production', 'Modules.Dpdshipping.AdminOnboarding') => Config::DPD_API_URL_LIVE,
                    $this->trans('DPD Poland DEMO', 'Modules.Dpdshipping.AdminOnboarding') => Config::DPD_API_URL_DEMO,
                ],
                'label' => $this->trans('Environment', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('carrierDpdPoland', CheckboxType::class, [
                'label' => $this->trans('Carrier DPD Poland', 'Modules.Dpdshipping.AdminOnboarding'),
                'required' => false,
            ])
            ->add('carrierDpdPolandCod', CheckboxType::class, [
                'label' => $this->trans('Carrier DPD Poland COD', 'Modules.Dpdshipping.AdminOnboarding'),
                'required' => false,
            ])
            ->add('carrierDpdPolandPickup', CheckboxType::class, [
                'label' => $this->trans('Carrier DPD Poland Pickup', 'Modules.Dpdshipping.AdminOnboarding'),
                'required' => false,
            ])
            ->add('carrierDpdPolandPickupCod', CheckboxType::class, [
                'label' => $this->trans('Carrier DPD Poland Pickup COD', 'Modules.Dpdshipping.AdminOnboarding'),
                'required' => false,
            ])
            ->add('senderAddressId', HiddenType::class, [])
            ->add('alias', TextType::class, [
                'label' => $this->trans('Alias', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('company', TextType::class, [
                'label' => $this->trans('Company', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('name', TextType::class, [
                'label' => $this->trans('Name', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('street', TextType::class, [
                'label' => $this->trans('Street', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('postcode', TextType::class, [
                'label' => $this->trans('Postcode', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('city', TextType::class, [
                'label' => $this->trans('City', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('country', TextType::class, [
                'label' => $this->trans('Country', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('mail', TextType::class, [
                'label' => $this->trans('Mail', 'Modules.Dpdshipping.AdminOnboarding'),
            ])
            ->add('phone', TextType::class, [
                'label' => $this->trans('Phone', 'Modules.Dpdshipping.AdminOnboarding'),
            ]);
    }
}
