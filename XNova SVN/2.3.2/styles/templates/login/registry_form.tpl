<form action="" name="reg_form" method="post">
    <div id="error"></div>
<center>
          <div id="title">  {register_at_reg} {servername}</div>

                    <div id="text1">
                    	<table>
                        	<tr>
                            	<td>{user_reg}:</td>
                                <td><input id="user" name="character" size="20" maxlength="20" type="text"></td>
                            </tr>
                        	<tr>
                            	<td>{pass_reg}:</td>
                                <td><input id="pass" name="passwrd" size="20" maxlength="20" type="password"></td>
                            </tr>
                        	<tr>
                            	<td>{email_reg}:</td>
                                <td><input id="email" name="email" size="20" maxlength="40" type="text"></td>
                            </tr>
			      <!-- START BLOCK : captcha -->
                              <tr>
					<td height="20" colspan="2">
                                            <div align="center">
                                            <img src="captcha.php" alt="CAPTCHA" /><br><input id="captch" type="text" name="captchastring" size="38" />
                                            </div>
                                        </td>
			      </tr>
                              <!-- END BLOCK : captcha -->
                        </table>
                    </div>
            		
			
			<div id="text2"><center><b>{accept_terms_and_conditions} <input name="rgt" type="checkbox"></b></center>
               		</div><br>	<div  class="bigbutton" onclick="document.reg_form.submit();">{register_now}</div>
</center>
</form>