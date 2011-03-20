<?php
//version 2.3
if (!defined('INSIDE'))die(header("location:../../"));
class SAC {

    var $dateFleet=array();
    var $attArray=array();
    var $defArray=array();
    var $rondaArray=array();
    var $rondaArrayinfo=array();
    var $att=array();
    var $def=array();
    var $def_mater=array();



function infoUserAtt($num){
   // global $att;
    $this->att[$num]["user"]["defence_tech_user"]=((0.1*$this->att[$num]["user"]["defence_tech"])+(0.05 * $this->att[$num]["user"]["rpg_amiral"]));
    $this->att[$num]["user"]["shield_tech_user"]=(1+(0.1 * $this->att[$num]["user"]["shield_tech"])+ (0.05 * $this->att[$num]["user"]["rpg_amiral"]));
    $this->att[$num]["user"]["military_tech_user"]=(1+(0.1 * $this->att[$num]["user"]["military_tech"])+ (0.05 * $this->att[$num]["user"]["rpg_amiral"]));
}
function infoUserDef($num){
   // global $def;
    $this->def[$num]["user"]["defence_tech_user"]=((0.1*$this->def[$num]["user"]["defence_tech"])+(0.05 * $this->def[$num]["user"]["rpg_amiral"]));
    $this->def[$num]["user"]["shield_tech_user"]=(1+(0.1 * $this->def[$num]["user"]["shield_tech"])+ (0.05 * $this->def[$num]["user"]["rpg_amiral"]));
    $this->def[$num]["user"]["military_tech_user"]=(1+(0.1 * $this->def[$num]["user"]["military_tech"])+ (0.05 * $this->def[$num]["user"]["rpg_amiral"]));
}

function integridad($id,$count){
    global $pricelist;
    return ($pricelist[$id]["metal"]+$pricelist[$id]["crystal"])*$count;
}

function casco($integridad,$info){
    return ceil(($integridad*(0.1+$info["defence_tech_user"])));//;* (rand(80, 120) / 100));
}

function escudos($id,$count,$info){
    global $CombatCaps;
    if($info["shield_tech"]!=0){
        return ceil($CombatCaps[$id]["shield"] * $count* $info["shield_tech_user"]);//* (rand(80, 120) / 100)));
    }else{
        return 0;
    }
}

function DeleteFleet($casco,$type,$info){
    $cascoxunidad=$this->casco($this->integridad($type, "1"),$info);
    $Porcen=ceil($casco/$cascoxunidad);
    return $Porcen;
}

function ataque($id,$count,$info){
   global $CombatCaps;
   return ceil($CombatCaps[$id]["attack"] * $count * $info["military_tech_user"]);//* (rand(80, 120) / 100)));
}


function IniSim(){
    //global $att,$def,$attArray,$defArray,$rondaArray;
    foreach($this->att as $num => $attt){
        $this->infoUserAtt($num);
        foreach($attt as $a => $b){
            if($a=="fleet"){
                foreach($b as $id =>  $count){
                    $this->attArray[$num][$id]["integri"]=$this->integridad($id, $count);
                    $this->attArray[$num][$id]["casco"]=$this->casco($this->attArray[$num][$id]["integri"], $this->att[$num]["user"]);
                    $this->attArray[$num][$id]["Origincasco"]=$this->casco($this->attArray[$num][$id]["integri"], $this->att[$num]["user"]);
                    $this->attArray[$num][$id]["escudos"]=$this->escudos($id, $count,$this->att[$num]["user"]);
                    $this->attArray[$num][$id]["ataque"]=$this->ataque($id, $count,$this->att[$num]["user"]);
                    $this->attArray[$num][$id]["count"]=$count;

                }
                $this->rondaArray["1"]["att"][$num]=$this->attArray[$num];
            }
        }
    }
    foreach($this->def as $num => $deff){
        $this->infoUserDef($num);
        foreach($deff as $a => $b){
            if($a=="fleet"){
                foreach($b as $id => $count){
                    $this->defArray[$num][$id]["integri"]=$this->integridad($id, $count);
                    $this->defArray[$num][$id]["casco"]=$this->casco($this->defArray[$num][$id]["integri"],$this->def[$num]["user"]);
                    $this->defArray[$num][$id]["Origincasco"]=$this->casco($this->defArray[$num][$id]["integri"],$this->def[$num]["user"]);
                    $this->defArray[$num][$id]["escudos"]=$this->escudos($id, $count, $this->def[$num]["user"]);
                    $this->defArray[$num][$id]["ataque"]=$this->ataque($id, $count, $this->def[$num]["user"]);
                    $this->defArray[$num][$id]["count"]=$count;
                }
                $this->rondaArray["1"]["def"][$num]=$this->defArray[$num];
            }
        }
    }
}

function ExploteFleet($casco,$new){
    $cascoNew=$casco-$new;
    $porce=$cascoNew/$casco*100;
    return $porce;
}

function ronda($Ronda){
    //global $attArray,$defArray,$att,$def,$rondaArrayinfo;
    $count_def=count($this->defArray);
    $count_att=count($this->attArray);
    for($i=1;$i<=$count_att;$i++){
        if(empty($this->attArray[$i])){
            $count_att--;
        }
    }
    for($i=1;$i<=$count_def;$i++){
        if(empty($this->defArray[$i])){
            $count_def--;
        }
    }
    
    foreach($this->attArray as $num => $attt){
        if(!empty($attt)){
            foreach($attt as $Type_att => $b){
                $PotenciaSendAtt+=$this->attArray[$num][$Type_att]["ataque"];
                foreach($this->defArray as $nums => $deff){
                    $PotenciaAtt = $this->attArray[$num][$Type_att]["ataque"]/$count_def;
                    $true=0;
                    foreach($deff as $Type_def => $b){
                        if($PotenciaRestantAtt<0 && $true==1){
                            continue;
                        }elseif($PotenciaRestantAtt>0 && $true==1){
                            $PotenciaAtt=$PotenciaRestantAtt;
                        }

                        $EscudosSendAtt+=$this->defArray[$nums][$Type_def]["escudos"];
                        
                        if($PotenciaAtt > $this->defArray[$nums][$Type_def]["escudos"]){
                            //$PotenciaTotalAtt = $PotenciaAtt - $defArray[$nums][$Type_def]["escudos"];
                            $PotenciaAtt -= $this->defArray[$nums][$Type_def]["escudos"];//EDIT
                            $this->defArray[$nums][$Type_def]["escudos"]= 0;
                            //$defArray[$nums][$Type_def]["casco"]-=$PotenciaTotalAtt;
                            if($PotenciaAtt>$this->defArray[$nums][$Type_def]["casco"]){
                                $PotenciaAtt-=$this->defArray[$nums][$Type_def]["casco"];//EDIT
                                $this->defArray[$nums][$Type_def]["casco"]=0;
                            }else{
                                $this->defArray[$nums][$Type_def]["casco"]-=$PotenciaAtt;//EDIT
                                $PotenciaAtt=0;
                            }
                            $Count=$this->DeleteFleet($this->defArray[$nums][$Type_def]["casco"],$Type_def,$this->def[$nums]["user"]);
                            //ExploteFleet($defArray[$num][$Type_def]["Origincasco"],$defArray[$num][$Type_def]["casco"]);//REVISAR USO
                            $Count=$this->defArray[$nums][$Type_def]["count"]-$Count;
                            if($Count>$this->defArray[$nums][$Type_def]["count"]){
                                $this->defArray[$nums][$Type_def]["count"]=0;
                            }else{
                                $this->defArray[$nums][$Type_def]["count"]-=$Count;
                            }

                        } else {
                            $this->defArray[$nums][$Type_def]["escudos"] -= $PotenciaAtt;
                            //$PotenciaTotalAtt = 0;
                            $PotenciaAtt = 0;

                        }
                        $true=1;
                        $PotenciaRestantAtt=$PotenciaAtt;

                    }
                }
                $this->rondaArrayinfo[$Ronda]["att"]["ataquetotal"]=$PotenciaSendAtt;
                $this->rondaArrayinfo[$Ronda]["att"]["escudototal"]=$EscudosSendAtt;
            }
        }
    }
   
    foreach($this->defArray as $num => $deff){
        if(!empty($deff)){
            foreach($deff as $Type_def => $b){
                $PotenciaSendDef+=$this->defArray[$num][$Type_def]["ataque"];
                foreach($this->attArray as $nums => $attt){
                    $PotenciaAtt = $this->defArray[$num][$Type_def]["ataque"]/$count_att;
                    $true=0;
                    foreach($attt as $Type_att => $b){
                        if($PotenciaRestantDef<0 && $true==1){
                            continue;
                        }elseif($PotenciaRestantDef>0 && $true==1){
                            $PotenciaAtt=$PotenciaRestantDef;
                        }
                        $EscudosSendDef+=$this->attArray[$nums][$Type_att]["escudos"];
                        if($PotenciaAtt > $this->attArray[$nums][$Type_att]["escudos"]){
                            $PotenciaAtt -= $this->attArray[$nums][$Type_att]["escudos"];//EDIT
                            $this->attArray[$nums][$Type_att]["escudos"]= 0;
                            if($PotenciaAtt>$this->attArray[$nums][$Type_att]["casco"]){
                                $PotenciaAtt-=$this->attArray[$nums][$Type_att]["casco"];//EDIT
                                $this->attArray[$nums][$Type_att]["casco"]=0;
                            }else{
                                $this->attArray[$nums][$Type_att]["casco"]-=$PotenciaAtt;//EDIT
                                $PotenciaAtt=0;
                            }
                            $Count=$this->DeleteFleet($this->attArray[$nums][$Type_att]["casco"],$Type_att,$this->att[$nums]["user"]);
                            //ExploteFleet($attArray[$num][$Type_att]["Origincasco"],$attArray[$num][$Type_att]["casco"]);//REVISAR USO
                            $Count=$this->attArray[$nums][$Type_att]["count"]-$Count;
                            if($Count>$this->attArray[$nums][$Type_att]["count"]){
                                $this->attArray[$nums][$Type_att]["count"]=0;
                            }else{
                                $this->attArray[$nums][$Type_att]["count"]-=$Count;
                            }
                        }else{
                            $this->attArray[$nums][$Type_att]["escudos"] -= $PotenciaAtt;
                            $PotenciaAtt=0;
                        }
                        $true=1;
                        $PotenciaRestantDef=$PotenciaAtt;

                    }
                }
                $this->rondaArrayinfo[$Ronda]["def"]["ataquetotal"]=$PotenciaSendDef;
                $this->rondaArrayinfo[$Ronda]["def"]["escudototal"]=$EscudosSendDef;
            }
        }
    }
    $this->ResetRonda($Ronda);

}
function ResetRonda($Ronda){
    foreach($this->attArray as $nums => $atts){
        foreach($atts as $id =>  $count){
            if($count["count"]<=0){
                unset($this->attArray[$nums][$id]);
            }else{
                $this->attArray[$nums][$id]["escudos"]=$this->escudos($id, $count["count"],$this->att[$nums]["user"]);
                $this->attArray[$nums][$id]["ataque"]=$this->ataque($id, $count["count"],$this->att[$nums]["user"]);
            }
        }
        $this->rondaArray[$Ronda]["att"][$nums]=$this->attArray[$nums];
    }

    foreach($this->defArray as $num => $deff){
        foreach($deff as $id => $count){
            if($count["count"]<=0){
                unset($this->defArray[$num][$id]);
            }else{
                $this->defArray[$num][$id]["escudos"]=$this->escudos($id, $count["count"], $this->def[$num]["user"]);
                $this->defArray[$num][$id]["ataque"]=$this->ataque($id, $count["count"], $this->def[$num]["user"]);
            }
        }
        $this->rondaArray[$Ronda]["def"][$num]=$this->defArray[$num];
    }

}

function formaterw(){
    //global $att,$def,$rondaArrayinfo;
    global $lang;
    $html= "<center>";
    foreach($this->rondaArray as $num_ronda => $array){
       $html.="<table border=1 width=100%>
                    <tr>
                        <th colspan=10>Ronda {$num_ronda}</th>
                    </tr>";
        foreach($array as $Type_person => $arrays){
            $num_div=count($this->rondaArray[$num_ronda][$Type_person]);
            $name="";
            $flee="";
            for($i=1;$i<=$num_div;$i++){
                $div=10/$num_div;
                $name.="<th colspan={$div}>";
                if($Type_person=="att"){
                    $name.="Atacante ";
                }else{
                    $name.="Defensor ";
                }

                $person=$this->$Type_person;
                $name.="{$person[$i]["user"]["username"]}<br />Armas: ".($person[$i]["user"]["military_tech"]*10)."% Escudo: ". ($person[$i]["user"]["shield_tech"]*10) ."% Blindaje: ".($person[$i]["user"]["defence_tech"]*10)."%";
                $name.="</th>";
                $flee.="<th colspan={$div}>\n<center><table border=1 >";
                if(!empty($this->rondaArray[$num_ronda][$Type_person][$i])){
                    $echo_tipo  ="<tr><th>Tipo</th>";
                    $echo_count ="<tr><th>Cantidad</th>";
                    $echo_attack="<tr><th>Armas</th>";
                    $echo_shield="<tr><th>Escudos</th>";
                    $echo_defense="<tr><th>Casco</th>";
                    foreach($this->rondaArray[$num_ronda][$Type_person][$i] as $type => $array_fleet){
                        $echo_tipo      .="<th>[ship[".$type."]]</th>\n";
                        $echo_count     .="<th>".number_format($array_fleet["count"], 0, "", ".")."</th>\n";
                        $echo_attack    .="<th>".number_format($array_fleet["ataque"],0, "", ".")."</th>\n";
                        $echo_shield    .="<th>".number_format($array_fleet["escudos"],0,"", ".")."</th>\n";
                        $echo_defense   .="<th>".number_format($array_fleet["casco"], 0, "", ".")."</th>\n";
                    }
                    $flee.= $echo_tipo."</tr>";
                    $flee.= $echo_count."</tr>";
                    $flee.= $echo_attack."</tr>";
                    $flee.= $echo_shield."</tr>";
                    $flee.= $echo_defense."</tr>";
                }else{
                    $flee.="<tr><th colspan={$div}>DESTRUIDO</th></tr>";
                }
                $flee.="</table></center></th>";
            }
            $html.= "<tr>";
            $html.= $name;
            $html.= "</tr><tr>";
            $html.= $flee;
            $html.= "</tr>";
            }

        $html.= "</table>";
        //if()
        if(is_array($this->rondaArrayinfo[$num_ronda+1])){
            $html.= "La flota atacante dispara con una fuerza total de ";
            $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["att"]["ataquetotal"], 0, "", ".");
            $html.= " sobre el defensor. Los escudos del defensor absorven ";
            if($this->rondaArrayinfo[$num_ronda+1]["att"]["ataquetotal"]>$this->rondaArrayinfo[$num_ronda+1]["att"]["escudototal"]){
               $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["att"]["escudototal"], 0, "", ".");
            }else{
                $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["att"]["ataquetotal"], 0, "", ".");
            }
            $html.= " puntos de daño.<br> La flota defensora dispara con una fuerza total de ";
            $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["def"]["ataquetotal"], 0, "", ".");
            $html.= " sobre el atacante. Los escudos del atacante absorven ";
           
            if($this->rondaArrayinfo[$num_ronda+1]["def"]["ataquetotal"]>$this->rondaArrayinfo[$num_ronda+1]["def"]["escudototal"]){
                $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["def"]["escudototal"], 0, "", ".");
            }else{
                $html.= number_format($this->rondaArrayinfo[$num_ronda+1]["def"]["ataquetotal"], 0, "", ".");
            }
           $html.= " puntos de daño.";
        }

    }
      $FleetDebris= $this->escombro["metal"]+$this->escombro["crystal"];
      $StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], pretty_number (($this->escombro[att]["metal"]+$this->escombro[att]["crystal"])));
      $StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], pretty_number (($this->escombro[def]["metal"]+$this->escombro[def]["crystal"])));
      $StrRuins         = sprintf ($lang['sys_gcdrunits'], pretty_number ($this->escombro["metal"]), $lang['metal'], pretty_number ($this->escombro["crystal"]), $lang['crystal']);
      $DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
      $MoonChance       = $FleetDebris / 100000;
      //LUNAA CREACION DE LUNA
      if ($MoonChance > 20) {
            $MoonChance = 20;
      }elseif($MoonChance < 1){
            $MoonChance = 0;
      }

      $UserChance  = mt_rand(1, 100);//mt_rand(1, 100);

      $ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);

      //if (($UserChance > 0) && ($UserChance >= $MoonChance)){
      
      if (($MoonChance > 0) && ($UserChance < $MoonChance) && ($this->dateFleet['id_luna'] == 0)){
            $TargetPlanetName = CreateOneMoonRecord($this->dateFleet['galaxy'], $this->dateFleet['system'], $this->dateFleet['planet'],  $this->def["user"]["id"], '', $MoonChance);
            $GottenMoon = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $this->dateFleet['galaxy'], $this->dateFleet['system'], $this->dateFleet['planet']);
      }else{//if ($UserChance = 0 or $UserChance > $MoonChance){
            $GottenMoon = "";
      }
        //FIN LUNAA CREACION DE LUNA
        switch ($this->win)
        {
                case "1":
                        $Pillage = sprintf ($lang['sys_stealed_ressources'], pretty_number ($this->robado["metal"]), "metal", pretty_number ($this->robado["crystal"]), "cristal", pretty_number ($this->robado["deuterio"]), "deuterio");
                        $html .= $lang['sys_attacker_won'] . $Pillage . "<br />";
                        $html .= $DebrisField . "<br />";
                        $html .= $ChanceMoon . "<br />";
                        $html .= $GottenMoon . "<br />";
                break;
                case "0":
                        $html .= $lang['sys_both_won'] . "<br />";
                        $html .= $DebrisField . "<br />";
                        $html .= $ChanceMoon . "<br />";
                        $html .= $GottenMoon . "<br />";
                break;
                case "2":
                        $html .= $lang['sys_defender_won'] . "<br />";
                        $html .= $DebrisField . "<br />";
                        $html .= $ChanceMoon . "<br />";
                        $html .= $GottenMoon . "<br />";

                        //$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '" . $FleetRow["fleet_id"] . "';", 'fleets');
                break;
        }



    $html.= "</center>";
    return $html;
}


