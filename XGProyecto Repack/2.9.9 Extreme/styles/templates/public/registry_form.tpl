
<style type="text/css">
<!--
.wrapper #page #main .form form fieldset .login li label {
    color: #FFF;
}
.wrapper #page #main .form form fieldset .help li a {
    color: #FFF;
}
.wrapper #page #main #footer ul li a {
    color: #FFF;
}
.wrapper #page #main #footer p {
    color: #FFF;
}
-->
</style>
<div class="wrapper-guide">
            <div id="page">

                <div id="header">
                    <ul class="buttons">
                        <li><a href="index.php">{menu_index}</a></li>
                        <li class="skull"><a href="#"></a></li>

                        <li class="tour"><a href="{forum_url}" target="_blank">{forum}</a></li>
                    </ul>
                </div>
                <div id="main">

                    <div class="content-big">
<div class="register">
    <div class="form-reg">
        <form name="reg" action="reg.php" method="post" id="formID">
            
                <div class="left-col">
                    <ul class="login">

                        <li>
                            <label for="username">{user_reg}</label>
                            <div class="bg">
                              <input name="character" size="38" maxlength="20" type="text" class="textarea"/>
                            </div>
                        </li>
                        <li>

                            <label for="email">{email_reg}</label>
                            <div class="bg">
                            <td><input name="email" size="38" maxlength="20" type="text"></td>
                            </div>
                        </li>
                        <li>
                            <label for="userpass">{pass_reg}</label>
                            <div class="bg">
                            <input name="passwrd" size="38" maxlength="20" type="password" />
                            </div>
                        </li>

                    </ul>

          </div>
                <div class="right-col"><br><br><br>
                                    
                            <label for="universe">{universe} --:-- Race</label><br>
							<select name="universe" id="universe">
            <option value="index.php" >Andromeda</option>
			</select>
					
			   <th> 
                             <th><select name="raza">
                             <option value="humano">{id_race_1}</option>
                             <option value="vampiro">{id_race_2}</option>
                             <option value="lobo">{id_race_3}</option>
                             <option value="asgard">{id_race_4}</option>
                            </select></th></td>
                            </tr>
                               </th></td>
                            </tr>
                    
            
                            
                    <p class="agb-text"><br>
                            
                                <input class="agb-check" name="rgt" type="checkbox" />    
                                {accept_terms_and_conditions}</p>
                            

                    <input class="submit" type="submit" value="{send}" />

                </div>
            
        </form>
    </div>
</div>
<strong class="logo">{servername}</strong>

                    </div>


<div id="footer">
                        <p>Powered by <a href="http://www.xgproyect.net/" target="_blanck" title="XG Proyect {version}">XG Proyect {version}</a> &#169; 2008 - 2011.</p>
                        <ul>
                          <li><a href="?lang={$lng}"><img src="./styles/images/login/es.png" alt="" width="16" height="11"></a><br><br>
                          <p>{creditsdesing}</p>|<p> {creditsadapter}.</p>
                      </ul>
                    </div>
                </div>
            </div>
        </div> 