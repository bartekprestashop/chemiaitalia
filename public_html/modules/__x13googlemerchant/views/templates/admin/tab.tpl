{if version_compare($smarty.const._PS_VERSION_, '1.6.0.0', '<')}
    {include file="./tab_15.tpl"}
{else}
    {include file="./tab_16.tpl"}
{/if}
