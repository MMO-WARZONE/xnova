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
#	$Cloteria[11] (Tiempo)
**/
  
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
   

if ($user['authlevel'] < 2) die(message ($lang['not_enough_permissions']));

$suspendidos_q	=	doquery("SELECT * FROM {{table}} WHERE `loteria_sus` = '1'", 'users');
$Consulta = doquery("SELECT * FROM {{table}} WHERE config_name = 'configloteria'", 'config', true);
$Cloteria = explode("|" ,$Consulta[1]);
	
    $parse['metal_precio'] 		=  $Cloteria[0];
    $parse['cristal_precio'] 	=  $Cloteria[1];
    $parse['deute_precio'] 		=  $Cloteria[2];
    $parse['materia_precio'] 	=  $Cloteria[3];
    $parse['metal_premio'] 		=  $Cloteria[4];
    $parse['cristal_premio']	=  $Cloteria[5];
    $parse['deute_premio'] 		=  $Cloteria[6];
    $parse['materia_premio'] 	=  $Cloteria[7];
    $parse['boletos_max'] 		=  $Cloteria[8];
    $parse['boletos_p_u'] 		=  $Cloteria[9];
	$parse['des-act'] 			=  $Cloteria[10];
	$parse['tiempo'] 			=  $Cloteria[11];


// Si la loteria esta desactivada se pone el checkbox como checked
if ($Cloteria[10] != 0)
{
	$parse['estado']	=	"checked=\"checked\"";
}
else
{
	$parse['estado']	=	"";
}

// Lista de suspendidos
while ($a	=	mysql_fetch_array($suspendidos_q))
{
	$parse['suspendidos']	.=	"<tr><td><center>".$a['username']." (ID: ".$a['id'].")</center></td></tr>";
}

if($_POST) 
{
	// Si se ponen letras...
	if(	!is_numeric($_POST['boletos_max']) or 
		!is_numeric($_POST['metal_precio']) or 
		!is_numeric($_POST['cristal_precio']) or 
		!is_numeric($_POST['deute_precio']) or 
		!is_numeric($_POST['materia_precio']) or 
		!is_numeric($_POST['metal_premio']) or
		!is_numeric($_POST['cristal_premio']) or
		!is_numeric($_POST['deute_premio']) or
		!is_numeric($_POST['materia_premio']) or
		!is_numeric($_POST['tiempo']) or
		!is_numeric($_POST['boletos_p_u'])) 
		{
        	message("Solo se pueden poner numeros.", "Loteria-C.php", 2);
        }
		

	
	if (isset($_POST['des-act']) && $_POST['des-act']	=	'on')
	{
		$resultado	=	1;
	}
	else
	{
		$resultado	=	0;
	}
	
    $NCloteria = 	$_POST['metal_precio']."|".$_POST['cristal_precio'].
					"|".$_POST['deute_precio']."|".$_POST['materia_precio'].
					"|".$_POST['metal_premio']."|".$_POST['cristal_premio'].
					"|".$_POST['deute_premio']."|".$_POST['materia_premio'].
					"|".$_POST['boletos_max']."|".$_POST['boletos_p_u'].
					"|".$resultado."|".$_POST['tiempo']."|";
       

    doquery("UPDATE {{table}} SET config_value='".$NCloteria."' where config_name='configloteria'", "config");
	
	if (isset($_POST['reiniciar']) && $_POST['reiniciar']	=	'on')
	{
		doquery ("DELETE FROM {{table}} ",'loteria');
		doquery("UPDATE {{table}} SET `config_value`	=	'0' WHERE `config_name`	=	'Loteria' limit 1", "config");
	}
	
	if (isset($_POST['reiniciar_tiempo']) && $_POST['reiniciar_tiempo']	=	'on')
	{
		$reinicio_tiempo	=	$Cloteria[11] + time();
   		doquery("UPDATE {{table}} SET `config_value`	=	'".$reinicio_tiempo."' WHERE `config_name`	=	'Loteria' limit 1", "config");
	}
	
	
	if ($_POST['suspender'] != NULL)
	{
		if (!is_numeric($_POST['suspender']))
		{
   			doquery("UPDATE {{table}} SET `loteria_sus`	=	'1' WHERE `username`	=	'".$_POST['suspender']."'", "users");
		}
		else
		{
			doquery("UPDATE {{table}} SET `loteria_sus`	=	'1' WHERE `id`	=	'".$_POST['suspender']."'", "users");
		}
	}
	
	if ($_POST['sacar_sus'] != NULL)
	{
		if (!is_numeric($_POST['sacar_sus']))
		{
   			doquery("UPDATE {{table}} SET `loteria_sus`	=	'0' WHERE `username`	=	'".$_POST['sacar_sus']."'", "users");
		}
		else
		{
			doquery("UPDATE {{table}} SET `loteria_sus`	=	'0' WHERE `id`	=	'".$_POST['sacar_sus']."'", "users");
		}
	}
	
    message("Cambios efectuados con exito", "Loteria-C.php", 2);
}
   

display(parsetemplate(gettemplate('adm/Loteria-C-Body'), $parse), false, '', true, false);
   
   
?> 