<div class="panel clearfix" {if version_compare($smarty.const._PS_VERSION_, '1.7.0.0', '>')}style="padding: 10px;"{/if}>
    {if version_compare($smarty.const._PS_VERSION_, '1.7', '>=')}
    {else}
        <h3>{l s='Google merchant XML' mod='x13googlemerchant'}</h3>
    {/if}

    <div class="form-group clearfix">
        <label for="" class="control-label form-control-label col-lg-3">
            <span>{l s='Eksportuj' mod='x13allegro'}</span>
        </label>
        <div class="col-lg-5">
            {if version_compare($smarty.const._PS_VERSION_, '1.7', '>=')}
                <span class="ps-switch">
                    <input type="radio" name="custom_export" id="custom_export_off" class="ps-switch" value="0" {if !$custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />
                    {strip}<label for="custom_export_off">{l s='No'}</label>{/strip}

                    <input type="radio" name="custom_export" id="custom_export_on" class="ps-switch" value="1" {if $custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />
                    {strip}<label for="custom_export_on">{l s='Yes'}</label>{/strip}
                    <span class="slide-button"></span>
                </span>
            {else}
                <span class="switch prestashop-switch fixed-width-lg">
                    <input type="radio" name="custom_export" id="custom_export_on" value="1" {if $custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />
                    {strip}<label for="custom_export_on">{l s='Yes'}</label>{/strip}

                    <input type="radio" name="custom_export" id="custom_export_off" value="0" {if !$custom_export}checked="checked"{/if} {if !$is_custom_export}disabled="disabled"{/if} />
                    {strip}<label for="custom_export_off">{l s='No'}</label>{/strip}
                    <a class="slide-button btn"></a>
                </span>
            {/if}
            <div class="help-block form-text">{l s='Jeśli opcja jest nieaktywna, wysłane będą wszystkie produkty - jeśli chcesz wybrać konkretny produkt - zmień to w konfiguracji modułu' mod='x13googlemerchant'}</div>
        </div>
    </div>

    <div class="form-group clearfix">
        <label for="custom_title" class="control-label form-control-label col-lg-3">
            <span>{l s='Nazwa produktu' mod='x13googlemerchant'}</span>
        </label>

        <div class="col-lg-9">
            {foreach from=$languages item=language}
                <div class="translatable-field lang-{$language.id_lang} row clearfix" style="{if $language.id_lang != $default_language}display: none;{/if}">
                    <div class="col-lg-5">
                        <input type="text" class="form-control" id="custom_title_{$language.id_lang}" name="custom_title[{$language.id_lang}]" value="{if isset($custom_title[$language.id_lang])}{$custom_title[$language.id_lang]}{/if}">
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                            {$language.iso_code}
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=language}
                                <li>
                                    <a href="javascript:hideOtherLanguage({$language.id_lang});">{$language.name}</a>
                                </li>
                            {/foreach}
                        </ul>
                    </div>
                </div>
            {/foreach}
        </div>

        <div class="col-lg-9 col-lg-offset-3">
            <div class="help-block form-text">
                {l s='{product_name} - Nazwa produktu' mod='x13googlemerchant'}<br />
                {l s='{product_name_attribute} - Nazwa atrybutu' mod='x13googlemerchant'}<br /><br />
                {l s='Pozostawiając te pole puste zostanie ustawiona domyślna nazwa produktu' mod='x13googlemerchant'}
            </div>
        </div>
    </div>

    {for $i = 0 to 4}
        <div class="form-group clearfix">
            <label class="control-label form-control-label col-lg-3">{l s='Etykieta niestandardowa' mod='x13googlemerchant'} {$i+1}</label>

            <div class="col-lg-9">
                {foreach from=$languages item=language}
                    <div class="translatable-field lang-{$language.id_lang} row clearfix" style="{if $language.id_lang != $default_language}display: none;{/if}">
                        <div class="col-lg-8">
                            <input type="text" class="form-control" id="custom_label_{$i}_{$language.id_lang}" name="custom_label[{$language.id_lang}][{$i}]" value="{if isset($custom_labels[$language.id_lang][$i])}{$custom_labels[$language.id_lang][$i]}{else}{/if}">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" tabindex="-1">
                                {$language.iso_code}
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                {foreach from=$languages item=language}
                                    <li>
                                        <a href="javascript:hideOtherLanguage({$language.id_lang});">{$language.name}</a>
                                    </li>
                                {/foreach}
                            </ul>
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    {/for}

    {$displayX13GoogleMerchantAdminProductsExtra}

    <input type="hidden" name="x13googlemerchant_product_extra" value="1">

    {if version_compare($smarty.const._PS_VERSION_, '1.7.0.0', '<')}
        <div class="panel-footer">
            <a href="{$link->getAdminLink('AdminProducts')|escape:'html':'UTF-8'}" class="btn btn-default"><i class="process-icon-cancel"></i> {l s='Cancel'}</a>
            <button type="submit" name="submitAddproduct" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Save'}</button>
            <button type="submit" name="submitAddproductAndStay" class="btn btn-default pull-right"><i class="process-icon-loading"></i> {l s='Save and stay'}</button>
        </div>
    {/if}
</div>
