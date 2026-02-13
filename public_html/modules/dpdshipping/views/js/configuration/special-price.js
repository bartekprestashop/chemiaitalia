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

    $(document).on('click', '#addFidRow', function () {
        const parentContainer = $("#specialPriceTable tbody tr:last");
        const clonedRow = parentContainer.clone();

        setIndexForNewRow(clonedRow, true);
        clonedRow.insertAfter(parentContainer);
    });

    $(document).on('click', '.dpdshipping-remove-row', function () {
        $(this).closest('tr').remove();

        $("#specialPriceTable tbody tr").each(function (index) {
            function setIndexesAfterRemoveRow() {
                const currentName = $(this).attr('name');
                const matches = currentName.match(/\[(\d+)\]/);
                if (matches) {
                    const newIndex = index + 1;
                    const newName = currentName.replace(/\[(\d+)\]/, '[' + newIndex + ']');
                    $(this).attr('name', newName);
                }
            }

            $(this).find('input').each(function () {
                setIndexesAfterRemoveRow.call(this);
            });

            $(this).find('select').each(function () {
                setIndexesAfterRemoveRow.call(this);
            });
        });

    });

    $(document).on('click', '.dpdshipping-duplicate-row', function () {
        const parentContainer = $(this).closest('tr');
        const clonedRow = parentContainer.clone();

        setIndexForNewRow(clonedRow, false);
        const lastRow = $("#specialPriceTable tbody tr:last");
        clonedRow.insertAfter(lastRow);
    });

    function setIndexForNewRow(clonedRow, emptyValue) {
        function setIndexes() {
            const index = parseInt($("#specialPriceTable tbody tr").length) + 1;
            const currentName = $(this).attr('name');
            const newName = currentName.replace(/\[(\d+)\]/, '[' + index + ']');
            $(this).attr('name', newName);
            if (emptyValue)
                $(this).val('');
        }

        clonedRow.find('input').each(function () {
            setIndexes.call(this);
        });

        clonedRow.find('select').each(function () {
            setIndexes.call(this);
        });
    }
});
