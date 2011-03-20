<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 2) {
		includeLang('admin');

		$mode      = $_POST['mode'];
  
  if (isset($_POST['mailing'])) 
  {
    $rMember = mysql_query("SELECT username, email FROM `game_users`");
    while ($aMember = mysql_fetch_assoc($rMember)) 
    {
      $sBericht = str_replace('{naam}', $aMember['login'], $_POST['mailing']);
      @mail($aMember['email'], $_POST['titel'], $sBericht, 'From: Admin <admin@yourmail.com>');
      echo '<br><br>Newsletter sent';

    }

  }
  else
  {

?>
<BR><BR>
<table align="center" width=70%>
  <tr><td class="subTitle">Mass E-Mail - Newsletter</b></td></tr>
  <tr><td class="mainTxt">
<form method="post" action="" name="">
Subject:<BR><input type="text" name="titel" value=""><BR><BR>
Message:<br>
<textarea cols=40 rows=10 name="mailing">
</textarea><p />

<input type="submit" value="Send" name="submit">

</form>
</table>

<?php

		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$metal       = $_POST['metal'];
			$cristal     = $_POST['cristal'];
			$deut        = $_POST['deut'];

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
			$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
			$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_am_done'], $lang['adm_am_ttle'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	}  
		AdminMessage ( $lang[''], $lang[''] );
	}

?>