<div id='leftmenu'>
	
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
function control_debug(){
 if (document.getElementById('pqp-container').style.display == "none"){
  document.getElementById('pqp-container').style.display = '';
 }else{
  document.getElementById('pqp-container').style.display = 'none';
 }
}
$(function() {
		$("#changelog").dialog({
			bgiframe: true,
                        autoOpen: false,
			modal: true,
                        height: '600',
                        width:  '800',
                        title: 'Changelog'
		});
	});

function showchangelog(){
     $("#changelog").dialog("open");
     $.post("game.php?page=changelog",{changelog: "ok"},
       function(data){
            $("#changelog").html(data);
        });
}
</script>


<center>
    <div id="changelog"></div>
<div id='menu'>

    <p style="width:110px;"><NOBR>{servername} (<a  onclick="showchangelog()" >{version}</a>)</NOBR></p>
<table id="menutable" width="110" cellspacing="0" cellpadding="0">
 <tr>
  <td>

   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=overview'>{lm_overview}</a>
    </font></div>
  </td>
 </tr>


 <tr>
  <td>

   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=imperium'>{lm_empire}</a>
    </font></div>
  </td>
 </tr>
 
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">

     <a href='game.php?page=buildings'>{lm_buildings}</a>
    </font></div>
  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=resources'>{lm_resources}</a>

    </font></div>
  </td>
 </tr>

  <tr>
  <td>
   <div align="center" ><font color="#FFFFFF">
     <a href='game.php?page=marchand'><font color='FF8900'>{lm_trader}</font></a> 

    </font></div>
  </td>
 </tr>
 
  
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=buildings&mode=research'>{lm_research}</a>
    </font></div>

  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=buildings&mode=fleet'>{lm_shipshard}</a>
    </font></div>
  </td>

 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=fleet'>{lm_fleet}</a>
    </font></div>
  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=techtree'>{lm_technology}</a>
    </font></div>
  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=galaxy&mode=0'>{lm_galaxy}</a>
    </font></div>
  </td>
 </tr>

 <tr>

  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=buildings&mode=defense' accesskey="d">{lm_defenses}</a>
    </font></div>
  </td>
 </tr>

 <tr>
  <td><!--<img src="{dpath}gfx/info-help.jpg" width="110" height="19">--> &nbsp;</td>

 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=alliance'>{lm_alliance}</a>
    </font></div>
  </td>
 </tr>

  <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
    <a href="{forum_url}" target="_blank">{lm_forums}</a>
   </font></div>
  </td>
 </tr>
 

 	<tr>

	   <td>
       	<div align="center"><font color="#FFFFFF">
	   		<a  href='game.php?page=officier'><font color='FF8900'>{lm_officiers}</font></a>
	   </font></div>
	  </td>
	 </tr>
 
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">

  <a href='game.php?page=statistics&range={user_rank}'>{lm_statistics}</a>
    </font></div>
  </td>
 </tr>

  <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=search'>{lm_search}</a>

    </font></div>
  </td>
 </tr>
 
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=banned'>{lm_banned}</a>

    </font></div>
  </td>
 </tr>
 
 <tr>
  <td><!-- <img src="{dpath}/gfx/user-menu.jpg" width="110" height="19">--> &nbsp;</td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">

     <a href='game.php?page=messages'>{lm_messages} {new_message}</a>
    </font></div>
  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href="#" onClick="f('game.php?page=notes', '{lm_notes}')">{lm_notes}</a>

    </font></div>
  </td>
 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=buddy'>{lm_buddylist}</a>
    </font></div>

  </td>
 </tr>
<tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=support'>{lm_supp}</a>
    </font></div>
  </td>

 </tr>
<tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=contact'>{lm_contact}</a>
    </font></div>
  </td>

 </tr>

 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=news'>{lm_news}</a>
    </font></div>
  </td>

 </tr>
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=options'>{lm_options}</a>
    </font></div>
  </td>

 </tr>
{plugins}
{debug}
 
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
     <a href='game.php?page=logout'>{lm_logout}</a>
    </font></div>
  </td>
 </tr>
{admin_link}
 <tr>
  <td>
   <div align="center"><font color="#FFFFFF">
<script language="JavaScript">
origen="2008";
copyright=new Date();
update=copyright.getFullYear();

if(origen==update){
    escribir=update;
}
if(origen<update){
    escribir=origen+" - "+update;
}
document.write("<a href='http://creativecommons.org/licenses/by-nc-sa/3.0/deed.es'><img src='./styles/images/88x31.png'/></a><br><a href='game.php?page=credit' style='font-size:9px' title='Copyright &copy; "+escribir+" '>&copy; "+escribir+"</a>");
</script>
    </font></div>
  </td>
 </tr>
 
 </table>
 </center>
</div>