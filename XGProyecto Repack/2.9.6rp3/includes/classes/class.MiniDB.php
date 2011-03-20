<?php
/*
*	
*	  _    _                                      _                   _                 
*	 | |  | |                                    | |                 | |                
*	 | |  | |   __ _    __ _   _ __ ___     ___  | |   __ _   _ __   | |   __ _   _   _  © 2008-2010
*	 | |  | |  / _  |  / _  | |  _   _ \   / _ \ | |  / _  | |  _ \  | |  / _  | | | | |
*	 | |__| | | (_| | | (_| | | | | | | | |  __/ | | | (_| | | |_) | | | | (_| | | |_| |
*	  \____/   \__  |  \____| |_| |_| |_|  \___| |_|  \____| |  __/  |_|  \____|  \__  |
*	            __/ |                                        | |                   __/ |
*	           |___/                                         |_|                  |___/ 
*	
*	@author shoghicp@gmail.com for ugamelaplay.net
*	@copyright 2008-1010
*	@package UGamelaPlay
*	
*/
if(HAS_SQLITE === true and class_exists('SQLiteDatabase')){
	class MiniDB{
		
		protected $Db;
		public $Variables;
		private $VariablesStart;
		public $fetch;
		function __construct($Db){
			if($Db != ''){
				$this->fetch = "fetch";
				if(!file_exists( MINIDB_PATH .'/'.$Db.'.sqlite')){
					$this->Db = new SQLiteDatabase( MINIDB_PATH .'/'.$Db.'.sqlite');
					$this->doquery("CREATE TABLE variables ( key text(100) not null unique primary key,	value text(99999999) );");
				}else{
					$this->Db = new SQLiteDatabase(MINIDB_PATH .'/'.$Db.'.sqlite');
				}
				$query = $this->Db->query("SELECT * FROM variables;");
				while($Curr = $query->fetch(  )){
					$this->VariablesStart[$Curr['key']] = $Curr['value'];
				}
				$this->Variables = $this->VariablesStart;
			}
		}
		function Close(){
			foreach($this->Variables as $Key => $Value){
				if(isset($this->VariablesStart[$Key]) and $this->VariablesStart[$Key] != $Value){
					$this->Db->query("UPDATE variables SET value = '".addslashes($Value)."' WHERE key = '".$Key."' ");
				}elseif(!isset($this->VariablesStart[$Key])){
					$this->Db->query("INSERT INTO variables VALUES ('$Key', '".addslashes($Value)."');");
				}
			}
		}
		function doquery($query, $fetch = false){
			$result = $this->Db->query($query) or die("Session Error");
			if($fetch){
				$array = $result->fetch();
				return $array;
			}else{
				return $result;
			}
		}

	}
}elseif(HAS_SQLITE === true and class_exists('SQLite3')){
	class MiniDB{
		
		protected $Db;
		public $Variables;
		private $VariablesStart;
		public $fetch;
		function __construct($Db){
			if($Db != ''){
				$this->fetch = "fetchArray";
				if(!file_exists( MINIDB_PATH .'/'.$Db.'.sqlite3')){
					$this->Db = new SQLite3( MINIDB_PATH .'/'.$Db.'.sqlite3');
					$this->doquery("CREATE TABLE variables ( key text(100) not null unique primary key,	value text(99999999) );");
				}else{
					$this->Db = new SQLite3(MINIDB_PATH .'/'.$Db.'.sqlite3');
				}
				$query = $this->Db->query("SELECT * FROM variables;");
				while($Curr = $query->fetch(  )){
					$this->VariablesStart[$Curr['key']] = $Curr['value'];
				}
				$this->Variables = $this->VariablesStart;
			}
		}
		function Close(){
			foreach($this->Variables as $Key => $Value){
				if(isset($this->VariablesStart[$Key]) and $this->VariablesStart[$Key] != $Value){
					$this->Db->query("UPDATE variables SET value = '".addslashes($Value)."' WHERE key = '".$Key."' ");
				}elseif(!isset($this->VariablesStart[$Key])){
					$this->Db->query("INSERT INTO variables VALUES ('$Key', '".addslashes($Value)."');");
				}
			}
		}
		function doquery($query, $fetch = false){
			$result = $this->Db->query($query) or die("DB Error");
			if($fetch){
				$array = $result->fetchArray();
				return $array;
			}else{
				return $result;
			}
		}

	}

}else{
	class MiniDB{		
		protected $Db;
		public $Variables;
		private $VariablesStart;
		public $fetch;
		function __construct($Db){
			$fetch = "";
			$this->Variables = array();
		}
		function Close(){
		}
		function doquery($query, $fetch = false){
			return array();
		}
	}
}
?>
