<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id='header_top'><center>
<table class='header' height="97">
<tr class='header' >
<td class='header' style='width:5;' height="82" >
	  <table class='header'>
    <tr class='header'>
     <td class='header' rowspan="2"><img src="{dpath}planeten/small/s_{image}.jpg" height="50" width="50"></td>
     <td class='header'>
	  <table class='header'>
&nbsp;<select size="1" onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
                    {planetlist}
                    </select>
                    {admin_link}
	  </table>
     </td>
    </tr>
    <tr class='header'>
     <td class='header'>
&nbsp;</td>
    </tr>
  </table></td>
<td class='header' height="82">   <table class='header' id='resources' border="0" cellspacing="0" cellpadding="0" padding-right='30' >

	    <tr class='header'>
	         <td width="50" class='header' valign="top" bgcolor="#996600" rowspan="4">
		      {alertled}</td>
		     
	         <td align="center" width="85" class='header'>
		      <img border="0" src="{dpath}images/metall.gif" width="42" height="22"></td>
		     
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

             <td align="center" width="85" class='header'><a href="game.php?page=messages">
             <img width="50" height="30" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b>Messages</font><br><font size=1 color=skyblue>Open your Inbox</font><br></center>', LEFT, WIDTH, 150);" alt="Message" src="styles/images/mp.png"/></a>
             </td>
	    </tr>
        
	    <tr class='header'>
		     
	     <td align="center" class='header' width="85">{Metal}</td>
	     <td align="center" class='header' width="85"><i><b>{Crystal}</b></i></td>
	     <td align="center" class='header' width="85"><i><b>{Deuterium}</b></i></td>
	     <td align="center" class='header' width="85"><i><b>{Darkmatter}</b></i></td>	
	          
	     <td align="center" class='header' width="85"><i><b>{Energy}</b></i></td>
         <td align="center" class='header' width="85"><b><font color="#FFFF00">Messages</font></b></td>  

	    </tr>
	    <tr class='header'>
		     
	     <td align="center" class='header' width="90"><font >{metal}</font></td>
	     <td align="center" class='header' width="90"><font >{crystal}</font></td>
	     <td align="center" class='header' width="90"><font >{deuterium}</font></td>
	     <td align="center" class='header' width="90"><font color="#FFFFFF">{darkmatter}</font></DIV></td>
	        
	     <td align="center" class='header' width="90">{energy}</td>
         <td align="center" class='header' width="90"><font color="white"><strong>{new_message}</strong></font></td>
	    </tr>
	    <tr class='header'>
		     
	    <td align="center" class='header' width="98" valign="top">
           <div align="left" style="border: 1px solid rgb(153, 153, 255); width: 70px;">
           <div id="AlmMBar" style="background-color: {metal_storage_barcolor}; width: {metal_storage_bar}px;">
           &nbsp;&nbsp;{metal_storage}</td>
	    <td align="center" class='header' width="98" valign="top">
           <div align="left" style="border: 1px solid rgb(153, 153, 255); width: 70px;">
           <div id="AlmCBar" style="background-color: {crystal_storage_barcolor}; width: {crystal_storage_bar}px; opacity: 0.98;">
           &nbsp;&nbsp;{crystal_storage}</td>
	    <td align="center" class='header' width="98" valign="top">
           <div align="left" style="border: 1px solid rgb(153, 153, 255); width: 70px;">
           <div id="AlmDBar" style="background-color: {deuterium_storage_barcolor}; width: {deuterium_storage_bar}px;">
           &nbsp;&nbsp;{deuterium_storage}</td>
	    <td align="center" class='header' width="98" valign="top">    
	       <td align="center" class='header' width="98">
           <div align="left" style="border: 1px solid rgb(153, 153, 255); width: 70px;">
           <div id="AlmDBar" style="background-color: {energy_storage_barcolor}; width: {energy_storage_bar}px;">
           &nbsp;&nbsp;{energy_storage}
</div>
</td>
         <td align="center" class='header' width="90">&nbsp;</td>
	    </tr>
   </table></td>
</tr>
<tr class='header' >
<td class='header' colspan="2" >
	  <div align="center">
<table border="1" width="57%">
	<tr>
		<td width="16">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1  color=white><b><font color=lime></font><br>Comandante</font><br><font size=1 color=skyblue>+3 slots para flotas</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="styles/images/officiers/{comandante}"/></a></td>
		<td width="16">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Ingeniero</font><br><font size=1 color=skyblue>+5% de energia</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="Ingeniero" src="styles/images/officiers/{ingeniero}"/></a></td>
		<td width="16">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Almirante</font><br><font size=1 color=skyblue>+5% escudo en naves</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="Almirante de flota" src="styles/images/officiers/{admirante}"/></a></td>
		<td width="16">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Geologo</font><br><font size=1 color=skyblue>+5% de producción en minas</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="Geólogo" src="styles/images/officiers/{geologo}"/></a></td>
		<td width="15">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Tecnocrata</font><br><font size=1 color=skyblue>+5% velocidad de construcción de naves</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="styles/images/officiers/{tecnocrata}"/></a></td>
		<td width="15">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Constructor</font><br><font size=1 color=skyblue>+10% de rapidez en la construcción de edificios</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="constructeur" src="styles/images/officiers/{constructeur}"/></a></td>
		<td width="15">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Cientifico</font><br><font size=1 color=skyblue>+10% de rapidez en la investigacion</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="scientifique" src="styles/images/officiers/{scientifique}"/></a></td>
		<td width="15">
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Almacenista</font><br><font size=1 color=skyblue>+50% de almacenamiento</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="stockeur" src="styles/images/officiers/{stockeur}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Defensor</font><br><font size=1 color=skyblue>+25% de rapidez en la construccion de defensas</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="defenseur" src="styles/images/officiers/{defenseur}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Protector</font><br><font size=1 color=skyblue>+25% de rapidez en la construccion de defensas</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="bunker" src="styles/images/officiers/{bunker}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Espia</font><br><font size=1 color=skyblue>+5 niveles de espionaje</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="espion" src="styles/images/officiers/{espion}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Destructor</font><br><font size=1 color=skyblue>2 estrellas al hacer 1</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="destructeur" src="styles/images/officiers/{destructeur}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>General</font><br><font size=1 color=skyblue>+10% de rapidez en los hangares</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="general" src="styles/images/officiers/{general}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Conquistador</font><br><font size=1 color=skyblue>Desbloquea la SuperNova</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="raideur" src="styles/images/officiers/{raideur}"/></a></td>
		<td>
        <a accesskey="o" href="game.php?page=officier">
        <img width="28" height="21" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime></font><br>Emperador</font><br><font size=1 color=skyblue>Desbloquea la Destrucción Planetaria</font><br><br><font size=1 color=lime></b></font></center>', LEFT, WIDTH, 150);" alt="empereur" src="styles/images/officiers/{empereur}"/></a></td>
	</tr>
</table>
		</div>
</td>
</tr>
</table>
<p>&nbsp;</p>
{show_umod_notice}
</div>