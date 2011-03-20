<div id="register_content">
	<span id="float_ie6"></span>
	<div id="register_infotext">
		<p>Para que possas jogar, tens de criar o teu <em>Utilizador</em>, escolher uma <em>Password</em> e introduzir o teu <em>E-Mail</em>.</p>
	</div>
	<div id="critical_error_box" style="display:none;"></div>
	<div id="registerForm_container">
		<form method="post" action="reg.php" name="reg" id="reg">
		<div id="inputform_container">
			<label for="inputform_klein_spielername">Utilizador:</label>
			<input onClick="play('enterTextfield');" id="inputform_klein_spielername" class="inputform_klein" name="character" type="text" onKeyDown="play('typing')" alt="Spielername" maxlength="20" tabindex="5" value="" onkeyup="printMessage(checkUsername());" onblur="printMessage(checkUsername());" />
	            <label for="inputform_klein_email">E-Mail:</label>
			<input onClick="play('enterTextfield');" id="inputform_klein_email" class="inputform_klein" name="email" type="text" onKeyDown="play('typing')" alt="emailadresse" maxlength="50" tabindex="6" value="" onkeyup="printMessage(checkEmail());" onblur="printMessage(checkEmail());" />
                	
			<label for="inputform_klein_passwort">Password:</label>
			<input onClick="play('enterTextfield');" id="inputform_klein_passwort" class="inputform_klein" name="passwrd" onKeyDown="play('typing')" type="password" alt="Passwort" maxlength="32" tabindex="7" onkeyup="printMessage(checkPassword());" onfocus="printMessage(checkPassword());" onblur="printMessage(checkPassword());" />
                    
			<label for="uni_url" id="uni_label">Universo:</label>
			<div class="inputform_klein_universum_bg">
				<select name="uni_url" class="inputform_klein_universum">
        
						<option value="uni1.ogame.org">
					1. Universo ALFA							</option>
	        
						<option value="uni2.ogame.org">
					2. Universo BETA							</option>
	        
						<option value="uni3.ogame.org">
					3. Universo CHARLIE							</option>
	        
						<option value="uni4.ogame.org">
					4. Universo DELTA							</option>
	        
						        
					</select> 
			</div>
			<div class="clearfloat"></div>
		</div>
		<div id="agb_container">  
			<input type="checkbox" name="rgt" id="rgt" onMouseDown="play('checkbox')" tabindex="9">Eu aceito as <a class="register_agb" href="http://impressum.gameforge.de/index.php?lang=en&art=tac&special=&&f_text=8e8e8e&f_text_hover=ffffff&f_text_h=8e8e8e&f_text_hr=ffffff&f_text_hrbg=061229&f_text_hrborder=26324c&f_text_font=verdana%2C+arial%2C+helvetica%2C+sans-serif&f_bg=000000" target='_TAC'>REGRAS</a> de funcionamento do Xnova PTBEST</input>
		</div>
		</form>
	</div>
	<div id="registrieren_button" onclick="play('bigClick'); changeAction('register','reg'); document.forms['reg'].submit();" onMouseOver="play('bigHover')"><a href="#" tabindex="10">Registar!</a></div>
</div>