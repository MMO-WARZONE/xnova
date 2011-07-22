<?php
////
//Banco.php
//Creado por Neko para XG Proyect - xtreme-gamez
////
if(!defined('INSIDE')){ die(header("location:../../"));}

function Banco ($CurrentUser, $planetrow)
{

$metal				=	$_POST['metal'];
$cristal			=	$_POST['cristal'];
$deute				=	$_POST['deute'];
$galaxia			=	$planetrow['galaxy'];
$sistema			=	$planetrow['system'];
$planeta			=	$planetrow['planet'];
$tipo				=	$planetrow['planet_type'];
$no_met				=	$planetrow['metal'];
$no_cris			=	$planetrow['crystal'];
$no_deu				=	$planetrow['deuterium'];
$no_met_bank		=	$planetrow['bankm'];
$no_cris_bank		=	$planetrow['bankc'];
$no_deu_bank		=	$planetrow['bankd'];
$almacenm			=	(($planetrow['metal_store'] * 1000000) * $planetrow['metal_store']);
$almacenc			=	(($planetrow['crystal_store'] * 1000000) * $planetrow['crystal_store']);
$almacend			=	(($planetrow['deuterium_store'] * 1000000) * $planetrow['deuterium_store']);
$costo_dark			=	2500;
$parse['almacenm']	=	$almacenm;
$parse['almacenc']	=	$almacenc;
$parse['almacend']	=	$almacend;
$parse['costodark'] =	$costo_dark;
$lista_planetas   	=	$QryPlanets  = "SELECT `name`, `bankm`, `bankc`, `bankd`, `galaxy`, `system`, `planet`, `planet_type` FROM {{table}} WHERE `id_owner` = '". $CurrentUser['id'] ."'";
$lista_planetas   	=	doquery($QryPlanets, 'planets');

$suma_m				=	($almacenm - $no_met_bank);
$suma_c				=	($almacenc - $no_cris_bank);
$suma_d				=	($almacend - $no_deu_bank);



while ($c = mysql_fetch_array($lista_planetas))
{
	if ($c["destruyed"] == 0)
		{
			if ($c['planet_type'] == 3){$parse['lista'] .= "<hr>".$c['name']."&nbsp;(Luna)&nbsp;<font color=lime>[".$c['galaxy'].":".$c['system'].":".$c['planet']."]</font><hr>";}
			elseif ($c['planet_type'] == 1){$parse['lista'] .= "<hr>".$c['name']."&nbsp;<font color=lime>[".$c['galaxy'].":".$c['system'].":".$c['planet']."]</font><hr>";}
			$parse['met'] .= "<hr><font color=LawnGreen>".$c['bankm']."</font><hr>";
			$parse['cri'] .= "<hr><font color=LawnGreen>".$c['bankc']."</font><hr>";
			$parse['deu'] .= "<hr><font color=LawnGreen>".$c['bankd']."</font><hr>";
		}
}

if ($no_met_bank >= $almacenm){$parse['llenom'] = "<center>Almacen lleno!</center>";}elseif ($no_met_bank < $almacenm){$parse['llenom'] = "<input name=\"metal\" type=\"text\" value=\"0\" />";}
if ($no_cris_bank >= $almacenc){$parse['llenoc'] = "<center>Almacen lleno!</center>";}elseif ($no_cris_bank < $almacenc){$parse['llenoc'] = "<input name=\"cristal\" type=\"text\" value=\"0\" />";}
if ($no_deu_bank >= $almacend){$parse['llenod'] = "<center>Almacen lleno!</center>";}elseif ($no_deu_bank < $almacend){$parse['llenod'] = "<input name=\"deute\" type=\"text\" value=\"0\" />";}


switch ($_GET['mode'])
{
	case 'depositar':
		if ($_POST['a'] == 'agregar') 
			{
				if ($metal > $no_met || $cristal > $no_cris || $deute > $no_deu)
				{message ('No dispones de recursos suficientes', 'game.php?page=banco&mode=depositar', 3);}
				
				elseif ($metal < 0 || $cristal < 0 || $deute < 0)
				{message ('Solo se pueden ingresar numeros positivos', 'game.php?page=banco&mode=depositar', 3);}
				
				elseif ($metal == 0 && $cristal == 0 && $deute == 0)
				{message ('No has ingresado ningun numero', 'game.php?page=banco&mode=depositar', 3);}
				
				elseif ($almacenm < $_POST['metal'] || $almacenc < $_POST['cristal'] || $almacend < $_POST['deute'] || $suma_m < $_POST['metal'] || $suma_c < $_POST['cristal'] || $suma_d < $_POST['deute'])
				{message ('Sobrepasas el limite del almacen, podes almacenar <font color=lime>'. $almacenm .' </font>de metal, <font color=lime>'. $almacenc .' </font>de cristal y <font color=lime>'. $almacend .' </font>de deuterio'   , 'game.php?page=banco&mode=depositar', 3);}
				
				elseif ($CurrentUser['darkmatter'] < $costo_dark)
				{message ('No tenes suficiente materia oscura', 'game.php?page=banco&mode=depositar', 3);}
				
				elseif ($metal <= $no_met && $cristal <= $no_cris && $deute <= $no_deu){
					
						doquery("UPDATE {{table}} SET
							  	`bankm`= bankm + '". $metal ."',
                              	`bankc`= bankc + '". $cristal ."',
                              	`bankd`= bankd + '". $deute ."',
							  	`metal`= metal - '". $metal ."',
							  	`crystal`= crystal - '". $cristal ."',
							  	`deuterium`= deuterium - '". $deute ."'
                              	 WHERE `galaxy`='".$planetrow['galaxy']."'
                               	 AND `system` ='".$planetrow['system']."'
                               	 AND `planet` ='".$planetrow['planet']."'
                               	 AND `planet_type` ='".$planetrow['planet_type']."'
                               	 ",'planets');
								 
						doquery("UPDATE {{table}} SET
							  	`darkmatter`= darkmatter - '". $costo_dark ."'
                              	 WHERE `id`='".$CurrentUser['id']."'
                               	 ",'users');
				
						message ('Su deposito ha sido realizado con exito!', 'game.php?page=banco&mode=depositar', 3);
				}
			}
			
		display(parsetemplate(gettemplate('banco_depositar'), $parse));
		break;
		
	case 'retirar':
		if ($_POST['s'] == 'sacar') 
			{
				if ($metal > $no_met_bank || $cristal > $no_cris_bank || $deute > $no_deu_bank)
				{message ('No hay tantos recursos en tu banco!', 'game.php?page=banco&mode=retirar', 3);}
				
				elseif ($metal < 0 || $cristal < 0 || $deute < 0)
				{message ('Solo se pueden ingresar numeros positivos', 'game.php?page=banco&mode=retirar', 3);}
				
				elseif ($metal == 0 && $cristal == 0 && $deute == 0)
				{message ('No has ingresado ningun numero', 'game.php?page=banco&mode=retirar', 3);}
				
				elseif ($metal <= $no_met_bank && $cristal <= $no_cris_bank && $deute <= $no_deu_bank){
				
						doquery("UPDATE {{table}} SET
							  	`bankm`= bankm - '". $metal ."',
                              	`bankc`= bankc - '". $cristal ."',
                              	`bankd`= bankd - '". $deute ."',
							  	`metal`= metal + '". $metal ."',
							  	`crystal`= crystal + '". $cristal ."',
							  	`deuterium`= deuterium + '". $deute ."'
                               	 WHERE `galaxy`='".$planetrow['galaxy']."'
                               	 AND `system` ='".$planetrow['system']."'
                               	 AND `planet` ='".$planetrow['planet']."'
                               	 AND `planet_type` ='".$planetrow['planet_type']."'
                               	 ",'planets');
				
						message ('Su extraccion ha sido realizada con exito!', 'game.php?page=banco&mode=retirar', 3);
				}
			
			}
			
		display(parsetemplate(gettemplate('banco_retirar'), $parse));
		break;
		
default:		
		display(parsetemplate(gettemplate('banco'), $parse));		
}
}
?>
