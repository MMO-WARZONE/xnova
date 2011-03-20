<!--<?php include('login.php');?>-->
  	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a>
            </p>
			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>
	<br />	<div id="pageheader">
		<h2><a class="titles" href="#" onClick="loadpage('./forums.php?forum=<?php $forum = "{$_GET['forum']}"; echo $forum?>&p=0','XNova Forum','bodyid');"><?php $forum = "{$_GET['forum']}"; echo $forum ?></a></h2>
 
			</div>
 
	<br clear="all" /><br />
    		<?php
	if(!isset($_SESSION['suser'])) {
	?>
    <strong><h1>You must be logged in for this action!</h1></strong>
	<?php
	} else {
	?>

	<table class="tablebg" width="100%" cellspacing="0">
    <form action="insertpol.php?<?php echo "onderwerp={$_GET['onderwerp']}&forum={$_GET['forum']}&reactie={$_GET['reactie']}&topic={$_GET['topic']}" ?>" method="post" name="postform">
    <caption><div class="cap-left"><div class="cap-right">&nbsp;Make your poll!&nbsp;</div></div></caption>	<tr>
		<td class="row1"><b class="genmed">Subject type:</b></td>
		<td class="row2">
			<table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tr>
				<td><span style="white-space: nowrap;"><input type="radio" class="radio" name="pol" value="pol" checked/>POLL</span> </td>
			</tr>
			</table>
		</td>
	</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Forum:</b></td>
	<td class="row2" width="78%"><select class="post" style="width:450px" type="text" name="forum" size="1" tabindex="2"><option><?php echo "{$_GET['forum']}" ?></option></select> </td>
</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Subject:</b></td>
	<td class="row2" width="78%"><select class="post" style="width:450px" type="text" name="onderwerp" size="1" tabindex="2"><option><?php echo "{$_GET['onderwerp']}" ?></option></select></td>
</tr>
<input type="hidden" class="post" value="<?php echo "{$_SESSION['suser']}" ?>">
<tr>
	<td class="row1" width="22%"><b class="genmed">Message:</b></td>
	<td class="row2" width="78%"><input class="post" type="hidden" name="reactie" value="<?php echo "{$_GET['reactie']}" ?>"><br /><div class=\"postbody\"><?php echo "{$_GET['reactie']}" ?></div><br /></td>
</tr>
<tr>
	<td class="row1" width="22%"><b class="genmed">Choices:</b></td>
    <td class="row2" width="78%">
    <p><b>You don't have to use all 5 possibilities. Max 5 or min 2 possibilities!</b></p><br />
    <p>
 <b>First possibility?</b><br /><input type="text" class="post" style="width:450px"  size="45" maxlength="60" tabindex="2" name="keuze1" value="" /><br />
 <b>Second possibility?</b><br /><input type="text" class="post" style="width:450px"  size="45" maxlength="60" tabindex="2" name="keuze2" value="" /><br />
 <b>Third possibility?</b><br /><input type="text" class="post" style="width:450px"  size="45" maxlength="60" tabindex="2" name="keuze3" value="" /><br />
 <b>Fourth possibility?</b><br /><input type="text" class="post" style="width:450px"  size="45" maxlength="60" tabindex="2" name="keuze4" value="" /><br />
 <b>Fifth possibility?</b><br /><input type="text" class="post" style="width:450px"  size="45" maxlength="60" tabindex="2" name="keuze5" value="" /></p>
    </td>
</tr>
<tr>
	<td class="cat" colspan="2" align="center">
		<input class="btnmain" type="submit" accesskey="s" tabindex="11" name="post" value="Place" />
		&nbsp; <input class="btnlite" type="submit" accesskey="c" tabindex="14" name="cancel" value="Reset" />
	</td>
</tr>
</form>
</table>
   	<?php
	}
	?>
 
<br clear="all" />
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a>
            </p>
			<p class="datetime">All times are GMT</p>
		</td>
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