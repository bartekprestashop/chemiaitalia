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

namespace DpdShipping\Grid\ShippingHistory\Definition\Factory;

if (!defined('_PS_VERSION_')) {
    exit;
}

use DpdShipping\Grid\DataColumnFactory;
use DpdShipping\Grid\HtmlColumnFactory;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\BulkActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Bulk\Type\SubmitBulkAction;
use PrestaShop\PrestaShop\Core\Grid\Action\GridActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\ModalOptions;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\RowActionCollection;
use PrestaShop\PrestaShop\Core\Grid\Action\Row\Type\SubmitRowAction;
use PrestaShop\PrestaShop\Core\Grid\Action\Type\SimpleGridAction;
use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\BooleanColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\BulkActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\LinkColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\DateRangeType;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use PrestaShopBundle\Form\Admin\Type\YesAndNoChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ShippingHistoryGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    public const GRID_ID = 'dpdshipping_shipping_history';

    protected function getId()
    {
        return self::GRID_ID;
    }

    protected function getName()
    {
        return $this->trans('Shippings', [], 'Modules.Dpdshipping.AdminShippingHistory');
    }

    protected function getColumns()
    {
        return (new ColumnCollection())
            ->add(
                (new BulkActionColumn('bulk'))
                ->setOptions([
                    'bulk_field' => 'id',
                ])
            )
            ->add(
                (new LinkColumn('id_order'))
                    ->setName($this->trans('Order number', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'id_order',
                        'route' => 'admin_orders_view',
                        'route_param_name' => 'orderId',
                        'route_param_field' => 'id_order',
                    ])
            )
            ->add(
                (new LinkColumn('shipping_number'))
                    ->setName($this->trans('Shipping number', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'shipping_number',
                        'route' => 'dpdshipping_external_dpd_tracking',
                        'route_param_name' => 'shippingNumber',
                        'route_param_field' => 'shipping_number',
                        'target' => '_blank',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('sender_address'))
                    ->setName($this->trans('Sender address', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'sender_address',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('receiver_address'))
                    ->setName($this->trans('Receiver address', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'receiver_address',
                    ])
            )
            ->add(
                (DataColumnFactory::create('carrier_name'))
                    ->setName($this->trans('Carrier', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'carrier_name',
                    ])
            )
            ->add(
                (DataColumnFactory::create('ref1'))
                    ->setName($this->trans('Ref 1', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'ref1',
                    ])
            )
            ->add(
                (DataColumnFactory::create('ref2'))
                    ->setName($this->trans('Ref 2', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'ref2',
                    ])
            )
            ->add(
                (HtmlColumnFactory::create('services'))
                    ->setName($this->trans('Services', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'services',
                    ])
            )
            ->add(
                (DataColumnFactory::create('label_datetime'))
                    ->setName($this->trans('Label Datetime', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'label_datetime',
                    ])
            )
            ->add(
                (DataColumnFactory::create('protocol_datetime'))
                    ->setName($this->trans('Protocol Datetime', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'protocol_datetime',
                    ])
            )
            ->add(
                (new BooleanColumn('is_delivered'))
                    ->setName($this->trans('Delivered', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'is_delivered',
                        'true_name' => $this->trans('Yes', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        'false_name' => $this->trans('No', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                    ])
            )
            ->add(
                (DataColumnFactory::create('shipping_date'))
                    ->setName($this->trans('Shipping date', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'field' => 'shipping_date',
                    ])
            )
            ->add(
                (new ActionColumn('actions'))
                    ->setName($this->trans('Actions', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'actions' => (new RowActionCollection())
                            ->add((new SubmitRowAction('delete'))
                                ->setName($this->trans('Delete', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                                ->setIcon('delete')
                                ->setOptions([
                                    'method' => 'DELETE',
                                    'route' => 'dpdshipping_shipping_history_delete_form',
                                    'route_param_name' => 'shippingHistoryId',
                                    'route_param_field' => 'id',
                                    'modal_options' => new ModalOptions([
                                        'title' => $this->trans('Remove selected row?', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                                        'confirm_button_label' => $this->trans('Delete', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                                        'confirm_button_class' => 'btn-secondary',
                                        'close_button_label' => $this->trans('Close', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                                    ]),
                                ]))
                            ->add((new SubmitRowAction('printprotocol'))
                                ->setName($this->trans('Print protocol', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                                ->setIcon('print')
                                ->setOptions([
                                    'method' => 'POST',
                                    'route' => 'dpdshipping_shipping_history_print_protocols_form',
                                    'route_param_name' => 'shippingHistoryId',
                                    'route_param_field' => 'id',
                                ]))
                            ->add((new SubmitRowAction('print'))
                                ->setName($this->trans('Print label', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                                ->setIcon('print')
                                ->setOptions([
                                    'method' => 'POST',
                                    'route' => 'dpdshipping_shipping_history_print_labels_form',
                                    'route_param_name' => 'shippingHistoryId',
                                    'route_param_field' => 'id',
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
                (new Filter('id_order', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('ID Order', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('id_order')
            )
            ->add(
                (new Filter('shipping_number', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Shipping number', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('shipping_number')
            )
            ->add(
                (new Filter('sender_address', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Sender address', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('sender_address')
            )
            ->add(
                (new Filter('receiver_address', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Receiver address', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('receiver_address')
            )
            ->add(
                (new Filter('carrier_name', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Carrier', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('carrier_name')
            )
            ->add(
                (new Filter('ref1', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Ref 1', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('ref1')
            )
            ->add(
                (new Filter('ref2', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Ref 2', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('ref2')
            )
            ->add(
                (new Filter('services', TextType::class))
                    ->setTypeOptions([
                        'required' => false,
                        'attr' => [
                            'placeholder' => $this->trans('Services', [], 'Modules.Dpdshipping.AdminShippingHistory'),
                        ],
                    ])
                    ->setAssociatedColumn('services')
            )
            ->add(
                (new Filter('label_datetime', DateRangeType::class))
                    ->setTypeOptions([
                        'required' => false,
                    ])
                    ->setAssociatedColumn('label_datetime')
            )
            ->add(
                (new Filter('protocol_datetime', DateRangeType::class))
                    ->setTypeOptions([
                        'required' => false,
                    ])
                    ->setAssociatedColumn('protocol_datetime')
            )
            ->add(
                (new Filter('is_delivered', YesAndNoChoiceType::class))
                    ->setAssociatedColumn('is_delivered')
            )
            ->add(
                (new Filter('shipping_date', DateRangeType::class))
                    ->setTypeOptions([
                        'required' => false,
                    ])
                    ->setAssociatedColumn('shipping_date')
            )
            ->add(
                (new Filter('actions', SearchAndResetType::class))
                    ->setTypeOptions([
                        'reset_route' => 'admin_common_reset_search_by_filter_id',
                        'reset_route_params' => [
                            'filterId' => self::GRID_ID,
                        ],
                        'redirect_route' => 'dpdshipping_shipping_history_search_form',
                    ])
                    ->setAssociatedColumn('actions')
            );
    }

    protected function getGridActions()
    {
        return (new GridActionCollection())
            ->add(
                (new SimpleGridAction('common_refresh_list'))
                ->setName($this->trans('Refresh list', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                ->setIcon('refresh')
            );
    }

    protected function getBulkActions()
    {
        return (new BulkActionCollection())
            ->add(
                (new SubmitBulkAction('print_labels'))
                    ->setName($this->trans('Print labels', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'submit_route' => 'dpdshipping_shipping_history_print_labels_form',
                    ])
            )
            ->add(
                (new SubmitBulkAction('print_protocols'))
                    ->setName($this->trans('Print protocols', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'submit_route' => 'dpdshipping_shipping_history_print_protocols_form',
                    ])
            )
            ->add(
                (new SubmitBulkAction('delete_shipping_history_list'))
                    ->setName($this->trans('Delete', [], 'Modules.Dpdshipping.AdminShippingHistory'))
                    ->setOptions([
                        'submit_route' => 'dpdshipping_shipping_history_delete_form',
                        'submit_method' => 'POST',
                    ])
            );
    }
}
