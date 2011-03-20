<?php
//version 2.3
header('content-type: text/css');
$expires = 60*60*24*14;
header("Pragma: public");
header("Cache-Control: maxage=".$expires);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
header("Accept-Encoding: gzip, deflate");

define('INSIDE'  , true);
define('INSTALL' , false);

$svn_root="./";

$dpath     = $_GET["skin"]  ;
$dpath2    = "styles/css/"  ;
include_once($svn_root . 'config.php');
include_once($svn_root . 'includes/functions.php');
foreach ($_GET as $key => $value) {
    $value=encrypt($value,true);
    if(is_file($value)){
        $css.="/*Archivo ".basename($value)."*/\n";
        $css_ss=file_get_contents($value);
        $css_ss=str_replace("\n","",$css_ss);
        $css_ss=str_replace("\r","",$css_ss);
        $css_ss=preg_replace("/{style_style}/i",$dpath,$css_ss);
        
        $css.=preg_replace("/{style_ui}/i",$dpath2,$css_ss);

        $css.="\n";
        $css.="\n";
    }
    
}
echo $css;

exit;
?>