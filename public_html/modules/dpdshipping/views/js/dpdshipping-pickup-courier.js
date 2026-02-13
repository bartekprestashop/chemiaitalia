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

    setLetterFields($('#form_letters'))
    setPackageFields($('#form_packages'))
    setPaletteFields($('#form_palette'))

    $(document).on('change', '#form_letters', function () {
        setLetterFields($('#form_letters'));
    });

    $(document).on('change', '#form_packages', function () {
        setPackageFields($('#form_packages'));
    });

    $(document).on('change', '#form_palette', function () {
        setPaletteFields($('#form_palette'));
    });


    function checkConfigurationWarning() {
        if ($('#form_dpdshipping_pickup_courier_sender_address option').length <= 1) {
            $('.warnMessagePickupCourier').text(dpdshipping_pickup_courier_pickup_courier_empty_configuration);
            $('.warnMessagePickupCourier').show();
        }
    }

    checkConfigurationWarning()

    function setLetterFields(input) {
        function getLetterFields() {
            return $("label[for='form_letters_count'], #form_letters_count");
        }

        if (input.is(':checked')) {
            getLetterFields().show();
            $('#form_palette').prop("checked", false);
            $('#form_packages').prop("checked", false);
        } else {
            getLetterFields().hide();
            $('#form_letters_count').val(undefined);
        }
    }

    function setPackageFields(input) {
        function getPackagesFields() {
            return $(
                "label[for='form_packages_count'], #form_packages_count, " +
                "label[for='form_packages_weight_sum'], #form_packages_weight_sum, " +
                "label[for='form_packages_weight_max'], #form_packages_weight_max, " +
                "label[for='form_packages_size_x_max'], #form_packages_size_x_max, " +
                "label[for='form_packages_size_y_max'], #form_packages_size_y_max, " +
                "label[for='form_packages_size_z_max'], #form_packages_size_z_max");
        }

        if (input.is(':checked')) {
            getPackagesFields().show();
            $('#form_letters').prop("checked", false);
            $('#form_palette').prop("checked", false);
        } else {
            getPackagesFields().hide();
            $('#form_packages_count').val(undefined);
            $('#form_packages_weight_sum').val(undefined);
            $('#form_packages_weight_max').val(undefined);
            $('#form_packages_size_x_max').val(undefined);
            $('#form_packages_size_y_max').val(undefined);
            $('#form_packages_size_z_max').val(undefined);
        }
    }

    function setPaletteFields(input) {
        function getPaletteFields() {
            return $(
                "label[for='form_palette_count'], #form_palette_count, " +
                "label[for='form_palette_weight_sum'], #form_palette_weight_sum, " +
                "label[for='form_palette_weight_max'], #form_palette_weight_max, " +
                "label[for='form_palette_size_y_max'], #form_palette_size_y_max");
        }

        if (input.is(':checked')) {
            getPaletteFields().show();
            $('#form_letters').prop("checked", false);
            $('#form_packages').prop("checked", false);
        } else {
            getPaletteFields().hide();
            $('#form_palette_count').val(undefined);
            $('#form_palette_weight_sum').val(undefined);
            $('#form_palette_weight_max').val(undefined);
            $('#form_palette_size_y_max').val(undefined);
        }
    }
});