<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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

class DbCache{
	protected $Interval, $StartTime, $DbConfig, $Cache, $Link;
	function __construct($DbConfig, $LoadOnStart = true, $StartTime = '', $Interval = 240){
		global $debug;
		if($StartTime == '' or $StartTime <= 0)
			$this->StartTime = time();
		else
			$this->StartTime = $StartTime*1;
		if($Interval < 1)
			$this->Interval = 1;
		else
			$this->Interval = $Interval*1;
		if(is_resource($DbConfig) and get_resource_type($DbConfig) == 'mysql')
			$this->Link = $DbConfig;
		else{
			$this->DbConfig = $DbConfig;
			$this->Link = mysql_connect($this->DbConfig["server"], $this->DbConfig["user"], $this->DbConfig["pass"]) or $debug->error(mysql_error()."<br />$query","SQL Error");
			mysql_select_db($this->DbConfig["name"]);
		}
		$this->doquery("DELETE FROM {{table}} WHERE `last_time` <= '". ($this->StartTime - $this->Interval) ."';");
		$this->Cache = array();
		if($LoadOnStart == true){
			$this->LoadOnStart = true;
			$Vars = $this->doquery("SELECT * FROM {{table}};");
			while($v = mysql_fetch_array($Vars)){				
				$this->Cache[$v['name']] = $v['content'];
			}
		}else
			$this->LoadOnStart = false;
		
	}
	function get($name){
		$name = base64_encode($name);
		if(!$this->LoadOnStart){
			$content = $this->doquery("SELECT * FROM {{table}} WHERE `name` = '".$name."' LIMIT 1;", true);			
			$this->Cache[$name] = $content;		
		}
		return unserialize(base64_decode($this->Cache[$name]));	
	}
	function set($content, $name){
		$content = base64_encode(serialize($content));
		$name = base64_encode($name);
		$c = $this->doquery("SELECT COUNT(*) as `total` FROM {{table}} WHERE `name` = '".$name."';", true);
		if($c['total'] >= 1){
			$this->doquery("UPDATE {{table}} SET `content` = '$content' WHERE `name` = '$name' LIMIT 1;");
		}else{
			$this->doquery("INSERT INTO {{table}} (`name`, `content`, `last_time`) VALUES ('$name', '$content', '". $this->StartTime ."');");		
		}
		$this->Cache[$name] = $content;
		return true;	
	}
	function doquery($query, $fetch = false, $table = 'cache'){
		global $debug;
		$sql 		= str_replace("{{table}}", $this->DbConfig["prefix"].$table, $query);
		$sqlquery 	= mysql_query($sql) or $debug->error(mysql_error()."<br />$sql<br />","SQL Error");
		if($fetch)
			return mysql_fetch_array($sqlquery);
		else
			return $sqlquery;
	}
}