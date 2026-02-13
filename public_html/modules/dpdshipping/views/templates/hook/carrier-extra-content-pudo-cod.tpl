{**
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
 *
 *}

<div class="col-xs-12 dpdshipping-pudo-cod-container">

    <div class="form-group container_dpdshipping_pudo_cod_warning" style="display:none">
        <p class="alert alert-danger">{l s='Selected point does not provide the cod service' d='Modules.Dpdshipping.Checkout'}</p>
    </div>

    <div class="form-group container_dpdshipping_pudo_cod_error" style="display:none">
        <p class="alert alert-danger">{l s='Error occured. Please try again' d='Modules.Dpdshipping.Checkout'}</p>
    </div>

    <div class="dpdshipping-pudo-cod-new-point">
        <span> {l s='DPD pickup point:' d='Modules.Dpdshipping.Checkout'}</span>
        <div class="dpdshipping-pudo-cod-open-map-btn btn btn-secondary">
            {l s='Select from map' d='Modules.Dpdshipping.Checkout'}
        </div>
    </div>
    <div class="dpdshipping-pudo-cod-selected-point" style="display: none">
        <p> {l s='Selected DPD pickup point:' d='Modules.Dpdshipping.Checkout'} <span
                    class="dpdshipping-cod-selected-point font-weight-bold"></span></p>
        <div class="dpdshipping-pudo-cod-change-map-btn btn btn-secondary float-xs-right">
            {l s='Change' d='Modules.Dpdshipping.Checkout'}
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="dpdshippingPudoCodModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dpd-xl" role="document">
        <div class="modal-content modal-dpd-content">
            <div class="modal-body modal-dpd-body">
                <script id="dpdshipping-widget-pudo-cod" type="text/javascript"></script>
                <script type="text/javascript" src="{$dpdshipping_pudo_cod_iframe_js}"></script>
            </div>
            <div class="modal-footer modal-dpd-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{l s='Close' d='Modules.Dpdshipping.Checkout'}</button>
            </div>
        </div>
    </div>
</div>