<?php
/*$host = "localhost"; // je hostname, meestal localhost
$user = "asschen"; // je username
$pass = "0"; // je wachtwoord
$dbas = "asschen"; // je database-naam
// connect naar database
if(mysql_connect($host, $user, $pass)) {
  // selecteer database
  mysql_select_db($dbas) or die(mysql_error());
} else {
  // connecten naar database is mislukt
  echo "Failed to connect to database.";
  exit;
}*/ 

/*define("UNIVERSE",1);
define("ROOT_PATH","../");
define('INSIDE'  , true);
define('INSTALL' , false);
include_once(ROOT_PATH."db/mysql.php");*/

$dbsettings = Array(
"type"		=> "mysql",			// Database type, enter "mysql" or "sqlite"
"server"	=> "localhost",		// MySQL server name, leave blank for SQLite.
"user"       => "evo_game",		// MySQL username, leave blank for SQLite.
"pass"       => "sunshine@#&",	// MySQL password, leave blank for SQLite.
"name"       => "evo_ugamela",	// MySQL database name or SQLite database filename, eg ROOT_PATH.'db/xnova.db'.
"prefix"     => "beta_board_",		// Tables prefix (for both SQLite and MySQL).
"secretword" => "XR123");	
	// Cookies (for both SQLite and MySQL).	

// connect naar database
if(mysql_connect($dbsettings['server'], $dbsettings['user'], $dbsettings['pass'])) {
  // selecteer database
  mysql_select_db($dbsettings['name']) or die(mysql_error());
} else {
  // connecten naar database is mislukt
  echo "Failed to connect to database.";
  exit;
}

function doquery($query, $table = '', $fetch = false, $allow_delete = false, $prefix = true){
	global $dbsettings;
	
	if($prefix) $sql = str_replace("{{table}}", "`".$dbsettings["prefix"].$table."`", $query);
	else $sql = str_replace("{{table}}", "`".$table."`", $query);
	$sql = str_replace("{{prefix}}", $dbsettings["prefix"], $sql);
		
	$sql = str_replace("``", "`", $sql);
	
	$sqlquery = mysql_query($sql);
		
	if($fetch){
		return mysql_fetch_assoc($sqlquery);
	}else{
		return $sqlquery;
	}
}


function sha($string,$salt=''){
	$str = $string.$salt;
	if (function_exists("hash")){
		return hash("sha256", $str, false);
	}else{
		sha1($str);
	}
}

?>
