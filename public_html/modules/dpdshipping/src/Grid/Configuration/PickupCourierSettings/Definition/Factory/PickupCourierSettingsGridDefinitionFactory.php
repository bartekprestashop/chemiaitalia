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

namespace DpdShipping\Grid\Configuration\PickupCourierSettings\Definition\Factory;

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

class PickupCourierSettingsGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    public const GRID_ID = 'dpdshipping_pickup_courier_settings';

    protected function getId()
    {
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Pickup order settings', [], 'Modules.Dpdshipping.AdminPickupCourierSettings');
    }

    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (DataColumnFactory::create('id'))
                    ->setName($this->trans('ID', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'id',
                    ])
            )
            ->add(
                (DataColumnFactory::create('customer_full_name'))
                    ->setName($this->trans('Customer company', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'customer_full_name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('customer_name'))
                    ->setName($this->trans('Customer name', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'customer_name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('customer_phone'))
                    ->setName($this->trans('Customer phone', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'customer_phone',
                    ])
            )

            ->add(
                (DataColumnFactory::create('payer_number'))
                    ->setName($this->trans('Payer number ', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'payer_number',
                    ])
            )
            ->add(
                (DataColumnFactory::create('sender_full_name'))
                    ->setName($this->trans('Sender company', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'sender_full_name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('sender_name'))
                    ->setName($this->trans('Sender name', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'sender_name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('sender_address'))
                    ->setName($this->trans('Sender address', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'field' => 'sender_address',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new SubmitRowAction('edit'))
                                ->setName($this->trans('Edit', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                                ->setIcon('edit')
                                ->setOptions([
                                    'method' => 'POST',
                                    'route' => 'dpdshipping_pickup_courier_settings_form',
                                    'route_param_name' => 'pickupCourierId',
                                    'route_param_field' => 'id',
                                ]))
                            ->add((new SubmitRowAction('delete'))
                                ->setName($this->trans('Delete', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'))
                                ->setIcon('delete')
                                ->setOptions([
                                    'method' => 'DELETE',
                                    'route' => 'dpdshipping_pickup_courier_settings_delete_form',
                                    'route_param_name' => 'pickupCourierId',
                                    'route_param_field' => 'id',
                                    'modal_options' => new ModalOptions([
                                        'title' => $this->trans('Remove selected row?', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'),
                                        'confirm_button_label' => $this->trans('Delete', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'),
                                        'confirm_button_class' => 'btn-secondary',
                                        'close_button_label' => $this->trans('Close', [], 'Modules.Dpdshipping.AdminPickupCourierSettings'),
                                    ]),
                                ])),
                    ])
            );
    }
}
