<?php include('login.php');?>
    	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a></p><p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>
	<br clear="all" /><br />
  
    
	<form action="createforum.php" method="post" name="postform">
 
<table class="tablebg" width="100%" cellspacing="0">
<caption><div class="cap-left"><div class="cap-right">&nbsp;Make a new forum&nbsp;</div></div></caption>	<tr>
		<td class="row1"><b class="genmed">Forum type:</b></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr>
				<td><input type="radio" class="radio" name="keuze" value="help" /><span class="genmed">Help forum</span>&nbsp; <span style="white-space: nowrap;"><input type="radio" class="radio" name="keuze" value="game" />Game forum</span> </td>
			</tr>
			</table>
		</td>
	</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Forum name:</b></td>
	<td class="row2" width="78%"><input class="post" style="width:450px" type="text" name="forum" size="1" tabindex="2" maxlength="50" value="" /> </td>
</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Forum info:</b></td>
	<td class="row2" width="78%"><textarea name="info" tabindex="2" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);" style="width: 98%; height: 100px;"></textarea></td>
</tr>
<tr>
	<td class="cat" colspan="2" align="center">
		<input class="btnmain" type="submit" accesskey="s" tabindex="11" name="post" value="Make" />
		&nbsp; <input class="btnlite" type="reset" accesskey="c" tabindex="14" name="cancel" value="Reset" />
	</td>
</tr>
</table>
	</form>
  
<br clear="all" />
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a></p><p class="datetime">All times are GMT</p>		</td>
	</tr>
	</table>		<br clear="all" />
 
		<?php 
		$res=mysql_query("select count(username) from beta_users where forum_online='online'") or die(mysql_error());
		$res2=mysql_query("select username from beta_users where forum_online='online'") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
	include('visitors.php');
	$guests = CountGuests() - $row['count(username)'];
    $user =	"<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">";
	$user .= "<tr>";
	$user .="<td class=\"cat\"><h4>Who is online</h4></td></tr><tr>";
	$user .="<td class=\"row1\" width=\"100%\"><span class=\"genmed\">Users on this forum ";
	$user .=":: ".$row['count(username)']." registered and ".$guests." guests ";
	$user .="<br />";
	$i=0;
	if(mysql_num_rows($res2) > 0) {
	
			while ($row2=mysql_fetch_assoc($res2))
			{
		$res3=mysql_query("select authlevel from beta_users where username = '".$row2['username']."'") or die(mysql_error());
		$row3=mysql_fetch_assoc($res3);
    	if($row3['authlevel'] != 0) {
			if($row3['authlevel'] != 1) {
				if($row3['authlevel'] != 2) {
					$status = "Site Admin";
					$color = "red";
					}	
				else{
					$status = "SGO";
					$color = "green";
				}
			}else{
				$status = "GO";
				$color = "lightgreen";
			}	
		}else {	
			$status = "User";	
			$color = "#06C";
		}
			$user .= "<div  style=\"color: ".$color."\"><b>".$row2['username']."</b></div>";
			$i++;
			}
	}
	else{
		$user .= "None registered users";
	}
	$user .= "</span></td>";
	$user .="</tr>";
	$user .="</table>";
	echo $user; 
?>	