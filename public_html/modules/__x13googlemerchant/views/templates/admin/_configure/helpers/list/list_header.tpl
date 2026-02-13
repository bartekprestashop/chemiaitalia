{extends file="helpers/list/list_header.tpl"}

{block name="leadin"}
    {if isset($merchantToolbarButtons)}
        <div style="text-align: right; margin: 5px 0;">
            {foreach $merchantToolbarButtons as $merchantButtonKey => $merchantButton}
                <a href="{$merchantButton.href}" class="btn btn-default process-{$merchantButtonKey}">
                    <i class="{$merchantButton.class}"></i> {$merchantButton.desc}
                </a>
            {/foreach}
        </div>
    {/if}

    {$merchantDownloadXmlForm}
{/block}
