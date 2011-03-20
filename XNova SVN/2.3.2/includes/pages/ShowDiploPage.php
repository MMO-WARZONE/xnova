<?php
//version 1
function ShowDiploPage($user){
    global $dpath, $phpEx, $lang,$_GET,$_POST;
		
	$parse['ally_name'] = $user['ally_name'];
	$parse['ally_id']   = $user['ally_id'];
		
	for($i=1;$i<=3;$i++){
	    $n2=$i;
	    if($n2==1){
                $mensajediplo="Alianza";
                $typen="1";
            }elseif($n2 ==2){
		$mensajediplo="No Agresion";
		$typen="2";
            }elseif($n2 ==3){
		$typen="3";
		$mensajediplo="Guerra";
            }
            $parse['bnd'] .= "<tr><td class=c colspan=3><b><u><center>".$mensajediplo."</center></b></u></td>
		</tr>";
			
            $query = $db->query("SELECT d.*,a.*
                            FROM {{table}}diplo as d INNER JOIN {{table}}alliance as a
                            ON (d.pact_ally_id = '". $user['ally_id'] ."'
			    AND d.type = '".$typen."' AND d.accept = '0' AND a.id=d.pact_owner)
			    OR (d.pact_owner = '". $user['ally_id'] ."' AND d.type = '".$typen."'
			    AND d.accept = '0' AND a.id=d.pact_ally_id)", "");
			
            while ($u = mysql_fetch_array($query)) {
		$parse['bnd'] .= "<tr><td class=b colspan=3><center><b><font color=lime>" .$u['ally_name'] . "</font></center></b></td></tr>";
            }	
	}
			     
	if(isset($_POST['type']) && isset($_POST['ally'])) {
	   
            if($_POST['type'] == "1") {//Alianza
               $type = "1"; 
	    } elseif ($_POST['type'] == "2") {//No Agresion
		$type = "2";
	    } elseif ($_POST['type'] == "3") {//Guerra
		$type = "3";
	    } else {
                message('<meta http-equiv="refresh" content="1; url=game.php?page=diplo">No a seleccionado tipo de pacto', 'Error');
	    }
	    $ally_id = $db->query("SELECT `id` FROM {{table}} WHERE `ally_name` = '". $_POST['ally'] ."'", "alliance");  
	    $id = mysql_fetch_array($ally_id);
	       
	    $db->query("INSERT INTO {{table}} SET
                    `pact_owner` = '". $user['ally_id'] ."',
		    `pact_ally` = '". $_POST['ally'] ."',
		    `type` = '". $type ."',
		    `accept` = '1',
		    `pact_ally_id` = '". $id['id'] ."'", "diplo");
				
            if($type==1){
                $tipo="una alianza a ";
	    }elseif($type==2){
                $tipo="un pacto de no agresion a ";
	    }elseif($type==3){
		$tipo="una guerrar a ";
	    }
	    message('Acabas de proponer '.$tipo.$_POST['ally'], 'game.php?page=diplo');
	
	}
			
			
			if(isset($_GET['add'])) {
			
				$ally = $db->query("SELECT a.id,a.ally_name,d.pact_ally_id,d.pact_owner FROM {{table}}alliance as a inner join {{table}}diplo as d ON a.id=d.pact_ally_id OR a.id=d.pact_owner", "");  
				$h = 0;
				while ($c = mysql_fetch_array($ally)) {
					if($user['ally_id']!=$c['id']){
						
							$parse['allys'] .= "<option>". $c['ally_name'] ."</option>";
						
					}
				$h++;
				}	   
				   
				$page = parsetemplate(gettemplate('alliance/alliance_diplo_add'), $parse);
				display($page);
			}
			     
			if(isset($_GET['anfragen'])) {
				
                                $accept = $db->query("SELECT d.pact_ally, d.pact_owner, d.pact_ally_id, d.type,a.ally_name
                                                  FROM {{table}}diplo as d,{{table}}alliance as a
                                                  WHERE d.pact_ally_id = '". $user['ally_id'] ."' AND d.accept = '1'
                                                  AND a.id=d.pact_owner", "");
				
				$h = 0;
				while ($c = mysql_fetch_array($accept)) {
					
					if($c['type']==1){
						$new="Alianza";
					}elseif($c['type']==2){
						$new="No Agresion";
					}elseif($c['type']==3){
						$new="Guerra";
					}
					$parse['accept'] .= "<tr><td class=b><b>". $c['ally_name'] ."</b> [".$new."] <a href=game.php?page=diplo&accept=". $c['pact_ally_id'] ."><img src='images/ok.jpg' width='13' height='13' title='Aceptar'/></a>
					<a href=game.php?page=diplo&denegar=". $c['pact_ally_id'] ."><img src='images/cerrar.gif' width='13' height='13' title='Negar'/></a></td></tr>";
					$h++;
				}
				 
				   
				$page = parsetemplate(gettemplate('alliance/alliance_diplo_anfragen'), $parse);
				display($page);
			}
			
			if(isset($_GET['accept'])) {
				$accept = $db->query("SELECT d.pact_ally, d.pact_owner, d.pact_ally_id, d.type,a.ally_name
                                                  FROM {{table}}diplo as d,{{table}}alliance as a
                                                  WHERE d.pact_ally_id = '". $user['ally_id'] ."' AND d.accept = '1'
                                                  AND a.id=d.pact_owner", "");
				$c = mysql_fetch_array($accept);
                                
				$db->query("UPDATE {{table}} SET `accept` = '0',`start_time`='".time()."' WHERE `pact_ally_id` = '". $_GET['accept'] ."' AND `type` =". $c['type'] ."", "diplo");  
				message ('Acabas de aceptar el tratado', 'game.php?page=diplo');
			}
			if(isset($_GET['denegar'])) {
				$accept = $db->query("SELECT d.pact_ally, d.pact_owner, d.pact_ally_id, d.type,a.ally_name
                                                  FROM {{table}}diplo as d,{{table}}alliance as a
                                                  WHERE d.pact_ally_id = '". $user['ally_id'] ."' AND d.accept = '1'
                                                  AND a.id=d.pact_owner", "");
				$c = mysql_fetch_array($accept);
                                
				$db->query("DELETE FROM {{table}} WHERE `pact_ally_id` = '". $_GET['denegar'] ."' AND `type` ='". $c['type'] ."'", "diplo");  
				message('Acabas de denegar tratado', 'game.php?page=diplo');
			
			}
				
			$ally_id = $db->query("SELECT `ally_owner` FROM {{table}} WHERE `id` = '". $user['ally_id'] ."'", "alliance");  
			$id = mysql_fetch_array($ally_id);
			
			if($user['id'] == $id['ally_owner']) {
				$parse['admin'] = "<tr><td class=c colspan=3><b><u><center>Administrador</b></u></td>
				</tr><tr>
				<td class=b colspan=1><b><a href=game.php?page=diplo&add=". $user['ally_id'] ."><center>Nueva Solicitud</a></td>
				<td class=b colspan=1><a href=game.php?page=diplo&anfragen=". $user['ally_id'] ."><center>Solicitudes</a></center></b></td>
				</tr>";
			} else {
				$parse['admin'] = "";
			}
		$page = parsetemplate(gettemplate('alliance/alliance_diplo'), $parse);
		display($page);
	}
?>