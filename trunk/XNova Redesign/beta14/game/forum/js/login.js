function login(type) {
require("connect.php");
session_start();

if(type == 'yes') {
if(isset($_POST['login'])) {
  if(trim($_POST['naam']) <> "" && trim($_POST['wacht']) <> "") {
    $naam  = $_POST['naam'];
    $wacht = md5($_POST['wacht']);
    $res = mysql_query("SELECT id, pass, level FROM users where name='".$naam."'") or die(mysql_error());

    if(mysql_num_rows($res) > 0) {
      $row = mysql_fetch_assoc($res);
      if(!strcmp($wacht, $row['pass'])) {
          if(isset($_POST['memory'])) {
          setcookie("login_cookie", $row['id'].";".$row['pass'], time()+3600*24*31*2, "/");
          $ip = $_SERVER['REMOTE_ADDR'];
          mysql_query("UPDATE users SET last_ip='".$ip."' WHERE id=".$row['id']) or die(mysql_error());
        }

        $_SESSION['suser']    = $naam;         // gebruikersnaam van ingelogd persoon
        $_SESSION['slevel']   = $row['level']; // bijbehorende gebruikersniveau
        $_SESSION['stime']    = time();        // de huidige tijd
        $_SESSION['smaxidle'] = 60 * 60;       // het aantal seconden inactiviteit
      } else {
        $_SESSION = array();
        session_destroy();
      }
      unset($row);
      mysql_free_result($res);
    }
    header("Location: logintest.php");
  }
}
}
}