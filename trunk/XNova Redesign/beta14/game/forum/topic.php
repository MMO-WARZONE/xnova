<?php
include('login.php');
include('session.php');
?>

    <?php 
	$forum = "{$_GET['forum']}";
	$onderwerp = "{$_GET['onderwerp']}" ;
	mysql_query("update beta_board_subject set hits = hits + 1 where onderwerp='".$onderwerp."' and forum='".$forum."'");	
	?>
    <?php
	$ant=mysql_query("select max(id) from beta_users") or die(mysql_error());
	$aantallen=mysql_fetch_assoc($ant);
	$aantal=$aantallen['max(id)'];
	$forum = "{$_GET['forum']}";
	$onderwerp = "{$_GET['onderwerp']}" ;
	$res=mysql_query("select id from beta_users where username='".$_SESSION['suser']."'") or die(mysql_error());
	$row=mysql_fetch_assoc($res);
	$res2=mysql_query("select id from beta_board_subject where onderwerp='".$onderwerp."' and forum='".$forum."'") or die(mysql_error());
	$row2=mysql_fetch_assoc($res2);
	$res3=mysql_query("select unread from beta_board_subject where id=".$row2['id']) or die(mysql_error());
	$row3=mysql_fetch_array($res3, MYSQL_ASSOC);
	$change=unserialize($row3['unread']);
	$id=$row['id'];
	for($i=1;$i<=$aantal;$i++){
		if($i==$id){
			$change[$i]=1;
		}
	}
	mysql_query("update beta_board_subject set unread='".serialize($change)."' where id=".$row2['id']) or die(mysql_error());
	?>
	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
             <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a></p>
			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>
	<br />
<div id="pageheader">
	<h2><a class="titles" href="#" onClick="loadpage('./topic.php<?php $onderwerp = "{$_GET['onderwerp']}"; $forum = "{$_GET['forum']}"; echo "?onderwerp=".$onderwerp."&forum=".$forum; ?>','XNova Forum','bodyid');"><?php $onderwerp = "{$_GET['onderwerp']}"; echo $onderwerp; ?></a></h2>
 
</div>
 
<br clear="all" /><br />
 
<div id="pagecontent">
 
	<table width="100%" cellspacing="1">
	<tr>
		<?php 
		$res=mysql_query("select status from beta_board_subject where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."'") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		if($row['status'] == 'open'){
		$antwoord = "<td align=\"left\" valign=\"middle\" nowrap=\"nowrap\">";
		$antwoord .="<a href=\"#\" onClick=\"loadpage('./posting.php?onderwerp={$_GET['onderwerp']}&forum={$_GET['forum']}','XNova Forum','bodyid');\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover','','img/button_topic_reply2.gif',1)\">";
		$antwoord .= "<img src=\"img/button_topic_reply.gif\" alt=\"Antwoorden\" name=\"rollover\" width=\"94\" height=\"20\" border=\"0\" id=\"rollover\" />";
		$antwoord .= "</a>";
		$antwoord .= "</td>";
		}else{
		$antwoord = "<td align=\"left\" valign=\"middle\" nowrap=\"nowrap\">";
		$antwoord .= "<img src=\"img/button_topic_locked.gif\" alt=\"Gesloten\" width=\"94\" height=\"20\" border=\"0\"/>";
		$antwoord .= "</a>";
		$antwoord .= "</td>";	
		}
		echo $antwoord;
		?>
					<td class="nav" valign="middle" nowrap="nowrap">&nbsp;Page <strong>1</strong> of <strong>1</strong><br /></td>
			<td class="gensmall" nowrap="nowrap">&nbsp;[ 
            <?php 
			$forum = "{$_GET['forum']}";
			$onderwerp = "{$_GET['onderwerp']}" ;
			$res=mysql_query("SELECT count(reactie) from beta_board_reactie where topic='onderwerp' and onderwerp='".$onderwerp."' and forum ='".$forum."'");
			$row=mysql_fetch_assoc($res);
			echo $row['count(reactie)'];
			echo '&nbsp;';
			if($row['count(reactie)'] == 1 ){
				echo 'message ';
			}
			else {
				echo 'messages ';
			}
			?>
			]&nbsp;</td>
			<td class="gensmall" width="100%" align="right" nowrap="nowrap"></td>
		</tr>
	</table>
 
			<!--<table width="100%" cellspacing="0">
			<tr>
				<td class="nav" nowrap="nowrap">
				<a href="./viewtopic.php?f=4&amp;t=89&amp;start=0&amp;st=0&amp;sk=t&amp;sd=a&amp;view=print" title="Afdrukweergave">Afdrukweergave</a>				</td>
				<td class="nav" align="right" nowrap="nowrap"><a href="./viewtopic.php?f=4&amp;t=89&amp;view=previous">Vorig onderwerp</a> | <a href="./viewtopic.php?f=4&amp;t=89&amp;view=next">Volgend onderwerp</a>&nbsp;</td>
			</tr>
			</table>-->
            <?php
