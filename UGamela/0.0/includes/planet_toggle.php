<?php // planet_toggle.php ::  Permite swithchear los planetas.

if(!defined('INSIDE')){ die("attemp hacking");}

/*
  Aqui se reconoce cuando el jugador selecciona otro planeta para cambiarlo
  con el $cp, se obtiene el id del planeta
*/

	if(isset($cp) && is_numeric($cp) && isset($re) && $re == 0)
	{ //Permite cambiar el planeta actual por el $cp
		//se comprueba que el planeta es de esa persona.
		$checking = doquery("SELECT * FROM {{table}} WHERE id='$cp' AND id_owner={$userrow['id']}","planets",true);
		//chequeamos
		if($checking){
			//establecemos el current_planet
			$userrow['current_planet'] = $cp;
			//y actualizamos la base de datos
			doquery("UPDATE {{table}} SET current_planet='$cp' WHERE id='{$userrow['id']}'","users");
			/*
			  En estos casos no hace falta volver a pedir el $userrow porque solo se hiso un cambio de planeta.
			  y esto solo ocurre cuando se cambia desde el pequeño combo box en la mayoria de las paginas
			*/
		}
		
	}

// Created by Perberos. All rights reversed (C) 2006
?>
