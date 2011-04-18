<HTML>
<HEAD><TITLE> Mercenary Report </TITLE>
<link rel="stylesheet" href="css/XNovaConverter.css">
<script language="JavaScript">
var ver = "0.5";
var homepage = "xnova.fr";
var t;
var f;
var attacker;
var defender; 
var attackerA;
var defenderA;
var rp; 
var time = "----";
var firstA;
var firstD;
var ganimet = new Array(0, 0, 0);
var garbage = new Array(0, 0);
var lost = new Array(0, 0);
var moonChance = 0;
var moonCreated = false;
var result;
var color = new Array;
var fleetView;
var bground;
var colorUse = new Array();

function closeMessage() {
	document.getElementById("message").style.visibility = "hidden";
}

function preview() {
	f = document.forms[0];
	t = f.report.value;
	if (t.match("Attaccante") && t.match("Difensore") && t.match("Tipo") && t.match("Numero") || t.match("Risorse su")) {
		var str = convertHtml();
		var obj = document.getElementById("preview");
		obj.innerHTML = str;
		var obj = document.getElementById("note1");
		obj.innerHTML = "Anteprima";
		var obj = document.getElementById("note0");
		obj.innerHTML = "Anteprima";
		document.getElementById("message").style.visibility = "visible";
	} else {
		alert("Inserisci un combat report o uno spy report nel pannello di sinistra.");
		return false;
	}
}

function about() {
	var str = '<center><img src=images/XNovaConverterLogo.png><br>'+
		  '<span style="letter-spacing:3pt"><b>XNova Converter</b></span><br>'+
		  'by Rocky<p>'+
		  'Versione: '+ver+'<p>'+
	 	  'Homepage: <a href="http://'+homepage+'">'+homepage+'</a><p>'+
		  'XNova Converter è basato su Takana CR Converter<br> di Dragon Takana '+
		  '<a href="http://takanacity.com">http://takanacity.com</a></center><br>';
	var obj = document.getElementById("preview");
	obj.innerHTML = str;
	var obj = document.getElementById("note1");
	obj.innerHTML = "Informazioni";
	var obj = document.getElementById("note0");
	obj.innerHTML = "Informazioni";
	document.getElementById("message").style.visibility = "visible";
	document.getElementById("message").className='dark';
}

