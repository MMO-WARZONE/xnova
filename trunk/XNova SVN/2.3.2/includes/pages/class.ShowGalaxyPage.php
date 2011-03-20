<?php
//version 1.3


if(!defined('INSIDE')){ die(header("location:../../"));}

include_once($svn_root . 'includes/functions/classes/PadaGalaxy.' . $phpEx);
include_once("./includes/functions/classes/class.noobs.php");

class ShowGalaxyPages extends GalaxyPada
{

	public function ShowGalaxyPage($user,&$planetrow){

            global $phpEx,$resource,$displays,$db,$noobs;

            if($planetrow["deuterium"]<9000){
                $displays->message("No tienes suficientemente deuterio para viajar por la galaxia","Galaxia");
            }
            $planetrow["deuterium"]-=9000;
            $displays->assignContent('/galaxy/galaxy_body_new');
            $noobs= new proteccion_noob();

            $noobs->prin=$user["total_points"];

            $noobs->mission=1;
            
            
            $CurrentSystem = $planetrow['system'];
            $CurrentGalaxy = $planetrow['galaxy'];

            $MaxFleet = $db->query("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $user['id']."'", 'fleets');
            $MaxFleetCount = mysql_num_rows($MaxFleet);

            $this->FleetMax      = 1 + $user[$resource["108"]] + ($user[$resource["611"]] * 3);
            $this->CurrentMIP    = $planetrow['interplanetary_misil'];
            $this->CurrentRC     = $planetrow['recycler'];
            $this->CurrentSP     = $planetrow['spy_sonde'];
            $this->HavePhalanx   = $planetrow['phalanx'];

            $this->CurrentSystem = $planetrow['system'];
            $this->CurrentGalaxy = $planetrow['galaxy'];
            $this->CurrentPlanet = $planetrow['planet'];
            $this->CurrentPlanet_type = $planetrow['planet_type'];

            $this->CanDestroy    = $planetrow[$resource[213]] + $planetrow[$resource[214]];

            // USELESS YET, NEEDED FOR MIPS I THINK

            if($_POST OR $_GET['galaxy'] OR $_GET['system']){
                    if($_POST){
                            // PREVENT NO-NUMERIC VALUES
                            $_POST['galaxy'] = cleanNumeric($_POST['galaxy']);
                            $_POST['system'] = cleanNumeric($_POST['system']);


                            $system = $_POST['system'];
                            $galaxy = $_POST['galaxy'];

                            if($_POST['galaxyLeft']){
                                    $galaxy = $galaxy - 1;
                            }elseif($_POST['galaxyRight']){
                                    $galaxy = $galaxy + 1;
                            }
                            if($_POST['systemLeft']){
                                    $system = $system - 1;
                            }elseif($_POST['systemRight']){
                                    $system = $system + 1;
                            }
                    }else if($_GET){
                            $_GET['galaxy'] = cleanNumeric($_GET['galaxy']);
                            $_GET['system'] = cleanNumeric($_GET['system']);

                            $system = $_GET['system'];
                            $galaxy = $_GET['galaxy'];
                    }
                    if ($galaxy < 1 OR !$galaxy){
                    $galaxy = 1;
                    }
                    if ($galaxy > MAX_GALAXY_IN_WORLD){
                            $galaxy = MAX_GALAXY_IN_WORLD;
                    }
                    if ($system < 1 OR !$system){
                            $system = 1;
                    }
                    if ($system > MAX_SYSTEM_IN_GALAXY){
                            $system = MAX_SYSTEM_IN_GALAXY;
                    }
            }

            $position[galaxy] = (empty($galaxy)) ? $this->CurrentGalaxy : $galaxy;
            $position[system] = (empty($system)) ? $this->CurrentSystem : $system;
            $position[planet] = (empty($planet)) ? $this->CurrentPlanet : $planet;
            $position[planet_type] = (empty($planet_type)) ? $this->CurrentPlanet_type : $planet_type;


            // MOVEMENT BLOCK
            $displays->newBlock("movement");
            foreach($position as $name => $trans){
                    $displays->assign($name, $trans);
            }
            if($_GET["mode"]=="2"){
                    $displays->newBlock("misiles");
                    foreach($_GET as $name => $trans){
                            $displays->assign($name, $trans);
                    }
            }



            // SHORT DEFINITION
            $g = $position[galaxy];
            $s = $position[system];
            if(!$g || !$s){
                    header("location: game.php?page=overview");
            }
            // GALAXY TABLE BLOCK
            // PREPARE THE $galaxy:$system
            $lang['Solar_system_at'] = $lang['Solar_system'] . " ".$g.":".$s;

            // PLANET INFORMATION
            $sql = "SELECT
                                    l.temp_min, l.diameter, l.name as moon_name,
                                    g.*, g.metal as debris_metal, g.crystal as debris_crystal, g.planet as planetpos,
                                    p.*, p.name as planet_name,
                                    u.*,
                                    s.total_points, s.total_rank,
                                    a.ally_tag, a.ally_name, a.ally_web, a.ally_members
                            FROM {{table}}planets as p

                                    LEFT JOIN {{table}}galaxy as g ON g.id_planet = p.id
                                    LEFT JOIN {{table}}users as u ON u.id = p.id_owner
                                    LEFT JOIN {{table}}alliance as a ON a.id = u.ally_id
                                    LEFT JOIN {{table}}planets as l ON l.id = g.id_luna AND l.planet_type = 3
                                    LEFT JOIN {{table}}statpoints as s ON s.id_owner = u.id AND stat_type = 1 AND stat_code = 1

                            WHERE
                                    g.galaxy = $g AND g.system = $s
                            ORDER BY g.planet ASC";
            $rs = $db->query($sql, '');
            if($temprow = mysql_fetch_assoc($rs)){
                    do{
                            $planetsrow[$temprow[planetpos]] = $temprow;
                    }while($temprow = mysql_fetch_assoc($rs));
            }

            // PLANETS LIST BLOCK
            for($i = 1; $i <(1+(MAX_PLANET_IN_SYSTEM)); $i++){

                    $displays->newBlock("planets");
                    if($planetsrow[$i]){
                            // PLANET NUMER :/
                            $displays->assign("i", $i);
                            // PLANET IMAGE TOOLTIP
                            $planet = $this->_TooltipPlanet($planetsrow[$i], $g, $s, $i, 1);

                            $displays->assign("planet", $planet);

                            // MOON TOOLTIP
                            if($planetsrow[$i][id_luna]){
                                    $moon = $this->_TooltipMoon($planetsrow[$i], $g, $s, $i, 3);
                                    $displays->assign("moon", $moon);
                                    unset($moon);
                            }


                            // PLANET STATUS
                            $planet_status = $this->_TooltipPlanetStatus($planetsrow[$i], $g, $s, $i, 1);
                            $displays->assign("planet_status", $planet_status);

                            // DEBRIS FIELD
                            if($planetsrow[$i][debris_metal] > 0 OR $planetsrow[$i][debris_crystal] > 0){

                                    $debris = $this->_TooltipDebris($planetsrow[$i], $g, $s, $i, 2);

                                    $debristotal = round($planetsrow[$i][debris_metal] + $planetsrow[$i][debris_crystal]);
                                    if ($debristotal >= 100000) $debris_class = "debris_small";
                                    if ($debristotal >= 1000000) $debris_class = "debris_medium";
                                    if ($debristotal >= 10000000) $debris_class = "debris_large";

                                    $displays->assign("debris", $debris);
                                    $displays->assign("debris_class", $debris_class);
                            }

                            // USER INFO
                            $user_info = $this->_TooltipUser($planetsrow[$i], $g, $s, $i, 0);
                            $displays->assign("user_info", $user_info);

                            // ALLIANCE INFO
                            if($planetsrow[$i][ally_id]){
                                    $ally_info = $this->_TooltipAlliance($planetsrow[$i], $g, $s, $i, 0);
                                    $displays->assign("ally_info", $ally_info);
                            }

                            // ACTIONS
                            $actions = $this->_TooltipActions($planetsrow[$i], $g, $s, $i,0);
                            $displays->assign("actions", $actions);
                    }else{
                        $is="<a href=\"game.php?page=fleet&galaxy={$g}&system={$s}&planet={$i}&planettype=1&target_mission=7\">{$i}</a>";
                        $displays->assign("i", $is);
                    }
            }

            $replace[fleet_count] = $MaxFleetCount;
            $replace[fleet_max] = $this->FleetMax;
            $replace[Recyclers] = pretty_number($this->CurrentRC);
            $replace[SpyProbes] = pretty_number($this->CurrentSP);
            $replace[CurrentMIP] = pretty_number($this->CurrentMIP);
            $replace[this_galaxy] = $planetrow['galaxy'];
            $replace[this_system] = $planetrow['system'];
            $replace[this_planet] = $planetrow['planet'];
            $replace[this_planet_type] = $planetrow['planet_type'];
            $replace[PHP_SELF] = $_SERVER['PHP_SELF'];
            $replace[ajaxscript]=$this->InsertGalaxyScripts();

            $displays->gotoBlock("_ROOT");
            if(is_array($replace)){
                    foreach($replace as $k => $v){
                            $displays->assign($k, $v);
                    }
            }

            $displays->display('Galaxia');
	}
	private function InsertGalaxyScripts ()
	{
		$Script  = "";
		$Script .= "<script language=\"JavaScript\">\n";
		$Script .= "function galaxy_submit(value) {\n";
		$Script .= "	document.getElementById('auto').name = value;\n";
		$Script .= "	document.getElementById('galaxy_form').submit();\n";
		$Script .= "}\n\n";
		$Script .= "function fenster(target_url,win_name) {\n";
		$Script .= "	var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');\n";
		$Script .= "	new_win.focus();\n";
		$Script .= "}\n";
		$Script .= "</script>\n";
		$Script .= "<script language=\"JavaScript\" src=\"scripts/tw-sack.js\"></script>\n";
		$Script .= "<script type=\"text/javascript\">\n\n";
		$Script .= "var ajax = new sack();\n";
		$Script .= "var strInfo = \"\";\n";
		$Script .= "function whenResponse () {\n";
		$Script .= "	retVals   = this.response.split(\"|\");\n";
		$Script .= "	Message   = retVals[0];\n";
		$Script .= "	Infos     = retVals[1];\n";
		$Script .= "	retVals   = Infos.split(\" \");\n";
		$Script .= "	UsedSlots = retVals[0];\n";
		$Script .= "	SpyProbes = retVals[1];\n";
		$Script .= "	Recyclers = retVals[2];\n";
		$Script .= "	Missiles  = retVals[3];\n";
		$Script .= "	retVals   = Message.split(\";\");\n";
		$Script .= "	CmdCode   = retVals[0];\n";
		$Script .= "	strInfo   = retVals[1];\n";
		$Script .= "	addToTable(\"done\", \"success\");\n";
		$Script .= "	changeSlots( UsedSlots );\n";
		$Script .= "	setShips(\"probes\", SpyProbes );\n";
		$Script .= "	setShips(\"recyclers\", Recyclers );\n";
		$Script .= "	setShips(\"missiles\", Missiles );\n";
		$Script .= "}\n\n";
		$Script .= "function doit (order, galaxy, system, planet, planettype, shipcount) {\n";
		$Script .= "	ajax.requestFile = \"flotenajax.php?action=send\";\n";
		$Script .= "	ajax.runResponse = whenResponse;\n";
		$Script .= "	ajax.execute = true;\n\n";
		$Script .= "	ajax.setVar(\"thisgalaxy\", ". $this->CurrentGalaxy .");\n";
		$Script .= "	ajax.setVar(\"thissystem\", ". $this->CurrentSystem .");\n";
		$Script .= "	ajax.setVar(\"thisplanet\", ". $this->CurrentPlanet .");\n";
		$Script .= "	ajax.setVar(\"thisplanettype\", ". $this->CurrentPlanet_type .");\n";
		$Script .= "	ajax.setVar(\"mission\", order);\n";
		$Script .= "	ajax.setVar(\"galaxy\", galaxy);\n";
		$Script .= "	ajax.setVar(\"system\", system);\n";
		$Script .= "	ajax.setVar(\"planet\", planet);\n";
		$Script .= "	ajax.setVar(\"planettype\", planettype);\n";
		$Script .= "	if (order == 6)\n";
		$Script .= "		ajax.setVar(\"ship210\", shipcount);\n";
		$Script .= "	if (order == 7) {\n";
		$Script .= "		ajax.setVar(\"ship208\", 1);\n\n";
		$Script .= "		ajax.setVar(\"ship203\", 2);\n\n";
		$Script .= "	}\n";
		$Script .= "	if (order == 8)\n";
		$Script .= "		ajax.setVar(\"ship209\", shipcount);\n\n";
		$Script .= "	ajax.runAJAX();\n";
		$Script .= "}\n\n";
		$Script .= "function addToTable(strDataResult, strClass) {\n";
		$Script .= "	var e = document.getElementById('fleetstatusrow');\n";
		$Script .= "	var e2 = document.getElementById('fleetstatustable');\n";
		$Script .= "	e.style.display = '';\n";
		$Script .= "	if(e2.rows.length > 2) {\n";
		$Script .= "		e2.deleteRow(2);\n";
		$Script .= "	}\n";
		$Script .= "	var row = e2.insertRow(0);\n";
		$Script .= "	var td1 = document.createElement(\"th\");\n";
		$Script .= "	var td1text = document.createTextNode(strInfo);\n";
		$Script .= "	td1.appendChild(td1text);\n";
		$Script .= "	var td2 = document.createElement(\"th\");\n";
		$Script .= "	var span = document.createElement(\"span\");\n";
		$Script .= "	var spantext = document.createTextNode(strDataResult);\n";
		$Script .= "	var spanclass = document.createAttribute(\"class\");\n";
		$Script .= "	spanclass.nodeValue = strClass;\n";
		$Script .= "	span.setAttributeNode(spanclass);\n";
		$Script .= "	span.appendChild(spantext);\n";
		$Script .= "	td2.appendChild(span);\n";
		$Script .= "	row.appendChild(td1);\n";
		$Script .= "	row.appendChild(td2);\n";
		$Script .= "}\n\n";
		$Script .= "function changeSlots(slotsInUse) {\n";
		$Script .= "	var e = document.getElementById('slots');\n";
		$Script .= "	e.innerHTML = slotsInUse;\n";
		$Script .= "}\n\n";
		$Script .= "function setShips(ship, count) {\n";
		$Script .= "	var e = document.getElementById(ship);\n";
		$Script .= "	e.innerHTML = count;\n";
		$Script .= "}\n";
		$Script .= "</script>\n";

		//return $Script;
	}
}
?>