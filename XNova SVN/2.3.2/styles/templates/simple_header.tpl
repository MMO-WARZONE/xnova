<html>
<head>
<title>{-title-}</title>
{-favi-}
{-style-}
{-meta-}
	<link  rel="stylesheet"  type="text/css" href="./styles/css/ui.all.css">
	<script type="text/javascript" src="./scripts/jquery.js"></script>
	<script type="text/javascript" src="./scripts/ui.core.js"></script>
	<script type="text/javascript" src="./scripts/ui.dialog.js"></script>
	<script type="text/javascript" src="./scripts/jquery.bgiframe.js"></script>
<script type="text/javascript">
	$(function() {
		$("#dialog").dialog({
			bgiframe: true,
                        autoOpen: false,
			modal: true,
                        height: 'auto',
                        width:  'auto',
                        title: 'Enviar Mensaje',
			buttons: {
				Enviar: function() {
					if($("#dialog #id").val()==''){
                                            $("#dialog").html('<table width="519"><tr><th class="c" colspan="2">Error: ID vacio</th></tr></table>');
                                        }else if($("#dialog #text").val()==''){
                                            $("#dialog").html('<table width="519"><tr><th class="c" colspan="2">Error: Mensaje Vacio</th></tr></table>');
                                        }else if($("#dialog #subject").val()==''){
                                            $("#dialog").html('<table width="519"><tr><th class="c" colspan="2">Error: Asunto</th></tr></table>');
                                        }else{
                                            $.post("game.php?page=messages&mode=write", {
                                            id: $("#dialog #id").val(),
                                            text:$("#dialog #text").val(),
                                            subject:$("#dialog #subject").val()
                                            },
                                            function(data){
                                                $("#dialog").html('<table width="519"><tr><th class="c" colspan="2">Mensaje Enviado</th></tr></table>');
                                                setTimeout('$("#dialog").dialog("close")',2000);
                                            });
                                        }
                                                                                
                                }                               
			}
		});
	});
        function new_mensaje(to,id,asunto,texto){
            $("#dialog").dialog("open");
            $("#dialog #to").val(to);
            $("#dialog #id").val(id);    
            $("#dialog #subject").val(asunto);
            $("#dialog #text").val(texto);
        }
	</script>
</head>
<body style="overflow: hidden;">  
<div id="dialog" style="background-image: url(./styles/images/background.jpg)" >
    <script src="scripts/cntchar.js" type="text/javascript"></script>
    <table width="519">
        <input type="hidden" id='id' value="" >
        <tr>
            <th>Destinatario</th>
            <th><input type="text" id='to' name="to" size="40" value=""/></th>
        </tr><tr>
            <th>Asunto</th>
            <th><input type="text" id="subject" name="subject" size="40" maxlength="40" value="{subject}" /></th>
        </tr><tr>
            <th>Mensaje (<span id="cntChars">0</span> / 5000 caracteres)</th>
            <th><textarea id='text' name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
        </tr>
    </table>
</div>