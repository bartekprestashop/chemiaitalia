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

namespace DpdShipping\Grid\PickupCourier\Definition\Factory;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Grid\DataColumnFactory;
use DpdShipping\Grid\HtmlColumnFactory;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\ModalOptions;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\DateRangeType;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PickupCourierGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    public const GRID_ID = 'dpdshipping_pickup_courier';

    protected function getId()
    {
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Pickup Courier', [], 'Modules.Dpdshipping.AdminPickupCourier');
    }

    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (HtmlColumnFactory::create('state'))
                    ->setName($this->trans('State', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'state',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('order_number'))
                    ->setName($this->trans('Order number', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'order_number',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('sender_address'))
                    ->setName($this->trans('Sender address', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'sender_address',
                    ])
            )
            ->add(
                (DataColumnFactory::create('letter'))
                    ->setName($this->trans('Letter', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'letter',
                    ])
            )
            ->add(
                (DataColumnFactory::create('packages'))
                    ->setName($this->trans('Packages', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'packages',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('palette'))
                    ->setName($this->trans('Palette', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'palette',
                    ])
            )
            ->add(
                (DataColumnFactory::create('pickup_time'))
                    ->setName($this->trans('Pickup time', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'pickup_time',
                    ])
            )
            ->add(
                (DataColumnFactory::create('pickup_date'))
                    ->setName($this->trans('Pickup date', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'field' => 'pickup_date',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new SubmitRowAction('delete'))
                                ->setName($this->trans('Reject', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                                ->setIcon('delete')
                                ->setOptions([
                                    'method' => 'DELETE',
                                    'route' => 'dpdshipping_pickup_courier_delete_pickup_courier',
                                    'route_param_name' => 'pickupOrderId',
                                    'route_param_field' => 'id',
                                    'modal_options' => new ModalOptions([
                                        'title' => $this->trans('Cancel selected pickup courier?', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                                        'confirm_button_label' => $this->trans('Delete', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                                        'confirm_button_class' => 'btn-secondary',
                                        'close_button_label' => $this->trans('Close', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                                    ]),
                                ])),
                    ])
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilters()
    {
        return (new FilterCollection())
            ->add(
                (new Filter('state', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('State', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('state')
            )
            ->add(
                (new Filter('order_number', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Order number', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('order_number')
            )
            ->add(
                (new Filter('sender_address', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Sender address', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('sender_address')
            )
            ->add(
                (new Filter('letter', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Letter', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('letter')
            )
            ->add(
                (new Filter('packages', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Packages', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('packages')
            )
            ->add(
                (new Filter('palette', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Palette', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('palette')
            )
            ->add(
                (new Filter('pickup_time', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('HH:MM', [], 'Modules.Dpdshipping.AdminPickupCourier'),
                        ],
                    ])
                    ->setAssociatedColumn('pickup_time')
            )
            ->add(
                (new Filter('pickup_date', DateRangeType::class))
                    ->setTypeOptions([
                        'required' => false,
                    ])
                    ->setAssociatedColumn('pickup_date')
            )
            ->add(
                (new Filter('actions', SearchAndResetType::class))
                    ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => [
                            'filterId' => self::GRID_ID,
                        ],
                        'redirect_route' => 'dpdshipping_pickup_courier_form',
                    ])
                    ->setAssociatedColumn('actions')
            );
    }

    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add(
                (new SimpleGridAction('common_refresh_list'))
                ->setName($this->trans('Refresh list', [], 'Modules.Dpdshipping.AdminPickupCourier'))
                ->setIcon('refresh')
            );
    }
}
