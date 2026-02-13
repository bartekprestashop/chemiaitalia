/*
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

$(document).ready(function () {

    handleDpdShippingFormCardBody();

        changeTable($('#packageGroupType').val());

        $(document).on('change', '#dpd_shipping_generate_shipping_service_guarantee', function () {
            changeVisibility(getCheckboxId(this), '.service_guarantee_type', '#dpd_shipping_generate_shipping_service_guarantee_type');
            changeVisibility(getCheckboxId(this), '.service_guarantee_value', '#dpd_shipping_generate_shipping_service_guarantee_value');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_guarantee', '.service_guarantee_type', '#dpd_shipping_generate_shipping_service_guarantee_type');
        changeVisibility('#dpd_shipping_generate_shipping_service_guarantee', '.service_guarantee_value', '#dpd_shipping_generate_shipping_service_guarantee_value');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_cod', function () {
            changeVisibility(getCheckboxId(this), '.service_cod_value', '#dpd_shipping_generate_shipping_service_cod_value');
            changeVisibility(getCheckboxId(this), '.service_cod_currency', '#dpd_shipping_generate_shipping_service_cod_currency');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_cod', '.service_cod_value', '#dpd_shipping_generate_shipping_service_cod_value');
        changeVisibility('#dpd_shipping_generate_shipping_service_cod', '.service_cod_currency', '#dpd_shipping_generate_shipping_service_cod_currency');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_self_con', function () {
            changeVisibility(getCheckboxId(this), '.service_self_con_value', '#dpd_shipping_generate_shipping_service_self_con_value');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_self_con', '.service_self_con_value', '#dpd_shipping_generate_shipping_service_self_con_value');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_dpd_pickup', function () {
            changeVisibility(getCheckboxId(this), '.service_dpd_pickup_value', '#dpd_shipping_generate_shipping_service_dpd_pickup_value');
            changeVisibility(getCheckboxId(this), '.service_dpd_pickup_map', '#dpd_shipping_generate_shipping_service_dpd_pickup_map');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_dpd_pickup', '.service_dpd_pickup_value', '#dpd_shipping_generate_shipping_service_dpd_pickup_value');
        changeVisibility('#dpd_shipping_generate_shipping_service_dpd_pickup', '.service_dpd_pickup_map', '#dpd_shipping_generate_shipping_service_dpd_pickup_map');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_declared_value', function () {
            changeVisibility(getCheckboxId(this), '.service_declared_value_value', '#dpd_shipping_generate_shipping_service_declared_value_value');
            changeVisibility(getCheckboxId(this), '.service_declared_value_currency', '#dpd_shipping_generate_shipping_service_declared_value_currency');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_declared_value', '.service_declared_value_value', '#dpd_shipping_generate_shipping_service_declared_value_value');
        changeVisibility('#dpd_shipping_generate_shipping_service_declared_value', '.service_declared_value_currency', '#dpd_shipping_generate_shipping_service_declared_value_currency');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_dpd_food', function () {
            changeVisibility(getCheckboxId(this), '.service_dpd_food_value', '#dpd_shipping_generate_shipping_service_dpd_food_value');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_dpd_food', '.service_dpd_food_value', '#dpd_shipping_generate_shipping_service_dpd_food_value');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_duty', function () {
            changeVisibility(getCheckboxId(this), '.service_duty_value', '#dpd_shipping_generate_shipping_service_duty_value');
            changeVisibility(getCheckboxId(this), '.service_duty_currency', '#dpd_shipping_generate_shipping_service_duty_currency');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_duty', '.service_duty_value', '#dpd_shipping_generate_shipping_service_duty_value');
        changeVisibility('#dpd_shipping_generate_shipping_service_duty', '.service_duty_currency', '#dpd_shipping_generate_shipping_service_duty_currency');

        $(document).on('change', '#dpd_shipping_generate_shipping_service_return_label', function () {
            changeVisibility(getCheckboxId(this), '.service_return_label_address_company', '#dpd_shipping_generate_shipping_service_return_label_address_company');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_name', '#dpd_shipping_generate_shipping_service_return_label_address_name');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_street', '#dpd_shipping_generate_shipping_service_return_label_address_street');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_city', '#dpd_shipping_generate_shipping_service_return_label_address_city');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_postcode', '#dpd_shipping_generate_shipping_service_return_label_address_postcode');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_country', '#dpd_shipping_generate_shipping_service_return_label_address_country');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_phone', '#dpd_shipping_generate_shipping_service_return_label_address_phone');
            changeVisibility(getCheckboxId(this), '.service_return_label_address_email', '#dpd_shipping_generate_shipping_service_return_label_address_email');
        });

        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_company', '#dpd_shipping_generate_shipping_service_return_label_address_company');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_name', '#dpd_shipping_generate_shipping_service_return_label_address_name');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_street', '#dpd_shipping_generate_shipping_service_return_label_address_street');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_city', '#dpd_shipping_generate_shipping_service_return_label_address_city');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_postcode', '#dpd_shipping_generate_shipping_service_return_label_address_postcode');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_country', '#dpd_shipping_generate_shipping_service_return_label_address_country');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_phone', '#dpd_shipping_generate_shipping_service_return_label_address_phone');
        changeVisibility('#dpd_shipping_generate_shipping_service_return_label', '.service_return_label_address_email', '#dpd_shipping_generate_shipping_service_return_label_address_email');

        $(document).on('click', '.dpdshipping-remove-row', function () {
            removeRow(this)
        });

        $(document).on('click', '#dpdShippingAddRow', function () {
            changeTable('addRow');
        });

        $(document).on('click', '#dpdShippingSingleShipping', function () {
            changeTable('single');
        });

        $(document).on('click', '#dpdShippingGroupShipping', function () {
            changeTable('group');
        });

        $(document).on('click', '#dpdShippingPackageShipping', function () {
            changeTable('package');
        });

        $(document).on('click', '#dpdShippingCalcShippingRows', function () {
            setDpdShippingCustomShippingRows();
            setDpdShippingCustomParcel();
            $('#dpdShippingParcelSummaryRow').removeClass('hidden');
        });

        $(document).on('change', '.dpdShippingCustomParcelSelect', function () {
            setDpdShippingCustomParcel();
        });

        $(document).on('click', '#dpdShippingCustomParcelSave', function () {
            changeTable('custom', getDpdShippingCustomParcel())
        });

        $(document).on('click', '#dpdShippingCustomShipping', function () {
            $('#dpdShippingCalcShippingRows').click();
        });

        $(document).on('change', '#dpdShippingSenderAddresses', function () {
            const address = $(this).find('option:selected').data('address');
            $('#dpd_shipping_generate_shipping_sender_address_company').val(address.company);
            $('#dpd_shipping_generate_shipping_sender_address_name').val(address.name);
            $('#dpd_shipping_generate_shipping_sender_address_street').val(address.street);
            $('#dpd_shipping_generate_shipping_sender_address_postcode').val(address.postcode);
            $('#dpd_shipping_generate_shipping_sender_address_country').val(address.country);
            $('#dpd_shipping_generate_shipping_sender_address_city').val(address.city);
            $('#dpd_shipping_generate_shipping_sender_address_phone').val(address.phone);
            $('#dpd_shipping_generate_shipping_sender_address_email').val(address.email);
        });

        $(document).on('change', '#dpdShippingReceiverAddresses', function () {
            const address = $(this).find('option:selected').data('address');
            $('#dpd_shipping_generate_shipping_receiver_address_company').val(address.company);
            $('#dpd_shipping_generate_shipping_receiver_address_name').val(address.name);
            $('#dpd_shipping_generate_shipping_receiver_address_street').val(address.street);
            $('#dpd_shipping_generate_shipping_receiver_address_postcode').val(address.postcode);
            $('#dpd_shipping_generate_shipping_receiver_address_country').val(address.country);
            $('#dpd_shipping_generate_shipping_receiver_address_city').val(address.city);
            $('#dpd_shipping_generate_shipping_receiver_address_phone').val(address.phone);
            $('#dpd_shipping_generate_shipping_receiver_address_email').val(address.email);
        });

        $(document).on('click', '.dpdshipping-tracking-detail-btn', function () {
            $(this).next(".dpdshipping-tracking-detail").toggleClass("hidden");
        });

        showWeightAdr();

        $(document).on('change', '#dpd_shipping_generate_shipping_service_adr', function () {
            showWeightAdr();
        });

        function showWeightAdr() {
            if ($('#dpd_shipping_generate_shipping_service_adr').prop('checked')) {
                $(".dpdShippingWeightAdr").removeClass("hidden");
            } else {
                $(".dpdShippingWeightAdr").addClass("hidden");
            }
        }

        function getCheckboxId(input) {
            return '#' + input.id;
        }

        function changeVisibility(checkBoxId, relatedClass, input) {
            if ($(checkBoxId).is(':checked')) {
                $(relatedClass).removeClass('hidden');
                $(input).prop('disabled', false);
                if (input !== "#dpd_shipping_generate_shipping_service_guarantee_value")
                    $(input).prop('required', true);

            } else {
                $(relatedClass).addClass('hidden');
                $(input).prop('disabled', 'disabled');
                if (input !== "#dpd_shipping_generate_shipping_service_guarantee_value")
                    $(input).prop('required', false);
            }
        }

        function removeRow(button) {
            const rowCount = $('#packagesTable tr').length;
            if (rowCount > 2)
                $(button).closest('tr').remove();
        }

        function changeTable(type, customData) {
            const lastContainer = $("#packagesTable tbody tr:last");
            const packagesTable = document.getElementById('packagesTable');
            if (!packagesTable) {
                console.error('Table with ID "packagesTable" not found.');
                return;
            }

            const tbodyByTagName = packagesTable.getElementsByTagName('tbody')
            if (tbodyByTagName == null || tbodyByTagName.length === 0) {
                console.error('No <tbody> elements found in the table.');
                return;
            }

            const tbody = tbodyByTagName[0];
            while (type !== "addRow" && tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Create new rows based on the selected action
            if (type === 'single') {
                const clonedRow = lastContainer.clone();
                let data = getSingleRow()
                setInputsData(clonedRow, data);
                setIndexForNewRow(clonedRow);
                $("#packagesTable").append(clonedRow);
            } else if (type === 'group') {
                const productsData = $('#dpdShippingOrderProducts').data('products');
                Object.keys(productsData).forEach(function (index) {
                    const product = productsData[index];
                    const clonedRow = lastContainer.clone();
                    let data = {
                        weight: getProductWeight([product], true),
                        weightAdr: null,
                        customerData: getData([product], 300, 'customer-source'),
                        content: getData([product], 300, 'content-source'),
                        sizeX: '',
                        sizeY: '',
                        sizeZ: ''
                    }
                    setInputsData(clonedRow, data);
                    setIndexForNewRow(clonedRow);
                    $("#packagesTable").append(clonedRow);
                });
            } else if (type === 'package') {
                const productsData = $('#dpdShippingOrderProducts').data('products');
                Object.keys(productsData).forEach(function (index) {
                    const product = productsData[index];
                    for (let i = 0; i < product.product_quantity; i++) {
                        const clonedRow = lastContainer.clone();
                        let data = {
                            weight: getProductWeight([product], false),
                            weightAdr: null,
                            customerData: getData([product], 300, 'customer-source'),
                            content: getData([product], 300, 'content-source'),
                            sizeX: '',
                            sizeY: '',
                            sizeZ: ''
                        }
                        setInputsData(clonedRow, data);
                        setIndexForNewRow(clonedRow);
                        $("#packagesTable").append(clonedRow);
                    }
                });
            } else if (type === 'addRow') {
                const clonedRow = lastContainer.clone();
                let data = {
                    weight: 1.0,
                    weightAdr: null,
                    customerData: "",
                    content: "",
                    sizeX: "",
                    sizeY: "",
                    sizeZ: "",
                }
                setInputsData(clonedRow, data);
                setIndexForNewRow(clonedRow);
                $("#packagesTable").append(clonedRow);
            } else if (type === 'custom') {
                Object.keys(customData).forEach(function (index) {
                    const parcel = customData[index];
                    const clonedRow = lastContainer.clone();
                    let data = {
                        weight: parcel.product_weight,
                        weightAdr: null,
                        customerData: parcel.customerData,
                        content: parcel.content,
                        sizeX: '',
                        sizeY: '',
                        sizeZ: ''
                    }
                    setInputsData(clonedRow, data);
                    setIndexForNewRow(clonedRow);
                    $("#packagesTable").append(clonedRow);
                });
            }

            function setInputsData(clonedRow, data) {

                clonedRow.find('input').each(function () {
                    const inputType = $(this).attr('fieldType');
                    switch (inputType) {
                        case 'weight':
                            $(this).val(data.weight);
                            break;
                        case 'weightAdr':
                            $(this).val(data.weightAdr);
                            break;
                        case 'customerData':
                            $(this).val(data.customerData);
                            break;
                        case 'content':
                            $(this).val(data.content);
                            break;
                        case 'sizeX':
                            $(this).val(data.sizeX);
                            break;
                        case 'sizeY':
                            $(this).val(data.sizeY);
                            break;
                        case 'sizeZ':
                            $(this).val(data.sizeZ);
                            break;
                    }
                });
            }

            function setIndexForNewRow(clonedRow) {
                function setIndexes() {
                    const index = parseInt($("#packagesTable tbody tr").length);
                    const currentName = $(this).attr('name');
                    const newName = currentName.replace(/\[(\d+)\]/, '[' + index + ']');
                    $(this).attr('name', newName);

                    const currentId = $(this).attr('id');
                    const newId = currentId.replace(/\_(\d+)\_/, '_' + index + '_');
                    $(this).attr('id', newId);
                }

                clonedRow.find('input').each(function () {
                    setIndexes.call(this);
                });

                clonedRow.find('select').each(function () {
                    setIndexes.call(this);
                });
            }

            function getSingleRow() {
                const productsData = $('#dpdShippingOrderProducts').data('products');

                return {
                    weight: getProductWeight(productsData, true),
                    weightAdr: null,
                    customerData: getData(productsData, 300, 'customer-source'),
                    content: getData(productsData, 300, 'content-source'),
                    sizeX: '',
                    sizeY: '',
                    sizeZ: ''
                }
            }

        }

        function setDpdShippingCustomShippingRows() {
            const parcels = Number($('#dpdShippingCustomShippingParcels').val());
            const newOptions = generateParcelsArray(parcels);

            const elements = $('.dpdShippingCustomParcelSelect');

            elements.each(function () {
                const select = $(this)
                select.empty();
                $.each(newOptions, function (index, value) {
                    select.append($('<option>', {
                        value: value,
                        text: value
                    }));
                });
            });

            function generateParcelsArray(size) {
                const array = [];
                for (let i = 1; i <= size; i++) {
                    array.push(i);
                }
                return array;
            }
        }

        function setDpdShippingCustomParcel() {
            const summaryTable = $('.dpdShippingCustomParcelSummaryTable');
            const parcels = getDpdShippingCustomParcel();

            let rows = "";
            Object.keys(parcels).forEach(function (parcel) {
                const parcelData = parcels[parcel];
                rows += '<tr>';
                rows += '<td>' + parcelData.parcel + '</td>';
                rows += '<td>' + parcelData.content + '</td>';
                rows += '<td>' + parcelData.customerData + '</td>';
                rows += '<td>' + parcelData.product_weight + '</td>';
                rows += '</tr>';
            });

            summaryTable.empty();
            summaryTable.append(rows);
        }

        function getDpdShippingCustomParcel() {

            const parcels = {};
            getProducts().forEach(function (product) {
                if (!parcels[product.parcel]) {
                    parcels[product.parcel] = [];
                }
                parcels[product.parcel].push(product);
            });

            const result = []
            Object.keys(parcels).forEach(function (parcel) {
                const parcelData = parcels[parcel];

                result.push({
                    parcel: parcel,
                    customerData: getData(parcelData, 300, 'customer-source'),
                    content: getData(parcelData, 300, 'content-source'),
                    product_weight: getProductWeight(parcelData, false),
                })
            });

            return result;

            function getProducts() {
                const products = [];

                const parcels = getSelectValues('dpdShippingCustomShippingParcel');
                const productNames = getInputValues('dpdShippingCustomShippingProductName');
                const productIds = getInputValues('dpdShippingCustomShippingProductId');
                const productWeights = getInputValues('dpdShippingCustomShippingProductWeight');
                const productReferences = getInputValues('dpdShippingCustomShippingProductReference');

                for (let i = 0; i < productIds.length; i++) {
                    const product = {
                        product_reference: productReferences[i],
                        product_weight: productWeights[i],
                        product_name: productNames[i],
                        product_id: productIds[i],
                        parcel: parcels[i],
                        customerData: '',
                        content: '',
                    };
                    products.push(product);
                }

                return products;
            }

            function getSelectValues(selectName) {
                return $('select[name^="' + selectName + '["]').map(function () {
                    return $(this).val();
                }).get();
            }

            function getInputValues(selectName) {
                return $('input[name^="' + selectName + '["]').map(function () {
                    return $(this).val();
                }).get();
            }
        }

        function getProductWeight(parcel, multiplyQuantity) {
            let sum = 0;
            parcel.forEach(function (product) {
                let weight = Number(product.product_weight);
                if (weight <= 0)
                    weight = $('#dpdShippingDefaultWeight').data('default-weight');

                if (multiplyQuantity)
                    sum += weight * Number(product.product_quantity);
                else
                    sum += weight;
            });

            return sum.toFixed(2);
        }


        function getData(parcel, limit, sourceString) {
            const source = $('#dpdShippingSource').data(sourceString);
            const sourceStatic = $('#dpdShippingSource').data(sourceString + '-static');

            const unique = [];
            parcel.forEach(function (product) {
                const dynamicField = getDynamicField(source, sourceStatic, product)
                if (!unique.includes(dynamicField)) {
                    unique.push(dynamicField);
                }
            });

            return getStringWithMaxLength(unique.join(', '), limit);
        }

        function getDynamicField(source, sourceStatic, product) {
            if (source === "STATIC_VALUE")
                return sourceStatic;
            else if (source === "ORDER_NUMBER")
                return $('#dpdShippingOrderNumber').data('order-number');
            else if (source === "ORDER_ID")
                return $('#dpdShippingOrderId').data('order-id');
            else if (source === "INVOICE_NUMBER")
                return $('#dpdShippingInvoiceNumber').data('invoice-number');
            else if (source === "PRODUCT_INDEX")
                return product.product_reference;
            else if (source === "PRODUCT_NAME")
                return product.product_name;
            return '';
        }

        function getStringWithMaxLength(data, limit) {
            if (data.length > limit) {
                return data.substring(0, limit - 3) + '...';
            }
            return data;
        }

        $(document).on('click', '.dpdshipping-pudo-change-map-btn', (e) => showModal(e, '#dpdshippingPudoModal'));

        function showModal(event, modalDiv) {
            event.preventDefault();
            event.stopPropagation();
            $(modalDiv).modal({
                backdrop: 'static',
                keyboard: false
            })
        }

    function handleDpdShippingFormCardBody() {
        const dpdCarrierValue = $("#dpdShippingIsDpdCarrier").data("dpd-carrier");
        const isDpdCarrier = dpdCarrierValue === 1 || dpdCarrierValue === "1";

        if (!isDpdCarrier) {
            $('form[name="dpd_shipping_generate_shipping"] .card-body').toggle();
            $('form[name="dpd_shipping_generate_shipping"] .card-footer').toggle();

            const toggleButton = $("#dpdToggleButton");
            const icon = toggleButton.find("span.material-icons");
            icon.text("expand_more");
        }

        $('#dpdToggleButton').click(function (e) {
            e.preventDefault();
            const dpdCardBody = $('form[name="dpd_shipping_generate_shipping"] .card-body')
            dpdCardBody.toggle();
            $('form[name="dpd_shipping_generate_shipping"] .card-footer').toggle();

            const icon = $(this).find("span.material-icons");
            if (dpdCardBody.is(":visible")) {
                icon.text("expand_less");
            } else {
                icon.text("expand_more");
            }
        });
    }
    }
);
