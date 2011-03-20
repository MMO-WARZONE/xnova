var t; // report
var f; // form
var attacker = new Array(); // array
var defender;
var attackerA; // array
var defenderA;
var rp; // rapor parcalari
var time = "----";
var firstA;
var firstD;
var ganimet = new Array(0, 0, 0);
var garbage = new Array(0, 0);
var lost = new Array(0, 0);
var moonChance = 0;
var moonCreated = false;
var ver = " v0.8";
var bgDark = 1;

var text = new Array(
new Array('Attacker', 'Aanvaller', 'Angreifer'),  // 0
new Array('Defender', 'Verdediger', 'Verteidiger'), // 1
new Array('At ',
'De volgende vloten kwamen elkaar tegen op ',
'Folgende Flotten stehen sich um'), // 2
new Array('Weapons: ', 'Wapens: ', 'Waffen: '), //3
new Array('Shields: ', 'Schilden: ', 'Schilde: '),  // 4
new Array('Armour: ', 'Romp beplating: ','Hülle: '), //5
new Array('Type', 'Soort', 'Typ'),  // 6
new Array('Total', 'Aantal', 'Anz.'),  // 7
new Array('He captured', 'Hij steelt', 'Er erbeutet'), //8
new Array('lost a total of', 'heeft een totaal van', 'hat insgesamt'), // 9
new Array('At these space coordinates now float',
'Op deze coördinaten in de ruimte zweven nu',
'Auf diesen Raumkoordinaten liegen nun'), // 10
new Array('The chance for a moon to be created is ',
'De kans dat een maan ontstaat uit het puin is ',
'Die Chance einer Mondentstehung beträgt '), //11
new Array('The enormous amounts of drifting metal and crystal particles attract each other and slowly form a lunar satellite in the orbit of the planet.',
'De enorme hoeveelheden van rondzwevend metaal en kristal deeltjes trekken elkaar aan en vormen langzaam een maan, in een baan rond de planeet.',
'Die enormen Mengen an freiem Metall und Kristall ziehen sich an und formen einen Trabanten um den Planeten.'), // 12
new Array('metal', 'Metaal', 'Metall'), // 13
new Array('crystal', 'Kristal', 'Kristall'), // 14
new Array('deuterium', 'Deuterium', 'Deuterium'),  // 15
new Array('The attacker lost a total of ', 'De aanvaller heeft een totaal van ', 'Der Angreifer hat insgesamt '), //16
new Array('The defender lost a total of ', 'De verdediger heeft een totaal van ', 'Der Verteidiger hat insgesamt '), //17
new Array('destroyed', 'Vernietigd', 'Vernichtet'), //18
new Array('units', 'Eenheden verloren', 'Units'), // 19
new Array(', as it came to a battle',
', toen het tot een gevecht kwam',
' gegenüber'), //20
new Array('and', 'en', 'und'), // 21
new Array('Moon was given', 'Maan gegeven', ''),//22
new Array(null,null,null,null,null,null,null,null,null,null,null,null,null),
new Array(null,null,null,null,null,null,null,null,null,null,null,null,null),
new Array(null,null,null,null,null,null,null,null,null,null,null,null,null)
);

var lang = 0;

function changeLang(val) {
	lang = val;
}

function getLanguage(val){
	ajaxpack.postAjaxRequest("getcrlang.php", "lang="+val, addLangFile, "txt");
}

function update() {
	var obj = document.getElementById("preview");
	obj.innerHTML = "<iframe width='100%' height='250' border='0' frameborder='0' src='pages/cr/update.html' style='border: none'></iframe>";
	var obj = document.getElementById("note1");
	obj.innerHTML = "Update";
	var obj = document.getElementById("note0");
	obj.innerHTML = "Update";
	document.getElementById("message").style.visibility = "visible";
}

function closeMessage() {
	document.getElementById("message").style.visibility = "hidden";
}

