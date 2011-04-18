<?php

/**
  * ShowGalaxySelector.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function ShowGalaxySelector ( $Galaxy, $System, $CurrentMIP, $CurrentRC, $CurrentGRC, $CurrentSP) {
    global $lang, $dpath, $maxfleet_count, $fleetmax;

    $LegendPopup = GalaxyLegendPopup ();
    $Recyclers = pretty_number($CurrentRC);
    $Gigarecyclers = pretty_number($CurrentGRC);
    $SpyProbes = pretty_number($CurrentSP);

    if ($Galaxy > 9) {
        $Galaxy = 9;
    }

    if ($Galaxy < 1) {
        $Galaxy = 1;
    }

    if ($System > 499) {
        $System = 499;
    }

    if ($System < 1) {
        $System = 1;
    }

    $Result  = "

<form action=\"galaxy.php?mode=1\" method=\"post\" id=\"galaxy_form\"><input type=\"hidden\" id=\"auto\" value=\"dr\" >

<table>
    <tr><td>

        <table>
            <tr><td><a onclick=\"galaxy_submit('galaxyLeft')\" type=\"button\" ><img src=\"./styl/image/gala/links.gif\"  style=\"width:24px; height:24px\" alt=\"links.png\"></a></td>
                <td><input name=\"galaxy\" value=\"". $Galaxy ."\" size=\"3\" maxlength=\"3\" type=\"text\"></td>
                <td><a onclick=\"galaxy_submit('galaxyRight')\" type=\"button\"><img src=\"./styl/image/gala/rechts.gif\" style=\"width:24px; height:24px\" alt=\"links.png\"></a></td></tr>
        </table>

        </td></tr>
    <tr><td rowspan=\"2\">

        <table>
            <tr><td><a onclick=\"galaxy_submit('systemLeft')\" type=\"button\" ><img src=\"./styl/image/gala/links.gif\"  style=\"width:24px; height:24px\" alt=\"links.png\"></a></td>
                <td><input name=\"system\" value=\"". $System ."\" size=\"3\" maxlength=\"3\" type=\"text\"></td>
                <td><a onclick=\"galaxy_submit('systemRight')\" type=\"button\"><img src=\"./styl/image/gala/rechts.gif\" style=\"width:24px; height:24px\" alt=\"links.png\"></a></td></tr>
        </table>

        </td></tr>
    <tr><td>

        <table>
            <tr><td align=\"center\"><input value=\"". $lang['gala']['0101'] ."\" type=\"submit\"></td></tr>
        </table>

        </td></tr>
    <tr><td style=\"height:15px;\"></td></tr>
    <tr><td colspan='2'>

        <table>
            <tr><td align=\"left\" colspan='2'>". $lang['gala']['5003'] ." ". $lang['gala']['0102'] ." ".$Galaxy."". $lang['gala']['5002'] ."".$System."</td></tr>
        </table>

        </td></tr>
</table>

<br><br><br>

<table>
    <tr><td align=\"center\" colspan='2'>". $LegendPopup ."</td></tr>
    <tr><td align=\"left\" colspan='2'>- <span id=\"interplanetary_misil\">". $CurrentMIP ."  </span> ". $lang['gala']['0103'] ."                </td></tr>
    <tr><td align=\"left\" colspan='2'>- <span id=\"recyclers\">". $CurrentRC  ."             </span> ". $lang['gala']['0104'] ."                </td></tr>
    <tr><td align=\"left\" colspan='2'>- <span id=\"giga_recycler\">". $CurrentGRC  ."        </span> ". $lang['gala']['0105'] ."                </td></tr>
    <tr><td align=\"left\" colspan='2'>- <span id=\"probes\">". $CurrentSP ."                 </span> ". $lang['gala']['0106'] ."                </td></tr>
    <tr><td align=\"left\" colspan='2'>- <span id=\"slots\">". $maxfleet_count ."             </span>/". $fleetmax ." ". $lang['gala']['0107'] ."</td></tr>
</table>

</form>";

    return $Result;

}
?>