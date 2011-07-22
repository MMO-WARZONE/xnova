<br />
<div id="content">

<form action="game.php?page=galaxia&mode=change" method="post">
<center>
<table width="530">

<tr>
<td class="c" colspan="2">{cc_galaxy}</td>
</tr>

<tr>
<th colspan="2">
<a href="game.php?page=options">{cc_datos}</a> -
<a href="game.php?page=general">{cc_general}</a> -
<a href="game.php?page=galaxia"><font color="yellow">{cc_galaxy}</font></a></th>
</tr>

<tr>
<td class="b"><b><font color="orange">{op_spy_probes_number}</font></b><br>{og_sondas}</td>
<th><input name="spio_anz" maxlength="10" size="2" value="{opt_probe_data}" type="text" style="text-align:center;"></th>
</tr>



<tr>
<td class="b"><b><font color="orange">{op_spy_retorn}</font></b><br>{og_return}</td>
<th><input name="settings_fleetactions" maxlength="2" size="2" value="{opt_fleet_data}" type="text" style="text-align:center;"></th>
</tr>
</table>

<table width="530">
<tr>
        <td class="c" align=left>{op_shortcut}</td>
        <td class="c" align=left>{op_show}</td>
        <tr>
        <td class="b"><img src="{dpath}img/e.gif" alt="" align="absbottom" border="0"> {op_spy}</td>
        <th><input name="settings_esp"{user_settings_esp} type="checkbox" /></th>
    </tr><tr>
        <td class="b"><img src="{dpath}img/m.gif" alt="" align="absbottom" border="0"> {op_write_message}</td>
        <th><input name="settings_wri"{user_settings_wri} type="checkbox" /></th>
    </tr><tr>
        <td class="b"><img src="{dpath}img/b.gif" alt="" align="absbottom" border="0"> {op_add_to_buddy_list}</td>
        <th><input name="settings_bud"{user_settings_bud} type="checkbox" /></th>
    </tr><tr>
        <td class="b"><img src="{dpath}img/r.gif" alt="" align="absbottom" border="0"> {op_missile_attack}</td>
        <th><input name="settings_mis"{user_settings_mis} type="checkbox" /></th>
    </tr><tr>
        <td class="b"><img src="{dpath}img/s.gif" alt="" align="absbottom" border="0"> {op_send_report}</td>
        <th><input name="settings_rep"{user_settings_rep} type="checkbox" /></th>
    </tr>

<tr>
<td class="c" colspan="2" align="center"><input class="button188" value="{cc_guardar}" onClick="onSubmit();" type="submit"></td>
</tr>
</table>

</form>
</div>
