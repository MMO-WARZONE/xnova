<?php
/**
 *
 * @version 0.6 (by XafiloX)
 * @copyright 2008 by Tom1991 and XafiloX
 *----Modificado por XafiloX (misiles funcionales, además de optimizacion y centrar ataque en defensas) ----
 *
 * QUERRY NECESARIA PARA FUNCIONAMIENTO:  ////---  ALTER TABLE `dxgm_fleets` ADD `defensa_destino` SMALLINT NOT NULL DEFAULT '400' AFTER `fleet_array`   ---////
 *
 *Explicacion:  este es el archivo que se llamará desde FlyingFleetHandler.  En él se comprueba si el defensor tiene suficientes misiles de defensa como para parar los tuyos,
 * y sino llama al motor de los ataques con los misiles restantes.
 *DESCRIPCION: este es el motor de los ataques con misiles. Recibe el numero de misiles y la id del planeta adversario . Va eligiendo defensas aleatorias,
 *			y calcula la resistencia de ellas y se la resta a la potencia de ataque, restando en uno el numero de defensas de su tipo. Importante, funciona con las vars de
*			includes, para que no haya problemas con los posibles cambios de valores que hagamos en el futuro.
 */

 
function MipAttack ($CurrentFleet) {
global $pricelist, $lang;
includeLang('misiles');
includeLang('tech');


// Recup des variables
$Attaquant 		= $CurrentFleet['fleet_owner'];
$NbreMip   		= $CurrentFleet['fleet_amount'];
$Defensadestino	= $CurrentFleet['defensa_destino'];

//Datos del planeta de inicio (atacante)
$Galaxys    	= $CurrentFleet['fleet_start_galaxy'];  
$Systems    	= $CurrentFleet['fleet_start_system'];
$Planets    	= $CurrentFleet['fleet_start_planet'];
//Datos del planeta de destino (defensor)
$Galaxy    		= $CurrentFleet['fleet_end_galaxy'];
$System    		= $CurrentFleet['fleet_end_system'];
$Planet    		= $CurrentFleet['fleet_end_planet'];
$tipe =1;

$PlaneteAttaquant = doquery("SELECT * FROM {{table}} WHERE planet_type = " .$tipe . " AND galaxy = " . $Galaxys . " AND system = " . $Systems . " AND planet = " . $Planets . "", "planets", true);
$PlaneteAdverse   = doquery("SELECT * FROM {{table}} WHERE planet_type = " .$tipe . " AND galaxy = " . $Galaxy . " AND system = " . $System . " AND planet = " . $Planet . "", "planets", true);
doquery ( "DELETE FROM {{table}} WHERE `fleet_id` = '" . $CurrentFleet['fleet_id'] . "';", 'fleets' ); //IMPORTANTE: BORRAMOS LA FLOTA !!!!!!!!!!!!!!!!
$MipAttaquant = $PlaneteAttaquant['interplanetary_misil'];

$AntiMipAdverse = $PlaneteAdverse['interceptor_misil'];
$MipRestant     = $NbreMip - $AntiMipAdverse;
$AntiMipRestant = $AntiMipAdverse - $NbreMip;

if ($AntiMipRestant < 0) {
	$AntiMipRestant = 0;
}

//Creamos el texto con link a galaxia de las coordenadas del atacante y defensor
$planeta_atac = '<a href="galaxy.php?mode=3&galaxy=' . $Galaxys . '&system=' . $Systems . '&planet=' . $Planets .'">['. $Galaxys. ':' .$Systems. ':' .$Planets.']</a>';
$planeta_defe = '<a href="galaxy.php?mode=3&galaxy=' . $Galaxy . '&system=' . $System . '&planet=' . $Planet .'">['. $Galaxy. ':' .$System. ':' .$Planet.']</a>';

// El defensor destruye todos los misisles.
if ($MipRestant <= 0) {
    
    doquery("UPDATE {{table}} SET `interceptor_misil`='" . $AntiMipRestant . "' WHERE `id`='" . $PlaneteAdverse['id'] . "'", "planets");
    // Mensaje al atacante
    $Owner    = $Attaquant;
    $Sender   = "0";
    $Time     = time();
    $Type     = 3;
    $From     = $lang['cuartel'];
    $Subject  = $lang['reporte'];
    $Message  = $lang['misiles_repel'].$planeta_defe;
    SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);

    // Mensaje al defensor
    $Owner2   = $PlaneteAdverse['id_owner'];
    $Message2 = $lang['has_destru'] . $NbreMip . $lang['mis_destru']. $planeta_atac . " ".$lang['quedan']  . $AntiMipRestant .  $lang['mis_t_a'];
    SendSimpleMessage($Owner2, $Sender, $Time, $Type, $From, $Subject, $Message2);
	
}

