<div id="header_top">
<center>
<script type="text/javascript" language="javascript">

var ress = new Array({metal_js}, {crystal_js}, {deuterium_js}); //aktuell vorhandene Ress
var max = new Array({metal_max_js}, {crystal_max_js}, {deuterium_max_js}); //Max ins Lager passende Ress
var production = new Array({metal_per_hour}, {crystal_per_hour}, {deuterium_per_hour}); //Ress Pro Sekunde
var stopped = 0;
var speed = 1;

</script>
<script type="text/javascript" language="javascript" src="scripts/ressourcen.js"></script>
<form action="" name="ress" id="ress" style="display: inline;">
<input id="metall" value="0" type="hidden">
<input id="kristall" value="0" type="hidden">
<input id="deuterium" value="0" type="hidden">
<input id="bmetall" value="0" type="hidden">
<input id="bkristall" value="0" type="hidden">
<input id="bdeuterium" value="0" type="hidden">
</form>
<table class="header">
<tbody>
<tr class="header">
	<td class="header">
		<table width="722" border="0" cellpadding="0" cellspacing="0" class="header" id="resources" style="width: 722px;">
		<tbody>
		<tr class="header">
		    <td class="header" align="center" width="150"><select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">{planetlist}</select></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/metall.gif" border="0" height="22" width="42" alt="metall"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/kristall.gif" border="0" height="22" width="42" alt="kristall"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/deuterium.gif" border="0" height="22" width="42" alt="deuterium"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/energie.gif" border="0" height="22" width="42" alt="energie"></td>
			<td class="header" align="center" width="150"><img src="{dpath}images/message.gif" border="0" height="22" width="42" alt="message"></td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="150"><b><font color="#ffffff"></font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Metal}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Crystal}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Deuterium}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Energy}</font></b></td>
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Message}</font></b></td>
		</tr>
		<tr class="header">
		    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Ressverf}</font></b></td>
			<td class="header" align="center" width="150"><div id="roh">{metal}</div></td>
			<td class="header" align="center" width="150"><div id="met">{crystal}</div></td>
			<td class="header" align="center" width="150"><div id="kry">{deuterium}</div></td>
			<td class="header" align="center" width="150">{energy_total}</td>
			<td class="header" align="center" width="150">{message}</td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="150"><b><font color="#FFFF00">{Store_max}</font></b></td>
			<td class="header" align="center" width="150">{metal_max}</td>
			<td class="header" align="center" width="150">{crystal_max}</td>
			<td class="header" align="center" width="150">{deuterium_max}</td>
			<td class="header" align="center" width="150"><font color="#00ff00">{energy_max}</font></td>
			<td class="header" align="center" width="150"></td>
		</tr>
		<tr class="header">
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150">&nbsp;</td>
			<td class="header" align="center" width="150"></td>
		</tr>
		</table>
	</td>
</tr>
</tbody>
</table>
</center>
</div>