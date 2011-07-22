<?php
/*
vente_defense.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//mise en page 
$page .='<HTML><div id="content">
<center>
<table width="600">
<td class="c">Menú Comercial</td></table>
<br>
'.$pageHeader.'
<br><br>
<table width="600">
<td class="c" colspan="10" align="center"><b><font color="white">Venta de Defensas</font></b></td></tr>
<form action="game.php?page=annonce&action=17" method="post">
<td class="c" colspan="10" align="center"><b>Defensa a vender</font></b></td>
<tr><th colspan="5"align="center"><select name="def">
		<option value="">Tipo</option>';
		
//de 401 a 409 pour les defs

foreach($lang['tech'] as $Element => $ElementName) {

if ($Element > 400 && $Element <= 409) {	

//on met en page les defs a vendre
$page.='
		<option value="'.$Element.'">'.$lang['tech'][$Element].'  Max: ('.$planetrow[$resource[$Element]].') </option>';
	}}
$page.='
		</select>
		</th><th colspan="5"><input type="texte" value="0" name="defvendre" />  </th>
		</tr>
<td class="c" colspan="10" align="center"><b>Recursos deseados</font></b></td></tr>
<tr><th colspan="5">Metal</th><th colspan="5"><input type="texte" value="0" name="metalsouhait" /></th></tr>
<tr><th colspan="5">Cristal</th><th colspan="5"><input type="texte" value="0" name="cristalsouhait" /></th></tr>
<tr><th colspan="5">Deuterio</th><th colspan="5"><input type="texte" value="0" name="deutsouhait" /></th></tr>
<tr><th colspan="10"><input type="submit" value="Enviar" /></th></tr>

<form>
</table></div>
</HTML>';

 display($page);
break;

 ?>