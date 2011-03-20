<?php
/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2010 por zhoed

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowPlanetMenu($CurrentUser)
{
    global $dpath;

$planets = "SELECT `id`,`name`,`galaxy`,`system`,`planet`,`planet_type`, `image`, `field_current`, `field_max`, `terraformer`, `mondbasis` FROM {{table}} WHERE `id_owner` = '" . $CurrentUser['id'] . "' AND `destruyed` = 0 ORDER BY ";

    $Order = ( $CurrentUser['planet_sort_order'] == 1 ) ? "DESC" : "ASC" ;
    $Sort  = $CurrentUser['planet_sort'];

    if($Sort == 0)
        $planets .= "`id` ". $Order;
    elseif($Sort == 1)
        $planets .= "`galaxy`, `system`, `planet`, `planet_type` ". $Order;
    elseif ($Sort == 2)
        $planets .= "`name` ". $Order;

$planets2 = doquery($planets, 'planets');

   while ($p = mysql_fetch_array($planets2))
{
    if ($p["destruyed"] == 0)
        {

          $ct     = $p["field_max"] + ($p["terraformer"] * FIELDS_BY_TERRAFORMER);
          if ($p['planet_type'] == 3)
          {
          $ct     = $p["field_max"];
          }

            $parse['planetmenulist'] .= "<center></br>";
            if ($p['planet_type'] == 1 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['planetmenulist'] .= "<td><div align=center><a href=game.php?page=$_GET[page]&gid=$_GET[gid]&cp=".$p['id']."&mode=".$_GET['mode']."&re=0 title=Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."><img src=".$dpath."planeten/small/s_".$p['image'].".gif border=0 height=35 width=35><br><font color=#2E9AFE>".$p['name']."&nbsp;</font><font color=#58FA58><br>[".$p['galaxy'].":".$p['system'].":".$p['planet']."]</font></a>";
            }
            elseif ($p['planet_type'] == 3 && $p["id"] != $CurrentUser["current_planet"])
            {
                $parse['planetmenulist'] .= "";
            }
            else
            {
                $parse['planetmenulist'] .= "<th><div align=center><a href=# title=Campos&nbsp;ocupados:&nbsp;".$p['field_current']."/".$ct."><img src=".$dpath."planeten/small/s_".$p['image'].".gif border=0 height=35 width=35><br><font color=#FFFF00>".$p['name']."&nbsp;</font><font color=#FE9A2E><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[".$p['galaxy'].":".$p['system'].":".$p['planet']."]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></a></div></th>";
            }
            $parse['planetmenulist'] .= "</center></table>";
        }
		$parse['date_time'] = date("D M j H:i:s", time());
}
    return parsetemplate(gettemplate('planet_menu'), $parse);
}
?>
