<?php
//version 1.3


if(!defined('INSIDE')){ die(header("location:../../"));}

class debug
{
	private $log;
	private $numqueries;

	
	/**
	 * A�ade querys en un array
	 * 
	*/
	public function add($query,$table,$fetch,$linea,$origen)
	{
		$this->numqueries++;
		$this->log[$this->numqueries]['query']= $query;
		$this->log[$this->numqueries]['table']= $table;
		$this->log[$this->numqueries]['fetch']= $fetch;
		$this->log[$this->numqueries]['linea']= $linea;
		$this->log[$this->numqueries]['origen']= $origen;
		
	}

	/**
	 * Muestra Debug Log
	 * 
	*/
	public function echo_log()
	{
		global $xnova_root;
		echo "<div id='debugerrors'><br>
				<table>
					<tr>
						<td class=k colspan=4><a href=".$xnova_root."admin.php?page=settings>Debug Log</a>:</td>
					</tr>
					<tr>
						<th>Query:</th>
						<th>Sentencia</th>
						<th>Tabla</th>
						<th>Fetch</th>
						<th>Linea</th>
						<th>Origen</th>
						</tr>";
		
		foreach($this->log as $a => $b){
				echo "<tr>
						<th>".$a."</th>
						<th>".$this->log[$a]['query']."</th>
						<th>".$this->log[$a]['table']."</th>
						<th>".$this->log[$a]['fetch']."</th>
						<th>".$this->log[$a]['linea']."</th>
						<th>".$this->log[$a]['origen']."</th>
						</tr>";
			
		}		

		echo "</table></div>";
		die();
	}

	public function error($message,$title)
	{
		global $link, $game_config, $lang;

		if($game_config['debug']==1)
		{
			echo "<h2>".$title."</h2><br/><font color='red'>".$message."</font><br/><hr/>";
			echo "<table>";
			foreach($this->log as $a => $b){
				echo "<tr>
						<th>Query:".$a."</th>
						<th>".$this->log[$a]['query']."</th>
						<th>".$this->log[$a]['table']."</th>
						<th>".$this->log[$a]['fetch']."</th>
						<th>".$this->log[$a]['linea']."</th>
						<th>".$this->log[$a]['origen']."</th>
						</tr>";
			
			}
			echo "</table>";
		}

		global $user,$xnova_root,$phpEx;
		include($xnova_root . 'config.'.$phpEx);

		if(!$link){die($lang['cdg_mysql_not_available']);}
			
		$query = "INSERT INTO {{table}} SET
		`error_sender` = '{$user['id']}' ,
		`error_time` = '".time()."' ,
		`error_type` = '{$title}' ,
		`error_text` = '".mysql_escape_string($message)."',
		`error_line` = '{$title}' ,
		`error_page` = '".mysql_escape_string($message)."';";

		$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors',$query)) or die($lang['cdg_fatal_error']);

		$query = "explain select * from {{table}}";

		$q = mysql_fetch_array(mysql_query(str_replace("{{table}}", $dbsettings["prefix"].'errors', $query))) or die($lang['cdg_fatal_error'].': ');

		if (!function_exists('message')){
			echo $lang['cdg_error_message']." <b>".$q['rows']."</b>";
		}
		else
		{
			message($lang['cdg_error_message']." <b>".$q['rows']."</b>", '', '', false, false);
		}

		die();
	}
}
?>