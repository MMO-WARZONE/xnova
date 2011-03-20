<?php
//version 1
if ( !defined('INSIDE') ) die(header("location:../"));

//REVISAR LAS QUERYS QUE SE HACEN EN LA PAGINA.

function ShowFleetSacPage($CurrentUser, $CurrentPlanet)
{
	global $resource, $pricelist, $reslist, $phpEx, $lang,$db,$displays,$users;

	//$parse		= $lang;

        $displays->assignContent('fleet/fleetACS_table');//, $parse)
        $fleetid 	= $_POST['fleetid'];

        //ComprobaciÃ³n de si es o no un nÃºmero el id de la flota.
	if (!is_numeric($fleetid) || empty($fleetid))
		exit(header("Location: game.".$phpEx."?page=fleet"));

        
        //Si no estÃ¡ vacÃ­o el campo "invitar usuario" procedemos
	if(isset($_POST['invited']) )
	{
                
                $added_user_id_mr=count($_POST['invited']);
                //Si las id de los usuarios aÃ±adidos es mayor que 0 (es decir, si se ha invitado a alguien)
		if($added_user_id_mr > 0)
		{
                        $aks = $db->query(
			"SELECT invited FROM {{table}} WHERE
			`fleet_id` = '" . $fleetid . "'", 'sac', true);
                        $array=explode(",",$aks["invited"]);
                        //Declaramos el nuevo grupo de ataque con el invitador, y los invitados
			$new_eingeladen_mr="";
                        foreach($_POST['invited'] as $id){
                            if(!in_array($id, $array)){
                                $not_yet_invited[]=$id;
                            }

                            $new_eingeladen_mr.=$id.",";
                        }
                        $new_eingeladen_mr=substr_replace($new_eingeladen_mr, '', -1);

                        //Actualizamos la base de datos poniendo en el campo `Ã¬nvited` el grupo invitado
			$db->query("UPDATE {{table}} SET `invited` = '".$new_eingeladen_mr."' WHERE fleet_id={$fleetid} ;",'sac');
                }/*else{
                        $db->query("UPDATE {{table}} SET `invited` = '' WHERE fleet_id={$fleetid} ;",'sac');
		}*/

                //Mandamos el mensaje al usuario/s invitado/s para que puedan proceder a mandar flota
		$invite_message = $lang['fl_player'] . $CurrentUser['username'] . $lang['fl_acs_invitation_message'];
		foreach($_POST['invited'] as $id){
                            if(is_array($not_yet_invited)){
                                if(in_array($id, $not_yet_invited)){
                                    $users->SendSimpleMessage ($id, $CurrentUser['id'], time(), 1, $CurrentUser['username'], $lang['fl_acs_invitation_title'], $invite_message);
                                }
                            }
                }
                exit;
        }elseif(isset($_POST['invited']) && empty($_POST['invited'])){
             $db->query("UPDATE {{table}} SET `invited` = '' WHERE fleet_id={$fleetid} ;",'sac');
             exit;
        }

        if(isset($_POST["sac_name"])){
              /*$aks = $db->query(
			"SELECT name FROM {{table}} WHERE
			`fleet_id` = '" . $fleetid . "'", 'sac', true);
              if($aks["name"]!=$_POST["sac_name"]){
                    $db->query("UPDATE {{table}} SET `name` = '{$_POST["sac_name"]}' WHERE fleet_id={$fleetid} ;",'sac');
              }*/
              echo "cambiado";
              exit;
        }
        //Imprimimos el id de la flota
        //echo $fleetid;

        //Seleccionamos la flota con el id anterior de la tabla de flotas
	$query = $db->query("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets');

        //Si no hay ninguna fila en la tabla de datos que corresponda con esa id nos devuelve a la pÃ¡gina de flotas inicial
	if (mysql_num_rows($query) != 1)
		exit(header("Location: game.".$phpEx."?page=fleet"));

        //Recogemos todos los datos obtenidos con $query en un array llamado $daten
	$daten = mysql_fetch_array($query);

        //Si la hora de salida de la flota es menor que la hora actual o que la hora final es menor que la hora actual
        //O si la flota estÃ¡ volviendo nos devuelve a la pÃ¡gina inicial de flotas.
	if ($daten['fleet_start_time'] < time() || $daten['fleet_end_time'] < time() || $daten['fleet_mess'] == 1)
	{	exit(header("Location: game.".$phpEx."?page=fleet"));}

        //Si no se ha enviado la flota
	if (!isset($_POST['send']))
	{
                //Seleccionamos el planeta del usuario actual
		SetSelectedPlanet($CurrentUser);

                //Realizamos querys para recoger todos los datos del planeta actual
                //Y para saber el numero de flotas enviadas
		$galaxyrow 		= $db->query("SELECT * FROM {{table}} WHERE `id_planet` = '".$CurrentPlanet['id']."';", 'galaxy', true);
		$maxfleet  		= $db->query("SELECT COUNT(fleet_owner) as ilosc FROM {{table}} WHERE fleet_owner='{$CurrentUser['id']}'", 'fleets', true);
		$maxfleet_count = $maxfleet["ilosc"];

                //Seleccionamos todos los datos de la flota (tabla 'fleets') en un array $fleet.
		$fleet = $db->query("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets', true);

                //Si la flota no pertenece a ningun grupo
		if (empty($fleet['fleet_group']))
		{
                        //Se establece el nombre del SAC mediante un nÃºmero aleatorio detrÃ¡s de las letras "SVN"
			$rand 			= mt_rand(100000, 999999999);
			$aks_code_mr 	= "SVN".$rand;
                        //Definimos "$aks_invited_mr" como el usuario que ha invitado al resto
			$aks_invited_mr = $CurrentUser['id'].','.$added_user_id_mr;

                        //Introducimos todos los datos del SAC en la tabla correspondiente
			$db->query(
			"INSERT INTO {{table}} SET
			`name` = '" . $aks_code_mr . "',
			`origen_id` = '" . $CurrentUser['id'] . "',
			`fleet_id` = '" . $fleetid . "',
			`time` = '" . $fleet['fleet_start_time'] . "',
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "',
			`system` = '" . $fleet['fleet_end_system'] . "',
			`planet` = '" . $fleet['fleet_end_planet'] . "',
			`type` = '" . $fleet['fleet_end_type'] . "',
			`accept` = '" . $aks_invited_mr . "'
			",'sac');

                        //Seleccionamos todos los datos en un array $aks
			$aks = $db->query(
			"SELECT * FROM {{table}} WHERE
			`name` = '" . $aks_code_mr . "' AND
			`origen_id` = '" . $CurrentUser['id'] . "' AND
			`fleet_id` = '" . $fleetid . "' AND
			`time` = '" . $fleet['fleet_start_time'] . "' AND
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
			`system` = '" . $fleet['fleet_end_system'] . "' AND
			`planet` = '" . $fleet['fleet_end_planet'] . "'
			", 'sac', true);

                        //print_r($aks);
                        $aks_madnessred = $db->query(
			"SELECT * FROM {{table}} WHERE
			`name` = '" . $aks_code_mr . "' AND
			`origen_id` = '" . $CurrentUser['id'] . "' AND
			`fleet_id` = '" . $fleetid . "' AND
			`time` = '" . $fleet['fleet_start_time'] . "' AND
			`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
			`system` = '" . $fleet['fleet_end_system'] . "' AND
			`planet` = '" . $fleet['fleet_end_planet'] . "'
			", 'sac');

                        //Actualizamos la tabla fleets con el id del grupo de la flota
                        $db->query(
			"UPDATE {{table}} SET
			fleet_group = '" . $aks['id'] . "',
                        fleet_mission = '2'   
			WHERE
			fleet_id = '" . $fleetid . "'", 'fleets');
		}
		else //Si la flota ya pertenece a un grupo
		{
                        //Seleccionamos los datos del sac que corresponden con la id del grupo de la flota.
                        $aks            = $db->query("SELECT * FROM {{table}} WHERE id = '" . $fleet['fleet_group'] . "'", 'sac');
			$aks_madnessred = $db->query("SELECT * FROM {{table}} WHERE id = '" . $fleet['fleet_group'] . "'", 'sac');

                        //Si hay mÃ¡s de una fila afectada por la query de $aks nos echan a la pagina de flotas principal
			if (mysql_num_rows($aks) != 1)
				exit(header("Location: game.".$phpEx."?page=fleet"));

                        //Redeclaramos la variable $aks con las filas afectadas por su query
			$aks = mysql_num_rows($aks);
		}

                //Declaramos los tipos de misiÃ³n (Atacar, transportar..)
		$missiontype = array(
				1 => $lang['type_mission'][1],
				2 => $lang['type_mission'][2],
				3 => $lang['type_mission'][3],
				4 => $lang['type_mission'][4],
				5 => $lang['type_mission'][5],
				6 => $lang['type_mission'][6],
				7 => $lang['type_mission'][7],
				8 => $lang['type_mission'][8],
				9 => $lang['type_mission'][9],
				15 => $lang['type_mission'][15],
				16 => $lang['type_mission'][16],
				17 => $lang['type_mission'][17],
				);

                //Array con velocidades..
		$speed = array(
				10 => 100,
				9 => 90,
				8 => 80,
				7 => 70,
				6 => 60,
				5 => 50,
				4 => 40,
				3 => 30,
				2 => 20,
				1 => 10,
		);

                //Datos de galaxia, sistema solar, posiciÃ³n planetaria, tipo de planeta o
                //misiÃ³n escogida.
		$galaxy 		= intval($_GET['galaxy']);
		$system 		= intval($_GET['system']);
		$planet 		= intval($_GET['planet']);
		$planettype 	= intval($_GET['planettype']);
		$target_mission = intval($_GET['target_mission']);

                //Si no hay galaxia escogida se pone la del planeta propio
		if (!$galaxy)
			$galaxy = $CurrentPlanet['galaxy'];
                //Si no hay sistema escogido se pone la del planeta propio
		if (!$system)
			$system = $CurrentPlanet['system'];
                //Si no hay planeta escogido se pone la del planeta propio
		if (!$planet)
			$planet = $CurrentPlanet['planet'];
                //Si no hay tipo de planeta escogido se pone la del planeta propio
		if (!$planettype)
			$planettype = $CurrentPlanet['planet_type'];

                //Slots de flota
		$ile 	= '' . (1 + $CurrentUser[$resource[108]]) + ($CurrentUser['rpg_commandant'] * 3) . '';

		$parse['ile']	= $ile;

                //Seleccionamos toda la informaciÃ³n de flotas que tengan como owner al propio usuario
		$fq = $db->query("SELECT * FROM {{table}} WHERE fleet_owner='$CurrentUser[id]' AND fleet_mission <> 10", "fleets");

                //Iniciamos un bucle con $f array de los resultados de $fq
		$i = 0;
		while ($f = mysql_fetch_array($fq))
		{
			$i++;

                        //Formamos la pÃ¡gina 1 de flotas.
			$page .= "<tr height=20><th>$i</th><th>";

			$page .= "<a title=\"\">{$missiontype[$f[fleet_mission]]}</a>";

                        //Si la hora de salida de la flota y la final es la misma -1 se pone un mensaje de flota regresando
			if (($f['fleet_start_time'] + 1) == $f['fleet_end_time'])
				$page .= " <a title=\"".$lang['fl_returning']."\">".$lang['fl_r']."</a>";

			$page .= "</th><th><a title=\"";

                        //Se separa la flota en sus naves
			$fleet = explode(";", $f['fleet_array']);
			$e = 0;
			foreach($fleet as $a => $b)
			{
                                //Si $b no es nulo
				if ($b != '')
				{
                                        //Incrementamos en 1 $e y en $a metemos los cÃ³digos de las naves (200, 201..)
					$e++;
					$a 		= explode(",", $b);
                                        //En la pÃ¡gina aÃ±adimos la nave y la cantidad que hay
					$page  .= "{$lang['tech']{$a[0]}}: {$a[1]}\n";
					if ($e > 1) // Si $e es mayor que 1 se hace una tabulaciÃ³n
						$page .= "\t";
				}
			}

                        //Damos formato a la cantidad de flota
			$page .= "\">" . pretty_number($f[fleet_amount]) . "</a></th>";
                        //Colocamos las coordenadas separadas por ":"
			$page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
			//Ponemos la fecha de salida en formato D M Y H:i:s
                        $page .= "<th>" . gmdate("d. M Y H:i:s", $f['fleet_start_time']) . "</th>";
                        //Coordenadas objetivo
			$page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
                        //Ponemos la fecha de llegada en el mismo formato anterior
			$page .= "<th>" . gmdate("d. M Y H:i:s", $f['fleet_end_time']) . "</th>";
			$page .= " </form>";
                        //Ponemos color al tiempo
			$page .= "<th><font color=\"lime\"><div id=\"time_0\"><font>" . pretty_time(floor($f['fleet_end_time'] + 1 - time())) . "</font></th><th>";

                        //Si la flota estÃ¡ yendo
			if ($f['fleet_mess'] == 0)
			{
                                //Ponemos pulsable el boton de volver la flota a casa
				$page .= "<form action=\"?page=fleetback\" method=\"post\">
				<input name=\"fleetid\" value=\"". $f['fleet_id'] ."\" type=\"hidden\">
				<input value=\"".$lang['fl_send_back']."\" type=\"submit\">
				</form></th>";
			}
			else //Si estÃ¡ volviendo no ponemos el boton de volver a casa
				$page .= "&nbsp;</th>";

                        //Terminamos el formato
			$page .= "</div></font></tr>";
		}

                //Si el valor de $i no se ha modificado ponemos guiones en el lugar de la flota
		if ($i == 0)
			$page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";

                //Mostramos la pÃ¡gina 1 de flotas
		$parse['page1']	= $page;

                //Si estÃ¡n todos los slots de flota ocupados lo ponemos en rojo
		if ($ile == $maxfleet_count)
			$maxflot = "<tr height=\"20\"><th colspan=\"9\"><font color=\"red\">".$lang['fl_no_more_slots']."</font></th></tr>";

                //Establecemos un bucle mientras $row contenga el array de los resultados de $aks_madnessred
		while($row = mysql_fetch_array($aks_madnessred))
		{
                        //Nombre del SAC
			$aks_code_mr  	= $row['name'];
                        //Miembros que han aceptado la invitacion
			$aks_invited_mr .= $row['invited'];
		}

                //Definimos las flotas enviadas y los miembros invitados (he modificado $row['accept'] por $row['invited']
                //tratando de corregir el problema de que los "invitados" no pueden enviar flota
		$parse['maxflot']		= $maxflot;
		$parse['aks_code_mr']	= $aks_code_mr;

                //Separamos los miembros por comas y los almacenamos en dimensiones del array diferentes
		$members = explode(",", $aks_invited_mr);
		/*foreach($members as $a => $b)
		{
                        //Cuando $b no sea nulo haremos
			if ($b != '')
			{
                                //Definimos una variable con los nombres de los invitados
				$member_qry_mr = $db->query("SELECT `username` FROM {{table}} WHERE `id` ='".$b."' ;",'users');

                                //$row serÃ¡ un array con los nombres de los invitados
                                while($row = mysql_fetch_array($member_qry_mr))
				{
                                        //Los aÃ±adimos a una "selecciÃ³n"
					$pageDos .= "<option>".$row['username']."</option>";
				}
			}
		}*/
                $member_qry_mr = $db->query("SELECT u.username,u.id FROM {{table}}users as u
                        LEFT JOIN  {{table}}buddy as b
                        ON ( u.id=b.sender AND  b.owner ='{$CurrentUser["id"]}')
                        OR ( u.id=b.owner  AND  b.sender='{$CurrentUser["id"]}')
                        WHERE (b.sender='{$CurrentUser["id"]}' OR b.owner='{$CurrentUser["id"]}')
                        OR (u.ally_id='{$CurrentUser["ally_id"]}' AND u.id!='{$CurrentUser["id"]}'); ",'');

                $pageDos="";                //$row serÃ¡ un array con los nombres de los invitados
                while($row = mysql_fetch_assoc($member_qry_mr))
                {
                        //Los aÃ±adimos a una "selecciÃ³n"
                        //REVISAR XDD $(this).clone().appendTo('#invited');$(this).remove();
                        if(!in_array($row['id'],$members)){
                            $pageDos  .= "<option value=".$row['id']." >".$row['username']."</option>";
                        }else{
                            $pageDos2 .= "<option value=".$row['id']." >".$row['username']."</option>";
                        }

                }
                
                //Mostramos la pÃ¡gina 2, la ID de la flota, los miembros imbitados y el mensaje de invitar usuario al SAC
		$parse['page2']			= $pageDos;
                $parse['page22']		= $pageDos2;
		$parse['fleetid']		= $_POST['fleetid'];
		$parse['aks_invited_mr']	= $aks_invited_mr;
		$parse['add_user_message_mr']	= $add_user_message_mr;

                //Si no estamos en el planeta actual nos devuelve a la pagina 1 de flotas
		if (!$CurrentPlanet)
			exit(header("Location: game.".$phpEx."?page=fleet"));

                //Vamos comprobando las naves
		foreach($reslist['fleet'] as $n => $i)
		{
                        //Siempre que las naves del planeta sean mayor que 0
			if ($CurrentPlanet[$resource[$i]] > 0)
			{
                                //Vamos comparando las naves con cada una y se pone la velocidad, dependiendo del motor usado
				if ($i == 202 or $i == 203 or $i == 204 or $i == 209 or $i == 210)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['combustion_tech']) * 0.1);
				if ($i == 205 or $i == 206 or $i == 208 or $i == 211)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['impulse_motor_tech']) * 0.2);
				if ($i == 207 or $i == 213 or $i == 214 or $i == 215 or $i == 216)
					$pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $CurrentUser['hyperspace_motor_tech']) * 0.3);

                                //Ponemos la pÃ¡gina 3 con toda la informaciÃ³n de la flota, pasada por referidos a otra pÃ¡gina.
				$page3 .= '<tr height="20">
				<th><a title="'. $lang[fl_fleet_speed]. ': ' . $pricelist[$i]['speed'] . '">' . $lang['tech'][$i] . '</a></th>
				<th>' . pretty_number($CurrentPlanet[$resource[$i]]) . '
				<input type="hidden" name="maxship' . $i . '" value="' . $CurrentPlanet[$resource[$i]] . '"/></th>

				<input type="hidden" name="consumption' . $i . '" value="' . $pricelist[$i]['consumption'] . '"/>

				<input type="hidden" name="speed' . $i . '" value="' . $pricelist[$i]['speed'] . '" />
				<input type="hidden" name="galaxy" value="' . $galaxy . '"/>

				<input type="hidden" name="system" value="' . $system . '"/>
				<input type="hidden" name="planet" value="' . $planet . '"/>
				<input type="hidden" name="planet_type" value="' . $planettype . '"/>
				<input type="hidden" name="mission" value="' . $target_mission . '"/>
				</th>
				<input type="hidden" name="capacity' . $i . '" value="' . $pricelist[$i]['capacity'] . '" />
				</th>';
				if ($i == 212) //si son satÃ©lites solares no ponemos nada
					$page3 .= '<th></th><th></th></tr>';
				else
				{
                                        //Si no son satÃ©lites ponemos el botÃ³n de mÃ¡ximo nÃºmero de naves
					$page3 .= '<th><a href="javascript:maxShip(\'ship' . $i . '\'); shortInfo();">'.$lang['fl_max'].'</a> </th>
					<th><input name="ship' . $i . '" size="10" value="0" onfocus="javascript:if(this.value == \'0\') this.value=\'\';" onblur="javascript:if(this.value == \'\') this.value=\'0\';" alt="' . $lang['tech'][$i] . $CurrentPlanet[$resource[$i]] . '"  onChange="shortInfo()" onKeyUp="shortInfo()"/></th>
					</tr>';
                                        //Variable cachondÃ­sima con el consumo de cada nave
					$aaaaaaa = $pricelist[$i]['consumption'];
				}
                                //Tenemos naves = Verdadero (Obvio(?))
				$have_ships = true;
			}
		}

                //Si no tenemos naves mostramos un mensaje que dice que no hay naves
		if (!$have_ships)
		{
			$page3 .= '<tr height="20">
			<th colspan="4">'.$lang['fl_no_ships'].'/th>
			</tr>
			<tr height="20">
			<th colspan="4">
			<input type="button" value="'.$lang['fl_continue'].'" enabled/></th>
			</tr>
			</table>
			</center>
			</form>';
		}
		else //si tenemos naves
		{
                        //Mostramos el boton de seleccionar todas o ninguna
			$page3 .= '
			<tr height="20">
			<th colspan="2"><a href="javascript:noShips();shortInfo();noResources();" >'.$lang['fl_remove_all_ships'].'</a></th>
			<th colspan="2"><a href="javascript:maxShips();shortInfo();" >'.$lang['fl_select_all_ships'].'</a></th>
			</tr>';

                        //Boton de continuar, claramente representado por el nombre de la variable
			$przydalej = '<tr height="20"><th colspan="4"><input type="submit" value="'.$lang['fl_continue'].'" /></th></tr>';
			//Si todos los slots estÃ¡n ocupados no aparece mensaje
                        if ($ile == $maxfleet_count)
				$przydalej = '';
                        //Vamos completando la pÃ¡gina 3 con el boton de continuar en el centro
			$page3 .= '
			' . $przydalej . '
			<tr><th colspan="4">
			<br><center></center><br>
			</th></tr>
			</table>
			</center>
			</form>';
		}

                //Mostramos la pÃ¡gina 3
		$parse['page3']	= $page3;
	}
        //Mostramos la pÃ¡gina
        foreach ($parse as $key => $value) {
            $displays->assign($key,$value);
        }
	$displays->display();

}
?>