function preview() {
	var str = convert();
	if (!str)
	return;

	str = str.replace(/[[]/gi,"<");
	while (str.match("]")) {
		str = str.replace("]",">");
	}
	while (str.match("\n")) {
		str = str.replace("\n","<br>");
	}
	while (str.match("<font=courier new>")) {
		str = str.replace("<font=courier new>","<font face='courier new'>");
	}
	while (str.match("</color>")) {
		str = str.replace("</color>","</font>");
	}
	while (str.match("<color")) {
		str = str.replace("<color","<font color");
	}
	while (str.match("_")) {
		str = str.replace("_","&nbsp;");
	}
	str +="<br>"
	var obj = document.getElementById("preview");
	obj.innerHTML = str;
	var obj = document.getElementById("note1");
	obj.innerHTML = "Preview";
	var obj = document.getElementById("note0");
	obj.innerHTML = "Preview";

	f = document.getElementById('crform');
	var bg = bgDark;
	var b;
	var c;
	if (bg != 1) {
		b = '#ddddff';
		c = '#001144';
	}
	else {
		b = '#1F273C';
		c = '#B0C0DE';
	}
	document.getElementById("message").style.visibility = "visible";
	document.getElementById("preview").style.background = b;
	document.getElementById("preview").style.color = c;
}

var cr;

function convert() {

	f = document.getElementById('crform');

	cr = f.report.value;
	cr = cr.replace(/\\/g, '');
	setColorPalette(f.background.value);

	var l = -1;
	if (cr.match("Attacker"))
	l =0;
	else if (cr.match('Angreifer'))
	l = 12;
	else if (cr.match("Aanvaller"))
	l = 1;
	else if (cr.match("Odbranioc"))
	l = 3;
	else if (cr.match("Agresor")) {
		if (cr.match("znajduj"))
		if (cr.match("stracił łącznie"))
		l = 11;
		else
		l = 7;
		else
		l = 4;
	}
	else if (cr.match("Attaquant")) {
		if (cr.match('unités de'))
		l = 9;
		else
		l = 5;
	}
	else if (cr.match("Attaccante"))
	l = 6;
	else if (cr.match('Obranioc'))
	l = 8;
	else if (cr.match('Saldiran'))
	l = 10;
	else if (cr.match('Atacante'))
	l = 13;
	else if (cr.match('Angriber'))
	l = 15

	if (l == 10)
	{
		cr = cr.replace(/Saldiri filosunun/g, '');
		cr = cr.replace(/Savunan filonun/g, '');
	}

	if (l == 12)
	{
		cr = cr.replace(/des Verteidigers/g, '');
		cr = cr.replace(/des Angreifers/g, '');
		cr = cr.replace(/den Verteidiger/g, '');
		cr = cr.replace(/den Angreifer/g, '');
	}

	if (l == 13)
	{
		if (cr.match('Blindaje'))
		l = 14;
	}

	try {
//		if (( parent.xx != 1833 ) ||  (l<0) || (pirt != parent.den))
		if (l < 0)
		{
			message("Bad CR!!!");
			return false;
		}
	}
	catch (err) {
		message("Bad CR!!!");
		return false;
	}

	changeLang(l);
	if (l == 11)
	f.language.value = 7;
	else
	f.language.value = l;


	time = getTime();

	var done = false;
	attacker = new Array();
	while (!done)
	{
		var a = getAttacker();
		if (a != null) {
			attacker.push(a);
		} else {
			done = true;
		}
	}

	done = false;
	defender = new Array();
	while (!done)
	{
		var a = getDefender();
		if (a != null) {
			defender.push(a);
		} else {
			done = true;
		}
	}

	defender = defender.reverse();
	defenderA = new Array();
	for (var i = 0; i<defender.length; i++)
	{
		defenderA.push(getDefenderA(defender[i][0]));
	}
	defender = defender.reverse();
	defenderA = defenderA.reverse();

	attacker = attacker.reverse();
	attackerA = new Array();
	for (var i = 0; i<attacker.length; i++)
	{
		attackerA.push(getAttackerA(attacker[i][0]));
	}
	attacker = attacker.reverse();
	attackerA = attackerA.reverse();

	if (cr.indexOf(text[8][lang]) > -1)
	getGanimet( cr.substr(cr.indexOf(text[8][lang])) );
	else
	ganimet = new Array('-','-','-');

	getLost(cr);

	if (cr.indexOf(text[10][lang]) > -1)
	getGarbage( cr.substr(cr.indexOf(text[10][lang])) );
	else
	garbage = new Array('-','-');

	if (cr.indexOf(text[11][lang]) > -1)
	getMoonChance(cr.substr(cr.indexOf(text[11][lang])))
	else
	moonChance = 0;

	if (cr.match(text[12][lang].substring(0,10)))
	moonCreated = true;
	else
	moonCreated = false;

	if (f.fixFont.checked == true)
	str = fixFont();
	else
	str = createMessage();

	if (f.forumType.value == 1)
	f.formatedReport.value = proboard(str);
	else if (f.forumType.value == 2)
	f.formatedReport.value = smf(str);
	else
	f.formatedReport.value = str;
	return str;
}

function proboard(str) {
	str = str.replace(/color=#/g, 'color=');
	str = str.replace(/size=10/g, 'size=1');
	str = str.replace(/size=16/g, 'size=3');
	return str;
}

function getAttackerA(name) {
	var x = cr.lastIndexOf(text[0][lang]+rtrim(name));
	if (x < 0)
	{
		return null;
	}
	cr  = cr.substring(0, x-1)+'----'+cr.substr(x+text[0][lang].length);
	var t;
	t = cr.substr(x);
	var p1 = 4;
	var p2 = t.indexOf("(");
	p2++;
	var p1 = t.indexOf(")");
	var coor = '----';
	if (p1>-1 && p2>-1)
	{
		coor = t.substring(p2,p1);
	} else {
		p2 = t.indexOf("[");
		p2++;
		p1 = t.indexOf("]");
		if (p1>-1 && p2>-1)
		{
			coor = t.substring(p2,p1);
		}
	}
	var p1 = t.indexOf(text[6][lang]);
	var p2 = t.indexOf(text[7][lang]);
	var p3 = t.indexOf(text[18][lang]);
	if ((p3 < p1 && p3 > -1) || p1 < 0 || p2 < 0)
	{
		return new Array(name, coor, null, null, null, null, null);
	}
	var types = getWordArray(t.substr(p1+text[6][lang].length));
	var numbers = getWordArray(t.substr(p2+text[7][lang].length))
	return new Array(name, coor, null, null, null, types, numbers);
}

function getDefenderA(name) {
	var x = cr.lastIndexOf(text[1][lang]+rtrim(name));
	if (x < 0)
	{
		return null;
	}
	cr  = cr.substring(0, x-1)+'----'+cr.substr(x+text[1][lang].length);
	var t;
	t = cr.substr(x);
	var p1 = 4;
	var p2 = t.indexOf("(");
	p2++;
	var p1 = t.indexOf(")");
	coor = '----';
	if (p1>-1 && p2>-1)
	{
		coor = t.substring(p2,p1);
	} else {
		p2 = t.indexOf("[");
		p2++;
		p1 = t.indexOf("]");
		if (p1>-1 && p2>-1)
		{
			coor = t.substring(p2,p1);
		}
	}
	var p1 = t.indexOf(text[6][lang]);
	var p2 = t.indexOf(text[7][lang]);
	var p3 = t.indexOf(text[18][lang]);
	if ((p3 < p1 && p3 > -1) || p1 < 0 || p2 < 0)
	{
		return new Array(name, coor, null, null, null, null, null);
	}
	var types = getWordArray(t.substr(p1+text[6][lang].length));
	var numbers = getWordArray(t.substr(p2+text[7][lang].length))
	return new Array(name, coor, null, null, null, types, numbers);
}

function getAttacker() {
	var x = cr.indexOf(text[0][lang]);
	var y = cr.indexOf(text[1][lang]);
	if (x > y || x < 0)
	{
		return null;
	}
	cr = cr.replace(text[0][lang], "----");
	var t = cr.substr(x);
	var p1 = 4;
	var p2 = t.indexOf("(");
	var name = t.substring(p1,p2);
	p2++;
	var p1 = t.indexOf(")");
	var coor = '----';
	if (p1>-1 && p2>-1)
	{
		coor = t.substring(p2,p1);
	} else {
		p1 = 4;
		p2 = t.indexOf("[");
		name = t.substring(p1,p2);
		p2++;
		p1 = t.indexOf("]");
		if (p1>-1 && p2>-1)
		{
			coor = t.substring(p2,p1);
		}
		else {
			tmp = t.substr(4);
			name = getWord();
			name = ' '+rtrim(name)+' ';
		}
	}
	var t1 = getTech(t, text[3][lang]);
	var t2 = getTech(t, text[4][lang]);
	var t3 = getTech(t, text[5][lang]);
	var p1 = t.indexOf(text[6][lang]);
	var p2 = t.indexOf(text[7][lang]);
	var types = getWordArray(t.substr(p1+text[6][lang].length));
	var numbers = getWordArray(t.substr(p2+text[7][lang].length))
	return new Array(name, coor, t1, t2, t3, types, numbers);
}

function getDefender() {
	var x = cr.indexOf(text[1][lang]);
	var y = cr.indexOf(text[0][lang]);
	if (x >= y && !( x>0 && y<0)) {
		return null;
	}
	cr = cr.replace(text[1][lang], "----");
	var t = cr.substr(x);
	var p1 = 4;
	var p2 = t.indexOf("(");
	var name = t.substring(p1,p2);
	p2++;
	var p1 = t.indexOf(")");
	var coor = '----';
	if (p1>-1 && p2>-1)
	{
		coor = t.substring(p2,p1);
	} else {
		p1 = 4;
		p2 = t.indexOf("[");
		name = t.substring(p1,p2);
		p2++;
		p1 = t.indexOf("]");
		if (p1>-1 && p2>-1)
		{
			coor = t.substring(p2,p1);
		}
		else {
			tmp = t.substr(4);
			name = getWord();
			name = ' '+rtrim(name)+' ';
		}
	}
	var t1 = getTech(t, text[3][lang]);
	var t2 = getTech(t, text[4][lang]);
	var t3 = getTech(t, text[5][lang]);
	var p1 = t.indexOf(text[6][lang]);
	var p2 = t.indexOf(text[7][lang]);
	var p3 = t.indexOf(text[18][lang]);
	if ((p3 < p1 && p3 > -1) || p1 < 0 || p2 < 0)
	{
		return new Array(name, coor, t1, t2, t3, null, null);
	}
	var types = getWordArray(t.substr(p1+text[6][lang].length));
	var numbers = getWordArray(t.substr(p2+text[7][lang].length))
	return new Array(name, coor, t1, t2, t3, types, numbers);
}


var tmp;
function getWordArray(s) {
	var arr = new Array();
	tmp = s;
	var word = getWord();
	while (word != null)
	{
		arr.push(word);
		word = getWord();
	}
	for(var i=0; i<arr.length; i++) {
		if ((arr[i].match("Sol")) && (lang==12))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		else if
		((
		(arr[i].match("Sol")) ||
		(arr[i].match("Kol")) ||
		(arr[i].match("Col")) ||
		(arr[i].match("Ion") && lang == 0) ||
		(arr[i].match("Spionage")) ||
		(arr[i].match("Zonneenergie"))) &&
		(lang<3)
		) {
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		if ((arr[i].match("Ster")))
		{
			arr[i] += arr[i+1] + arr[i+2];
			arr.splice(i+1, 2);
		}
		if
		(
		((arr[i].match("Petit")) ||
		(arr[i].match("Grand")) ||
		(arr[i].match("Chasseur")) ||
		(arr[i].match("Sonde")) ||
		(arr[i].match("Sat.")) ||
		(arr[i].match("Can.")) ||
		(arr[i].match("Pet.")) ||
		(arr[i].match("Grd.")) ||
		(arr[i].match("Laser"))) &&
		(lang==5)
		) {
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		if (
		((arr[i].match("Artillerie")) ||
		(arr[i].match("Lanc.")) ||
		(arr[i].match("Vaisseau"))
		) &&
		(lang==5))
		{
			arr[i] += arr[i+1] + arr[i+2];
			arr.splice(i+1, 2);
		}
		if ( /* italian */
		((arr[i].match("Cargo")) ||
		(arr[i].match("Caccia")) ||
		(arr[i].match("N.")) ||
		(arr[i].match("Sonda")) ||
		(arr[i].match("Sat.")) ||
		(arr[i].match("C.")) ||
		(arr[i].match("Laser")) ||
		(arr[i].match("Cup.") && arr[i+1].match("p."))
		) &&
		(lang==6))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		if ( /* turkish */
		((arr[i].match("Komuta")) ||
		(arr[i].match("Geri")) ||
		(arr[i].match("Ölüm")) ||
		(arr[i].match("Iyon")) ||
		(arr[i].match("Gaus")) ||
		(arr[i].match("Kalkan")) ||
		(arr[i].match("B.Kalkan"))
		) &&
		(lang==10))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}

		if ( /* brazilian / portegues */
		((arr[i].match("Caça")) ||
		(arr[i].match("Laser"))
		) &&
		(lang==13))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		if ( /* spanish */
		((arr[i].match("Cazador")) ||
		(arr[i].match("Satélite")) ||
		(arr[i].match("Láser")) ||
		(arr[i].match("Cúpula"))
		) &&
		(lang==14))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}
		/* spanish */
		if ((arr[i].match("Nave")) && (lang == 14))
		{
			arr[i] += arr[i+1] + arr[i+2];
			arr.splice(i+1, 2);
		}
		if ((arr[i].match("Cr.")) && (lang == 14))
		{
			arr[i] += arr[i+1];
			arr.splice(i+1, 1);
		}


	}

	return arr;
}

function getWord() {
	var i = 0;
	while(tmp.charAt(i) == ':' ||  tmp.charAt(i) == ' ' || tmp.charAt(i) == '\t' )
	i++;
	x = i;
	while(tmp.charAt(i) != ' ' && tmp.charAt(i) != '\t' && tmp.charAt(i) != '\n' && tmp.charAt(i) != '\r')
	i++;
	y = i;
	if (y==x) {
		return null;
	}
	var ret = tmp.substring(x, y+1);
	tmp = tmp.substr(y);
	return ret;
}

var ship = new Array(
new Array ('S.Cargo', 'L.Cargo', 'L.Fighter', 'H.Fighter', 'Cruiser', 'Battleship', 'Recy.', 'Col', 'Esp', 'Bomber', 'Sol', 'Dest.', 'Deathstar', 'R.Launcher', 'L.Laser', 'H.Laser', 'Ion C.', 'Gauss', 'Plasma', 'S.Dome', 'L.Dome', 'Battlecr.'),
new Array ('K.Vrachtschip', 'G.Vrachtschip', 'L.Gevechtsschip', 'G.Gevechtsschip', 'Kruiser', 'Slagschip', 'Schoonmaker', 'Kol.', 'Spionage', 'Bommenwerper', 'Zonneenergie', 'Vernietiger', 'Ster', 'Raketten', 'K.Laser', 'G.Laser', 'Ion.K', 'Gauss', 'Plasma', 'K.Koepel', 'G.Koepel'),
new Array ()
);

var colorPalette = new Array();
var colorD = new Array('#aa3300', '#116600', '#995500', '#aa0000', '#446633', '#0000bb', '#007799', '#331100', '#000044', '#004422', '#330044', '#443300', '#aa0000', '#004477', '#004411', '#0000aa', '#002233', '#330000', '#002200', '#002255', '#002255') ;
var color = new Array('#FF9900','#00FF00','#33FF99','#FF00FF','#00FFFF','#FFCC00','#0099FF', '#EEC273', '#FF0099', '#00FF99', '#00B0B0', '#B000B0', '#A099FF', '#A0FF99', '#FF99A0', '#99FFA0','#99A0FF', '#9900FF', '#CCFFCC', '#FFCC99', '#FFCC99');

// 22 uzunlukta

colorPalette.push(colorD);
colorPalette.push(color);

function getColor(t) {
	var bg = bgDark;
	var c = color;

	for (var i = 0; i<ship[lang].length; i++) {
		if (t.match(ship[lang][i]))
		return c[i];
	}
	return c[Math.round(Math.random()*(21))];
}

var colorUse = new Array();

function createTechLine(p, tech) {
	if (tech) {
		return text[3][lang]+"[B]"+p[2]+"[/B]% "+text[4][lang]+"[B]"+p[3]+"[/B]% "+text[5][lang]+"[B]"+p[4]+"[/B]%\n";
	}
	else {
		return text[3][lang]+"XXX% "+text[4][lang]+"XXX% "+text[5][lang]+"XXX%\n";
	}
}

function createPlayerLine(what, p, coor) {
	f = document.getElementById('crform');
	var name = true;
	var c = color[24];
	if (what.match(text[0][lang])) {
		name = f.attackerName.checked;
		c = color[23];
	}
	else {
		name = f.defenderName.checked;
	}
	if (!name)
	p[0] = ' XXXXX ';
	if (coor) {
		return what+" [B][color="+c+"]"+p[0]+"[/color][/B]([B]"+p[1]+"[/B])\n";
	}
	else {
		return what+" [B][color="+c+"]"+p[0]+"[/color][/B](X:XXX:XX)\n";
	}
}

function createFleetMessage(type, n) {
	var str = '';
	for(var i = 0; i < type.length; i++) {
		var t = type[i];
		while ((t.charAt(t.length-1) == "\n") || (t.charAt(t.length-1) == "\r")) {
			t = t.substring(0, t.length-1);
		}
		var c = getColor(t);
		if (n)
		str += '[color='+c+'] '+t+' '+formatNumber(n[i])+'[/color]\n';
		else
		str += "[B][color="+color[25]+"]"+text[18][lang]+"![/color][/B]\n";
	}
	str += '\n';
	return str;
}

function createPlayerMessage(what, p, tech, coor, first) {
	var str = "";
	f = document.getElementById('crform');
	str += createPlayerLine(what, p, coor);
	if (first) {
		str += createTechLine(p, tech);
	}
	if (!f.column.checked) {
		if (p[5] && p[5][0]) {
			p[5][0] = ltrim(p[5][0]);
		}
		if (p[5] && p[5][0]) {
			str += text[6][lang]+": "+birlestir(p[5], colorUse)+"\n";
			str += text[7][lang]+": "+birlestir(p[6], colorUse)+"\n";
		}
		else {
			str += "[B][color="+color[25]+"]"+text[18][lang]+"![/color][/B]\n";
		}
	}
	else {
		if (p[5] && p[5][0]) {
			str += createFleetMessage(p[5],p[6]);
		}
		else {
			str += "[B][color="+color[25]+"]"+text[18][lang]+"![/color][/B]\n";
		}
	}
	str += "\n";
	return str;
}

function createMessage() {
	f = document.getElementById('crform');
	tech = f.tech.checked;
	coor = f.coor.checked;

	var str =
	text[2][lang]+" [B]"+
	time +
	"[/B]"+text[20][lang]+":\n\n";

	if (attacker) {
		for (var i = 0; attacker[i]; i++) {
			str += createPlayerMessage(text[0][lang], attacker[i], tech, coor, true);
		}
	}

	if (defender){
		for (var i = 0; defender[i]; i++) {
			str += createPlayerMessage(text[1][lang], defender[i], tech, coor, true);
		}
	}

	str += f.message.value+"\n\n";

	if (!attackerA) {
		attackerA = new Array();
	}

	for (var i = 0; attackerA[i]; i++) {
		str += createPlayerMessage(text[0][lang], attackerA[i], tech, coor, false);
	}

	if (!defenderA) {
		defenderA = new Array();
	}

	for (var i = 0; defenderA[i]; i++) {
		str += createPlayerMessage(text[1][lang], defenderA[i], tech, coor, false);
	}

	str += text[8][lang]+"\n [B]"+formatNumber(ganimet[0], color[22], color[21],5000000)+"[/B] "+
	text[13][lang]+", [B]"+formatNumber(ganimet[1], color[22], color[21],5000000)+
	"[/B] "+text[14][lang]+" "+text[21][lang]+" [B]"+formatNumber(ganimet[2], color[22], color[21],5000000)+
	"[/B] "+text[15][lang]+".\n\n";

	str += text[16][lang]+"[B]"+formatNumber(lost[0], color[22], color[21],10000000)+"[/B] "+text[19][lang]+".\n"+
	text[17][lang]+"[B]"+formatNumber(lost[1], color[22], color[21],10000000)+"[/B] "+text[19][lang]+".\n"+
	text[10][lang]+" [B]"+formatNumber(garbage[0], color[22], color[21],10000000)+"[/B] "+text[13][lang]+" "+
	text[21][lang]+" [B]"+formatNumber(garbage[1], color[22], color[21],10000000)+"[/B] "+text[14][lang]+".\n"+
	text[11][lang]+"[B]"+formatNumber(moonChance, color[22], color[21],20)+"[/B] %.\n"


	if (moonCreated) {
		str += text[12][lang]+" [B][color=#FF9900]"+text[22][lang]+".[/color][/B]";
	}

	c = '#66FFCC';
	if (bgDark != 1)
	c = '#550055';
	str += "\n\n[color="+c+"][size=10][url=http://ru.syndiga.com]"+" -- Battlereport End --"+"[/url][/size][/color]";

	if (f.center.checked)
	str = '[CENTER]\n'+str+'\n[/CENTER]';

	str = str.replace(/  /g, " ");

	str = str.replace(/\r/g, "");
	str = str.replace(/\t/g, " ");
	str = str.replace(/ \n/g, "\n");
	str = str.replace(/\n /g, "\n");
	str = str.replace(/ \n/g, "\n");
	str = str.replace(/\n /g, "\n");

	str = str.replace(/\n\n\n/g, "\n\n");
	str = str.replace(/\n\n\n/g, "\n\n");
	str = str.replace(/\n\n\n/g, "\n\n");
	str = str.replace(/\n\n\n/g, "\n\n");
	str = str.replace(/\n\n\n/g, "\n\n");
	str = str.replace(/\n\n\n/g, "\n\n");

	return str;
}

function birlestir(dizi, clr) {
	var str = "";

	if (dizi == undefined) {
		clr.splice(0, clr.length);
		dizi = new Array();
	}

	if (!parseInt(dizi[0])) {
		clr.splice(0, clr.length);
	}


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
		str += " [color="+c+"]"+formatNumber(t)+"[/color] ";
	}
	return str;
}

function getMoonChance(p) {
	var str = text[11][lang];
	var x = p.search(str);
	if (x < 0)
	moonChance = '0';
	else
	moonChance = parseInt(p.substr(x+str.length));
}

function getGarbage(p) {
	var y;
	y = p.search(' '+text[13][lang]);
	if (y < 0 )
	{
		garbage[0] = '-';
		garbage[1] = '-';
		return;
	}
	var i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	garbage[0] = p.substring(y-i, y);
	garbage[0] = garbage[0].replace(/\./g, '');

	y = p.search(' '+text[14][lang]);
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	garbage[1] = p.substring(y-i, y);
	garbage[1] = garbage[1].replace(/\./g, '');
}

function getLost(p) {
	var str = text[16][lang];
	if (p.search(str) > 0)
	{
		var x = p.search(str) + str.length;
		lost[0] = "";
		var y = 0;
		while ((!isNaN(parseInt(p.charAt(x+y)))) || (p.charAt(x+y)=='.')) {
			lost[0] += p.charAt(x+y);
			y++;
		}
	} else { lost[0] = "-"; }

	str = text[17][lang];
	if (p.search(str) > 0)
	{
		x = p.search(str) + str.length;
		lost[1] = "";
		y = 0;
		while ((!isNaN(parseInt(p.charAt(x+y)))) || (p.charAt(x+y)=='.')) {
			lost[1] += p.charAt(x+y);
			y++;
		}
	} else { lost[1] = "-"; }
	lost[0] = lost[0].replace(/\./g, '');
	lost[1] = lost[1].replace(/\./g, '');

}

function getGanimet(p) {
	var y = -1;
	y = p.search(' '+text[13][lang]);
	if (y < 0)
	{
		ganimet[0] = '-';
		ganimet[1] = '-';
		ganimet[2] = '-';
		return;
	}
	var i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[0] = p.substring(y-i, y);

	y = p.search(' '+text[14][lang]);
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[1] = p.substring(y-i, y);

	y = p.search(' '+text[15][lang]);
	i = 1;
	while ((!isNaN(parseInt(p.charAt(y-i)))) || (p.charAt(y-i)=='.')) {
		i++;
	}
	ganimet[2] = p.substring(y-i, y);

	return ganimet;
}

function afterWar (at, p) {
	var lines = p.split('\n');
	if (lines.length==1)
	lines = p.split('\n\r');

	var pos = lines[0].search(text[6][lang]);
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
				if ((at[5][i].match("Esp")) ||
				(at[5][i].match("Sol")) ||
				(at[5][i].match("Kol")) ||
				(at[5][i].match("Col")) ||
				(at[5][i].match("Spionage")) ||
				(at[5][i].match("Zonneenergie"))
				) {
					at[5][i] += at[5][i+1];
					at[5].splice(i+1, 1);
				}
				if ((at[5][i].match("Ster")))
				{
					at[5][i] += at[5][i+1] + at[5][i+2];
					at[5].splice(i+1, 2);
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
	var pos = lines[0].search(text[6][lang]);
	var n = 0;
	if (pos > 0){
		n = -1;
	}
	at[2] = getTech(lines[1], text[3][lang]);
	at[3] = getTech(lines[1], text[4][lang]);
	at[4] = getTech(lines[1], text[5][lang]);

	pos = lines[1].search(text[6][lang]);
	if (pos > 0){
		n = -1;
		lines[1] = lines[1].substr(pos);
	}

	if (lines.length > 2+n) {
		at[5] = lines[2+n].split('\t');
		if (at[5].length == 1) {
			at[5] = lines[2+n].split(' ');
			for(var i=0; i<at[5].length; i++) {
				if ((at[5][i].match("Esp")) ||
				(at[5][i].match("Sol")) ||
				(at[5][i].match("Kol")) ||
				(at[5][i].match("Col")) ||
				(at[5][i].match("Spionage")) ||
				(at[5][i].match("Zonneenergie"))
				) {
					at[5][i] += at[5][i+1];
					at[5].splice(i+1, 1);
				}
				if ((at[5][i].match("Ster")))
				{
					at[5][i] += at[5][i+1] + at[5][i+2];
					at[5].splice(i+1, 2);
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
	var x = line.indexOf(what);
	x = x + what.length;

	var i = 0;
	var str = "";
	while (line.charAt(x+i) != '%') {
		str += line.charAt(x+i);
		i++;
	}

	return str;
}

function getTime() {
	var p = cr;
	var str = text[2][lang];
	var x = p.search(str);
	if (x < 0 )
	{
		return "----";
	}
	var l = x+str.length;

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

	if (x==-1)
	return -1;

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

function addBosnianLang()
{
	//#CR WORDS
	text[0][3]='Napadac';		 // Attacker
	text[1][3]='Odbranioc';		 // Defender
	text[2][3]='Slijedece flote su prisutne '; // The following fleets are facing each other at
	text[3][3]='Oruzje: ';		 // Weapons
	text[4][3]='Stitovi: ';		 // Shields
	text[5][3]='Omot: ';		 // Hull Plating
	text[6][3]='Tip';		 // Type
	text[7][3]='Broj';		 // Number
	text[8][3]='On pljacka';		 // He captures
	text[9][3]='je izgubio ukupno';	 // has lost a total of
	text[10][3]='Na ovim koordinatima sada leze'; // At these space coordinates now float
	text[11][3]='Sansa stvaranja mjeseca iznosi '; // The chance for a moon to arise from the debris is
	text[12][3]='Ogromne kolicine slobodnog metala i kristala se privlace i stvaraju trabanta oko planete.'; // The enormous amounts of drifting metal and crystal particles attract each other and slowly form a lunar satellite in the orbit of the planet.
	text[13][3]='Metal';		 // Metal
	text[14][3]='Kristal';		 // Crystal
	text[15][3]='Deuterium';		 // Deuterium
	text[16][3]='Napadac je izgubio ukupno '; // The attacker has lost a total of
	text[17][3]='Odbranioc je izgubio ukupno '; // The defender has lost a total of
	text[18][3]='Unisten';		 // Destroyed
	text[19][3]='jedinica';		 // Units
	text[21][3]='i';			 // and
	text[22][3]='Moon was given.';			 // moon was given.
	text[20][3]='suprostavile';	 // as it came to a battle
	// SHIPS

	ship[3] = new Array('Krstarica', 'B.brodovi.', 'Reci.', 'Kolon.', 'Sonde.spio', 'Bombarder', 'Sol.S', 'Razar.', 'Fatal', 'Rak.', 'L.laser', 'T.laser', 'Bac.ion', 'Gaus', 'Plazma', 'M.kupo', 'V.kupo');
}

var pirt = '';
try {
	pirt = parent.location.host;
}
catch (err) {
}

function addFrenchLang() {
	// CR WORDS

	text[0][5]='Attaquant'; // Attacker
	text[1][5]='Défenseur'; // Defender
	text[2][5]='Les flottes suivantes se trouvent r '; // The following fleets are facing each other at
	text[3][5]='Armes: '; // Weapons
	text[4][5]='Bouclier: '; // Shields
	text[5][5]='Coque: '; // Hull Plating
	text[6][5]='Type'; // Type
	text[7][5]='Nombre'; // Number
	text[8][5]='Il gagne'; // He captures
	text[9][5]='a perdu au total '; // has lost a total of
	text[10][5]='A ces coordonnées se trouve maintenant'; // At these space coordinates now float
	text[11][5]='La probabilité de création de lune est de '; // The chance for a moon to arise from the debris is
	text[12][5]="Les quantités énormes de métal et de cristal forment une nouvelle lune dans l'orbite de cette plancte. "; // The enormous amounts of drifting metal and crystal particles attract each other and slowly form a lunar satellite in the orbit of the planet.
	text[13][5]='Métal'; // Metal
	text[14][5]='Cristal'; // Crystal
	text[15][5]='Deutérium'; // Deuterium
	text[16][5]="L'attaquant a perdu au total "; // The attacker has lost a total of
	text[17][5]='Le défenseur a perdu au total '; // The defender has lost a total of
	text[18][5]='Détruit'; // Destroyed
	text[19][5]='unités'; // Units
	text[20][5]=' '; // as it came to a battle
	text[21][5]='et'; // and
	text[22][5]='une lune a été créer'; // Moon was given

	// SHIPS
	ship[5] = new Array('Petit transporteur', 'Grand transporteur', 'Chasseur léger', 'Chasseur lourd', 'Croiseur', 'Vaisseau de combat', 'Recycleur', 'Vaisseau de colonisation', 'Sonde espionnage', 'Bombardier', 'Sat. sol.', 'Destrct..', 'E.Mort', 'Missile.', 'Laser léger.', 'Laser lourd', 'Artillerie r ions', 'Can. élec.', 'Lanc. de plas.', 'Pet. bouc.', 'Grd. bouc.', 'Traqueur');
}

addBosnianLang();
addFrenchLang();

function setColorPalette(val) {
	color = colorPalette[val];
	bgDark = colorPalette[val][colorPalette[val].length-1];
}

function addOptionToCombo(value, label, combo) {
	combo.innerHTML += "<option value="+value+" style='font-style:italic'>"+label+"</option>";
}


function smf(str) {
	str = str.replace(/size=10/g, 'size=8pt');
	str = str.replace(/size=16/g, 'size=13pt');
	return str;
}

function tableformatclicked() {
	var f = document.getElementById('crform');
	if (f.fixFont.checked) {
		f.column.checked = false;
	}
}
function columnformatclicked() {
	var f = document.getElementById('crform');
	if (f.column.checked) {
		f.fixFont.checked = false;
	}
}

function fillColorPalette(combo) {
	if (combo == null)
	combo = document.getElementById('crform').background;
	//	for (var i=2; i<=combo.options.length; i++)
	//		combo.remove(i);
	combo.options.length = 2;
	var colorPaletteN = getCookie("colorPaletteNames");
	if (!colorPaletteN)
	return;
	colorPaletteN = colorPaletteN.split(',');
	for (var i=0; i<colorPaletteN.length; i++) {
		var cp = getCookie("C_P_"+colorPaletteN[i]).split(",");
		var opt = new Option(colorPaletteN[i],combo.options.length);
		colorPalette[2+i] = cp;
		combo.options.add(opt, combo.options.length);
	}
}



function addTTT() {
	for (var i=0; i<ship.length; i++) {
		if (i != 4) {
			ship[i].push('99.999');
			ship[i].push('99.999.999.999');
			ship[i].push(text[0][i]);
			ship[i].push(text[1][i]);
			ship[i].push(text[18][i]);
		}
	}

	colorPalette[1].push('#FF9900'); //21
	colorPalette[1].push('#FF0000'); //22
	colorPalette[1].push('#CCFFCC'); //23
	colorPalette[1].push('#EEC273'); //24
	colorPalette[1].push('#CC99FF'); //25
	colorPalette[1].push(1);         //26
	colorPalette[0].push('#0055AA');
	colorPalette[0].push('#FF0000');
	colorPalette[0].push('#551111');
	colorPalette[0].push('#115511');
	colorPalette[0].push('#550099');
	colorPalette[0].push(0);
}