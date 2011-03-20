<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id='header_top'><center>
<table class='header'>
<tr class='header' >
<td class='header' style='width:5;' >
	  <table class='header'>
    <tr class='header'>
     <td class='header' rowspan="2"><img src="{dpath}planeten/small/s_{image}.jpg" height="50" width="50"></td>
     <td class='header'>
	   <select size="1" id="pselector" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
                    {planetlist}
       </select>
     </td>
    </tr>
	<tr class="header">
	<td class="header">{flechas}</td>
	</tr>
  </table></td>
<td class='header'>   <table class='header' id='resources' border="0" cellspacing="0" cellpadding="0" padding-right='30'>
		<tr class='header'>
	     <td align="center" style="border-left: 1px dashed rgb(102, 102, 102);border-top: 1px dashed rgb(102, 102, 102);border-bottom: 1px dashed rgb(102, 102, 102);" class='header' width="85" colspan="2"><span style="font-weight: bolder;">Minerales</span></td>
	     <td align="center" style="border-left: 1px dashed rgb(102, 102, 102);border-right: 1px dashed rgb(102, 102, 102);border-top: 1px dashed rgb(102, 102, 102);border-bottom: 1px dashed rgb(102, 102, 102);" class='header' width="85" colspan="2"><span style="font-weight: bolder;">Hidr&oacute;geno</span></td>
	     <td align="center" class='header'></td>
		 <td align="center" class='header'></td>

	    </tr>
	    <tr class='header'>
	    
		     <td align="center" width="85" class='header' style="border-left: 1px dashed rgb(102, 102, 102);">
		      <img border="0" src="{dpath}images/metall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/kristall.gif" width="42" height="22">
		     </td>
		     
		     <td align="center" width="85" class='header' style="border-left: 1px dashed rgb(102, 102, 102);">
		      <img border="0" src="{dpath}images/deuterium.gif" width="42" height="22">
		     </td>
			 
		     <td align="center" width="85" class='header' style="border-right: 1px dashed rgb(102, 102, 102);">
		      <img border="0" src="{dpath}images/tritium.gif" width="42" height="22">
		     </td>
			 
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/darkmatter.jpg" width="42" height="22" title="Dark Matter">
		     </td>	     
	        		     
		     <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/energie.gif" width="42" height="22">
		     </td>
	    </tr>
        
	    <tr class='header'>
	     <td align="center" class='header' width="85" style="border-left: 1px dashed rgb(102, 102, 102);"><i><b><font color="#ffffff">{Metal}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Crystal}</font></b></i></td>
	     <td align="center" class='header' width="85" style="border-left: 1px dashed rgb(102, 102, 102);"><i><b><font color="#ffffff">{Deuterium}</font></b></i></td>
		 <td align="center" class='header' width="85" style="border-right: 1px dashed rgb(102, 102, 102);"><i><b><font color="#ffffff">{Tritium}</font></b></i></td>
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Darkmatter}</font></b></i></td>	          
	     <td align="center" class='header' width="85"><i><b><font color="#ffffff">{Energy}</font></b></i></td>

	    </tr>
	    <tr class='header'>
	     <td align="center" class='header' width="90" style="border-left: 1px dashed rgb(102, 102, 102);"><font >{metal}</font></td>
	     <td align="center" class='header' width="90"><font >{crystal}</font></td>
	     <td align="center" class='header' width="90" style="border-left: 1px dashed rgb(102, 102, 102);"><font >{deuterium}</font></td>
		 <td align="center" class='header' width="90" style="border-right: 1px dashed rgb(102, 102, 102);"><font >{tritium}</font></td>
	     <td align="center" class='header' width="90"><font color="#FFFFFF">{darkmatter}</font></DIV></td>
	        
	     <td align="center" class='header' width="90">{energy}</td>

	    </tr>
        <tr class="header">
            <td class="header" align="center" width="140" style="border-left: 1px dashed rgb(102, 102, 102);border-bottom: 1px dashed rgb(102, 102, 102);"><font>{metal_bar}</font></td>
            <td class="header" align="center" width="140" style="border-bottom: 1px dashed rgb(102, 102, 102);"><font>{crystal_bar}</font></td>
            <td class="header" align="center" width="140" style="border-left: 1px dashed rgb(102, 102, 102);border-bottom: 1px dashed rgb(102, 102, 102);"><font>{deuterium_bar}</font></td>
			<td class="header" align="center" width="140" style="border-bottom: 1px dashed rgb(102, 102, 102);border-right: 1px dashed rgb(102, 102, 102);"><font>{tritium_bar}</font></td>        
		</tr>
   </table></td>
</tr>
</table>
{show_umod_notice}
</div>
