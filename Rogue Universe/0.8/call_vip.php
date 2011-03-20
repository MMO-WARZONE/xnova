<?php
 
// Stäng av PHP:s felrapportering
error_reporting(0);
 
 
// Kontrollera att det är MO-SMS som anropar (OBS: kommentera bort vid testkörning!)
if($_SERVER['REMOTE_ADDR'] != '217.75.102.141'){   
   exit();   
}
 
// Plocka ut avsändarnumret
$nr = $_REQUEST['nr'];
 
// Plocka ut SMS-meddelandet
$sms = urldecode($_REQUEST['sms']);
 
// Plocka ut priset slutanvändaren blev debiterad (för egen vinststatistik)
$tariff = $_REQUEST['tariff'];
 
// Plocka ut operatören SMS:et skickades in via (för egen vinststatistik)
$operator = $_REQUEST['operator'];

//Spara i databasen
mysql_connect("localhost","DB_USER","DB_PASS") or exit( mysql_error() );
mysql_select_db("DB_NAME") or exit( mysql_error() );
 $infos = explode(" ", $sms);

$query = mysql_query("UPDATE game_users SET arraki = arraki + 100 WHERE username = '$infos[1]' ") or die(mysql_error());


$query = mysql_query("UPDATE game_planets, game_users SET game_planets.arraki = game_users.arraki WHERE game_planets.id_owner = game_users.id") or die(mysql_error());


$query="select arraki from game_users WHERE username = '$infos[1]'";
$result=mysql_query($query);
while($row=mysql_fetch_array($result))
{
    echo "Thank you for your order. You now have ". $row['arraki'] ." Arraki!";
 }


mysql_free_result($result);
mysql_close();

?> 
