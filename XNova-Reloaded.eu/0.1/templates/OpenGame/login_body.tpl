

<script type="text/javascript">

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}


function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function Ajax(datei) {
 var xhReq = new XMLHttpRequest();
 xhReq.open("GET", datei, false);
 xhReq.send(null);
 var serverResponse = xhReq.responseText;
 document.getElementById("content").innerHTML = serverResponse;
}
function dotb(title, url)
{
$(document).ready(function(){ tb_show(title, url, null); });
}

</script>
</head>
<body class="loginbody">
<div>
<!--Login_body.tpl Copyright by SteggSoft-Germany for Xnova Reloaded-->
<div align="center">
	<table width="100%" align="center" border="0" cellpadding="1" cellspacing="1">
		<tr>
			<td style="text-align:center">
				<a href="index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','images/login/home2.gif',1)"><img src="images/login/home1.gif" alt="Startseite" name="Image16" width="235" height="35" border="0" id="Image16"></a>
				<a href="#" onClick="Ajax('regeln.php');"  onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','images/login/regeln2.gif',1)"><img src="images/login/regeln1.gif"  alt="Regeln" name="Image17" width="235" height="35" border="0" id="Image17"></a>
				<a href="http://www.xnova-reloaded.de" target="_blank" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image18','','images/login/forum2.gif',1)"><img src="images/login/forum1.gif" alt="Forum" name="Image18" width="235" height="35" border="0" id="Image18"></a>
			 <!--<a href="banned.php" target="_blank" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image22','','images/login/pranger1.jpg',1)"><img src="images/login/pranger2.jpg" alt="Gesperrte User" name="Image22" width="120" height="30" border="0" id="Image22"></a> -->
			  
			  <a href="#" onClick="Ajax('impressum.php');" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image21','','images/login/impressum2.gif',1)"><img src="images/login/impressum1.gif" alt="Impressum" name="Image21" width="235" height="35" border="0" id="Image21"></a>
		  </td>	
		</tr>
	</table>
</div>

	
	<table width="100%" border="0" cellspacing="10" cellpadding="0">
		<tr>
			<td width="205" valign="top">
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="transparent">
					<tr>
						<td><img border="0" src="images/login/registrieren.gif" width="205" height="35" alt="registrieren"></td>
					</tr>
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20">&nbsp;</td>
									<td width="205">
										<div align="center">
											<font class="mittel"><br>{left_title}</font>
										</div><br>
										<form name="form" action="" id="form">
											<div align="center">
											 <a href="reg.php?height=400&amp;width=700" class="thickbox" title="Registrierung">{Register}</a>
											</div>
										</form>
																			</td>
									<td width="20">&nbsp;</td>
								</tr>
							</table>						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><img border="0" src="images/login/game_status.gif" width="205" height="35" alt="status"></td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
						<tr>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="205">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="5">&nbsp;</td>
												<td width="70"><font class="mittel" size="-2" color="#E3F8E6">{players_online}</font></td>
												<td width="70"><font class="mittel" face="Verdana, Arial, Helvetica, sans-serif" size="1">{online_users}</font></td>
												<td  width="5">&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td width="5">&nbsp;</td>
												<td width="70"><font class="mittel" size="-2" color="#E3F8E6">{newest_player}</font></td>
												<td width="70"><font class="mittel" face="Verdana, Arial, Helvetica, sans-serif" size="1">{last_user}</font></td>
												<td width="5">&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td width="5">&nbsp;</td>
												<td width="70"><font class="mittel" size="-2" color="#E3F8E6">{registred_players}</font></td>
												<td width="70"><font class="mittel" face="Verdana, Arial, Helvetica, sans-serif" size="1">{users_amount}</font></td>
												<td width="5">&nbsp;</td>
											</tr>
											<tr>
													<td><br></td>
											</tr>
											</table>										</td>
									</tr>
									<tr>
										<td><img border="0" src="images/login/server_status.gif" width="205" height="35" alt="serverstatus"></td>
									</tr>
								</table>							</td>
						</tr>
							{status}
							{reason}
				</table>			</td>
		  <td width="100%" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><table>
                  <tr>
                    <td width="20">&nbsp;</td>
                    <td width="1000" valign="top" id="inhalt">
						<div id="content" align="center">
						</div>
                        </td>
                    <td width="20">&nbsp;</td>
                  </tr>
              </table></td>
            </tr>
            <tr>
              <td><center>
              </center></td>
            </tr>
          </table></td>
			<td width="60" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="transparent">
					<tr>
						<td><img border="0" src="images/login/login.gif" width="205" height="35" alt="login"></td>
					</tr>
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">

								<tr>
									<td width="20">&nbsp;</td>
									<td width="120">
										<form name="formular" action="" method="post" onSubmit="changeAction('login');">
											<input type="hidden" name="timestamp" value="1173621187">
											<input type="hidden" name="v" value="2">
											<img src="images/login/user.png" border="0" alt="user"><br>
											<input class="mittel" name="username" tabindex="1" style="background-color:#555555" type="text" value=""><br>
											<img src="images/login/passwort.png" border="0" alt="passwort"><br>
											<input class="mittel" name="password" tabindex="2" style="background-color:#555555" type="password" value="">
											  <br>
											  <a class="mittel" href="lostpassword.php">{lost_password}</a>
											  <br>
											  <br>
											  <select class="mittel" tabindex="3" name="Uni">
											    <option value="no">{select_universe}</option>
											    <option value="Testuni1">Testuni 1</option>
										        </select>
											  <br>
											<p  class="mittel" style="color:#FF0000; font-weight:bold">{no_universe_selected}</p>
											<div align="center"><br>
												<input type="image" name="imageField2" src="images/login/go.gif">
											</div>
										</form>									</td>
									<td width="20">&nbsp;</td>
								</tr>
							</table>						</td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="transparent">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><img border="0" src="images/login/news.gif" width="205" height="30" alt="news"></td>
					</tr>
					<tr>
						<td><br></td>
					</tr>          
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="transparent">
								<tr>
									<td width="20">&nbsp;</td>
									<td class="mittel" width="120">Hier die News einbinden</td>
									<td width="20">&nbsp;</td>
								</tr>
							</table>						</td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
				</table>
	
				<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="transparent">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td><img border="0" src="images/login/foren.gif" width="205" height="35" alt="foren"></td>
					</tr>
					<tr>
						<td><br></td>
					</tr>
					<tr>
						<td>
							<table width="100%" border="0" cellspacing="0" cellpadding="0" class="transparent">
								<tr>
									<td width="20">&nbsp;</td>
									<td width="120">
										<div align="center" class="mittel">Foren</div>
										<form name="form" action="">
											<select  class="mittel" name="jumpMenu" onChange="MM_jumpMenu('parent',this,0)">
												<option value="#">Game Forum Ausw&auml;hlen</option>
												<option value="http://www.xnova-reloaded.de">Xnova-Reloaded</option>
											</select>
										</form>									</td>
									<td width="20">&nbsp;</td>
								</tr>
							</table>						</td>
					</tr>
					<tr>
						<td><br><center><a href="http://validator.w3.org/check?uri=referer"><img
        src="http://www.w3.org/Icons/valid-html401"
        alt="Valid HTML 4.01 Transitional" height="31" width="88"></a></center>
</td>
					</tr>
				</table>			</td>
		</tr>
	</table>

    <div align="center" class="mittel">Copyright &copy; 2009</div>
