<h4>{l s='Google merchant XML' mod='x13googlemerchant'}</h4>
<div class="separation"></div>

<input type="hidden" name="x13googlemerchant_product_extra" value="1">

<table cellpadding="5" style="width:100%">
    <tbody>
        <tr>
            <td>
                <table style="margin-top: 15px;">
                    <tbody>
                        <tr>
                            <td class="col-left"><label>{l s='Nazwa produktu' mod='x13googlemerchant'}</label></td>
                            <td style="padding-bottom:5px;" class="translatable">
                                {foreach from=$languages item=language}
                                    <div class="lang_{$language.id_lang}" style="{if $language.id_lang != $default_language}display: none;{/if} float: left;">
                                        <input type="text" id="custom_title_{$language.id_lang}" name="custom_title[{$language.id_lang}]" value="{if isset($custom_title[$language.id_lang])}{$custom_title[$language.id_lang]}{/if}">
                                    </div>
                                {/foreach}
                            </td>
                        </tr>
                        <tr>
                            <td class="col-left"></td>
                            <td style="padding-bottom:5px;">
                                <p class="preference_description">
                                    {l s='{product_name} - Nazwa produktu' mod='x13googlemerchant'}<br />
                                    {l s='{product_name_attribute} - Nazwa atrybutu' mod='x13googlemerchant'}<br /><br />
                                    {l s='Pozostawiając te pole puste zostanie ustawiona domyślna nazwa produktu' mod='x13googlemerchant'}
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="margin-top: 15px;">
                    <tbody>
                        <tr>
                            <td class="col-left"><label>{l s='Eksportuj' mod='x13googlemerchant'}</label></td>
                            <td style="padding-bottom:5px;">
                                <label class="t" for="custom_export_on"><img src="../img/admin/enabled.gif" alt="{l s='Yes'}" title="{l s='Yes'}" /></label>
                                <input type="radio" name="custom_export" id="custom_export_on" value="1" {if $custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />

                                <label class="t" for="custom_export_off"><img src="../img/admin/disabled.gif" alt="{l s='No'}" title="{l s='No'}" /></label>
                                <input type="radio" name="custom_export" id="custom_export_off" value="0" {if !$custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />

                                <p class="preference_description">{l s='Jeśli opcja jest nieaktywna, wysłane będą wszystkie produkty - jeśli chcesz wybrać konkretny produkt - zmień to w konfiguracji modułu' mod='x13googlemerchant'}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table style="margin-top: 15px;">
                    <tbody>
                        {for $i = 0 to 4}
                            <tr>
                                <td class="col-left"><label>{l s='Etykieta niestandardowa' mod='x13googlemerchant'} {$i+1}</label></td>
                                <td style="padding-bottom:5px;" class="translatable">
                                    {foreach from=$languages item=language}
                                        <div class="lang_{$language.id_lang}" style="{if $language.id_lang != $default_language}display: none;{/if} float: left;">
                                            <input type="text" id="custom_label_{$i}_{$language.id_lang}" name="custom_label[{$language.id_lang}][{$i}]" value="{if isset($custom_labels[$language.id_lang][$i])}{$custom_labels[$language.id_lang][$i]}{else}{/if}">
                                        </div>
                                    {/foreach}
                                </td>
                            </tr>
                        {/for}
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

{$displayX13GoogleMerchantAdminProductsExtra}

<script type="text/javascript">
    displayFlags(languages, id_language, allowEmployeeFormLang);
</script>
