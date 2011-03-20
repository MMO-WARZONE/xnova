<?php
require('login.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forum Asschensukar</title>
<!--<script type="text/javascript" src="js/login.js"></script>-->
<LINK HREF="css/basis.css" REL="stylesheet" TYPE="text/css">
<LINK HREF="css/stylesheet.css" REL="stylesheet" TYPE="text/css">
<script language="javascript" src="js/time.js"></script>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
//-->
</script>
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('img/button_topic_new2.gif')">
<?php
	function pretty_number($n, $floor = true) {
		if ($floor) {
			$n = floor($n);
		}
		return number_format($n, 0, ",", ".");
	}
?>
<?php
session_start();
?>
<table width="800" border="0.25" align="center" bgcolor="#333333" cellpadding="0" cellspacing="0" bordercolor="black" >
<!--  <tr>	
    <td id="logorow" align="center"><div id="logo-left"><div id="logo-right">
		<a href="./index.php"></a>
	</div></div></td>
  </tr>-->
  <tr>
  	<td width="800" height="99" align="center">
    <h1><strong>Server news</strong></h1>
    <br />
    <?php
    $res = mysql_query("SELECT config_name,config_value FROM beta_config WHERE config_name='OverviewNewsText'") or die(mysql_error());
    $row = mysql_fetch_assoc($res);
    echo $row['config_value'];
    ?>
    <br />
    </td>
  </tr>
  <tr>
    <td height="30" align="center" class="navrow">
    <?php
	if(!isset($_SESSION['suser'])) {
	?>
	<form action="login.php" method="post">
	Username: <input type="text" name="naam" size="15" class="post">&nbsp;
	Wachtwoord: <input type="password" name="wacht" size="15" class="post">&nbsp;
	<input type="checkbox" name="memory" value="1"> Onthouden (cookie)&nbsp;
	<input type="submit" name="login" value="log in" class="btnmain">
	</form>
	<?php
	} else {
	?>
	Je bent ingelogd als <b><?php $naam = $_SESSION['suser']; echo $naam; ?></b>,
	<a href="logout.php?user='<?php $naam = $_SESSION['suser']; echo $naam; ?>'">uitloggen</a><br />
	<?php
	}
	?>
    </td>
  </tr>
<!--  <tr>
   <td>
   <div align="right" id="time"></div>
   </td>
  </tr>-->
  <tr>
    <td height="204"><!-- InstanceBeginEditable name="Inhoud" -->
	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverzicht</a> &#187; <a href="./techassis.php">Technical Assistence</a></p>
			<p class="datetime">Alle tijden zijn GMT + 1 uur [ Zomertijd ]</p>
		</td>
	</tr>
	</table>
	<br />	<div id="pageheader">
	        		<h2><a class="titles" href="./techassis.php">Technical Assistence</a></h2>
    		</div>
 
	<br clear="all" />
 
<div id="pagecontent">
 
		<table width="100%" cellspacing="1">
		<tr>
							<td align="left" valign="middle"><a href="./newtopic.php?forum=Technical Assistence" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rollover','','img/button_topic_new2.gif',1)"><img src="img/button_topic_new.gif" alt="Nieuw Onderwerp" name="rollover" width="141" height="20" border="0" id="rollover" /></a><!--<a href="./newtopic.php"><img src="img/button_topic_new.gif" width="141" height="20" alt="Plaats een nieuw onderwerp" title="Plaats een nieuw onderwerp" /></a>--></td>
							<?php 
							$res=mysql_query("select username, authlevel from beta_users where username ='".$_SESSION['suser']."'") or die(mysql_error());
							$row=mysql_fetch_assoc($res);
							if($row['authlevel'] > 0)
							{
								echo "<td align=\"left\" valign=\"middle\"><a href=\"./newmede.php?forum=Technical Assistence\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover'		,'','img/button_topicmede_new2.gif',1)\"><img src=\"img/button_topicmede_new.gif\" alt=\"Nieuw Onderwerp\" name=\"rollover\" width=\"141\" height=\"20\" border=\"0\" id=\"rollover\" /></a></td>";
							}
							?>
								<td class="nav" valign="middle" nowrap="nowrap">&nbsp;Pagina <strong>1</strong> van <strong>1</strong><br /></td>
					<td class="gensmall" nowrap="nowrap">&nbsp;[ 
                    <?php 
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = 'Technical Assistence'");
					$row=mysql_fetch_assoc($res);
					echo $row['count(onderwerp)'];
					?>
                    onderwerpen ]&nbsp;</td>
								<td align="right" width="100%">
					<br />				</td>
					</tr>
		</table>
					<table class="tablebg" width="100%" cellspacing="0" id='mytable'>
		<caption><div class="cap-left"><div class="cap-right">&nbsp;Technical Assistence&nbsp;</div></div></caption>		<tr>
							<th colspan="2">&nbsp;Onderwerpen&nbsp;</th>
						<th>&nbsp;Auteur&nbsp;</th>
			<th>&nbsp;Reacties&nbsp;</th>
			<th>&nbsp;Bekeken&nbsp;</th>
			<th>&nbsp;Laatste bericht&nbsp;</th>
		</tr>
 
						<tr>
					<td class="row3" colspan="6"><b class="gensmall">Mededelingen</b></td>
				</tr>
			
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
			</tr>
            <?php 
		$res=mysql_query("select id,onderwerp,auteur,forum,type,topic,hits from beta_board_subject where topic='mededeling' and forum = 'Technical Assistence' order by id desc") or die(mysql_error());
		$res3=mysql_query("select time from beta_board_reactie, subject where reactie.topic='mededeling' and reactie.onderwerp = subject.onderwerp order by reactie.id desc") or die(mysql_error());
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res) and $row3=mysql_fetch_assoc($res3))
		{
		$res2=mysql_query("select authlevel from beta_users, subject where beta_users.username = '".$row['auteur']."'") or die(mysql_error());
		$row2=mysql_fetch_assoc($res2);
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
		$res4=mysql_query("select count(reactie) from beta_board_reactie where topic='mededeling' and onderwerp = '".$row['onderwerp']."' and forum = '".$row['forum']."'") or die(mysql_error());
		$row4=mysql_fetch_assoc($res4);
		$html = "<tr>";
		$html .= "<td class=\"row1\" width=\"25\" align=\"center\"></td>";
		$html .= "<td class=\"row1\">";
		if($row['type'] == 'pol'){
			$html .= "<b>Poll: </b>";
		}
		else{
			$html .= "";
		}
		$html .= "<a class=\"topictitle\" href=\"topicmede.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."\">".$row['onderwerp']."</a></td>";
		$html .= "<td class=\"row2\" width=\"130\" align=\"center\"><p class=\"topicauthor\"><a href=\"./index.php\" style=\"color: ".$color."\" class=\"username-coloured\">".$row['auteur']."";
        $html .= "<td class=\"row1\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row4['count(reactie)']."</p></td>";
		$html .= "<td class=\"row2\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row['hits']."</p></td>";
		$html .= "<td class=\"row1\" width=\"140\" align=\"center\">";
		$html .= "<p class=\"topicdetails\" style=\"white-space: nowrap;\">on</p>";
		$html .= "<p class=\"topicdetails\">".$row3['time']."</p>";
		$html .= "</td>";
		$html .= "</tr>";
			echo $html;
			$i++;
		}
		}
		?>

 
					  <tr>
					<td class="row3" colspan="6"><b class="gensmall">Onderwerpen</b></td>
				</tr>

		<?php 
				$res=mysql_query("select id,onderwerp,auteur,forum,type,topic,hits from beta_board_subject where topic='onderwerp' and forum = 'Technical Assistence' order by id desc") or die(mysql_error());
		$res3=mysql_query("select time from beta_board_reactie, subject where reactie.topic='onderwerp' and reactie.onderwerp = subject.onderwerp order by reactie.id desc") or die(mysql_error());
		$i=1;
		if(mysql_num_rows($res) > 0) {
		while ($row=mysql_fetch_assoc($res) and $row3=mysql_fetch_assoc($res3))
		{
		$res2=mysql_query("select authlevel from beta_users, subject where beta_users.username = '".$row['auteur']."'") or die(mysql_error());
		$row2=mysql_fetch_assoc($res2);
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
		$res4=mysql_query("select count(reactie) from beta_board_reactie where topic='onderwerp' and onderwerp = '".$row['onderwerp']."' and forum = '".$row['forum']."'") or die(mysql_error());
		$row4=mysql_fetch_assoc($res4);
		$html = "<tr>";
		$html .= "<td class=\"row1\" width=\"25\" align=\"center\"></td>";
		$html .= "<td class=\"row1\">";
		if($row['type'] == 'pol'){
			$html .= "<b>Poll: </b>";
		}
		else{
			$html .= "";
		}
		$html .= "<a class=\"topictitle\" href=\"topic.php?onderwerp=".$row['onderwerp']."&forum=".$row['forum']."\" onclick>".$row['onderwerp']."</a></td>";
		$html .= "<td class=\"row2\" width=\"130\" align=\"center\"><p class=\"topicauthor\"><a href=\"./index.php\" style=\"color: ".$color."\" class=\"username-coloured\">".$row['auteur']."";
        $html .= "<td class=\"row1\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row4['count(reactie)']."</p></td>";
		$html .= "<td class=\"row2\" width=\"50\" align=\"center\"><p class=\"topicdetails\">".$row['hits']."</p></td>";
		$html .= "<td class=\"row1\" width=\"140\" align=\"center\">";
		$html .= "<p class=\"topicdetails\" style=\"white-space: nowrap;\">on</p>";
		$html .= "<p class=\"topicdetails\">".$row3['time']."</p>";
		$html .= "</td>";
		$html .= "</tr>";
			echo $html;
			$i++;
		}
		}
		?>
		<tr align="center">
							<td class="cat" colspan="7">
								<form method="post" action="./viewforum.php?f=2&amp;start=0"><span class="gensmall">Geef de vorige onderwerpen weer:</span>&nbsp;<select name="st" id="st"><option value="0" selected="selected">Alle onderwerpen</option><option value="1">1 dag</option><option value="7">7 dagen</option><option value="14">2 weken</option><option value="30">1 maand</option><option value="90">3 maanden</option><option value="180">6 maanden</option><option value="365">1 jaar</option></select>&nbsp;<span class="gensmall">Sorteer op</span> <select name="sk" id="sk"><option value="a">Auteur</option><option value="t" selected="selected">Berichtdatum</option><option value="r">Reacties</option><option value="s">Onderwerp</option><option value="v">Bekeken</option></select> <select name="sd" id="sd"><option value="a">Oplopend</option><option value="d" selected="selected">Aflopend</option></select>&nbsp;<input class="btnlite" type="submit" name="sort" value="Ga" /></form>
				</td>
		</tr>
        </table>

        
        				<table width="100%" cellspacing="1">
		<tr>
							<td align="left" valign="middle"><a href="./newtopic.php?forum=Technical Assistence" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('rollover2','','img/button_topic_new2.gif',1)"><img src="img/button_topic_new.gif" alt="Nieuw Onderwerp" name="rollover2" width="141" height="20" border="0" id="rollover2" /></a></td>
                            <?php 
							$res=mysql_query("select username, authlevel from beta_users where username ='".$_SESSION['suser']."'") or die(mysql_error());
							$row=mysql_fetch_assoc($res);
							if($row['authlevel'] > 0)
							{
								echo "<td align=\"left\" valign=\"middle\"><a href=\"./newmede.php?forum=Technical Assistence\" onmouseout=\"MM_swapImgRestore()\" onmouseover=\"MM_swapImage('rollover'		,'','img/button_topicmede_new2.gif',1)\"><img src=\"img/button_topicmede_new.gif\" alt=\"Nieuw Onderwerp\" name=\"rollover\" width=\"141\" height=\"20\" border=\"0\" id=\"rollover\" /></a></td>";
							}
							?>
							<td class="nav" valign="middle" nowrap="nowrap">&nbsp;Pagina <strong>1</strong> van <strong>1</strong></td>
				<td class="gensmall" nowrap="nowrap">&nbsp;[ 
                    <?php 
					$res=mysql_query("select count(onderwerp) from beta_board_subject where forum = 'Technical Assistence'");
					$row=mysql_fetch_assoc($res);
					echo $row['count(onderwerp)'];
					?>
                    onderwerpen ]&nbsp;</td>
				<td class="gensmall" width="100%" align="right" nowrap="nowrap"></td>
					</tr>
		</table>
	
	<br clear="all" />
 
