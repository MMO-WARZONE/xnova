<script language="JavaScript">
function f(target_url, win_name) {
var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
new_win.focus();
}
</script>
<br />
<form action="" method="post">
<input type="hidden" name="curr" value="{mlst_data_page}">
<input type="hidden" name="pmax" value="{mlst_data_pagemax}">
<input type="hidden" name="sele" value="{mlst_data_sele}">
    <table width="700" border="0" cellspacing="1" cellpadding="1">
        <tr>
            <td colspan="4" class="c">{ml_message_list}</td>
        </tr>        
        <tr>
            <td class="c"><div align="center"><input type="submit" name="prev" value="[ &lt;- ]" /></div></div></td>
            <td class="c"><div align="center">{ml_page}</div></td>
            <td class="c"><div align="center">
            <select name="page" onchange="submit();">
            {mlst_data_pages}
            </select></div>
            </td>
        	<td class="c"><div align="center"><input type="submit" name="next" value="[ -&gt; ]" /></div></td>
        </tr>
        <tr>
            <td class="c">&nbsp;</td>
            <td class="c"><div align="center">{ml_type}</div></td>
            <td class="c"><div align="center">
            <select name="type" onchange="submit();">
            {mlst_data_types}
            </select></div>
            </td>
            <td class="c">&nbsp;</td>
        </tr>
        <tr>
            <td class="c"><div align="center"><input type="submit" name="delsel" value="{ml_dlte_selection}" /></div></td>
            <td class="c"><div align="center">{ml_dlte_since}</div></td>
            <td class="c"><div align="center"><input type="text"   name="selday" value="dd" size="3" /> <input type="text" name="selmonth"  value="mm" size="3" /> <input type="text" value="yyyy" name="selyear" size="6" /></div></td>
            <td class="c"><div align="center"><input type="submit" name="deldat" value="{ml_dlte_since_button}" /></div></td>
        </tr>
        <tr>
            <th colspan="4">
                <table width="700" border="0" cellspacing="1" cellpadding="1">
                    <tr align="center" valign="middle">
                        <th class="c">{ml_id}</th>
                        <th class="c">{ml_type}</th>
                        <th class="c">{ml_date}</th>
                        <th class="c">{ml_from}</th>
                        <th class="c">{ml_to}</th>
                        <th class="c" width="350">{ml_content}</th>
                    </tr>
                    {mlst_data_rows}
                </table>
        	</th>
        </tr>
    </table>
</form>