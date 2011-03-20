
function message(str, caption) {
	var alertDiv = document.getElementById("alert");
	alertDiv.style.visibility = "visible";
	if (!caption)
		caption = "Alert";
	alertDiv.innerHTML ="<table><tr><th>"+caption+"</th></tr>"+
		"<tr><td colspan='2'>"+str+"</td></tr><tr>"+
		"<td colspan='2' style='height: 18px;'><input class='button' type='button' value='OK' onclick='closeAlert();'></td></tr></table>";
}

function closeAlert() {
	var alertDiv = document.getElementById("alert");
	alertDiv.style.visibility = "hidden";
}

function save(type, name) {
	var f = document.getElementById('crform');
	var dizi = new Array();
	if (type == 'cookie') {
		if (name == 'cr') {
			dizi.push(f.tech.checked);
			dizi.push(f.coor.checked);
			dizi.push(f.center.checked);
			dizi.push(f.column.checked);
			dizi.push(f.attackerName.checked);
			dizi.push(f.defenderName.checked);
			dizi.push(f.forumType.value);
			dizi.push(f.message.value);
			dizi.push(f.language.value);
			dizi.push(f.background.value);
			dizi.push(0);
			dizi.push(f.fixFont.checked);
			setCookie('cr', dizi.toString());
		}
	}
}

function load(type, name) {
	var f = document.getElementById('crform');
	if (type == 'cookie') {
		if (name == 'cr') {
			var cr = getCookie("cr");
			if (!cr) {
				return;
			}
			var dizi = cr.split(',');
			dizi = dizi.reverse();
			f.tech.checked = (dizi.pop() == 'true');
			f.coor.checked = (dizi.pop() == 'true');
			f.center.checked = (dizi.pop() == 'true');
			f.column.checked = (dizi.pop() == 'true');
			f.attackerName.checked = (dizi.pop() == 'true');
			f.defenderName.checked = (dizi.pop() == 'true');
			f.forumType.value = dizi.pop();
			f.message.value = dizi.pop();
			f.language.value = dizi.pop();
			f.background.value = dizi.pop();
			dizi.pop();
			f.fixFont.checked = (dizi.pop() == 'true');
		}
	}
}

function setCookie(name, value, expires, path, domain, secure)
{
	if (!expires) {
		expires = new Date();
		expires.setFullYear(2015,0,14);
	}
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

function getCookie(Name) {
	var search = Name + "="
	var returnvalue = "";
	if (document.cookie.length > 0) {
		offset = document.cookie.indexOf(search)
		// if cookie exists
		if (offset != -1) {
			offset += search.length
			// set index of beginning of value
			end = document.cookie.indexOf(";", offset);
			// set index of end of cookie value
			if (end == -1) end = document.cookie.length;
				returnvalue=unescape(document.cookie.substring(offset, end))
		}
	}
	return returnvalue;
} 

function deleteCookie(name, path, domain)
{
    if (getCookie(name))
    {
        document.cookie = name + "=" + 
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

var inpValue = '';
function integerControl(inp) {
	if (isNaN(parseInt(inp.value)) && inp.value != '' && inp.value != '-') {
		inp.value = inpValue;
	} else {
		inpValue = inp.value;
	}
}

function positiveIntegerControl(inp) {
	if (isNaN(parseInt(inp.value)) && inp.value != '') {
		inp.value = inpValue;
	} else {
		inpValue = inp.value;
	}
	if (inp.value < 0) {
		inpValue = '';
		inp.value = '';
	}
}

var bgDark = 1;
function formatNumber(s, c1, c2, val,size) {
	if (!size) {
		size = 150;
	}
	var str = "";
	if (bgDark != 1 && c2 && c2.match('#FF9900'))
		c2 = color[i][21];
		
	if (isNaN(s)) {
		str = s;
		if ( c2 ) {
			str = "[color="+c2+"]"+str+"[/color]";
		}
	}
	else {
		if (String(s).indexOf(".")>-1)
		{
			s = String(s).replace(/\./g, '');
		}
		s = parseInt(s);
		var t = String(s);
		var x  = 3;

		while (t.length-x > 0)
		{
			str = "."+t.substr(t.length-x, 3)+str;
			x += 3;
		}
		str = t.substring(0, t.length-x+3)+str;
		if ( c1 && c2 ) {
			if (s>=val)
				str = "[color="+c1+"]"+str+"[/color]";
			else 
				str = "[color="+c2+"]"+str+"[/color]";
		}
		if (val && s>=val)
		{
			str = "[size="+size+"]"+str+"[/size]";
		}
	}
	return str;
}

function formatTime(t) {
	var date = new Array();
	date.push(Math.floor(t / 3600 / 24));
	t -= date[0]*3600*24;
	date.push(Math.floor(t / 3600));
	t -= date[1]*3600;
	date.push(Math.floor(t / 60 ));
	t -= date[2]*60;
	date.push(t);
	/* 1 day 17h 29m 12s */
	var str ='';
	if (date[0])
		str += date[0]+' day ';
	if (date[0] || date[1])
		str += date[1]+'h ';
	if (date[0] || date[1] || date[2])
		str += date[2]+'m ';
	if (date[0] || date[1] || date[2] || date[3])
		str += date[3]+'s ';
	
	return str;
}

function emptyCombo(combo){
	combo.options.length = 0;
}

function fillCombo(dizi, combo) {
	emptyCombo(combo);
	for (var i = 0; i<dizi.length; i++)
		combo.options[i] = new Option(dizi[i][1], dizi[i][0]);
}

function ltrim(str) {
	if (!str)
		return "";
	var i;
	for (i = 0; i < str.length; i++) {
		if (str.charAt(i) != ' ' && str.charAt(i) != '\t' && str.charAt(i) != '\n' && str.charAt(i) != '\r')  
			break;
	}
	return str.substr(i);
}
function rtrim(str) {
	if (!str)
		return "";
	var i;
	for (i=str.length-1; i>=0  ; i--)
	{
		if (str.charAt(i) != ' ' && str.charAt(i) != '\t' && str.charAt(i) != '\n' && str.charAt(i) != '\r')  
			break;
	}
	return str.substring(0,i+1);
}

var den = location.host;

function trim(str) {
	str = ltrim(str);
	str = rtrim(str);
	return str;
}

function changeMenu(obj) {
	for (i = 0; document.getElementById('menu'+i); i++) {
		document.getElementById('menu'+i).className='button';
	}
	obj.className = 'selected';
}

/*
var xx = 0;
for (i=0; i<den.length; i++)
	xx += den.charCodeAt(i);
var kulak;
if (parent.frames[0])
	kulak = parent.frames[0].location.host.match('takanacity');

*/