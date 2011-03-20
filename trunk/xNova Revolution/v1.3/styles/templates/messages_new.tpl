<br><br>
<div id="content">    
<img src="styles/images/headers/network.png">
            <div style="position: absolute; right: 160px;top: 8px; font-size: 16px" ><span class="Estilo2">Gestion de mensajes </span><font style="font-size:10px"></div><br />
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
      <th  valign="top"><table width="100%" align="center" >
        <!-- START BLOCK : message_type -->
        <tr>
          <td><a href="game.php?page=messages&mode=show&messcat={type}">{name}</a></td>
          <td id="{type}" >{total}</td>
	      <td align="center" valign="middle"><a href="javascript:delall({type})" title="{lang_deleteall}"><img src="styles/images/delete.gif" alt="{lang_deleteall}" border="0" /></a><a href="{PHPSELF}?mode=show&amp;messcat={type}"></a></td>
        </tr>
        <!-- END BLOCK : message_type -->
      </table></th>
      </tr>
    <tr>
      <th>Mensajes</th>
      </tr>
    <tr>
      <th id="lista" width="99%" valign="top">
          <!-- START BLOCK : message -->
        <div id="{id}">
        <table width="100%" align="center">
          <tr>
            <th colspan="2">Fecha</th>
            <th width="25%">De</th>
            <th width="40%">Asunto</th>
            <th width="5%"><a href="javascript:del({id})" title="{lang_mess_delete_this}"><img src="styles/images/delete.gif" alt="{lang_mess_delete_this}" border="0" /></a></th>
          </tr>
          <tr>
            <th colspan="2">{mdate}</th>
            <th>{from}</th>
            <th colspan="2">{subject}</th>
          </tr>
          <tr>
            <td width="11%" align="center" valign="top" class="b">
            <!-- START BLOCK : answer -->
            <a href="game.php?page=messages&mode=write&id={id}&subject={subject}" title="{lang_mess_answer}"><img src="styles/images/mp.gif" border="0" /></a>
            <!-- END BLOCK : answer -->            </td>
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
        
        function del(ids) {
            $.post("game.php?page=messages", {
                action: "delete",
                id: ids },
                   function(data) {
                    $("#" + ids).slideUp("fast", function(){
                            $("#" + ids).remove();
                        });
                });
        }
        
        function delall(cat){
            $.post("game.php?page=messages", {
                action: "deleteall",
                messcat: cat},
                   function(data) {
                    $("#" + cat).text('0');
                    $("#lista").remove();
                });
        }
        
        </script>
        </th>
    </tr>
</table>
<!-- START BLOCK : new_message -->
{new_message}
<!-- END BLOCK : new_message -->
</div>   
