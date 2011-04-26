<form action="" method="post">
<input type="hidden" name="currid" value="{id}">
<table width="750">
<tr>
	<td class="c" colspan="9">Mond {name} bearbeiten</td>
</tr>
<tr>
	<th>ID</th>
	<th>Spieler-ID</th>
	<th>Mondname</th>
	<th>Mondname</th>
	<th>Felder</th>
	<th>davon bebaut</th>
	<th>Galaxie</th>
	<th>System</th>
	<th>Position</th>
</tr>
<tr style="text-align:center;">
	<td class=b>{id}</td>
	<td class=b>{id_owner}</td>
	<td class=b>{name}</td>
	<td class=b><input type="text" name="mondname" size="15" value="{name}"></td>
	<td class=b><input type="text" name="felder" size="4" maxlength="4" value="{field_max}"></td>
	<td class=b>{field_current}</td>
	<td class=b>{galaxy}</td>
	<td class=b>{system}</td>
	<td class=b>{planet}</td>
</tr>
<tr>
	<th colspan="9"><input type="submit" name="submit" value="&Auml;nderungen speichern"></th>
</tr>
</table>
<table width="450" style="color:#FFFFFF">
<tr>
	<td class="c" colspan="3">Rohstoffe bearbeiten</td>
</tr>
<tr>
	<th>Aluminium</th>
 	<th>Silicium</th>
 	<th>Deuterium</th>
</tr>
<tr>
 	<th><input type="text" name="metal" size="10" value="{metal}"></th>
 	<th><input type="text" name="crystal" size="10" value="{crystal}"></th>
 	<th><input type="text" name="deuterium" size="10" value="{deuterium}"></th>
</tr>
<tr>
	<th colspan="3"><input type="submit" name="submit" value="&Auml;nderungen speichern"></th>
</tr>
</table>
<table width="750">
<tr>
	<td class="c" colspan="14">Schiffe bearbeiten</td>
</tr>
<tr>
	<th>Kleiner Transporter</th>
	<th>Großer Transporter</th>
	<th>Leichter J&auml;ger</th>
	<th>Schwerer J&auml;ger</th>
	<th>Kreuzer</th>
	<th>Schlachtschiff</th>
	<th>Kolonieschiff</th>
	<th>Recycler</th>
	<th>Spionagesonde</th>
	<th>Bomber</th>
	<th>Solarsattelit</th>
	<th>Zerst&ouml;rer</th>
	<th>Todesstern</th>
	<th>Schlachtkreuzer</th>
</tr>
<tr>
	<th><input name="small_ship_cargo" type="text" size="5" value="{small_ship_cargo}" /></th>
	<th><input name="big_ship_cargo" type="text" size="5" value="{big_ship_cargo}" /></th>
	<th><input name="light_hunter" type="text" size="5" value="{light_hunter}" /></th>
	<th><input name="heavy_hunter" type="text" size="5" value="{heavy_hunter}" /></th>
	<th><input name="crusher" type="text" size="5" value="{crusher}" /></th>
	<th><input name="battle_ship" type="text" size="5" value="{battle_ship}" /></th>
	<th><input name="colonizer" type="text" size="5" value="{colonizer}" /></th>
	<th><input name="recycler" type="text" size="5" value="{recycler}" /></th>
	<th><input name="spy_sonde" type="text" size="5" value="{spy_sonde}" /></th>
	<th><input name="bomber_ship" type="text" size="5" value="{bomber_ship}" /></th>
	<th><input name="solar_satelit" type="text" size="5" value="{solar_satelit}" /></th>
	<th><input name="destructor" type="text" size="5" value="{destructor}" /></th>
	<th><input name="dearth_star" type="text" size="5" value="{dearth_star}" /></th>
	<th><input name="battleship" type="text" size="5" value="{battleship}" /></th>
</tr>
<tr>
	<th colspan="14"><input type="Submit" name="submit" value="&Auml;nderungen speichern" /></th>
</tr>
</table>
<table width="750">
<tr>
	<td class="c" colspan="10">Verteidigung bearbeiten</td>
</tr>
<tr>
	<th>Raketenwerfer</th>
	<th>Leichtes Lasergesch&uuml;tz</th>
	<th>Schweres Lasergesch&uuml;tz</th>
	<th>Gausskanone</th>
	<th>Ionengesch&uuml;tz</th>
	<th>Plasmawerfer</th>
	<th>Kleine Schildkuppel</th>
	<th>Große Schildkuppel</th>
</tr>
<tr>
	<th><input name="misil_launcher" size="5" type="text" value="{misil_launcher}" /></th>
	<th><input name="small_laser" size="5" type="text" value="{small_laser}" /></th>
	<th><input name="big_laser" size="5" type="text" value="{big_laser}" /></th>
	<th><input name="gauss_canyon" size="5" type="text" value="{gauss_canyon}" /></th>
	<th><input name="ionic_canyon" size="5" type="text" value="{ionic_canyon}" /></th>
	<th><input name="buster_canyon" size="5" type="text" value="{buster_canyon}" /></th>
	<th><input name="small_protection_shield" size="5" type="text" value="{small_protection_shield}" /></th>
	<th><input name="big_protection_shield" size="5" type="text" value="{big_protection_shield}" /></th>
</tr>
<tr>
	<th colspan="10"><input type="Submit" name="submit" value="&Auml;nderungen speichern" /></th>
</tr>
</table>
<table width="350">
<tr>
	<td class="c" colspan="3">Geb&auml;ude bearbeiten</td>
</tr>
<tr>
	<th>1</td>
	<th>Roboterfabrik</td>
	<th><input name="robot_factory" type="text" value="{robot_factory}" /></th>
</tr>
<tr>
	<th>2</td>
	<th>Schiffswerft</td>
	<th><input name="hangar" type="text" value="{hangar}" /></th>
</tr>
<tr>
	<th>3</td>
	<th>Aluminiumspeicher</td>
	<th><input name="metal_store" type="text" value="{metal_store}" /></th>
</tr>
<tr>
	<th>4</td>
	<th>Siliciumspeicher</td>
	<th><input name="crystal_store" type="text" value="{crystal_store}" /></th>
</tr>
<tr>
	<th>5</td>
	<th>Deuteriumtank</td>
	<th><input name="deuterium_store" type="text" value="{deuterium_store}" /></th>
</tr>
<tr>
	<th>6</td>
	<th>Allianzdepot</td>
	<th><input name="ally_deposit" type="text" value="{ally_deposit}" /></th>
</tr>
<tr>
	<th>7</td>
	<th>Mondbasis</td>
	<th><input name="mondbasis" type="text" value="{mondbasis}" /></th>
</tr>
<tr>
	<th>8</td>
	<th>Sensorphalanx</td>
	<th><input name="phalanx" type="text" value="{phalanx}" /></th>
</tr>
<tr>
	<th>9</td>
	<th>Sprungtor</td>
	<th><input name="sprungtor" type="text" value="{sprungtor}" /></th>
</tr>
<tr>
	<th colspan="3"><input type="Submit" name="submit" value="&Auml;nderungen speichern" /></th>
</tr>
</table>
</form>
<br>