<?php
/**
 * buddy.php
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include( $rocketnova_root_path . 'extension.inc');
include( $rocketnova_root_path . 'common.' . $phpEx);

includeLang('buddy');

// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

$a = $_GET['a'];
$e = $_GET['e'];
$s = $_GET['s'];
$u = intval($_GET['u']);

if ($s == 1 && isset($_GET['bid']))
{
	// To erase an entry from the buddy list.
	$bid = intval($_GET['bid']);

	$buddy = doquery( "SELECT * FROM {{table}} WHERE `id` = '".$bid."';", 'buddy', true);
	if ($buddy['owner'] == $user['id'])
	{
		if ($buddy['active'] == 0 && $a == 1)
		{
			doquery("DELETE FROM {{table}} WHERE `id` = '".$bid."';", 'buddy');
		}
		elseif ($buddy['active'] == 1)
		{
			doquery("DELETE FROM {{table}} WHERE `id` = '".$bid."';", 'buddy');
		}
		elseif ($buddy['active'] == 0)
		{
			doquery("UPDATE {{table}} SET `active` = '1' WHERE `id` = '".$bid."';", 'buddy');
		}
	}
	elseif ($buddy['sender'] == $user['id'])
	{
		doquery("DELETE FROM {{table}} WHERE `id` = '".$bid."';", 'buddy');
	}
}
elseif ($_POST["s"] == 3 && $_POST["a"] == 1 && $_POST["e"] == 1 && isset($_POST["u"]))
{
	// Requests and buddy rejecting
	$uid = $user["id"];
	$u = intval($_POST["u"]);

	$buddy = doquery("SELECT * FROM {{table}} WHERE sender={$uid} AND owner={$u} OR sender={$u} AND owner={$uid}", 'buddy', true);

	if (!$buddy)
	{
		if (strlen($_POST['text']) > 5000)
		{
			message($lang['to_much_characters'], $lang['error']);
		}
		$text = mysql_escape_string(strip_tags($_POST['text']));
		doquery("INSERT INTO {{table}} SET sender={$uid}, owner={$u}, active=0, text='{$text}'", 'buddy');
		message($lang['Request_sent'], $lang['Buddy_request'], 'buddy.php');
	}
	else
	{
		message($lang['A_request_exists_already_for_this_user'], $lang['Buddy_request']);
	}
}

$page = "<br>";

if ($a == 2 && $u != 0)
{
	// Sending a new buddy request
	$u = doquery("SELECT * FROM {{table}} WHERE id={$u}", "users", true);
	
	if ($u && $u['id'] != $user['id'])
	{
		$parse = $lang;
		$parse['id']       = $u['id'];
		$parse['username'] = $u['username'];
		
		$page = parsetemplate(gettemplate('buddy_sendform'), $parse);
		display($page, $lang['Buddy_request']);
	}
	elseif ($u["id"] == $user["id"])
	{
		message($lang['You_cannot_ask_yourself_for_a_request'], $lang['Buddy_request']);
	}
}


if ($a == 1)
{
	$TableTitle = ($e == 1) ? $lang['My_requests'] : $lang['Anothers_requests'];
}
else
{
	$TableTitle = $lang['Buddy_list'];
}

$page .= "
<table width=519>
<tr>
	<td class=c colspan=6>{$TableTitle}</td>
</tr>";

if (!isset($a))
{
	$page .= "
	<tr>
		<th colspan=6><a href=?a=1>{$lang['Requests']}</a></th>
	</tr><tr>
		<th colspan=6><a href=?a=1&e=1>{$lang['My_requests']}</a></th>
	</tr><tr>
		<td class=c>Nr.</td>
		<td class=c>{$lang['Name']}</td>
		<td class=c>{$lang['Alliance']}</td>
		<td class=c>{$lang['Coordinates']}</td>
		<td class=c>{$lang['Position']}</td>
		<td class=c>Aktion</td>
	</tr>";
}

if ($a == 1)
{
	$query = ($e == 1) ? "WHERE active=0 AND sender={$user["id"]}" : "WHERE active=0 AND owner={$user["id"]}";
}
else
{
	$query = "WHERE active=1 AND sender={$user["id"]} OR active=1 AND owner={$user["id"]}";
}

$buddyrow = doquery("SELECT * FROM {{table}} " . $query, 'buddy');

while ($b = mysql_fetch_array( $buddyrow ))
{
	// para solicitudes
	if (!isset($i) && isset($a))
	{
		$page .= "
		<tr>
			<td class=c>Nr.</td>
			<td class=c>{$lang['User']}</td>
			<td class=c>{$lang['Alliance']}</td>
			<td class=c>{$lang['Coordinates']}</td>
			<td class=c>{$lang['Text']}</td>
			<td class=c>Aktion</td>
		</tr>";
	}

	$i++;
	$uid = ($b["owner"] == $user["id"]) ? $b["sender"] : $b["owner"];
	// query del user
	$u = doquery("SELECT id,username,galaxy,system,planet,onlinetime,ally_id,ally_name FROM {{table}} WHERE id=" . $uid, "users", true);
	// $g = doquery("SELECT galaxy, system, planet FROM {{table}} WHERE id_planet=".$u["id_planet"],"galaxy",true);
	// $a = doquery("SELECT * FROM {{table}} WHERE id=".$uid,"aliance",true);
	if ($u["ally_id"] != 0)
	{ // Alianza
		// $allyrow = doquery("SELECT id,ally_tag FROM {{table}} WHERE id=".$u["ally_id"],"alliance",true);
		// if($allyrow){
		$UserAlly = "<a href=alliance.php?mode=ainfo&a=" . $u["id"] . ">" . $u["ally_name"] . "</a>";
		// }
	}
	else
	{
		$UserAlly = "";
	}

	if (isset($a))
	{
		$LastOnline = $b["text"];
	}
	else
	{
		$LastOnline = "<font color=";
		if ($u["onlinetime"] + 60 * 10 >= time())
		{
			$LastOnline .= "lime>{$lang['On']}";
		}
		elseif ($u["onlinetime"] + 60 * 20 >= time())
		{
			$LastOnline .= "yellow>{$lang['15_min']}";
		}
		else
		{
			$LastOnline .= "red>{$lang['Off']}";
		}
		$LastOnline .= "</font>";
	}

	if (isset( $a ) && isset($e))
	{
		$UserCommand = "<a href=?s=1&bid=" . $b["id"] . ">{$lang['Delete_request']}</a>";
	}
	elseif (isset($a))
	{
		$UserCommand = "<a href=?s=1&bid=" . $b["id"] . ">{$lang['Ok']}</a><br/>";
		$UserCommand .= "<a href=?a=1&s=1&bid=" . $b["id"] . ">{$lang['Reject']}</a></a>";
	}
	else
	{
		$UserCommand = "<a href=?s=1&bid=" . $b["id"] . ">{$lang['Delete']}</a>";
	}

	$page .= "
	<tr>
		<th width=20>" . $i . "</th>
		<th><a href=messages.php?mode=write&id=" . $u["id"] . ">" . $u["username"] . "</a></th>
		<th>{$UserAlly}</th>
		<th><a href=\"galaxy.php?mode=3&galaxy=" . $u["galaxy"] . "&system=" . $u["system"] . "\">" . $u["galaxy"] . ":" . $u["system"] . ":" . $u["planet"] . "</a></th>
		<th>{$LastOnline}</th>
		<th>{$UserCommand}</th>
	</tr>";
}

if (!isset($i))
{
	$page .= "
	<tr>
		<th colspan=6>{$lang['There_is_no_request']}</th>
	</tr>";
}

if ($a == 1)
{
	$page .= "
	<tr>
		<td colspan=6 class=c><a href=buddy.php>{$lang['Back']}</a></td>
	</tr>";
}

$page .= "
	</table>
	</center>";

display($page, $lang['Buddy_list'], false);

?>
