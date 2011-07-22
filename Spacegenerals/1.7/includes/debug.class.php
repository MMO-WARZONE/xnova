<?php // debug.class.php ::  Clase Debug, maneja reporte de eventos

if(!defined('INSIDE')){ die("hacking attempt");}
//
//  Experiment code!!!
//
/*vamos a experimentar >:)
  le veo futuro a las classes, ayudaria mucho a tener un codigo mas ordenado...
  que esperabas!!! soy newbie!!! D':<
*/

includeLang('debug');

class debug
{
	var $log,$numqueries;

	function debug()
	{
		$this->vars = $this->log = '';
		$this->numqueries = 0;
	}

	function add($mes)
	{
		$this->log .= $mes;
		$this->numqueries++;
	}

	function echo_log()
	{	global $rocketnova_root_path;
		echo  "<br><table><tr><td class=k colspan=4><a href=".$rocketnova_root_path."admin/settings.php>".$lang['DEBUG_LOG']."</a>:</td></tr>".$this->log."</table>";
		die();
	}
	
	function error($message,$title)
	{
		global $link,$game_config;
		if($game_config['debug']==1){
			echo "<h2>$title</h2><br><font color=red>$message</font><br><hr>";
			echo  "<table>".$this->log."</table>";
		}
		//else{
			//A futuro, se creara una tabla especial, para almacenar
			//los errores que ocurran.
			global $user,$rocketnova_root_path,$phpEx;
			include($rocketnova_root_path . 'config.'.$phpEx);
			if(!$link) die($lang['DEBUG_SQL_NA']);
			$query = "INSERT INTO {{table}} SET
				`error_sender` = '{$user['id']}' ,
				`error_time` = '".time()."' ,
				`error_type` = '{$title}' ,
				`error_text` = '".mysql_escape_string($message)."';";
			$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query))
				or die($lang['DEBUG_FATAL']);
			$query = "explain select * from {{table}}";
			$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].
				'errors', $query))) or die($lang['DEBUG_FATAL']);
				

			if (!function_exists('message'))
				echo $lang['DEBUG_ERROR']." <b>".$q['rows']."</b>";
			else
				message($lang['DEBUG_ERROR']." <b>".$q['rows']."</b>", $lang['DEBUG_ERROR_TITLE']);
		//}
		
		die();
	}
	
	
}

// Created by Perberos. All rights reversed (C) 2006
?>