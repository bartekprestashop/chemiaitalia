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

    $('#form_dpdshipping_pickup_courier_sender_address').on('change', function (event) {
        event.preventDefault();
        $('.errorMessagePickupCourier').hide();
        const pickupOrderSettingsId = $(this).val();
        $('#senderAddressContainer').hide();
        $.ajax({
            url: dpdshipping_pickup_courier_ajax_url, method: 'GET', data: {
                pickupOrderSettingsId: pickupOrderSettingsId,
                token: dpdshipping_token
            }, success: function (response, status, xhr) {
                if (response.success === true && response.data !== null) {
                    $('#form_customer_company').val(response.data.customerFullName);
                    $('#form_customer_name').val(response.data.customerName);
                    $('#form_customer_phone').val(response.data.customerPhone);
                    $('#senderFullName').text(response.data.senderFullName);
                    $('#senderName').text(response.data.senderName);
                    $('#senderAddress').text(response.data.senderAddress);
                    $('#senderPostalCode').text(response.data.senderPostalCode);
                    $('#senderCity').text(response.data.senderCity);
                    $('#senderCountryCode').text(response.data.senderCountryCode);
                    $('#senderPhone').text(response.data.senderPhone);
                    $('#payerNumber').text(response.data.payerNumber);
                    $('#senderAddressContainer').show();
                } else if (response.success === false && response.errors && response.errors.length > 0) {
                    $('.errorMessagePickupCourier').text(response.errors[0]);
                    $('.errorMessagePickupCourier').show();
                } else {
                    $('.errorMessagePickupCourier').text('Unknown error');
                    $('.errorMessagePickupCourier').show();
                }
            }, error: function () {
                $('.errorMessagePickupCourier').text('Unknown error');
                $('.errorMessagePickupCourier').show();
            }
        });
    });

    $('#button_get_pickup_time_frames').on('click', function (event) {
        $('.errorMessagePickupCourier').hide();
        const pickupOrderSettingsId = $('#form_dpdshipping_pickup_courier_sender_address').val()
        const countryCode = $('#senderCountryCode').text()
        const postalCode = $('#senderPostalCode').text()

        $('#pickupTimeContainer').hide();
        $.ajax({
            url: dpdshipping_pickup_courier_get_pickup_time_frames_ajax_url, method: 'GET', data: {
                pickupOrderSettingsId: pickupOrderSettingsId,
                countryCode: countryCode,
                postalCode: postalCode,
                token: dpdshipping_token
            }, success: function (response, status, xhr) {
                if (response.success === true && response.data !== null) {
                    const select = $('#form_pickup_time');
                    select.empty();

                    const currentTime = new Date();
                    $.each(response.data, function (index, item) {
                        function getEndTime() {
                            const [startTime, endTime] = item.range.split('-');
                            const [endHour, endMinute] = endTime.split(':');
                            const endDate = new Date();
                            endDate.setHours(parseInt(endHour));
                            endDate.setMinutes(parseInt(endMinute));
                            endDate.setSeconds(0);
                            return endDate;
                        }

                        const pickedDate = new Date($('#form_pickup_date').val());
                        const isToday = pickedDate.toDateString() === currentTime.toDateString();
                        const isAfterCurrentTime = getEndTime() > currentTime;

                        if ((isToday && isAfterCurrentTime) || !isToday) {
                            const option = $('<option></option>')
                                .attr('value', item.range)
                                .text(item.range);
                            select.append(option);
                        }
                    });

                    const jsonString = JSON.stringify(response.data);
                    select.attr('data-timeframes', jsonString);
                    select.val(response.data.length > 0 ? response.data[0].range : '').change();

                    $('#pickupTimeContainer').show();
                } else if (response.success === false && response.errors && response.errors.length > 0) {
                    $('.errorMessagePickupCourier').text(response.errors[0]);
                    $('.errorMessagePickupCourier').show();
                } else {
                    $('.errorMessagePickupCourier').text('Unknown error');
                    $('.errorMessagePickupCourier').show();
                }
            }, error: function () {
                $('.errorMessagePickupCourier').text('Unknown error');
                $('.errorMessagePickupCourier').show();
            }
        });
    });

    $('#pickup-courier-add-save-button').on('click', function (event) {
        event.preventDefault();
        $('.errorMessagePickupCourier').hide();

        const form = document.getElementById('dpdshipping_pickup_courier_form');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        if (!validateAddPickupCourier())
            return;


        const pickupOrderSettingsId = $('#form_dpdshipping_pickup_courier_sender_address').val()

        $.ajax({
            url: dpdshipping_pickup_courier_pickup_courier_ajax_url, method: 'POST', data: {
                pickupOrderSettingsId: pickupOrderSettingsId,
                customerFullName: $('#form_customer_company').val(),
                customerName: $('#form_customer_name').val(),
                customerPhone: $('#form_customer_phone').val(),
                senderFullName: $('#senderFullName').text(),
                senderName: $('#senderName').text(),
                senderAddress: $('#senderAddress').text(),
                senderPostalCode: $('#senderPostalCode').text(),
                senderCity: $('#senderCity').text(),
                senderCountryCode: $('#senderCountryCode').text(),
                senderPhone: $('#senderPhone').text(),
                payerNumber: $('#payerNumber').text(),
                payerName: "DPD_API",
                pickupDate: $('#form_pickup_date').val(),
                pickupTime: $('#form_pickup_time').val(),
                letters: $('#form_letters').is(':checked'),
                lettersCount: $('#form_letters_count').val(),
                packages: $('#form_packages').is(':checked'),
                packagesCount: $('#form_packages_count').val(),
                packagesWeightSum: $('#form_packages_weight_sum').val(),
                packagesWeightMax: $('#form_packages_weight_max').val(),
                packagesSizeXMax: $('#form_packages_size_x_max').val(),
                packagesSizeYMax: $('#form_packages_size_y_max').val(),
                packagesSizeZMax: $('#form_packages_size_z_max').val(),
                palette: $('#form_palette').is(':checked'),
                paletteCount: $('#form_palette_count').val(),
                paletteWeightSum: $('#form_palette_weight_sum').val(),
                paletteWeightMx: $('#form_palette_weight_max').val(),
                paletteSizeYMax: $('#form_palette_size_y_max').val(),
                token: dpdshipping_token
            }, success: function (response, status, xhr) {
                if (response.success === true && response.data !== null) {
                    window.location.href = response.data.redirectPath;
                } else if (response.success === false && response.errors && response.errors.length > 0) {
                    $('.errorMessagePickupCourier').text(response.errors[0]);
                    $('.errorMessagePickupCourier').show();
                } else {
                    $('.errorMessagePickupCourier').text('Unknown error');
                    $('.errorMessagePickupCourier').show();
                }
            }, error: function () {
                $('.errorMessagePickupCourier').text('Unknown error');
                $('.errorMessagePickupCourier').show();
            }
        });

        function isEmptyInputData(fields) {
            return fields.some(function (selector) {
                return !$.trim($(selector).val()) && !$.trim($(selector).text());
            });
        }

        function validateAddPickupCourier() {
            function showError(errorMsg) {
                $('.errorMessagePickupCourier').text(errorMsg);
                $('.errorMessagePickupCourier').show();
            }

            if (isEmptyInputData([
                '#form_customer_company',
                '#form_customer_name',
                '#form_customer_phone'])) {
                showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_customer);
                return false;
            }

            if (isEmptyInputData([
                '#senderFullName',
                '#senderName',
                '#senderAddress',
                '#senderPostalCode',
                '#senderCity',
                '#senderCountryCode',
                '#senderPhone',
            ])) {
                showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_sender);
                return false;
            }

            if (isEmptyInputData([
                '#payerNumber',
            ])) {
                showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_payer);
                return false;
            }

            if (isEmptyInputData([
                '#form_pickup_date',
                '#form_pickup_time',
            ])) {
                showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_pickup_date_time);
                return false;
            }
            if (!$('#form_letters').is(':checked') &&
                !$('#form_packages').is(':checked') &&
                !$('#form_palette').is(':checked')) {
                showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_parcel);
                return false;
            }
            if ($('#form_letters').is(':checked')) {
                if (isEmptyInputData([
                    '#form_letters_count',
                ])) {
                    showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_letters);
                    return false;
                }
            }

            if ($('#form_packages').is(':checked')) {
                if (isEmptyInputData([
                    '#form_packages_count',
                    '#form_packages_weight_sum',
                    '#form_packages_weight_max',
                    '#form_packages_size_x_max',
                    '#form_packages_size_y_max',
                    '#form_packages_size_z_max',
                ])) {
                    showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_packages);
                    return false;
                }
            }

            if ($('#form_palette').is(':checked')) {
                if (isEmptyInputData([
                    '#form_palette_count',
                    '#form_palette_weight_sum',
                    '#form_palette_weight_max',
                    '#form_palette_size_y_max'
                ])) {
                    showError(dpdshipping_pickup_courier_pickup_courier_ajax_empty_palette);
                    return false;
                }
            }

            return true;
        }
    });

    $('#form_pickup_time').on('change', function (event) {
        const selectedRange = $(this).val();
        const timeFrames = $('#form_pickup_time').data('timeframes');
        const selectedTimeFrame = timeFrames.find(tf => tf.range === selectedRange);

        function getFormatedHour() {
            const rangeParts = selectedTimeFrame.range.split('-');
            const startTime = rangeParts[0];

            const startDate = new Date();
            const [startHour, startMinute] = startTime.split(':');
            startDate.setHours(parseInt(startHour));
            startDate.setMinutes(parseInt(startMinute));
            startDate.setSeconds(0);

            const offsetDate = new Date(startDate.getTime() - selectedTimeFrame.offset * 60000);

            const offsetHour = offsetDate.getHours().toString().padStart(2, '0');
            const offsetMinute = offsetDate.getMinutes().toString().padStart(2, '0');
            return `${offsetHour}:${offsetMinute}`;
        }

        if (selectedTimeFrame) {
            $('#timeFrameHour').text(getFormatedHour());
            $('#timeFrameDate').text($('#form_pickup_date').val());
        } else {
            console.error('No matching time frame found for the selected range:', selectedRange);
        }
    });
});