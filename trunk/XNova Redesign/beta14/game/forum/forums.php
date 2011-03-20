<!--<?php include('login.php');?>-->
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a>
			</p>			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>
	<br />	<div id="pageheader">
	        		<h2><a class="titles" href="#" onClick="loadpage('./forums.php?forum=<?php $forum = "{$_GET['forum']}"; echo $forum?>&p=0','XNova Forum','bodyid');"><?php $forum = "{$_GET['forum']}"; echo $forum ?></a></h2>
    		</div>
 
	<br clear="all" />
 
<div id="pagecontent">
 
		<table width="100%" cellspacing="1">
		<tr>
							<td align="left" valign="middle"><?php if(isset($_SESSION['suser'])){?><a href="#" onClick="loadpage('newtopic.php?forum=<?php $forum = "{$_GET['forum']}"; echo $forum ?>','XNova Forum','bodyid');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('rollover','','img/button_topic_new2.gif',1)"><img src="img/button_topic_new.gif" alt="Nieuw Onderwerp" name="rollover" width="141" height="20" border="0" id="rollover" /></a></td>
							<?php 				
							$forum = "{$_GET['forum']}";
							$res=mysql_query("select username, authlevel from beta_users where username ='".$_SESSION['suser']."'") or die(mysql_error());
							$row=mysql_fetch_assoc($res);
							if($row['authlevel'] > 0)
							{
								$html = "<td align=\"left\" valign=\"middle\">";
								$html .= "<a href=\"#\" onClick=\"loadpage('newmede.php?forum=".$forum."','XNova Forum','bodyid');\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover3','','img/button_topicmede_new2.gif',1)\">";
								$html .= "<img src=\"img/button_topicmede_new.gif\" alt=\"Nieuw Onderwerp\" name=\"rollover3\" width=\"141\" height=\"20\" border=\"0\" id=\"rollover3\" />";
								$html .= "</a></td>";
								echo $html;
							}
							}
							?>
                           <!--<a href="./newtopic.php"><img src="img/button_topic_new.gif" width="141" height="20" alt="Plaats een nieuw onderwerp" title="Plaats een nieuw onderwerp" /></a>-->
                           <td class="nav" valign="middle" nowrap="nowrap">
                          <?php 
						  $p = "{$_GET['p']}";
						  $forum = "{$_GET['forum']}";
						  $res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."'") or die(mysql_error());
						  $row=mysql_fetch_assoc($res);
						  $pages = $row['count(onderwerp)'];
						  if( $p <= 25 ){
							  echo "&nbsp;Page <strong>1</strong> of ";
						  }else{
							  $z = 1;
							  for( $i = 0; $i <= $pages; $i+=25 ){
								  if($p==$i){
									  $page = $p/25+1;
									  echo $page;
								  }
							  }
						  }
						  $maxpages = ceil($pages/25);
						  echo "<strong>".$maxpages."</strong><br /></td>"
						  ?>
					<td class="gensmall" nowrap="nowrap">&nbsp;[ 
                    <?php 
					$forum = "{$_GET['forum']}";
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."'") or die(mysql_error());
					$row=mysql_fetch_assoc($res);
					echo $row['count(onderwerp)'];
					?>
                    subjects ]&nbsp;</td>
					<td align="right" width="100%">
                    <?php 
					$p = "{$_GET['p']}";
					$forum = "{$_GET['forum']}";
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."' and topic='onderwerp'") or die(mysql_error());
					$row=mysql_fetch_assoc($res);
					$z=1;
					$vorige = $p-25;
					$volgende = $p+25;
					if( $row['count(onderwerp)'] > 25 ){
					$count = $row['count(onderwerp)'];
					$pag = "<b>Go to page ";
					if( $p > 0 ){
						$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$vorige."','XNova Forum','bodyid');\">previous </a>";
					}
					for( $i = 0; $i < $count; $i+=25 ){
						if($i == $count-1){
							if($i == $p) {
							$pag .= $z++;
							}else{
							$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$i."','XNova Forum','bodyid');\">".$z++."</a>";	
							}
						}
						else{
							if($i == $p) {
							$pag .= $z++.", ";
							}else{
							$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$i."','XNova Forum','bodyid');\">".$z++."</a>, ";	
							}
						}
					}
					if( $p <= $count -25){
						$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$volgende."','XNova Forum','bodyid');\"> next </a>";
					}
					$pag .= "</b>";
					echo $pag;
					}
					?>			
                    </td>
					</tr>
		</table>
					<table class="tablebg" width="100%" cellspacing="0" id='mytable'>
		<caption><div class="cap-left"><div class="cap-right">&nbsp;
            <?php
			$forum = "{$_GET['forum']}";
			echo $forum;
			?>
        &nbsp;</div></div></caption>		<tr>
							<th colspan="2">&nbsp;Subjects&nbsp;</th>
						<th>&nbsp;Author&nbsp;</th>
			<th>&nbsp;Answers&nbsp;</th>
			<th>&nbsp;Views&nbsp;</th>
			<th>&nbsp;Last message&nbsp;</th>
		</tr>
 
						<tr>
					<td class="row3" colspan="6"><b class="gensmall">Reports</b></td>
				</tr>
