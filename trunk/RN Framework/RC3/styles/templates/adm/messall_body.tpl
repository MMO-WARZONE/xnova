<script src="scripts/cntchar.js" type="text/javascript"></script>
<br />
<form action="?mode=change" method="post">
    <table width="519">
        <tbody>
            <tr>
                <td class="c" colspan="2">{ma_send_global_message}</td>
            </tr>
            <tr>
                <th>{ma_subject}</th>
                <th><input name="temat" maxlength="100" size="20" value="{ma_none}" type="text"></th>
            </tr>
            <tr>
                <th>{ma_message} (<span id="cntChars">0</span> / 5000 {ma_characters})</th>
                <th><textarea name="tresc" cols="40" rows="10" size="100">{ma_no_text}</textarea></th>
            </tr>
            <tr>
                <th colspan="2"><input value="{ma_send}" type="submit"></th>
            </tr>
        </tbody>
    </table>
</form>