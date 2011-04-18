<br />
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <td valign="top"><table width="90%" align="center">
        <tr>
          <td colspan="2" class="c">{lang_head_type}</td>
          <td width="24%" class="c">{lang_head_count}</td>
          <td width="22%" class="c">{lang_head_total}</td>
        </tr>
        <!-- START BLOCK : message_type -->
		<tr>
          <th width="5%" align="center" valign="middle"><a href="{PHPSELF}?action=deleteall&amp;messcat={type}" title="{lang_deleteall}"><img src="images/delete_small.png" alt="{lang_deleteall}" width="16" height="14" border="0" /></a><a href="{PHPSELF}?mode=show&amp;messcat={type}"></a></th>
          <th width="49%"><a href="{PHPSELF}?mode=show&amp;messcat={type}">{name}</a></th>
          <th>{unread}</th>
          <th>{total}</th>
        </tr>
		<!-- END BLOCK : message_type -->
      </table></td>
  	</tr>
	<tr>
	  <td height="10" valign="top"></td>
  	</tr>
	<tr>
	  <td width="99%" valign="top">
	  	<!-- START BLOCK : message -->
		<div id="{id}">
	    <table width="90%" align="center">
          <tr>
            <th colspan="2">Fecha</th>
            <th width="25%">De</th>
            <th width="40%">Asunto</th>
            <th width="5%"><a href="javascript:void(0);" onclick="javascript:del({id});" title="{lang_mess_delete_this}"><img src="images/delete.png" alt="{lang_mess_delete_this}" width="24" height="21" border="0" /></a></th>
          </tr>
          <tr>
            <th colspan="2">{mdate}</th>
            <th>{from}</th>
            <th colspan="2">{subject}</th>
          </tr>
          <tr>
            <td width="11%" align="center" valign="top" class="b">
			<!-- START BLOCK : answer -->
			<a href="messages.php?mode=write&amp;id={id}&amp;subject={subject}" title="{lang_mess_answer}"><img src="images/write.png" border="0" /></a>
			<!-- END BLOCK : answer -->			</td>
            <td colspan="5" class="b">{message}</td>
          </tr>
        </table>
		</div>
		<!-- END BLOCK : message -->
        <script src="scripts/jquery.js" language="javascript"></script>
		<script src="scripts/functions.js" language="javascript"></script>
		<script language="JavaScript" type="text/javascript">
		
		function f(target_url, win_name) {
			var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
			new_win.focus();
		}
		
		function del(id) {
			$.ajax({
				url: '{PHPSELF}', 
				processData: false,
				cache: false,
				type: 'POST', 
				dataType: 'html', 
				data: "action=delete&id=" + id,
				
				success: function(html) {
					$("#" + id).slideUp("fast", function(){	$("#" + id).remove(); });
				}
			});
		}
		
		</script>
		</td>
	</tr>
</table>
