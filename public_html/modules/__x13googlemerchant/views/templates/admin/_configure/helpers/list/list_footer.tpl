{extends file="helpers/list/list_footer.tpl"}

{block name="after"}
    <script>
        var default_language = '{$default_language}';
        hideOtherLanguage(default_language);
    </script>
{/block}
