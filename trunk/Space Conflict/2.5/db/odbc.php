<?php

function doquery($query, $table, $fetch = false){
  global $link,$debug,$xnova_root_path;

	@include($xnova_root_path.'config.php');

	if(!$link)
	{
		$link = odbc_connect($dbsettings["server"], $dbsettings["user"], 
				$dbsettings["pass"]) or
				$debug->error(odbc_error()."<br />$query","SQL Error");
		
		odbc_select_db($dbsettings["name"]) or $debug->error(odbc_error()."<br />$query","SQL Error");
	}

	$sqlquery = odbc_exec($query, str_replace("{{table}}", $dbsettings["prefix"].
				$table)) or 
				$debug->error(odbc_error()."<br />$query","SQL Error");

	unset($dbsettings);

	global $numqueries,$debug;
	$numqueries++;
	$debug->add("<tr><th>Query $numqueries: </th><th>$query</th><th>$table</th><th>$fetch</th></tr>");

	if($fetch)
	{ 
		$sqlrow = odbc_fetch_array($sqlquery);
		return $sqlrow;
	}else{ 
		return $sqlquery;
	}
	
}

?>