
// mostrar un simple mensaje.
function XN_message(mes, title, color) {
	document.write('<br><br>'+
		'<table width="519">'+
		'<tr>'+
		'<td class="c"><font color="'+color+'">'+title+'</font></td>'+
		'</tr><tr>'+
		'<th class="errormessage">'+mes+'</th>'+
		'</tr>'+
		'</table>'
	);
}

// hmmm, se podria agregar la parte de mostrar el copyright, quizas para mas
// adelante
function XN_foot() {
	document.write('<br><br>'+
		'<div align="center">Powered by <a href="http://project.xnova.es/" target="_new">XNova</a></div>'+
		'</td>'+
		'</tr>'+
		'</table>'+
		'</body>'+
		'</html>'
	);
}

// to show the frame
function XN_frame(game_name, encoding, noframes) {
	document.write('<html>' +
		'<head>' +
		'<meta http-equiv="Content-Type" content="text/html;charset='+encoding+'">' +
		'<link rel="shortcut icon" href="favicon.ico">' +
		'<title>'+game_name+'</title>' +
		'</head>' +

		'<frameset framespacing="0" border="0" cols="190,*" frameborder="0">' +
		'	<frame name="LeftMenu" target="Mainframe" src="leftmenu.php" noresize scrolling="no" marginwidth="0" marginheight="0">' +
		'	<frame name="Hauptframe" src="overview.php">' +
		'</frameset>' +

		'<noframes>' +
		'	<body>' +
		'		<p>'+noframes+'</p>' +
		'	</body>' +
		'</noframes>' +

		'</html>'
	);
}


function f(target_url, win_name) {
  var new_win = window.open(target_url, win_name, 'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}

// dios, que choclo!
function XN_leftmenu(
servername, mf, XNovaRelease, dpath,
devlp,Overview,Buildings,Research,Shipyard,Defense,Officiers,Marchand,
navig,Alliance,Fleet,Messages,
observ,Galaxy,Imperium,Resources,Technology,Records,Statistics,user_rank,Search,blocked,Annonces,
commun,Buddylist,Notes,Chat,Board,Contact,support_system,Options,ADMIN_LINK,Logout,
infog,server_info, forum_url) {
	document.write('<div id="leftmenu">' +
		'<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">' +
		'<center>' +
		'<div id="menu">' +
		'<br>' +
		'<table width="130" cellspacing="0" cellpadding="0">' +
		'<tr>' +
		'<td colspan="2" style="border-top: 1px #545454 solid"><div><center>'+servername+'<br>(<a href="changelog.php" target="'+mf+'"><font color=red>'+XNovaRelease+'</font></a>)<center></div></td>' +
		'</tr><tr>' +
		'<td colspan="2" background="'+dpath+'img/bg1.gif"><center>'+devlp+'</center></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="overview.php" accesskey="g" target="'+mf+'">'+Overview+'</a></div></td>' +
		'</tr><tr>' +

		'<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="buildings.php" accesskey="b" target="'+mf+'">'+Buildings+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="buildings.php?mode=research" accesskey="r" target="'+mf+'">'+Research+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="buildings.php?mode=fleet" accesskey="f" target="'+mf+'">'+Shipyard+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="buildings.php?mode=defense" accesskey="d" target="'+mf+'">'+Defense+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="officier.php" accesskey="o" target="'+mf+'">'+Officiers+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="marchand.php" accesskey="m" target="'+mf+'">'+Marchand+'</a></div></td>' +
		'</tr><tr>' +

		'<td colspan="2" background="'+dpath+'img/bg1.gif"><center>'+navig+'</center></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="alliance.php" accesskey="a" target="'+mf+'">'+Alliance+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="fleet.php" accesskey="t" target="'+mf+'">'+Fleet+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="messages.php" accesskey="c" target="'+mf+'">'+Messages+'</a></div></td>' +
		'</tr><tr>' +

		'<td colspan="2" background="'+dpath+'img/bg1.gif"><center>'+observ+'</center></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="galaxy.php?mode=0" accesskey="s" target="'+mf+'">'+Galaxy+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="imperium.php" accesskey="i" target="'+mf+'">'+Imperium+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="resources.php" accesskey="r" target="'+mf+'">'+Resources+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="techtree.php" accesskey="g" target="'+mf+'">'+Technology+'</a></div></td>' +
		'</tr><tr>' +

		'<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="records.php" accesskey="3" target="'+mf+'">'+Records+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="stat.php?start='+user_rank+'" accesskey="k" target="'+mf+'">'+Statistics+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="search.php" accesskey="b" target="'+mf+'">'+Search+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="banned.php" accesskey="3" target="'+mf+'">'+blocked+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="annonce.php" accesskey="3" target="'+mf+'">'+Annonces+'</a></div></td>' +
		'</tr><tr>' +

		'<td colspan="2" background="'+dpath+'img/bg1.gif"><center>'+commun+'</center></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="#" onClick="f(\'buddy.php\', \'\');" accesskey="c">'+Buddylist+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="#" onClick="f(\'notes.php\', \'Report\');" accesskey="n">'+Notes+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="chat.php" accesskey="a" target="'+mf+'">'+Chat+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="'+forum_url+'" accesskey="1" target="'+mf+'">'+Board+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="contact.php" accesskey="3" target="'+mf+'" >'+Contact+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="support.php" accesskey="3" target="'+mf+'">'+support_system+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2"><div><a href="options.php" accesskey="o" target="'+mf+'">'+Options+'</a></div></td>' +
		'</tr>' +
		ADMIN_LINK +
		'<tr>' +
		'<td colspan="2"><div><a href="javascript:top.location.href=\'logout.php\'" accesskey="s" style="color:red">'+Logout+'</a></div></td>' +
		'</tr><tr>' +
		'<td colspan="2" background="'+dpath+'img/bg1.gif"><center>'+infog+'</center></td>' +
		'</tr>' +
		//'{server_info}' +
		'<tr>' +
		'<td colspan="2"><div><center><a href="credit.php" accesskey="T" target="'+mf+'">XNova Team</a><br>&copy; Copyright 2008</center></div></td>' +
		'</tr>' +
		'</table>' +
		'</div>' +
		'</center>' +
		'</body>' +
		'</div>'
	);
}