</div>
 
<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverzicht</a> &#187; <a href="./techassis.php">Technical Assistence</a></p>
			<p class="datetime">Alle tijden zijn GMT + 1 uur [ Zomertijd ]</p>
		</td>
	</tr>
	</table>	<br clear="all" />
 
	<table class="tablebg" width="100%" cellspacing="0">
	<tr>
		<td class="cat"><h4>Wie is er online</h4></td>
	</tr>
	<tr>
		<td class="row1"><p class="gensmall">Gebruikers op dit forum: Geen geregistreerde gebruikers en 1 gast</p></td>
	</tr>
	</table>
	<br clear="all" />
 
	<table width="100%" cellspacing="0">
	<tr>
		<td align="left" valign="top">
			<table cellspacing="3" cellpadding="0" border="0" class="legend legend-viewforum">
			<tr>
				<td width="20" style="text-align: center;"><img src="./styles/acidtech/imageset/topic_unread.gif" width="18" height="18" alt="Nieuwe berichten" title="Nieuwe berichten" /></td>
				<td class="gensmall">Nieuwe berichten</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" style="text-align: center;"><img src="./styles/acidtech/imageset/topic_read.gif" width="18" height="18" alt="Geen nieuwe berichten" title="Geen nieuwe berichten" /></td>
				<td class="gensmall">Geen nieuwe berichten</td>
				<td>&nbsp;&nbsp;</td>
				<td width="20" style="text-align: center;"><img src="./styles/acidtech/imageset/announce_read.gif" width="18" height="18" alt="Mededeling" title="Mededeling" /></td>
				<td class="gensmall">Mededeling</td>
			</tr>
			<tr>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/topic_unread.gif" width="18" height="18" alt="Nieuwe berichten [ populair ]" title="Nieuwe berichten [ populair ]" /></td>
				<td class="gensmall">Nieuwe berichten [ populair ]</td>
				<td>&nbsp;&nbsp;</td>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/topic_read.gif" width="18" height="18" alt="Geen nieuwe berichten [ populair ]" title="Geen nieuwe berichten [ populair ]" /></td>
				<td class="gensmall">Geen nieuwe berichten [ populair ]</td>
				<td>&nbsp;&nbsp;</td>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/sticky_read.gif" width="18" height="18" alt="Sticky" title="Sticky" /></td>
				<td class="gensmall">Sticky</td>			
			</tr>
			<tr>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/topic_unread_locked.gif" width="18" height="18" alt="Nieuwe berichten [ gesloten ]" title="Nieuwe berichten [ gesloten ]" /></td>
				<td class="gensmall">Nieuwe berichten [ gesloten ]</td>
				<td>&nbsp;&nbsp;</td>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/topic_read_locked.gif" width="18" height="18" alt="Geen nieuwe berichten [ gesloten ]" title="Geen nieuwe berichten [ gesloten ]" /></td>
				<td class="gensmall">Geen nieuwe berichten [ gesloten ]</td>
				<td>&nbsp;&nbsp;</td>
				<td style="text-align: center;"><img src="./styles/acidtech/imageset/topic_moved.gif" width="18" height="18" alt="Verplaatst onderwerp" title="Verplaatst onderwerp" /></td>
				<td class="gensmall">Verplaatst onderwerp</td>
			</tr>
			</table>
		</td>
		<td align="right"><span class="gensmall">Je <strong>mag geen</strong> nieuwe onderwerpen in dit forum plaatsen<br />Je <strong>mag niet</strong> antwoorden op een onderwerp in dit forum<br />Je <strong>mag</strong> je berichten in dit forum <strong>niet</strong> wijzigen<br />Je <strong>mag</strong> je berichten <strong>niet</strong> uit dit forum verwijderen<br /></span></td>
	</tr>
	</table>

	<!-- InstanceEndEditable --></td>
  </tr>
  <tr>
    <td align="center">Designed by Warsaalk for <a href="http://www.asschensukar.nl">www.asschensukar.nl</a></td>
  </tr>
  <tr>
  <td>&nbsp;
  </td>
  </tr>
</table>
</body>
<!-- InstanceEnd --></html>
