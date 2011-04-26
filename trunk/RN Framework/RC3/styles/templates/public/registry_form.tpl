<script type="text/javascript" src="scripts/generate.js"></script>
<form name="reg" action="" method="post">
    <div id="main">
        <div id="mainmenu" style="margin-top: 20px;">
            <a href="index.php">{index}</a>
            <a href="index.php?page=reg">{register}</a>
            <a href="index.php?page=agb">AGB</a>
            <a href="index.php?page=rules">Regeln</a>
            <a href="{forum_url}" target="_blank">{forum}</a>
        </div>
        <div id="rightmenu" class="rightmenu">
            <div id="title">{register_at_reg} {servername}</div>
            <div id="content">
                    <div id="text1">
                    	<table align="center" border="0px">
                        	<tr>
                            	<td>{user_reg}:</td>
                                <td><input name="character" size="20" maxlength="20" type="text"></td> 
								
							</tr>
                        	<tr>
                            	<td>{pass_reg}:</td>
                                <td><input name="passwrd" size="20" maxlength="20" type="password"></td>
                            </tr>
                        	<tr>
                            	<td>{email_reg}:</td>
                                <td><input name="email" size="20" maxlength="40" type="text"></td>
                            </tr>
                        </table>
                    </div>
            		<div id="register" class="bigbutton" onclick="document.reg.submit();">{register_now}</div>
            		<div id="text2">
                		<div id="text3" style="text-align:center;">
							{captcha}
							<br><b>{accept_terms_and_conditions} <input name="rgt" type="checkbox"></b>
               			 </div>
            		</div>
			</div>
		</div>
	</div>
</form>