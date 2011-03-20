function fixFont() {
	f = document.getElementById('crform');
	tech = f.tech.checked;
	coor = f.coor.checked;
	var str = "";

	if (attacker) {
		for (var i = 0; attacker[i]; i++) {
			str += fixFontPlayerMessage(text[0][lang], attacker[i], attackerA[i], tech, coor, true);
		}
	}

	str += createFixTalan();
	str += createFixLost(true);
	str += '\n\n';

	if (defender) {
		for (var i = 0; defender[i]; i++) {
			str += fixFontPlayerMessage(text[1][lang], defender[i], defenderA[i], tech, coor, false);
		}
	}

	str += createFixLost(false);
	str += '\n\n';
	str += createLastInfo();

	c = '#66FFCC';
	if (bgDark != 1)
		c = '#550055';
	str += "\n\n[color="+c+"][size=10][url=http://ru.syndiga.com]"+" -- End of Battle Compression --"+"[/url][/size][/color]";

	if (f.center.checked)
		str = '[CENTER]\n'+str+'\n[/CENTER]';

	return "[size=11]"+str+"[/size]";

}

function fixFontPlayerMessage(what, p, pA, tech, coor, isAttacker) {
	var str = '';
	str += '[font=verdana]'+createPlayerLine(what, p, coor);
	if (tech)
		str += createTechLine(p, tech);
	str += "[/font]"+createFixFleet(p[5], p[6], pA[5], pA[6], isAttacker);
	str = str+'\n\n';
	return str;
}

function createFixFleet(name, number, nameA, numberA, isAttacker) {
	var strName = '';
	var strNumber = '';
	var strNumberA = '';
	var strFark = '';
	var b;
	var c;
	if (bgDark != 1) {
		b = '#ddddff';
		c = '#001144';
	}
	else {
		b = '#1F273C';
		c = '#B0C0DE'; 
	}
	var bgC = b;
	var ll = 0;
	for(var i = 0; name && i < name.length; i++) {
		var sname = name[i];
		sname = trim(sname);
		c = getColor(sname);

		var nA = getAfterNumber(name[i], nameA, numberA);
		var fark = nA - number[i];
		fark = String(fark);
		var n = formatNumber(number[i]);
		nA = formatNumber(nA);
		fark = formatNumber(-fark);
		fark = '-'+fark;
		var l1 = sname.length;
		var l2 = n.length;
		var l3 = nA.length;
		var l4 = fark.length;
		nA = '[color='+c+']'+nA+'[/color]';
		sname = sname.replace(/\t/g, '_');
		sname = sname.replace(/\t/g, '_');
		sname = sname.replace(/\n/g, '_');
		sname = '[color='+c+']'+sname+'[/color]';
		n = '[color='+c+']'+n+'[/color]';
		fark = '[color='+color[22]+']'+fark+'[/color]';
		var l;
		l = l1;
		if (l2 > l) 
			l = l2;
		if (l3 > l)
			l = l3;
		if (l4 > l)
			l = l4;
		ll += l+1;
		for (var x = 0; x < l - l1; x++) {
			sname = '_'+sname;
		}

		for (var x = 0; x < l - l2; x++) {
			n = '_'+n;
		}

		for (var x = 0; x < l - l3; x++) {
			nA = '_'+nA;
		}

		for (var x = 0; x < l - l4; x++) {
			fark = '_'+fark;
		}

		strName += '[color='+bgC+']'+sname+'[/color] ';
		strNumber +='[color='+bgC+']'+n+'[/color] ';
		strNumberA +='[color='+bgC+']'+nA+'[/color] ';
		strFark +='[color='+bgC+']'+fark+'[/color] ';
	}
	strName = strName.replace("\n", ' ');
	strNumber = strNumber.replace("\n", ' ');
	strNumberA = strNumberA.replace("\n", ' ');
	strFark = strFark.replace("\n", ' ');
	var tata = text[18][lang];
	if (!name) {
		tata = ' -- NO DEFENCE -- '
	}
	var dest = ' [color='+color[22]+']'+tata+'[/color] ';
	if (!name) {
		dest = '__'+dest+'_';
	}
	var left = true;
	if (ll < 30) {
		strName += '[color='+bgC+']'; 
		strNumberA += '[color='+bgC+']';  
		strNumber += '[color='+bgC+']';  
		strFark += '[color='+bgC+']'; 
		for (var x = ll; x<=30; x++) {
			strName += '_'; 
			strNumberA += '_'; 
			strNumber += '_'; 
			strFark += '_'; 
		}
		strName += '[/color]'; 
		strNumberA += '[/color]'; 
		strNumber += '[/color]';   
		strFark += '[/color]'; 
		ll = 30;
	}
	for (var x = 0; x < ll - tata.length - 2; x++) {
		if (left)
			dest = '_'+dest;
		else
			dest = dest+'_';
		left = !left;
	}
	dest ='[color='+bgC+']'+dest+'[/color] ';

	if (!name) {
		return "[font=courier new][U]"+strNumber+"[/U]\n[U]"+dest+"[/U][/font]";
	}
	if (!nameA) {
		return "[font=courier new][U]"+strName+"[/U]\n"+strNumber+"\n[U]"+dest+"[/U][/font]";
	}
	return "[font=courier new][U]"+strName+"[/U]\n"+strNumber+"\n"+strFark+"\n[U]"+strNumberA+"[/U][/font]";
}

