<?php

##############################################################################
# *                                                                             #
# * XG PROYECT                                                                 #
# *                                                                           #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net           #
# *                                                                             #
# *                                                                             #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *                                                                             #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of             #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             #
# *  GNU General Public License for more details.                             #
# *                                                                             #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowBuildingsPage
{
    private function BuildingSavePlanetRecord ($CurrentPlanet)
    {
        $QryUpdatePlanet  = "UPDATE {{table}} SET ";
        $QryUpdatePlanet .= "`b_building_id` = '". $CurrentPlanet['b_building_id'] ."', ";
        $QryUpdatePlanet .= "`b_building` = '".    $CurrentPlanet['b_building']    ."' ";
        $QryUpdatePlanet .= "WHERE ";
        $QryUpdatePlanet .= "`id` = '".            $CurrentPlanet['id']            ."';";
        doquery( $QryUpdatePlanet, 'planets');

        return;
    }

    private function CancelBuildingFromQueue (&$CurrentPlanet, &$CurrentUser)
    {
        $CurrentQueue  = $CurrentPlanet['b_building_id'];
        if ($CurrentQueue != 0)
        {
            $QueueArray          = explode ( ";", $CurrentQueue );
            $ActualCount         = count ( $QueueArray );
            $CanceledIDArray     = explode ( ",", $QueueArray[0] );
            $Element             = $CanceledIDArray[0];
            $BuildMode           = $CanceledIDArray[4];

            if ($ActualCount > 1)
            {
                array_shift( $QueueArray );
                $NewCount        = count( $QueueArray );
                $BuildEndTime    = time();
                for ($ID = 0; $ID < $NewCount ; $ID++ )
                {
                    $ListIDArray          = explode ( ",", $QueueArray[$ID] );
                    $BuildEndTime        += $ListIDArray[2];
                    $ListIDArray[3]       = $BuildEndTime;
                    $QueueArray[$ID]      = implode ( ",", $ListIDArray );
                }
                $NewQueue        = implode(";", $QueueArray );
                $ReturnValue     = true;
                $BuildEndTime    = '0';
            }
            else
            {
                $NewQueue        = '0';
                $ReturnValue     = false;
                $BuildEndTime    = '0';
            }

            if ($BuildMode == 'destroy')
            {
                $ForDestroy = true;
            }
            else
            {
                $ForDestroy = false;
            }

            if ( $Element != false ) {
            $Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
            $CurrentPlanet['metal']       += $Needed['metal'];
            $CurrentPlanet['crystal']     += $Needed['crystal'];
            $CurrentPlanet['deuterium']   += $Needed['deuterium'];
            }

        }
        else
        {
            $NewQueue          = '0';
            $BuildEndTime      = '0';
            $ReturnValue       = false;
        }

        $CurrentPlanet['b_building_id']  = $NewQueue;
        $CurrentPlanet['b_building']     = $BuildEndTime;

        return $ReturnValue;
    }

    private function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID )
    {
        if ($QueueID > 1)
        {
            $CurrentQueue  = $CurrentPlanet['b_building_id'];
            if ($CurrentQueue != 0)
            {
                $QueueArray    = explode ( ";", $CurrentQueue );
                $ActualCount   = count ( $QueueArray );
                $ListIDArray   = explode ( ",", $QueueArray[$QueueID - 2] );
                $BuildEndTime  = $ListIDArray[3];
                for ($ID = $QueueID; $ID < $ActualCount; $ID++ )
                {
                    $ListIDArray          = explode ( ",", $QueueArray[$ID] );
                    $BuildEndTime        += $ListIDArray[2];
                    $ListIDArray[3]       = $BuildEndTime;
                    $QueueArray[$ID - 1]  = implode ( ",", $ListIDArray );
                }
                unset ($QueueArray[$ActualCount - 1]);
                $NewQueue     = implode ( ";", $QueueArray );
            }
            $CurrentPlanet['b_building_id'] = $NewQueue;
        }
        return $QueueID;
    }

    private function AddBuildingToQueue (&$CurrentPlanet, $CurrentUser, $Element, $AddMode = true)
    {
        global $resource;

        $CurrentQueue  = $CurrentPlanet['b_building_id'];

        $Queue                 = $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser);
        $CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet);

        if ($CurrentPlanet["field_current"] >= ($CurrentMaxFields - $Queue['lenght']) && $_GET['cmd'] != 'destroy')
            die(header("location:game.php?page=buildings"));

        if ($CurrentQueue != 0)
        {
            $QueueArray    = explode ( ";", $CurrentQueue );
            $ActualCount   = count ( $QueueArray );
        }
        else
        {
            $QueueArray    = "";
            $ActualCount   = 0;
        }

        if ($AddMode == true)
        {
            $BuildMode = 'build';
        }
        else
        {
            $BuildMode = 'destroy';
        }

        if ( $ActualCount < MAX_BUILDING_QUEUE_SIZE)
        {
            $QueueID      = $ActualCount + 1;
        }
        else
        {
            $QueueID      = false;
        }

        if ( $QueueID != false && IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false) && IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) )
        {
            if ($QueueID > 1)
            {
                $InArray = 0;
                for ( $QueueElement = 0; $QueueElement < $ActualCount; $QueueElement++ )
                {
                    $QueueSubArray = explode ( ",", $QueueArray[$QueueElement] );
                    if ($QueueSubArray[0] == $Element)
                    {
                        $InArray++;
                    }
                }
            }
            else
            {
                $InArray = 0;
            }

            if ($InArray != 0)
            {
                $ActualLevel  = $CurrentPlanet[$resource[$Element]];
                if ($AddMode == true)
                {
                    $BuildLevel   = $ActualLevel + 1 + $InArray;
                    $CurrentPlanet[$resource[$Element]] += $InArray;
                    $BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                    $CurrentPlanet[$resource[$Element]] -= $InArray;
                }
                else
                {
                    $BuildLevel   = $ActualLevel - 1 - $InArray;
                    $CurrentPlanet[$resource[$Element]] -= $InArray;
                    $BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
                    $CurrentPlanet[$resource[$Element]] += $InArray;
                }
            }
            else
            {
                $ActualLevel  = $CurrentPlanet[$resource[$Element]];
                if ($AddMode == true)
                {
                    $BuildLevel   = $ActualLevel + 1;
                    $BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                }
                else
                {
                    $BuildLevel   = $ActualLevel - 1;
                    $BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
                }
            }

            if ($QueueID == 1)
            {
                $BuildEndTime = time() + $BuildTime;
            }
            else
            {
                $PrevBuild = explode (",", $QueueArray[$ActualCount - 1]);
                $BuildEndTime = $PrevBuild[3] + $BuildTime;
            }

            $QueueArray[$ActualCount]       = $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
            $NewQueue                       = implode ( ";", $QueueArray );
            $CurrentPlanet['b_building_id'] = $NewQueue;
        }
        return $QueueID;
    }

    // OLD CODE
    private function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser )
    {
        global $lang, $dpath, $reslist, $resource;
        
        $BuildingNow   = array();
        $CurrentQueue  = $CurrentPlanet['b_building_id'];
        $QueueID       = 0;
        
        if ($CurrentQueue != 0) {
            $QueueArray    = explode ( ";", $CurrentQueue );
            $ActualCount   = count ( $QueueArray );
        } else {
            $QueueArray    = "0";
            $ActualCount   = 0;
        }

        $ListIDRow    = "";

        if ($ActualCount != 0)
        {
            $ListIDRow .= "<tr><td class='c' colspan='3'><center><font color='yellow'>.:: Edificios en desarrollo ::.</font><br />Espacios usados <font color='#00FF00'>".$ActualCount."</font> / <font color='#FF0000'>". MAX_BUILDING_QUEUE_SIZE ."</font> Restan ". ( MAX_BUILDING_QUEUE_SIZE - $ActualCount) ." espacios de cola.</center></td></tr>";
            $PlanetID     = $CurrentPlanet['id'];
            $totalBuildTime = 0;
            $totalBuildEndTime = time();
            
            if((MAX_BUILDING_QUEUE_SIZE - $ActualCount) > 0){
                $CanBuild = true;
            }else{
                $Canbuild = false;
            }
            
            foreach($reslist['build'] as $Element){
                $BuildingNow[$Element] = $CurrentPlanet[$resource[$Element]];
            }
            
            for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++)
            {
                $BuildArray   = explode (",", $QueueArray[$QueueID]);
                $BuildEndTime = floor($BuildArray[3]);
                $CurrentTime  = floor(time());
                if ($BuildEndTime >= $CurrentTime)
                {
                    $ListID       = $QueueID + 1;
                    $Element      = $BuildArray[0];
                    $BuildingNow[$Element] = $BuildArray[1];
                    $BuildLevel   = $BuildArray[1];
                    $BuildMode    = $BuildArray[4];
                    $BuildTime    = $BuildEndTime - time();
                    $totalBuildTime    = $BuildTime;
                    $totalBuildEndTime = $BuildEndTime;
                    $ElementTitle = $lang['tech'][$Element];
                    
                    if (IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false) and IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element) and $CanBuild and $CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($CurrentPlanet) - $ActualCount )) {
                        $CanBuild = true;
                    } else {
                        $CanBuild = false;
                    }
                    
                    if ($BuildMode == 'build') {
                        $modo_rep = 'insert';
                        $multi = 1;
                    } else {
                        $modo_rep = 'destroy';
                        $multi = 2;
                    }
                    
                    if ($CanBuild) { 
                        $levelmore = "<input type='button' onclick=\"top.location = 'game.php?page=buildings&cmd=$modo_rep&building=". $Element ."';\" value='Repetir' />"; 
                    } else { 
                        $levelmore = ''; 
                    }

                    if ($ListID > 0)
                    {
                        $ListIDRow .= "<tr>";                       
                        if ($ListID == 1) {
                            $ListIDRow .= "<th colspan=\"3\">";
                            $ListIDRow .= "    <table width=\"100%\">";
                            $ListIDRow .= "        <tr>";
                            $ListIDRow .= "                <td width='80' rowspan='2'><a href='game.php?page=infos&gid=".$Element."'><img border='0' src='".$dpath."gebaeude/".$Element.".gif' align='top' title='". $ElementTitle ."' width='80' height='80'></a></td>";
                            if ($BuildMode == 'build')
                            {
                                $ListIDRow .= "            <td><center>";
                                $ListIDRow .= "            <table>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td width='24'><img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            <td><center><font color =\"#6699FF\"><a href='game.php?page=infos&gid=".$Element."'><font color =\"#6699FF\">.::. ". $ElementTitle ." .::.</font></a><br />Ampliar al <font color=\"#FF8C00\"><b>Nivel ". $BuildLevel ."</b></font></font></center></td>";
                                $ListIDRow .= "            <td width='24'><img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td colspan='3'><center>". $levelmore . "</center></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            </table>";
                                $ListIDRow .= "            </center></td>";
                            } else {
                                $ListIDRow .= "            <td><center>";
                                $ListIDRow .= "            <table>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td width='24'><img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            <td><center><font color =\"#6699FF\"><a href='game.php?page=infos&gid=".$Element."'><font color =\"#6699FF\">.::. ". $ElementTitle ." .::.</font></a><br /><font color=\"#87CEEB\"><blink>". $lang['bd_dismantle'] ."</blink></font> en <font color=\"#FF8C00\"><b>Nivel ". $BuildLevel ."</b></font></font></center></td>";
                                $ListIDRow .= "            <td width='24'><img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            </table>";
                                $ListIDRow .= "            </center></td>";
                            }   
                            $ListIDRow .= "            <td width=\"56\" rowspan='2'><center>";
                            $ListIDRow .= "                <div id=\"blc\" class=\"z\">". $BuildTime ."<br><a href=\"game.php?page=buildings&listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">".$lang['bd_interrupt']."</a></div>";
                            $ListIDRow .= "                <script language=\"JavaScript\">";
                            $ListIDRow .= "                    pp = \"". $BuildTime ."\";\n";
                            $ListIDRow .= "                    pk = \"". $ListID ."\";\n";
                            $ListIDRow .= "                    pm = \"cancel\";\n";
                            $ListIDRow .= "                    pl = \"". $PlanetID ."\";\n";
                            $ListIDRow .= "                    t();\n";
                            $ListIDRow .= "                </script>";
                            $ListIDRow .= "                <strong color=\"lime\"><br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font></strong></center>";
                            $ListIDRow .= "            </td>";
                            $ListIDRow .= "           </tr>";
                            
                            $totaltime  = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / $multi;
                            if($totaltime == 0) {
                                 $barpercent=0;
                             } else { 
                                 $barpercent = round(( ($totaltime - $BuildTime) / $totaltime * 100), 2); 
                            }
                            $BarScript .= "<script type=\"text/javascript\">\n";
                            $BarScript .= "<!--\n";
                            $BarScript .= "    function barupdate() {\n";
                            $BarScript .= "        var barra   = document.getElementById('prodBar');\n";
                            $BarScript .= "        var timeout = 1;\n";
                            $BarScript .= "        ss2         = pp2;\n";
                            $BarScript .= "        if ( ss2 <= 0 ) {\n";
                            $BarScript .= "            barra.innerHTML = '<font color=\"#000\">100%</font>'; barra.style.width = 364;\n";
                            $BarScript .= "        } else {\n";
                            $BarScript .= "            if ( ss2 <= 0 ) {\n";
                            $BarScript .= "                if (1) {\n";
                            $BarScript .= "                    barra.innerHTML = '<font color=\"#000\">100%</font>'; barra.style.width = 364;\n";
                            $BarScript .= "                } else {\n";
                            $BarScript .= "                    timeout = 0;\n";
                            $BarScript .= "                    barra.innerHTML = '<font color=\"#000\">100%</font>'; barra.style.width = 364;\n";
                            $BarScript .= "                }\n";
                            $BarScript .= "            } else {\n";
                            $BarScript .= "                var percent = Math.round(((".$totaltime." - pp2) / ".$totaltime.") * 10000) / 100; var width = Math.round( percent * 3.64 );\n";
                            $BarScript .= "                barra.innerHTML = '<font color=\"#000\"><b>' + percent + '%</b></font>'; barra.style.width = width;\n";
                            $BarScript .= "            }\n";
                            $BarScript .= "            pp2 = pp2 - 0.5;\n";
                            $BarScript .= "            if (timeout == 1) {\n";
                            $BarScript .= "                 window.setTimeout(\"barupdate();\", 499);\n";
                            $BarScript .= "            }\n";
                            $BarScript .= "        }\n";
                            $BarScript .= "    }\n";
                            $BarScript .= "//-->\n";
                            $BarScript .= "</script>\n";
                            $BarScript .= "<script language=\"javascript\">";
                            $BarScript .= "    pp2 = \"". $BuildTime ."\";\n";      // temps necessaire (a compter de maintenant et sans ajouter time() )
                            $BarScript .= "    barupdate();\n";
                            $BarScript .= "</script>";
                            $Bar        .= "<div id='barcontainer' style='border: 1px solid rgb(153, 153, 255); width: 364px;'><div id='prodBar' style='background-color: #dfd; width: ".round($barpercent * 3.64) ."px;'><font color='#000000'><b>". $barpercent ."%</b></font></div></div>";
                            
                            $ListIDRow .= "           <tr>";
                            $ListIDRow .= "            <td class=\"k\" height='18'>$Bar $BarScript</td>";
                            $ListIDRow .= "           </tr>";
                            $ListIDRow .= "    </table>";
                            $ListIDRow .= "</th>";
                            unset($Bar);
                            unset($BarScript);
                        } else {
                            $ListIDRow .= "<th colspan=\"3\">";
                            $ListIDRow .= "    <table width=\"100%\">";
                            $ListIDRow .= "        <tr>";
                            if ($BuildMode == 'build')
                            {
                                $ListIDRow .= "               <td class=\"l\"><font color =\"#6699FF\">". $ListID ." <a href='game.php?page=infos&gid=".$Element."'><font color =\"#6699FF\">.::. ". $ElementTitle ." .::.</font></a> Ampliar al <font color=\"#FF8C00\"><b>Nivel ". $BuildLevel ."</b></font></font></td>";
                            } else {
                                $ListIDRow .= "               <td class=\"l\"><font color =\"#6699FF\">". $ListID ." <a href='game.php?page=infos&gid=".$Element."'><font color =\"#6699FF\">.::. ". $ElementTitle ." .::.</font></a> <font color=\"#87CEEB\"><blink>". $lang['bd_dismantle'] ."</blink></font> en <font color=\"#FF8C00\"><b>Nivel ". $BuildLevel ."</b></font></font></td>";
                            }
                            $ListIDRow .= "               <td class=\"k\" width=\"56\"><center>". $levelmore . "</center></td>";
                            $ListIDRow .= "               <td class=\"k\" width=\"56\">";
                            $ListIDRow .= "                   <font color=\"red\"><a href=\"game.php?page=buildings&listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">".$lang['bd_cancel']."</a></font>";
                            $ListIDRow .= "               </td>";
                            $ListIDRow .= "        </tr>";
                            $ListIDRow .= "   </table>";
                            $ListIDRow .= "</th>";
                        }
                        $ListIDRow .= "</tr>";
                    }
                }
            }
            
            $ListIDRow .= "<tr><td class='c' colspan='3'><center>Tiempo de finalizacion total: ". pretty_time($totalBuildTime) ."<br/>Hora finalizacion total: <strong color=\"lime\"><font color=\"lime\">". date("j/m H:i:s" ,$totalBuildEndTime ) ."</font></strong></center></td></tr>";
        }

        $RetValue['lenght']    = $ActualCount;
        $RetValue['buildlist'] = $ListIDRow.'<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>';

        return $RetValue;
    }  



    public function __construct (&$CurrentPlanet, $CurrentUser)
    {
        global $ProdGrid, $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET, $xgp_root;

        include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
        include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);
        include_once($xgp_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);

		CheckPlanetUsedFields ( $CurrentPlanet );

    
        $parse            = $lang;
        $Allowed['1']     = array(  1,  2,  3,  4, 12, 14, 15, 21, 22, 23, 24, 31, 33, 34, 44);
        $Allowed['3']     = array( 12, 14, 21, 22, 23, 24, 34, 41, 42, 43);

        if (isset($_GET['cmd']))
        {
            $bDoItNow     = false;
            $TheCommand = $_GET['cmd'];
            $Element     = $_GET['building'];
            $ListID     = $_GET['listid'];

            if (!in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']]))
            {
                unset($Element);
            }

            if( isset ( $Element ))
            {
                if ( !strchr ( $Element, ",") && !strchr ( $Element, " ") &&
                     !strchr ( $Element, "+") && !strchr ( $Element, "*") &&
                     !strchr ( $Element, "~") && !strchr ( $Element, "=") &&
                     !strchr ( $Element, ";") && !strchr ( $Element, "'") &&
                     !strchr ( $Element, "#") && !strchr ( $Element, "-") &&
                     !strchr ( $Element, "_") && !strchr ( $Element, "[") &&
                     !strchr ( $Element, "]") && !strchr ( $Element, ".") &&
                     !strchr ( $Element, ":"))
                {
                    if (in_array( trim($Element), $Allowed[$CurrentPlanet['planet_type']]))
                    {
                        $bDoItNow = true;
                    }
                }
                else
                {
                    header("location:game.php?page=buildings");
                }
            }
            elseif ( isset ( $ListID ))
            {
                $bDoItNow = true;
            }

            if ($Element == 31 && $CurrentUser["b_tech_planet"] != 0)
            {
                $bDoItNow = false;
            }

            if ( ( $Element == 21 or $Element == 14 or $Element == 15 ) && $CurrentPlanet["b_hangar"] != 0)
            {
                $bDoItNow = false;
            }

            if ($bDoItNow == true)
            {
                switch($TheCommand)
                {
                    case 'cancel':
                        $this->CancelBuildingFromQueue ($CurrentPlanet, $CurrentUser);
                    break;
                    case 'remove':
                        $this->RemoveBuildingFromQueue ($CurrentPlanet, $CurrentUser, $ListID);
                    break;
                    case 'insert':
                        $this->AddBuildingToQueue ($CurrentPlanet, $CurrentUser, $Element, true);
                    break;
                    case 'destroy':
                        $this->AddBuildingToQueue ($CurrentPlanet, $CurrentUser, $Element, false);
                    break;
                }
            }

            if ( $_GET['r'] == 'overview' )
            {
                header('location:game.php?page=overview');
            }
            else
            {
                header ("Location: game.php?page=buildings&mode=buildings");
            }
        }

        SetNextQueueElementOnTop($CurrentPlanet, $CurrentUser);
        // $Queue = $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser); // OLD CODE
        // START FIX BY JSTAR
        $Sprice    =    array();
        $Queue     =     $this->ShowBuildingQueue($CurrentPlanet, $CurrentUser, $Sprice);
        // END FIX BY JSTAR
        $this->BuildingSavePlanetRecord($CurrentPlanet);

        if ($Queue['lenght'] < (MAX_BUILDING_QUEUE_SIZE))
        {
            $CanBuildElement = true;
        }
        else
        {
            $CanBuildElement = false;
        }

        $BuildingPage        = "";
        $zaehler              = 1;

        foreach($lang['tech'] as $Element => $ElementName)
        {
            if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']]))
            {
                $CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet);
                if ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght']))
                {
                    $RoomIsOk = true;
                }
                else
                {
                    $RoomIsOk = false;
                }

                if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
                {
                    $HaveRessources            = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
                    $parse                     = array();
                    $parse                     = $lang;
                    $parse['dpath']            = $dpath;
                    $parse['i']                = $Element;
                    $BuildingLevel             = $CurrentPlanet[$resource[$Element]];
                    $parse['nivel']            = ($BuildingLevel == 0) ? "" : " (". $lang['bd_lvl'] . " " . $BuildingLevel .")";
                    
                    // ENERGIA AL LADO DE LOS EDIFICIOS #####################################################
                    $BuildLevelFactor     = 10;
                    $BuildTemp            = $CurrentPlanet[ 'temp_max' ];
                    $CurrentBuildtLvl     = $BuildingLevel;
                    $BuildLevel           = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
                    $EnergyTechLevel      = $CurrentUser["energy_tech"];
                    $Prod[4]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    
                                        * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                    $ActualNeed     = floor($Prod[4]);
                    $BuildLevel++;
                    $Prod[4]         = (floor(eval($ProdGrid[$Element]['formule']['energy'])    
                                        * $game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
                                        
                    $EnergyNeed = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );           
                    if ($Element >= 1 && $Element <= 3) {
                         $parse['energia'] = "("."<font color=#FF0000>". $EnergyNeed." ".$lang['Energy']."</font>".")";
                         $BuildLevel = 0;
                    }elseif ($Element == 4 || $Element == 12) {
                         $parse['energia'] = "("."<font color=#00FF00>+". $EnergyNeed." ".$lang['Energy']."</font>".")";
                         $BuildLevel = 0;
                    }
                                   
                   // FIN DE LA ENERGIA AL LADO DE LOS EDIFICIOS ##############################################
                    
                    $parse['n']                = $ElementName;
                    $parse['descriptions']     = $lang['res']['descriptions'][$Element];
/* OLD CODE ---------------------------------------------------- OLD CODE ------------------------------------- //
                    $ElementBuildTime          = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                    $parse['time']             = ShowBuildTime($ElementBuildTime);
                    $parse['price']            = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
   OLD CODE ---------------------------------------------------- OLD CODE ------------------------------------- //
*/
                    // START FIX BY JSTAR
                    $really_lvl             = ( isset ( $Sprice[$Element] ) ) ? $Sprice[$Element]:$BuildingLevel;
                    $ElementBuildTime         = GetBuildingTime ( $CurrentUser , $CurrentPlanet , $Element , $really_lvl );
                    $parse['price']         = GetElementPrice ( $CurrentUser , $CurrentPlanet , $Element , true , $really_lvl );
                    $parse['time']             = ShowBuildTime ( $ElementBuildTime );
                    // END FIX BY JSTAR

                    $parse['click']            = '';
                    $NextBuildLevel            = $CurrentPlanet[$resource[$Element]] + 1;

                    if ($RoomIsOk && $CanBuildElement)
                    {
                        if ($Queue['lenght'] == 0)
                        {
                            if ($NextBuildLevel == 1)
                            {
                                if ( $HaveRessources == true )
                                    $parse['click'] = "<a href=\"game.php?page=buildings&cmd=insert&building=". $Element ."\"><font color=#00FF00>".$lang['bd_build']."</font></a>";
                                else
                                    $parse['click'] = "<font color=#FF0000>".$lang['bd_build']."</font>";
                            }
                            else
                            {
                                if ( $HaveRessources == true )
                                    $parse['click'] = "<a href=\"game.php?page=buildings&cmd=insert&building=". $Element ."\"><font color=#00FF00>". $lang['bd_build_next_level'] . $NextBuildLevel ."</font></a>";
                                else
                                    $parse['click'] = "<font color=#FF0000>". $lang['bd_build_next_level'] . $NextBuildLevel ."</font>";
                            }
                        }
                        else
                        {
                            $parse['click'] = "<a href=\"game.php?page=buildings&cmd=insert&building=". $Element ."\"><font color=#00FF00>".$lang['bd_add_to_list']."</font></a>";
                        }
                    }
                    elseif ($RoomIsOk && !$CanBuildElement)
                    {
                        if ($NextBuildLevel == 1)
                            $parse['click'] = "<font color=#FF0000>".$lang['bd_build']."</font>";
                        else
                            $parse['click'] = "<font color=#FF0000>". $lang['bd_build_next_level'] . $NextBuildLevel ."</font>";
                    }
                    else
                        $parse['click'] = "<font color=#FF0000>".$lang['bd_no_more_fields']."</font>";

                    if ($siguiente==2) 
                        {
                        $parse['cerrartr'] = "</tr>";
                        $siguiente=0;
                        }
                        else $siguiente++;
                        $BuildingPage .= parsetemplate(gettemplate('buildings/buildings_builds_row'), $parse);

                    if ($Element == 31 && $CurrentUser["b_tech_planet"] != 0)
                    {
                        $parse['click'] = "<font color=#FF0000>".$lang['bd_working']."</font>";
                    }

                    if ( ( $Element == 21 or $Element == 14 or $Element == 15 ) && $CurrentPlanet["b_hangar"] != 0)
                    {
                        $parse['click'] = "<font color=#FF0000>".$lang['bd_working']."</font>";
                    }


                }
            }
        }

        if ($Queue['lenght'] > 0)
        {
            include($xgp_root . 'includes/functions/InsertBuildListScript.' . $phpEx);

            $parse['BuildListScript']  = InsertBuildListScript ("buildings");
            $parse['BuildList']        = $Queue['buildlist'];
        }
        else
        {
            $parse['BuildListScript']  = "";
            $parse['BuildList']        = "";
        }

        $parse['BuildingsList']        = $BuildingPage;
        $parse['planet_field_current'] = $CurrentPlanet["field_current"];
        $parse['planet_field_max']     = $CurrentPlanet['field_max'] + ($CurrentPlanet[$resource[33]] * 5);
        $parse['field_libre']          = $parse['planet_field_max']  - $CurrentPlanet['field_current'];  


        display(parsetemplate(gettemplate('buildings/buildings_builds'), $parse));
    }
}
?>