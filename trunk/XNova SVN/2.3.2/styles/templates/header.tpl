<html>
<head>
<title>{-title-}</title>
{-favi-}
{-style-}
{-meta-}
<link rel="alternate" title="{game_name} - RSS FEED" href="rss.php" type="application/rss+xml" />

<!-- START BLOCK : scripts_header -->
<!--<link  rel="stylesheet"  type="text/css" href="./styles/css/ui.all.css">-->
<script src="scripts/cntchar.js" type="text/javascript"></script>

<script type="text/javascript" src="./scripts/jquery2.js"></script>
<!--<script type="text/javascript" src="./scripts/jquery.js"></script>
<script type="text/javascript" src="./scripts/ui.core.js"></script>
<script type="text/javascript" src="./scripts/ui.dialog.js"></script>
<script type="text/javascript" src="./scripts/jquery.bgiframe.js"></script>-->
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
                                            $("#error").html('<center><img src="./styles/images/loadingAnimation.gif" ></center>');
					if($("#dialog #id").val()==''){
                                            $("#error").html('<table width="519"><tr><th class="c" colspan="2">Error: ID vacio</th></tr></table>');
                                        }else if($("#dialog #text").val()==''){
                                            $("#error").html('<table width="519"><tr><th class="c" colspan="2">{mg_no_text}</th></tr></table>');
                                        }else if($("#dialog #subject").val()==''){
                                            $("#error").html('<table width="519"><tr><th class="c" colspan="2">{mg_no_subject}</th></tr></table>');
                                        }else{

                                           $.post("game.php?page=messages&mode=write&actions=0", {
                                           id: $("#dialog #id").val(),
                                           text:$("#dialog #text").val(),
                                           subject:$("#dialog #subject").val()
                                           },
                                           function(data){
                                                $("#error").html('<table width="519"><tr><th class="c" colspan="2">{mg_msg_sended}</th></tr></table>');
                                                setTimeout('$("#dialog").dialog("close")',2000);
                                                $("#error").html();

                                            });
                                        }                                        
                                }                               
			}
		});
	});
        function new_mensaje(to,id,asunto,texto){
            
            $("#dialog").html('<div id="error"></div>'+
            '<form action="#" ><input type="hidden" id="id" value="" >'+
            '<table width="519">'+
                '<tr>'+
                    '<th class="anything">{al_receiver}</th>'+
                    '<th class="anything"><input type="text" id="to" name="to" size="40" value=""/></th>'+
                '</tr><tr>'+
                    '<th class="anything">{mg_subject}</th>'+
                   '<th class="anything"><input type="text" id="subject" name="subject" size="40" maxlength="40" value="{subject}" /></th>'+
                '</tr><tr>'+
                    '<th class="anything">Mensaje (<span id="cntChars">0</span> / 5000 {bu_characters})</th>'+
                    '<th class="anything"><textarea id="text" name="text" cols="40" rows="10" size="100"  onkeyup="cntchar(5000)">{text}</textarea></th>'+
                '</tr>'+
            '</table></form>');
        
            $("#dialog").dialog("open");
            $("#dialog #to").val(to);
            $("#dialog #id").val(id);    
            $("#dialog #subject").val(asunto);
            $("#dialog #text").val(texto);
        }
	</script>


<!-- END BLOCK : scripts_header -->

</head>
<body style="overflow: hidden;">
<script type="text/javascript">
var browser=navigator.appName;var b_version=navigator.appVersion;var inter=b_version.split(";");var ie=inter[1].split(' ');if(browser!="Netscape"){if(ie[1]=="MSIE"&&ie[2]>"6"){alert("Xnova - Svn le recomienda usar Mozilla Firefox , Safari o Goggle Chrome con estos no tendras ningun problema de visualización");}}
</script>
<!-- START BLOCK : mensaje -->
<div id="dialog">
    
    
    
</div>
<!-- END BLOCK : mensaje -->

<!-- INCLUDE BLOCK : topnav -->

<!-- INCLUDE BLOCK : leftmenu -->

<div id="content"><center>
<!-- INCLUDE BLOCK : content -->
</center></div>

<div id="publicidad">
    {script_publicidad}
    
</div>
<div style="position: absolute; top : 98%; width: 100%; text-align: center ">
    © Copyright <a href="http://nd-games.es">ND-GAMES</a>. All rights reversed.
</div>

</body>
</html>