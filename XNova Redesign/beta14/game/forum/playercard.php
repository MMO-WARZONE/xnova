<?php
include('login.php');

	function pretty_number($n, $floor = true) {
		if ($floor) {
			$n = floor($n);
		}
		return number_format($n, 0, ",", ".");
	}
?>

    	<table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverview</a> &#187;
             <?php
			$forum = "{$_GET['forum']}";
			?>			
			<a href="#" onClick="loadpage('./forums.php?forum=<?php echo $forum; ?>&p=0',document.title,document.body.id);"><?php echo $forum; ?></a>&#187; <a href="#" onClick="loadpage('./playercard.php<?php $user = "{$_GET['auteur']}"; $forum = "{$_GET['forum']}"; echo "?auteur=".$user."&forum=".$forum; ?>','XNova Forum','bodyid');">Playercard</a></p>
			<p class="datetime">Alle tijden zijn GMT + 1 uur [ Zomertijd ]</p>
		</td>
	</tr>
	</table>
    <br />
    <div id="pageheader">
	<h2><a class="titles" href="#" onClick="loadpage('./playercard.php<?php $user = "{$_GET['auteur']}"; $forum = "{$_GET['forum']}"; echo "?auteur=".$user."&forum=".$forum; ?>"><?php $user = "{$_GET['auteur']}"; echo 'Playercard: '.$user; ?></a></h2>
 
</div>
 
<br clear="all" /><br />
	<?php 
	//$battles = explode(',',$user['battles']);
