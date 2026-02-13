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

// noinspection JSUnresolvedReference

if (typeof dpsShippingCodEventCreated == 'undefined') {
    var dpsShippingCodEventCreated = false;
}

var dpsShippingCod_iframe = document.createElement("iframe");
dpsShippingCod_iframe.setAttribute("id", "dpdshipping-widget-pudo-cod-iframe");
dpsShippingCod_iframe.setAttribute("allow", "geolocation");
dpsShippingCod_iframe.src = dpdshipping_iframe_cod_url;
dpsShippingCod_iframe.style.width = "100%";
dpsShippingCod_iframe.style.border = "none";
dpsShippingCod_iframe.style.minHeight = "400px";
dpsShippingCod_iframe.style.height = "768px";

var dpsShippingCod_script = document.getElementById("dpdshipping-widget-pudo-cod");
if (dpsShippingCod_script)
    dpsShippingCod_script.parentNode.insertBefore(dpsShippingCod_iframe, dpsShippingCod_script);

if (!dpsShippingCodEventCreated) {
    var dpsShippingCod_eventListener = window[window.addEventListener ? "addEventListener" : "attachEvent"];
    var dpsShippingCod_messageEvent = ("attachEvent" === dpsShippingCod_eventListener) ? "onmessage" : "message";
    dpsShippingCod_eventListener(dpsShippingCod_messageEvent, function (a) {
        if (getDpdshippingIdPudoCodCarrier() === getDpdshippingSelectedCarrier()) {
            if (a.data.height && !isNaN(a.data.height)) {
                dpsShippingCod_iframe.style.height = a.data.height + "px"
            } else if (a.data.point_id)
                dpdShippingCodPointSelected(a.data.point_id);
        }
    }, !1);
    dpsShippingCodEventCreated = true
}

function dpdShippingCodPointSelected(pudoCode) {
    $('.container_dpdshipping_pudo_cod_error').css("display", "none");
    $('.dpdshipping-pudo-cod-new-point').css("display", "none");
    $('.dpdshipping-pudo-cod-selected-point').css("display", "block");

    dpdshippingSavePudoCode(pudoCode, $('#dpdshippingPudoCodModal'));
    dpdshippingGetPudoAddress(pudoCode, $('.dpdshipping-cod-selected-point'))
    dpdshippingIsPointWithCod(pudoCode)
}


function dpdshippingIsPointWithCod(pudoCode) {
    $.ajax({
        url: dpdshipping_pickup_is_point_with_cod_ajax_url,
        type: 'GET',
        data: {
            dpdshipping_token: dpdshipping_token,
            dpdshipping_csrf: dpdshipping_csrf,
            dpdshipping_pudo_code: pudoCode
        },
        success: function (response) {
            const resultJson = JSON.parse(response)
            if (resultJson.success && resultJson.data && Number(resultJson.data) === 1) {
                $('.container_dpdshipping_pudo_cod_warning').css("display", "none");
            } else {
                $('.container_dpdshipping_pudo_cod_warning').css("display", "block");
                dpdshippingDisableOrderProcessBtn();
            }
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
}