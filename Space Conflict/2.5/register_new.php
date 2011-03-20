
<!-- saved from url=(0033)http://ogame.org/register_new.php -->
<HTML><BODY><DIV id="register_content">
	<SPAN id="float_ie6"></SPAN>
	<DIV id="register_infotext">
		<P>In order to play you only have to enter a <EM>username</EM>, a <EM>password</EM> and an <EM>E-Mail address</EM> and proceed to read the terms and conditions before activating the check box about your agreement to them.</P>
		<P><EM>Username</EM> is the name you use as emperor at the universe. It is unique throughout the universe.</P>
	</DIV>
	<DIV id="critical_error_box" style="display:none;"></DIV>
	<DIV id="registerForm_container">
		<FORM name="registerForm" method="POST" action="">
		<DIV id="inputform_container">
			<LABEL for="inputform_klein_spielername">Username:</LABEL>
			<INPUT onclick="play(&#39;enterTextfield&#39;);" id="inputform_klein_spielername" class="inputform_klein" name="character" type="text" onkeydown="play(&#39;typing&#39;)" alt="Spielername" maxlength="20" tabindex="5" onkeyup="printMessage(checkUsername());" onblur="printMessage(checkUsername());" value="">
                
			<LABEL for="inputform_klein_email">E-Mail-Address:</LABEL>
			<INPUT onclick="play(&#39;enterTextfield&#39;);" id="inputform_klein_email" class="inputform_klein" name="email" type="text" onkeydown="play(&#39;typing&#39;)" alt="emailadresse" maxlength="50" tabindex="6" onkeyup="printMessage(checkEmail());" onblur="printMessage(checkEmail());" value="">
                	
			<LABEL for="inputform_klein_passwort">Password:</LABEL>
			<INPUT onclick="play(&#39;enterTextfield&#39;);" id="inputform_klein_passwort" class="inputform_klein" name="password" onkeydown="play(&#39;typing&#39;)" type="password" alt="Passwort" maxlength="32" tabindex="7" onkeyup="printMessage(checkPassword());" onfocus="printMessage(checkPassword());" onblur="printMessage(checkPassword());">
                    
			<LABEL for="uni_url" id="uni_label">Universe:</LABEL>
			<DIV class="inputform_klein_universum_bg">
				<SELECT name="uni_url" class="inputform_klein_universum">
        
						<OPTION value="uni28.ogame.org" style="color:#2eac40;font-weight:bold;font-size:10px;">
					28. (recommended)							</OPTION>
	        
						<OPTION value="uni42.ogame.org" style="color:#2eac40;font-weight:bold;font-size:10px;">
					42. (recommended)							</OPTION>
	        
						<OPTION value="uni1.ogame.org">
					1. Universe							</OPTION>
	        
						<OPTION value="uni2.ogame.org">
					2. Universe							</OPTION>
	        
						<OPTION value="uni3.ogame.org">
					3. Universe							</OPTION>
	        
						<OPTION value="uni4.ogame.org">
					4. Universe							</OPTION>
	        
						<OPTION value="uni5.ogame.org">
					5. Universe							</OPTION>
	        
						<OPTION value="uni6.ogame.org">
					6. Universe							</OPTION>
	        
						<OPTION value="uni7.ogame.org">
					7. Universe							</OPTION>
	        
						<OPTION value="uni8.ogame.org">
					8. Universe							</OPTION>
	        
						<OPTION value="uni9.ogame.org">
					9. Universe							</OPTION>
	        
						<OPTION value="uni10.ogame.org">
					10. Universe							</OPTION>
	        
						<OPTION value="uni11.ogame.org">
					11. Universe							</OPTION>
	        
						<OPTION value="uni12.ogame.org">
					12. Universe							</OPTION>
	        
						<OPTION value="uni13.ogame.org">
					13. Universe							</OPTION>
	        
						<OPTION value="uni14.ogame.org">
					14. Universe							</OPTION>
	        
						<OPTION value="uni15.ogame.org">
					15. Universe							</OPTION>
	        
						<OPTION value="uni16.ogame.org">
					16. Universe							</OPTION>
	        
						<OPTION value="uni17.ogame.org">
					17. Universe							</OPTION>
	        
						<OPTION value="uni18.ogame.org">
					18. Universe							</OPTION>
	        
						<OPTION value="uni19.ogame.org">
					19. Universe							</OPTION>
	        
						<OPTION value="uni20.ogame.org">
					20. Universe							</OPTION>
	        
						<OPTION value="uni21.ogame.org">
					21. Universe							</OPTION>
	        
						<OPTION value="uni22.ogame.org">
					22. Universe							</OPTION>
	        
						<OPTION value="uni23.ogame.org">
					23. Universe							</OPTION>
	        
						<OPTION value="uni24.ogame.org">
					24. Universe							</OPTION>
	        
						<OPTION value="uni25.ogame.org">
					25. Universe							</OPTION>
	        
						<OPTION value="uni26.ogame.org">
					26. Universe							</OPTION>
	        
						<OPTION value="uni27.ogame.org">
					27. Universe							</OPTION>
	        
						<OPTION value="uni29.ogame.org">
					29. Universe							</OPTION>
	        
						<OPTION value="uni30.ogame.org">
					30. Universe							</OPTION>
	        
						<OPTION value="uni31.ogame.org">
					31. Universe							</OPTION>
	        
						<OPTION value="uni32.ogame.org">
					32. Universe							</OPTION>
	        
						<OPTION value="uni33.ogame.org">
					33. Universe							</OPTION>
	        
						<OPTION value="uni34.ogame.org">
					34. Universe							</OPTION>
	        
						<OPTION value="uni35.ogame.org">
					35. Universe							</OPTION>
	        
						<OPTION value="uni36.ogame.org">
					36. Universe							</OPTION>
	        
						<OPTION value="uni37.ogame.org">
					37. Universe							</OPTION>
	        
						<OPTION value="uni38.ogame.org">
					38. Universe							</OPTION>
	        
						<OPTION value="uni39.ogame.org">
					39. Universe							</OPTION>
	        
						<OPTION value="uni40.ogame.org">
					40. Universe							</OPTION>
	        
						<OPTION value="uni41.ogame.org">
					41. Universe							</OPTION>
	        
						<OPTION value="uni43.ogame.org">
					43. Universe							</OPTION>
					</SELECT> 
			</DIV>
			<DIV class="clearfloat"></DIV>
			<DIV id="error_meldungen_container">
				<DIV id="spielername_err_box" class="error_text">
				    <DIV id="spielername_error"></DIV>
				</DIV>
				<DIV id="email_err_box" class="error_text">
				    <DIV id="email_error"></DIV>
				</DIV>
				<DIV id="passwort_err_box" class="error_text">
				    <DIV id="passwort_error"></DIV>
				</DIV>
				<DIV id="universum_err_box" class="error_text">
				    <DIV id="universum_error"></DIV>
				</DIV>
				<DIV id="agb_err_box" class="error_text">
				    <DIV id="agb_error"></DIV>
				</DIV>
			</DIV>
			
			<INPUT type="hidden" name="v" value="3">
			<INPUT type="hidden" name="step" value="validate">
			<INPUT type="hidden" name="kid" value="">
			<INPUT type="hidden" name="errorCodeOn" value="1">
			<INPUT type="hidden" name="is_utf8" value="1">
                     
		</DIV>
		<A class="besonderheiten_link" href="http://ogame.org/register_new.php#" tabindex="8" onmouseover="play(&#39;smallHover&#39;);" onclick="play(&#39;smallClick&#39;);
		            show_hide_menus(&#39;fenster&#39;);
		            show_hide_menus(&#39;overlay_seite&#39;);
		            show_hide_menus_visibility(&#39;flash_oben&#39;);
		            ajaxImport(&#39;unis.php&#39;);
		            setFensterHeader(&#39;Specials of the universes&#39;);">
            	Specials of the universes		</A>
		<DIV id="agb_container">  
			<INPUT type="checkbox" name="agb" onmousedown="play(&#39;checkbox&#39;)" tabindex="9">
		    I accept the		    <A class="register_agb" href="http://agb.gameforge.de/index.php?lang=en&art=tac&special=&&f_text=8e8e8e&f_text_hover=ffffff&f_text_h=8e8e8e&f_text_hr=ffffff&f_text_hrbg=061229&f_text_hrborder=26324c&f_text_font=verdana%2C+arial%2C+helvetica%2C+sans-serif&f_bg=000000" target="_TAC">
		        T&amp;C`s		    </A>
		
		</DIV>
		</FORM>
	</DIV>
	<DIV id="registrieren_button" onmouseover="play(&#39;bigHover&#39;)" onclick="play(&#39;bigClick&#39;);
	              changeAction(&#39;register&#39;,&#39;registerForm&#39;);
	              document.forms[&#39;registerForm&#39;].submit();">
	   <A href="http://ogame.org/register_new.php#" tabindex="10">
	       Join now!	   </A>
    </DIV>
</DIV></BODY></HTML>