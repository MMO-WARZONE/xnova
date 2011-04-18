<?php

/**
 * contact2.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */
  define('INSIDE'  , true);
	define('INSTALL' , false);
	
	$ugamela_root_path = './';
	include($ugamela_root_path . 'extension.inc');
	include($ugamela_root_path . 'common.' . $phpEx);
	
	includeLang('support');
	$page .= print_r($_SESSION);
	if(!isset($_POST['supp'], $_POST['text'])) {
		$page .= '
		<form id="support" name="support" method="post" action="contact2.php">
			<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><strong>Support</strong></td>
				</tr>
				<tr>
					<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%" align="right" valign="top">Betreff:&nbsp;</td>
								<td>&nbsp;
								  <select name="supp" id="supp">
								    <option value="Beleidigung">Beleidigung</option>
								    <option value="Bug">Bug</option>
								    <option value="Sonstiges">Sonstiges</option>
							    </select>
							  </td>
							</tr>
							<tr>
								<td align="right" valign="top">Nachricht:&nbsp;</td>
								<td>&nbsp;
										<textarea name="text" cols="50" rows="10" id="text"></textarea></td>
							</tr>
							<tr>
								<td align="right" valign="top">&nbsp;</td>
								<td>&nbsp;
										<input type="submit" name="Submit" value="Abschicken" /></td>
							</tr>
					</table></td>
				</tr>
			</table>
		</form>
		';
	}
	else if(isset($_POST['supp'], $_POST['text']) && $_POST['supp'] != "" && $_POST['text'] != ""){
		$allow_supp = array("Beleidigung", "Sonstiges", "Bug");
		
		$supp = trim($_POST['supp']);
		$text = trim($_POST['text']);
		
		if(in_array($supp, $allow_supp)) {
			$mail_to = "nimda.xnova@web.de";
      $Sender  = $user['id'];
			$From    = $user['username'] ." [".$user['galaxy'].":".$user['system'].":".$user['planet']."]";
			$Subject = $_POST['subject'];
			if(mail($mail_to, $supp, $From, $text)) {
				$page .= '
				<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td><strong>Support</strong></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td align="center">Deine Nachricht wurde abgeschickt.</td>
					</tr>
				</table>
				';
			}
		}
		else {
			$page .= '
			<form id="support" name="support" method="post" action="contact.php">
				<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
					<tr>
						<td><strong>Support</strong></td>
					</tr>
					<tr>
						<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right" valign="top">Betreff:&nbsp;</td>
									<td>&nbsp;
											<select name="supp" id="supp">
								    <option value="Beleidigung">Beleidigung</option>
								    <option value="Bug">Bug</option>
								    <option value="Sonstiges">Sonstiges</option>
							    </select></td>
								</tr>
								<tr>
									<td align="right" valign="top">Nachricht:&nbsp;</td>
									<td>&nbsp;
											<textarea name="text" cols="50" rows="8" id="text"></textarea></td>
								</tr>
								<tr>
									<td align="right" valign="top">&nbsp;</td>
									<td>&nbsp;
											<input type="submit" name="Submit" value="Abschicken" /></td>
								</tr>
						</table></td>
					</tr>
				</table>
			</form>
			';
		}
	}
	else {
		$page .= '
		<form id="support" name="support" method="post" action="contact.php">
			<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><strong>Support</strong></td>
				</tr>
				<tr>
				  <td align="center"><strong style="color:#FF0000;">Fehlgeschlagen: Bitte Nachricht eintragen.</strong></td>
			  </tr>
				<tr>
					<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="20%" align="right" valign="top">Betreff:&nbsp;</td>
								<td>&nbsp;
										<select name="supp" id="supp">
								    <option value="Beleidigung">Beleidigung</option>
								    <option value="Bug">Bug</option>
								    <option value="Sonstiges">Sonstiges</option>
							    </select></td>
							</tr>
							<tr>
								<td align="right" valign="top">Nachricht:&nbsp;</td>
								<td>&nbsp;
										<textarea name="text" cols="50" rows="8" id="text"></textarea></td>
							</tr>
							<tr>
								<td align="center" valign="top">&nbsp;</td>
								<td>&nbsp;
										<input type="submit" name="Submit" value="Abschicken" /></td>
							</tr>
					</table></td>
				</tr>
			</table>
		</form>
		';
	}
	
	display($page);
?>