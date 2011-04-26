<!--
/**
# 	ShowLoteriaPage.php, Loteria-C.php
#	Creado por Neko para XG Proyect - xtreme-gamez
#	Algunas ideas sacadas de la Loteria de SainT.
**/
-->

<style>
td {
	color: #000000;
	margin: 3px;
	padding: 3px;
	font-size: 12px;
	font-weight: bold;
	border-bottom-width: thin;
	border-bottom-style: solid;
	border-bottom-color: #000099;
}
</style>

<br><br>
<h2>Configurar loteria</h2>
<form action="Loteria-C.php" method="POST">
<table width="550" class="tabla">
   <tr>
    <td>Metallpreis pro Ticket</td>
    <td align="left" width="50" style="color:red"><input name="metal_precio" type="text" value="{metal_precio}"/></td>
  </tr>
    <tr>
    <td>Kristallpreis pro Ticket</td>
    <td align="left" width="50" style="color:red"><input name="cristal_precio" type="text" value="{cristal_precio}"/></td>
  </tr>
    <tr>
    <td>Deuteriumpreis pro Ticket</td>
    <td align="left" width="50" style="color:red"><input name="deute_precio" type="text" value="{deute_precio}"/></td>
  </tr>
  <tr>
    <td>Dunkle Materie Preis pro Ticket</td>
    <td align="left" width="50" style="color:red"><input name="materia_precio" type="text" value="{materia_precio}"/></td>
  </tr>     
    <tr>
    <td>Gewinn: Metall</td>
    <td align="left" width="50" style="color:red"><input name="metal_premio" type="text" value="{metal_premio}"/></td>
  </tr>
	<tr>
    <td>Gewinn: Kristall</td>
    <td align="left" width="50" style="color:red"><input name="cristal_premio" type="text" value="{cristal_premio}"/></td>
  </tr>
    <tr>
    <td>Gewinn: Deuterium</td>
    <td align="left" width="50" style="color:red"><input name="deute_premio" type="text" value="{deute_premio}"/></td>
  </tr>
    <tr>
    <td>Gewinn: Dunkle Materie</td>
    <td align="left" width="50" style="color:red"><input name="materia_premio" type="text" value="{materia_premio}"/></td>
  </tr>
  <tr>
    <td>Max. Anzahl der Lose</td>
    <td align="left" width="50" style="color:red"><input name="boletos_max" type="text" value="{boletos_max}"/></td>
  </tr>
    <tr>
    <td>Lose por Person</td>
    <td align="left" width="50" style="color:red"><input name="boletos_p_u" type="text" value="{boletos_p_u}"/></td>
  </tr>
  <tr>
    <td>Wartezeit bis nur n&auml;chsten Lotterie</td>
    <td align="left" width="50" style="color:red"><input name="tiempo" type="text" value="{tiempo}"/></td>
  </tr>
  <tr>
    <td>Spieler auschlieﬂen(Name oder ID)</td>
    <td align="left" width="50" style="color:red"><input name="suspender" type="text" /></td>
  </tr>
  <tr>
    <td>Spielerspeere aufheben(Name oder ID)</td>
    <td align="left" width="50" style="color:red"><input name="sacar_sus" type="text" /></td>
  </tr>
  <tr>
    <td>Lotterie deaktivieren</td>
    <td align="left" width="50" style="color:red"><center><input name="des-act" type="checkbox" {estado} /></center></td>
  </tr>
  <tr>
    <td>Aktuelle Lotterie leeren</td>
    <td align="left" width="50" style="color:red"><center><input name="reiniciar" type="checkbox" /></center></td>
  </tr>
  <tr>
    <td>Wartezeit aufheben</td>
    <td align="left" width="50" style="color:red"><center><input name="reiniciar_tiempo" type="checkbox" /></center></td>
  </tr>
    <tr>
    <td colspan="2"><input style="width:100%;" value="Actualizar" type="submit"></td>
</tr>
</table>
</form> 

<br />

<table width="450">
<td class="c">Gespeerte Spieler</td>
{suspendidos}
</table>