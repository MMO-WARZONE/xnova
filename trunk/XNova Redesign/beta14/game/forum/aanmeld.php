<?php
require("connect.php"); // verbinding met de database maken
?>
<html>
<head>
<title>sessies • aanmelden</title>
</head>

<body>
<?php
// als het formulier nog niet is ingevuld
if(!isset($_POST['submit'])) {
?>
<form action="aanmeld.php" method="post">
naam <input type="text" name="naam" size="40" maxlength="20" /><br />
wachtwoord <input type="password" name="wacht1" size="40" maxlength="30" /><br />
wachtwoord opnieuw <input type="password" name="wacht2" size="40" maxlength="30" /><br />
<!--
en wat je verder over deze gebruiker bij wilt houden
bijvoorbeeld leeftijd, woonplaats, email, ...
voor het opvragen van het wachtwoord etc. etc.
hier moet je dan ook velden voor in je tabel 'members' aanmaken.
Op deze extra velden moeten hieronder ook controles uitgevoerd worden of ze ingevuld zijn!
-->
<input type="submit" name="submit" value="submit" />
</form>
<?php
// formulier gepost, kijk of alle velden ook daadwerkelijk zijn ingevuld
} elseif(trim($_POST['naam']) <> "" && trim($_POST['wacht1']) <> "") {
  // formulier ingevuld - kijk eerst of de gebruiker al bestaat
  $naam = $_POST['naam'];
  $res = mysql_query("SELECT * FROM users WHERE name='".$naam."'") or die(mysql_error());
  if(mysql_num_rows($res) == 0) {
    // geen resultaten - dit is wat we willen
    // kijk of de opgegeven wachtwoorden overeenkomen
    if(!strcmp($_POST['wacht1'], $_POST['wacht2'])) {
      // wachtwoorden komen overeen - sla alle gegevens op in de database
      // naam is al opgehaald uit het formulier
      $wacht = md5($_POST['wacht1']); // versleuteld wachtwoord
      $level = 1;                     // standaard gebruikersniveau
      mysql_query("INSERT INTO users (name, pass, level) VALUES ('".$naam."','".$wacht."',".$level.")") or die(mysql_error());

      // geef melding weer
?>
Je gegevens zijn opgeslagen.<br />
Je kunt <a href="login.php">hier</a> naartoe om in te loggen.<br />
<?php
    } else {
      // wachtwoorden komen niet overeen
?>
De twee opgegeven wachtwoorden zijn niet hetzelfde.<br />
Druk op de "back" knop van je browser en voer twee identieke wachtwoorden in.<br />
<?php
   }
  } else {
    // er bestaat al een gebruiker met deze naam
?>
Er bestaat al een gebruiker met deze naam.<br />
Druk op de "back" knop van je browser en geef een andere naam op.<br />
<?php
  }
} else {
  // sommige velden zijn niet ingevuld
?>
Alle velden dienen ingevuld te worden.<br />
Druk op de "back" toets en vul in alle velden wat in.<br />
<?php
}
?>
</body>
</html>
