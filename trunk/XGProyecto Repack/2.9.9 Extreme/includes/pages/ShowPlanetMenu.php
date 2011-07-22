<?php
/*
ShowPlanetMenu.php v1.0
Creado por zhoed para XGProyect
Respeten los créditos, gracias.
*/
if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowPlanetMenu($CurrentUser)
{
    global $dpath, $lang;

    $planets = SortUserPlanets ($CurrentUser);

    while ($p = mysql_fetch_array($planets))
    {
        if ($p["destruyed"] == 0)
        {
            $ct     = $p["field_max"] + ($p["terraformer"] * FIELDS_BY_TERRAFORMER);
            
            if ($p['planet_type'] == 3)
            {
                $ct     = $p["field_max"];
            }
            
            if ($p['b_building'] != 0)
            {
                UpdatePlanetBatimentQueueList ($CurrentUserPlanet, $CurrentUser);
                
                if ($p['b_building'] != 0 )
                {
                    $BuildQueue      = $p['b_building_id'];
                    $QueueArray      = explode ( ";", $BuildQueue );
                    $CurrentBuild    = explode ( ",", $QueueArray[0] );
                    $BuildElement    = $CurrentBuild[0];
                    $BuildLevel      = $CurrentBuild[1];
                    $BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
                    $construccion = "".$lang['tech'][$BuildElement]."<br>(Construyendo nivel ".$BuildLevel.")<br>Tiempo restante:".$BuildRestTime."";
                }
                else
                {
                    CheckPlanetUsedFields ($p);
                    $construccion = $lang['ov_free'];
                }
            }
            else
            {
                $construccion = $lang['ov_free'];
            }
            
            $popup = "".$p['name']."&nbsp;[".$p['galaxy'].":".$p['system'].":".$p['planet']."]<br>Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."<br>".$construccion."";
            
            if($t == 0)
            {
                $parse['mplanet'] .= "<th text-decoration:none>";
            }
            
            if ($p['planet_type'] == 1 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['mplanet'] .= "<div align=center><a class=mplanet href=game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$p['id']."&mode=".$_GET['mode']."&re=0 onmouseover=\"return overlib('".$popup."', CENTER, OFFSETX, -80, OFFSETY, 20, WIDTH, 200)\" onmouseout=\"return nd();\"><img src=".$dpath."/planeten/".$p['image'].".jpg border=0 height=78 width=78><br><font color=#2E9AFE>".$p['name']."&nbsp;</font><font color=#58FA58><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a>";
            }
            elseif ($p['planet_type'] == 3 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['mplanet'] .= "<div align=center><a class=mplanet href=game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$p['id']."&mode=".$_GET['mode']."&re=0 onmouseover=\"return overlib('".$popup."', CENTER, OFFSETX, -80, OFFSETY, 20, WIDTH, 200)\" onmouseout=\"return nd();\"><img src=".$dpath."/planeten/".$p['image'].".jpg border=0 height=78 width=78><br>".$p['name']." (Luna)&nbsp;<font color=#58FA58><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a>";
            }
            else
            {
                $parse['mplanet'] .= "<div align=center><a class=mplanet href=# onmouseover=\"return overlib('".$popup."', CENTER, OFFSETX, -80, OFFSETY, 20, WIDTH, 200)\" onmouseout=\"return nd();\"><img src=".$dpath."/planeten/".$p['image'].".jpg border=0 height=78 width=78><br><font color=#FFFF00>".$p['name']."&nbsp;</font><font color=#FE9A2E><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a></div>";
            }
            
            if($t == 6) //Modificar este valor si queremos modificar los planetas que aparecen por columna
            {
                $parse['mplanet'] .= "</th>";
                $t = 0;
            }else{
                $t = $t+1;
            }            
        }
    }
    $parse['mplanet'] .= "</center></table>";
    
    return parsetemplate(gettemplate('planet_menu'), $parse);
}
?> 
