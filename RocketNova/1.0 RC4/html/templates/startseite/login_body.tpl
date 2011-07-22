
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" />
<script src="rollover.js" type="text/javascript"></script>
</head>

<body id="page1" onload="MM_preloadImages('images/m1_act.jpg','images/m2_act.jpg','images/m3_act.jpg','images/m4_act.jpg','images/m5_act.jpg','images/m6_act.jpg')">	<div id="main">
		<!-- header -->
		<div id="header">
			<div class="row_1">
				<div class="fleft">{url}</div>
				<ul class="top_nav">
					<li><a href="kontakt.php">{Kontakt}</a></li>
					<li><a class="last" href="impressum.php">{Impressum}</a></li>
				</ul>
			</div>
			<div class="row_2">
				<div class="inner">
					<a href="index.php"><img alt="" src="images/logo.png" /></a><br />

				</div>
			</div>
			<div class="row_3">
<a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_1','','images/m1_act.jpg',1)"><img alt="" src="images/m1_act.jpg" id="r_1" /></a><a href="forum/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_2','','images/m2_act.jpg',1)"><img alt="" src="images/m2.jpg" id="r_2" /></a><a href="irc.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_3','','images/m3_act.jpg',1)"><img alt="" src="images/m3.jpg" id="r_3" /></a><a href="pranger.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_4','','images/m4_act.jpg',1)"><img alt="" src="images/m4.jpg" id="r_4" /></a><a href="gameinfos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_5','','images/m5_act.jpg',1)"><img alt="" src="images/m5.jpg" id="r_5" /></a><a href="kontakt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_6','','images/m6_act.jpg',1)"><img alt="" src="images/m6.jpg" id="r_6" /></a>    			</div>
		</div>
		<!-- content -->
		<div id="content">
			<div class="bgd">
				<div class="inner">
					<div class="extra">
                    <a href="index.php"><img alt="" src="images/login.jpg" /></a><a href="reg.php"><img alt="" src="images/reg.jpg" /></a><a href="pw.php"><img alt="" src="images/pw.jpg" /></a>
					</div>
					<div class="article">
						<div class="wrapper">
						  <div class="col_1">
								<h5 align="center"><br />{Infos}</h5>
							<table width="250" border="0" cellspacing="0" cellpadding="0" id="table3">
  <tr>
    <td width="100"><font size="p2" color="#E3F8E6">{log_online}:</font></td>
    <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{online_users}</font></td>
  </tr>
  <tr>
    <td width="100"><font size="p2" color="#E3F8E6">{log_lastreg}:</font></td>
    <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{last_user}</font></td>
  </tr>
  <tr>
    <td width="100"><font size="p2" color="#E3F8E6">{log_numbreg}:</font></td>
    <td width="150"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{users_amount}</font></td>
  </tr>
</table>
								<p>&nbsp;</p>
							  <h5 align="center">{Links}</h5>
								<div class="wrapper">
									<ul class="list1 column1">
										<li><a href="http://www.teamrocket.info">
										Team Rocket</a></li>
									</ul>
									<ul class="list1 column2">
										<li><a href="http://www.imagehut.eu">
										Bilder hochladen</a></li>
									</ul>
									<ul class="list1 column3">
										<li><a href="http://www.maildome.com">
										eMail & SMS</a></li>
									</ul>
<p>&nbsp;</p>
									<ul class="list1 column4">
										<li><a href="http://www.mmogbay.com">
										MMOG Marktplatz</a></li>
									</ul>
									<ul class="list1 column5">
										<li><a href="http://www.facevz.com">
										FaceVZ Netzwerk</a></li>
									</ul>
									<ul class="list1 column6">
										<li><a href="http://games.2go.cc">
										Games Portal</a></li>
									</ul>
								</div>
						  </div>
							<div class="col_2">
								<h2 align="center">{Welcome} {servername}</h2>
								<p>&nbsp;</p>
								<h3>{ueberschrift1}</h3>
								<p class="p1">{text1}</p>
                                <h3>{ueberschrift2}</h3>
								<p class="p1">{text2}</p>
                                <h3>{ueberschrift3}</h3>
								<p class="p1">{text3}</p>
                                <h3>{ueberschrift4}</h3>
								<p class="p1">{text4}</p>
                                <h3>{ueberschrift5}</h3>
								<p class="p1">{text5}</p>
                                <h3>{ueberschrift6}</h3>
								<p class="p1">{text6}</p>
<div class="wrapper"></div>
							</div>
						  <div class="col_3">
								<h5 align="center"><br />{Login}</h5>

							<table width="160" border="0" cellspacing="0" cellpadding="0" background="http://your-domain.de/images/navibg.gif" id="table4">
              <tr>
                  <td width="160">
				  <form name="formular" action="" method="post" onsubmit="changeAction('login');">
                  <input type="hidden" name="timestamp" value="1173621187" />
                  <input type="hidden" name="v" value="2" />
				    <p align="center">{GameName}<input name="username" tabindex="1" style="background-color:#000000" type="text" value="{GameName}" size="14" />
					</p>
					<p align="center">{neededpass}<input name="password" tabindex="2" style="background-color:#000000" type="password" value="passwort" size="14" /></p>
					<p align="center"><input type="image" border="0" name="imageField2" src="images/go.gif" width="37" height="17" />
                    &nbsp;<script type="text/javascript"> document.formular.Uni.focus(); </script>					                        
					</p>
					</tr>
            </table>
								<p align="left">
								<object id="csSWF" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="160" height="120" codebase="http://active.macromedia.com/flash7/cabs/ swflash.cab#version=9,0,28,0">
                <param name="src" value="animation/video.swf"/>
                <param name="bgcolor" value="#1a1a1a"/>
                <param name="quality" value="best"/>
                <param name="allowScriptAccess" value="1"/>
                <param name="allowFullScreen" value="true"/>
                <param name="scale" value="showall"/>
                <param name="flashVars" value="autostart=true"/>
                <embed name="csSWF" src="./animation/video.swf" width="160" height="120" bgcolor="#1a1a1a" quality="best" allowScriptAccess="always" allowFullScreen="true" scale="showall" flashVars="autostart=true" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
            </object></p>
								<h3>
</h3>

								<div class="alignright">&nbsp;</div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- footer -->
		<div id="footer">
			<div class="fleft">
<!-- Darf nicht geänder oder Gelöscht werden -->
<!-- änderung oder löschung führt zu anzeige -->
				{copyright}
<!-- Must not be changed or deleted -->
<!-- modification or deletion leads to ad -->
			</div>
			<div class="fright">
				<a href="index.php"><img alt="" src="images/footer_img1.jpg" /></a><a href="reg.php"><img alt="" src="images/footer_img2.jpg" /></a><a href="forum/index.php"><img alt="" src="images/footer_img3.jpg" /></a><a href="impressum.php"><img alt="" src="images/footer_img4.jpg" /></a>
			</div>
		</div>
	</div>
</body>
</html></body>
</html>