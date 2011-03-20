<?php

$lang['Version']     = 'Versión';
$lang['Description'] = 'Descripción';
$lang['changelog']   = array(
    '2.3.2' => '<span style="color:green">7/12/10</span>
<div><a onmouseout="document.getElementById(\'fix_2.3.2\').style.display=\'none\';" onmouseover="document.getElementById(\'fix_2.3.2\').style.display=\'\';">[FIX]</a></div><div id="fix_2.3.2" style="display:none">---Reparado sistema de seguridad en Admin [MENU]
---Reparado Misiles Interplanetarios (alcance)
---Reparado Misiles Interplanetarios (ataque) [REARMADO SISTEMA]
---Reparado Eliminación de un planeta
---Reparado Estadísticas contar cuando vuela
---Reparado Sistema de referidos
---Reparado BUG en TIEMPOS
---Reparado Duplicación de reciclajes
---Reparado Creacion de lunas con los ataques
</div><div><a onmouseout="document.getElementById(\'mod_2.3.2\').style.display=\'none\';" onmouseover="document.getElementById(\'mod_2.3.2\').style.display=\'\';">[MOD]</a></div><div id="mod_2.3.2" style="display:none">--Nuevo sistema de actualizaciones</div>',
    '2.3' => '<span style="color:green">23/09/10</span>
<div><a onmouseout="document.getElementById(\'fix_2.3\').style.display=\'none\';" onmouseover="document.getElementById(\'fix_2.3\').style.display=\'\';">[FIX]</a></div><div id="fix_2.3" style="display:none">---Reparado sistema de seguridad en Admin, daba acceso algunas paginas
---Reparado contador de usuarios cuando se registran.
---Reparado el uso de Planta de Fusion
---Reparado en Galaxia consume 9000 deuterio al navegar, si tiene.
---Reparado en Galaxia el envio de Recicladores
---Reparado las cookies en caso de duplicacion en statpoints.
---Reparado sistema de activación</div><div><a onmouseout="document.getElementById(\'mod_2.3\').style.display=\'none\';" onmouseover="document.getElementById(\'mod_2.3\').style.display=\'\';">[MOD]</a></div><div id="mod_2.3" style="display:none">---Nuevo sistema de sacs.
---Nuevo sistema de encriptacion se encriptaran COOKIES
---Replanteado el sistema de Displays</div>',
    '2.2' => '<span style="color:green">1/07/10</span>
<div><a onmouseout="document.getElementById(\'fix_2.2\').style.display=\'none\';" onmouseover="document.getElementById(\'fix_2.2\').style.display=\'\';">[FIX]</a></div><div id="fix_2.2" style="display:none">---Reparado el tiempo de vuelo de la flota ahora lo hace bien
---Reparado el boton de MIP en galaxia
---Reparado el panel de soporte de admin ahora podras cerrar los soportes</div><div><a onmouseout="document.getElementById(\'mod_2.2\').style.display=\'none\';" onmouseover="document.getElementById(\'mod_2.2\').style.display=\'\';">[MOD]</a></div><div id="mod_2.2" style="display:none">---Nueva Core de sistema de batallas
---Nuevo diseño con ajax incorporado
---RSS FEED incorporado al sistema
---Mejora de seguridad en la activación de cuentas</div>',

    '2.1' => '<span style="color:green">18/4/10</span>
<div ><a onmouseout="document.getElementById(\'add_2.1\').style.display=\'none\';" onmouseover="document.getElementById(\'add_2.1\').style.display=\'\';">[ADD]</a></div><div id="add_2.1" style="display:none">---Añadido sistema de actualizacion por archivos
---Sistema de seguridad de los archivos (en carpeta styles, scripts,incluides)</div><div ><a onmouseout="document.getElementById(\'fix_2.1\').style.display=\'none\';" onmouseover="document.getElementById(\'fix_2.1\').style.display=\'\';">[FIX]</a></div><div id="fix_2.1" style="display:none">---Mercader arreglado ahora actualiza bien los recursos
---Reparado con el problema de duplicacion de flotas
---Reparado el problema con los escombros daba 0
---Disminuido el tiempo de carga de las paginas</div><div ><a onmouseout="document.getElementById(\'avn_2.1\').style.display=\'none\';" onmouseover="document.getElementById(\'avn_2.1\').style.display=\'\';">[AVANCES PARA 2.2]</a></div><div id="avn_2.1" style="display:none">---Modificado del sistema de flotas
---Modificacion del diseño del login</div>',
'2.0' => '<span style="color:green">4/4/10</span>
<div ><a onmouseout="document.getElementById(\'add_2.0\').style.display=\'none\';" onmouseover="document.getElementById(\'add_2.0\').style.display=\'\';">[ADD]</a></div><div id="add_2.0" style="display:none" >---Sistema de plugins
---Sistema de log en admin
---Sistema de envio de mensajes JQUERY
---Sistema de email (phpmailer)
-------Configurado desde la instalación o panel de administración
---Sistema de activación de cuenta por email
---Sistema de circular por email,
---Sistema de copias de seguridad (BD) y con su restauración
---Nuevo Sistema de Antibots en registro (Captcha nuevo no publicado hasta ahora).</div><div><a onmouseout="document.getElementById(\'mod_2.0\').style.display=\'none\';" onmouseover="document.getElementById(\'mod_2.0\').style.display=\'\';">[MOD]</a> </div><div id="mod_2.0" style="display:none">---Sistema de tpl (displays)
---Sistema debug (ahora da mas información y guarda mas información)
---Sistema de usuarios (core de usuarios)
---la sentencia doquery() ahora sera $db->query()
---Core de flotas
---Cerrada brecha de seguridad en options (sql injection)
---Nuevo diseño, tanto en tpl como grafico.
---Nueva forma de instalación
-------Comprobaciones de los requisitos minimos del script
-------El update comprueba los datos de la conexion pero usa el config</div><div ><a onmouseout="document.getElementById(\'fix_2.0\').style.display=\'none\';" onmouseover="document.getElementById(\'fix_2.0\').style.display=\'\';">[FIX]</a></div><div id="fix_2.0" style="display:none">---Cerrada la vulnerabilidad en opciones por SQL Injection
---Reapado el problema con \' y " en la pagina de galaxia
---Repadado el agujero de seguridad en el Phanlax</div>

',

'1.2' => ' <span style="color:green">24/10/09</span>
-[ADD]Actualizador de base de datos hecho por adri y corregido x mi.
-[UPDATE]Sistema de Debug mejorado y con información algo mas detallada.
------[UPDATE]Te dirá donde se encuentran las $db->querys y su linea. (para que se mejor encontrar el error de las querys)
------[UPDATE]Mostrara la memoria de la pagina el total, con el common.php incluido.
-[UPDATE]Reducidos algunos archivos el uso de memoria usando TemplateMaster.inc el cual es usado en GALAXIA Y MENSAJES.
------[UPDATE]Y pasara a usarse en notas, techtree (arbol de investigaciones), en el sistema de soporte , también en compañeros y estadísticas.
-[FIX] De alianzas a la hora de mandar solicitudes 
-[FIX] Al BORRAR mensajes de uno en uno
-[FIX] Misiles Interplanetarios
-[FIX] Seguridad de Archivos
-[FIX] Cambiadas las imagenes de los planetas y con ello reduce su peso.
--------------------------------------------------------------------------------
Para la proxima version habra un cambio significativo.
pasara de v1.2 a la v2 (añadido ajax y rediseño estilo ogame pero sin su diseño);
',


'1' => '<span style="color:green"> 3/9/09</span> Modificado la estructuracion de las carpetas
-[MOD]Sac funcional (MadnessRed) y cambiando al de PADA (para nueva version)
-----[Fix] Cambio de nombre.
-----[FIX] Invitaciones.
-----[FIX] Tras la batalla se elimina.
-[MOD] Creada las clases para una mayor ordenacion del codigo y reducir el tiempo de carga.
-[MOD] Class para las funciones de flota. (union de todas las missioncase)
-[UPDATE] Modificada la tabla de aks por la de sac y con ello la missioncasesac.
-----[FIX] Si cambia el nombre del sac, se modifica.
-[UPDATE] Actualización del sistema de soporte. (reduccion query)
-[ADD] Nuevo sistema de Update. Te muestra que ficheros importantes han sido modificados. (comprueba cada 1h)
-----[Fix] Si se cambia los creditos no se actualiza.
-----[Fix] Todos los archivos a actualizar parten de los includes (pages - pages/admin - functions - functions/classes)
-[SKIN] Hecho por Principe Negro

',
);
?>