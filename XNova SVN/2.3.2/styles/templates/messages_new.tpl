<input type="hidden" id="messages">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
	  <th class="anything"  valign="top">
		<table width="90%" align="center" >
        <!-- START BLOCK : message_type -->
		<tr>
		  <th width="1%" align="center" valign="middle"><a href="javascript:delall({type})" title="{lang_deleteall}"><img src="styles/images/delete_small.png" alt="{lang_deleteall}" width="16" height="14" border="0" /></a><a href="{PHPSELF}?mode=show&amp;messcat={type}"></a></th>
		  <th width="10%"><a href="game.php?page=messages&mode=show&messcat={type}">{name}</a></th>
		  <th width="1%">{unread}</th>
		  <th width="1%" id="{type}">{total}</th>
		</tr>
		<!-- END BLOCK : message_type -->
		</table>
	  </th>
  	</tr>
	 <!-- START BLOCK : show_message -->
	<tr>
		<th class="anything" id="lista" width="99%" valign="top">
			<table width="90%" align="center">
				<tr>
				  <th colspan="2">Fecha</th>
				  <th width="25%">De</th>
				  <th width="40%">Asunto</th>
				  <th width="5%">Opciones</th>
				</tr>
			  <!-- START BLOCK : message -->
				  <tbody id="{id}" width="100%">
					  <tr>
						  <th colspan="2">{mdate}</th>
						  <th>{from}</th>
						  <th >{subject}</th>
						  <th width="5%">
							<a onclick="del({id})" href="#" title="{lang_mess_delete_this}"><img src="styles/images/delete_small.png" alt="{lang_mess_delete_this}" width="16" height="14" border="0" /></a>
							{noread}
						  </th>
					  </tr>
				  </tbody>
				  <tbody id="{id}show" class="lightbox" style="display:none">
					<tr>
						  <th colspan="2">Fecha: {mdate}</th>
						  <th>Remitente: {from}</th>
						  <th >Asunto: {subject}</th>
						  <th width="5%"><img src="styles/images/close.png" onclick="cerrar_mensaje('{id}')" />	
						  </th>
					  </tr>
					<tr>
						<td class="anything" width="11%" align="center" valign="top" class="b">
							  <!-- START BLOCK : answer -->
							  <a onclick="new_mensaje('{from}','{id}','{subject}','')" href="#" title="{lang_mess_answer}"><img src="styles/images/write.png" border="0" /></a>
							  <!-- END BLOCK : answer -->			</td>
						  <th colspan="5" class="c">{message}</th>
					  </tr>
				  </tbody> 
			  <!-- END BLOCK : message -->
			</table>
		</th>
	</tr>
	<!-- END BLOCK : show_message -->
</table>
<script language="JavaScript" type="text/javascript">
		function del(ids) {
			$.post("game.php?page=messages", {
				action: "delete",
				id: ids },
				   function(data) {
					$("#" + ids).slideUp("fast", function(){
							$("tbody #" + ids).remove();
						});
				});
		}
		function delall(cat){
			$.post("game.php?page=messages", {
				action: "deleteall",
				messcat: cat},
				   function(data) {
					$("th #" + cat).text('0');
					$("#lista").remove();
				});
		}
		function abrir_mensaje(id,value){
			if(value==false){
				$.post("game.php?page=messages", {
				action: "show",
				id: id},
				   function(data){
					$('#messages').val(id);
					$('#'+id+'show').css("display","");
					$('#idmensaje').attr("src","./styles/images/read.png");
				});
			}else{
				$('#messages').val(id);
				$('#'+id+'show').css("display","");
			}
		}
		function cerrar_mensaje(id){
			$('#'+id+'show').css("display","none");
		}
		function control_mensaje(id,value){
                    if($('#'+id+'show').css("display")=="none"){
                          if($('#messages').val()){
                                cerrar_mensaje($('#messages').val());
                          }
                          abrir_mensaje(id,value);
                    }else{
                          cerrar_mensaje(id);
                    }
		}
</script>
