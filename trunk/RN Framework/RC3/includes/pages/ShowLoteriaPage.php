<?php
/**
# 	ShowLoteriaPage.php, Loteria-C.php
#	Creado por Neko para XG Proyect - xtreme-gamez
#	Algunas ideas sacadas de la Loteria de SainT.
**/


/**
#	$Cloteria[0] (Precio del metal)
#	$Cloteria[1] (Precio del cristal)
#	$Cloteria[2] (Precio del deuterio)
#	$Cloteria[3] (Precio de la materia oscura)
#	$Cloteria[4] (Premio en metal)
#	$Cloteria[5] (Premio en cristal)
#	$Cloteria[6] (Premio en deuterio)
#	$Cloteria[7] (Premio en materia oscura)
#	$Cloteria[8] (Numero maximo de boletos)
#	$Cloteria[9] (Numero maximo de boletos por usuario)
#	$Cloteria[10] (Desactivar loteria)
#	$Cloteria[11] (Tiempo de la loteria)
**/

if(!defined('INSIDE')){ die(header("location:../../"));}

function Loteria($CurrentPlanet, $CurrentUser)
{

global $planetrow, $user, $game_config;


$loteria_c 	= doquery("SELECT * FROM {{table}} WHERE config_name = 'configloteria'", 'config', true);
$loteria_b  = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['id']."' ", 'loteria', true);
$loteria_s  = doquery("SELECT sum(boletos) as boletos_t FROM {{table}} ", 'loteria', true);
$loteria_d  = doquery("SELECT * FROM {{table}} order by nombre_u", 'loteria');

$Cloteria = explode("|" ,	$loteria_c[1]);


$metal_c		=	$Cloteria[0];
$cristal_c		=	$Cloteria[1];
$deute_c		=	$Cloteria[2];
$materia_c		=	$Cloteria[3];

$metal_p		=	$Cloteria[4];
$cristal_p		=	$Cloteria[5];
$deute_p		=	$Cloteria[6];
$materia_p		=	$Cloteria[7];
	
$boletos_max	=	$Cloteria[8];
$boletos_por_u	=	$Cloteria[9];

$desactivar		=	$Cloteria[10];

$tiempo			=	$Cloteria[11];

$parse['metal_c']	=	$metal_c;
$parse['cristal_c']	=	$cristal_c;
$parse['deute_c']	=	$deute_c;
$parse['materia_c']	=	$materia_c;

$parse['metal_p']	=	$metal_p;
$parse['cristal_p']	=	$cristal_p;
$parse['deute_p']	=	$deute_p;
$parse['materia_p']	=	$materia_p;

$parse['boletos_max']	=	"<font color=lime>".$boletos_por_u."</font>";





// Total de tickets ##############################################################################
// En caso de que no hayan comprado tickets se pone el resultado total como 0
if ($loteria_s['boletos_t'] != 0)
{
	$boletos_totales	=	$loteria_s['boletos_t'];
}
else
{
	$boletos_totales	=	0;
}

if($loteria_s['boletos_t'] != $boletos_max)
{
	$parse['boletos']	=	"<font color=lime>".$boletos_totales."/".$boletos_max."</font>";
}
elseif($loteria_s['boletos_t'] >= $boletos_max)
{
	$parse['boletos']	=	"<font color=red>".$boletos_totales."/".$boletos_max."</font>";
}
// Fin total de tickets ##############################################################################






// Tickets de la persona ##############################################################################
// En caso de que no haya comprado tickets se pone el resultado total como 0
if ($loteria_b['boletos'] != 0)
{
	$boletos_usuario	=	$loteria_b['boletos'];
}
else
{
	$boletos_usuario	=	0;
}

if($loteria_b['boletos'] < $boletos_por_u)
{
	$parse['boletos_p_u']	=	"<font color=lime>".$boletos_usuario."</font>";
}
else
{
	$parse['boletos_p_u']	=	"<font color=red>".$boletos_usuario." (Max.Anzahl)</font>";
}
// Fin tickets de la persona ##############################################################################






