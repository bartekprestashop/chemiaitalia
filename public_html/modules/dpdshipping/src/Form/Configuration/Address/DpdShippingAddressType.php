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

namespace DpdShipping\Form\Configuration\Address;

if (!defined('_PS_VERSION_')) {
    exit;
}

use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class DpdShippingAddressType extends TranslatorAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('senderAddressId', HiddenType::class, [
            ])
            ->add('alias', TextType::class, [
                'label' => $this->trans('Alias', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('company', TextType::class, [
                'label' => $this->trans('Company', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('name', TextType::class, [
                'label' => $this->trans('Name', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('street', TextType::class, [
                'label' => $this->trans('Street', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('postcode', TextType::class, [
                'label' => $this->trans('Postcode', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('city', TextType::class, [
                'label' => $this->trans('City', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('country', TextType::class, [
                'label' => $this->trans('Country', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('mail', TextType::class, [
                'label' => $this->trans('Mail', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('phone', TextType::class, [
                'label' => $this->trans('Phone', 'Modules.Dpdshipping.AdminAddress'),
            ])
            ->add('isDefault', CheckboxType::class, [
                'label' => $this->trans('Default', 'Modules.Dpdshipping.AdminAddress'),
                'required' => false,
            ]);
    }
}
