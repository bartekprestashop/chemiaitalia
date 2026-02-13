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

    function downloadFile(xhr, response) {
        const contentType = xhr.getResponseHeader('Content-Type');
        const fileName = getFileName(xhr);
        const blob = new Blob([response], {type: contentType});
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = fileName;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function getFileName(xhr) {
        const contentDisposition = xhr.getResponseHeader('Content-Disposition');
        let fileName = 'downloaded-file';

        if (contentDisposition && contentDisposition.indexOf('attachment') !== -1) {
            const filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
            const matches = filenameRegex.exec(contentDisposition);
            if (matches != null && matches[1]) {
                fileName = matches[1].replace(/['"]/g, '');
            }
        }
        return fileName;
    }

    $('#print-label').on('click', function (event) {
        event.preventDefault();

        const shippingHistoryId = $(this).data('shipping-history-id');
        const url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                shippingHistoryId: shippingHistoryId,
                token: dpdshipping_token
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response, status, xhr) {
                downloadFile(xhr, response);
                $('.alert-messages').hide();
                $('.success-message-ajax').text(dpdshipping_translations.dpdshipping_label_success_text).show();
                $('.error-message-ajax').hide();
            },
            error: function () {
                handleErrorResponse(dpdshipping_translations.dpdshipping_label_error_text);
            }
        });
    });


    $('#print-return-label').on('click', function (event) {
        event.preventDefault();

        const shippingHistoryId = $(this).data('shipping-history-id');
        const orderId = $(this).data('order-id');
        const url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'POST',
            data: {
                shippingHistoryId: shippingHistoryId,
                orderId: orderId,
                token: dpdshipping_token
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response, status, xhr) {
                downloadFile(xhr, response);
                $('.alert-messages').hide();
                $('.success-message-ajax').text(dpdshipping_translations.dpdshipping_return_label_success_text).show();
                $('.error-message-ajax').hide();
            },
            error: function () {
                handleErrorResponse(dpdshipping_translations.dpdshipping_return_label_error_text);
            }
        });
    });

    function handleErrorResponse(message) {
        $('.alert-messages').hide();
        $('.success-message-ajax').hide();
        $('.error-message-ajax').text(message).show();
    }
});