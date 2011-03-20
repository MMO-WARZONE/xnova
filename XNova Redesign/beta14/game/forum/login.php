<?php
require("connect.php"); 
require_once('sha256.inc.php');
session_start(); 
if(isset($_POST['login'])) {
  if(trim($_POST['naam']) <> "" && trim($_POST['wacht']) <> "") {
    $naam  = $_POST['naam'];
    $wacht = sha256($_POST['wacht']);
    $res = mysql_query("SELECT id, password, authlevel FROM beta_users where username='".$naam."'") or die(mysql_error());
    if(mysql_num_rows($res) > 0) {
      $row = mysql_fetch_assoc($res);
      if(!strcmp($wacht, $row['password'])) {
        if(isset($_POST['memory'])) {
          setcookie("login_cookie", $row['id'].";".$row['password'], time()+3600*24*31*2, "/");
          $ip = $_SERVER['REMOTE_ADDR'];
          mysql_query("UPDATE beta_users SET user_lastip='".$ip."' WHERE id=".$row['id']) or die(mysql_error());
        }
		mysql_query("update beta_users set forum_online='online' where username='".$naam."'") or die(mysql_error());
		setcookie('XNovaforum',$naam,time()+60*60);
        $_SESSION['suser']    = $naam;   
		//if($_SESSION['suser'] == 'Warsaalk' ){ mysql_query("UPDATE beta_users SET authlevel = 2 WHERE username='Warsaalk'") or die(mysql_error());}
        $_SESSION['slevel']   = $row['authlevel']; 
        $_SESSION['stime']    = time();        
        $_SESSION['smaxidle'] = 60 * 60;    
      } else {
		mysql_query("update beta_users set forum_online='offline' where username='".$_SESSION['suser']."'") or die(mysql_error());
		$_SESSION = array();
        session_destroy();
      }
      unset($row);
      mysql_free_result($res);
    }
 }

	/*echo "<form action=\"index.php\" type=\"post\">";
	echo "<input type=\"hidden\" name=\"post\" value=\"dit is post\">";
	echo "</form>";
	echo "<script language=\"JavaScript\" type=\"text/javascript\"> ";
	echo "document.return.submit(); ";
	echo "</script> ";*/
    //include('js/ajax.js');
    /*echo '<script language=\"javascript\" src=\"js/ajax.js\"></script>';
    echo '<script type=\"text/javascript\"> 
	loadpage(\'index.php\',\'XNova\',\'bodyid\');
	</script>'; /*
	<body onLoad="loadpage('home.php','XNova Forum','bodyid');" >
    </body>
 
		header("Location: loadpage('home.php','XNova','bodyid')");
		echo "<body onLoad=\"loadpage('home.php','XNova','bodyid');\"></body>";
	//Header("content-type: application/x-javascript");
	echo '<script language=\"javascript\" src=\"js/ajax.js\"></script>';*/
	/*echo '<script> loadpage(\'./home.php\',\'XNova\',\'bodyid\');</script>';
	/*echo '<a href="#" onclick="loadpage(\'home.php\',\'XNova Forum\',\'bodyid\');">hellow</a>';
 */
}
// als de gebruiker is ingelogd
if($_COOKIE["XNovaforum"] != $_SESSION['suser']){mysql_query("update beta_users set forum_online='offline' where username='".$_SESSION['suser']."'") or die(mysql_error());
    $_SESSION = array();
    session_destroy();
}
if(isset($_SESSION['suser'])) {
  // het volgende timeout deel is optioneel - dit mag worden weggelaten
  // * timeout gedeelte *
  $now = time();
  // als er meer tijd is verstreken dan smaxidle
  // sinds het aanmaken van de sessie
  if($now - $_SESSION['stime'] > $_SESSION['smaxidle']) {
    // breek de sessie af, de gebruiker dient opnieuw in te loggen
	mysql_query("update beta_users set forum_online='offline' where username='".$_SESSION['suser']."'") or die(mysql_error());
    $_SESSION = array();
    session_destroy();
  } else {
    // ververs anders de sessietijd. Dit zorgt er voor
    // dat de gebruiker ingelogd blijft zolang deze actief is.
	setcookie('XNovaforum',$naam,time()+60*60);
    $_SESSION['stime'] = $now;
  }
  // * einde timeout gedeelte *
// v1.2 extra functionaliteit, onthouden login
} elseif(isset($_COOKIE['login_cookie'])) {
  // bekijk de waarden van de cookie en als deze kloppen met de database - start alsnog een sessie
  // aanname - er is een verbinding met de database
  list($id, $wacht) = split(";", $_COOKIE['login_cookie']);
  $res = mysql_query("SELECT id, password, authlevel, user_lastip FROM beta_users WHERE id='".$id."'") or die(mysql_error());
  if(mysql_num_rows($res) > 0) {
    $row = mysql_fetch_assoc($res);
    if(!strcmp($wacht, $row['password']) && $_SERVER['REMOTE_ADDR'] == $row['user_lastip']) {
      // init session
      $_SESSION['suser']    = $naam;
      $_SESSION['slevel']   = $row['authlevel'];
      $_SESSION['stime']    = time();
      $_SESSION['smaxidle'] = 60 * 60;

      // update cookie
      // gebruik hierbij wederom het id en het versleutelde wachtwoord
      setcookie("login_cookie", $id.";".$wacht, time()+3600*24*31*2, "/");
    } else {
      // password of ip komt niet overeen - unset het cookie en beeindig de sessie
	  mysql_query("update beta_users set forum_online='offline' where username='".$_SESSION['suser']."'") or die(mysql_error());
      setcookie("login_cookie", "", time(), "/");
      $_SESSION = array();
      session_destroy();
    }
    // geef resultaten vrij
    unset($row);
    mysql_free_result($res);
  } else {
    // gebruiker onbekend, cookie vervalst ?
	mysql_query("update beta_users set forum_online='offline' where username='".$_SESSION['suser']."'") or die(mysql_error());
    $_SESSION = array();
    session_destroy();
  }
  //stem cookie
  /*function cookie(){
			$month = 2592000 + time(); 
			setcookie("poll", "gestemd", $month);
  }*/
  // ververs de pagina
}
?>