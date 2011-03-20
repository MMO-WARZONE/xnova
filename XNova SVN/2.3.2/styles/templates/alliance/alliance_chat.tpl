<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript">
var tiempoRecarga = 3000; // 3seg
recargaChat();
setInterval("recargaChat()",tiempoRecarga);

function recargaChat() {
    $.post("log/class.chatajax.php?id={ally_id}&date={time}",
           {
        funcion: "refrescar",
        },
        function(data){
            $('#chatwindow').html(data);
                               
        });
}

function enviarChat(){
    if($("#text").val()!=''){
    $.post("log/class.chatajax.php?id={ally_id}&date={time}",{
        funcion: "send",
        nick:$("#nick").val(),
        mensaje:$("#text").val() 
        },
        function(data){
            recargaChat();
    });
    $("#text").val('');
    }
}
function noNumbers(e)
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
if(keynum==13){
    enviarChat();
}

}
</script>

</script>
<style type="text/css">
    strong{
        font-size: x-small;
    }
    g{
        font-size: small;
    }
</style>
<div id="content">
    <table>
    <tr><td colspan=1><div id="chatwindow" style="width:500px; height:300px; overflow:auto"></div></td><td>{chat_list}</td></tr>
    <tr><td colspan=2><label for="nick"><input id="nick" size="10" name="nick" readonly  type="text" value="{username}" /></label>
    <label for="mensaje"><input id="text" name="mensaje"  type="text" value="" size="40" onkeypress="noNumbers(event)" /></label>
    <input type="button" onclick="enviarChat()" value="Enviar" /></td></tr>
    </table>
</div>
