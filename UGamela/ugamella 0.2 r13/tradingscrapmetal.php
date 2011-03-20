<?php  //tradingscrapmetal.php :: Comerciante de chatarra AddOn

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

includeLang('tradingscrapmetal');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
//Esta funcion permite cambiar el planeta actual.
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);

//setting
$price = 750;
//post
if($_POST){
	//si no se colocaron sondas
	if($_POST['number_of_probes']>0&&$planetrow[$resource[210]]!=0){
		//condicion si es mayor la cantidad que se quiere comprar
		if($_POST['number_of_probes']>$planetrow[$resource[210]]){
			$_POST['number_of_probes']=$planetrow[$resource[210]];
		}
		echo "{$planetrow['crystal']} - ".($_POST['number_of_probes']*750)."<br>";
		$planetrow['crystal']+=$_POST['number_of_probes']*750;
		$planetrow[$resource[210]]-=$_POST['number_of_probes'];
		doquery("UPDATE {{table}} SET crystal='{$planetrow['crystal']}',{$resource[210]}='{$planetrow[$resource[210]]}' WHERE id='{$user['id']}'",'planets');
		
	}

}
//Array para exparsir
$parse = $lang;
$parse['dpath'] = $dpath;
$parse['crystal'] = $price;
$parse['max_spy_probe'] = $planetrow[$resource[210]];//id para la sonda de espionaje
$parse['Merchant_give_you'] = str_replace('%n',gettemplate('tradingscrapmetal_n'),$lang['Merchant_give_you']);
$page = parsetemplate(gettemplate('tradingscrapmetal'), $parse);

display($page,$lang['Intergalactic_merchant']);

?>