function flota_destruida(){

    global $pricelist;//$rondaArray,$pricelist;
        $num_div=count($this->rondaArray[1]["att"]);

        $num_ronda=count($this->rondaArray);
        for($i=1;$i<=$num_div;$i++){
           //if(!empty($this->rondaArray)){continue;}

            foreach($this->rondaArray[1]["att"][$i] as $type => $array_fleet){
                if(empty($this->rondaArray[$num_ronda]["att"][$i][$type])){
                    $delete["att"][$i][$type]=$array_fleet["count"];
                }else{
                    $delete["att"][$i][$type]=$array_fleet["count"]-$this->rondaArray[$num_ronda]["att"][$i][$type][count];
                }
                $this->escombro["metal"]  += ($pricelist[$type]['metal'] * $delete["att"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                $this->escombro["crystal"]+= ($pricelist[$type]['crystal'] * $delete["att"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                $this->escombro[att]["metal"]  += ($pricelist[$type]['metal'] * $delete["att"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                $this->escombro[att]["crystal"]+= ($pricelist[$type]['crystal'] * $delete["att"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);


                $atacante_vive[$i][$type] = $array_fleet["count"]-$delete["att"][$i][$type];
                if($atacante_vive[$i][$type]<0){
                    $atacante_vive[$i][$type]=0;
                }
                
            }
            $this->SQL_atacant($atacante_vive[$i],$i);
        }
       
        $num_div=count($this->rondaArray[1]["def"]);
        for($i=1;$i<=$num_div;$i++){
            if(empty($this->rondaArray[1]["def"][$i])){continue;}
            foreach($this->rondaArray[1]["def"][$i] as $type => $array_fleet){
                if(empty($this->rondaArray[$num_ronda]["def"][$i][$type])){
                    $delete["def"][$i][$type]=$array_fleet["count"];
                }else{
                    $delete["def"][$i][$type]=$array_fleet["count"]-$this->rondaArray[$num_ronda]["def"][$i][$type]["count"];
                }
                if($type>400){
                    $this->escombro["metal"]  += ($pricelist[$type]['metal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro["crystal"]+= ($pricelist[$type]['crystal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro[def]["metal"]  += ($pricelist[$type]['metal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro[def]["crystal"]+= ($pricelist[$type]['crystal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);

                    $delete["def"][$i][$type]-=floor($delete["def"][$i][$type]*rand(60,80)/100);
                }else{
                    $this->escombro["metal"]  += ($pricelist[$type]['metal'] * $delete["def"][$i][$type])  * (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro["crystal"]+= ($pricelist[$type]['crystal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro[def]["metal"]  += ($pricelist[$type]['metal'] * $delete["def"][$i][$type])  * (30 / 100);//$pricelist[$a]['crystal']);
                    $this->escombro[def]["crystal"]+= ($pricelist[$type]['crystal'] * $delete["def"][$i][$type])* (30 / 100);//$pricelist[$a]['crystal']);


                }
                $defesa_vive[$i][$type] = $array_fleet["count"]-$delete["def"][$i][$type];
                if($defesa_vive[$i][$type]<0){
                    $defesa_vive[$i][$type]=0;
                }
               
            }
           
            if($i!=1){
                $this->SQL_atacant($defesa_vive[$i],$i,"def");
            }
        }
        
        $this->repartirmateriales();
        $this->SQL_defensa($defesa_vive[1]);

}
function SQL_atacant($atacante_vive,$id_userfleet,$type=false){
   global $db;
        $totalCount = 0;
        $Farray = "";

        foreach($atacante_vive as $Element => $Count){
            if($Count){
                $Farray .= $Element.','.$Count.";";

                $totalCount += $Count;
            }
        }
        if($type=="def"){
            $fleet_id=$this->def[$id_userfleet]["user"][fleet_id];
        }else{
            $fleet_id=$this->att[$id_userfleet]["user"][fleet_id];
        }

        if($totalCount <= 0){
            $query="DELETE FROM {{table}} WHERE fleet_id = '{$fleet_id}';";
            } else {
            $query="UPDATE {{table}} SET fleet_array = '".substr($Farray, 0, -1)."',
                fleet_amount = '{$totalCount}', fleet_mess = 1
                WHERE fleet_id='{$fleet_id}'";
        }
        $db->query($query, 'fleets');
        
}
function SQL_defensa($defesa_vive){
    global $resource,$db;//,$dateFleet;
    $UpdateDefense = "UPDATE {{table}} SET ";
    $count=count($defesa_vive);
    $i=1;
    if(is_array($defesa_vive)){
        foreach($defesa_vive as $id => $Count){
            if($resource[$id]){
                
                $UpdateDefense .= "".$resource[$id]." = '".$Count."',";
                
                $i++;
            }
        }
    }
    $UpdateDefense .= "`metal` = `metal` - '" . $this->robado['metal'] . "', ";
    $UpdateDefense .= "`crystal` = `crystal` - '" . $this->robado['crystal'] . "', ";
    $UpdateDefense .= "`deuterium` = `deuterium` - '" . $this->robado['deuterio'] . "' ";
    $UpdateDefense .= " WHERE id_owner = '".$this->dateFleet["id_owner"]."'
                AND galaxy = '".$this->dateFleet['galaxy']."'
                AND system = '".$this->dateFleet['system']."'
                AND planet = '".$this->dateFleet['planet']."'
                AND planet_type = '".$this->dateFleet['planet_type']."';";
    $db->query($UpdateDefense, 'planets');
}

function repartirmateriales() {
    global $pricelist,$db;//,$rondaArray,$att,$def_mater;
        $variable_reparto=array();
        $num_ronda=count($this->rondaArray);
        $num_div=count($this->rondaArray[$num_ronda]["att"]);
        $this->robado["metal"]=0;
        $this->robado["crystal"]=0;
        $this->robado['deuterio']=0;
        for($i=1;$i<=$num_div;$i++){
            if(!empty($this->rondaArray[$num_ronda]["att"][$i])){$totaluser++;}
        }
        if($totaluser!=0 && $this->win==1){
            $metalrobado = abs($this->def_mater['metal']/(2*$totaluser));
            $cristalrobado = abs($this->def_mater['crystal']/(2*$totaluser));
            $deutrobado = abs($this->def_mater['deuterio']/(2*$totaluser));
            for($i=1;$i<=$num_div;$i++){
                if(!empty($this->rondaArray[$num_ronda]["att"][$i])){
                    $booty=array();
                    foreach($this->rondaArray[$num_ronda]["att"][$i] as $type => $array_fleet){
                        $capacity[$i]+=$pricelist[$type]["capacity"]*$array_fleet["count"];
                    }
                    $Sumcapacity              =  $capacity[$i];

                    $booty['deuterium']       = min($Sumcapacity / 3,  $deutrobado);
                    $Sumcapacity             -= $booty['deuterium'];

                    $booty['crystal']         = min(($Sumcapacity / 2), $cristalrobado);
                    $Sumcapacity             -= $booty['crystal'];

                    $booty['metal']           = min(($Sumcapacity ),  $metalrobado);
                    $Sumcapacity             -= $booty['metal'];


                    $oldMetalBooty            = $booty['crystal'] ;
                    $booty['crystal']         += min(($Sumcapacity /2),  max($cristalrobado - $booty['crystal'], 0));

                    $Sumcapacity             += $oldMetalBooty - $booty['crystal'] ;

                    $booty['metal']          += min(($Sumcapacity ),  max($metalrobado - $booty['metal'], 0));


                    $robado[$i]['metal']      = max($booty['metal'] ,0);
                    $robado[$i]['crystal']    = max($booty['crystal'] ,0);
                    $robado[$i]['deuterio']   = max($booty['deuterium'] ,0);

                    $this->robado['metal']      += $robado[$i]['metal'];
                    $this->robado['crystal']    +=  $robado[$i]['crystal'];
                    $this->robado['deuterio']   += $robado[$i]['deuterio'];

                    $steal                    = array_map('floor', $robado[$i]);
                    $UpdateFleet  = 'UPDATE {{table}} SET ';
                            $UpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $robado[$i]['metal'] .', ';
                            $UpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` + '. $robado[$i]['crystal'] .', ';
                            $UpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` + '. $robado[$i]['deuterio'] .' ';
                            $UpdateFleet .= 'WHERE fleet_id = '. $this->att[$i]["user"]["fleet_id"] .' ';
                            $UpdateFleet .= 'LIMIT 1 ;';
                        $db->query( $UpdateFleet, 'fleets');
                        unset($robado[$i],$booty);
                }
            }
             
        }
}


function reporte(){
    global $db;
    $reporte=mysql_escape_string($this->formaterw());

    $hash = md5($reporte).time();

    $InsertRapport  = 'INSERT INTO {{table}} SET ';
    $InsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
    $users = '';
    for($i = 1; $i <= count($this->att); $i++){
        $users .= $this->att[$i]["user"]['id'].",";
    }
    for($i = 1; $i <= count($this->def); $i++){
        $users .= $this->def[$i]["user"]['id'].",";
    }
    $InsertRapport .= '`owners` = "'.substr($users, 0, -1).'", ';
    $InsertRapport .= '`rid` = "'. $hash .'", ';
    $InsertRapport .= '`raport` = "'. mysql_escape_string(str_replace("\n", "",  $reporte) ) .'"';
    $db->query($InsertRapport, 'rw');// or die("Error insertando el reporte a la base de datos".mysql_error()."<br /><br />Prueba a ejecutar:".mysql_query());
    return $hash;
}

function MissionCaseSac2($FleetData){
    
    $this->dateFleet        =array();
    $this->attArray         =array();
    $this->defArray         =array();
    $this->rondaArray       =array();
    $this->rondaArrayinfo   =array();
    $this->att              =array();
    $this->def              =array();
    $this->def_mater        =array();
    $this->userTotal_id["att"]=array();
    $this->userTotal_id["def"]=array();
    global $db,$reslist,$resource,$lang,$users;
    $timeini = microtime(true);
    
    if($FleetData['fleet_mess'] == '0' && $FleetData['fleet_start_time'] < time() ){
            if($FleetData['fleet_group']){
                $db->query('DELETE FROM {{table}} WHERE id="'.$FleetData['fleet_group'].'"', 'sac');

                $Fleets = $db->query("SELECT f.*, u.id,u.username,u.rpg_amiral,u.defence_tech,u.military_tech,u.shield_tech FROM {{table}}fleets as f
                                          LEFT JOIN {{table}}users as u
                                          ON u.id=f.fleet_owner WHERE f.fleet_mess=0 AND f.fleet_mission=2

                                            AND f.fleet_group = '".$FleetData['fleet_group']."';", '');
                                                                     //f.fleet_mission = '2' AND
                        $db->query("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group='".$FleetData['fleet_group']."'", 'fleets');
            }else{
                $Fleets = $db->query("SELECT f.*, u.id,u.username,u.rpg_amiral,u.defence_tech,u.military_tech,u.shield_tech FROM {{table}}fleets as f
                                          LEFT JOIN {{table}}users as u
                                          ON u.id=f.fleet_owner WHERE f.fleet_id = '".$FleetData['fleet_id']."';", '');
            }
            $a=1;
            while($Fleet = mysql_fetch_assoc($Fleets)){
                $Fleet["fleet_array"]= substr($Fleet["fleet_array"], 0, -1);
                $FExp = explode(";", $Fleet["fleet_array"]);
                $fleet_array=array();
                foreach($FExp as $key => $value){
                    $Atack = explode(",", $value);
                    $fleet_array[$Atack[0]] = $Atack[1];
               }
                $this->att[$a]["fleet"]=$fleet_array;
                $this->att[$a]["user"]["fleet_id"]=$Fleet["fleet_id"];
                $this->att[$a]["user"]["id"]=$Fleet["id"];
                if(!in_array($Fleet["id"],$this->userTotal_id["att"])){
                    $this->userTotal_id["att"][]=$Fleet["id"];
                }
                $this->att[$a]["user"]["username"]=$Fleet["username"];
                $this->att[$a]["user"]["rpg_amiral"]=$Fleet["rpg_amiral"];
                $this->att[$a]["user"]["defence_tech"]=$Fleet["defence_tech"];
                $this->att[$a]["user"]["military_tech"]=$Fleet["military_tech"];
                $this->att[$a]["user"]["shield_tech"]=$Fleet["shield_tech"];
                $a++;
            }
            if(empty($this->att)){
                return;
            }
            $TargetPlanet = $db->query("SELECT g.id_luna, p.*,u.id,u.username,u.rpg_amiral,u.defence_tech,u.military_tech,u.shield_tech
                                    FROM {{table}}planets as p
                                    INNER JOIN {{table}}users as u ON u.id=p.id_owner
                                    INNER JOIN {{table}}galaxy as g On g.id_planet=p.id
                                        WHERE p.galaxy = ".$FleetData['fleet_end_galaxy']."
                                        AND p.system = ".$FleetData['fleet_end_system']."
                                        AND p.planet = ".$FleetData['fleet_end_planet']."
                                        AND p.planet_type = ".$FleetData['fleet_end_type'].";", '',true);
            $this->userTotal_id["def"][]=$TargetPlanet[id];
            $array_fleet_var= array_merge($reslist['fleet'], $reslist['defense']);
            $this->def[1]['fleet']=array();
            foreach($array_fleet_var as $value){
                if($value==("502"|"503"))continue;
                if(isset($resource[$value]) && isset($TargetPlanet[$resource[$value]]) && $TargetPlanet[$resource[$value]]>0 ){
                    $this->def[1]['fleet'][$value] = $TargetPlanet[$resource[$value]];
                }
            }
            $this->def[1][user][id]=$TargetPlanet[id];
            $this->def[1][user][username]=$TargetPlanet[username];
            $this->def[1][user][rpg_amiral]=$TargetPlanet[rpg_amiral];
            $this->def[1][user][defence_tech]=$TargetPlanet[defence_tech];
            $this->def[1][user][military_tech]=$TargetPlanet[military_tech];
            $this->def[1][user][shield_tech]=$TargetPlanet[shield_tech];
            $this->def_mater=array("metal"=>$TargetPlanet["metal"],"crystal"=>$TargetPlanet["crystal"],"deuterio"=>$TargetPlanet["deuterium"]);
            $this->dateFleet=array("id_owner"=>   $TargetPlanet["id_owner"],
                                   "galaxy"=>     $TargetPlanet['galaxy'],
                                   "system"=>     $TargetPlanet['system'],
                                   "planet"=>     $TargetPlanet['planet'],
                                   "planet_type"=>  $TargetPlanet['planet_type'],
                                    "id_luna"=>     $TargetPlanet['id_luna']);




            $FleetStays = $db->query("SELECT f.*, u.id,u.username,u.rpg_amiral,u.defence_tech,u.military_tech,u.shield_tech
                            FROM {{table}}fleets as f
                              LEFT JOIN {{table}}users as u
                              ON u.id=f.fleet_owner WHERE f.fleet_mission = '5' AND f.fleet_end_galaxy = ".$FleetData['fleet_end_galaxy']."
                                        AND f.fleet_end_system = ".$FleetData['fleet_end_system']."
                                        AND f.fleet_end_planet = ".$FleetData['fleet_end_planet']."
                                        AND f.fleet_end_type = ".$FleetData['fleet_end_type'].";", '');
            $a=2;
            while($FleetStay = mysql_fetch_assoc($FleetStays)){
            //print_r($FleetStay);
                $fleet_array=array();
                $FExp = explode(";", substr($Fleet["fleet_array"], 0, -1));
                foreach($FExp as $key => $value){
                    $Atack = explode(",", $value);
                    $fleet_array[$Atack[0]] = $Atack[1];
                }
                $this->def[$a]["fleet"]=$fleet_array;
                $this->def[$a]["user"]["fleet_id"]=$FleetStay["fleet_id"];
                $this->def[$a]["user"]["id"]=$FleetStay["id"];
                $this->def[$a]["user"]["username"]=$FleetStay["username"];
                $this->def[$a]["user"]["rpg_amiral"]=$FleetStay["rpg_amiral"];
                $this->def[$a]["user"]["defence_tech"]=$FleetStay["defence_tech"];
                $this->def[$a]["user"]["military_tech"]=$FleetStay["military_tech"];
                $this->def[$a]["user"]["shield_tech"]=$FleetStay["shield_tech"];
                $a++;
                if(!in_array($FleetStay["id"],$this->userTotal_id["def"])){
                    $this->userTotal_id["def"][]=$FleetStay["id"];
                }
                
            }
    for($ronda=1;$ronda<=6;$ronda++){
        if($ronda==1){
            $this->IniSim();
        }else{
            $this->ronda($ronda);
        }
        $destatt=0;
        $destdef=0;
        $CountAttArray=count($this->attArray);
        for ($i=1;$i<=$CountAttArray;$i++){
            if(empty($this->attArray[$i])){
                $destatt++;
            }
            if($destatt==$CountAttArray){
                $ronda=7;
            }
        }
        $CountDefArray=count($this->defArray);

        for ($i=1;$i<=$CountDefArray;$i++){
            if(empty($this->defArray[$i])){
                $destdef++;
            }
            if($destdef==$CountDefArray){
                $ronda=7;
            }
        }
        $ronda=(($CountDefArray==0||$CountAttArray==0)?"7":$ronda);
        

    }
    if($CountDefArray==$destdef){
        $this->win=1;
    }elseif($CountAttArray==$destatt){
        $this->win=2;
    }else{
        $this->win=0;
    }
    $this->flota_destruida();
    $hash=$this->reporte();
    
    
    $db->query("UPDATE {{table}}
        SET metal = metal + ".($this->escombro["metal"])." ,
            crystal = crystal + ".($this->escombro["crystal"])."
                WHERE `galaxy`=". $FleetData['fleet_end_galaxy'] ."
                AND `system` = ". $FleetData['fleet_end_system'] ."
                AND `planet` = ". $FleetData['fleet_end_planet'] .";",'galaxy');



    foreach($this->userTotal_id as $type_name => $id){
        
        $reporte  = '<a OnClick=\'f("CombatReport.php?raport='.$hash.'", "");\' >';
        $reporte .= '<center>';
        if($type_name == "att" ){
            if($CountDefArray==$destdef ){
                $reporte .= '<font color=\'green\'>';
            }elseif($CountAttArray==$destatt){
                $reporte .= '<font color=\'red\'>';
            }
        }elseif($type_name == "def"){
            if($CountAttArray==$destatt){
                $reporte .= '<font color=\'green\'>';
            }elseif($CountDefArray==$destdef){
                $reporte .= '<font color=\'red\'>';
            }
        }else{
            $reporte .= '<font color=\'orange\'>';
        }

        $reporte .= $lang['sys_mess_attack_report'] .' ['. $FleetData['fleet_end_galaxy'] .':'. $FleetData['fleet_end_system'] .':'. $FleetData['fleet_end_planet'] .'] </font></a><br /><br />';
        $reporte .= '<font color=\'red\'>'. $lang['sys_perte_attaquant'] .': '.pretty_number ( ($this->escombro[att]["metal"]+$this->escombro[att]["crystal"])) .'</font>';
        $reporte .= '<font color=\'green\'>   '. $lang['sys_perte_defenseur'] .': '. pretty_number (($this->escombro[def]["metal"]+$this->escombro[def]["crystal"]) ).'</font><br />' ;
        $reporte .= $lang['sys_gain'] .' '. $lang['Metal'] .':<font color=\'#adaead\'>'.pretty_number ( $this->robado['metal']) .'</font>   '. $lang['Crystal'] .':<font color=\'#ef51ef\'>'. pretty_number ($this->robado['crystal']) .'</font>   '. $lang['Deuterium'] .':<font color=\'#f77542\'>'. pretty_number ($this->robado['deuterio']) .'</font><br />';
        $reporte .= $lang['sys_debris'] .' '. $lang['Metal'] .': <font color=\'#adaead\'>'.pretty_number  ($this->escombro["metal"]) .'</font>   '. $lang['Crystal'] .': <font color=\'#ef51ef\'>'. pretty_number ($this->escombro["crystal"]) .'</font><br /></center>';
        $timefin = microtime(true);

        $reporte .="Tiempo : ".($timefin-$timeini);
        $reporte =  mysql_escape_string($reporte);
        for($i = 0; $i < count($this->userTotal_id[$type_name]); $i++){
            $users2[$i] = $this->userTotal_id[$type_name][$i];
            $users->SendSimpleMessage ($users2[$i], '',time() , 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $reporte);
        }
    }
    }else{
        if ($FleetData['fleet_end_time'] < time())
        {
            
                   $this->RestoreFleetToPlanet($FleetData);
                    $db->query ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetData['fleet_id'].'', 'fleets');

                    
        }
    }
    //exit();
}
}

//$sac=new sac();
//$sac->MissionCaseAttack2();
?>