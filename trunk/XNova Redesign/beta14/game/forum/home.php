    <!--<?php include('login.php');?>-->
   <table width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
        <tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a></p>
			<p class="datetime">All times are GMT</p>
		</td>
		</tr>
    </table>
	<br />	
    <table cellspacing="0" width="100%">
	<?php if( $_SESSION['suser'] != NULL ){
		  $res=mysql_query("select authlevel from beta_users where username='".$_SESSION['suser']."'");
		  $row=mysql_fetch_assoc($res);
		  if( $row['authlevel'] >= 2 )
		  { ?>
    <a href="#" onClick="loadpage('./newforum.php','XNova Forum','bodyid');">Make new forum</a>
    <?php }}
	?>
    <?php 
	function markunread($suser){
	$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
	$aantallen=mysql_fetch_assoc($ant);
	$aantal=$aantallen['max(id)'];
	$ant2=mysql_query("select id from beta_users where username='".$suser."'") or die(mysql_error());
	$aantallen2=mysql_fetch_assoc($ant2);
	$ant3=mysql_query("select id from beta_board_subject") or die(mysql_error());
	$h=1;
	if(mysql_num_rows($res) > 0) {
	while($aantallen3=mysql_fetch_assoc($ant3)){
		$ant4=mysql_query("select unread from beta_board_subject where id=".$aantallen3['id']) or die(mysql_error());
		$aantallen4=mysql_fetch_array($ant4, MYSQL_ASSOC);
		$mark=unserialize($aantallen4['unread']);
		$id=$aantallen2['id'];
				for($i=1;$i<=$aantal;$i++){
					if($i==$id){
						if($mark[$i]==2){
							$mark[$i]=1;
						}
					}
				}
		mysql_query("update beta_board_subject set unread='".serialize($mark)."' where id='".$aantallen3['id']) or die(mysql_error());
		$h++;
	}
	}
	}
	if($_SESSION['suser'] != NULL){
		echo "<br><a href=\"#\" onclick=\"markunread(".$_SESSION['suser']."); loadpage('home.php','XNova Forum','bodyid');\">DOESN'T WORK YET !!!! mark all messages as readed</a>";
	}
	?>
    <table class="tablebg" cellspacing="0" width="100%">
		<caption><div class="cap-left"><div class="cap-right">&nbsp;<h4>Help Forums</h4>&nbsp;</div></div></caption>		<tr>
			<th colspan="2">&nbsp;Forum&nbsp;</th>
			<th width="50">&nbsp;Subjects&nbsp;</th>
			<th width="50">&nbsp;Messages&nbsp;</th>
			<th width="175">&nbsp;Last message&nbsp;</th>
 		</tr>
        <?php
		$res=mysql_query("select id,forum,info,auteur,type from beta_board_forum where type='help' order by id") or die(mysql_error());
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res))
		{
			$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
			$aantallen=mysql_fetch_assoc($ant);
			$aantal=$aantallen['max(id)'];
			$ant2=mysql_query("select id from beta_users where username='".$_SESSION['suser']."'") or die(mysql_error());
			$aantallen2=mysql_fetch_assoc($ant2);
			$ant3=mysql_query("select id from beta_board_subject where forum='".$row['forum']."'") or die(mysql_error());
			$h=1;
			if(mysql_num_rows($ant3) > 0) {
			while($aantallen3=mysql_fetch_assoc($ant3)){
				if($aantallen3['id']==NULL){
					$uncolor=$row['forum'];
				}else{
				$ant4=mysql_query("select unread from beta_board_subject where id=".$aantallen3['id']) or die(mysql_error());
				$aantallen4=mysql_fetch_array($ant4, MYSQL_ASSOC);
				$arcolor=unserialize($aantallen4['unread']);
				$id=$aantallen2['id'];
				for($u=1;$u<=$aantal;$u++){
					if($u==$id){
						if($uncolor=="<font style=\"color:yellow;\">".$row['forum']."</font>"){
							$uncolor="<font style=\"color:yellow;\">".$row['forum']."</font>";
							$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
						}else{
							if($arcolor[$u]==2){
								$uncolor="<font style=\"color:yellow;\">".$row['forum']."</font>";
								$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
							}else{
								$uncolor=$row['forum'];
								$unimg="<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" />";
							}
						}
					}
				}
				}
			$h++;
			}
			}else{
				$uncolor=$row['forum'];
			}
		$forum = "<tr>";
		$forum .= "<td class=\"row1\" width=\"31\" align=\"center\">";
		if($_SESSION['suser'] == NULL){
			$forum .= "<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" /></td>";
		}else{
			$forum .= $unimg."</td>";
		}
		$forum .= "<td class=\"row1\">";
		if( $_SESSION['suser'] != NULL ){
		  $res5=mysql_query("select authlevel from beta_users where username='".$_SESSION['suser']."'");
		  $row5=mysql_fetch_assoc($res5);
		  if( $row5['authlevel'] >= 2 ){
		  $forum .= "<a href=\"#\" onclick=\"loadpage('deleteforum.php?forum=".$row['forum']."','XNova Forum','bodyid');\"><img src=\"img/r.png\" /></a>";
		  }}
		$forum .= "<a class=\"forumlink\" href=\"#\" onClick=\"loadpage('forums.php?forum=".$row['forum']."&p=0','XNova Forum','bodyid');\">";
		if($_SESSION['suser'] == NULL){
			$forum .= $row['forum']."</a>";
		}else{
			$forum .= $uncolor."</a>";
		}
		$forum .= "<p class=\"forumdesc\">".$row['info']."</p>";
		$forum .= "</td>";
		$forum .= "<td class=\"row2\" align=\"center\"><p class=\"topicdetails\">";
			$res2=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$row['forum']."'");
			$row2=mysql_fetch_assoc($res2);
		$forum .= $row2['count(onderwerp)'];
		$forum .= "</p></td>";
		$forum .=	"<td class=\"row2\" align=\"center\"><p class=\"topicdetails\">"; 
			$res3=mysql_query("select count(onderwerp) from beta_board_reactie where forum = '".$row['forum']."'");
			$row3=mysql_fetch_assoc($res3);
		$forum .= $row3['count(onderwerp)'];
		$forum .= "</p></td>";
		$forum .= "<td class=\"row2\" align=\"center\" nowrap=\"nowrap\">";
		$forum .=	"<p class=\"topicdetails\">";
			$res4=mysql_query("select onderwerp ,time, auteur,topic from beta_board_reactie where forum = '".$row['forum']."' order by id desc");
			$row4=mysql_fetch_assoc($res4);
		$forum .=		$row4['time'];
		$forum .=		"</p>";
		$forum .=		"<p class=\"topicdetails\">";
		$forum .=		"<a href=\"#\" onClick=\"loadpage('playercard.php?auteur=".$row4['auteur']."&forum=".$row['forum']."','XNova Forum','bodyid');\">".$row4['auteur'];
		if($row4['topic'] == 'onderwerp'){									
		$forum .=		"<a href=\"#\" onClick=\"loadpage('topic.php?onderwerp=".$row4['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		}else{
		$forum .=		"<a href=\"#\" onClick=\"loadpage('topicmede.php?onderwerp=".$row4['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		}
		$forum .=		"<img src=\"img/icon_topic_latest.gif\" width=\"13\" height=\"9\" alt=\"Bekijkt laatste berichten\" title=\"Bekijkt laatste berichten\" /></a>";
		$forum .=		"</p>";
		$forum .=	"</td>";
		$forum .= "</tr>";

		echo $forum;
        $i++;
        }
        }
        ?>
		
				</table>
<br />
		    		<table class="tablebg" cellspacing="0" width="100%">
		<caption><div class="cap-left"><div class="cap-right">&nbsp;<h4>Game Forums</h4>&nbsp;</div></div></caption>		<tr>
			<th colspan="2">&nbsp;Forum&nbsp;</th>
			<th width="50">&nbsp;Subjects&nbsp;</th>
			<th width="50">&nbsp;Messages&nbsp;</th>
			<th width="175">&nbsp;Last message&nbsp;</th>
		</tr>
        <?php
		$res=mysql_query("select id,forum,info,auteur,type from beta_board_forum where type='game' order by id") or die(mysql_error());
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res))
		{
			$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
			$aantallen=mysql_fetch_assoc($ant);
			$aantal=$aantallen['max(id)'];
			$ant2=mysql_query("select id from beta_users where username='".$_SESSION['suser']."'") or die(mysql_error());
			$aantallen2=mysql_fetch_assoc($ant2);
			$ant3=mysql_query("select id from beta_board_subject where forum='".$row['forum']."'") or die(mysql_error());
			$h=1;
			if(mysql_num_rows($ant3) > 0) {
			while($aantallen3=mysql_fetch_assoc($ant3)){
				if($aantallen3['id']==NULL){
					$uncolor=$row['forum'];
				}else{
				$ant4=mysql_query("select unread from beta_board_subject where id=".$aantallen3['id']) or die(mysql_error());
				$aantallen4=mysql_fetch_array($ant4, MYSQL_ASSOC);
				$arcolor=unserialize($aantallen4['unread']);
				$id=$aantallen2['id'];
				for($u=1;$u<=$aantal;$u++){
					if($u==$id){
						if($uncolor=="<font style=\"color:yellow;\">".$row['forum']."</font>"){
							$uncolor="<font style=\"color:yellow;\">".$row['forum']."</font>";
							$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
						}else{
							if($arcolor[$u]==2){
								$uncolor="<font style=\"color:yellow;\">".$row['forum']."</font>";
								$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
							}else{
								$uncolor=$row['forum'];
								$unimg="<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" />";
							}
						}
					}
				}
				}
				$h++;
			}
			}else{
				$uncolor=$row['forum'];
			}		
		$forum = "<tr>";
		$forum .= "<td class=\"row1\" width=\"31\" align=\"center\">";
		if($_SESSION['suser'] == NULL){
			$forum .= "<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" /></td>";
		}else{
			$forum .= $unimg."</td>";
		}
		$forum .= "<td class=\"row1\">";
		  if( $_SESSION['suser'] != NULL ){
		  $res5=mysql_query("select authlevel from beta_users where username='".$_SESSION['suser']."'");
		  $row5=mysql_fetch_assoc($res5);
		  if( $row5['authlevel'] >= 2 ){
		  $forum .= "<a href=\"#\" onclick=\"loadpage('deleteforum.php?forum=".$row['forum']."','XNova Forum','bodyid');\"><img src=\"img/r.png\" /></a>";
		  }}
		$forum .= "<a class=\"forumlink\" href=\"#\" onClick=\"loadpage('forums.php?forum=".$row['forum']."&p=0','XNova Forum','bodyid');\">";
		if($_SESSION['suser'] == NULL){
			$forum .= $row['forum']."</a>";
		}else{
			$forum .= $uncolor."</a>";
		}
		$forum .= "<p class=\"forumdesc\">".$row['info']."</p>";
		$forum .= "</td>";
		$forum .= "<td class=\"row2\" align=\"center\"><p class=\"topicdetails\">";
			$res2=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$row['forum']."'");
			$row2=mysql_fetch_assoc($res2);
		$forum .= $row2['count(onderwerp)'];
		$forum .= "</p></td>";
		$forum .=	"<td class=\"row2\" align=\"center\"><p class=\"topicdetails\">"; 
			$res3=mysql_query("select count(onderwerp) from beta_board_reactie where forum = '".$row['forum']."'");
			$row3=mysql_fetch_assoc($res3);
		$forum .= $row3['count(onderwerp)'];
		$forum .= "</p></td>";
		$forum .= "<td class=\"row2\" align=\"center\" nowrap=\"nowrap\">";
		$forum .=	"<p class=\"topicdetails\">";
			$res4=mysql_query("select onderwerp ,time, auteur,topic from beta_board_reactie where forum = '".$row['forum']."' order by id desc");
			$row4=mysql_fetch_assoc($res4);
		$forum .=		$row4['time'];
		$forum .=		"</p>";
		$forum .=		"<p class=\"topicdetails\">";
		$forum .=		"<a href=\"#\" onClick=\"loadpage('playercard.php?auteur=".$row4['auteur']."&forum=".$row['forum']."','XNova Forum','bodyid');\">".$row4['auteur'];
		if($row4['topic'] == 'onderwerp'){									
		$forum .=		"<a href=\"#\" onClick=\"loadpage('topic.php?onderwerp=".$row4['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		}else{
		$forum .=		"<a href=\"#\" onClick=\"loadpage('topicmede.php?onderwerp=".$row4['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		}
		$forum .=		"<img src=\"img/icon_topic_latest.gif\" width=\"13\" height=\"9\" alt=\"Bekijkt laatste berichten\" title=\"Bekijkt laatste berichten\" /></a>";
		$forum .=		"</p>";
		$forum .=	"</td>";
		$forum .= "</tr>";

		echo $forum;
        $i++;
        }
        }
        ?>
		</table>
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a></p>
			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>	<br clear="all" />
<?php 
		include('online.inc.php');
		$res=mysql_query("select count(username) from beta_users where forum_online='online'") or die(mysql_error());
		$res2=mysql_query("select username from beta_users where forum_online='online'") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
	include('visitors.php');
	$guests = CountGuests() - $row['count(username)'];
	$online = $row['count(username)'] + $guests;
    $user =	"<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">";
	$user .="<caption><div class=\"cap-left\"><div class=\"cap-right\">&nbsp;Who is online&nbsp;</div></div></caption>	<tr>";
	$user .="<td class=\"row1\" rowspan=\"2\" align=\"center\" valign=\"middle\"><img src=\"img/whosonline.gif\" alt=\"Wie is er online\" /></td>";
	$user .="<td class=\"row1\" width=\"100%\"><span class=\"genmed\">There are ";
	$user .="<strong>".$online."</strong> users online ";
	$user .=":: ".$row['count(username)']." registered and ".$guests." guests ";
	$user .="(based on users who are now online)<br />";
	/*$user .="Het grootste aantal gebruikers online was ";
	$user .="<strong>7</strong> op zo jan 25, 2009 10:14 pm<br />";
	$user .="<br />Geregistreerde gebruikers: ";*/
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
	$user .="<tr>";
	$user .="<td class=\"row1 nobold\"><b class=\"gensmall\">Legenda :: 
	<font style=\"color: red;\">Game Admins</font>, 
	<font style=\"color: green;\">Super Game Operators</font>, 
	<font style=\"color: lightgreen;\">Game Operators</font></b></td>";
	$user .="</tr>";
	$user .="</table>";
	echo $user; 
?>	
<br clear="all" />
 
<table class="tablebg" width="100%" cellspacing="0">
<caption><div class="cap-left"><div class="cap-right">&nbsp;Statistics&nbsp;</div></div></caption><tr>
	<td class="row1"><img src="img/stats.gif" alt="Statistieken" /></td>
	<td class="row1 nobold" width="100%" valign="middle"><p class="genmed">Total number of messages <strong>
    <?php 
	$res = mysql_query("SELECT count(id) from beta_board_reactie");
	$row = mysql_fetch_assoc($res);
	echo $row['count(id)'];
	?>
    </strong> | Total number of subjects <strong>
    <?php 
	$res = mysql_query("SELECT count(id) from beta_board_subject");
	$row = mysql_fetch_assoc($res);
	echo $row['count(id)'];
	?>
    </strong> | Total number of members <strong>
    <?php
	$res = mysql_query("SELECT count(id) FROM beta_users");
	$row = mysql_fetch_assoc($res);
	echo $row['count(id)'];
    ?>
    </strong> | Our last new member is <strong>
    <?php
	$res = mysql_query("SELECT max(id) FROM beta_users");
	$row = mysql_fetch_assoc($res);
	$res2 = mysql_query("SELECT username FROM beta_users WHERE id = '".$row['max(id)']."'");
	$row2 = mysql_fetch_assoc($res2);
	echo $row2['username'];
    ?></strong></p></td>
</tr>
</table>