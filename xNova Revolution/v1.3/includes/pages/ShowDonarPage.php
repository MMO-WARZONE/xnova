<?php
/* Página de donar by principe negro */

if(!defined('INSIDE')){ die(header("location:../../"));}
function ShowDonarPage($user)
{

$paypal = "<center><form action=\"https://www.paypal.com/cgi-bin/webscr\" method=\"post\">";
$paypal .= "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">";
$paypal .= "<input type=\"hidden\" name=\"hosted_button_id\" value=\"7Y2FKHGY53YAU\">";
$paypal .= "<input type=\"image\" src=\"https://www.paypal.com/es_ES/ES/i/btn/btn_donateCC_LG.gif\" border=\"0\" name=\"submit\" alt=\"PayPal. La forma rápida y segura de pagar en Internet.\">";
$paypal .= "<img alt=\"\" border=\"0\" src=\"https://www.paypal.com/es_ES/i/scr/pixel.gif\" width=\"1\" height=\"1\">";
$paypal .= "</form></center>";

$text = "<center><b><font size=\"1\" face=\"arial\">Quieres donar algo de calidad? se usara para pagar servicios de hosting y dominios, as&iacute; como un soporte t&eacute;cnico para la mejor estabilidad posible.</font></b></center>";

echo $paypal;
echo $text;

}
?>

