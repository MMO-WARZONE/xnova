<?php

/**
  * GalaxyRowDebris.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowDebris ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
    global $lang, $dpath, $CurrentRC, $CurrentGRC, $user, $pricelist, $CurrentPlanet;

    $Result  = "<td style=\"white-space:'nowrap'; width:'30px;' hight:'30px;'\" align='center'>";

    if ($GalaxyRow) {

        if ($GalaxyRow["metal"] != 0 || $GalaxyRow["crystal"] != 0 ) {

            If ($CurrentGRC > 0){
                $Kapazität = $pricelist[219]['capacity'];
                $RecNeeded = ceil(($GalaxyRow["metal"] + $GalaxyRow["crystal"] + $GalaxyRow["appolonium"]) /$Kapazität );
            } else  {
                $Kapazität = $pricelist[209]['capacity'];
                $RecNeeded = ceil(($GalaxyRow["metal"] + $GalaxyRow["crystal"] + $GalaxyRow["appolonium"]) /$Kapazität );
            }

            $Result  = "<td align='center' style=\"width:30px; hight:30px;";

            if       (($GalaxyRow["metal"] + $GalaxyRow["crystal"]+ $GalaxyRow["appolonium"]) >= 30) {
                $Result .= "  background-color: rgb(100, 0, 0);\">";
            } elseif (($GalaxyRow["metal"] + $GalaxyRow["crystal"]+ $GalaxyRow["appolonium"]) >= 100000000) {
                $Result .= "  background-color: rgb(100, 100, 0);\">";
            } elseif (($GalaxyRow["metal"] + $GalaxyRow["crystal"]+ $GalaxyRow["appolonium"]) >= 100000) {
                $Result .= "  background-color: rgb(0, 100, 0);\">";
            } else {
                $Result .= " \">";
            }

            $Result .= "<a style=\"cursor: pointer;\"";
            $Result .= " onmouseover='return overlib(\"";
            $Result .= "<table width=270px cellspacing=0px>";
            $Result .= "<tr><td class=c align=center rowspan=5 width=60px><img src=". $dpath ."planeten/tf/debris.gif height=50px width=50px>                                                                                                    </td></tr>";
            $Result .= "<tr><td class=c colspan=2 align=center width=140px>".$lang['gala']['0403']."                                                                                                                                             </td></tr>";
            $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0401']."".$lang['gala']['5002']."</td><td class=c align=left width=110px> ". number_format( $GalaxyRow['metal'], 0, '', '.') ."        </td></tr>";
            $Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0402']."".$lang['gala']['5002']."</td><td class=c align=left width=110px> ". number_format( $GalaxyRow['crystal'], 0, '', '.') ."      </td></tr>";
			$Result .= "<tr><td class=c align=left width=110px>".$lang['gala']['5003']." ".$lang['gala']['0410']."".$lang['gala']['5002']."</td><td class=c align=left width=110px> ". number_format( $GalaxyRow['appolonium'], 0, '', '.') ."   </td></tr>";
            $Result .= "</table><table width=270px cellspacing=0px><tr>";
            $Result .= "<td colspan=2 class=c align=center>";

            If ($CurrentGRC > 0 and $CurrentGRC >= $RecNeeded  ){
                $Result .="".$CurrentRC ."  ". $lang['gala']['0404'] ."<br>";
                $Result .="".$CurrentGRC ." ". $lang['gala']['0405'] ."<br>";
                $Result .="". $lang['gala']['0409'] ."<br />";
                $Result .= "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=8>      ".$RecNeeded."". $lang['gala']['0407'] ."</a>";
            } else {
                $Kapazität = $pricelist[209]['capacity'];
                $RecNeeded = ceil(($GalaxyRow["metal"] + $GalaxyRow["crystal"]+ $GalaxyRow["appolonium"]) /$Kapazität );

                If ($CurrentRC > 0 and $CurrentRC >= $RecNeeded  ){
                    $Result .="".$CurrentRC ."  ". $lang['gala']['0404'] ."<br>";
                    $Result .="".$CurrentGRC ." ". $lang['gala']['0405'] ."<br>";
                    $Result .="". $lang['gala']['0409'] ."<br>";
                    $Result .= "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=8>  ".$RecNeeded."". $lang['gala']['0406'] ."</a>";
                }else{
                    $Result .="".$CurrentRC ."  ". $lang['gala']['0405'] ."<br>";
                    $Result .="".$CurrentGRC ." ". $lang['gala']['0406'] ."<br>";
                    $Result .="". $lang['gala']['0408'] ."<br>";
                    $Result .= "<a href=fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=8>      ". $lang['gala']['0408'] ."</a>";
                }
            }
            $Result .= "</td></tr></table>\"";
            $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
            $Result .= " onmouseout='return nd();'>";
            $Result .= "<img src='". $dpath ."planeten/tf/debris.gif' alt='debris.gif' style='height:22px; width:22px;'></a>";
        }
    }
    $Result .= "</td>";
    return $Result;
}

?>