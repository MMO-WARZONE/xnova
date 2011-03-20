
<center>
<table>
	<tr>
	  <td></td>
	  <td>
	    <center>
		<table>
			<tr>
			  <td><img src="{$dpath}planeten/small/s_{$planetrow['image']}.jpg" height="50" width="50"></td>
			  <td>
			  <select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
			  <!-- peque? loop para agregar todos los planetas disponibles del mismo jugador... -->
				{select_planetlist}
			  </select>
				<table border="1"></table>
			  </td>
			</tr>
		</table>
		</center>
	  </td>
	  <td>
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			  <td align="center"></td>
			  <td align="center" width="85"><img src="{$dpath}images/metall.gif" border="0" height="22" width="42"></td>
			  <td align="center" width="85"><img src="{$dpath}images/kristall.gif" border="0" height="22" width="42"></td>
			  <td align="center" width="85"><img src="{$dpath}images/deuterium.gif" border="0" height="22" width="42"></td>
			  <td align="center" width="85"><img src="{$dpath}images/energie.gif" border="0" height="22" width="42"></td>
     <td align="center"></td>
    </tr>
    <tr>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(173, 174, 173);">{$lang['Metal']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(239, 81, 239);">{$lang['Crystal']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(247, 117, 66);">{$lang['Deuterium']}</b></i></td>
     <td align="center" width="85"><i><b style="color: rgb(156, 113, 198);">{$lang['Energy']}</b></i></td>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
    </tr>
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
HTML;
	/* 
	  Muestra los recursos, e indica si estos sobrepasan la capacidad de los almacenes
	*/
	$metal = number_format(floor($planetrow["metal"]),0,",",".");
	if(($planetrow["metal"] > $planetrow["metal_max"])){
		echo "<font color=\"#ff0000\">{$metal}</font>";
	}else{echo $metal;}
	echo '</td>
     <td align="center" width="85">';
	$crystal = number_format(floor($planetrow["crystal"]),0,",",".");
	if(($planetrow["crystal"] > $planetrow["crystal_max"])){ echo "<font color=\"#ff0000\">$crystal</font>";
	}else{echo $crystal;}
	echo '</td>
     <td align="center" width="85">';
	$deuterium = number_format(floor($planetrow["deuterium"]),0,",",".");
	if(($planetrow["deuterium"] > $planetrow["deuterium_max"])){ echo "<font color=\"#ff0000\">$deuterium</font>";
	}else{echo $deuterium;}
	echo '</td>
     <td align="center" width="85">';
	$energy = number_format($planetrow["energy_free"],0,",",".")."/".number_format($planetrow["energy_max"],0,",",".");
	
	if(($planetrow["energy_free"] < 0)){ echo "<font color=\"#ff0000\">$energy</font>";
	}else{echo $energy;}
	
	echo '</td>
     <td align="center"></td>
    </tr>
   </table>
  </td>
  </tr>
</table>
</center>