function getAfterNumber(name,nameA,numberA) {
	if (!nameA) {
		return 0;
	}
	var s = trim(name);
	for (var i = 0; i<nameA.length ; i++) {
		var sA = trim(nameA[i]);
		if (sA.indexOf(s)==0) {
			return numberA[i];
		}
	}
	return 0;
}


function getLighter(color) {
	var tt = color.substr(0,2);
	if (tt == 'FF') {
		var t = color[2];
		if (t == '0') t = '22';
		else if (t == '1') t = '00';
		else if (t == '2') t = '44';
		else if (t == '3') t = '11';
		else if (t == '4') t = '66';
		else if (t == '5') t = '33';
		else if (t == '6') t = '88';
		else if (t == '7') t = '55';
		else if (t == '8') t = 'AA';
		else if (t == '9') t = '77';
		else if (t == 'A') t = 'CC';
		else if (t == 'B') t = '99';
		else if (t == 'C') t = 'EE';
		else if (t == 'D') t = 'BB';
		else if (t == 'E') t = 'FF';
		else if (t == 'F') t = 'DD';
		var c = 'FF'+String(t)+'00';
	}
	else if (color.substr(2,2) == 'FF') {
		if (t == '0') t = '22';
		else if (t == '1') t = '00';
		else if (t == '2') t = '44';
		else if (t == '3') t = '11';
		else if (t == '4') t = '66';
		else if (t == '5') t = '33';
		else if (t == '6') t = '88';
		else if (t == '7') t = '55';
		else if (t == '8') t = 'AA';
		else if (t == '9') t = '77';
		else if (t == 'A') t = 'CC';
		else if (t == 'B') t = '99';
		else if (t == 'C') t = 'EE';
		else if (t == 'D') t = 'BB';
		else if (t == 'E') t = 'FF';
		else if (t == 'F') t = 'DD';
		var c = 'FF00'+String(t);
	}
	return c;
}

function createFixTalan() {
	var str = '';
	str += text[8][lang]+" [B]"+formatNumber(ganimet[0], color[22], color[21],5000000, 13)+"[/B] "+
		text[13][lang]+", [B]"+formatNumber(ganimet[1], color[22], color[21],5000000, 13)+
	   "[/B] "+text[14][lang]+" "+text[21][lang]+" [B]"+formatNumber(ganimet[2], color[22], color[21],5000000, 13)+
	   "[/B] "+text[15][lang]+".\n";

	return '[font=verdana]'+str+'[/font]';
}

function createFixLost(isAttacker) {
	var str = '';
	if (isAttacker){
		str += text[16][lang]+"[B]"+formatNumber(lost[0], color[22], color[21],10000000, 13)+"[/B] "+text[19][lang]+".\n";
	}
	else {
		str += text[17][lang]+"[B]"+formatNumber(lost[1], color[22], color[21],10000000, 13)+"[/B] "+text[19][lang]+".\n";
	}

	return '[font=verdana]'+str+'[/font]';
}

function createLastInfo() {
	var str = '';
	str += text[10][lang]+" [B]"+formatNumber(garbage[0], color[22], color[21],10000000, 13)+"[/B] "+text[13][lang]+" "+
		   text[21][lang]+" [B]"+formatNumber(garbage[1], color[22], color[21],10000000, 13)+"[/B] "+text[14][lang]+".\n"+
		   text[11][lang]+"[B]"+formatNumber(moonChance, color[22], color[21],20, 13)+"[/B] %.\n"
	if (moonCreated) {
		str += "[B][color="+color[21]+"]"+text[22][lang]+".[/color][/B]\n";
	}
	return str;
}