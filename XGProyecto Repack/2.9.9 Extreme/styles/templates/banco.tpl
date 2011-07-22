<!--
////
//Banco.php
//Creado por Neko para XG Proyect - xtreme-gamez
////
-->

<div id="content">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<br><br>


<table border="0" width="120" cellspacing="5">
<td class="b">
<a href="game.php?page=banco&mode=depositar"><img src="styles/images/depositar.gif" " align="top" width="150" height="120"></a>
<th><a href="game.php?page=banco&mode=retirar"><img src="styles/images/retirar.gif" " align="top" width="150" height="120"></a></th>
</td>
</table>

<table border="0" width="310">
<td class="b">
Depositar en el banco cuesta <font color=lime>{costodark}</font> de Materia Oscura, retirar recursos no tiene costo alguno.
</td>
</table>

<br>
<table width="600">
<td class="c" colspan="10"><center>Capacidad del almacen</center></td>
<tr><th>Metal</th><th>Cristal</th><th>Deuterio</th></tr>
<tr><th><font color=lime>{almacenm}</font></th><th><font color=lime>{almacenc}</font></th><th><font color=lime>{almacend}</font></th></tr>
</table>
<table width="600">
<td class="b">Para aumentar la capacidad del almacen tenes q subir los contenedores de metal, cristal y/o deuterio, cada nivel sube 1.000.000 y el total lo multiplica por el nivel del almacen.
</td>
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
