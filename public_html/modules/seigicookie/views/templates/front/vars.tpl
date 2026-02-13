<script type="text/javascript">
    {foreach from=$vars key=k item=def}
    {if is_bool($def)}
    var {$k} = {$def|var_export:true};
    {elseif is_int($def)}
    var {$k} = {$def|intval};
    {elseif is_float($def)}
    var {$k} = {$def|floatval|replace:',':'.'};
    {elseif is_string($def)}
    var {$k} = '{$def|strval}';
    {elseif is_array($def) || is_object($def)}
    var {$k} = {$def|json_encode};
    {elseif is_null($def)}
    var {$k} = null;
    {else}
    var {$k} = '{$def|@addcslashes:'\''}';
    {/if}
    {/foreach}
</script>
