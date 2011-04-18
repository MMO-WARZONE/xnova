<?php
/* pdo.php
/* written by RedFighter and gianluca311
/* version 0.1 */


define("ERROR_FILER_FOLDER", XNOVA_ROOT_PATH.'errors/');


class DB extends PDO {

    public static $NumQuerys = 0;
    public static $queryTime = 0;
	public static $lastQuery = null;
	
    public function query($statement)
    {
            $this->increaseQueryCounter();
            $timeStart = microtime(true);

            $res = parent::query($statement);
		    if(!$res) {
			    $this->SafeError($this->errorInfo(),$statement, $line, $file);
				message("Achtung Datenbankfehler! Bitte kontaktiere den Administrator. Nenne folgende Uhrzeit: ".date('H:i:s'), "Datenbankfehler!");
				exit();
			}
		
            $this->queryTime = $this->queryTime + (microtime(true) - $timeStart);
	    	$this->lastQuery = $res;
            return $res;
    }
	
	function SafeError($Error,$Query) 
	{
	    $datum = date("d.m.Y");
		
		$inhalt  = "Uhrzeit: ". date('H:i:s')."\r\n";
		$inhalt .= "Datei: ". $_SERVER['REQUEST_URI']."\r\n";
		$inhalt .= "Zeile: ". $Zeile."\r\n";
		$inhalt .= "Query: ". $Query."\r\n";
		$inhalt .= "Error: ".$Error[2]."\r\n";
		$inhalt .= "Code: ".$Error[1]."\r\n";
		$inhalt .= "SQL-State: ".$Error[0]."\r\n";
		$inhalt .= "\r\n";
		
	    $handle = fopen (ERROR_FILER_FOLDER . $datum.".txt", 'a+');
        fwrite ($handle, $inhalt);
        fclose ($handle);

	}
	
	public function increaseQueryCounter()
	{
	$this->numberOfQueries++;
	}
 
	public function getNumberOfQueries()
	{
	return $this->numberOfQueries;
	}
 
	public function getQueryTime()
	{
	return $this->queryTime;
	}

}

    require_once(XNOVA_ROOT_PATH .'pages/config.php');

    $DB = null;
	
function ConnectPDO($Typ="",$Host="",$DBName="",$User="",$Pass="",$Prefix=""){
	global $dbsettings;
	
    $Typ     = (!empty($Typ))    ? $Typ    : $dbsettings['typ'];
    $Host    = (!empty($Host))   ? $Host   : $dbsettings['server'];
    $DBName  = (!empty($DBName)) ? $DBName : $dbsettings['name'];
    $User    = (!empty($User))   ? $User   : $dbsettings['user'];
    $Pass    = (!empty($Pass))   ? $Pass   : $dbsettings['pass'];
    $Prefix  = (!empty($Prefix)) ? $Prefix : $dbsettings['prefix'];

	define('PREFIX', $Prefix);
	
        try {
            $DB = new DB($Typ.':host='.$Host.';dbname='.$DBName.'', $User, $Pass, array(PDO::ATTR_PERSISTENT => true));
			$DB->query("SET NAMES 'utf8'");

        } catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
		
	return $DB;

}

function sql_num_rows($Objekt){

    return count($Objekt->fetchAll());

}


?>