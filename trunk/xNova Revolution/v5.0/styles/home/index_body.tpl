{if !$getajax}{include file="index_top.tpl"}{/if}  
  <form method="post" name="xnovarevolution">
        <div id="loginwrapper">
		        	 
			<div class="textLeft">
	            <h2>{$welcome_to} {$servername} - {$login}</h2>
		
				<label for="universe">{$universe}</label>
        		<select name="universe" id="universe">
				{html_options options=$AvailableUnis selected=$UNI}
				</select>
				
				<label for="username">{$user}</label>
        		<input type="text" name="username" id="username" tabindex="1" class="input" />
				
				<label for="password">{$pass}</label>
        		<input type="password" name="password" id="password" tabindex="1" class="input" />
				
    	    	<input type="submit" value="{$login}" name="submit" tabindex="2" class="start" />
				<br>
				<a onclick="ajax('?page=reg&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$register_now}</a> || <a onclick="ajax('?page=lostpassword&amp;'+'getajax=1&amp;'+'lang={$lang}');" style="cursor:pointer;">{$lostpassword}</a>
				<br>
				{if $fb_active}<br><br><a href="javascript:void(0);" onclick="loginFB(); return false;"><img src="http://b.static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif" alt=""></a>{/if}
        	</div>
    	    <div id="advice">
        		<p>{$server_description}</p>
	        </div>
			<div id="inforow">
			<br><br><br><br>{foreach item=InfoRow from=$server_infos}<li><strong>{$InfoRow}</strong></li>{/foreach}
			</div>
            <br class="clear" />

        </div>
    </form>
 {if !$getajax}{include file="index_footer.tpl"}{/if}