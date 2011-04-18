<style type="text/css">
<!--
.Stil1 {color: #FF0000}
.Stil2 {color: #FFFFFF}
-->
</style>
<center><br /><br />
    <table width="650">
      <tbody>  
      <th width="126"><p><a href="forum/index.php" target="new">{log_forum}
		</a></p></th>
      <th width="126"><p><a href="banned.php" target="new">{log_banned}
		</a></p></th>		
      <th width="122"><p><a href="contact.php" target="new">{log_contac}</a></p></th>
      
	        <th width="126"><div align="center"><a href="reg.php" ><font color="orange">
				{Register}</a></div></th></font>
    </table><br />
<table width="440"><tbody><tr><td colspan="2" class="c"><span class="Stil1">{servername}</span></td>
</tr><tr><th rowspan="2" width="100"><object id="csSWF" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="240" height="176" codebase="http://active.macromedia.com/flash7/cabs/ swflash.cab#version=9,0,28,0">
                <param name="src" value="./animation/xampp.swf"/>
                <param name="bgcolor" value="#1a1a1a"/>
                <param name="quality" value="best"/>
                <param name="allowScriptAccess" value="1"/>
                <param name="allowFullScreen" value="true"/>
                <param name="scale" value="showall"/>
                <param name="flashVars" value="autostart=true"/>
                <embed name="csSWF" src="./animation/xampp.swf" width="240" height="176" bgcolor="#1a1a1a" quality="best" allowScriptAccess="always" allowFullScreen="true" scale="showall" flashVars="autostart=true" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed>
            </object></th><th><div align="left" class="news Stil2"><strong>{servername}</strong> {log_desc}</div></th>
</tr><tr><th><div align="left">{log_firefox_download} <a href="http://www.mozilla-europe.org/de/products/firefox/" align="right"><font color="yellow">{log_download}</a></font></div></th></tr></tbody></table>
    <table width="440" id="table1">
        <tr>
          <th width="100" style="text-align: left">
            <div align="left"><b><font color="#00cc00">Online: </font><span class="Stil2">{online_users}</span> </b></div></th>
          <th width="173" style="text-align: left"><font color="#00cc00">{log_user}</font><span class="Stil2">{last_user}</span></th>
          <th width="135" style="text-align: left"><font color="#00cc00">{log_max}</font><span class="Stil2">{users_amount}</span></th>
        </tr>
    </table>
    <table width="440">
      <tbody>
        <tr>
		<form name="formular" action="" method="post" onsubmit="changeAction('login');" style="margin-top: -9px; margin-left: 70px;"> <input name="timestamp" value="1173621187" type="hidden"><input name="v" value="2" type="hidden">

          <td colspan="2" class="c"><b><center><marquee direction="left" onmouseout="this.start()" onmouseover="this.stop()">{log_marque}</marquee></center></b></td>
        </tr>
        <tr>
          <th width="220"><div align="center"><a href="reg.php" ><font color="orange"><b>
				{log_reg}</a></div></th>
          <th width="220"><p><a href="lostpassword.php" ><font color="red"><b>{PasswordLost}</a></p></th><b></font>
        </tr>
          <th width="220">{User_name}</th>
          <th width="220"><input name="username" value="" type="text"></th>
        </tr>
          <th>{Password}</th>
          <th width="220"><input name="password" value="" type="password"></th>
      </tr>
      <th>{Remember_me}
          <input name="rememberme" type="checkbox"></th>
      <th width="220"><script type="text/javascript">document.formular.Uni.focus(); </script>
          <input name="submit" value="{Login}" type="submit">
          <label></label></th>
    </table>
</center>