<!--			
			<tr>
				<td class="row1" width="25" align="center"><img src="./styles/acidtech/imageset/announce_read.gif" width="18" height="18" alt="Geen nieuwe berichten" title="Geen nieuwe berichten" /></td>
								<td class="row1">
										 <b>Poll: </b> <a title="Geplaatst: wo nov 26, 2008 6:23 pm" href="./viewtopic.php?f=4&amp;t=66" class="topictitle">POLL: Inactives Verwijderen</a>
											<p class="gensmall"> [ <img src="./styles/acidtech/imageset/icon_topic_latest.gif" width="13" height="9" alt="Ga naar pagina" title="Ga naar pagina" />Ga naar pagina: <a href="./viewtopic.php?f=4&amp;t=66&amp;start=0">1</a><span class="page-sep">, </span><a href="./viewtopic.php?f=4&amp;t=66&amp;start=10">2</a> ] </p>
									</td>
				<td class="row2" width="130" align="center"><p class="topicauthor"><a href="./memberlist.php?mode=viewprofile&amp;u=2" style="color: #AA0000;" class="username-coloured">Asschen</a></p></td>
				<td class="row1" width="50" align="center"><p class="topicdetails">10</p></td>
				<td class="row2" width="50" align="center"><p class="topicdetails">222</p></td>
				<td class="row1" width="140" align="center">
					<p class="topicdetails" style="white-space: nowrap;">wo dec 31, 2008 10:19 pm</p>
					<p class="topicdetails"><a href="./memberlist.php?mode=viewprofile&amp;u=78">Metallica</a>						<a href="./viewtopic.php?f=4&amp;t=66&amp;p=764#p764"><img src="./styles/acidtech/imageset/icon_topic_latest.gif" width="13" height="9" alt="Bekijkt laatste berichten" title="Bekijkt laatste berichten" /></a>
					</p>
				</td>
			</tr>-->
		<?php
		$forum = "{$_GET['forum']}";
		$res=mysql_query("select id,onderwerp,auteur,forum,type,topic,hits,status from beta_board_subject where topic='mededeling' and forum = '".$forum."' order by id desc") or die(mysql_error());
		$res6=mysql_query("select authlevel from beta_users where username = '".$_SESSION['suser']."'") or die(mysql_error());
		$row6=mysql_fetch_assoc($res6);
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res))
		{
		$res3=mysql_query("select time, beta_board_reactie.auteur from beta_board_reactie, beta_board_subject where beta_board_subject.onderwerp = '".$row['onderwerp']."' and beta_board_reactie.topic='mededeling' and beta_board_reactie.onderwerp = beta_board_subject.onderwerp order by beta_board_reactie.id desc") or die(mysql_error());
		$res2=mysql_query("select authlevel from beta_users, beta_board_subject where beta_users.username = '".$row['auteur']."'") or die(mysql_error());
		$row2=mysql_fetch_assoc($res2);
		$row3=mysql_fetch_assoc($res3);
		$res5=mysql_query("select authlevel from beta_users, beta_board_subject where beta_users.username = '".$row3['auteur']."'") or die(mysql_error());
		$row5=mysql_fetch_assoc($res5);
		$res7=mysql_query("select status from beta_board_subject where onderwerp='".$row['onderwerp']."' and forum='".$row['forum']."' and topic='mededeling'") or die(mysql_error());
		$row7=mysql_fetch_assoc($res7);
		if($row2['authlevel'] != 0) {
			if($row2['authlevel'] != 1) {
				if($row2['authlevel'] != 2) {
						$color = "red";
					}	
				else{
					$color = "green";
				}
			}else{
				$color = "lightgreen";
			}	
		}else {	
			$color = "light blue";
		}
		if($row5['authlevel'] != 0) {
			if($row5['authlevel'] != 1) {
				if($row5['authlevel'] != 2) {
						$color2 = "red";
					}	
				else{
					$color2 = "green";
				}
			}else{
				$color2 = "lightgreen";
			}	
		}else {	
			$color2 = "light blue";
		}
		$res4=mysql_query("select count(reactie) from beta_board_reactie where topic='mededeling' and onderwerp = '".$row['onderwerp']."' and forum = '".$row['forum']."'") or die(mysql_error());
		$row4=mysql_fetch_assoc($res4);
		$html = "<tr>";
			$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
			$aantallen=mysql_fetch_assoc($ant);
			$aantal=$aantallen['max(id)'];
			$onderwerp = $row['onderwerp'] ;
			$ant2=mysql_query("select id from beta_users where username='".$_SESSION['suser']."'") or die(mysql_error());
			$aantallen2=mysql_fetch_assoc($ant2);
			$ant3=mysql_query("select id from beta_board_subject where onderwerp='".$onderwerp."' and forum='".$forum."'") or die(mysql_error());
			$aantallen3=mysql_fetch_assoc($ant3);
			$ant4=mysql_query("select unread from beta_board_subject where id=".$aantallen3['id']) or die(mysql_error());
			$aantallen4=mysql_fetch_array($ant4, MYSQL_ASSOC);
			$arcolor=unserialize($aantallen4['unread']);
			$id=$aantallen2['id'];
			for($i=1;$i<=$aantal;$i++){
				if($i==$id){
					if($arcolor[$i]==2){
						$uncolor="<font style=\"color:yellow;\">".$row['onderwerp']."</font>";
						$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
					}else{
						$uncolor=$row['onderwerp'];
						$unimg="<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" />";
					}
				}
			}
		$html .= "<td class=\"row1\" width=\"25\" align=\"center\">";
		if($_SESSION['suser'] == NULL){
			if($row['status']=='gesloten'){
				$html .= "<img src=\"img/forum_closet.gif\" width=\"23\" height=\"23\" alt=\"Closed\" title=\"Closed\" /></td>";
			}else{
				$html .= "<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" /></td>";
			}
		}else{
			if($row['status']=='gesloten'){
				$html .= "<img src=\"img/forum_closet.gif\" width=\"23\" height=\"23\" alt=\"Closed\" title=\"Closed\" /></td>";
			}else{
				$html .= $unimg."</td>";
			}
		}
		$html .= "<td class=\"row1\">";
		if($row['type'] == 'pol'){
			if($row6['authlevel'] > 1){
			$html .= "<a href=\"remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=mededeling\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";//"<a href=\"#\" onclick=\"loadpage('remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=mededeling','XNova Forum','bodyid');\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
				if($row7['status'] == 'open'){
				$html .= "<a href=\"#\" onclick=\"loadpage('locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=mededeling&auteur=".$row['auteur']."','XNova Forum','bodyid');\"><img src=\"img/lock.png\" width=\"13\" height=\"13\" alt=\"Lock\" /></a><b>Poll: </b>";
				}else{
				$html .= "<a href=\"#\" onclick=\"loadpage('locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=mededeling&auteur=".$row['auteur']."','XNova Forum','bodyid');\"\"><img src=\"img/unlock.png\" width=\"13\" height=\"13\" alt=\"Unlock\" /></a><b>Poll: </b>";
				}
			}else{
			$html .= "<b>Poll: </b>";
			}
		}
		else{
			if($row6['authlevel'] > 1){
			$html .= "<a href=\"remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=mededeling\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";//"<a href=\"#\" onclick=\"loadpage('remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=mededeling','XNova Forum','bodyid');\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
				if($row7['status'] == 'open'){
				$html .= "<a href=\"#\" onclick=\"loadpage('locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=mededeling&auteur=".$row['auteur']."','XNova Forum','bodyid');\"><img src=\"img/lock.png\" width=\"13\" height=\"13\" alt=\"Lock\" /></a>";
				}else{
				$html .= "<a href=\"#\" onclick=\"loadpage('locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=mededeling&auteur=".$row['auteur']."','XNova Forum','bodyid');\"><img src=\"img/unlock.png\" width=\"13\" height=\"13\" alt=\"Unlock\" /></a>";
				}
			}else{
			$html .= "";
			}
		}			
		$html .= "&nbsp;<a class=\"topictitle\" href=\"#\" onClick=\"loadpage('topicmede.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		if($_SESSION['suser'] == NULL){
			$html .= $row['onderwerp']."</a></td>";
		}else{
			$html .= $uncolor."</a></td>";
		}
		$html .= "<td class=\"row2\" width=\"130\" align=\"center\"><p class=\"topicauthor\"><a href=\"playercard.php?auteur=".$row['auteur']."&forum=".$row['forum']."\" style=\"color: ".$color."\" class=\"username-coloured\">".$row['auteur']."";
        $html .= "<td class=\"row1\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row4['count(reactie)']."</p></td>";
		$html .= "<td class=\"row2\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row['hits']."</p></td>";
		$html .= "<td class=\"row1\" width=\"140\" align=\"center\">";
		$html .= "<p class=\"topicdetails\">".$row3['time']."</p>";
		$html .= "<p class=\"topicdetails\"><a href=\"playercard.php?auteur=".$row3['auteur']."&forum=".$row['forum']."\" style=\"color: ".$color2."\" class=\"username-coloured\">".$row3['auteur']."</p>";
		$html .= "</td>";
		$html .= "</tr>";
			echo $html;
			$i++;
		}
		}
		?>

 					  <tr>
					<td class="row3" colspan="6"><b class="gensmall">Subjects</b></td>
				</tr>

		<?php 
		$p = "{$_GET['p']}";
		$forum = "{$_GET['forum']}";
		$res=mysql_query("select id,onderwerp,auteur,forum,type,topic,hits,status from beta_board_subject where topic='onderwerp' and forum = '".$forum."' order by id desc limit ".$p.",25") or die(mysql_error());
		$res6=mysql_query("select authlevel from beta_users where username = '".$_SESSION['suser']."'") or die(mysql_error());
		$row6=mysql_fetch_assoc($res6);
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res))
		{
		$res3=mysql_query("select time, beta_board_reactie.auteur from beta_board_reactie, beta_board_subject where beta_board_subject.onderwerp = '".$row['onderwerp']."' and beta_board_reactie.topic='onderwerp' and beta_board_reactie.onderwerp = beta_board_subject.onderwerp order by beta_board_reactie.id desc") or die(mysql_error());
		$res2=mysql_query("select authlevel from beta_users, beta_board_subject where beta_users.username = '".$row['auteur']."'") or die(mysql_error());
		$row2=mysql_fetch_assoc($res2);
		$row3=mysql_fetch_assoc($res3);
		$res5=mysql_query("select authlevel from beta_users, beta_board_subject where beta_users.username = '".$row3['auteur']."'") or die(mysql_error());
		$row5=mysql_fetch_assoc($res5);
		$res7=mysql_query("select status from beta_board_subject where onderwerp='".$row['onderwerp']."' and forum='".$row['forum']."' and topic='onderwerp'") or die(mysql_error());
		$row7=mysql_fetch_assoc($res7);
		if($row2['authlevel'] != 0) {
			if($row2['authlevel'] != 1) {
				if($row2['authlevel'] != 2) {
						$color = "red";
					}	
				else{
					$color = "green";
				}
			}else{
				$color = "lightgreen";
			}	
		}else {	
			$color = "light blue";
		}
		if($row5['authlevel'] != 0) {
			if($row5['authlevel'] != 1) {
				if($row5['authlevel'] != 2) {
						$color2 = "red";
					}	
				else{
					$color2 = "green";
				}
			}else{
				$color2 = "lightgreen";
			}	
		}else {	
			$color2 = "light blue";
		}
		
		$res4=mysql_query("select count(reactie) from beta_board_reactie where topic='onderwerp' and onderwerp = '".$row['onderwerp']."' and forum = '".$row['forum']."'") or die(mysql_error());
		$row4=mysql_fetch_assoc($res4);
		$html = "<tr>";
			$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
			$aantallen=mysql_fetch_assoc($ant);
			$aantal=$aantallen['max(id)'];
			$onderwerp = $row['onderwerp'] ;
			$ant2=mysql_query("select id from beta_users where username='".$_SESSION['suser']."'") or die(mysql_error());
			$aantallen2=mysql_fetch_assoc($ant2);
			$ant3=mysql_query("select id from beta_board_subject where onderwerp='".$onderwerp."' and forum='".$forum."'") or die(mysql_error());
			$aantallen3=mysql_fetch_assoc($ant3);
			$ant4=mysql_query("select unread from beta_board_subject where id=".$aantallen3['id']) or die(mysql_error());
			$aantallen4=mysql_fetch_array($ant4, MYSQL_ASSOC);
			$arcolor=unserialize($aantallen4['unread']);
			$id=$aantallen2['id'];
			for($i=1;$i<=$aantal;$i++){
				if($i==$id){
					if($arcolor[$i]==2){
						$uncolor="<font style=\"color:yellow;\">".$row['onderwerp']."</font>";
						$unimg="<img src=\"img/forum_unread.gif\" width=\"23\" height=\"23\" alt=\"New messages\" title=\"New messages\" />";
					}else{
						$uncolor=$row['onderwerp'];
						$unimg="<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" />";
					}
				}
			}
		$html .= "<td class=\"row1\" width=\"25\" align=\"center\">";
		if($_SESSION['suser'] == NULL){
			if($row['status']=='gesloten'){
				$html .= "<img src=\"img/forum_closet.gif\" width=\"23\" height=\"23\" alt=\"Closed\" title=\"Closed\" /></td>";
			}else{
				$html .= "<img src=\"img/forum_read.gif\" width=\"23\" height=\"23\" alt=\"No new messages\" title=\"No new messages\" /></td>";
			}
		}else{
			if($row['status']=='gesloten'){
				$html .= "<img src=\"img/forum_closet.gif\" width=\"23\" height=\"23\" alt=\"Closed\" title=\"Closed\" /></td>";
			}else{
				$html .= $unimg."</td>";
			}
		}
		$html .= "<td class=\"row1\">";
		if($row['type'] == 'pol'){
			if($row6['authlevel'] > 1){
			$html .= "<a href=\"remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=onderwerp\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
				if($row7['status'] == 'open'){
				$html .= "<a href=\"locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=onderwerp&auteur=".$row['auteur']."\"><img src=\"img/lock.png\" width=\"13\" height=\"13\" alt=\"Lock\" /></a><b>Poll: </b>";
				}else{
				$html .= "<a href=\"locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=pol&topic=onderwerp&auteur=".$row['auteur']."\"><img src=\"img/unlock.png\" width=\"13\" height=\"13\" alt=\"Unlock\" /></a><b>Poll: </b>";
				}
			}else{
			$html .= "<b>Poll: </b>";
			}
		}
		else{
			if($row6['authlevel'] > 1){
			$html .= "<a href=\"remove.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=onderwerp\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
				if($row7['status'] == 'open'){
				$html .= "<a href=\"locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=onderwerp&auteur=".$row['auteur']."\"><img src=\"img/lock.png\" width=\"13\" height=\"13\" alt=\"Lock\" /></a>";
				}else{
				$html .= "<a href=\"locking.php?status=".$row7['status']."&onderwerp=".$row['onderwerp']."&forum=".$row['forum']."&type=notpol&topic=onderwerp&auteur=".$row['auteur']."\"><img src=\"img/unlock.png\" width=\"13\" height=\"13\" alt=\"Unlock\" /></a>";
				}
			}else{
			$html .= "";

			}
		}
		$html .= "&nbsp;<a class=\"topictitle\" href=\"#\" onClick=\"loadpage('topic.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."','XNova Forum','bodyid');\" >";
		if($_SESSION['suser'] == NULL){
			$html .= $row['onderwerp']."</a></td>";
		}else{
			$html .= $uncolor."</a></td>";
		}//<a class=\"topictitle\" href=\"topic.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."\" >".$row['onderwerp']."</a></td>";
		$html .= "<td class=\"row2\" width=\"130\" align=\"center\"><p class=\"topicauthor\"><a href=\"playercard.php?auteur=".$row['auteur']."&forum=".$row['forum']."\" style=\"color: ".$color."\" class=\"username-coloured\">".$row['auteur']."";
        $html .= "<td class=\"row1\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row4['count(reactie)']."</p></td>";
		$html .= "<td class=\"row2\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row['hits']."</p></td>";
		$html .= "<td class=\"row1\" width=\"140\" align=\"center\">";
		$html .= "<p class=\"topicdetails\">".$row3['time']."</p>";
		$html .= "<p class=\"topicdetails\"><a href=\"playercard.php?auteur=".$row3['auteur']."&forum=".$row['forum']."\" style=\"color: ".$color2."\" class=\"username-coloured\">".$row3['auteur']."</p>";				
		$html .= "</td>";
		$html .= "</tr>";
			echo $html;
			$i++;
		}
		}
		?>
		</table>
					<table class="tablebg" width="100%" cellspacing="0">
					  <tr align="center">
					    <td class="cat" colspan="7">
                        <?php 
						$p = "{$_GET['p']}";
						$forum = "{$_GET['forum']}";
						echo "<a href=\"#\" onclick=\"loadpage('./forums.php?forum=".$forum."&p=".$p."','XNova Forum','bodyid');\">Go to top</a>";
						?>
					    </td>
				      </tr>
	    </table>

        
        				<table width="100%" cellspacing="1">
