<?php

/**
  * GalaxyRowPos.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GalaxyRowPos ( $GalaxyRow, $Galaxy, $System, $Planet ) {
    $Result  = "<td style='width:30px height:30px' align='center' >";
    $Result .= "<a href=\"fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=0&amp;target_mission=7\"";

    if ($GalaxyRow) {
        $Result .= " tabindex=\"". ($Planet + 1) ."\"";
    }
    $Result .= ">". $Planet ."</a>";
    $Result .= "</td>";
    return $Result;
}

?>