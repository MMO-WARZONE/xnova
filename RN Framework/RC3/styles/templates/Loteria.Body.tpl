<!--
/**
# 	ShowLoteriaPage.php, Loteria-C.php
#	Creado por Neko para XG Proyect - xtreme-gamez
#	Algunas ideas sacadas de la Loteria de SainT.
**/
-->

<style>
.pp{ font-size:12px; font-weight:bold; }
.precio{ color: #00FF00; }
.premio{ color: #00FF00; }
.info{ font-size:11px; font-weight:bold; }
.form{ color: #CCCCCC; }
.estado{ background-color:#000000; text-align:center; cursor: pointer; text-decoration:{blink}; color: {color}; }
.estado2{ font-size:12px; font: bold; font-variant:small-caps; }
.error{ background-color:#000000; font-variant:small-caps; }
.error2{ background-color:#000000; color:#FFFFFF; text-align:left; }
.lotee{ background-color:#000000; text-align:center; cursor: pointer; color: #CCCCCC; font-variant:small-caps;}
</style>
<div id="content">
<br />
<table border="0" cellpadding="3" cellspacing="2">
<tr><th class="error2"><center><span class="estado2">Willkommen zur LottoriE</span></center></th></tr>
<tr><th class="estado">{msj2}</th></tr>
</table>

<br />
<table width="700" border="0" cellpadding="5" cellspacing="10">
<tr><th class="lotee">{loteria_tiempo}</th></tr>
</th></tr>
</table>
<table border="0" cellpadding="5" cellspacing="0" width="700">
<tr><td class="c" colspan="3"><center>Intergalakitsche Lotterie</center></td></tr>
<tr>
<td width="20%" align="center"></td>
<td width="40%" align="center" class="pp">Kosten pro Schein</td>
<td width="40%" align="center" class="pp">Gewinn</td>
</tr>
<tr><th>Metal</th><th class="precio">{metal_c}</th><th class="premio">{metal_p}</th></tr>
<tr><th>Cristal</th><th class="precio">{cristal_c}</th><th class="premio">{cristal_p}</th></tr>
<tr><th>Deuterio</th><th class="precio">{deute_c}</th><th class="premio">{deute_p}</th></tr>
<tr><th>Dunkler M&uuml;ll</th><th class="precio">{materia_c}</th><th class="premio">{materia_p}</th></tr>
</table>
<table border="0" cellpadding="5" cellspacing="0" width="700">
<th><font color="#F7BE81">Der Gewinn wird uaf den Hauptplaneten gutgeschrieben.</font></th>
</table>

<br />
<table border="0" cellpadding="5" cellspacing="0" width="700">
<tr><td class="c" colspan="3"><center>Information</center></td></tr>
<tr>
<td width="20%" align="center" class="info">Tickets ingesamt</td>
<td width="40%" align="center" class="info">Max. Tickets pro Person</td>
<td width="40%" align="center" class="info">Cant. de boletos tuyos</td>
</tr>
<tr><th>{boletos}</th><th>{boletos_max}</th><th>{boletos_p_u}</th></tr>
</table>
{info}

<br />
<table border="0" cellpadding="0" cellspacing="0" width="340">
<tr><td class="c"><center>Kaufe Tickets</center></td></tr>
<tr>
   <th>
   	<form method="POST" action="game.php?page=loteria&bole=si">
	<input type="hidden" name="bole" value="si" />
   	<select name="tickets" {disabled} {form}>
   	<option value="1">1</option>
   	<option value="2">2</option>
   	<option value="3">3</option>
   	<option value="4">4</option>
   	<option value="5">5</option>
   	<option value="6">6</option>
   	<option value="7">7</option>
   	<option value="8">8</option>
   	<option value="9">9</option>
   	<option value="10">10</option>
	<option value="15">15</option>
	<option value="20">20</option>
   	</select>
   	<input type="submit" value="{value}" {disabled} {form}>
	</form>
   </th>
</tr>
</table>
<br />
<table border="0" cellpadding="5" cellspacing="0" width="340">
<tr><td class="c"><center>Bereits Teilgenommende User:</center></td></tr>
{participantes}
</table>


</div>

