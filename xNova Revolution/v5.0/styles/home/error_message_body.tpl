{if !$getajax}{include file="index_top.tpl"}{/if}
        <form name="lostpassword" action="index.php?page=lostpassword&mode=send&lang={$lang}" method="post">
		<div id="loginwrapper">
		        	 
			<div class="textLeft">
	            <h2>{$fcm_info}</h2>
		
     			<label for="character">{$mes}</label>

				<br>
				
        	</div>
            <br class="clear" />

        </div>
		</form>
{if !$getajax}{include file="index_footer.tpl"}{/if}