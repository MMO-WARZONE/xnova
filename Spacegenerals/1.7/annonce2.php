<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);
includeLang('annonce');

// Schutz vor unregestrierten
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

$actions = $_GET['action'];

if($actions == 2)
{
	$page .=<<<HTML
	<center>
	<br>
	<table width="600">
	<td class="c" colspan="10" align="center"><b><font color="white">{$lang['ANNONCE_CREATE_ANNONCE']}</font></b></td></tr>
	<td class="c" colspan="10" align="center"><b>{$lang['ANNONCE_BID_RESOURCES']}</font></b></td></tr>

	<form action="annonce.php?action=5" method="post">
	<tr><th colspan="5">{$lang['ANNONCE_METAL']}</th><th colspan="5"><input type="texte" value="0" name="metalvendre" /></th></tr>
	<tr><th colspan="5">{$lang['ANNONCE_CRYSTAL']}</th><th colspan="5"><input type="texte" value="0" name="cristalvendre" /></th></tr>
	<tr><th colspan="5">{$lang['ANNONCE_DEUT']}</th><th colspan="5"><input type="texte" value="0" name="deutvendre" /></th></tr>
	<td class="c" colspan="10" align="center"><b>{$lang['ANNONCE_NEED_RESOURCES']}</font></b></td></tr>
	<tr><th colspan="5">{$lang['ANNONCE_METAL']}</th><th colspan="5"><input type="texte" value="0" name="metalsouhait" /></th></tr>
	<tr><th colspan="5">{$lang['ANNONCE_CRYSTAL']}</th><th colspan="5"><input type="texte" value="0" name="cristalsouhait" /></th></tr>
	<tr><th colspan="5">{$lang['ANNONCE_DEUT']}</th><th colspan="5"><input type="texte" value="0" name="deutsouhait" /></th></tr>
	<tr><th colspan="10"><input type="submit" value="{$lang['ANNONCE_SUBMIT']}" /></th></tr>

	$page2

	<form>
	</table>
HTML;

	display($page);
}
?>