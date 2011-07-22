<style type="text/css">
.oculto {display:none}
</style>
<script type="text/javascript">
var visto = null;
function ver(num) {
  obj = document.getElementById(num);
  obj.style.display = (obj==visto) ? 'none' : 'block';
  if (visto != null)
    visto.style.display = 'none';
  visto = (obj==visto) ? null : obj;
}


function ver1(num)
{
var t=setTimeout("ver("+num+")",1000)
}

function ver2(num)
{
var id = setInterval("ver("+num+")",1000);
setTimeout("clearInterval("+id+")",15000);
}

</script>

<br />
<div id="content">

<form action="game.php?page=general&mode=change" method="post">
<center>
<table width="530">

<tr>
<td class="c" colspan="2">{cc_general}</td>
</tr>

<tr>
<th colspan="2">
<a href="game.php?page=options">{cc_datos}</a> -
<a href="game.php?page=general"><font color="yellow">{cc_general}</font></a> -
<a href="game.php?page=galaxia">{cc_galaxy}</a></th>
</tr>

<tr>
<td colspan="2">
<table width="100%"><b><font color=orange>{op_skin}</font></b><br>{ag_skin}<br><br><center><input name="dpath" maxlength="80" style="width:90%" type="text" value="{opt_dpath_data}"><br>
<p onclick="ver(0)" style="z-index:3;">Lista de Skins propios (mostrar/ocultar)</p>
<div id="0" class="oculto" style="z-index:3;">
=> <font color="lime">styles/skins/evoloution/</font> (skin por defecto)</font><br />
=> <font color="lime">styles/skins/TU_SKIN/</font><br />
=> <font color="lime">styles/skins/TU_SKIN/</font></font><br /><br />
<i>Copia la dirección del skin en la casilla superior y pulsa en guardar.</i>
</div>
</tr>
 <tr>
        <select name="dpath">{lst_skins}</select>
 </tr>
</table>

<tr>
<td class="b"><b><font color=orange>{op_deactivate_ipcheck}</font></b><br>{ag_ip_check}</th>
<th width="165px"><input name="noipcheck"{opt_noipc_data} type="checkbox" /></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_sort_planets_by}</font></b><br>{ag_planets}</td>
<th><select name="settings_sort">
            {opt_lst_ord_data}
            </select></th>
</tr>

         

<tr>
<td class="b"><b><font color=orange>{op_sort_kind}</font></b><br>{ag_ordenacion}</td>
<th><select name="settings_order">
            {opt_lst_cla_data}
            </select></th>
</tr>
 </tr>
    <!-- //***** LISTA DE IDIOMAS *****// -->
    <tr>
        <th>Idioma:</th>
        <th>
            <select name="idioma_usuario">
            {lst_idomas}
            </select>
        </th>
    </tr>
    <!-- //***** LISTA DE IDIOMAS *****// -->
    <tr>
	<th>Avatar<br /></th>
	<th><input name="avatar" maxlength="80" size="40" value="{opt_avata_data}" type="text"></th>
</tr>
</table>

<table width="530">
<tr>
<td class="c" align=center colspan=3>{cc_estado}</td>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_vacation}</font></b><br>{ag_vacation}</td>
<th><input name="urlaubs_modus"{opt_modev_data} type="checkbox" /></th>
</tr>

<tr>
<td class="b"><b><font color=orange>{op_dlte_account}</font></b><br>{ag_delete}</td>
<th><input name="db_deaktjava"{db_deaktjava} type="checkbox" /></th>
</tr>
</table>

<table width="530">
<tr>
<td class="c" colspan="2" align="center"><input class="button188" value="{cc_guardar}" onClick="onSubmit();" type="submit"></td>
</tr>
</table>

</form>
</div>