<tr>
							<td align="left" valign="middle"><?php if(isset($_SESSION['suser'])){?><a href="#" onClick="loadpage('newtopic.php?forum=<?php $forum = "{$_GET['forum']}"; echo $forum ?>','XNova Forum','bodyid');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('rollover2','','img/button_topic_new2.gif',1)"><img src="img/button_topic_new.gif" alt="Nieuw Onderwerp" name="rollover2" width="141" height="20" border="0" id="rollover2" /></a></td>
							<?php 				
							$forum = "{$_GET['forum']}";
							$res=mysql_query("select username, authlevel from beta_users where username ='".$_SESSION['suser']."'") or die(mysql_error());
							$row=mysql_fetch_assoc($res);
							if($row['authlevel'] > 0)
							{
								$html = "<td align=\"left\" valign=\"middle\">";
								$html .= "<a href=\"#\" onClick=\"loadpage('newmede.php?forum=".$forum."','XNova Forum','bodyid');\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover4','','img/button_topicmede_new2.gif',1)\">";
								$html .= "<img src=\"img/button_topicmede_new.gif\" alt=\"Nieuw Onderwerp\" name=\"rollover4\" width=\"141\" height=\"20\" border=\"0\" id=\"rollover4\" />";
								$html .= "</a></td>";
								echo $html;
							}
							}
							?>
							                           <td class="nav" valign="middle" nowrap="nowrap">
                          <?php 
						  $p = "{$_GET['p']}";
						  $forum = "{$_GET['forum']}";
						  $res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."'") or die(mysql_error());
						  $row=mysql_fetch_assoc($res);
						  $pages = $row['count(onderwerp)'];
						  if( $p <= 25 ){
							  echo "&nbsp;Page <strong>1</strong> of ";
						  }else{
							  $z = 1;
							  for( $i = 0; $i <= $pages; $i+=25 ){
								  if($p==$i){
									  $page = $p/25+1;
									  echo $page;
								  }
							  }
						  }
						  $maxpages = ceil($pages/25);
						  echo "<strong>".$maxpages."</strong><br /></td>"
						  ?>
				<td class="gensmall" nowrap="nowrap">&nbsp;[ 
                    <?php
					$forum = "{$_GET['forum']}";
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."'");
					$row=mysql_fetch_assoc($res);
					echo $row['count(onderwerp)'];
					?>
                    subjects ]&nbsp;</td>
									<td align="right" width="100%">
                    <?php 
					$p = "{$_GET['p']}";
					$forum = "{$_GET['forum']}";
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = '".$forum."' and topic='onderwerp'") or die(mysql_error());
					$row=mysql_fetch_assoc($res);
					$z=1;
					$vorige = $p-25;
					$volgende = $p+25;
					if( $row['count(onderwerp)'] > 25 ){
					$count = $row['count(onderwerp)'];
					$pag = "<b>Go to page ";
					if( $p > 0 ){
						$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$vorige."','XNova Forum','bodyid');\">previous </a>";
					}
					for( $i = 0; $i < $count; $i+=25 ){
						if($i == $count-1){
							if($i == $p) {
							$pag .= $z++;
							}else{
							$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$i."','XNova Forum','bodyid');\">".$z++."</a>";	
							}
						}
						else{
							if($i == $p) {
							$pag .= $z++.", ";
							}else{
							$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$i."','XNova Forum','bodyid');\">".$z++."</a>, ";	
							}
						}
					}
					if( $p <= $count -25){
						$pag .= "<a href=\"#\" onClick=\"loadpage('forums.php?forum=".$forum."&p=".$volgende."','XNova Forum','bodyid');\"> next </a>";
					}
					$pag .= "</b>";
					echo $pag;
					}
					?>			
                    </td>
					</tr>
		</table>
	
	<br clear="all" />
 