if($MipRestant > 0){
	
    $TechnoArme = doquery("SELECT * FROM {{table}} WHERE `id`='" . $Attaquant . "'", "users", true);
    
    //$PuissanceAttaque = ($NbreMip * 12000) * (1.05 * $TechnoArme['military_tech']); ANTIGUA FORMULA
	$PuissanceAttaque = ($MipRestant * 30000) + (0.1 * $TechnoArme['military_tech']);
	$PuissanceAttaque2 = $PuissanceAttaque;

    $DefenseAdversaire = array(
		401 => ($PlaneteAdverse['misil_launcher']),
        402 => ($PlaneteAdverse['small_laser']),
        403 => ($PlaneteAdverse['big_laser']),
        404 => ($PlaneteAdverse['gauss_canyon']),
        405 => ($PlaneteAdverse['ionic_canyon']),
        406 => ($PlaneteAdverse['buster_canyon']),
        407 => ($PlaneteAdverse['small_protection_shield']),
        408 => ($PlaneteAdverse['big_protection_shield'])
	);
	$DefenseAdversaire2 = $DefenseAdversaire;
	
	$num_defensas= $DefenseAdversaire[401] + $DefenseAdversaire[402] +$DefenseAdversaire[403] +$DefenseAdversaire[404] +$DefenseAdversaire[405] +
		$DefenseAdversaire[406] +$DefenseAdversaire[407] +$DefenseAdversaire[408];
		
	//Comprobamos si tiene defensas
	if ($num_defensas <= 0 ) {
	doquery("UPDATE {{table}} SET `interceptor_misil`='0' WHERE `id`='" . $PlaneteAdverse['id'] . "'", "planets");
		//Mensaje al atacante de que no habia defensas que destruir
		$Owner    = $Attaquant;
		$Sender   = "0";
		$Time     = time();
		$Type     = 3;
		$From     = $lang['cuartel'];
		$Subject  = $lang['reporte'];
		$Message  = $lang['no_defensas'].$planeta_defe;
		SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);
		
		//Mensaje al defensor de que no habia defensas que le pudiesen destruir
		$Owner    = $PlaneteAdverse['id_owner'];
		$Message  = $lang['no_defensas_propias_1'].$planeta_atac.$lang['no_defensas_propias_2'];
		SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);
		
	} else {
		$ataque_destinado = (rand(35, 75))/100 * $PuissanceAttaque; //Calculamos el ataque destinado a una defensa en concreto elegida (entre un35% y un 75%)
		
	    while ($PuissanceAttaque > 20 && $num_defensas > 0 ) {
			//Seleccionamos la defensa a atacar
			//Defensa de destino, AUN POR HACER, es la defensa a la que va dirigido el ataque
			if($Defensadestino > 400 && $ataque_destinado > 0 && $DefenseAdversaire[$Defensadestino] > 0) {
				$RandomDefense =$Defensadestino;
			}else{
				$RandomDefense = rand(401, 408);  
				}
			
			$SelectionDefense = $DefenseAdversaire[$RandomDefense];
	        if ($SelectionDefense > 0) {  //Comprobamos que haya defensas de ese tipo construidas
			
				//Obtenemos la capacidad de aguante de la defensa, que es la suma del escudo y la de la estructura (que es a su vez, coste en acero mas silicio entre 10)
				$resistenciaDefensa = $CombatCaps[$RandomDefense]['shield'] + ($pricelist[$RandomDefense]['metal'] + $pricelist[$RandomDefense]['crystal'])/10;  //Obtenemos el escudo de la defensa
				
	            if ($PuissanceAttaque > $resistenciaDefensa) {
	                
	                $DefenseAdversaire[$RandomDefense]--;
					$num_defensas--;
					
	            }
				$PuissanceAttaque = $PuissanceAttaque - $resistenciaDefensa;
				$ataque_destinado = $ataque_destinado - $resistenciaDefensa;
				
			}
			
	    }

		//Actualizamos las defensas del defensor después del ataque...
	    $SqlDefenseur = "UPDATE {{table}} SET ";
		$SqlDefenseur .= "`interceptor_misil`='0', ";
	    $SqlDefenseur .= "`misil_launcher`='".$DefenseAdversaire[401]."', ";
		$SqlDefenseur .= "`small_laser`='".$DefenseAdversaire[402]."', ";
	    $SqlDefenseur .= "`big_laser`='".$DefenseAdversaire[403]."', ";
	    $SqlDefenseur .= "`gauss_canyon`='".$DefenseAdversaire[404]."', ";
	    $SqlDefenseur .= "`ionic_canyon`='".$DefenseAdversaire[405]."', ";
	    $SqlDefenseur .= "`buster_canyon`='".$DefenseAdversaire[406]."', ";
	    $SqlDefenseur .= "`small_protection_shield`='".$DefenseAdversaire[407]."', ";
	    $SqlDefenseur .= "`big_protection_shield`='".$DefenseAdversaire[408]."' ";
	    $SqlDefenseur .= " WHERE `id`='".$PlaneteAdverse['id']."'";

	    doquery($SqlDefenseur, 'planets');
		
		
				
		//Calculamos las defensas restadas
		$DefenseAdversaire2[401] = $DefenseAdversaire[401] - $DefenseAdversaire2[401];
		$DefenseAdversaire2[402] = $DefenseAdversaire[402] - $DefenseAdversaire2[402];
		$DefenseAdversaire2[403] = $DefenseAdversaire[403] - $DefenseAdversaire2[403];
		$DefenseAdversaire2[404] = $DefenseAdversaire[404] - $DefenseAdversaire2[404];
		$DefenseAdversaire2[405] = $DefenseAdversaire[405] - $DefenseAdversaire2[405];
		$DefenseAdversaire2[406] = $DefenseAdversaire[406] - $DefenseAdversaire2[406];
		$DefenseAdversaire2[407] = $DefenseAdversaire[407] - $DefenseAdversaire2[407];
		$DefenseAdversaire2[408] = $DefenseAdversaire[408] - $DefenseAdversaire2[408];
		
		//Si tenian un destino de defensas, preparamos el mensaje
		if ($Defensadestino > 400) {
		$lang_destino = "<b><br><br>".$lang['destino_misiles'].$lang['tech_rc'][$Defensadestino]."</b>";
		}
		
		// Mandamos un mensaje al atacante con las defensas destruidas
	    $Owner    = $Attaquant;
	    $Sender   = "0";
	    $Time     = time();
	    $Type     = 3;
	    $From     = $lang['cuartel'];
	    $Subject  = $lang['reporte'];
	    $Message  = $lang['report_atac_1'].$planeta_defe.$lang['report_atac_2']."<br><br>".$lang['tech_rc'][401]."--> ".$DefenseAdversaire2[401]."<br>".$lang['tech_rc'][402]."--> ".$DefenseAdversaire2[402]."<br>".$lang['tech_rc'][403]."--> ".$DefenseAdversaire2[403]
					."<br>".$lang['tech_rc'][404]."--> ".$DefenseAdversaire2[404]."<br>".$lang['tech_rc'][405]."--> ".$DefenseAdversaire2[405]."<br>".$lang['tech_rc'][406]."--> ".$DefenseAdversaire2[406]
					."<br>".$lang['tech_rc'][407]."--> ".$DefenseAdversaire2[407]."<br>".$lang['tech_rc'][408]."--> ".$DefenseAdversaire2[408].$lang_destino;
	    SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);

	    // Mandamos un mensaje al defensor con las defensas destruidas
	    $Owner2   = $PlaneteAdverse['id_owner'];
	    $Message2 = $lang['report_defen_1'].$planeta_atac."<br><br>".$lang['tech_rc'][401]."--> ".$DefenseAdversaire2[401]."<br>".$lang['tech_rc'][402]."--> ".$DefenseAdversaire2[402]."<br>".$lang['tech_rc'][403]."--> ".$DefenseAdversaire2[403]
					."<br>".$lang['tech_rc'][404]."--> ".$DefenseAdversaire2[404]."<br>".$lang['tech_rc'][405]."--> ".$DefenseAdversaire2[405]."<br>".$lang['tech_rc'][406]."--> ".$DefenseAdversaire2[406]
					."<br>".$lang['tech_rc'][407]."--> ".$DefenseAdversaire2[407]."<br>".$lang['tech_rc'][408]."--> ".$DefenseAdversaire2[408].$lang_destino;
	    SendSimpleMessage($Owner2, $Sender, $Time, $Type, $From, $Subject, $Message2);
		}
	}	
}

?>