function convertHtml() {
	convert();
	var str = f.formatedReport.value;

	while (str.match("\n")) str = str.replace("\n","<br>");
	str = str.replace(/\[(\/*)[bB]\]/g,"<$1b>");
	str = str.replace(/\[(\/*)[Ii]\]/g,"<$1i>");
	str = str.replace(/\[color=([^\]]*)\]/g,"<font color=$1>");
	str = str.replace(/\[\/color\]/g,"</font>");
	str = str.replace(/\[url=([^\]]*)\]/g,"<a href=$1>");
	str = str.replace(/\[\/url\]/g,"</a>");
	str = str.replace(/\[size=9\]/g,"<small>");
	str = str.replace(/\[\/size\]/g,"</small>");
	str = str.replace(/\[(\/*)center\]/g,"<$1center>");
	str = str.replace(/\[(\/*)list\]/g,"<$1ul>");
	if (bground == 1) {
	str = str.replace(/\[quote\]/g,"<table align=center width=95% cellpadding=4px><tr>"+
	"<td style=\"font-size:11px;font-family:Tahoma;font-weight:bold;color:#FFFFCC\">Citazione:</td></tr><tr>"+
	"<td style=\"color:black;font-size:12px;font-family:Tahoma;font-weight:normal;border:#BFBFBF; "+
	"border-style:solid;border-left-width: 1px; border-top-width: 1px; border-right-width:1px; "+
	"border-bottom-width: 1px;background-color:#616161\">");
	str = str.replace(/\[\/quote\]/g,"</td></tr></table>");
	}
	else {
	str = str.replace(/\[quote\]/g,"<table align=center width=95% cellpadding=4px><tr>"+
	"<td style=\"font-size:11px;font-family:Tahoma;font-weight:bold;color=#000000\">Citazione:</td></tr><tr>"+
	"<td style=\"color:black;font-size:12px;font-family:Tahoma;font-weight:normal;border:#000000; "+
	"border-style:solid;border-left-width: 1px; border-top-width: 1px; border-right-width: 1px; "+
	"border-bottom-width: 1px;background-color:#BFBFBF\">");
	}
	str = str.replace(/\[\/quote\]/g,"</td></tr></table>");
	
	return str;
} 

function html() {
	f = document.forms[0];
	t = f.report.value;

	if (t.match("Attaccante") && t.match("Difensore") && t.match("Tipo") && t.match("Numero") || t.match("Risorse su")) {
		var tt = convertHtml();

		str = "<html><head><style>";
		if (bground == 1) str += 'body{background-color:#212121;font-family:Tahoma;font-size:12px;color:#FFFFCC}';
		else str += 'body{font-family:Tahoma;font-size:12px}';
		str += "</style></head>"+tt+"</body></html>";
		
		f.formatedReport.value = str;
	} else {
		alert("Inserisci un combat report o uno spy report nel pannello di sinistra.");
		return false;
	}
}

function convert() {
	f = document.forms[0];
	t = f.report.value;

	time = "----";

	var j= f.fleetView.length;
	for (var i=0; i<j; i++) {
		if(f.fleetView[i].checked) fleetView = f.fleetView[i].value;
	}
	var j = f.bground.length;
	for (var i = 0; i < j; i++) {
		if(f.bground[i].checked) bground = f.bground[i].value;
	}

	savePref();

	colorSet();

	if (t.match("Attaccante") && t.match("Difensore") && t.match("Tipo") && t.match("Numero")) 
		convertcr();
	else if (t.match("Risorse su") && t.match("Metallo:") && t.match("Cristallo:") && t.match("Energia:"))
		convertsr();
	else {
		alert("Inserisci un combat report o uno spy report nel pannello di sinistra.");
		return false;
	}
}

function convertsr() {
	var sr = f.report.value;

	while (sr.match("\t")) sr = sr.replace("\t", " ");
	while (sr.match("  ")) sr = sr.replace("  ", " ");
	while (sr.match("\r")) sr = sr.replace("\r", "\n");
	while (sr.match("\n ")) sr = sr.replace("\n ", "\n");
	while (sr.match(" \n")) sr = sr.replace(" \n", "\n");
	while (sr.match("\n\n")) sr = sr.replace("\n\n", "\n");

	if (sr.match("Comando di flotta")) 
		sr = sr.replace(/.*Comando di flotta.*Rapporto di spionaggio.*\[\d:\d+:\d+\]\s*/g, '');

	while (sr.match(/(\n\D*) (\d*) (\D*) (\d*\n)/))
			sr = sr.replace(/(\n\D*) (\d*) (\D*) (\d*\n)/, "$1 $2\n$3 $4");

	sr = sr.replace(/Risorse su (.*) \[(\d:\d+:\d+)\] a (\d+\-\d+) (\d\d:\d\d:\d\d)/g, 
		"[i]Rapporto di spionaggio ($3 @ $4):[/i] [b][color=#ff0000]$1[/color] [$2][/b]");

	if (f.coor.checked) sr = sr.replace(/\[\/color\] \[\d:\d+:\d+\]\[\/b]/, "[/color] [-:---:--][/b]");
	if (f.defenderName.checked) sr = sr.replace(/(:\[\/i\] \[b\]\[color=#ff0000\]).*(\[\/color\])/, "$1-----$2");


	sr = sr.replace(/(\nMetallo)/g, "\n\n[b][color=#0099FF]Risorse[/color][/b]$1");

	while(sr.match(/\nMetallo: \d+\n/)) {
		var m = sr.match(/\nMetallo: \d+\n/);
		m = m[0].replace(/\nMetallo: (\d+)\n/, "$1");
		sr = sr.replace("\nMetallo: "+m, "\nMetallo: [b][color=#FF9900]"+formatFloat(m,0)+"[/color][/b]");
	}
	while(sr.match(/\nCristallo: \d+\n/)) {
		var k = sr.match(/\nCristallo: \d+\n/);
		k = k[0].replace(/\nCristallo: (\d+)\n/, "$1");
		sr = sr.replace("\nCristallo: "+k, "\nCristallo: [b][color=#FF9900]"+formatFloat(k,0)+"[/color][/b]");
	}
	while(sr.match(/\nDeuterio: \d+\n/)) {
		var d = sr.match(/\nDeuterio: \d+\n/);
		d = d[0].replace(/\nDeuterio: (\d+)\n/, "$1");
		sr = sr.replace("\nDeuterio: "+d, "\nDeuterio: [b][color=#FF9900]"+formatFloat(d,0)+"[/color][/b]");
	}
	while(sr.match(/\nEnergia: \d+\n/)) {
		var e = sr.match(/\nEnergia: \d+\n/);
		e = e[0].replace(/\nEnergia: (\d+)\n/, "$1");
		sr = sr.replace("\nEnergia: "+e, "\nEnergia: "+formatFloat(e,0));
	}
	var sec = new Array("Flotte","Difesa","Infrastrutture","Ricerca");
	for (var i=0; i<sec.length; i++) {
		while (sr.match("\n"+sec[i])) 
			sr = sr.replace("\n"+sec[i], "\n\n[b][color=#0099FF]"+sec[i]+"[/color][/b]"); 
	}

	sr = sr.replace(/(Laboratorio di ricerca)\./g, "$1");
	sr = sr.replace(/(\nProbabilità di controspionaggio:)(\d*)%/g, "\n$1 [b][color=#FF9900]$2[/color][/b]%\n");
	
	for (var i=0; i<shipl.length; i++) {
		while (sr.match("\n"+shipl[i])) 
			sr = sr.replace("\n"+shipl[i], "\n[color="+color[i]+"]"+shipl[i]+"[/color]");
	}

	sr = sr.replace(/\[\/color\] (\d+)/g, " $1[/color]");

	sr = sr.replace(/(\nMissili anti-missili) (\d+)/g, "[color=#993300]$1 $2[/color]");
	sr = sr.replace(/(\nMissili interplanetari) (\d+)/g, "[color=#FF3300]$1 $2[/color]");

	sr += "\n\n[size=9]* Generato con [url=http://"+homepage+"]Mercenary Report "+ver+"[/url][/size]";

	while (sr.match("\n\n\n")) sr = sr.replace(/\n\n\n/, "\n\n");
	while (sr.match(/^\n/)) sr = sr.replace(/^\n/, "");
	
	if (f.list.checked) sr = '[list]'+sr+'[/list]';
	if (f.center.checked) sr = '[center]'+sr+'[/center]';
	if (f.quote.checked) sr = '[quote]'+sr+'[/quote]';

	f.formatedReport.value = sr;
}
	
function convertcr() {	
	ganimet = new Array(0, 0, 0);
	garbage = new Array(0, 0);
	lost = new Array(0, 0);
	moonChance = 0;

	firstA = true;
	firstD = true;
	round = 0;
	repaired = "";
	moonCreated = false;
	
	attacker = new Array();
	defender = new Array();
	attackerA = new Array();
	defenderA = new Array();

	while (t.match("  ")) t = t.replace("  ", " ");
	while (t.match("\n ")) t = t.replace("\n ", "\n");
	while (t.match(" \n")) t = t.replace(" \n", "\n");
	while (t.match("\r ")) t = t.replace("\r ", "\r");
	while (t.match(" \r")) t = t.replace(" \r", "\r");

	rp = t.split("\n\r\n");
	if (rp.length==1) rp = t.split("\n\n");

	for (var i=0; i<rp.length; i++) {

		if (rp[i].match("Tipo ")) {
				for (j=0; j<ship.length; j++) {
					if (rp[i].match(" "+ship[j])) {
						rp[i] = rp[i].replace(" "+ship[j], "\t"+ship[j]);
					}
				}
		}
		if (rp[i].match("Numero ")) {
				for (var h=1; h<10; h++) {
					while (rp[i].match(" "+h)) {
					rp[i] = rp[i].replace(" "+h,"\t"+h);
					}
				}
				while (rp[i].match(":\t")) {
					rp[i] = rp[i].replace(":\t", ": ");
				}
		}
	
		if (rp[i].match("Le flotte sono una di fronte")) {
			if (rp[i].match(" su ")) {
				rp[i] = rp[i].replace(" su ", " a ");
			}
			time = getTime(rp[i]);
		}
		else if (rp[i].match("Attaccante ")) {
		
			round ++;

			var players = rp[i].split("\t\r\n");
			if (players.length == 1)
				players = rp[i].split("\n\t\n");
			if (firstA == true) {
				attacker = new Array();
				attackerA = new Array();
			}
			for (var j = 0; j < players.length; j++) {
				while (players[j].charAt(0) != 'A')
					players[j] = players[j].substr(1);
				var at = getPlayer(players[j], "Attaccante");
				if (firstA==true) {
					addPlayer(at, players[j]);
					attacker.push(at); 
				}
				else {
					afterWar(at, players[j])
					attackerA[round] = new Array();
					attackerA[round].push(at); 
				}
			}
			firstA = false;	
		}
		else if (rp[i].match("Difensore ")) {
			var players = rp[i].split("\t\r\n");
			if (players.length == 1)
				players = rp[i].split("\n\t\n");
			if (firstD==true) {
				defender = new Array();
				defenderA = new Array();
			}
			for (var j = 0; j < players.length; j++) {
				while (players[j].charAt(0) != 'D')
					players[j] = players[j].substr(1);
				var at = getPlayer(players[j], "Difensore");
				if (firstD==true) {
					addPlayer(at, players[j]);
					defender.push(at); 
				}
				else {
					afterWar(at, players[j])
					defenderA[round] = new Array();
					defenderA[round].push(at); 
				}
			}
			firstD = false;
		}
		else if (rp[i].match("attaccante ha vinto la battaglia")) {
			result = 1;			
		}
		else if (rp[i].match("Il difensore ha vinto la battaglia")) {
			result = 2;			
		}
		else if (rp[i].match("Il combattimento finisce in equilibrio")) {
			result = 0;			
		}
		if (rp[i].match("E cattura")) {			
			getGanimet(rp[i]);
		}
		if (rp[i].match("ha perso un totale di")) {
			getLost(rp[i]);
		}
		if (rp[i].match("Fluttua ora a queste coordinate spaziali")) {
			getGarbage(rp[i]);
		}
		if (rp[i].match(" che si formi una luna dai detriti è ")) {
			getMoonChance(rp[i]);
		}
		if (rp[i].match("enorme quantità; di particelle ")) {
			moonCreated = true;
		}
		if (rp[i].match("poteva essere riparata")) {
			getRepaired(rp[i]);
		}
	}
	f.formatedReport.value = createMessage();
}

function getColor(t) {
	for (var i = 0; i<ship.length; i++) {
		if (t.match(ship[i])) return color[i];
	}
	return color[Math.round(Math.random()*(color.length-1))];
}

function getShipl(t) {
	for (var i = 0; i<ship.length; i++) {
		if (t.match(ship[i])) return shipExt[i];
	}
}

function createTechLine(p, tech) {
	if (!tech) return "Armi: [b]"+p[2]+"[/b]% Scudi: [b]"+p[3]+"[/b]% Corazza: [b]"+p[4]+"[/b]%\n";
	else return "Armi: --% Scudi: --% Corazza: --%\n";
}

function createPlayerLine(what, p, coor) {
	var name = true;
	var c = '#00cc33';

	if (what.match('Attaccante')) {
		name = f.attackerName.checked;
		c = '#ff0000';
	} 
	else name = f.defenderName.checked;

	if (name) p[0] = ' ----- ';

	if (!coor) return what+" [b][color="+c+"]"+p[0]+"[/color][/b]([b]"+p[1]+"[/b])\n";
	else return what+" [b][color="+c+"]"+p[0]+"[/color][/b](-:---:--)\n";
}

function createFleetMessage(type, n, hide) {
	var str = '';

	for(var i = 0; i < type.length; i++) {
		var t = type[i];
		while ((t.charAt(t.length-1) == "\n") || (t.charAt(t.length-1) == "\r")) {
			t = t.substring(0, t.length-1);
		}
		var c = getColor(t);

		if (f.longships.checked) t = getShipl(t);

		if (n) {
			if(hide) {
				if (fleetView == 2) str += '[color='+c+']'+t+' --[/color]\n';
				else str += '[color='+c+']'+t+' --[/color] | ';	// flotta su una riga
			} else {
				if (fleetView == 2) str += '[color='+c+']'+t+' '+n[i]+'[/color]\n';
				else str += '[color='+c+']'+t+' '+n[i]+'[/color] | '; // flotta su una riga
			}
		}
		else	str += "Distrutto\n";
	}
	str += '\n';
	str = str.replace(' | \n', "\n") // Per flotta su una riga
	return str;
}

function ltrim(str) {
	if (!str) return "";
	for (var i = 0; i < str.length; i++) {
		if (str.charAt(i) != ' ' && str.charAt(i) != '\t' && str.charAt(i) != '\n' && str.charAt(i) != '\r')  
			break;
	}
	return str.substr(i);
}

function createPlayerMessage(what, p, tech, coor, first) {
	var str = "";
	str += createPlayerLine(what, p, coor);

	if (first) str += createTechLine(p, tech);
	
	var hide = false;
	if (f.attackerFleet.checked) {
		if (what.match('Attaccante')) hide = true;
	}
	if (f.defenderFleet.checked) {
		if (what.match('Difensore')) hide = true;
	}
	if (fleetView == 0) {
		p[5][0] = ltrim(p[5][0]);
		if (p[5][0]) {
			str += "Tipo "+birlestir(p[5], colorUse, false)+"\n";
			str += "Numero "+birlestir(p[6], colorUse, hide)+"\n";
		}
		else	str += "Distrutto\n";
	} else {
		if (p[5][0]) {
			str += createFleetMessage(p[5],p[6], hide);
		}
		else	str += "Distrutto\n";
	}
	str += "\n";
	return str;
}

function createMessage() {
	f = document.forms[0];
	tech = f.tech.checked;
	coor = f.coor.checked;
	shortcr = f.shortcr.checked;
	msg = f.msg.value;
	if (f.allyA.value) allyA = "["+f.allyA.value+"]"; else allyA = "";
	if (f.allyD.value) allyD = "["+f.allyD.value+"]"; else allyD = "";

	if (!f.title.checked) var str = 
	    "Le flotte sono una di fronte all'altra a [b]"+
		time +
	    "[/b], ed ecco giungere alla battaglia:\n\n"; 

	else {
		var str = "[b]Combat Report ("+time.replace(/(.+) (.+)/, "$1 @ $2")+"): ";
		if (f.attackerName.checked) str += "-----"; else str += attacker[0][0]

		str +=allyA+" vs. ";

		if (f.defenderName.checked) str += "-----"; else str += defender[0][0]

		str +=allyD+"[/b]\n\n";
	}
	for (var i = 0; attacker[i]; i++) {
		str += createPlayerMessage("[b][1][/b] Attaccante", attacker[i], tech, coor, true);
	}
	for (var i = 0; defender[i]; i++) {
		str += createPlayerMessage("Difensore", defender[i], tech, coor, true);
	}
	if (shortcr) {
		if(msg) str += msg+"\n\n";
		var h = round;
	} 
	else 	var h = 2;

	k = round+1 ;
	 
	for (var j = h; j < k; j++) {
		if (!attackerA[j]) {
			attackerA[j] = new Array();
		}
		for (var i = 0; attackerA[j][i]; i++) {
			str += createPlayerMessage("[b]["+j+"][/b] Attaccante", attackerA[j][i], tech, coor, false);
		}
		if (!defenderA[j]) {
			defenderA[j] = new Array();
		}
		for (var i = 0; defenderA[j][i]; i++) {
			str += createPlayerMessage("Difensore", defenderA[j][i], tech, coor, false);
		}
	}
	if (result == 1) {
		str += "[b][color=#ff0000]L'attaccante ha vinto la battaglia![/color][/b]\n"+
	        "Cattura: [b][color=#FF9900]"+formatFloat(ganimet[0],0)+
	   	"[/color][/b] Metallo, [b][color=#FF9900]"+formatFloat(ganimet[1],0)+
	   	"[/color][/b] Cristallo e [b][color=#FF9900]"+formatFloat(ganimet[2],0)+
	   	"[/color][/b] Deuterio.\n\n";
	} 
	else if (result == 2) { 
		str += "[b][color=#00cc33]Il difensore ha vinto la battaglia![/color][/b]\n\n";
	} 
	else if (result == 0) { 
		str += "[b][color=#0099FF]Il combattimento finisce in equilibrio - entrambe le flotte rimanenti "+
		    "ritornano ai loro pianeti di origine.[/color][/b]\n\n";
	}

	str += "L'attaccante ha perso un totale di [b][color=#FF9900]"+formatFloat(lost[0],0)+"[/color][/b] Unità.\n"+
		   "Il difensore ha perso un totale di [b][color=#FF9900]"+formatFloat(lost[1],0)+"[/color][/b] Unità.\n\n"+
		   "Fluttua ora a queste coordinate spaziali [b][color=#FF9900]"+formatFloat(garbage[0],0)+
		   "[/color][/b] Metallo e [b][color=#FF9900]"+formatFloat(garbage[1],0)+"[/color][/b] Cristallo.\n";

	if (moonChance > 0) 
		str += "La possibilità che si formi una luna dai detriti è [b][color=#FF9900]"+moonChance+
	          "[/color][/b]%.\n";
	
	if (moonCreated) {
		str += "L'enorme quantità di particelle di metallo e cristallo alla deriva si attraggono a vicenda e "+
                  "lentamente formano un [b][color=#FF9900]satellite lunare[/color][/b] in orbita attorno al pianeta.\n";
	}

	str += repaired;

	str += "\n\n[size=9]* Generato con [url=http://"+homepage+"]Mercenary Report "+ver+"[/url][/size]";

	
	if (f.list.checked) str = '[list]'+str+'[/list]';
	if (f.center.checked) str = '[center]'+str+'[/center]';
	if (f.quote.checked) str = '[quote]'+str+'[/quote]';

	str = str.replace(/  /g, " ");
	str = str.replace(/\r/g, "");
	str = str.replace(/\t/g, " ");
	str = str.replace(/ \n/g, "\n");
	str = str.replace(/\n /g, "\n");
	str = str.replace(/\n\n\n/g, "\n\n");
	
	return str;
}

function birlestir(dizi, clr, hide) {
	var str = "";

	if (dizi == undefined) {
		clr.splice(0, clr.length);
		dizi = new Array();
	}

	if (!parseInt(dizi[0])) clr.splice(0, clr.length);

	for (var i=0; i<dizi.length; i++) {
		var t = dizi[i];
		while ((t.charAt(t.length-1) == "\n") || (t.charAt(t.length-1) == "\r")) {
			t = t.substring(0, t.length-1);
		}
		var c;
		if (parseInt(t)) {
			c = clr[i];
		}
		else {
			c = getColor(t);
			clr.push(c);
		}

		if(hide) t = "--";
		else if(isNaN(t)) 
			if(f.longships.checked) t = getShipl(t);
		str += " [color="+c+"]"+t+"[/color] ";
	}
	return str;
}

function getMoonChance(p) {
	var str = "La possibilità; che si formi una luna dai detriti è ";
	var x = p.search(str);
	moonChance = parseInt(p.substr(x+str.length));
}

function getGarbage(p) {
	var y = p.search(' Metallo');
	var i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	garbage[0] = p.substring(y-i, y);
	
	y = p.search(' Cristallo');
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	garbage[1] = p.substring(y-i, y);
}

function getLost(p) {
	var str = "attaccante ha perso un totale di ";
	var x = p.search(str) + str.length;
	lost[0] = "";
	var y = 0;
	while ((!isNaN(parseInt(p.charAt(x+y)))) || (p.charAt(x+y)=='.')) {
		lost[0] += p.charAt(x+y);
		y++;
	}

	str = "Il difensore ha perso un totale di ";
	x = p.search(str) + str.length;
	lost[1] = "";
	y = 0;
	while ((!isNaN(parseInt(p.charAt(x+y)))) || (p.charAt(x+y)=='.')) {
		lost[1] += p.charAt(x+y);
		y++;
	}
}

function getGanimet(p) {
	var y = p.search(' Metallo');
	var i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[0] = p.substring(y-i, y);
	
	y = p.search(' Cristallo');
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[1] = p.substring(y-i, y);

	y = p.search(' Deuterio');
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[2] = p.substring(y-i, y);

	return ganimet;
} 

function getRepaired(p) {
	if (p.match(". ")) p = p.replace(/\. /g, ".\n");
	tr = new Array();
	tr = p.match(/.*poteva essere riparata\./);
	repaired = "\nDifese riparate: "+tr[0].replace(" poteva essere riparata", "");
}

function afterWar (at, p) {
	var lines = p.split('\n');
	if (lines.length==1)
		lines = p.split('\n\r');

	var pos = lines[0].search("Tipo");
	var n = 0;
	if (pos > 0){
		n = -1;
		lines[0] = lines[0].substr(pos);
	}
	
	if (lines.length > 1+n) {
		at[5] = lines[1+n].split('\t');
		if (at[5].length == 1) {
			at[5] = lines[1+n].split(' ');
			for(var i=0; i<at[5].length; i++) {
				if ((at[5][i].match("Sonda")) || (at[5][i].match("Sat"))) {
					at[5][i] += at[5][i+1];
					at[5].splice(i+1, 1); 
				}
			}
		}
		at[5].shift();
	}
	if (lines.length > 2+n) {
		at[6] = lines[2+n].split('\t');
		if (at[6].length == 1)
			at[6] = lines[2+n].split(' ');
		at[6].shift();
	}	
}

function addPlayer(at, p) {
	var lines = p.split('\n');
	var pos = lines[0].search("Tipo");
	var n = 0;
	if (pos > 0) n = -1;

	at[2] = getTech(lines[1], "Armi: ");
	at[3] = getTech(lines[1], "Scudi: ");
	at[4] = getTech(lines[1], "Corazza: ");

	pos = lines[1].search("Tipo");
	if (pos > 0){
		n = -1;
		lines[1] = lines[1].substr(pos);
	}
	if (lines.length > 2+n) {
		at[5] = lines[2+n].split('\t');
		if (at[5].length == 1) {
			at[5] = lines[2+n].split(' ');
			for(var i=0; i<at[5].length; i++) {
				if ((at[5][i].match("Sonda")) || (at[5][i].match("Sat"))) {
					at[5][i] += at[5][i+1];
					at[5].splice(i+1, 1); 
				}
			}
		}		
		at[5].shift();
	}
	if (lines.length > 3+n) {
		at[6] = lines[3+n].split('\t');
		if (at[6].length == 1)
			at[6] = lines[3+n].split(' ');
		at[6].shift();
	}
	return true;
}

function getTech(line, what) {
	var x = line.search(what);
	x = x + what.length;

	var i = 0;
	var str = "";
	while (line.charAt(x+i) != '%') {
		str += line.charAt(x+i);
		i++;
	}
	return str;
}

function getTime(p) {
	var str = "Le flotte sono una di fronte all'altra a ";
	var l = p.search(str)+str.length;

	str = "";
	var i = 0;
	while (p.charAt(l+i) != " ") {
		str += p.charAt(l+i);
		i++;
	}
	i++;
	str += " ";
	while (p.charAt(l+i) != " ") {
		str += p.charAt(l+i);
		i++;
	}
	return str;
}

function getPlayer(par,what,n) {
	var str = par;
	var x = str.search(what);

	if (x==-1) return -1;

	x = x + 1 + what.length;
	
	var name = "";
	while (str.charAt(x) != "(") {
		name += str.charAt(x);
		x++;
	}
	x++;

	var coordinat = "";
	while (str.charAt(x) != ")") {
		coordinat += str.charAt(x);
		x++;
	}
	return new Array(name, coordinat, null, null, null);
}

var shipl = new Array('Navi da battaglia','Nave cargo grande','Caccia leggero','Caccia pesante','Incrociatore',
	'Nave Riciclatrice','Sonda spia','Lancia-missili','Nave cargo piccola','Nave colonizzatrice',
	'Satellite solare', 'Corazzata','Laser leggero', 'Laser pesante','Cannone di Gauss', 'Cannone ionico',
	'Cannone al plasma', 'Cupola scudo potenziata', 'Cupola scudo', 'Bombardiere', 'Morte nera');

var ship = new Array('N. Batt.','Cargo p.','Caccia l.','Caccia p.','Incro.','Ricicl.','Sonda spia',
	'Lanciam.','Cargo l.', 'Col.', 'Sat. Sol.', 'Corazz.', 'Laser l.', 'Laser p.',
	'C. gauss', 'C. ionico', 'C. plasma', 'Cup. p.', 'Cup.', 'Bombard.', 'RIP');

var shipExt = new Array('Navi da battaglia','Cargo pesanti','Caccia leggeri','Caccia pesanti','Incrociatori',
	'Navi riciclatrici','Sonde spia','Lancia missili','Cargo leggeri','Navi colonizzatrici',
	'Satelliti solari', 'Corazzate','Laser leggeri', 'Laser pesanti','Cannoni di Gauss', 'Cannoni ionici',
	'Cannoni al plasma', 'Cupola scudo potenziata', 'Cupola scudo', 'Bombardieri', 'Morti nere');


function colorSet() {
	if (bground == 0) {
		color = new Array('#3366cc','#996633','#660000','#3300ff','#003300','#99cc00','#3399ff',
				  '#669900','#ff3300','#666600','#ff6699','#ff6633','#006666','#cc9900',
				  '#cc0000','#993300','#663366','#999966','#333333','#993333','#007007');
		document.getElementById("message").className='light';
	} else {
		color = new Array('#cccccc','#ff00cc','#ff99cc','#99ffff','#99ff66','#00cc33','#00ccff',
				  '#0066FF','#ffcc00','#99cc00','#ff6633','#336699','#ffff99','#ff0000',
				  '#ffff66','#669900','#AFAFAF','#CC00CC','#cc3300','#cccc99','#01F01F');
		document.getElementById("message").className='dark';
	}	
}

var thousand_sep = ".";
var decimal_point = ",";
var default_precision = 0;

function formatFloat(aFloat, aPrecision){
	try {precision = default_precision;
		if(!isNaN(aPrecision))
			if(Math.abs(aPrecision)<=10) precision = aPrecision;
	} catch(e) {
		precision = default_precision;
	}
	try {number = parseFloat(aFloat+'');
		if(isNaN(number)) return "NaN";
	} catch(e) {
		return "NaN";
	}

	number = Math.round(number * Math.pow(10, precision)) / Math.pow(10, precision);
	integerpart = '' + ((number<0) ?  Math.ceil(number) :
	Math.floor(number));
	decimalpart = Math.abs(Math.round((number - integerpart)*(Math.pow(10, precision))));
	if(decimalpart<10) decimalpart="0"+decimalpart;
	if(decimalpart==0) decimalpart="00";
	var buff = "";
	for(j=-1, i=integerpart.length; i>=0; i--, j++){
		if((j%3) == 0 && j>1) buff = thousand_sep + buff;
		buff = integerpart.charAt(i) + buff;
	}
	if(precision>0) return buff+decimal_point+decimalpart;
	return buff;
}

function cancel() {
	f = document.forms[0];
	f.report.value = "";
	f.formatedReport.value = "";
}

function clipBoard() {
	f = document.forms[0];
	var par = f.formatedReport.value;

	if (window.clipboardData) {
   		window.clipboardData.setData("Text", par);
	}
	else if (window.opera) { 
		alert("La funzione Copia negli appunti non è supportata da Opera.\n\n"+
			"Selezionare e copiare manualmente il testo nel pannello di destra.");
		return false;
	}
   	else if (window.netscape) { 
		netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');

		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;

		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
   
		trans.addDataFlavor('text/unicode');
   
		var str = new Object();
		var len = new Object();
   
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
   
		var copytext=par;
   
		str.data=copytext;
   
		trans.setTransferData("text/unicode",str,copytext.length*2);
   
		var clipid=Components.interfaces.nsIClipboard;
   
 		if (!clip) return false;
   
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
	else {
   		alert("La funzione Copia negli appunti non è supportata da questo browser.\n\n"+
			"Selezionare e copiare manualmente il testo nel pannello di destra.");
		return false;
	}
}

function getCookie(name) {
	var dc = document.cookie;
	var prefix = name + "=";
	var begin = dc.indexOf("; " + prefix);
	if (begin == -1) {
		begin = dc.indexOf(prefix);
 		if (begin != 0) return null;
  	} else begin += 2;
  	var end = document.cookie.indexOf(";", begin);
  	if (end == -1) end = dc.length;
  	return unescape(dc.substring(begin + prefix.length, end));
}

function setCookie(name, value) {
	var date = new Date();
	var exp = new Date(date.getTime() + (45 * 24 * 60 * 60 * 1000));
	exp = exp.toGMTString();
	var curCookie = name + "=" + escape(value) + '; expires='+exp;
   	document.cookie = curCookie;
}

function loadPref() {
	f = document.forms[0];
	var opt = getCookie('options');
	var options = new Array();
	if(opt) options = opt.split(",");
	if (options) {
		if (options[0] == 1) f.attackerName.checked = true;
		if (options[1] == 1) f.defenderName.checked = true;
		if (options[2] == 1) f.coor.checked = true;
		if (options[3] == 1) f.attackerFleet.checked = true;
		if (options[4] == 1) f.defenderFleet.checked = true;
		if (options[5] == 1) f.tech.checked = true;
		if (options[6] == 1) f.shortcr.checked = true;
		if (options[7] == 1) f.quote.checked = true;
		if (options[8] == 1) f.center.checked = true;
		if (options[9]) f.fleetView[options[9]].checked = true;
		if (options[10]) f.bground[options[10]].checked = true;
		if (options[11] == 1) f.title.checked = true;
		if (options[12] == 1) f.list.checked = true;
		if (options[13] == 1) f.longships.checked = true;
	}
	var mex = getCookie('msg');
	if (mex) f.msg.value = mex;
}

function savePref() {
	var f = document.forms[0];
	var options = new Array();
	if (f.attackerName.checked) options.push(1);
		else options.push(0);
	if (f.defenderName.checked) options.push(1);
		else options.push(0);
	if (f.coor.checked) options.push(1);
		else options.push(0);
	if (f.attackerFleet.checked) options.push(1);
		else options.push(0);
	if (f.defenderFleet.checked) options.push(1);
		else options.push(0);
	if (f.tech.checked) options.push(1);
		else options.push(0);
	if (f.shortcr.checked) options.push(1);
		else options.push(0);
	if (f.quote.checked) options.push(1);
		else options.push(0);
	if (f.center.checked)options.push(1);
		else options.push(0);
	options.push(fleetView);
	options.push(bground);
	if (f.title.checked)options.push(1);
		else options.push(0);
	if (f.list.checked)options.push(1);
		else options.push(0);
	if (f.longships.checked)options.push(1);
		else options.push(0);

	setCookie('options', options);
	var mex = f.msg.value;
	setCookie('msg', mex);
}
</script>
</HEAD>
<BODY>

<div id="message" style="visibility: hidden; position: absolute; width: 500px; height: 340px; top: 70px; left: 100px; 
border: 1px ridge white; overflow: auto; padding: 5px">
<table width="100%">
	<tr>
		<td id="note0">Anteprima</td>

		<td align="right"><a href="#" onclick="closeMessage()">Chiudi</a></td>
	</tr>
</table>
<hr>
<div id="preview" > </div>
<hr>
<table width="100%">
	<tr>
		<td id="note1">Anteprima</td>
		<td align="right"><a href="#" onclick="closeMessage()">Chiudi</a></td>

	</tr>
</table>
</div>


<form>
<table width="740px" height="465px" align="center" class="a">
<tr height="110px" class="b">
	<td width="100%" valign="bottom" class="c">
	Mercenary Report
	</td>
</tr>
<tr>
	<td width="100%">

		<TABLE width="100%" class="d">
		<TR>
		<TD width="50%" class="d1">
		Inserisci il combat report qui sotto: <br>
		<textarea name="report" style="width:100%; height:190px" onfocus="closeMessage()"></textarea>
		</TD>
		<TD width="50%" class="d2"> 
		Combat report convertito:<br>

		<textarea readonly name="formatedReport" style="width:100%; height:190px" onfocus="closeMessage()">
		</textarea>
		</TD>
		</TR>
		</TABLE>
	</td>
</tr>
<tr>
	<td valign="top" width="100%" class="e">
		<table width="100%" class="f">

		<tr>
		<td valign="top" class="f1">
			<input type="checkbox" name="attackerName" onclick="closeMessage()"> Nascondi nome attacc.<br>
			<input type="checkbox" name="defenderName" onclick="closeMessage()"> Nascondi nome difens.<br>
			<input type="checkbox" name="attackerFleet" onclick="closeMessage()"> Nascondi flotta attacc.<br>
			<input type="checkbox" name="defenderFleet" onclick="closeMessage()"> Nascondi flotta difens.
		</td>

		<td valign="top" class="f2">
			<input type="checkbox" name="coor" onclick="closeMessage()"> Nascondi coordinate<br>			
			<input type="checkbox" name="tech" onclick="closeMessage()"> Nascondi tecnologie<br>
			<input type="checkbox" name="longships" onclick="closeMessage()"> Nomi estesi per flotte<br>
			<input type="checkbox" name="title" onclick="closeMessage()"> Inserisci titolo
		</td>

		<td valign="top" class="f3">
			<input type="checkbox" name="shortcr" onclick="closeMessage()"> 1&deg; e ultimo round<br>
			<input type="checkbox" name="quote" onclick="closeMessage()"> Tag [quote]<br>
			<input type="checkbox" name="center" onclick="closeMessage()"> Tag [center]<br>
			<input type="checkbox" name="list" onclick="closeMessage()"> Testo rientrato
			
		</td>

		<td width="10px"></td>
		<td valign="top" class="f4">
			<table cellspacing=0><tr>
			<td>Messaggio ultimo round:
			<input style="width:125px" name="msg" style="border: 1px groove" type="text" 
			value="Dopo la battaglia..." onclick="closeMessage()" class="inp"></td></tr></table>

			<table cellspacing=0><tr>
			<td>Ally attacc.:
			<input style="width:60px" name="allyA" style="border: 1px groove"type="text"
			onclick="closeMessage()" class="inp">
			Ally difens.:
			<input style="width:60px" name="allyD" style="border: 1px groove"type="text"
			onclick="closeMessage()" class="inp"></td>

			</tr></table>

			<table cellspacing=0><tr>
			<td>Vis. flotte:</td> 
			<td><input type="radio" name="fleetView" value="0" onclick="closeMessage()"> Standard</td>
			<td><input type="radio" name="fleetView" value="1" onclick="closeMessage()"> Riga</td>
			<td><input type="radio" name="fleetView" value="2" checked onclick="closeMessage()"> Colonna</td>

			</tr><tr>
			<td>Sfondo: </td>
			<td><input type="radio" name="bground" value="0" onclick="closeMessage()"> Chiaro</td>
			<td><input type="radio" name="bground" value="1" checked onclick="closeMessage()"> Scuro</td></tr>
			</table>

		</td>

		</tr>
		</table>

		<table  height="35px" class="g">
		<tr>
		<td width="290px" class="g1">
			<input style="width:85px" class="button" type="button" onclick="convert(); closeMessage(); blur();" value="Converti">
			<input style="width:85px" class="button" type="button" onclick="html(); closeMessage(); blur();" value="Html">
			<input style="width:85px" class="button" type="button" onclick="preview(); blur();" value="Anteprima">

		</td>
		<td width="200px" class="g2"> 
			<input style="width:85px" name="cancelb" class="button" type="button" onclick="cancel(); closeMessage(); blur();"  value="Cancella">	
			<input style="width:85px" class="button" type="button" onclick="clipBoard(); closeMessage(); blur();" value="Copia">	
		</td> 
		<td width="255px" align="right" class="g3">
			<input style="width:85px" class="button" type="button" onclick="about(); blur();"  value="?">
			</td>
		</tr>
		</table>
	</td>

</tr>
</table>
</form>
</body>
<script language="JavaScript">loadPref();</script>
</html>