<style type="text/css">
<!--
body {
background-color: #061229;
background-position:center bottom;
background-repeat:no-repeat;
background-image: url(images/border/mainback.gif);
margin:0px 10px 0px 10px;
font-family:Arial, Helvetica, sans-serif; 
font-size:9px; 
color:#54718D; 
}

form{margin:0px;}
table{border:0px;}
tr, td{font-size:12px;}

a{color:#9EBDE4; text-decoration:none;}
a:hover{color:#CADFFA; text-decoration:underline;}
a.footer_link{font-size:10px; color:#AABFDA; text-decoration:none;}
a.footer_link:hover{font-size:10px; color:#ffffff; text-decoration:underline;}


.button, .eingabe{ 
border:1px double #000000;
background:#395584;
color: #cedfff;
font-size:10px;
}
.text{font-size:11px; color:#649CD3; letter-spacing: 2px; }

-->

</style>
<body>
<br><br><hr size=1><br><br><center>
 <form name="formular" action="" method="post">
  {User_name}<input name="username" type="text" value="" />
  {Password}<input name="password" type="password" value="" />
  <input name="submit" type="submit" value="{Login}" /><br />
  <label><input name="rememberme" type="checkbox">{Remember_me}</label>
</form>

<div class="eingabe"><b>{Online_users} <font color=#c6c7c6>{online_users}</font> - {Last_registed_user} <font color=#c6c7c6>{last_user}</font> - {Users_ammount} <font color=#c6c7c6>{users_amount}</font></b> - <a href="reg.php">{Register}</a></div>

<p><!-- una moneda pa' la torre? -->
<a href="http://sourceforge.net/donate/index.php?group_id=184761"><img src="http://images.sourceforge.net/images/project-support.jpg" alt="Support This Project" border="0" height="32" width="88"></a>
</form></p>
</center><br><hr size=1>
</body>
</html>
