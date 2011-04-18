<?php

/**
 * @TheCleaner.php
 * @author angelus_ira - angelus_ira@hotmail.com
 * @package newXnova www.fantasiagames.com.ar
 * @version 0.6
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!USE AT YOUR OWN RISK!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

includeLang('admin/TheCleaner');

    if ( $user['authlevel'] >= 2 and in_array ($user['id'],$Adminerlaubt) ) {
	if($_POST['clean'] == $lang['adm_clean'])
	{
		//We start  the deleted count...
		$user_deleted	= 0;
		$result_u_d ='';
		$planet_deleted	= 0;
		$result_p_d 	='';
		$galaxy_deleted	= 0;
		$result_g_d 	='';
		// Initial Time
		$mtime        = microtime();
		$mtime        = explode(" ", $mtime);
		$mtime        = $mtime[1] + $mtime[0];
		$starttime    = $mtime;
		//Initial Memory
		$initial_memory= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		//------------------------------------------------------------------------------------------------------------------
		//-----------------USERS AND PLANET USERS CONTROL--------------------------------------------
		//------------------------------------------------------------------------------------------------------------------
		//Now we make the master check., a beatyfull query..
		//This query will select the with a LEFT JOIN the users and planets, if the value have user id ='' or planet id_owner ='' the user, or the planet are invalid and will be deleted
		$master_query1	= 	doquery("SELECT u.id AS uid, p.id AS pid, p.id_owner, p.galaxy, p.system, p.planet
							FROM {{table}}users AS u
							Left Join {{table}}planets AS p ON u.id_planet = p.id AND p.planet_type = 1
							WHERE u.id IS NULL OR p.id_owner IS NULL ",'');

		while ($current_check = mysql_fetch_assoc($master_query1))
		{
			//If the user do not have a principal planet, that user is a bug or a cheater, we delete that user !!!
			if ($current_check['pid']=='')
			{
				DeleteSelectedUser($current_check['uid']);
				$result_u_d .=$current_check['uid'].', ';
				++$user_deleted;
			}
			//If the planet do not have a linked user, that planet is a bug, we delete that planet and all is info arround the database
			//TODO, Check flyings fleets to that planet...
			if ($current_check['uid']=='')
			{
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $current_check['galaxy'] . "' AND `system` = '" . $current_check['system'] . "' AND `planet` = '" . $current_check['planet'] . "';", 'galaxy' );
				doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $current_check['id'] . "';", 'planets' );
				$result_p_d .=$current_check['pid'].', ';
				++$planet_deleted;
			}
		}
		unset($current_check,$master_query1);
		//Control Querys, this determine if is necesary or not do it a brute force Cleaner action...
		//First we check the total amount of users in table users:
		$total_users 		= doquery ("SELECT COUNT(*) AS `count` FROM {{table}};", 'users', true);
		//Next we check the total amount of users in table planets...
		$users_on_planet	= doquery("SELECT COUNT(*)  FROM (SELECT id_owner FROM {{table}} GROUP BY id_owner) AS usr;", 'planets');
		//Next we check the linked users and planets...
		$linked_u_p			= doquery("SELECT COUNT(*) as 'count'  FROM 
								(SELECT u.id as uid, p.id as pid FROM {{table}}planets AS p
								Inner Join {{table}}users AS u ON p.id_owner = u.id 
								AND p.id = u.id_planet) AS plt;",'');
		//If exist some difference between the previus variables, a brute force search is needed						
		if ($linked_u_p != $total_users || $linked_u_p != $users_on_planet)
		{
			//Here we Chek the users
			$user_sql	=	 doquery("SELECT id, ally_id FROM {{table}};", 'users');
			$planet_sql	=	 doquery("SELECT id, id_owner,galaxy, system, planet FROM {{table}} GROUP BY id_owner;", 'planets');
			while ($CurP = mysql_fetch_array($planet_sql)) 
			{
					$p_array[$CurP['id_owner']]	=	$CurP['id_owner'];
			}
			while ($CurUser = mysql_fetch_assoc($user_sql)) 
			{
				//Here we check if the user have any planet...
				if($p_array[$CurUser['id']]== '')
				{
					DeleteSelectedUser($CurUser['id']);
					$result_u_d .=$CurUser['id'].', ';
					++$user_deleted;
				}
				else
				{
					$user_array[$CurUser['id']]	=	$CurUser['id'];
				}
			}
			unset($planet_sql);
			//We make the planet array
			$planet_sql	=	 doquery("SELECT id, id_owner,galaxy, system, planet FROM {{table}};", 'planets');
			while ($CurPlanet = mysql_fetch_assoc($planet_sql)) 
			{
				$planet_array[$CurPlanet['id']]	=	$CurPlanet['id'];
				//Here we check if the planet have any owner...
				foreach ($user_array as $id=> $udata)
				{
					if($CurPlanet['id_owner']==$id)
					{
						$UserExist	=	'true';
					}
				}
				if ($UserExist != 'true')
				{
					doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $CurPlanet['galaxy'] . "' AND `system` = '" . $CurPlanet['system'] . "' AND `planet` = '" . $CurPlanet['planet'] . "';", 'galaxy' );
					doquery ( "DELETE FROM {{table}} WHERE `id` = '" . $CurPlanet['id'] . "';", 'planets' );
					$result_p_d .=$CurPlanet['id'].', ';
					++$planet_deleted;
				}
			unset($UserExist);
			}
			unset($planet_array,$user_array,$id,$udata,$planet_sql,$user_sql,$CurPlanet,$p_array,$total_users,$users_on_planet,$linked_u_p );
		}
	
		//------------------------------------------------------------------------------------------------------------------
		//-----------------PLANETS AND GALAXY CONTROL--------------------------------------------
		//------------------------------------------------------------------------------------------------------------------
		//We will make the master check
		$master_query2= doquery("SELECT DISTINCT p.id, p.galaxy AS pgal, p.system AS psys, p.planet AS ppla,
								g.galaxy AS ggal, g.system AS gsys, g.planet AS gpla, p.planet_type
								FROM {{table}}planets AS p LEFT JOIN {{table}}galaxy AS g ON p.galaxy = g.galaxy AND p.system = g.system AND p.planet = g.planet
								WHERE p.id IS NULL  OR g.galaxy IS NULL",'');
		while ($current_check = mysql_fetch_assoc($master_query2))
		{
			//If the planet do not exist, in that place nobody can colonize, we need to delete that !!!
			if ($current_check['pgal']=='')
			{
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $current_check['ggal'] . "' AND `system` = '" . $current_check['gsys'] . "' AND `planet` = '" . $current_check['gpla'] . "';", 'galaxy' );
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $current_check['ggal'] . "' AND `system` = '" . $current_check['gsys'] . "' AND `planet` = '" . $current_check['gpla'] . "';", 'planets' );
				$result_g_d .='['.$current_check['ggal'].':'.$current_check['gsys'].':'.$current_check['gpla'].'], ';
				++$galaxy_deleted;
			}
			//If the planet do not have a galaxy spot, that planet is a bug and  we delete that galaxy spot and posibly phantom moon !!!
			if ($current_check['ggal']=='')
			{
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $current_check['pgal'] . "' AND `system` = '" . $current_check['psys'] . "' AND `planet` = '" . $current_check['ppla'] . "';", 'galaxy' );
				doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $current_check['pgal'] . "' AND `system` = '" . $current_check['psys'] . "' AND `planet` = '" . $current_check['ppla'] . "';", 'planets' );
				$result_p_d .=$current_check['id'].', ';
				++$planet_deleted;
			}
		}
		//Now we make the some checks to see if everythings is ok..
		$total_real		= doquery("SELECT COUNT(*) as 'count'  FROM 
								(SELECT p.id FROM {{table}}planets AS p
								Inner Join {{table}}galaxy AS g ON p.planet = g.planet 
								AND p.galaxy = g.galaxy AND p.system = g.system
								WHERE
								p.planet_type =  '1') AS plt;",'');
		$total_planets	= doquery(	"SELECT COUNT(*) as 'count' FROM {{table}} WHERE planet_type =  '1';",'planets');
		$total_g_planets= doquery(	"SELECT COUNT(*) as 'count' FROM {{table}};",'galaxy');
		if ($total_real!=$total_planets || $total_real!=$total_g_planets)
		{
			//If there exist diferences we need to make a brute forece control....
			if($total_planets>=$total_g_planets)
			{
				$planet_sql	= doquery("SELECT id,galaxy, system, planet FROM {{table}}", 'planets');
				$galaxy_sql	= doquery("SELECT galaxy, system, planet, id_planet FROM {{table}}", 'galaxy');
				//we make the array with the minimun info 
				while ($CurG = mysql_fetch_array($galaxy_sql)) 
				{
					$g_array[$CurG['galaxy']][$CurG['system']][$CurG['planet']][$CurG['planet']][$CurG['id_planet']]	=	$CurG['id_planet'];
				}
				while ($CurP = mysql_fetch_array($planet_sql)) 
				{
					if($g_array[$CurP['galaxy']][$CurP['system']][$CurP['planet']][$CurP['planet']][$CurP['id']] == '')
					{
						doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $CurP['galaxy'] . "' AND `system` = '" . $CurP['system'] . "' AND `planet` = '" . $CurP['planet'] . "';", 'planets' );
						$result_p_d .=$CurP['id'].', ';
						++$planet_deleted;
					}
					unset($g_array[$CurP['galaxy']][$CurP['system']][$CurP['planet']][$CurP['planet']][$CurP['id']]);
				}
				unset($g_array,$planet_sql,$galaxy_sql,$CurP,$CurG );
			}
			elseif($total_g_planets>$total_planets)
			{
				$planet_sql	= doquery("SELECT id,galaxy, system, planet FROM {{table}}", 'planets');
				$galaxy_sql	= doquery("SELECT galaxy, system, planet, id_planet FROM {{table}}", 'galaxy');
				//we make the array with the minimun info 
				while ($CurP = mysql_fetch_array($planet_sql)) 
				{
					$p_array[$CurP['galaxy']][$CurP['system']][$CurP['planet']][$CurP['planet']][$CurP['id']]	=	$CurP['id'];
				}
				while ($CurG = mysql_fetch_array($galaxy_sql)) 
				{
					if($p_array[$CurG['galaxy']][$CurG['system']][$CurG['planet']][$CurG['planet']][$CurG['id_planet']] == '')
					{
						doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $CurG['galaxy'] . "' AND `system` = '" . $CurG['system'] . "' AND `planet` = '" . $CurG['planet'] . "';", 'galaxy' );
						doquery ( "DELETE FROM {{table}} WHERE `galaxy` = '" . $CurG['galaxy'] . "' AND `system` = '" . $CurG['system'] . "' AND `planet` = '" . $CurG['planet'] . "';", 'planets' );
						$result_g_d .='['.$CurG['galaxy'].':'.$CurG['system'].':'.$CurG['system'].'], ';
						++$galaxy_deleted;
					}
					unset($p_array[$CurG['galaxy']][$CurG['system']][$CurG['planet']][$CurG['planet']][$CurG['id_planet']]);
				}
				unset($p_array,$planet_sql,$galaxy_sql,$CurP,$CurG);
			}
		}	
		$del_u	= str_replace(array("%u", "%iu"), array($user_deleted,$result_u_d), $lang['adm_deleted_users']);
		$del_p	= str_replace(array("%p", "%ip"), array($planet_deleted,$result_p_d), $lang['adm_deleted_planets']);
		$del_g	= str_replace(array("%g", "%ig"), array($galaxy_deleted,$result_g_d), $lang['adm_deleted_galaxy']);
		unset($user_deleted,$result_u_d,$planet_deleted,$result_p_d,$galaxy_deleted,$result_g_d);
		// End Time
		$mtime		= microtime();
		$mtime		= explode(" ", $mtime);
		$mtime		= $mtime[1] + $mtime[0];
		$endtime	= $mtime;
		$totaltime	= ($endtime - $starttime);
		$time		= str_replace("%ti",$totaltime, $lang['adm_time']);
		//Memory at the end
		$end_memory	= array(round(memory_get_usage() / 1024,1),round(memory_get_usage(1) / 1024,1));
		$i_mem		= str_replace(array("%mi", "%mti"),$initial_memory, $lang['adm_i_mem']);
		$e_mem		= str_replace(array("%me", "%mte"),$end_memory, $lang['adm_e_mem']);
		//We send the message.
		$message	= $lang['adm_stat_end'].$time.$i_mem.$e_mem.$del_u.$del_p.$del_g;
		AdminMessage ( $message, $lang['adm_succes'] );
	}
	else
	{
		$page = parsetemplate(gettemplate('admin/TheCleaner_body'), $lang);
		display($page, $lang['adm_clean_title'], false, '', true );
	}
} 
else 
{
	AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
// -----------------------------------------------------------------------------------------------------------
//TODO: Make flying fleets control
//TODO: Check the others tables with use user id...
//
?>