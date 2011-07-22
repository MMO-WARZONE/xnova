<!--
////
//Banco.php
//Creado por Neko para XG Proyect - xtreme-gamez
////
-->
<div id="content">

<form action="" method="post">
<input type="hidden" name="a" value="agregar">

<table width="310">
<td class="b" colspan="6"><center><b>[<a href="game.php?page=banco&mode=retirar"><font color=lime>Ir a retirar recursos</font></a>]</b></center></td>
</table>
<table width="310">
<td class="b" colspan="6"><center><b>Deposito de Recursos</b></center></td>
</table>
<br>
<table width="310">
<tbody>
<tr><td class="c" colspan="6"><center>Ingresar Recursos</center></td></tr>
<tr>	
<th>Metal:</th><th>{llenom}</tr><tr></th>
<th>Cristal:</th><th>{llenoc}</tr><tr></th>
<th>Deuterio:</th><th>{llenod}</tr><tr></th>
</tr>
<tr>
<td class="b" colspan="6"><center><input type="Submit" value="Depositar" /></center></td>
</tbody>
</tr>
</table>
</form>

<br>
<table width="600">
<td class="c" colspan="10"><center>Capacidad del almacen</center></td>
<tr><th>Metal</th><th>Cristal</th><th>Deuterio</th></tr>
<tr><th><font color=lime>{almacenm}</font></th><th><font color=lime>{almacenc}</font></th><th><font color=lime>{almacend}</font></th></tr>
</table>
<br>
<table width="600">
<td class="c" colspan="5"><center>Informacion de los Bancos de tus planetas</center></td>
<tr>
<th>Planeta/Luna</th><th>Metal</th><th>Cristal</th><th>Deuterio</th>
</tr><tr>
<th>{lista}</th><th>{met}</th><th>{cri}</th><th>{deu}</th>
</tr>
</table>
<table width="600">
<td class="b" colspan="6"><b>[<a href="game.php?page=banco">Volver</a>]</b></td>
</table>