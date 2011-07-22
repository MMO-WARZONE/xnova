<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <link href="skins/xnova/formate.css" rel="stylesheet" type="text/css">
  <title>XNova</title>
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="css/styles.css">
  <link rel="stylesheet" type="text/css" href="css/about.css">
</head>
<body>
  <div id="main">
     <script type="text/javascript">
	var lastType = "";
	function changeAction(type) {
	if (document.formular.Uni.value == '') {
	    alert('{log_univ}'); }
	else {
	    if(type == "login" && lastType == "") {
	    var url = "http://" + document.formular.Uni.value + "";
	    document.formular.action = url; }
	else {
            var url = "http://" + document.formular.Uni.value + "/reg.php";
            document.formular.action = url;
            document.formular.submit(); } } }
	function jump()
	{
	   var a = document.getElementById ('ChangeUniversum');
	   if (a.value != "dummy")
	   {
	      url = "http://" + a.value;
	      document.location = url;
	   }
	}

     </script>
  <div id="login"><a name="pustekuchen"></a>
  <div id="login_input">
<table border="0" cellpadding="8" cellspacing="0">
<tbody>
<tr style="vertical-align: buttom;">
<td style="padding-left: 4px;">
<form name="formular" action="" method="post" onsubmit="changeAction('login');" style="margin-top: -9px; margin-left: 10px;"> <input name="timestamp" value="1173621187" type="hidden"><input name="v" value="2" type="hidden">
<select name="select" onchange="javascript:jump();" class="norm" id="ChangeUniversum"><option value="xnova-germany.org">Universum 1</option><option value="xnova-germany.org">Universum 2</option><option value="xnova-germany.org">Universum 3</option><option value="xnova-germany.org">Universum 4</option><option value="xnova-germany.org">Universum 5</option></select> 
{User_name} <input name="username" value="" type="text">
{Password} <input name="password" value="" type="password"><br>
{Remember_me} <input name="rememberme" type="checkbox"> <script type="text/javascript">document.formular.Uni.focus(); </script><input name="submit" value="{Login}" type="submit"><label></label></form>
<a href="lostpassword.php">{PasswordLost}</a>
</td>
</tr>
</tbody>
</table>
</div>
<div id="downmenu">&nbsp;</div>
</div>
<div id="mainmenu" style="margin-top: 20px;">
<a href="reg.php">{log_reg}</a>
<a href="{forum_url}" target="fenster" >Forum</a>
<a href="contact.php">Contact</a>
<a href="credit.php">{log_cred}</a>
<a href="banned.php">{log_pranger}</a>
<a href="impressum.php">{log_impres}</a>
</div>
<div id="rightmenu" class="rightmenu">
<div id="title"></div>
<div id="content">
<div style="text-align: left;"></div>
<center>
<div style="text-align: left;"></div>
<div id="text1">
<div style="text-align: left;"><strong>{servername}</strong> {log_desc} {servername}.
</div>
</div>
<div id="register" class="bigbutton" onclick="document.location.href='reg.php';"><font color="#cc0000">{log_toreg}</font></div>
<div id="text2">
<div id="text3">
<center><b><font color="#00cc00">{log_online}: </font>
<font color="#c6c7c6">{online_users}</font> - <font color="#00cc00">{log_lastreg}: </font>
<font color="#c6c7c6">{last_user}</font> - <font color="#00cc00">{log_numbreg}:</font> <font color="#c6c7c6">{users_amount}</font>
</b></center>
</div>
</div>
</center>
</div>
<div id="text3">
<center><br>
<div style="text-align: left; color: white;"><big style="font-weight: bold; margin-left: 25px;"><big>{log_welcome} {servername}</big></big></div>
</center>
</div>
</div>
</div>
</body></html>