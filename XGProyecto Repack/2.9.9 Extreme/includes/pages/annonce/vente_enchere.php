<?php
/*
vente_enchere.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//mise en page
$page2 = "<HTML><div id='content'>
<center>
<table width='600'>
<td class='c'>Menú Comercial</td></table>
<br>
{$pageHeader}
<br><br>";

$page2 .="
<form action='game.php?page=annonce&action=16' method='post'>
<table border='0' width='466'>
    <tr>
        <td width='200' class='c'>
         Poner una flota en subasta
        </td>
        <td width='250'class='c'>
         Cumplimenta los campos     
        </td>
    </tr>
    <tr>
        <td width='200'class='a'>";
$page2 .='
          Nave:  <select name="vaisseau">
		<option value="">Tipo</option>';
		
//de 201 a 299 pour les vaisseaux

foreach($lang['tech'] as $Element => $ElementName) {

if ($Element > 201 && $Element <= 299) {	

//on met en page les vaisseaux a mettre au encheres
$page2.='
		<option value="'.$Element.'">'.$lang['tech'][$Element].'  Max: ('.$planetrow[$resource[$Element]].') </option>';
	}}
$page2.="
		</select>
        </td>
        <td width='250' class='a'>
            Cantidad: <input type='text' value='0' name='vaisseauvendre' />
        </td>
    </tr>
	</tr><td><br></td></tr>
    <tr>
        <td width='200' class='c' align='center' rowspan='3'>
            <h2>Precio de salida</h2> <br><br>
			Inferior a 1000 unidades sin comisión, y un 10% de la venta si es superior.
        </td>
        <td width='250' class='a'>
            Metal: <input type='text' value='0' name='departmetal' />
        </td>
    </tr>
    <tr>
        <td width='250' class='a'>
            Cristal: <input type='text' value='0' name='departcristal' />
        </td>
    </tr>
    <tr>
        <td width='250' class='a'>
            Deuterio: <input type='text' value='0' name='departdeuter' />
        </td>
    </tr>
	</tr><td><br></td></tr>
    <tr>
        <td width='200' class='a'>
            Precio de reserva (costo: 500.000 Deut):
        </td>
        <td width='250' class='a'>
            Mínimo para validar la subasta: <input type='text' value='0' name='reserve' />
        </td>
    </tr>
	<tr>
	<td width='200'class='a'>
         Duración: </td>
	<td width='200'class='a'>
	 <select name='duree'>
		<option value=''> </option>
        <option value='86400'>1 día</option>
		<option value='259200'>3 días</option>
		<option value='604800'>7 días</option>	
	 </select>
        </td>
	<tr><th colspan='2'><input type='submit' value='Enviar' /></th></tr>
</table></div>";
display($page2);
break;

 ?>