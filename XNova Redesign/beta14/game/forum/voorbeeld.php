<?php
// include/require hier evt nog andere zaken
require ("connect.php");
// we willen op deze pagina gebruik maken van beveiliging mbv sessies,
// dus includen (requiren) we session.php
require("session.php");
?>
<?php
require("login.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forum Asschensukar</title>
<!--<script type="text/javascript" src="js/login.js"></script>-->
<LINK HREF="css/basis.css" REL="stylesheet" TYPE="text/css">
<LINK HREF="css/stylesheet.css" REL="stylesheet" TYPE="text/css">
<script language="javascript" src="js/time.js"></script>
</head>

<body>
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
<?php
/*
we gaan hier kijken of de gebruiker is ingelogd, en welk
user level de gebruiker heeft. Op grond daarvan laten we
bepaalde delen al dan niet zien.
Een gebruikerslevel is een getal wat aangeeft hoeveel
"macht" je hebt. Vaak is het zo: hoe hoger het getal, hoe
meer je mag.
bijvoorbeeld:
Voor een bepaalde bewerking heb je gebruikers-
niveau 1 nodig, maar voor een andere bewerking heb je niveau
2 nodig. Een gebruiker die beide bewerkingen mag uitvoeren
heeft gebruikersniveau 1+2 = 3. MAAR: Een gebruiker die om
een of andere reden alleen de tweede bewerking mag uitvoeren
heeft gebruikersniveau 0+2 = 2. Dus je telt de nummers die
bij bepaalde rechten horen bij elkaar op.
Het nummer dat het recht geeft op een bepaalde bewerking is
altijd een macht van 2.
bijvoorbeeld:
recht #1 (bv inloggen) heeft gebruikers niveau            2^0 = 1
recht #2 (bv je eigen info veranderen) heeft gebr. niveau 2^1 = 2
recht #3 (bv nieuws toevoegen) heeft gebruikers niveau    2^2 = 4
recht #4 (bv members toevoegen) heeft gebruikersniveau    2^3 = 8
enz.
Iemand die al deze bewerkingen mag uitvoeren heeft dus
gebruikersniveau 1+2+4+8 = 15 (of 2^4 - 1)
Iemand die alleen recht #1 en recht #3 heeft, heeft
dus gebruikersniveau 1+4 = 5
*/
// controle op ingelogd zijn:
if(isset($_SESSION['suser'])) {
?>
user <b><?php $naam = $_SESSION['suser']; echo $naam;?></b> is logged in.<br />
<?php
  /*
  vervolgens kijken we naar het userlevel, we vergelijken
  bitsgewijs het gebruikerslevel - dit doen we met behulp van
  een enkele '&' (de bitwise comparator)
  *** LET OP ***
  Enkel controleren met & is niet genoeg !
  Stel dat je level 9 moet hebben voor een bepaalde bewerking, en je hebt
  maar level 1. 1 & 9 is gelijk aan 1, en dan zou if(1 & 9) { ... } true opleveren
  Je moet dus expliciet controleren of je level hoog genoeg is.
  */
  if(($_SESSION['slevel'] & 1) == 1) {
    // voer code uit behorend bij recht #1
?>
Je bent gewonne user.<br />
<?php
  } else {
    // geef een melding dat je de acties
    // behorend bij recht #1 niet mag uitvoeren
?>
Je hebt recht #1 NIET.<br />
<?php
  }

  if(($_SESSION['slevel'] & 2) == 2) {
    // voer code uit behorend bij recht #2
?>
Je bent GO.<br />
<?php
  } else {
?>
Je hebt recht #2 NIET.<br />
<?php
  }
  if(($_SESSION['slevel'] & 4) == 4) {
    // voer code uit behorend bij recht #3
?>
Je bent SGO.<br />
<?php
  } else {
?>
Je hebt recht #3 NIET.<br />
<?php
  }
  if(($_SESSION['slevel'] & 8) == 8) {
    // voer code uit behorend bij recht #4
?>
Je bent Admin.<br />
<?php
  } else {
?>
Je hebt recht #4 NIET.<br />
<?php
  }
  // et cetera
?>
<a href="index.php">homepage</a><br />
<a href="posttest.php">Posttest</a><br />
<a href="logout.php">uitloggen</a><br />
<?php
} else {
?>
Je bent op dit moment niet ingelogd.<br />
<!--<a href="login.php">inloggen</a><br />
<a href="aanmeld.php">registreer</a><br />-->
<?php
}
?>
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