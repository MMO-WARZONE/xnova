<?PHP //leftmenu.php :: Menu de la izquierda
{//init
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}
$mf = "Mainframe";
{$link = array(
		"image1" => array( "src" => $dpath."gfx/ogame-produktion.jpg", "width" => "110", "height" => "40" ),
		$lang["Overview"] => array("href" => "overview.php", "accesskey" => "v", "target" => $mf),
		$lang["Buildings"] => array("href" => "b_building.php", "accesskey" => "e", "target" => $mf),
		$lang["Resources"] => array("href" => "resources.php", "accesskey" => "i", "target" => $mf),
		$lang["Research"] => array("href" => "buildings.php?mode=research", "accesskey" => "h", "target" => $mf),
		$lang["Shipyard"] => array("href" => "buildings.php?mode=fleet", "accesskey" => "u", "target" => $mf),
		$lang["Fleet"] => array("href" => "fleet.php", "accesskey" => "t", "target" => $mf),
		$lang["Technology"] => array("href" => "techtree.php", "accesskey" => "g", "target" => $mf),
		$lang["Galaxy"] => array("href" => "galaxy.php", "accesskey" => "s", "target" => $mf),
		$lang["Defense"] => array("href" => "buildings.php?mode=defense", "accesskey" => "d", "target" => $mf),
		"image2" => array( "src" => $dpath."gfx/info-help.jpg", "width" => "110", "height" => "19" ),
		$lang["Alliance"] => array("href" => "alliance.php", "accesskey" => "a", "target" => $mf),
		//"Foro" => array("href" => "http://perberos.pe.funpic.de/forum.php?frameset=1", "accesskey" => "1", "target" => "_new"),
		$lang["Board"] => array("href" => "forum.php", "accesskey" => "1", "target" => $mf),
		$lang["Statistics"] => array("href" => "stat.php?start=601", "accesskey" => "k", "target" => $mf),
		$lang["Search"] => array("href" => "search.php", "accesskey" => "b", "target" => $mf),
		$lang["Help"] => array("href" => "http://tutorial.ogame.de/index.php?newlang=en", "accesskey" => "y", "target" => "_new"),
		"image3" => array( "src" => $dpath."gfx/user-menu.jpg", "width" => "110", "height" => "35" ),
		$lang["Messages"] => array("href" => "messages.php", "accesskey" => "c" , "target" => $mf),
		$lang["Notes"] => array("href" => "#", "onclick" => "f('notes.php', 'Report');" , "accesskey" => "n"),
		$lang["Buddylist"] => array("href" => "buddy.php", "accesskey" => "c", "target" => $mf),
		$lang["Options"] => array("href" => "options.php", "accesskey" => "o", "target" => $mf),
		$lang["Logout"] => array("href" => "javascript:top.location.href='logout.php'", "accesskey" => "s"),
		$lang["Rules"] => array("accesskey" => "6", "target" => "_new"),
		$lang["Legal Notice"] => array("accesskey" => "3", "target" => "_new")
);
}
echo <<<HTML
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset={$lang['ENCODING']}">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>
</head>
<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0"> 
<center>
<a href="mailto:webmaster@perberos.no-ip.info" title="Si tenes problemas, envia un email webmaster@perberos.no-ip.info."></a>
<p>{$lang['Multiverse']} (<a href="changelog.php" target=$mf>v 0.0</a>)</p>
HTML;
//Para el modo programador ^_^
if($userrow['authlevel'] == 3){
	$link['Admin'] = array("href" => "admin", "accesskey" => "9", "target" => $mf);
}
//Tabla Loop
echo '<table width="110" cellspacing="0" cellpadding="0">';
foreach($link as $a => $b){
  echo "<tr><td>";
  if(!isset($b["src"])){echo '<div align="center"><font color="#FFFFFF"><a';}else{echo '<img';}
  foreach($b as $property => $value){echo " $property=\"$value\""; }
  if(!isset($b["src"])){ echo ">$a</a></font></div>";}else{echo "/>";}
  echo "</td></tr>\n";
}
echo "</table>\n";//fin tabla loop
//Perberos PayPal Banner :/
echo '<p><!-- una moneda pa\' la torre? --><form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_new">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="image" src="img/donate.jpg" border="0" name="submit" alt="Donate with PayPal - it\'s fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
</form></p>';
//Prody E-Gold
//echo '<a href="http://3056984.e-gold.com/" target="_new"><img src="img/e-gold.gif"></a>';
echo "</center></body></html>";
if(isset($link)) mysql_close();
// Created by Perberos. All rights reversed (C) 2006
?>
