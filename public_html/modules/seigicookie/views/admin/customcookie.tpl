{function name=createElementLine index=0 el=''}
    <tr>
        <td style='padding-top: 15px;'>
            <input type='text' name='customcookie[col1][]' {if isset($data)}value='{$data.col1|escape}'{/if} placeholder='{l s='Cookie name' mod='seigicookie'}'>
            <br>
            <input type='text' name='customcookie[col2][]' {if isset($data)}value='{$data.col2|escape}'{/if} placeholder='{l s='Cookie provider' mod='seigicookie'}'></td>
        <td style='padding-top: 15px;'>
            <input type='text' name='customcookie[col3][]' {if isset($data)}value='{$data.col3|escape}'{/if} placeholder='{l s='Cookie expiry' mod='seigicookie'}'>
            <br>
            <input type='text' name='customcookie[col4][]' {if isset($data)}value='{$data.col4|escape}'{/if} placeholder='{l s='Cookie explanation' mod='seigicookie'}'></td>
        <td>
            <select name='customcookie[category][]'>
                <option {if isset($data) && $data.category == 'necessary'}selected='selected'{/if} value='necessary'>Wymagane</option>
                <option {if isset($data) && $data.category == 'analytics'}selected='selected'{/if} value='analytics'>Analityczne</option>
                <option {if isset($data) && $data.category == 'targeting'}selected='selected'{/if} value='targeting'>Targetowanie / Personalizacja reklam</option>
                <option {if isset($data) && $data.category == 'person_site'}selected='selected'{/if} value='person_site'>Personalizacja strony</option>
                <option {if isset($data) && $data.category == 'security'}selected='selected'{/if} value='security'>Bezpieczeństwo</option>
            </select>
        </td>
        <td>
            <select name='customcookie[regex][]'>
                <option {if !isset($data.regex) || 0 === intval($data.regex)}selected='selected'{/if} value='0'>Nie</option>
                <option {if isset($data.regex) && 1 === intval($data.regex)}selected='selected'{/if} value='1'>Tak</option>
            </select>
        </td>
        <td><button style='margin-top: -15px' class='s-button removeCustomCookie'>&#128465; {l s='Remove' mod='seigicookie'}</button></td>
    </tr>
{/function}
    <form action='' method='post'>
    <table id='seigi_cookie_table' class='s-table' style='width: 100%'>
        <tr>
            <th>{l s='Cookie name' mod='seigicookie'} /<br> {l s='Cookie domain' mod='seigicookie'}</th>
            <th>{l s='Cookie expiry' mod='seigicookie'} /<br> {l s='Cookie explanation' mod='seigicookie'}</th>
            <th>
                {l s='Cookie group' mod='seigicookie'}
            </th>
            <th>
                {l s='Regex' mod='seigicookie'}
            </th>
            <th>&nbsp;</th>
        </tr>

        {foreach $customCookies as $customCookie}
            {createElementLine data=$customCookie}
        {foreachelse}
            {createElementLine}
        {/foreach}
    </table>
    <button type='submit' name='submitCustomCookies' class='s-button'>{l s='Save' mod='seigicookie'}</button>
    <button id='seigi_cookie_add' class='s-button'>{l s='Add new row' mod='seigicookie'}</button>
</form>

<h3>{l s='Legend'}</h3>
<ul>
    <li><b>{l s='Cookie name' mod='seigicookie'}</b> {l s='technical name of cookie to unset' mod='seigicookie'}</li>
    <li><b>{l s='Cookie domain' mod='seigicookie'}</b> {l s='Leave custom domain empty or set its value to [domain] to use current site domain' mod='seigicookie'}</li>
    <li><b>{l s='Cookie expiry' mod='seigicookie'}</b> {l s='How many days it takes for cookie to expire. I\'s information for your clients. We write it like 30d for 30 days etc.' mod='seigicookie'}</li>
    <li><b>{l s='Cookie explanation' mod='seigicookie'}</b> {l s='Here you can explain what this cookie is excatly used for to your customer' mod='seigicookie'}</li>
    <li><b>{l s='Regex' mod='seigicookie'}</b> {l s='You may want to use regex for your cookie name. This module supports it, but you must know what you\'re doing.' mod='seigicookie'}</li>
</ul>
<script>

    $('#seigi_cookie_add').click(function(){
        $('#seigi_cookie_table').append(addNewRow());
        return false;
    });
    {capture name=createElementLine}
    {createElementLine}
    {/capture}
    function addNewRow(){
        return '{$smarty.capture.createElementLine|escape:'javascript'}';
    }
    $('#seigi_cookie_table').on('click', '.removeCustomCookie', function() {
        $(this).parent().parent().remove();
        return false;
    });
</script>
