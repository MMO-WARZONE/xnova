<?php
//version 1
class MySqlDatabase {

	private $host;
	private $user;
	private $password;
	private $database;
        private $prefijo ;
	public $queryCount = 0;
	public $queries = array();
	public $conn;
	public $game_config = array();
	
	
	/*------------------------------------
	          CONFIG CONNECTION
	------------------------------------*/
	
	function __construct() {
		global $svn_root,$dbsettings;
                if(is_file($svn_root.'config.php')){
                    include($svn_root.'config.php');
                }
                if(isset($dbsettings)){
                    $this->host 	= $dbsettings["server"];
                    $this->user 	= $dbsettings["user"];
                    $this->password     = $dbsettings["pass"];
                    $this->prefijo	= $dbsettings["prefix"];
                    $this->connect(true);
                    $this->changeDatabase($dbsettings["name"]);
                    $this->game_config();
                }
                   
                
	}
	
	
	private function game_config(){
		
		$query = $this->query("SELECT * FROM {{table}}",'config');
		while ($row = mysql_fetch_assoc($query))
		{
			$this->game_config[$row['config_name']] = $row['config_value'];
		}
		class_exists('Console')?Console::log($this->game_config):"";
	}
	
	
	function connect($new = false) {
		$this->conn = mysql_connect($this->host, $this->user, $this->password, $new);
		if(!$this->conn) {
			throw new Exception('Conexion no realizada con exito.');
		}
	}
	
	function changeDatabase($database) {
		$this->database = $database;
		if($this->conn) {
			if(!mysql_select_db($this->database, $this->conn)) {
				die('We\'re working on a few connection issues.');
			}else{
                            return true;
                        }
		}
	}
	
	function lazyLoadConnection() {
		$this->connect(true);
		if($this->database)$this->changeDatabase($this->database);
	}
	
	/*-----------------------------------
	   		QUERY
	------------------------------------*/
	
	function query($sql,$table, $fetch = false) {
		if(!$this->conn) $this->lazyLoadConnection();
		$start = $this->getTime();
		$e=new Exception();
                
		$sql 	= str_replace("{{table}}", $this->prefijo.$table, $sql);
		$sqlquery = mysql_query($sql,$this->conn) or $this->logQuery(mysql_error()."<br>".$sql,$table, $start, $e,$fetch , 1);
		$this->queryCount += 1;
		
		if($sqlquery){
			$this->logQuery($sql,$table,$start,$e,$fetch,0);
			if($fetch){
				$rss=mysql_fetch_array($sqlquery);
				
				if (is_array($rss)){
					foreach($rss as $a => $b){
					   if (is_numeric($a)){unset($rss[$a]);}                                           
					}
					Console::log($rss);
				}
				return $rss;
			}else{
				return $sqlquery;
			}
		}
	}
	
	
	/*-----------------------------------
	          	DEBUGGING
	------------------------------------*/
	
	function logQuery($sql,$table, $start, $e,$fetch , $num) {
		global $dbsettings;
		$e=$e->getTrace();
                foreach($e as $a => $b){
			foreach($b as $c => $d){
                                if($d=="query"){
                                        $line=$b['line'];
					$file=$b['file'];
				}
			}
		}
		if($num==1){
			$logItem = array(
				"data" => $sql,
				"type" => 'error',
				"file" => $file,
				"line" => $line
				);
			$GLOBALS['debugger_logs']['console'][] = $logItem;
			$GLOBALS['debugger_logs']['errorCount'] += 1;
			
			if(!$this->conn) die("NO HAY CONEXION");
			
			
			$querys ='INSERT INTO `'.$this->prefijo.'errors` (`error_sender`, `error_time`, `error_type`, `error_text`, `error_page`, `error_line`)
			VALUES ( "", "'.time().'", "SQL ERROR", "'.$sql.'", "'.mysql_real_escape_string($file).'", "'.$line.'");';
			
			
			mysql_query($querys,$this->conn) or die(mysql_error()."<br>".$querys);
		}
		
			$error=$num ? 'Si' : 'No';
			$fetch=$fetch? 'Si' : 'No';
			$query = array(
					'sql' => $sql,
					'time' => ($this->getTime() - $start)*1000,
					'line' => $line,
					'file' => $file,
					'error' => $error,
					'table' => $table,
					"fetch" =>$fetch
				);
			array_push($this->queries, $query);
	}
	
	function getTime() {
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
		return $start;
	}
	
	public function getReadableTime($time) {
		$ret = $time;
		$formatter = 0;
		$formats = array('ms', 's', 'm');
		if($time >= 1000 && $time < 60000) {
			$formatter = 1;
			$ret = ($time / 1000);
		}
		if($time >= 60000) {
			$formatter = 2;
			$ret = ($time / 1000) / 60;
		}
		$ret = number_format($ret,3,'.','') . ' ' . $formats[$formatter];
		return $ret;
	}
	
	function __destruct()  {
            if($this->conn){
		mysql_close($this->conn);
            }

        }
	
}

?>
