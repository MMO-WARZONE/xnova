<script>
function abrir(url) {
open(url,'','top=400,left=300,width=600,height=600') ;
}
</script>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<link rel="stylesheet" type="text/css" href="styles/css/topnav/01style.css" media="screen">
<div id='header_top'><center>
<div id="bar">

<a href="#">Jugador:</a> <b>{user_username}</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=soporte">Soporte</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=notes" target="_blank">Notas</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=buddy">Amigos</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=options">Configuraciones</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=statistics">Estadisticas {user_rank}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=search">Buscar</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:top.location.href='game.php?page=logout'" style="color:red">Salir</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="game.php?page=creditos">Autores</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#99cc00">Creditos Totales: {creditos}</font>
</div><br>
<table class='header'>
<tr class='header' >
<td class='header'>   <table class='header' id='resources' border="0" cellspacing="0" cellpadding="0" padding-right='30' >

        <tr class='header'>
        <td align="center" width="85" class='header'><img width="52" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>{Metal}</font><br>Capacidad Almacen</font><br><font size=1 color=skyblue>({metal_max})</font><br><font size=1 color=lime>({metal_basic_income})</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="{dpath}images/metal.png"/></td>
        <td align="center" width="85" class='header'><img width="52" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>{Crystal}</font><br>Capacidad Almacen</font><br><font size=1 color=skyblue>({crystal_max})</font><br><font size=1 color=lime>({crystal_basic_income})</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="{dpath}images/cristal.png"/></td>
         <td align="center" width="85" class='header'><img width="52" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>{Deuterium}</font><br>Capacidad Almacen</font><br><font size=1 color=skyblue>({deuterium_max})</font><br><font size=1 color=lime>({deuterium_basic_income})</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="{dpath}images/deuterio.png"/></td>
         <td align="center" width="85" class='header'><img width="52" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>{Darkmatter}</font><br><font size=1 color=lime>({darkmatter_basic_income})</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="{dpath}images/materia.png"/></td>
         <td align="center" width="85" class='header'><img width="52" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>{Energy}</font><br><font size=1 color=lime>({energy_basic_income})</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="{dpath}images/energia.png"/></td>
        </tr>
        <tr class='header'>
         <td align="center" class='header' width="90"><font >{metal}</font></td>
         <td align="center" class='header' width="90"><font >{crystal}</font></td>
         <td align="center" class='header' width="90"><font >{deuterium}</font></td>
         <td align="center" class='header' width="90"><font color="#FFFFFF">{darkmatter}</font></DIV></td>
         <td align="center" class='header' width="90">{energy}</td>

        </tr>

  </table></td>
    <td class="header">
        <table class="header" align="left">
  <tbody>
        <tr class="header">
        <td class="header" width="50" align="center">
        <a accesskey="o" href="game.php?page=officier">
        <img width="32" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>Activo Tempo Ilimitado</font><br>Comandante</font><br><font size=1 color=skyblue>Desbloquea la destruccion de la luna</font><br><br><font size=1 color=lime>¡Pidelo Ahora!</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="styles/images/officiers/{comandante}"/>     </a>    </td>
        <td class="header" width="35" align="center">
        <a accesskey="o" href="game.php?page=officier">
        <img width="32" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>Activo tiempo ilimitado</font><br>Almirante de flota</font><br><font size=1 color=skyblue>+5% de defensa, proteccion de naves y armas sobre las naves.</font><br><br><font size=1 color=lime>¡Pidelo Ahora!</b></font></center>', LEFT, WIDTH, 150);" alt="Almirante de flota" src="styles/images/officiers/{admirante}"/>     </a>    </td>
        <td class="header" width="35" align="center">
        <a accesskey="o" href="game.php?page=officier">
        <img width="32" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>Activo tiempo ilimitado</font><br>Ingeniero</font><br><font size=1 color=skyblue>Reduce las p&eacute;rdidas en batalla a la mitad<br>+10% m&aacute;s energ&iacute;a</font><br><br><font size=1 color=lime>¡Pidelo Ahora!</b></font></center>', LEFT, WIDTH, 150);" alt="Ingeniero" src="styles/images/officiers/{ingeniero}"/>     </a>    </td>
        <td class="header" width="35" align="center">
        <a accesskey="o" href="game.php?page=officier">
        <img width="32" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>Activo tiempo ilimitado</font><br>Ge&oacute;logo</font><br><font size=1 color=skyblue>+5% producci&oacute;n de minas</font><br><br><font size=1 color=lime>¡Pidelo Ahora!</b></font></center>', LEFT, WIDTH, 150);" alt="Geólogo" src="styles/images/officiers/{geologo}"/>     </a>    </td>
        <td class="header" width="35" align="center">
        <a accesskey="o" href="game.php?page=officier">
        <img width="32" height="32" border="0" onmouseout="return nd();" onmouseover="return overlib('<center><font size=1 color=white><b><font color=lime>Activo tiempo ilimitado</font><br>Tecn&oacute;crata</font><br><font size=1 color=skyblue>-5% al tiempo de construcci&oacute;n de naves</font><br><br><font size=1 color=lime>¡Pidelo Ahora!</b></font></center>', LEFT, WIDTH, 150);" alt="Tecnócrata" src="styles/images/officiers/{tecnocrata}"/>     </a>    </td>
 </tbody>
</table></td>
</tr>
</table>
{show_umod_notice}
</div>  
