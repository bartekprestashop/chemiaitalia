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

$(() => {
    function handleSelectChange() {
        const selectedValue = $(this).val();
        const parentContainer = $(this).closest('.row');
        if (selectedValue === 'STATIC_VALUE') {
            parentContainer.find('.input-static-value').removeClass('d-none').addClass('d-block');
        } else {
            parentContainer.find('.input-static-value').removeClass('d-block').addClass('d-none');
        }
    }

    $('.select-with-static-value').each(handleSelectChange);
    $(document).on('change', '.select-with-static-value', handleSelectChange);

    function handlePrintFormat() {
        const selectedValue = $('#form_printFormat').val();

        if (selectedValue === 'LBL_PRINTER') {
            $('#form_labelType').removeAttr('disabled');
        } else {
            $('#form_labelType').prop('selectedIndex', 0);
            $('#form_labelType').attr('disabled', 'disabled');
        }
    }
    handlePrintFormat();
    $(document).on('change', '#form_printFormat', handlePrintFormat);

});