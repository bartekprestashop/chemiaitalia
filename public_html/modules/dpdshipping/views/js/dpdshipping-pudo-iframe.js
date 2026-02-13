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

if (typeof dpdshippingEventCreated == 'undefined') {
    var dpdshippingEventCreated = false;
}

var dpdshipping_iframe = document.createElement("iframe");
dpdshipping_iframe.setAttribute("id", "dpdshipping-widget-pudo-iframe");
dpdshipping_iframe.setAttribute("allow", "geolocation");
dpdshipping_iframe.src = dpdshipping_iframe_url;
dpdshipping_iframe.style.width = "100%";
dpdshipping_iframe.style.border = "none";
dpdshipping_iframe.style.minHeight = "400px";
dpdshipping_iframe.style.height = "768px";

var dpdshipping_script = document.getElementById("dpdshipping-widget-pudo");
if (dpdshipping_script)
    dpdshipping_script.parentNode.insertBefore(dpdshipping_iframe, dpdshipping_script);

if (!dpdshippingEventCreated) {
    var dpdshipping_eventListener = window[window.addEventListener ? "addEventListener" : "attachEvent"];
    var dpdshipping_messageEvent = ("attachEvent" === dpdshipping_eventListener) ? "onmessage" : "message";
    dpdshipping_eventListener(dpdshipping_messageEvent, function (a) {
        if (getDpdshippingIdPudoCarrier() === getDpdshippingSelectedCarrier()) {
        if (a.data.height && !isNaN(a.data.height)) {
            dpdshipping_iframe.style.height = a.data.height + "px"
        } else if (a.data.point_id)
            dpdShippingPointSelected(a.data.point_id);
        }
    }, !1);
    dpdshippingEventCreated = true
}

function dpdShippingPointSelected(pudoCode) {
    $('.container_dpdshipping_pudo_error').css("display", "none");
    $('.dpdshipping-pudo-new-point').css("display", "none");
    $('.dpdshipping-pudo-selected-point').css("display", "block");

    dpdshippingSavePudoCode(pudoCode, $('#dpdshippingPudoModal'));
    dpdshippingGetPudoAddress(pudoCode, $('.dpdshipping-selected-point'))

}