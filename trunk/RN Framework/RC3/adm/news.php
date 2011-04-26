<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] >= "2") {

	$parse = $lang;
	$query = doquery("SELECT * FROM {{table}} ORDER BY id ASC", "news");
	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		$parse['planetes'] .= "<tr>"
		. "<td class=b><center><b><a href='news.php?action=edit&id=".$u['id'] ."'>" . $u['id'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='news.php?action=edit&id=".$u['id'] ."'>" . $u['title'] . "</a></center></b></td>"
		. "<td class=b><center><b><a href='news.php?action=edit&id=".$u['id'] ."'>" . date("d.m.Y H:i:s",$u['date']) . "</a></center></b></td>"
		. "<td class=b><center><b><a href='news.php?action=edit&id=".$u['id'] ."'>" . $u['user'] . "</a></center></b></td>"
		. "<td class=b align=\"center\"><a href='news.php?action=delete&id=".$u['id'] ."' onclick=\"return confirm('Bist du sicher, dass du die Nachricht " . $u['title'] . " entfernen willst?');\"><img border=\"0\" src=\"../styles/images/r1.png\"></a></td>"
		. "</tr>";
		$i++;
	}
	$parse['planetes'] .= "<tr><td colspan=\"5\" align=\"center\"><a href=\"news.php?action=create\">News erstellen</a></td></tr>";
	$parse['planetes'] .= "<tr><th class=\"b\" colspan=\"8\">Insgesamt {$i} News vorhanden</th></tr>";

	if(($_GET['action'] == 'edit') && isset($_GET['id'])) {
		$query = doquery("SELECT * FROM {{table}} WHERE id = '".$_GET['id']."';", "news");
		$id = intval($_GET['id']);
		$planet = mysql_fetch_array($query);
		$parse['show_edit_form'] = parsetemplate(gettemplate('adm/news_edit_form'),$planet);
	}
	if($_GET['action'] == 'create') {
		$parse['show_edit_form'] = parsetemplate(gettemplate('adm/news_create_form'),$planet);
	}
	if(($_GET['action'] == 'delete') && isset($_GET['id'])) {
		doquery("DELETE FROM {{table}} WHERE `id` = '".$_GET['id']."' LIMIT 1;", "news");
	}
	if(isset($_POST['submit'])) {
		$edit_id 	= intval($_POST['currid']);
		$title 	= mysql_real_escape_string(addslashes(umlaute($_POST['title'])));
		$text =  preg_replace(array('/\\n/','/\\r/',), array('<br/>','',),mysql_real_escape_string(addslashes(umlaute($_POST['text']))));
		if(isset($_GET['gone'])) {
			$query = doquery("INSERT INTO {{table}} (`id` ,`user` ,`date` ,`title` ,`text`) VALUES ( NULL , '".$user['username']."', '".time()."', '".$title."', '".$text."');",'news');		
		} else {
			$query = doquery("UPDATE {{table}} SET 
								`title` 			= '".$title."',
								`text`				= '".$text."',
								`date`				= '".time()."'
								  WHERE `id` = '".$edit_id."' LIMIT 1;",'news');
			}
		header("location:news.php");
		}
	display(parsetemplate(gettemplate('adm/newslist_body'), $parse), false, '', true, false);
} else {
	message($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>