<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>XNova Redesigned</title>
	
    <link rel="stylesheet" type="text/css" media="screen"	href="css/styles.css"/>
    <link rel="shortcut icon" 	type="image/x-icon" 			href="favicon.ico">
	<!--[if lt IE 7]>
    	<style type="text/css"> @import url(css/xnova_ie.css);</style>
  	<![endif]-->
    <!--[if gte IE 6]>
        <style type="text/css"> @import url(css/xnova_ie7.css);</style>
  	<![endif]--> 
  	<link rel="stylesheet" type="text/css" href="css/xnova_thickbox.css" media="screen" />
  	<link rel="stylesheet" type="text/css" href="css/xnova_errorbox.css" media="screen" />

    <script	type="text/javascript" src="js/xnova_Content.js"></script>
    <script type="text/javascript" src="js/xnova_soundmanager2.js"></script>
    <script type="text/javascript">var sound = true;</script>

	<script type="text/javascript">
		var locaUniverse = "universe";
		var language = "en";
		var locaAllError = "Error";
    	var locaAllOk = "Ok";
    	errorsByBox = new Array();
    	errorsByBox["-1"] = "Your request could not be answered by the universe! Please try again in a few minutes.";
    	errorsByBox[1] = "Your username or password is wrong!";
    	    	
		function printMessage(code, div)
		{
			switch (code)
			{
				case "1":
					text = "O Utilizador deve ser entre 3 e 20 caracteres!";
					divContainer = "spielername_error";
					break;
				case "2":
					text = "Necessitas de inserir um E-Mail válido!"; 
					divContainer = "email_error";
					break;
				case "nr21":
					text = "Esse Utilizador já se encontra em uso."; 
					divContainer = "spielername_error";
					break;
				case "nr23":
					text = "The nickname  is not within the length margins or it contains characters that are not valid. You will be automatically suggested a valid nickname."; 
					divContainer = "spielername_error";
					break;
				case "nr24":
					text = "Your E-Mail address is already in use!"; 
					divContainer = "email_error";
					break;
				case "nr25":
					text = "The E-Mail address is not valid!"; 
					divContainer = "email_error";
					break;
				case "nr26":
					text = "You need to read and agree with the Terms and Conditions before playing!"; 
					divContainer = "agb_error";
					break;
				case "nr27":
					text = "You did not enter a password. Please enter a password for your own accounts security."; 
					divContainer = "passwort_error";
					break;
				case "nr28":
					text = "The password you entered is too long (20 characters max.)"; 
					divContainer = "passwort_error";
					break;
				case "nr29":
					text = "The password you entered is too short (8 characters min.)"; 
					divContainer = "passwort_error";
					break;
				case "nw7":
					text = "Currently this universe is full. New accounts cannot be registered at the moment."; 
					divContainer = "universum_error";
					break;
				case "nr30":
					text = "You have already registered accounts from this IP address!"; 
					divContainer = "universum_error";
					break;
				default:
					text = "";
					break;
			}
			
			if(div == null && typeof(divContainer) != "undefined")
			{
				div = divContainer;
			}
			
			if(div != null)
			{
				document.getElementById(div).innerHTML = text;
			}
		}
		
		function setLoginCookies() {
			set_cookie('uni_selected_'+document.forms["loginForm"].uni_id.value,1,1234919638+1209600); 
			set_cookie('uni_user',document.forms["loginForm"].login.value,1234919638+604800); 
			set_cookie('uni_lastLogin',document.forms["loginForm"].uni_id.value,1234919638+604800);
		}
	</script>
	<script type="text/javascript" src="js/xnova-1.2.6.min.js"></script>
    <script type="text/javascript" src="js/xnova_main.js"></script>
    <script type="text/javascript" src="js/xnova_thickbox.js"></script>
    <script type="text/javascript" src="js/xnova_errorbox.js"></script>
</head>