//raidswon = $battles[0]
//raidsdrawn = $battles[1]
//raidsload = $battles[2]
//ALTER TABLE `beta_users` ADD `battles` VARCHAR( 30 ) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '0,0,0' AFTER `messages` ;
	$user = "{$_GET['auteur']}";
	$res=mysql_query("select id, username, authlevel, avatar, id_planet, galaxy, system, planet, ally_name, wons, loos, draws, kbmetal, kbcrystal, lostunits, desunits from beta_users where username = '".$user."' ") or die(mysql_error());
	$row=mysql_fetch_assoc($res);
	$res2=mysql_query("select id_owner, tech_rank, tech_points, build_rank, build_points, defs_rank, defs_points, fleet_rank, fleet_points, total_rank, total_points from beta_statpoints where id_owner = ".$row['id']."") or die(mysql_error());
	$row2=mysql_fetch_assoc($res2);
	$res3=mysql_query("select name from beta_planets, beta_users where beta_planets.id = beta_users.id_planet and beta_users.id_planet = ".$row['id_planet']."") or die(mysql_error());
	$row3=mysql_fetch_assoc($res3);
	if($row['ally_name'] == NULL){
		$ally = 'geen alliantie';
	}
	else{
		$ally = $row['ally_name'];
	}
	$pol = "<table width=\"100%\" cellspacing=\"0\" bgcolor=\"#333333\">";
	$pol .= "<tr>";
	$pol .= "<td>";
	$pol .= "<table class=\"tablebg\" width=\"600\" cellspacing=\"0\" id=\'mytable\'>";
	$pol .= "<caption><div class=\"cap-left\"><div class=\"cap-right\">&nbsp;Playercard&nbsp;</div></div></caption>		<tr>";
	$pol .= "<td class=\"row3\"><b class=\"gensmall\">Avatar</b></td><td class=\"row3\"><b class=\"gensmall\">Player Info</b></td>";
	$pol .= "</tr>";
	$pol .= "<tr><td class=\"row1\" align=\"center\" width=\"250\"><img src=".$row['avatar']." width=\"200\" height=\"200\"></img></td>";
	$pol .= "<td class=\"row1\"><b>Username : ".$row['username']."<br>";
	$pol .= "Homeplanet : ".$row3['name']." at ".$row['galaxy'].":".$row['system'].":".$row['planet']."<br>";
	$pol .= "Alliantie : ".$ally."</b><br><br>";
	$pol .= "<table class=\"tablebg\" width=\"85%\" cellspacing=\"0\" id=\'mytable'\>";
	$pol .= "<tr><td class=\"row3\" width=\"20%\"></td><td class=\"row3\"><b>Points</b></td><td class=\"row3\"><b>Rank</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Buildings</b></td><td class=\"row3\"><b>".pretty_number($row2['build_points'])."</b></td><td class=\"row3\"><b>".$row2['build_rank']."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Research</b></td><td class=\"row3\"><b>".pretty_number($row2['tech_points'])."</b></td><td class=\"row3\"><b>".$row2['tech_rank']."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Fleet</b></td><td class=\"row3\"><b>".pretty_number($row2['fleet_points'])."</b></td><td class=\"row3\"><b>".$row2['fleet_rank']."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Defense</b></td><td class=\"row3\"><b>".pretty_number($row2['defs_points'])."</b></td><td class=\"row3\"><b>".$row2['defs_rank']."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Total</b></td><td class=\"row3\"><b>".pretty_number($row2['total_points'])."</b></td><td class=\"row3\"><b>".$row2['total_rank']."</b></td></tr>";
	$pol .= "</table>";
	$pol .= "</td>";
	$pol .= "</tr>";
	$pol .= "<tr><td class=\"row3\" colspan=\"2\"><b class=\"gensmall\">Fight Stats</b></td><tr>";
	$pol .= "<tr>";
	$pol .= "<td colspan=\"2\">";
	if($row['wons'] == NULL ){
		$wins = 0;
	}else{
		$wins = $row['wons'];
	}
	if($row['draws'] == NULL){
		$draws = 0;
	}else{
		$draws = $row['draws'];
	}
	if($row['loos'] == NULL){
		$loos = 0;
	}else{
		$loos = $row['loos'];
	}
	$totaal = $row['wons']+$row['draws']+$row['loos'];
	$procentwins = ($wins/$totaal)*100;
	$procentdraws = ($draws/$totaal)*100;
	$procentloos = ($loos/$totaal)*100;
	$procenttotaal = $procentwins+$procentdraws+$procentloos;
	$pol .= "<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\" id=\'mytable'\>";
	$pol .= "<tr><td class=\"row3\" width=\"25%\"></td><td class=\"row3\" width=\"37,5%\"><b>Fights</b></td><td class=\"row3\" width=\"37,5%\" align=\"right\"><b>Combat Ratio</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Victories</b></td><td class=\"row3\"><b>".$wins."</b></td><td class=\"row3\" align=\"right\"><b>".round($procentwins,2)."%</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Draws</b></td><td class=\"row3\"><b>".$draws."</b></td><td class=\"row3\" align=\"right\"><b>".round($procentdraws,2)."%</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Losses</b></td><td class=\"row3\"><b>".$loos."</b></td><td class=\"row3\" align=\"right\"><b>".round($procentloos,2)."%</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Total stats</b></td><td class=\"row3\"><b>".$totaal."</b></td><td class=\"row3\" align=\"right\"><b>".round($procenttotaal,2)."%</b></td></tr>";
	$pol .= "</table>";
	$pol .= "</td>";
	$pol .= "</tr>";
	$pol .= "<tr><td class=\"row3\" colspan=\"2\"><b class=\"gensmall\">Gevolgen uit gevechten van ".$row['username']."</b></td><tr>";
	$pol .= "<tr>";
	$pol .= "<td colspan=\"2\">";
	$pol .= "<table class=\"tablebg\" width=\"100%\" cellspacing=\"0\" id=\'mytable'\>";
	$pol .= "<tr><td class=\"row3\" width=\"40%\"><b>Units killed</b></td><td class=\"row3\" width=\"60%\" align=\"right\"><b>".pretty_number($row['desunits'])."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Units Lost</b></td><td class=\"row3\" align=\"right\"><b>".pretty_number($row['lostunits'])."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Total Metal in Debris Field</b></td><td class=\"row3\" align=\"right\"><b>".pretty_number($row['kbmetal'])."</b></td></tr>";
	$pol .= "<tr><td class=\"row3\"><b>Total Crystal in Debris Field</b></td><td class=\"row3\" align=\"right\"><b>".pretty_number($row['kbcrystal'])."</b></td></tr>";
	$pol .= "</table>";
	$pol .= "</td>";
	$pol .= "</tr>";
	$pol .= "</table>";
	$pol .= "</td><td>";
	$res4=mysql_query("select id, username, authlevel, galaxy, system, planet from beta_users order by id") or die(mysql_error());
	$i=0;
	$pol .= "<table class=\"tablebg\" width=\"200\" cellspacing=\"0\" id=\'mytable2\'>";
	$pol .= "<caption><div class=\"cap-left\"><div class=\"cap-right\">&nbsp;Playercards&nbsp;</div></div></caption>";
	while($row4=mysql_fetch_assoc($res4))
	{
		if($row4['authlevel'] != 0) {
			if($row4['authlevel'] != 1) {
				if($row4['authlevel'] != 2) {
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
		$pol .= "<tr><td align=\"right\"><a href=\"playercard.php?auteur=".$row4['username']."&forum=".$_GET['forum']."\" style=\"color: ".$color."\" class=\"username-coloured\">".$row4['username']."</a> &nbsp;&nbsp;</td><td align=\"left\">".$row4['galaxy'].":".$row4['system'].":".$row4['planet']."</td></tr>";
		$i++;
	}
	$pol .= "</table>";
	$pol .= "</td>";
	$pol .= "</tr>";
	$pol .= "</table>";
	echo $pol;
	?>
    <br />
    <table class="tablebg breadcrumb" width="100%" cellspacing="0" cellpadding="0" style="margin-top: 5px;">
	<tr>
		<td class="row1">
			<p class="breadcrumbs"><a href="#" onClick="loadpage('./home.php','XNova Forum','bodyid');">Forumoverzicht</a> &#187;
            <?php
			$forum = "{$_GET['forum']}";
			if( "{$_GET['forum']}" != 'Game News') {
				if( "{$_GET['forum']}" != 'Technical Assistence') {
					if( "{$_GET['forum']}" != 'Gameplay Help') {
						if( "{$_GET['forum']}" != 'Handel') {
							if( "{$_GET['forum']}" != 'Diplomatie Uni 1') {
								if( "{$_GET['forum']}" == 'Diplomatie Uni 2') {
									echo '<a href="./forums.php?forum=Diplomatie Uni 2">'.$forum.'</a>';
								}
							}
							else {
								echo '<a href="./forums.php?forum=Diplomatie Uni 1">'.$forum.'</a>';
							}
						}
						else {
							echo '<a href="./forums.php?forum=Handel">'.$forum.'</a>';
						}
					}
					else {
						echo '<a href="./forums.php?forum=Gameplay Help">'.$forum.'</a>';
					}
				}
				else {
					echo '<a href="./forums.php?forum=Technical Assistence">'.$forum.'</a>';
				}
			}
			else {
				echo '<a href="./forums.php?forum=Game News">'.$forum.'</a>';
			} 			
			?>&#187; <a href="./playercard.php<?php $user = "{$_GET['auteur']}"; $forum = "{$_GET['forum']}"; echo "?auteur=".$user."&forum=".$forum; ?>">Playercard</a></p>
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

