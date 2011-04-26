<!--
info.cuenta.php
Creado por Neko para XG Proyect - xtreme-gamez
-->
<style>
td
{
	color: #000000;
	margin: 3px;
	padding: 3px;
	font-size: 15px;
	font-weight: bold;
	border-bottom-width: medium;
	border-bottom-style: groove;
	border-bottom-color: #000000;
}
</style>
<br><br><br><br>
<form action="" method="post">
<input type="hidden" name="modo" value="datos">
<table>
<center><font color=red>{error}</font></center>
</table>
<br>
<table width="350">
<tbody>
<td colspan="3"><center>{ac_enter_user_id}</center></td>
<tr>
   	<th>{ac_user_id}</th>
   	<th><input name="id_u" type="text" value="" /></th>
</tr>
	<td colspan="3"><center><input type="Submit" value="{ac_send}" /></center></td>
</tbody>
</table>