<body>
	<div id="overlay_seite"></div>
    <div id="fenster">
    	<h1><span id="fenster_header"></span></h1>
    	<div id="schliessen"><a href="#" id="schliessen_link" onClick="play('defaultClick'); showHideTrailerBox(); setTimeout('closeWindow()', 200); return false;"></a></div>
    	<div id="fenster_content_bg">
        	<div id="fenster_content_container">
        		<div id="fenster_content">
    			</div>
    		</div>
    	</div>
    	<div id="fenster_fuss"></div>
    </div>
	<div id="netzwerkleiste">
    			<div id="mute_button" onMouseOver="showMuteButtonHover(1); play('defaultHover');" onMouseOut="showMuteButtonHover(0);" onMouseDown="play('defaultClick'); toggleMuteAll();"></div>
    </div>
    <div id="content">
        <div id="flash_oben">
			  <script type="text/javascript">AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','568','height','396','FlashVars', 'movieurl=http://ogame.org/flash/', 'title','flash_header','wmode', ermittleWmode(), 'src','flash/header_anim_nosound','quality','high','bgcolor','#000000','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie', 'flash/header_anim_nosound', 'name' , 'flash_header' ); //end AC code</script>
              <noscript>
              <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" name="flash_header" width="568" height="396" id="flash_header" title="flash_header">
                <param name="movie" value="flash/header_anim_nosound.swf"/>
                <param name="quality" value="high"/>
                <param name="FlashVars" value="movieurl=http://ogame.org/flash/">
				<embed FlashVars="movieurl=http://ogame.org/flash/" src="flash/header_anim_nosound.swf" width="568" height="396" bgcolor="#000000" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" name="flash_header"></embed>
              </object>
          </noscript> 
        </div>
  		<div id="menu_links_container">
            <ul id="menu_links">
                <li class="stepdown">
                    <a href="#" onMouseOver="play('defaultHover', -80);"  onClick="play('defaultClick',-80); ajaxImport('about.html');setFensterHeader('About Xnova');return false;"class="button_left_menu">Sobre Xnova</a> 
                </li>
                <li class="stepdown">
                    <a href="#" onMouseOver="play('defaultHover', -80);" onClick="play('defaultClick',-80); ajaxImport('screenshots.html');setFensterHeader('Screenshots');return false;" class="button_left_menu">Imagens</a>
                </li>
                <li class="stepdown">
                    <a href="#"  onMouseOver="play('defaultHover', -80);" onClick="play('defaultClick',-80); ajaxImport('register_new.php');setFensterHeader('Bem-vindo ao Universo PTBEST!');return false;" class="button_left_menu">Regista-te JÁ!</a>
                </li>
                <li class="stepdown">
                    <a href="http://board.ogame.org" onMouseOver="play('defaultHover', -80);" onClick="play('defaultClick',-80)" class="button_left_menu" target="_blank">Fórum</a>
                </li>
                <li class="stepdown">
                    <a href="#" onMouseOver="play('defaultHover', -80);" onClick="play('defaultClick',-80); ajaxImport('team.html');setFensterHeader('The OGame-Team');return false;" class="button_left_menu">Team</a>
                </li>
            </ul>
        	<div id="menu_links_fuss"></div>
        </div>
		                <a class="anmelden_button" onMouseOver="play('bigHover');">XNOVA PTBEST</a>
        <div id="flash_trailer_hintergrund">
          <script type="text/javascript">AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','378','height','224','title','trailer','wmode', 'opaque','FlashVars', 'movieurl=http://dlcl.gfsrv.net/ogame/','src','flash/flash_trailer','quality','high','bgcolor','#000000','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','flash/flash_trailer' ); //end AC code</script>
  			<noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="378" height="224" title="trailer">
            <param name="movie" value="flash/flash_trailer.swf" />
            <param name="quality" value="high" />
            <param name="FlashVars" value="movieurl=http://dlcl.gfsrv.net/ogame/">
            <embed FlashVars="movieurl=http://dlcl.gfsrv.net/ogame/" src="flash/flash_trailer.swf" bgcolor="#000000" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="378" height="224"></embed>
         </object></noscript>  
        </div>
        <div id="hauptinfo">
        	<div id="hauptinfo_hintergrund">
        		<p class="hauptinfo_text"><em>Xnova PTBest</em> é um jogo de estratégia espacial. Milhares de jogadores pelo mundo fora tentam ser o senhor supremo da gálaxia! Somente necessitas de uma ligação à internet para poderes jogar.</p>
        							<a href="#" id="hauptinfo_news" onMouseOver="play('bigHover');" onClick="play('bigClick'); ajaxImport('register_new.php');setFensterHeader('Bem-vindo ao Xnova PTBest!');return false;" >Regista-te JÁ!!!</a>			
				            </div>
            <div id="hauptinfo_fuss"></div>
            <div id="rechtliches_container">
                <ul id="rechtliches">
                    <li class="stepdown">
                        <a onMouseOver="play('smallHover', -60);" onClick="play('smallClick', -60)" href="http://impressum.gameforge.de/index.php?lang=en&art=tac&special=&&f_text=8e8e8e&f_text_hover=ffffff&f_text_h=8e8e8e&f_text_hr=ffffff&f_text_hrbg=061229&f_text_hrborder=26324c&f_text_font=verdana%2C+arial%2C+helvetica%2C+sans-serif&f_bg=000000"  id="rechtliches_agb" target='_TAC'>T&C`s</a>
                    </li>	
                    <li class="stepdown">
                        <a onMouseOver="play('smallHover', -30);" href="#"  id="rechtliches_regeln" onClick="play('smallClick', -30); ajaxImport('rules.html');setFensterHeader('Rules');">Regras</a>
                    </li>
                    <li class="stepdown">
                        <a onMouseOver="play('smallHover', 30);" onClick="play('smallClick', 30)" href="http://impressum.gameforge.de/index.php?lang=en&art=impress&special=&&f_text=8e8e8e&f_text_hover=ffffff&f_text_h=8e8e8e&f_text_hr=ffffff&f_text_hrbg=061229&f_text_hrborder=26324c&f_text_font=verdana%2C+arial%2C+helvetica%2C+sans-serif&f_bg=000000"  id="rechtliches_impressum" target='_TAC'>Imprint</a>
                    </li>
                    <li class="stepdown">
                        <a onMouseOver="play('smallHover', 60);" href="#"  id="rechtliches_credits" onClick="play('smallClick', 60); ajaxImport('credits.html');setFensterHeader('Credits');">Créditos</a>
                    </li>
                </ul>
            </div>
            <div id="copyright">&copy; 2008 by <a href="http://www.ptbest" target="blank">Xnova PTBest</a>. Todos os direitos reservados.</div>
        </div>
        <div id="menu_rechts">
			<form action="login.php" method="post" name="formular" id="loginForm">
                <input type="hidden" name="uni_id" value="">       
                <input type="hidden" name="v" value="2">
				<input type="hidden" name="is_utf8" value="0">                
                <div id="input_universe">
                	<select name="uni_url" id="uni_select_box" class="input_universe_select" tabindex="1">
                		<option value="uni1.ogame.org" onClick="setUniID('1'); setPasswordlostUrl('uni1.ogame.org');" >1. Universo ALFA</option>
                		<option value="uni2.ogame.org" onClick="setUniID('2'); setPasswordlostUrl('uni2.ogame.org');" >2. Universo BETA</option>
                		<option value="uni3.ogame.org" onClick="setUniID('3'); setPasswordlostUrl('uni3.ogame.org');" >3. Universo CHARLIE</option>
                		<option value="uni4.ogame.org" onClick="setUniID('4'); setPasswordlostUrl('uni4.ogame.org');" >4. Universo DELTA</option>
                	</select>
                </div>
                <div id="input_background">
                    <input type="text" name="username" id="inputform" alt="Utilizador" value="" maxlength="20" tabindex="2" onClick="play('enterTextfield', 80); if(this.value == 'Utilizador') this.value = '';" onBlur="if(this.value == '') this.value= 'Utilizador';" onKeyDown="play('typing', 80)"/>
                </div>
                <div id="passwort_background">
                    <input type="password" name="password" id="passwort" alt="Password" value="" maxlength="32" tabindex="3" onClick="play('enterTextfield', 80);" if(this.value == 'Password') this.value = '';" onBlur="if(this.value == '') this.value= 'Password';" onKeyDown="play('typing', 80)">
                </div>
                <p class="pw_vergessen"><a href="#" onMouseOver="play('defaultHover', -80);" onClick="play('defaultClick',-80); ajaxImport('pass.php');setFensterHeader('Recuperar Password');return false;">Perdeste a Password?</a></p>
                <input type="submit" name="submitInput" id="login_button" onMouseOver="play('bigHover', 80);" onClick="play('bigClick', 80);" tabindex="4" value="Entrar" />
			</form>
        </div>
	</div>
</body>
</html>

<div id="notifyTB" style="display: none;">
	<div class="errorBox">
		<h3 id="errorBoxNotifyHead">-</h3>
		<div class="body">
			<p class="message" id="errorBoxNotifyContent">-</p>
			<div class="spacer">
	            <a href="#" onclick="handleErrorBoxClick('ok'); return false;" class="okButton">
	            	<span id="errorBoxNotifyOk">-</span>
	            </a>
	        </div>
	    </div>
	    <div class="footer"></div>    
	</div><!-- errorBox -->
</div>
<script type="text/javascript" src="js/xnova_mootools.js"></script>
<script type="text/javascript" src="js/xnova_slimbox.js"></script>
