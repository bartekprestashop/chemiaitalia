{extends file="helpers/list/list_content.tpl"}

{block name="td_content"}
    {if isset($params.type) && $params.type == 'editable' && isset($tr.id)}
        {foreach from=$languages item=language}
            <div class="translatable-field lang-{$language.id_lang} clearfix">
                <div class="tf tf-input">
                    {assign var='google_name_key' value="google_name_{$language.id_lang}"}
                    <input autocomplete="off" type="text" id="{$key}_{$tr.id}_{$language.id_lang}" name="{$key}_{$tr.id}_{$language.id_lang}" class="{$key}" data-lang="{$language.id_lang}" value="{if isset($tr.$google_name_key)}{$tr.$google_name_key|escape:'html':'UTF-8'}{else}{/if}">
                </div>
                <div class="tf tf-list">
                    <button type="button" class="{if !version_compare($smarty.const._PS_VERSION_, '1.6.0.0', '<')}btn btn-default dropdown-toggle{/if}" data-toggle="dropdown" tabindex="-1">
                        {$language.iso_code}
                        <span class="caret"></span>
                    </button>
                    {if version_compare($smarty.const._PS_VERSION_, '1.6.0.0', '<')}
                        {foreach from=$languages item=language}
                            <a href="javascript:hideOtherLanguage({$language.id_lang});">
                                <img class="language_current pointer" src="../img/l/{$language.id_lang}.jpg" alt="{$language.name}">
                            </a>
                        {/foreach}
                    {else}
                        <ul class="dropdown-menu">
                            {foreach from=$languages item=language}
                                <li>
                                    <a href="javascript:hideOtherLanguage({$language.id_lang});">{$language.name}</a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}

                </div>

            </div>
        {/foreach}
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
