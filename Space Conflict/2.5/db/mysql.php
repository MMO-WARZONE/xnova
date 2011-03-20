<?php

function doquery($query, $table, $fetch = false){
  global $link, $debug, $xnova_root_path;
	require($xnova_root_path.'config.php');

	if(!$link)
	{
		$link = mysql_connect($dbsettings["server"], $dbsettings["user"],
				$dbsettings["pass"]) or
				$debug->error(mysql_error()."<br />$query","SQL Error");

		mysql_select_db($dbsettings["name"]) or $debug->error(mysql_error()."<br />$query","SQL Error");
		echo mysql_error();
	}

	$sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);

	$sqlquery = mysql_query($sql) or
				$debug->error(mysql_error()."<br />$sql<br />","SQL Error");

	unset($dbsettings);

	global $numqueries,$debug;
	$numqueries++;
	$debug->add("<tr><th>Query $numqueries: </th><th>$query</th><th>$table</th><th>$fetch</th></tr>");

	if($fetch)
	{ 
		$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}else{ 
		return $sqlquery;
	}

}

?>