</div>
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
             <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a>
            </p>			<p class="datetime">All times are GMT </p>
		</td>
	</tr>
	</table>	<br clear="all" />
 
	<!--<table class="tablebg" width="100%" cellspacing="0">
	<tr>
		<td class="cat"><h4>Who is online (doesn't work yet)</h4></td>
	</tr>
	<tr>
		<td class="row1"><p class="gensmall">Users on this forum: None registered users en 1 guest</p></td>
	</tr>
	</table>-->
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
	$user .="</table>";
	echo $user; 
?>	
	<br clear="all" />
 
	<table width="100%" cellspacing="0">
	<tr>
		<td align="left" valign="top">
			<table cellspacing="3" cellpadding="0" border="0" class="legend legend-viewforum">
            <tr>
				<td width="20" style="text-align: center;"><img src="img/forum_unread.gif" width="18" height="18" alt="Nieuwe berichten" title="Nieuwe berichten" /></td>
				<td class="gensmall">New messages</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" style="text-align: center;"><img src="img/forum_read.gif" width="18" height="18" alt="Geen nieuwe berichten" title="Geen nieuwe berichten" /></td>
				<td class="gensmall">None new messages</td>
                <td>&nbsp;&nbsp;</td>
                <td style="text-align: center;"><img src="img/forum_closet.gif" width="18" height="18" alt="Nieuwe berichten [ gesloten ]" title="Nieuwe berichten [ gesloten ]" /></td>
				<td class="gensmall">Topic [ closed ]</td>
			</tr>
			</table>
		</td>
		<td align="right">
        <?php 
		$res=mysql_query("select authlevel from beta_users where username='".$_SESSION['suser']."'");
		$row=mysql_fetch_assoc($res);
		if($row['authlevel'] > 0){
			$recht1 = "can";
		}else{
			$recht1 = "can't";
		}
		if($row['authlevel'] >= 0){
			if($_SESSION['suser'] == NULL){
				$recht2 = "can't";
			}else{
				$recht2 = "can";
			}
		}
		if($row['authlevel'] > 1){
			$recht3 = "can";
		}else{
			$recht3 = "can't";
		}
		if($row['authlevel'] > 1){
			$recht4 = "can";
		}else{
			$recht4 = "can't";
		}
		$recht = "<span class=\"gensmall\">You ";
		$recht .= "<strong>".$recht1."</strong> ";
		$recht .= "place new subjects on tis forum<br />";
		$recht .= "You <strong>".$recht2."</strong> ";
		$recht .= "answer on a subject on this forum<br />";
		$recht .= "You <strong>".$recht3."</strong> ";
		$recht .= "change subjects on this forum ";
		$recht .= "<br />";
		$recht .= "You <strong>".$recht4."</strong> ";
		$recht .= "remove messages from this forum<br /></span>";
		echo $recht;
		?>
        </td>
	</tr>
	</table>