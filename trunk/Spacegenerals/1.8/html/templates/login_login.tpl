<script type="text/javascript">
    var lastType = "";
    function changeAction(type) {
		if(document.formular.Uni.value == '') {
			alert('Bitte waehle ein Universum!');
		}
		else {
			if(type == "login" && lastType == "") {
    			var url = "" + document.formular.Uni.value + "";
    			document.formular.action = url;
			}
		}
	}    </script>
  <div id="login"><table align="right"><tr align="left"><td>Universum:</td><td>{User_name}</td><td>{Password}</td><td><form name="formular" action="login.php" method="post" onSubmit="changeAction('login');" style="margin-top: -9px; margin-left: 70px;">
<input name="timestamp" value="1173621187" type="hidden"><input name="v" value="2" type="hidden"><input name="mode" value="login" type="hidden"><input name="mode2" value="login" type="hidden"><input name="login" value="{mode}" type="hidden">&nbsp;</td></tr>
<!-- <div id="login_input"> -->
<tr align="left"><td><select tabindex="1" name="Uni" class="">
					   <option value="">--</option>
                       <!-- HIER BITTE OHNE HTTP:// -->
                      <option value="http://uni1.finalgalaxy.com/login.php">Universum 1</option>
					  <option value="www.deine-Domain2/test/login.php">Universum 2</option>
                    </select></td><td><input name="username" tabindex="2" value="" type="text">
</td><td><input name="password" tabindex="3" value="" type="password"></td><td><input name="submit" value="{Login}" tabindex="4" type="submit"></td></tr>
<tr align="right"><td colspan="3">{Remember_me} <input name="rememberme" type="checkbox"> <script type="text/javascript">document.formular.Uni.focus(); </script></form></td></tr></table>
<!-- </div> -->
<div id="downmenu"><a href="login.php?mode=passlost">{PasswordLost}</a>&nbsp;<a href="login.php?mode=rules">{rules}</a>&nbsp;<a href="login.php?mode=agb">{agb}</a>&nbsp;<a href="login.php?mode=impressum">{impressum}</a>&nbsp;<a href="login.php?mode=credit">{log_cred}</a></div>

<div id="copyright">Login &copy; copyright 2008 by <a href="http://www.mwieners.de">Mwieners</a></div>
</div>