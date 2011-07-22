{if !$getajax}{include file="index_top.tpl"}{/if}
{if $game_captcha}<script type="text/javascript">if(typeof $ == "undefined") 
{
        recaptchaload = true;
} else { 
        $(document).ready(function(){ showRecaptcha(); });
}</script>{/if}
        <form name="reg" action="?page=reg&mode=send&lang={$lang}" method="post">
		<div id="loginwrapper">
		        	 
			<div class="textLeft">
	            <h2>{$servername} - Registro</h2>
		
				<label for="universe">{$uni_reg}</label>
        		<select name="universe" id="universe">
            {html_options options=$AvailableUnis selected=$UNI}
			</select>
				
				<label for="character">{$user_reg}</label>
        		<input type="text" name="character" id="character" tabindex="1" class="input" />
				
				<label for="password">{$pass_reg}</label>
        		<input type="password" name="password" id="password" tabindex="1" class="input" />
				
				<label for="password2">{$pass2_reg}</label>
        		<input type="password" name="password2" id="password2" tabindex="1" class="input" />
				
				<label for="email">{$email_reg}</label>
        		<input type="text" name="email" id="email" tabindex="1" class="input" />
				
				<label for="email2">{$email2_reg}</label>
        		<input type="text" name="email2" id="email2" tabindex="1" class="input" />
											
				<label for="planet">{$planet_reg}</label>
        		<input type="text" name="planet" id="planet" tabindex="1" class="input" />
				
				<label for="lang">{$lang_reg}</label>
        		<select name="lang" id="lang">
            {html_options options=$AvailableLangs selected=$lang}
				</select>
			
			{if $game_captcha}
			<label for="captcha">{$captcha_reg}</label>
			<label for="captcha"><a href="javascript:Recaptcha.reload()">{$captcha_reload}</a></label>
	<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">{$captcha_get_audio}</a></div>
	<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">{$captcha_get_image}</a></div>
        	<label for="captcha"><a href="javascript:Recaptcha.showhelp()">{$captcha_help}</a></label>
			<div id="display_captcha" style="display:none"><div id="recaptcha_image"></div><input type="text" id="recaptcha_response_field" size="30" maxlength="40" tabindex="7" name="recaptcha_response_field" class="input-text"></div>
			{/if}

				<input name="rgt" type="checkbox">{$accept_terms_and_conditions}
    	    	<input tabindex="2" class="start" type="submit" value="{$send}"/>
				<br>
				
        	</div>
            <br class="clear" />

        </div>
		</form>
{if !$getajax}{include file="index_footer.tpl"}{/if}