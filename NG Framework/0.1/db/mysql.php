<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */


function doquery($query, $table, $fetch = false)
{
	global $link, $debug, $ugamela_root_path;

	require($ugamela_root_path.'config.php');

	if (!$link)
	{
		$link = mysql_connect($dbsettings['server'], $dbsettings['user'], 
				$dbsettings['pass']) or
				$debug->error(mysql_error().'<br />'.$query, 'SQL Error');
		
		mysql_select_db($dbsettings['name']) or $debug->error(mysql_error().'<br />'.$query, 'SQL Error');
		//[FIX] Permitir uso de á,é,í,ó,ú,ñ, etc
		//mysql_query("set character set utf8");
		//mysql_query("set names utf8");
		//Fin Fix
		echo mysql_error();
	}
	// at the moment $query si showed, but later only is seen in debug mode

	$sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);

	$sqlquery = mysql_query($sql) or 
				$debug->error(mysql_error()."<br />$sql<br />","SQL Error");

	unset($dbsettings); // we delete the array to free some of memory

	global $numqueries, $debug;
	$numqueries++;

	$debug->add("<tr><th>Query $numqueries:</th><th>$query</th><th>$table</th><th>$fetch</th></tr>");

	if ($fetch)
	{ // do a fetch and return $sqlrow
		$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}
	else
	{ // return $sqlquery ("without fetch")
		return $sqlquery;
	}
	
}
// Created by Perberos. All rights reversed (C) 2006
?>