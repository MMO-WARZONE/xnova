{if !$getajax}{include file="index_top.tpl"}{/if}
        <form name="lostpassword" action="index.php?page=lostpassword&mode=send&lang={$lang}" method="post">
		<div id="loginwrapper">
		        	 
			<div class="textLeft">
	            <h2>{$lost_pass_title}</h2>
		
			<label for="universe">{$uni_reg}</label>
        		<select name="universe" id="Uni">
            {html_options options=$AvailableUnis selected=$UNI}
			    </select>
				
				<label for="character">{$email}</label>
        		<input type="text" name="email" id="email" tabindex="1" class="input" />
							
    	    	<input tabindex="2" class="start" type="submit" value="{$send}"/>
				<br>
				
        	</div>
            <br class="clear" />

        </div>
		</form>
{if !$getajax}{include file="index_footer.tpl"}{/if}