/*
	<tr class="row1">
			<td align="center" valign="top" class="row">
				<a name="p557"></a>
				<div class="postauthor" style="color: #AA0000">Asschen</div>
				<div class="posterrank">Site Admin</div>
				<div class="postdetails">
					<br /><b>Geregistreerd op:</b> zo apr 27, 2008 4:33 pm<br /><b>Berichten:</b> 260				</div>
			</td>
			<td width="100%" height="25" class="row" valign="top">
				<div style="float: right;"></div>				<div class="postsubject"><a href="./viewtopic.php?p=557#p557"><img src="./styles/acidtech/imageset/icon_topic_latest.gif" width="13" height="9" alt="Bericht" title="Bericht" /></a>&nbsp;BELANGRIJK!!</div>
 
					
						<div class="postbody">Ik heb eindelijk een oplossing gevonden om het spel weer online te krijgen.<br /><br />De nieuwe versie van het spel is nu gedeeltelijk online gezet, maar met de oude gegevens van de oude server<br /><br />Het spel is nu te vinden op: <!-- w --<a class="postlink" href="http://www.asschensukar.nl">www.asschensukar.nl</a><!-- w --<br /><br />Je kan daar gewoon inloggen met je oude gegevens!<br /><br />Tot op de nieuwe server!<br /><br /><br />Let op: Op de nieuwe server moet nog wel een hoop vertaald worden.<br />Dit zal in de komende weken allemaal nog gebeuren.</div>
 
					<br clear="all" /><br />			</td>
		</tr>
 
		<tr class="row1">
			<td class="postbottom" align="center">za dec 06, 2008 4:20 pm</td>
			<td class="postbottom postbuttons" valign="middle">
									<div style="float: right">
										</div>
				<a href="./memberlist.php?mode=viewprofile&amp;u=2"><img src="./styles/acidtech/imageset/nl/icon_user_profile.gif" width="49" height="13" alt="Profiel" title="Profiel" /></a> 			</td>
    			</tr>-->
                
		
		$ond =1;
		$res3=mysql_query("select count(id),id,onderwerp from beta_board_reactie order by id") or die(mysql_error());
		$row3=mysql_fetch_assoc($res3);
		$aantal = $row3['count(id)'];
		$i2=1;
		while ($row3=mysql_fetch_assoc($res3))
		{
		$allond = $row3['onderwerp'];
			if( $row3['onderwerp'] == "{$_GET['onderwerp']}")
			{
				$ond = "{$_GET['".$allond."']}";
			}
		$i2++;
		}*/
		
		$forum = "{$_GET['forum']}";
		$onderwerp = "{$_GET['onderwerp']}" ;
		$res=mysql_query("select id,onderwerp,auteur,time,reactie,topic from beta_board_reactie where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."' order by id") or die(mysql_error());
		$res3=mysql_query("select auteur,type from beta_board_subject where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."' order by id") or die(mysql_error());
		$res4=mysql_query("select auteur,time,keuze1,keuze2,keuze3,keuze4,keuze5 from beta_board_pol where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."' order by id_pol") or die(mysql_error());
		$res5=mysql_query("select onderwerp,auteur,forum,topic,keuze1,keuze2,keuze3,keuze4,keuze5 from beta_board_polstem where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."' order by id") or die(mysql_error());
		$res6=mysql_query("select id_pol,auteur from beta_board_pol where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."' order by id_pol") or die(mysql_error());
		$res7=mysql_query("select authlevel, username from beta_users, beta_board_reactie where beta_users.username = beta_board_reactie.auteur and onderwerp = '".$onderwerp."' and forum ='".$forum."'") or die(mysql_error());
		$row7=mysql_fetch_assoc($res7);
		if($row7['authlevel'] != 0) {
			if($row7['authlevel'] != 1) {
				if($row7['authlevel'] != 2) {
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
			$color = "light blue";
		}
		$row3=mysql_fetch_assoc($res3);
		$row4=mysql_fetch_assoc($res4);
		$row5=mysql_fetch_assoc($res5);
		$row6=mysql_fetch_assoc($res6);
		if($row3['type'] == 'pol'){
		$totaal = $row5['keuze1'] + $row5['keuze2'] + $row5['keuze3'] + $row5['keuze4'] + $row5['keuze5'];
		$procent1 = ($row5['keuze1'] / $totaal)*100;
		$procent2 = ($row5['keuze2'] / $totaal)*100;
		$procent3 = ($row5['keuze3'] / $totaal)*100;
		$procent4 = ($row5['keuze4'] / $totaal)*100;
		$procent5 = ($row5['keuze5'] / $totaal)*100;
		$width1 = (round($procent1,2) / 100)*200;
		$width2 = (round($procent2,2) / 100)*200;
		$width3 = (round($procent3,2) / 100)*200;
		$width4 = (round($procent4,2) / 100)*200;
		$width5 = (round($procent5,2) / 100)*200;
		$pol = "<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">";
		$pol .= "<caption>";
		$pol .= "<div class=\"cap-left\"><div class=\"cap-right\">&nbsp; ".$onderwerp." &nbsp;";
		$pol .= "<tr class=\"row1\">";
		/*$pol .= "<td align=\"center\" valign=\"top\" class=\"row\" width=\"15%\">";
		$pol .= "<div class=\"postauthor\" style=\"color: ".$color."\">Poll: ".$row4['auteur']."</div>";
		$pol .= "<div class=\"posterrank\">".$status."<br>".$row4['time']."</div>";
		$pol .= "<div class=\"postdetails\">";
		$pol .= "</td>";*/
	    $pol .= "<td width=\"100%\" height=\"25\" class=\"row\" valign=\"top\" align=\"center\" colspan=\"2\">";
		$pol .= "<div style=\"float: right;\"></div><br>";
		$pol .= "<div class=\"postbody\" align=\"center\"><small><b>Total of votes:&nbsp;".$totaal."</b></small></div>";
		$pol .= "<table width=\"50%\" heigth=\"50%\" align=\"center\">";
		$pol .= "<tr>";
		$pol .= "<td>";
		$pol .= "<div class=\"postbody\" align=\"right\"><b>1.</b>&nbsp;&nbsp;&nbsp;&nbsp;".$row4['keuze1']."&nbsp;&nbsp;";
		$pol .= "</td><td align=\"left\">";
		$pol .= "<img src=\"img/poll_left.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "<img src=\"img/poll_center.gif\" width=\"".$width1."\" height=\"12\" alt=\"".round($procent1,2)."%\" title=\"".round($procent1,2)."%\"/>";
		$pol .= "<img src=\"img/poll_right.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "</td><td>";
		$pol .= "&nbsp;&nbsp;<b>".round($procent1,2)."%</b>&nbsp;[".$row5['keuze1']."]</div>";
		$pol .= "</td>";
		$pol .= "</tr><tr>";
		$pol .= "<td>";
		$pol .= "<div class=\"postbody\" align=\"right\"><b>2.</b>&nbsp;&nbsp;&nbsp;&nbsp;".$row4['keuze2']."&nbsp&nbsp;";
		$pol .= "</td><td align=\"left\">";
		$pol .= "<img src=\"img/poll_left.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "<img src=\"img/poll_center.gif\" width=\"".$width2."\" height=\"12\" alt=\"".round($procent2,2)."%\" title=\"".round($procent2,2)."%\"/>";
		$pol .= "<img src=\"img/poll_right.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "</td><td>";
		$pol .= "&nbsp;&nbsp;<b>".round($procent2,2)."%</b>&nbsp;[".$row5['keuze2']."]</div>";
		$pol .= "</td>";
		$pol .= "</tr>";
		if($row4['keuze3'] !== ''){
		$pol .= "<tr>";
		$pol .= "<td align=\"right\">";
		$pol .= "<div class=\"postbody\" align=\"right\"><b>3.</b>&nbsp;&nbsp;&nbsp;&nbsp;".$row4['keuze3']."&nbsp;&nbsp;";
		$pol .= "</td><td align=\"left\">";
		$pol .= "<img src=\"img/poll_left.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "<img src=\"img/poll_center.gif\" width=\"".$width3."\" height=\"12\" alt=\"".round($procent3,2)."%\" title=\"".round($procent3,2)."%\"/>";
		$pol .= "<img src=\"img/poll_right.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "</td><td>";
		$pol .= "&nbsp;&nbsp;<b>".round($procent3,2)."%</b>&nbsp;[".$row5['keuze3']."]</div>";
		$pol .= "</td>";
		$pol .= "</tr>";}
		if($row4['keuze4'] !== ''){
		$pol .= "<tr>";
		$pol .= "<td>";
		$pol .= "<div class=\"postbody\" align=\"right\"><b>4.</b>&nbsp;&nbsp;&nbsp;&nbsp;".$row4['keuze4']."&nbsp;&nbsp;";
		$pol .= "</td><td align=\"left\">";
		$pol .= "<img src=\"img/poll_left.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "<img src=\"img/poll_center.gif\" width=\"".$width4."\" height=\"12\" alt=\"".round($procent4,2)."%\" title=\"".round($procent4,2)."%\"/>";
		$pol .= "<img src=\"img/poll_right.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "</td><td>";
		$pol .= "&nbsp;&nbsp;<b>".round($procent4,2)."%</b>&nbsp;[".$row5['keuze4']."]</div>";
		$pol .= "</td>";
		$pol .= "</tr>";}
		if($row4['keuze5'] !== ''){
		$pol .= "<tr>";
		$pol .= "<td>";
		$pol .= "<div class=\"postbody\" align=\"right\"><b>5.</b>&nbsp;&nbsp;&nbsp;&nbsp;".$row4['keuze5']."&nbsp;&nbsp;";
		$pol .= "</td><td align=\"left\">";
		$pol .= "<img src=\"img/poll_left.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "<img src=\"img/poll_center.gif\" width=\"".$width5."\" height=\"12\" alt=\"".round($procent5,2)."%\" title=\"".round($procent5,2)."%\"/>";
		$pol .= "<img src=\"img/poll_right.gif\" width=\"4\" height=\"12\"/>";
		$pol .= "</td><td>";
		$pol .= "&nbsp;&nbsp;<b>".round($procent5,2)."%</b>&nbsp;[".$row5['keuze5']."]</div>";
		$pol .= "</td>";
		$pol .= "</tr>";}
		$pol .= "</table>";
		if(!isset($_SESSION['suser'])) {
    	$pol .= "<strong><h1>You must be logged in for this action!</h1></strong>";
		} else {
		if($_COOKIE[$row6['id_pol']] == $_SESSION['suser'])
		{
		$pol.= "Sorry, you've allready voted this month!<br>";
		}
		else
		{
		$pol .= "<p align=\"center\"><a href=\"#\" onClick=\"loadpage('updatepol.php?onderwerp=".$row5['onderwerp']."&auteur=".$row5['auteur']."&forum=".$row5['forum']."&topic=".$row5['topic']."&id_pol=".$row6['id_pol']."&keuze=keuze1','XNova Forum','bodyid');\"><img src=\"img/stem1.gif\" width=\"56\" height=\"20\" alt=\"Stem 1\" /></a>&nbsp;";
		$pol .= "<a href=\"#\" onClick=\"loadpage('updatepol.php?onderwerp=".$row5['onderwerp']."&auteur=".$row5['auteur']."&forum=".$row5['forum']."&topic=".$row5['topic']."&id_pol=".$row6['id_pol']."&keuze=keuze2','XNova Forum','bodyid');\"><img src=\"img/stem2.gif\" width=\"56\" height=\"20\" alt=\"Stem 1\" /></a>&nbsp;";
		if($row4['keuze3'] !== ''){$pol .= "<a href=\"#\" onClick=\"loadpage('updatepol.php?onderwerp=".$row5['onderwerp']."&auteur=".$row5['auteur']."&forum=".$row5['forum']."&topic=".$row5['topic']."&id_pol=".$row6['id_pol']."&keuze=keuze3','XNova Forum','bodyid');\"><img src=\"img/stem3.gif\" width=\"56\" height=\"20\" alt=\"Stem 1\" /></a>&nbsp;";}
		if($row4['keuze4'] !== ''){$pol .= "<a href=\"#\" onClick=\"loadpage('updatepol.php?onderwerp=".$row5['onderwerp']."&auteur=".$row5['auteur']."&forum=".$row5['forum']."&topic=".$row5['topic']."&id_pol=".$row6['id_pol']."&keuze=keuze4','XNova Forum','bodyid');\"><img src=\"img/stem4.gif\" width=\"56\" height=\"20\" alt=\"Stem 1\" /></a>&nbsp;";}
		if($row4['keuze5'] !== ''){$pol .= "<a href=\"#\" onClick=\"loadpage('updatepol.php?onderwerp=".$row5['onderwerp']."&auteur=".$row5['auteur']."&forum=".$row5['forum']."&topic=".$row5['topic']."&id_pol=".$row6['id_pol']."&keuze=keuze5','XNova Forum','bodyid');\"><img src=\"img/stem5.gif\" width=\"56\" height=\"20\" alt=\"Stem 1\" /></a>";}
		}
				}
 		$pol .= "</p><br clear=\"all\" /><br />			</td>";
		$pol .= "</tr>";
		$pol .= "<tr class=\"row1\">";
		$pol .= "<td class=\"postbottom\" align=\"center\" width=\"15%\">".$row4['time']."</td>";
		$pol .= "<td class=\"postbottom postbuttons\" valign=\"middle\">";
		$pol .= "<div style=\"float: right\">";
		$pol .= "</div>";
		$pol .= "<div class=\"postauthor\" style=\"color: ".$color."\">&nbsp;&nbsp;Poll: ".$row4['auteur']."</div></td>";
     	$pol .= "</tr>";
		$pol .= "</table>";
		$pol .= "<br>";
		echo $pol;
		}
		$table = "<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\">";
		$table .= "<caption>";
		$table .= "<div class=\"cap-left\"><div class=\"cap-right\">&nbsp; ".$onderwerp." &nbsp;";
        $table .= "</div></div></caption>	<tr>";
		$table .= "<th>Author</th>";
		$table .= "<th width=\"100%\">Message</th>";
		$table .= "</tr>";
		echo $table;
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res))
		{
		$res2=mysql_query("select authlevel from beta_users, beta_board_reactie where beta_users.username = '".$row['auteur']."'") or die(mysql_error());
		$row2=mysql_fetch_assoc($res2);
    	if($row2['authlevel'] != 0) {
			if($row2['authlevel'] != 1) {
				if($row2['authlevel'] != 2) {
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
			$color = "light blue";
		}
        $html = "<tr class=\"row1\">";
		$html .= "<td align=\"center\" valign=\"top\" class=\"row\">";
		$res8=mysql_query("select authlevel from beta_users where username = '".$_SESSION['suser']."'") or die(mysql_error());
		$row8=mysql_fetch_assoc($res8);
		if($row8['authlevel'] > 1){
			$html .= "<a href=\"#\" onclick=\"loadpage('removereactie.php?onderwerp=".$row['onderwerp']."&forum=".$forum."&reactie=".$row['reactie']."&topic=onderwerp','XNova Forum','bodyid');\"><img src=\"img/r.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
		}else{
			$html .= "";
		}
		$html .= "&nbsp;";
		if($row8['authlevel'] > 1){
			$html .= "<a href=\"#\" onclick=\"loadpage('wijzig.php?onderwerp=".$row['onderwerp']."&forum=".$forum."&reactie=".$row['reactie']."&topic=onderwerp&id=".$row['id']."&auteur=".$row['auteur']."','XNova Forum','bodyid');\"><img src=\"img/wijzig.png\" width=\"16\" height=\"16\" alt=\"Remove\" /></a>";
		}else{
			$html .= "";
		}
		$html .= "<div class=\"postauthor\" style=\"color: ".$color."\">".$row['auteur']."</div>";
		$html .= "<div class=\"posterrank\">".$status."</div>";
		$html .= "<div class=\"postdetails\">";
		$html .= "</td>";
		$html .= "<td width=\"100%\" height=\"25\" class=\"row\" valign=\"top\">";
		$html .= "<div style=\"float: right;\"></div>";
		$html .= "<div class=\"postsubject\"><a href=\"./viewtopic.php?p=557p557\">";
		$html .= "<img src=\"img/icon_topic_latest.gif\" width=\"13\" height=\"9\" alt=\"Bericht\" title=\"Bericht\" /></a>";
		$html .= "&nbsp;".$row['onderwerp']."</div>";
		$html .= "<div class=\"postbody\">".$row['reactie']."</div>";
 		$html .= "<br clear=\"all\" /><br />			</td>";
		$html .= "</tr>";
 		$html .= "<tr class=\"row1\">";
		$html .= "<td class=\"postbottom\" align=\"center\">".$row['time']."</td>";
		$html .= "<td class=\"postbottom postbuttons\" valign=\"middle\">";
		$html .= "<div style=\"float: right\">";
		$html .= "</div>";
		$html .= "<a href=\"./memberlist.php?mode=viewprofile&amp;u=2\">";
		$html .= "<img src=\"img/icon_user_profile.gif\" width=\"49\" height=\"13\" alt=\"Profiel\" title=\"Profiel\" /></a>";
		$html .= "</td>";
     	$html .= "</tr>";
                
			echo $html;
			$i++;
		}
		}
		?>
            <tr>
  <td class="spacer" colspan="2" height="1"><img src="./styles/acidtech/theme/images/spacer.gif" alt="" width="1" height="1" /></td>
  </tr>
<tr align="center">
							    <td class="cat" colspan="2">
                        <?php 
						$p = "{$_GET['p']}";
						$forum = "{$_GET['forum']}";
						echo "<a href=\"#\" onclick=\"loadpage('./topic.php?forum=".$forum."&onderwerp=".$onderwerp."','XNova Forum','bodyid');\">Go to top</a>";
						?>
					    </td>
	</tr>
	</table>
	
	<table width="100%" cellspacing="1">
	<tr>
		<?php 
		$res=mysql_query("select status from beta_board_subject where topic='onderwerp' and onderwerp = '".$onderwerp."' and forum ='".$forum."'") or die(mysql_error());
		$row=mysql_fetch_assoc($res);
		if($row['status'] == 'open'){
		$antwoord = "<td align=\"left\" valign=\"middle\" nowrap=\"nowrap\">";
		$antwoord .="<a href=\"#\" onClick=\"loadpage('./posting.php?onderwerp={$_GET['onderwerp']}&forum={$_GET['forum']}','XNova Forum','bodyid');\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover2','','img/button_topic_reply2.gif',1)\">";
		$antwoord .= "<img src=\"img/button_topic_reply.gif\" alt=\"Antwoorden\" name=\"rollover2\" width=\"94\" height=\"20\" border=\"0\" id=\"rollover2\" />";
		$antwoord .= "</a>";
		$antwoord .= "</td>";
		}else{
		$antwoord = "<td align=\"left\" valign=\"middle\" nowrap=\"nowrap\">";
		$antwoord .= "<img src=\"img/button_topic_locked.gif\" alt=\"Gesloten\" width=\"94\" height=\"20\" border=\"0\"/>";
		$antwoord .= "</a>";
		$antwoord .= "</td>";	
		}
		echo $antwoord;
		?>
					<td class="nav" valign="middle" nowrap="nowrap">&nbsp;Page <strong>1</strong> of <strong>1</strong><br /></td>
					<td class="gensmall" nowrap="nowrap">&nbsp;[ 
            <?php 
			$forum = "{$_GET['forum']}";
			$onderwerp = "{$_GET['onderwerp']}" ;
			$res=mysql_query("SELECT count(reactie) from beta_board_reactie where topic='onderwerp' and onderwerp='".$onderwerp."' and forum ='".$forum."'");
			$row=mysql_fetch_assoc($res);
			echo $row['count(reactie)'];
			echo '&nbsp;';
			if($row['count(reactie)'] == 1 ){
				echo 'message ';
			}
			else {
				echo 'messages ';
			}
			?>
			]&nbsp;</td>
			<td class="gensmall" width="100%" align="right" nowrap="nowrap"></td>
		</tr>
	</table>
 
</div>
 
<div id="pagefooter"></div>
 
<br clear="all" />
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
             <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a></p>			<p class="datetime">All times are GMT</p>
		</td>
	</tr>
	</table>	<br clear="all" />
 
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
 
<br clear="all" />
 
<table width="100%" cellspacing="1">
<tr>
	<td width="40%" valign="top" nowrap="nowrap" align="left"></td>
	<td align="right" valign="top" nowrap="nowrap">
         <?php 
		$res=mysql_query("select authlevel from beta_users where username='".$_SESSION['suser']."'");
		$row=mysql_fetch_assoc($res);
		if($row['authlevel'] > 0){
			$recht1 = "can";
		}else{
			$recht1 = "can't";
		}		if($row['authlevel'] >= 0){
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