<form action="" method="post">
<input type="hidden" name="currid" value="{id}">




<table width="700" style="color:#FFFFFF">
<tr>
	<td class="c" colspan="9"><font color="lime">{adm_pllist_planet} </font><font color="orange">{name}</font></td>

</tr>
<tr>
	<th>ID</th>	
	<th>Cordenadas</th>
	<th>ID-User</th>
	<th>Nombre del planeta</th>
	<th>Nuevo nombre</th>
	<th>Campos</th>
	<th>Diametro</th>
</tr>
<tr style="text-align:center;">
	<td class=b>{id}</td>
	<td class=b><b>[{galaxy}:{system}:{planet}]</b></td>
	<td class=b>{id_owner}</td>
	<td class=b>{name}</td>
	<td class=b><input type="text" name="planetname" size="15" value="{name}"></td>
	<td class=b>{field_current} / <input type="text" name="felder" size="1" maxlength="2" value="{field_max}"></td>
	<td class=b>{diameter}</td>
</tr>
</table><br>
<tr>

<div style="margin: auto; width:700">
<div style="float: left; width: 400;">

<table width="100%">
<tr>
	<td class="c" colspan="4"><font color="lime">Edificios del planeta</font></td>
</tr>
<tr>
	<th>Fabrica de robots</td>
	<th><input style="text-align:right;" name="robot_factory" type="text" size="3" value="{robot_factory}" /></th>
	<th>Hangar</td>
	<th><input style="text-align:right;" name="hangar" type="text" size="3" value="{hangar}" /></th>
</tr>
<tr>
	<th>Almacen de metal</td>
	<th><input style="text-align:right;" name="metal_store" type="text" size="3" value="{metal_store}" /></th>
	<th>Almacen de cristal</td>
	<th><input style="text-align:right;" name="crystal_store" type="text" size="3" value="{crystal_store}" /></th>
</tr>
<tr>
	<th>Contenedor de deuterio</td>
	<th><input style="text-align:right;" name="deuterium_store" type="text" size="3" value="{deuterium_store}" /></th>
	<th>Base lunar</td>
	<th><input style="text-align:right;" name="mondbasis" type="text" size="3" value="{mondbasis}" /></th>
</tr>
<tr>
	<th>Phalax</td>
	<th><input style="text-align:right;" name="phalanx" type="text" size="3" value="{phalanx}" /></th>
	<th>Salto cuantico</td>
	<th><input style="text-align:right;" name="sprungtor" type="text" size="3" value="{sprungtor}" /></th>
</tr>

</table>

</div>
<div style="float: right; width: 288;">


<table width="100%">
<tr>
	<td class="c" colspan="2"><font color="lime">Recursos en el planeta</font></td>
</tr>
<tr>
	<th>Metal</th>
 	<th><input style="text-align:right; font-size: 8pt;" type="text" name="metal" size="30" value="{metal}"></th>
</tr>
<tr>
 	<th>Cristal</th>
 	<th><input style="text-align:right; font-size: 8pt;" type="text" name="crystal" size="30" value="{crystal}"></th>
</tr>
<tr>
 	<th>Deuterio</th>
 	<th><input style="text-align:right; font-size: 8pt;" type="text" name="deuterium" size="30" value="{deuterium}"></th>
</tr>
</table>

</div>
<div style="clear: both;"></div>
</div>

<br>

<table width="700" style="color:#FFFFFF">
<tr>
	<td class="c" colspan="6"><font color="lime">Flotas en el planeta</font></td>

</tr>
<tr>
	<th width="183">Nave peque&ntilde;a de carga</th>
	<th width="50"><input style="text-align:right;" name="small_ship_cargo" type="text" size="10" value="{small_ship_cargo}" /></th>
	<th width="183">Nave grande de carga</th>
	<th width="50"><input style="text-align:right;" name="big_ship_cargo" type="text" size="10" value="{big_ship_cargo}" /></th>
	<th width="183">Cazador lijero</th>
	<th width="50"><input style="text-align:right;" name="light_hunter" type="text" size="10" value="{light_hunter}" /></th>
</tr>
<tr>
	<th>Cazador pesado</th>
	<th><input style="text-align:right;" name="heavy_hunter" type="text" size="10" value="{heavy_hunter}" /></th>
	<th>Crucero</th>
	<th><input style="text-align:right;" name="crusher" type="text" size="10" value="{crusher}" /></th>
	<th>Nave de batalla</th>
	<th><input style="text-align:right;" name="battle_ship" type="text" size="10" value="{battle_ship}" /></th>
</tr>
<tr>
	<th>Colonizador</th>
	<th><input style="text-align:right;" name="colonizer" type="text" size="10" value="{colonizer}" /></th>
	<th>Reciclador</th>
	<th><input style="text-align:right;" name="recycler" type="text" size="10" value="{recycler}" /></th>
	<th>Sonda de espionaje</th>
	<th><input style="text-align:right;" name="spy_sonde" type="text" size="10" value="{spy_sonde}" /></th>
</tr>
<tr>
	<th>Bombardero</th>
	<th><input style="text-align:right;" name="bomber_ship" type="text" size="10" value="{bomber_ship}" /></th>
	<th>Satelite solar</th>
	<th><input style="text-align:right;" name="solar_satelit" type="text" size="10" value="{solar_satelit}" /></th>
	<th>Destructor</th>
	<th><input style="text-align:right;" name="destructor" type="text" size="10" value="{destructor}" /></th>
</tr>
<tr>
	<th>Estrella de la muerte</th>
	<th><input style="text-align:right;" name="dearth_star" type="text" size="10" value="{dearth_star}" /></th>
	<th>Acorazado</th>
	<th><input style="text-align:right;" name="battleship" type="text" size="10" value="{battleship}" /></th>
	<th></th>
	<th></th>
</tr>
</table>

<br>

<table width="700" style="color:#FFFFFF;">
<tr>

	<td class="c" colspan="6"><font color="lime">Defensas en el planeta</font></td>


</tr>
<tr>
	<th width="183">Lanzamisiles</th>
	<th width="50"><input style="text-align:right;" name="misil_launcher" size="10" type="text" value="{misil_launcher}" /></th>
	<th width="183">Laser peque&ntilde;os</th>
	<th width="50"><input style="text-align:right;" name="small_laser" size="10" type="text" value="{small_laser}" /></th>
	<th width="183">Laser grandes </th>
	<th width="50"><input style="text-align:right;" name="big_laser" size="10" type="text" value="{big_laser}" /></th>
</tr>
<tr>
	<th>Ca&ntilde;on gaus</th>
	<th><input style="text-align:right;" name="gauss_canyon" size="10" type="text" value="{gauss_canyon}" /></th>
	<th>Ca&ntilde;on ionico</th>
	<th><input style="text-align:right;" name="ionic_canyon" size="10" type="text" value="{ionic_canyon}" /></th>
	<th>Ca&ntilde;on de plasma</th>
	<th><input style="text-align:right;" name="buster_canyon" size="10" type="text" value="{buster_canyon}" /></th>
</tr>
<tr>
	<th>Cupula peque&ntilde;a</th>
	<th><input style="text-align:right;" name="small_protection_shield" size="10" type="text" value="{small_protection_shield}" /></th>
	<th>Cupula grande</th>
	<th><input style="text-align:right;" name="big_protection_shield" size="10" type="text" value="{big_protection_shield}" /></th>
	<th colspan="2"><input type="Submit" name="submit" value="Guardar cambios" /></th>
</tr>
</table>

</form>
<br>
