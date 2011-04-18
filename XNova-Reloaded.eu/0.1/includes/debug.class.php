<?php // debug.class.php ::  Clase Debug, maneja reporte de eventos

if(!defined('INSIDE')){ die("attemp hacking");}
//
//  Experiment code!!!
//
/*vamos a experimentar >:)
  le veo futuro a las classes, ayudaria mucho a tener un codigo mas ordenado...
  que esperabas!!! soy newbie!!! D':<
*/

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
	{
		echo  "<br><table><tr><td class=k colspan=4><a href=".XNOVA_ROOT_PATH."admin/settings.php>Debug Log</a>:</td></tr>".$this->log."</table>";
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
			global $user;
			include(XNOVA_ROOT_PATH . 'pages/config.php');
			if(!$link) die('mySQL no esta disponible por el momento, sentimos el inconveniente...');
			$query = "INSERT INTO {{table}} SET
				`error_sender` = '{$user['id']}' ,
				`error_time` = '".time()."' ,
				`error_type` = '{$title}' ,
				`error_text` = '".mysql_escape_string($message)."';";
			$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query))
				or die('error fatal');
			$query = "explain select * from {{table}}";
			$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].
				'errors', $query))) or die('error fatal: ');
				

			if (!function_exists('message'))
				echo "Erreur, merci de contacter l'admin. Erreur n°: <b>".$q['rows']."</b>";
			else
				message("Erreur, merci de contacter l'admin. Erreur n°: <b>".$q['rows']."</b>", "Erreur");
		//}
		
		die();
	}
	
	
}

// Created by Perberos. All rights reversed (C) 2006
?>