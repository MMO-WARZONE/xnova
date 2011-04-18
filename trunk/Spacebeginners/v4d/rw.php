<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('tech');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$open = true;
$reportid = $_GET["raport"];
$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_escape_string($_GET["raport"]))."';", 'rw', true);

if ($allow == 1 || $open) {
    $Page  = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
              <html>
              <head>
              <title>Space Beginners</title>

              <link rel='shortcut icon' href='favicon.ico'>
              <link rel='stylesheet' type='text/css' href='".$dpath."formate.css'>
              <link rel='stylesheet' type='text/css' href='".$dpath."default.css'>
              <meta http-equiv='content-type' content='text/html; charset=utf-8'>
              </head>

              <body>
              <center>

              ";

    if (($raportrow["owners"] == $user["id"]) and
        ($raportrow["a_zestrzelona"] == 1)) {
        $Page .= "<td>Contact with the attacking fleet has been lost.<br>";
        $Page .= "(This means that is was destroyed in the first round.)</td>";
    } else {
        $report = stripslashes($raportrow["raport"]);

        foreach ($lang['tech_rc'] as $id => $s_name) {
            $str_replace1  = array("[ship[".$id."]]");
            $str_replace2  = array($s_name);
            $report = str_replace($str_replace1, $str_replace2, $report);
        }

        $no_fleet = "<table align='center' cellpadding='0' cellspacing='0'>
                         <tr><td class='sb' align='center'>Type          </td></tr>
                         <tr><td class='sb' align='center'>Total         </td></tr>
                         <tr><td class='sb' align='center'>Weapons       </td></tr>
                         <tr><td class='sb' align='center'>Shields       </td></tr>
                         <tr><td class='sb' align='center'>Armour        </td></tr>
                     </table>";
        $destroyed = "<table align='center' cellpadding='0' cellspacing='0'>
                          <tr><td class='sb' align='center' style='color:#FF0000;'><strong>Destroyed!</strong></td></tr>
                      </table>";
        $str_replace1  = array($no_fleet);
        $str_replace2  = array($destroyed);
        $report = str_replace($str_replace1, $str_replace2, $report);
        $Page .= $report;
    }

    $Page .= "<br><br>";
    $Page .= "Share this report - ";
    $Page .= $reportid;
    $Page .= "<br><br>
              </center>
              </body>
              </html>
              ";

    echo $Page;
}

?>