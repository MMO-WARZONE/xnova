<div id='header_top'><center>
<table class='header'>
<tr class='header' >
<td class='header' style='width:5;' >
	  <table class='header'>
    <tr class='header'>
     <td class='header'><img src="{dpath}planeten/small/s_{image}.jpg" height="50" width="50"></td>
     <td class='header'>
	  <table class='header'>
                    <select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
                    <optgroup label="{ov_planet}">
		    <!-- START BLOCK : planetlist -->
<option {select} value="game.php?page={page_topnav}&gid={gid_topnav}&cp={id}&amp;mode={mode_topnav}&amp;re=0">{name} [{galaxy}:{system}:{planet}]</option>
                    <!-- END BLOCK : planetlist -->
		    </optgroup>
		    <optgroup label="{gl_moon}">
		    <!-- START BLOCK : moonlist -->
<option {select} value="game.php?page={page_topnav}&gid={gid_topnav}&cp={id}&amp;mode={mode_topnav}&amp;re=0">{name} [{galaxy}:{system}:{planet}]</option>
                    <!-- END BLOCK : moonlist -->
		    </optgroup>
		   
		    </select>
		    
	  </table>
     </td>
    </tr>
  </table></td>
<td class='header'>   <table class='header' id='resources' border="0" cellspacing="0" cellpadding="0" padding-right='30' >

	    <tr class='header'>
	    
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/metall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/kristall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/deuterium.gif" width="42" height="22">
		     </td>
	     		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/darkmatter.jpg" width="42" height="22" title="Dark Matter">
		     </td>	     
	        		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/energie.gif" width="42" height="22">
		     </td>
		    
	    </tr>
        
	    <tr class='header'>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Metal}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Crystal}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Deuterium}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Darkmatter}</font></b></i></td>	
	          
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Energy}</font></b></i></td>
         
	    </tr>
	    <tr class='header'>
	     <td align="center" class='header' width="90"><font >{metal}</font></td>
	     <td align="center" class='header' width="90"><font >{crystal}</font></td>
	     <td align="center" class='header' width="90"><font >{deuterium}</font></td>
	     <td align="center" class='header' width="90"><font color="#FFFFFF">{darkmatter}</font></td>
	        
	     <td align="center" class='header' width="90">{energy}</td>
		   
	    </tr>
	    
   </table></td>
</tr>
</table>
{show_umod_notice}
</div>