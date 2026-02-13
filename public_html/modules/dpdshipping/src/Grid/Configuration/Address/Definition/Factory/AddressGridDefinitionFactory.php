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

namespace DpdShipping\Grid\Configuration\Address\Definition\Factory;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Grid\DataColumnFactory;
use PrestaShop\PrestaShop\Core\Grid\Action\ModalOptions;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;

class AddressGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    public const GRID_ID = 'dpdshipping_sender_address';

    protected function getId()
    {
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Sender addresses', [], 'Modules.Dpdshipping.AdminAddress');
    }

    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (DataColumnFactory::create('alias'))
                    ->setName($this->trans('Alias', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'alias',
                    ])
            )
            ->add(
                (DataColumnFactory::create('company'))
                    ->setName($this->trans('Company', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'company',
                    ])
            )
            ->add(
                (DataColumnFactory::create('name'))
                    ->setName($this->trans('Name', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('street'))
                    ->setName($this->trans('Street', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'street',
                    ])
            )
            ->add(
                (DataColumnFactory::create('postal_code'))
                    ->setName($this->trans('Postcode', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'postal_code',
                    ])
            )
            ->add(
                (DataColumnFactory::create('city'))
                    ->setName($this->trans('City', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'city',
                    ])
            )
            ->add(
                (DataColumnFactory::create('country_code'))
                    ->setName($this->trans('Country', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'country_code',
                    ])
            )
            ->add(
                (DataColumnFactory::create('email'))
                    ->setName($this->trans('Mail', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'email',
                    ])
            )
            ->add(
                (DataColumnFactory::create('phone'))
                    ->setName($this->trans('Phone', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'phone',
                    ])
            )
            ->add(
                (DataColumnFactory::create('is_default'))
                    ->setName($this->trans('Default', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'field' => 'is_default',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Dpdshipping.AdminAddress'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new SubmitRowAction('edit'))
                                ->setName($this->trans('Edit', [], 'Modules.Dpdshipping.AdminAddress'))
                                ->setIcon('edit')
                                ->setOptions([
                                    'method' => 'POST',
                                    'route' => 'dpdshipping_address_edit_form',
                                    'route_param_name' => 'senderAddressId',
                                    'route_param_field' => 'id',
                                ]))
                            ->add((new SubmitRowAction('delete'))
                                ->setName($this->trans('Delete', [], 'Modules.Dpdshipping.AdminAddress'))
                                ->setIcon('delete')
                                ->setOptions([
                                    'method' => 'DELETE',
                                    'route' => 'dpdshipping_address_delete_form',
                                    'route_param_name' => 'senderAddressId',
                                    'route_param_field' => 'id',
                                    'modal_options' => new ModalOptions([
                                        'title' => $this->trans('Remove selected row?', [], 'Modules.Dpdshipping.AdminAddress'),
                                        'confirm_button_label' => $this->trans('Delete', [], 'Modules.Dpdshipping.AdminAddress'),
                                        'confirm_button_class' => 'btn-secondary',
                                        'close_button_label' => $this->trans('Close', [], 'Modules.Dpdshipping.AdminAddress'),
                                    ]),
                                ])),
                    ])
            );
    }
}