// Desactivado de loteria, Prohibida la compra si ya tenes el maximo permitido de boletos p/p, etc #############################
if ($desactivar != 0)
{
	$parse['value']				=	"Desactivado";
	$parse['disabled']			=	"disabled=\"disabled\"";
	$parse['form']				=	"class=\"form\"";
	$parse['color']				=	"#FF0000";
	$parse['msj2']				=	"Desactivado";
	$parse['blink']				=	"blink";
}
else
{
	$parse['value']		=	"Comprar";
	$parse['color']		=	"#00FF00";
	$parse['msj2']		=	"AKTIV";
}

if ($loteria_b['boletos'] >= $boletos_por_u)
{
	$parse['value']		=	"Comprar";
	$parse['disabled']	=	"disabled=\"disabled\"";
	$parse['form']		=	"class=\"form\"";
}
// Fin Desactivado de loteria, etc ##############################################################################





// Lista de usuarios que participan en la loteria y la cantidad de boletos de tal ######################################
while ($a = mysql_fetch_array($loteria_d))
{
	$parse['participantes']	.=	"<tr><th>".$a['nombre_u']." (<font color=lime>".$a['boletos']." boletos</font>)</th></tr>";
}
// Fin lista de usuarios ##############################################################################




// Definimos el Tiempo ##############################################################################
$Tiempo = time();
if($Tiempo < $game_config['Loteria'])
{
	$Falta1 =  ($game_config['Loteria']-$Tiempo);
   
	function segundos_tiempo($segundos)
	{
		$minutos	=	$segundos/60;
		$horas		=	floor($minutos/60);
	   	$minutos2	=	$minutos%60;
   	    $segundos_2	=	$segundos%60%60%60;
				
      	if($minutos2 < 10)	$minutos2	=	'0'.$minutos2;
      	if($segundos_2 < 10)	$segundos_2	=	'0'.$segundos_2;
     
      	if($segundos <60)
		{ 
      		$resultado	=	'N&auml;chste Lotterie startet in  '.round($segundos).' Sekunden';
      	}
		elseif($segundos > 60 && $segundos < 3600)
		{
      		$resultado	= 	'N&auml;chste Lotterie startet in  '.$minutos2.' Minuten und '.$segundos_2.' Sekunden';
      	}
		else
		{
     		$resultado	= 	'N&auml;chste Lotterie startet in '.$horas.' Stunden, '.$minutos2.' Minuten und '.$segundos_2.' Sekunden';
      	}
		
      	return $resultado;
     }
	 	 
	$segundos	=	date('h')*60*60+(date('i')*60)+date('s');
	$parse['loteria_tiempo']	=	segundos_tiempo($Falta1);
	$parse['value']		=	"En espera...";
	$parse['disabled']	=	"disabled=\"disabled\"";
	$parse['form']		=	"class=\"form\"";
// Fin de definir el Tiempo ##############################################################################
}
elseif ($user['loteria_sus']	==	1)
{
	$parse['loteria_tiempo']	=	"<font color=red>Estas suspendido y no podes participar en esta loteria!</font>";
	$parse['value']				=	"Comprar";
	$parse['disabled']			=	"disabled=\"disabled\"";
	$parse['form']				=	"class=\"form\"";
}
else
	{	
		if ($desactivar != 0){$parse['loteria_tiempo']	=	"<font color=#FF8000>Loteria desactivada</font>";}else{
		$parse['loteria_tiempo']	=	"<font color=lime>Loteria en marcha, compra tus tickets!</font>";}
		
		// Trámite que se ejecuta al comprar boletos ##############################################################################
		$post	= $_POST['bole'];
		
		if ($post == 'si')
		{
			$ticket		= $_POST['tickets'];
			
			$metal 		= $ticket * $metal_c;
    		$cristal 	= $ticket * $cristal_c;
    		$deute 		= $ticket * $deute_c;
			$materia 	= $ticket * $materia_c;


			
			if ($materia	>	$user['darkmatter'])
			{
				$f_materia	=	($materia - $user['darkmatter']);
				$comun		=	"<tr><th class=\"error2\">Sie wollten <font color=lime>".$ticket."</font> Tickets kaufen:</th></tr>";
				$ff_materia	=	"<tr><th class=\"error2\">Ihnen fehlen: <font color=lime>".$f_materia."</font> Dunkler M&uuml;</th></tr>";
			}
			if ($metal	>	$planetrow['metal'])
			{
				$f_metal	=	($metal - $planetrow['metal']);
				$comun		=	"<tr><th class=\"error2\">Para comprar <font color=lime>".$ticket."</font> boleto/s te falta:</th></tr>";
				$ff_metal	=	"<tr><th class=\"error2\">Ihnen fehlen: <font color=lime>".$f_metal."</font> Metall</th></tr>";
			}
			if ($cristal	>	$planetrow['crystal'])
			{
				$f_cristal	=	($cristal - $planetrow['crystal']);
				$comun		=	"<tr><th class=\"error2\">Para comprar <font color=lime>".$ticket."</font> boleto/s te falta:</th></tr>";
				$ff_cristal	=	"<tr><th class=\"error2\">Ihnen fehlen: <font color=lime>".$f_cristal."</font> Kristall</th></tr>";
			}
			if ($deute	>	$planetrow['deuterium'])
			{
				$f_deute	=	($deute - $planetrow['deuterium']);
				$comun		=	"<tr><th class=\"error2\">Para comprar <font color=lime>".$ticket."</font> boleto/s te falta:</th></tr>";
				$ff_deute	=	"<tr><th class=\"error2\">Ihnen fehlen: <font color=lime>".$f_deute."</font> Deuterium</th></tr>";
			}
			
			$error_boletos	=	$ticket + $loteria_b['boletos'];
			$error_boletos2	=	$ticket + $loteria_s['boletos_t'];
			if ($error_boletos > $boletos_por_u)
			{
				$m_b_u	=	$boletos_por_u - $loteria_b['boletos'];
				$mm_b_m	=	"<tr><th class=\"error2\">Excedes el maximo de boletos por usuario, podes comprar: <font color=lime>".$m_b_u."</font> boletos</th></tr>";
			}
			elseif ($error_boletos2 > $boletos_max)
			{
				$m_b_m	=	$boletos_max - $loteria_s['boletos_t'];
				$mm_b_u	=	"<tr><th class=\"error2\">Excedes el maximo de boletos disponibles, podes comprar: <font color=lime>".$m_b_m."</font> boletos</th></tr>";
			}
			
			// Planilla de Errores ##############################################################################
			$parse['info']	.=	"<br><table width=\"700\" border=\"5\" bordercolor=\"#DF0101\" cellpadding=\"5\" cellspacing=\"10\">";
			$parse['info']	.=	$comun;
			$parse['info']	.=	$ff_materia;	
			$parse['info']	.=	$ff_metal;
			$parse['info']	.=	$ff_cristal;
			$parse['info']	.=	$ff_deute;
			$parse['info']	.=	$mm_b_m;
			$parse['info']	.=	$mm_b_u;
			$parse['info']	.=	"</table>";
			// Fin de la planilla de errores ##############################################################################
				
						
			if ($materia	<=	$user['darkmatter'] && $metal	<=	$planetrow['metal'] &&
				$cristal	<=	$planetrow['crystal'] && $deute	<=	$planetrow['deuterium'] &&
				$error_boletos <= $boletos_por_u && $error_boletos2 <= $boletos_max)
			{
				
				
					doquery("UPDATE {{table}} SET 
					`metal` = metal - '".$metal."', `crystal` = crystal - '".$cristal."', 
					`deuterium` = deuterium - '".$deute."' WHERE `id` = '".$planetrow['id']."'", "planets");
			
					doquery("UPDATE {{table}} SET `darkmatter` = darkmatter - '".$materia."' WHERE `id` = '".$user['id']."'", "users");
				
				
					if ($loteria_b['boletos']	>	'0')
					{
						doquery("UPDATE {{table}} SET `boletos` = `boletos` + '".$ticket."' WHERE `id` = '".$user['id']."'", "loteria");
					}
					else
					{
						doquery("INSERT INTO {{table}} SET `id` = '".$user['id']."', `boletos` = '".$ticket."', 
														   `nombre_u` = '".$user['username']."', `id_planeta` = '".$user['id_planet']."'", "loteria");
					}
					
					
					// Se entrega el premio ##############################################################################
					if ($boletos_max <= ($ticket + $loteria_s['boletos_t']))
					{		
		
						$query_1 = doquery("SELECT * FROM {{table}} order by rand()", "loteria", true);
						$query_2 = doquery("SELECT * FROM {{table}} WHERE `id` = '".$query_1['id']."' limit 1", "users", true);
						$query_3 = doquery("SELECT * FROM {{table}} WHERE `id` = '".$query_2['id_planet']."' limit 1", "planets", true);
								
						$materia_pp	=	$query_2['darkmatter'] + $materia_p;
					 
					 
						doquery("UPDATE {{table}} SET 
								`metal` = metal + '".$metal_p."', `crystal` = crystal + '".$cristal_p."', 
								`deuterium` = deuterium + '".$deute_p."' WHERE `id` = '".$query_3['id']."' limit 1", "planets");
								
						doquery("UPDATE {{table}} SET `darkmatter` = '".$materia_pp."' WHERE `id` = '".$query_2['id']."' limit 1", "users");
						
						
						// Manda mensajes a los participantes ##############################################################################
						$Time    		= time();
  						$From    		= "<font color='#01DF01'>Lotterie</font>"; 
  						$Subject 		= "<font color='#01DF01'>Ziehung um ".date("H:i:s",time())."</font>";
						$lote_consulta  = doquery("SELECT * FROM {{table}}", "loteria");

    					while ($b = mysql_fetch_array($lote_consulta))
						{   
             				if($query_1['id'] == $b['id'])
							{ 
             					$Message  = "<b>Herzlichen Gl&uuml;ckwunsch<br>Sie hatten das Glückslos. Hier ist ihr Gewinn: ";
								$Message .= "<br><font color=lime>".$metal_p."</font> Metall <br>";
								$Message .= "<font color=lime>".$cristal_p."</font> Kristall <br>";
								$Message .= "<font color=lime>".$deute_p."</font> Deuterium <br>";
								$Message .= "<font color=lime>".$materia_p."</font> Dunkler M&uuml;ll <br><br>";
								$Message .= "Wir hoffen, sie bald wieder zu beeheren.</b>";
             				}
							else
							{   
            					$Message  = "<b>Du hattest leider nicht das Gewinnerlos. <br>";
								$Message .= umlaute("Auf jeden Fall wünschen wir Ihnen noch viel Glück und hoffe, Sie wieder hier an der nächsten Teilnahme begrüßen zu dürfen.")."</b>";
             				}
             				SendSimpleMessage ( $b['id'], '', $Time, 1, $From, $Subject, $Message);
    					}
						// Fin de mensajes ##############################################################################
			
			
						doquery ("DELETE FROM {{table}} ",'loteria');
			
						$sigueintelore = $tiempo + time();
   						doquery("UPDATE {{table}} SET `config_value`='".$sigueintelore."' WHERE `config_name`='Loteria' limit 1", "config");
					}
					// Fin de la entrega ##############################################################################
					
					
					message("<font color=lime>".$ticket."</font> Tickets gekauft", "game.php?page=loteria", 2);
			}
		}
		// Fin del trámite ##############################################################################
	}


display(parsetemplate(gettemplate("Loteria.Body"), $parse));
}
?> 