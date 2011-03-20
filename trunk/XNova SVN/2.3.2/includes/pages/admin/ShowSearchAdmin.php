<?php
//version 1.1
function ShowSearchAdmin($user){
	global $lang, $db, $displays;;
if ($user['authlevel'] < 2) die($displays->message($lang['not_enough_permissions']));


$displays->assignContent('adm/search');
    $id = intval($_GET['search']);
     if (isset($_GET['mode']))
     {
        global $reslist,$resource;
        $displays->newblock($_GET['mode']);
     	switch($_GET['mode'])
       	{
		case'resources':

                        $SelResources = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'planets', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelResources['id_owner'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');



	while ($u = mysql_fetch_array($SelColos))
	{
		$displays->newblock("lista_colos_resources");
		$i++;

                foreach($u as $key => $value){

                $displays->assign($key,$value);

	}

 }

			$mode      = $_POST['edit'];

                        $lang['id']          = $id;
                        $lang['name']        = $SelResources['name'];
			$lang['metal']       = pretty_number($SelResources['metal']);
			$lang['crystal']     = pretty_number($SelResources['crystal']);
			$lang['deuterium']   = pretty_number($SelResources['deuterium']);
			$lang['galaxy']      = $SelResources['galaxy'];
			$lang['system']      = $SelResources['system'];
			$lang['planet']      = $SelResources['planet'];


			if ($mode == 'addit')
			{
                                $accion      = $_POST['accion'];
				$metal       = $_POST['metal'];
				$cristal     = $_POST['cristal'];
				$deut        = $_POST['deut'];

                                if (is_numeric($accion.$metal)
                                 && is_numeric($accion.$cristal)
                                 && is_numeric($accion.$deut)){

                                        $QryUpdateResources  = "UPDATE {{table}} SET ";
                                        $QryUpdateResources .= "`metal` = `metal` ". $accion ." '". $metal ."', ";
                                        $QryUpdateResources .= "`crystal` = `crystal` ". $accion ." '". $cristal ."', ";
                                        $QryUpdateResources .= "`deuterium` = `deuterium` ". $accion ." '". $deut ."' ";
                                        $QryUpdateResources .= "WHERE ";
                                        $QryUpdateResources .= "`id` = '". $id ."' ";
                                        $db->query( $QryUpdateResources, "planets");

                                        $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=resources&search=".$id."",1);
                                }else{
                                        $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=resources&search=".$id."",1);
                                 }
                       }
		break;

		case'buildings':
                        $SelBuilds = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'planets', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelBuilds['id_owner'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');



	while ($u = mysql_fetch_array($SelColos))
	{
		$displays->newblock("lista_colos_buildings");
		$i++;

                foreach($u as $key => $value){

                $displays->assign($key,$value);

	}

 }



			$mode      = $_POST['edit'];

                        $lang['id']                     = $id;
                        $lang['name']                   = $SelBuilds['name'];
			$lang['galaxy']                 = $SelBuilds['galaxy'];
			$lang['system']                 = $SelBuilds['system'];
			$lang['planet']                 = $SelBuilds['planet'];


                        foreach ($reslist['build'] as $key) {
                            $displays->newblock("buildings_list");
                            $name=$resource[$key];

                            $displays->assign("count",pretty_number($SelBuilds[$name]));
                            $displays->assign("name",$name);
                            $displays->assign("name_lang",$lang['tech'][$key]);
                        }

			if ($mode == 'addit')
			{
                                extract($_POST);

                                if (is_numeric($accion."1")){

                                    $QryUpdateBuilds  = "UPDATE {{table}} SET ";
                                    foreach ($reslist['build'] as $key) {
                                        $name   = $resource[$key];
                                        $input  = $$name;
                                        if(is_numeric($accion.$input) && $input!=0){
                                           if($count_query==0){
                                                $QryUpdateBuilds .= "". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }else{
                                                $QryUpdateBuilds .= ", ". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }
                                             ++$count_query;                                        }

                                    }
                                    $QryUpdateBuilds .= "WHERE ";
                                    $QryUpdateBuilds .= "`id` = '". $id ."' ";

                                    $count_query!=0?$db->query( $QryUpdateBuilds, "planets"):"";

                                    $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=defenses&search=".$id."",2);
                                        }else{
                                    $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=defenses&search=".$id."",1);
                                }

			}
		break;

		case'ships':

                        $SelShips = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'planets', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelShips['id_owner'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');



                        while ($u = mysql_fetch_array($SelColos))
                        {
                                $displays->newblock("lista_colos_ships");
                                $i++;

                                foreach($u as $key => $value){

                                $displays->assign($key,$value);

                                }

                        }


			$mode      = $_POST['edit'];

                        $lang['id']                     = $id;
                        $lang['name']                   = $SelShips['name'];
			$lang['galaxy']                 = $SelShips['galaxy'];
			$lang['system']                 = $SelShips['system'];
			$lang['planet']                 = $SelShips['planet'];


                        foreach ($reslist['fleet'] as $key) {
                            $displays->newblock("ships_list");
                            $name=$resource[$key];

                            $displays->assign("count",pretty_number($SelShips[$name]));
                            $displays->assign("name",$name);
                            $displays->assign("name_lang",$lang['tech'][$key]);
                        }

			if ($mode == 'addit')
			{
                                extract($_POST);

                                if (is_numeric($accion."1")){

                                    $QryUpdateShips  = "UPDATE {{table}} SET ";
                                    foreach ($reslist['fleet'] as $key) {
                                        $name   = $resource[$key];
                                        $input  = $$name;
                                        if(is_numeric($accion.$input) && $input!=0){
                                           if($count_query==0){
                                                $QryUpdateShips .= "". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }else{
                                                $QryUpdateShips .= ", ". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }
                                             ++$count_query;
                                        }

                                    }
                                    $QryUpdateShips .= "WHERE ";
                                    $QryUpdateShips .= "`id` = '". $id ."' ";

                                    $count_query!=0?$db->query( $QryUpdateShips, "planets"):"";

                                    $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=ships&search=".$id."",2);
                                        }else{
                                    $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=ships&search=".$id."",1);
                                }

			}

		break;

		case'defenses':

                        $SelDefenses = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'planets', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelDefenses['id_owner'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');



	while ($u = mysql_fetch_array($SelColos))
	{
		$displays->newblock("lista_colos_defenses");
		$i++;

                foreach($u as $key => $value){

                $displays->assign($key,$value);

	}

 }


			$mode      = $_POST['edit'];

                        $lang['id']                     = $id;
                        $lang['name']                   = $SelDefenses['name'];
			$lang['galaxy']                 = $SelDefenses['galaxy'];
			$lang['system']                 = $SelDefenses['system'];
			$lang['planet']                 = $SelDefenses['planet'];


                        foreach ($reslist['defense'] as $key) {
                            $displays->newblock("defense_list");
                            $name=$resource[$key];

                            $displays->assign("count",pretty_number($SelDefenses[$name]));
                            $displays->assign("name",$name);
                            $displays->assign("name_lang",$lang['tech'][$key]);
                        }

			if ($mode == 'addit')
			{
                                extract($_POST);

                                if (is_numeric($accion."1")){

                                    $QryUpdateDefenses  = "UPDATE {{table}} SET ";
                                    foreach ($reslist['defense'] as $key) {
                                        $name   = $resource[$key];
                                        $input  = $$name;
                                        if(is_numeric($accion.$input) && $input!=0){
                                           if($count_query==0){
                                                $QryUpdateDefenses .= "". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }else{
                                                $QryUpdateDefenses .= ", ". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }
                                             ++$count_query;                                        }

                                    }
                                    $QryUpdateDefenses .= "WHERE ";
                                    $QryUpdateDefenses .= "`id` = '". $id ."' ";

                                    $count_query!=0?$db->query( $QryUpdateDefenses, "planets"):"";

                                    $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=defenses&search=".$id."",2);
                                        }else{
                                    $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=defenses&search=".$id."",1);
                                }

			}
		break;

		case'researchs':

                        $SelResearch = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'users', true);
			$mode      = $_POST['edit'];

                        $lang['id']                     = $id;
                        $lang['name']                   = $SelResearch['name'];

                        foreach ($reslist['tech'] as $key) {
                            $displays->newblock("research_list");
                            $name=$resource[$key];

                            $displays->assign("count",pretty_number($SelResearch[$name]));
                            $displays->assign("name",$name);
                            $displays->assign("name_lang",$lang['tech'][$key]);
                        }

			if ($mode == 'addit')
			{
                                extract($_POST);

                                if (is_numeric($accion."1")){

                                    $QryUpdateResearch  = "UPDATE {{table}} SET ";
                                    foreach ($reslist['build'] as $key) {
                                        $name   = $resource[$key];
                                        $input  = $$name;
                                        if(is_numeric($accion.$input) && $input!=0){
                                           if($count_query==0){
                                                $QryUpdateResearch .= "". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }else{
                                                $QryUpdateResearch .= ", ". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }
                                             ++$count_query;                                        }

                                    }
                                    $QryUpdateResearch .= "WHERE ";
                                    $QryUpdateResearch .= "`id` = '". $id ."' ";

                                    $count_query!=0?$db->query( $QryUpdateResearch, "planets"):"";

                                    $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=defenses&search=".$id."",2);
                                        }else{
                                    $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=defenses&search=".$id."",1);
                                }

			}

		break;

		case'oficers':

                        $SelOficer = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'users', true);
			$mode      = $_POST['edit'];

                        $lang['id']                     = $id;
                        $lang['name']                   = $SelOficer['name'];

                        foreach ($reslist['officier'] as $key) {
                            $displays->newblock("oficers_list");
                            $name=$resource[$key];

                            $displays->assign("count",pretty_number($SelOficer[$name]));
                            $displays->assign("name",$name);
                            $displays->assign("name_lang",$lang['tech'][$key]);
                        }

			if ($mode == 'addit')
			{
                                extract($_POST);

                                if (is_numeric($accion."1")){

                                    $QryUpdateOficer  = "UPDATE {{table}} SET ";
                                    foreach ($reslist['officier'] as $key) {
                                        $name   = $resource[$key];
                                        $input  = $$name;
                                        if(is_numeric($accion.$input) && $input!=0){
                                           if($count_query==0){
                                                $QryUpdateOficer .= "". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }else{
                                                $QryUpdateOficer .= ", ". $name ." = ". $name ." ". $accion ." '". $input ."' ";
                                             }
                                             ++$count_query;                                        }

                                    }
                                    $QryUpdateOficer .= "WHERE ";
                                    $QryUpdateOficer .= "`id` = '". $id ."' ";

                                    $count_query!=0?$db->query( $QryUpdateOficer, "planets"):"";

                                    $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=oficers&search=".$id."",2);
                                        }else{
                                    $displays->message ($lang['ad_numeric'],"admin.php?page=search&mode=oficers&search=".$id."",1);
                                }

			}

		break;

	        case 'planets':

                        $SelPlanet = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'planets', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelPlanet['id_owner'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');



	while ($u = mysql_fetch_array($SelColos))
	{
		$displays->newblock("lista_colos_planets");
		$i++;

                foreach($u as $key => $value){

                $displays->assign($key,$value);

	}

 }


			$mode      = $_POST['edit'];

                        $lang['id']               = $id;
       			$lang['name']             = ($SelPlanet['name']);
			$lang['diameter']         = pretty_number($SelPlanet['diameter']);
			$lang['field_max']        = pretty_number($SelPlanet['field_max']);
			$lang['galaxy']           = $SelPlanet['galaxy'];
			$lang['system']           = $SelPlanet['system'];
			$lang['planet']           = $SelPlanet['planet'];
			$lang['temp_min']         = ($SelPlanet['temp_min']);
			$lang['temp_max']         = ($SelPlanet['temp_max']);

                        If($SelPlanet['b_building_id'] == 0)
                        {
                        $lang['b_building_id']    = colorRed($lang['ad_empty']);
                        }
                        else
                        {
			$lang['b_building_id']    = $SelPlanet['b_building_id'];
                        }
                        if($SelPlanet['b_hangar_id'] == "")
                        {
                        $lang['b_hangar_id']      = colorRed($lang['ad_empty']);
                        }
                        else
                        {
			$lang['b_hangar_id']      = $SelPlanet['b_hangar_id'];
                        }
                        
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
                        {

	           	$name			= $_POST['name'];
		        $change_id		= $_POST['change_id'];
	           	$diameter		= $_POST['diameter'];
	             	$fields			= $_POST['fields'];
			$galaxy			= $_POST['g'];
		        $system			= $_POST['s'];
		        $planet			= $_POST['p'];
		        $t_min		        = $_POST['temp_min'];
		        $t_max		        = $_POST['temp_max'];
	               	$buildings		= $_POST['0_buildings'];
	                $ships			= $_POST['0_ships'];
	                $defenses		= $_POST['0_defenses'];
		        $c_hangar		= $_POST['0_c_hangar'];
		        $c_buildings	        = $_POST['0_c_buildings'];
		        $change_pos		= $_POST['change_position'];
		        $delete			= $_POST['delete'];
			$accion                 = $_POST['accion'];

   	                if ($delete != 'on')
			{

                           if ($name != NULL)
                           {
                       		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`name` =  '". $name ."' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }

                           if ($buildings == 'on'){

                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`metal_mine` =  '0', ";
                                $QryUpdatePlanet .= "`crystal_mine` =  '0', ";
                                $QryUpdatePlanet .= "`deuterium_sintetizer` =  '0', ";
                                $QryUpdatePlanet .= "`solar_plant` =  '0', ";
                                $QryUpdatePlanet .= "`fusion_plant` =  '0', ";
                                $QryUpdatePlanet .= "`robot_factory` =  '0', ";
                                $QryUpdatePlanet .= "`nano_factory` =  '0', ";
                                $QryUpdatePlanet .= "`hangar` =  '0', ";
                                $QryUpdatePlanet .= "`metal_store` =  '0', ";
                                $QryUpdatePlanet .= "`crystal_store` =  '0', ";
                                $QryUpdatePlanet .= "`deuterium_store` =  '0', ";
                                $QryUpdatePlanet .= "`laboratory` =  '0', ";
                                $QryUpdatePlanet .= "`terraformer` =  '0', ";
                                $QryUpdatePlanet .= "`ally_deposit` =  '0', ";
                                $QryUpdatePlanet .= "`silo` =  '0', ";
                                $QryUpdatePlanet .= "`mondbasis` =  '0', ";
                                $QryUpdatePlanet .= "`phalanx` =  '0', ";
                                $QryUpdatePlanet .= "`sprungtor` =  '0', ";
                                $QryUpdatePlanet .= "`last_jump_time` =  '0', ";
                                $QryUpdatePlanet .= "`field_current` =  '0' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }

				if ($ships == 'on')
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`small_ship_cargo` =  '0', ";
                                $QryUpdatePlanet .= "`big_ship_cargo` =  '0', ";
                                $QryUpdatePlanet .= "`light_hunter` =  '0', ";
                                $QryUpdatePlanet .= "`heavy_hunter` =  '0', ";
                                $QryUpdatePlanet .= "`crusher` =  '0', ";
                                $QryUpdatePlanet .= "`battle_ship` =  '0', ";
                                $QryUpdatePlanet .= "`colonizer` =  '0', ";
                                $QryUpdatePlanet .= "`recycler` =  '0', ";
                                $QryUpdatePlanet .= "`spy_sonde` =  '0', ";
                                $QryUpdatePlanet .= "`bomber_ship` =  '0', ";
                                $QryUpdatePlanet .= "`solar_satelit` =  '0', ";
                                $QryUpdatePlanet .= "`destructor` =  '0', ";
                                $QryUpdatePlanet .= "`dearth_star` =  '0', ";
                                $QryUpdatePlanet .= "`battleship` =  '0', ";
                                $QryUpdatePlanet .= "`supernova` =  '0' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                If ($defenses == 'on')
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`misil_launcher` =  '0', ";
                                $QryUpdatePlanet .= "`small_laser` =  '0', ";
                                $QryUpdatePlanet .= "`big_laser` =  '0', ";
                                $QryUpdatePlanet .= "`gauss_canyon` =  '0', ";
                                $QryUpdatePlanet .= "`ionic_canyon` =  '0', ";
                                $QryUpdatePlanet .= "`buster_canyon` =  '0', ";
                                $QryUpdatePlanet .= "`small_protection_shield` =  '0', ";
                                $QryUpdatePlanet .= "`planet_protector` =  '0', ";
                                $QryUpdatePlanet .= "`big_protection_shield` =  '0', ";
                                $QryUpdatePlanet .= "`interceptor_misil` =  '0', ";
                                $QryUpdatePlanet .= "`interceptor_misil` =  '0' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                if ($c_hangar == 'on')
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`b_hangar` =  '0', ";
                                $QryUpdatePlanet .= "`b_hangar_plus` =  '0', ";
                                $QryUpdatePlanet .= "`b_hangar_id` =  '' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                If ($c_buildings == 'on')
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`b_building` =  '0', ";
                                $QryUpdatePlanet .= "`b_building_id` =  '' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                if ($diameter != NULL && is_numeric($diameter) && $diameter > 0)
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`diameter` =  '".$diameter."' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                if ($fields != NULL && is_numeric($fields) && $fields > 0)
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`field_max` =  '".$fields."' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
				if ($t_min != NULL && is_numeric($t_min))
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`temp_min` =  '".$t_min."' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
				if ($t_max != NULL && is_numeric($t_max))
                                {
                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                $QryUpdatePlanet .= "`temp_max` =  '".$t_max."' ";
                                $QryUpdatePlanet .= "WHERE ";
                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                $db->query( $QryUpdatePlanet, "planets");
                                }
                                $P = $db->query("SELECT * FROM {{table}} WHERE `id` = '".$id."'", "planets", true);

                                if ($change_pos == 'on')
				{
				     if (is_numeric($galaxy) && is_numeric($system) && is_numeric($planet) && $galaxy > 0 && $system > 0 && $planet > 0 &&
				     $galaxy <= MAX_GALAXY_IN_WORLD && $system <= MAX_SYSTEM_IN_GALAXY && $planet <= MAX_PLANET_IN_SYSTEM)
				     {
				     $Queryyy = $db->query("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
											`planet` = '".$planet."'", "galaxy", true);

                                                        $PP       =       $db->query("SELECT * FROM {{table}} WHERE `id` = '".$P['id_owner']."'", "users", true);
							if ($P['planet_type'] == '1')
							{
								if (!$Queryyy)
								{
									if ($Queryyy['id_luna'] != '0')
									{
										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND `planet` = '".$P['planet']."' AND `planet_type` = '3'", "planets");
									}

                                                                        if ($PP['galaxy'] == $galaxy && $PP['system'] == $system && $PP['planet'] == $planet)
                                                                        {
                                                                        $db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id` = '".$P['id_owner']."'", "users");
                                                                        }

									$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id` = '".$id."'", "planets");

									$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id_planet` = '".$id."'", "galaxy");

									$Name	=	$lang['log_planet_pos'];
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets3'].'</font></th></tr>';
								}
							}
							elseif ($P['planet_type'] == '3')
							{
								if ($Queryyy)
								{
									if ($Queryyy['id_luna'] == '0')
									{
										$db->query ("UPDATE {{table}} SET `id_luna` = '0' WHERE `galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND
											`planet` = '".$P['planet']."'", "galaxy");

										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."',
										`id_luna` = '".$id."' WHERE `id_planet` = '".$Queryyy['id_planet']."'", "galaxy");

										$QMOON2	=	doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
										`planet` = '".$planet."'", "planets", true);

										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."',
										`id_owner` = '".$QMOON2['id_owner']."', `id_level` = '".$QMOON2['id_level']."' WHERE `id` = '".$id."' AND `planet_type` = '3'", "planets");
										$Name	=	$lang['log_moon_pos'];
									}
									else
									{
										$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets4'].'</font></th></tr>';
									}
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets5'].'</font></th></tr>';
								}
							}

							$Log	.=	$lang['log_change_pla_pos'].$Name.": [".$galaxy.":".$system.":".$planet."]\n";
						}
						else
						{
							$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
						}
					}

				}
				

				else
				{
					$QueryPlanetsS	=	$db->query("SELECT planet_type FROM {{table}} WHERE id = '".$id."'", "planets", true);
					if ($QueryPlanetsS['planet_type'] == '1')
					{
						$db->query("DELETE FROM {{table}} WHERE id = '".$id."'", "planets");
						$db->query("DELETE FROM {{table}} WHERE id_planet = '".$id."'", "galaxy");
					}
					else
					{
						$db->query("DELETE FROM {{table}} WHERE id = '".$id."'", "planets");
						$db->query("UPDATE {{table}} SET id_luna = '0', luna = '0' WHERE id_luna = '".$id."'", "galaxy");
					}

			// MENSAJE PLANETA BORRADO		$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_pla_delete_planet_s'].'</font></th></tr>';
				}


				$displays->message ($lang['ad_sucess'],"admin.php?page=editor&mode=planets&search=".$id."",1);


 	}

	        break;
	
	        case 'users':

                        $SelUser = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'users', true);
                        $SelColos  = $db->query("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelUser['id'] ."' ORDER BY `galaxy`, `system`, `planet` ASC;", 'planets');

                        while ($u = mysql_fetch_array($SelColos))
                            {
                                    $displays->newblock("lista_colos_users");
                                    $i++;

                            $u['activity'] = pretty_time(time() - $u['last_update']);
                            if ($u['planet_type'] == 1){
                            $u['type'] = "Planeta";
                            }
                            else{
                            $u['type'] = "Luna";
                            }
                                    foreach($u as $key => $value){

                                    $displays->assign($key,$value);
                            }
                     }
			$mode      = $_POST['edit'];

                        $lang['id']          = $id;
                        $lang['username']    = $SelUser['username'];
                        $lang['password']    = $SelUser['password'];
                        $lang['email']       = $SelUser['email'];
                        $lang['email2']      = $SelUser['email_2'];
                        $lang['ip_at_reg']   = $SelUser['ip_at_reg'];
                        $lang['register']    = date ( "G:i:s | d M y", $SelUser['register_time']);
                        $lang['lastlogin']   = date ( "G:i:s | d M y", $SelUser['user_lastlogin']);
                        $lang['user_lastip'] = $SelUser['user_lastip'];
                        $lang['dpath']       = $SelUser['dpath'];
                        $lang['authlevel_s']   = $lang['user_level'][$SelUser['authlevel']];
                       $lang["levels_".$SelUser['authlevel']]="selected='selected'";
                        
                        If ($SelUser['activate_status'] == 1){
                        $lang['activate']    = colorRed($lang['ad_activatenone']);}
                        Else{
                        $lang['activate']    = colorGreen($lang['ad_activateok']);}

                        If ($SelUser['design'] == 0){
                        $lang['design']      = colorRed($lang['ad_activatenone']);}
                        Else{
                        $lang['design']      = colorGreen($lang['ad_activateok']);}

                        If ($SelUser['noipcheck'] == 0){
                        $lang['noipcheck']   = colorRed($lang['ad_activatenone']);}
                        Else{
                        $lang['noipcheck']   = colorGreen($lang['ad_activateok']);}

                        If ($SelUser['urlaubs_modus'] == 0){
                        $lang['vacations']   = colorRed($lang['ad_activatenone']);}
                        Else{
                        $lang['vacations']   = colorGreen($lang['ad_activateok']);}

                        If ($SelUser['urlaubs_until'] == 0){
                        $lang['duration']    = colorRed($lang['ad_activatenone']);}
                        Else{
                        $lang['duration']    = date ( "d/m/Y G:i:s", $SelUser['urlaubs_until']);}

			if ($mode == 'addit')
		        {
	           		$username		= $_POST['username'];
		         	$password		= $_POST['password'];
	           		$email	                = $_POST['email'];
	             		$email2		        = $_POST['email2'];
	             		$activate		= $_POST['activate'];
	             		$dpath		        = $_POST['dpath'];
	             		$design		        = $_POST['design'];
	             		$noipcheck	        = $_POST['noipcheck'];
                                $authlevel              = $_POST['authlevel'];
	               		$vacations         	= $_POST['vacations'];
	               		$d         		= $_POST['d'];
	               		$h         		= $_POST['h'];

                                        $QueryUsers     = "UPDATE {{table}} SET ";
				if($username != NULL){
					$QueryUsers    .= "`username` = '".$username."', ";
					}
					
				if($password != NULL){
					$QueryUsers    .= "`password` = '".md5($password)."', ";
                                        }

				if($email != NULL){
					$QueryUsers    .= "`email` = '".$email."', ";
					}

				if($email_2 != NULL){
					$QueryUsers    .= "`email_2` = '".$email2."', ";
					}
					
				if($activate != ''){
					if ($activate == 'yes')
					{
					$QueryUsers    .= "`activate_status` = '1', ";
					}

					elseif ($activate == 'no')
					{
					$QueryUsers    .= "`activate_status` = '0', ";
					}
                                     }

				
				if($dpath != NULL){
					$QueryUsers    .= "`dpath` = '".$dpath."', ";
					}
					
				if($design != ''){
					if ($design == 'no')
					{
					$QueryUsers    .= "`design` = '0', ";
					}

					elseif ($design == 'yes')
					{
					$QueryUsers    .= "`design` = '1', ";
					}
                                     }
				if($noipcheck != ''){

					if ($noipcheck == 'no')
					{
					$QueryUsers    .= "`noipcheck` = '0', ";
					}

					elseif ($noipcheck == 'yes')
					{
					$QueryUsers    .= "`noipcheck` = '1', ";
					}
                                     }
				if($authlevel != NULL){
					$QueryUsers    .= "`authlevel` = '".$authlevel."', ";
					}

				if($vacations != '')
				{
					if ($vacations == 'no')
					{
						$Vacation   =    0;
						$TimeAns    =    0;
					}
					elseif ($vacations == 'yes')
					{
						$Vacation   =    1;
						$VTime      =    ($d * 86400)+($h * 3600);
						$TimeAns    =    $VTime + time();
					}

					$QueryUsers    .= "`urlaubs_modus` = '".$Vacation."', ";
                                        $QueryUsers    .= "`urlaubs_until` = '".$TimeAns."' ";
				}
				else {
					$QueryUsers    .= "`onlinetime` = '".time()."' ";
                                     }


					$QueryUsers    .= "WHERE ";
                                        $QueryUsers    .= "`id` = '".$id."' ";
					$db->query($QueryUsers, "users");

                                        $displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=users&search=".$id."",1);

  }

	        break;

        	case 'alliances':
                        //$id = $_GET['search'];
                        $SelAlly    = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $id ."';", 'alliance', true);
                        $SelOwner   = $db->query("SELECT * FROM {{table}} WHERE `id` = '". $SelAlly['ally_owner'] ."';", 'users', true);
	                $mode      = $_POST['edit'];
	                
       			$lang['ally_name']        = $SelAlly['ally_name'];
       			$lang['ally_tag']         = $SelAlly['ally_tag'];
       			$lang['ally_owner']       = $SelOwner['username'];
       			$lang['owner_range']      = $SelAlly['ally_owner_range'];
       			$lang['ally_web']         = $SelAlly['ally_web'];
       			$lang['ally_image']       = $SelAlly['ally_image'];
       			$lang['ally_description'] = $SelAlly['ally_description'];
       			$lang['ally_text']        = $SelAlly['ally_text'];
       			$lang['ally_request']     = $SelAlly['ally_request'];

                        $SelMembers = $db->query("SELECT * FROM {{table}} WHERE `ally_id` = '". $id ."';", 'users');

			if ($mode == 'addit')
		{
			$name			=	$_POST['name'];
			$tag			=	$_POST['tag'];
			$changeleader	        =	$_POST['changeleader'];
			$range                  =       $_POST['range'];
			$web			=	$_POST['web'];
			$image			=	$_POST['image'];
			$externo		=	$_POST['externo'];
			$interno		=	$_POST['interno'];
			$solicitud		=	$_POST['solicitud'];
			$delete			=	$_POST['delete'];
			$delete_u		=	$_POST['delete_u'];

			 	if ($SelAlly)
			 	{

                                        if ($range != NULL){
						$db->query("UPDATE {{table}} SET `ally_owner_range` = '".$range."' WHERE `id` = '".$id."'", "alliance");
                                                }

                                        if ($web != NULL){
						$db->query("UPDATE {{table}} SET `ally_web` = '".$web."' WHERE `id` = '".$id."'", "alliance");
                                                }

                                        if ($image != NULL){
						$db->query("UPDATE {{table}} SET `ally_image` = '".$image."' WHERE `id` = '".$id."'", "alliance");
                                                }

					if ($name != NULL){
						$db->query("UPDATE {{table}} SET `ally_name` = '".$name."' WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_name` = '".$name."' WHERE `ally_id` = '".$id."'", "users");
						}

					if ($tag != NULL){
						$db->query("UPDATE {{table}} SET `ally_tag` = '".$tag."' WHERE `id` = '".$id."'", "alliance");
						}


					$i	=	0;
					$QueryF2	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$changeleader."'", "users", true);
					if ($QueryF2 && $changeleader != NULL && $QueryF2['ally_id'] == $id){
						$db->query("UPDATE {{table}} SET `ally_owner` = '".$changeleader."' WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_rank_id` = '0' WHERE `id` = '".$changeleader."'", "users");
						}
					elseif (!$QueryF2 && $changeleader != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist3'].'</font></th></tr>';
						$i++;}

					if ($externo != NULL){
						$db->query("UPDATE {{table}} SET `ally_description` = '".$externo."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($interno != NULL){
						$db->query("UPDATE {{table}} SET `ally_text` = '".$interno."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($solicitud != NULL){
						$db->query("UPDATE {{table}} SET `ally_request` = '".$solicitud."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($delete == 'on'){
						$db->query("DELETE FROM {{table}} WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `ally_id` = '".$id."'", "users");
						}



					$QueryF3	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$delete_u."'", "users", true);
					if ($QueryF3 && $delete_u != NULL){
						$db->query("UPDATE {{table}} SET `ally_members` = ally_members - 1 WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `id` = '".$delete_u."' AND `ally_id` = '".$id."'", "users");
						}
					elseif (!$QueryF3 && $delete_u != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist2'].'</font></th></tr>';
						$i++;}

					if ($i == 0)
						$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_ally_succes'].'</font></th></tr>';
					else
						$parse['display']	=	$Error;

			 	}
			 	else
			 	{
                                        $displays->message ($lang['ad_ally_not_exist'],"admin.php?page=search&mode=alliances&search=".$id."",1);
			 	}

				$displays->message ($lang['ad_sucess'],"admin.php?page=search&mode=alliances&search=".$id."",1);

		}

		while($ba =  mysql_fetch_array($SelMembers)){
			$displays->newblock("members");
			$displays->assign("username",$ba['username']);
			$displays->assign("id",$ba['id']);
		}

                break;

                case'iplog':

                        $SelLog = $db->query("SELECT * FROM {{table}} WHERE (`userid` = '". mysql_escape_string($id) ."') OR (`username` = '". mysql_escape_string($id) ."') OR (`user_ip` = '". mysql_escape_string($search) ."') ORDER BY `Id`;", 'iplog');

	                $i 		= 0;

	                while ($u = mysql_fetch_array($SelLog))
	                {
                        $displays->newblock("lista_ip");
                        $i++;

                        $lang['id']          = $u['id'];
                        $lang['userid']      = $u['userid'];
			$lang['username']    = $u['username'];
			$lang['user_ip']     = $u['user_ip'];
			$lang['date']        = date ( "G:i:s | d M y", $u['date']);

                        foreach($lang as $key => $value){
                        $displays->assign($key,$value);
	                }
                 }

		break;

	}
	
     }else{
      $displays->newblock("default");
     }
      $displays->display();
}
?>