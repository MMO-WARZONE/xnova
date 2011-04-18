<?php


function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser ) {
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

if ($ActualCount != 0) {
  $ListIDRow        .= "<tr><td class='c' colspan='3' align='center'>".$lang['Constructions']."<font color='#00FF00'>".$ActualCount."</font> von <font color='#FF0000'>". MAX_BUILDING_QUEUE_SIZE ."</font></td></tr>";
  $PlanetID          = $CurrentPlanet['id'];
  $totalBuildTime    = 0;
  $totalBuildEndTime = time();

if((MAX_BUILDING_QUEUE_SIZE - $ActualCount) > 0){
   $CanBuild = true;
   }else{
      $Canbuild = false;
   }

   foreach($reslist['build'] as $Element){
   $BuildingNow[$Element] = $CurrentPlanet[$resource[$Element]];
}

for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) {
  $BuildArray   = explode (",", $QueueArray[$QueueID]);
  $BuildEndTime = floor($BuildArray[3]);
  $CurrentTime  = floor(time());
  if ($BuildEndTime >= $CurrentTime)

     {
       $ListID                = $QueueID + 1;
       $Element               = $BuildArray[0];
       $BuildingNow[$Element] = $BuildArray[1];
       $BuildLevel            = $BuildArray[1];
       $BuildMode             = $BuildArray[4];
       $BuildTime             = $BuildEndTime - time();
       $totalBuildTime        = $BuildTime;
       $totalBuildEndTime     = $BuildEndTime;
       $ElementTitle          = $lang['tech'][$Element];

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
                        $levelmore = "<a href='buildings.php?cmd=$modo_rep&building=".$Element."'>".$lang['Next']."</a> ";
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
                            $ListIDRow .= "                <td width='80' rowspan='2'><a href='infos.php?gid=".$Element."'><img border='0' src='".$dpath."gebaeude/".$Element.".gif' align='top' title='". $ElementTitle ."' width='80' height='80'></a></td>";
                            if ($BuildMode == 'build')
                            {
                                $ListIDRow .= "            <td><center>";
                                $ListIDRow .= "            <table>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td class='c' width='24'><img border='0' src='./images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            <td class='c'><center><font color =\"#6699FF\"><a href='infos.php?gid=".$Element."'><font color =\"#6699FF\">- ". $ElementTitle ." </font></a><br />".$lang['BuildNextLevel']."<font color=\"#FF8C00\"><b>".$lang['level']." ". $BuildLevel ."</b></font></font></center></td>";
                                $ListIDRow .= "            <td class='c' width='24'><img border='0' src='./images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td class='c' colspan='3'><center>". $levelmore . "</center></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            </table>";
                                $ListIDRow .= "            </center></td>";
                            } else {
                                $ListIDRow .= "            <td class='c'><center>";
                                $ListIDRow .= "            <table>";
                                $ListIDRow .= "            <tr>";
                                $ListIDRow .= "            <td class='c' width='24'><img border='0' src='./images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            <td class='c'><center><font color =\"#6699FF\"><a href='infos.php?gid=".$Element."'><font color =\"#6699FF\"> ". $ElementTitle ." </font></a><br /><font color=\"#87CEEB\"><blink>". $lang['bd_dismantle'] ."</blink></font> en <font color=\"#FF8C00\"><b>Nivel ". $BuildLevel ."</b></font></font></center></td>";
                                $ListIDRow .= "            <td class='c' width='24'><img border='0' src='./images/enproceso.gif' align='top' width='24' height='24'></td>";
                                $ListIDRow .= "            </tr>";
                                $ListIDRow .= "            </table>";
                                $ListIDRow .= "            </center></td>";
                            }
                            $ListIDRow .= "            <td class='c' width=\"56\" rowspan='2'><center>";
                            $ListIDRow .= "                <div id=\"blc\" class=\"z\">". $BuildTime ."<br><a href=\"buildings.php?listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">".$lang['bd_interrupt']."</a></div>";
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
                            $ListIDRow .= "<td class='c' colspan=\"3\">";
                            $ListIDRow .= "    <table width=\"100%\">";
                            $ListIDRow .= "        <tr>";
                            if ($BuildMode == 'build')
                            {
                                $ListIDRow .= "               <td class=\"c\"><font color =\"#6699FF\">". $ListID ." <a href='infos.php?gid=".$Element."'><font color =\"#6699FF\">- ". $ElementTitle ." </font></a>".$lang['BuildNextLevel']."<font color=\"#FF8C00\"><b>".$lang['level']." ". $BuildLevel ."</b></font></font></td>";
                            } else {
                                $ListIDRow .= "               <td class=\"c\"><font color =\"#6699FF\">". $ListID ." <a href='infos.php?gid=".$Element."'><font color =\"#6699FF\">- ". $ElementTitle ." </font></a> <font color=\"#87CEEB\"><blink>". $lang['bd_dismantle'] ."</blink></font>".$lang['into']." <font color=\"#FF8C00\"><b>".$lang['level']." ". $BuildLevel ."</b></font></font></td>";
                            }
                            $ListIDRow .= "               <td class=\"c\" width=\"56\"><center>". $levelmore . "</center></td>";
                            $ListIDRow .= "               <td class=\"c\" width=\"56\">";
                            $ListIDRow .= "                   <font color=\"red\"><a href=\"buildings.php?listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">".$lang['cancel']."</a></font>";
                            $ListIDRow .= "               </td>";
                            $ListIDRow .= "        </tr>";
                            $ListIDRow .= "   </table>";
                            $ListIDRow .= "</th>";
                        }
                        $ListIDRow .= "</tr>";
                    }
                }
            }

            $ListIDRow .= "<tr><td class='c' colspan='3'><center>".$lang['ConstructionTime']." ". pretty_time($totalBuildTime) ."<br/>".$lang['ConstructionDateTime'].": <strong color=\"lime\"><font color=\"lime\">". date("j/m H:i:s" ,$totalBuildEndTime ) ."</font></strong></center></td></tr>";
        }

        $RetValue['lenght']    = $ActualCount;
        $RetValue['buildlist'] = $ListIDRow.'';

        return $RetValue;
}

?>