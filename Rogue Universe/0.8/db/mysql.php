<?
function doquery($query, $table, $fetch = false){
  global $numqueries,$link,$debug,$ugamela_root_path,$user;
	require($ugamela_root_path.'config.php');

/////////////// SECURITY STARTS //////////////////
	/* bad words */
	/*
	"TRUNCATE TABLE"
	"DROP TABLE"
	"RENAME TABLE"
	"CREATE DATABASE"
	"CREATE TABLE"
	"SET PASSWORD"
	"LOAD DATA"
	*/
	
	$badword = false;
	if ((stripos($query, 'RUNCATE TABL') != FALSE) && ($table != 'errors') && ($user['authlevel'] <= 1)) {
		$badword = true;
	}elseif (stripos($query, 'ROP TABL') != FALSE) {
		$badword = true;
	}elseif (stripos($query, 'ENAME TABL') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'REATE DATABAS') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'REATE TABL') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'ET PASSWOR') != FALSE) {	
		$badword = true;
	}elseif (stripos($query, 'EOAD DAT') != FALSE) {	
		$badword = true;
	}
	if ($badword) {
		$message = 'Hi, I don\'t know what you were trying to do, but the command you just sent to the database didn\'t look very friendly so we have blocked it.<br /><br />Your IP, useragent, and any other info we find will be logged along with the query you attempted to make. Good Day.';
		
		$report  = "Hacking attempt (".date("H:i:s d/m/Y")." - [".time()."]):\n";
		$report .= ">Database Info\n";
		$report .= "\tID - ".$user['id']."\n";
		$report .= "\tUser - ".$user['username']."\n";
		$report .= "\tAuth level - ".$user['authlevel']."\n";
		$report .= "\tAdmin Notes - ".$user['adminNotes']."\n";
		$report .= "\tCurrent Planet - ".$user['current_planet']."\n";
		$report .= "\tUser IP - ".$user['user_lastip']."\n";
		$report .= "\tUser IP at Reg - ".$user['ip_at_reg']."\n";
		$report .= "\tUser Agent- ".$user['user_agent']."\n";
		$report .= "\tCurrent Page - ".$user['current_page']."\n";
		$report .= "\tRegister Time - ".$user['register_time']."\n";

		$report .= "\n";

		$report .= ">Query Info\n";		
		$report .= "\tTable - ".$table."\n";
		$report .= "\tQuery - ".$query."\n";

		$report .= "\n";
	
		$report .= ">\$_SERVER Info\n";		
		$report .= "\tIP - ".$_SERVER['REMOTE_ADDR']."\n";
		$report .= "\tHost Name - ".$_SERVER['HTTP_HOST']."\n";
		$report .= "\tUser Agent - ".$_SERVER['HTTP_USER_AGENT']."\n";
		$report .= "\tRequest Method - ".$_SERVER['REQUEST_METHOD']."\n";
		$report .= "\tCame From - ".$_SERVER['HTTP_REFERER']."\n";
		$report .= "\tUses Port - ".$_SERVER['REMOTE_PORT']."\n";
		$report .= "\tServer Protocol - ".$_SERVER['SERVER_PROTOCOL']."\n";
		
		$report .= "\n--------------------------------------------------------------------------------------------------\n";

		$fp = fopen($ugamela_root_path.'badquerys.txt', 'a');
		fwrite($fp, $report);
		fclose($fp);
		
		die($message);
	}	
//////////// SECURITY ENDS //////////////

///////// ORIGINAL STUFF /////////////
	if(!$link)
	{$link = mysql_connect($dbsettings["server"], $dbsettings["user"], 
				$dbsettings["pass"]) or
				$debug->error(mysql_error()."<br />$query","SQL Error");

		mysql_select_db($dbsettings["name"]) or $debug->error(mysql_error()."<br />$query","SQL Error");
		mysql_query("SET NAMES latin2");
		echo mysql_error();}

	$sql = str_replace("{{table}}", $dbsettings["prefix"].$table, $query);
	$sqlquery = mysql_query($sql) or 
				$debug->error(mysql_error()."<br />$sql<br />","SQL Error");

	unset($dbsettings);
	$numqueries++;
  $arr = debug_backtrace();
  $file = end(explode('/',$arr[1]['file']));
  $line = $arr[1]['line'];
$debug->add("<tr><th>Query $numqueries: </th><th>$query</th><th>$file($line)</th><th>$table</th><th>$fetch</th></tr>");

	if($fetch)
	{$sqlrow = mysql_fetch_array($sqlquery);
		return $sqlrow;
	}else{return $sqlquery;}}
?>