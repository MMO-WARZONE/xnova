<!-- topnav.tpl -->
<div id="header_top">
<center>
<table class="header">
<tbody>
	<tr class="header">
          <tr>
<td>
       <center>
      <table>
         <tr>
           <td><img src="{dpath}planeten/small/s_{image}.jpg" height="50" width="50"></td>
           <td align="center">
           <input style="width: 20px;" value="&lt;" onclick="eval('location=\''+pselector.options[pselector.selectedIndex-1].value+'\'');" type="button">
           <select id="pselector" size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
                       {planetlist}
          
           <input style="width: 20px;" value="&gt;" onclick="eval('location=\''+pselector.options[pselector.selectedIndex+1].value+'\'');" type="button">
            <table border="1"></table>
           </td>
         </tr>
      </table>
      </center>
    	<td class="header">
        	<table width="722" border="0" cellpadding="0" cellspacing="0" class="header" id="resources" style="width: 722px;" padding-right="30">
            <tbody>
            	<tr class="header">
			  <td class="header" align="center" width="150"></td>
                    <td class="header" align="center" width="150"><img src="{dpath}images/metall.gif" border="0" height="22" width="42"></td>
                    <td class="header" align="center" width="150"><img src="{dpath}images/kristall.gif" border="0" height="22" width="42"></td>
                    <td class="header" align="center" width="150"><img src="{dpath}images/deuterium.gif" border="0" height="22" width="42"></td>
                    <td class="header" align="center" width="150"><img src="{dpath}images/energie.gif" border="0" height="22" width="42"></td>
                    <td class="header" align="center" width="150"><img src="{dpath}images/message.gif" border="0" height="22" width="42"></td>
                </tr>
                <tr class="header">
                	<td class="header" align="center" width="150"><b><font color="#ffffff"></font></b></td>
                	<td class="header" align="center" width="150"><b><font color="#FFFF00">{Metal}</font></td>
                    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Crystal}</font></b></td>
                    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Deuterium}</font></b></td>
                    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Energy}</font></b></td>
                    <td class="header" align="center" width="150"><b><font color="#FFFF00">{Message}</font></b></td>
                </tr>
                <tr class="header">
                	<td class="header" align="center" width="150"><b><font color="#FFFF00">{Ressverf}</font></b></td>
                    <td class="header" align="center" width="150"><font>{metal}</font></td>
                    <td class="header" align="center" width="150"><font>{crystal}</font></td>
                    <td class="header" align="center" width="150"><font>{deuterium}</font></td>
                    <td class="header" align="center" width="150"><font>{energy_total}/{energy_max}</font></td>
                    <td class="header" align="center" width="150"><font></font>{message}</td>
                </tr>
                <tr>
                	<td class="header" align="center" width="180"><b><font color="#FFFF00">{Store_max}</font></b></td>
                	<td class="header" align="center" width="180">{metal_max}</td>
                    <td class="header" align="center" width="180">{crystal_max}</td>
                    <td class="header" align="center" width="180">{deuterium_max}</td>
                </tr>
          	</table>
        </td>
	</tr>
</tbody>
</table>
{show_umod_notice}
</center>
</div>
<!-- end topnav.tpl -->