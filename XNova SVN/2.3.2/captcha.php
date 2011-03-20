<?php
//version 1
session_start();
header('content-type: text/css');
$expires = 60*60*24*14;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

include_once($svn_root.'includes/functions/classes/captcha.class.php');
$captcha = new captchas();

include_once($svn_root.'config.php');
include_once($svn_root.'includes/functions/classes/MySqlDatabase.php');
$db = new MySqlDatabase();
$captcha->seguridad=array("noise"=>$db->game_config["captcha"]+$captcha->seguridad["noise"],
                          "blur" => $db->game_config["captcha"]+$captcha->seguridad["blur"] );
$captcha->captcha();
$_SESSION['CAPTCHAString'] = $captcha->getCaptchaString();
?>