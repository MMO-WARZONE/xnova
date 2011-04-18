<?php

/**
 * ShowGalaxyFooter.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxyFooter ( $Galaxy, $System,  $CurrentMIP, $CurrentRC, $CurrentGRC, $CurrentSP) {
    global $lang, $maxfleet_count, $fleetmax, $planetcount;

        $Result .= "
<table cellspacing=\"0\" style=\"width:700px\">
    <tr><td><span id=\"missiles\"></span></td></tr>

    <tr style=\"display: none;\" id=\"fleetstatusrow\"><td>

        <!--<div id=\"fleetstatus\"></div>-->

            <table style=\"font-weight: bold\" width=\"100%\" id=\"fleetstatustable\"><tr><td></td></tr>
               <!-- will be filled with content later on while processing ajax replys -->
            </table>
            </td></tr>
</table>";

        return $Result;
}

?>