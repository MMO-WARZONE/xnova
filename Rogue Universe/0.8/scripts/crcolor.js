function colorWindowOpen() {
	var lang = document.getElementById('langCombo').value;
	var obj = document.getElementById("preview");
	obj.innerHTML = "<iframe width='100%' height='250' border='0' frameborder='0' src='pages/cr/colors.php?lang="+lang+"' style='border: none'></iframe>";
	var obj = document.getElementById("note1");
	obj.innerHTML = "Update";
	var obj = document.getElementById("note0");
	obj.innerHTML = "Update";
	document.getElementById("message").style.visibility = "visible";
}

function sssColors() {
	var form = document.colorForm;
	form.tt.value = '';
	for (var i=0; i<form.shipcolor.length; i++) {
		if (form.shipcolor[i].style.color.match("rgb")) {
			form.tt.value += rgbToHex(form.shipcolor[i].style.color) +"\n";
		}
		else {
			form.tt.value += form.shipcolor[i].style.color +"\n";
		}
	}
}

function rgbToHex(rgb) {
	rgb = rgb.replace(/rgb/g, "");
	rgb = rgb.replace(/ /g, "");
	rgb = rgb.replace(/\(/g, "");
	rgb = rgb.replace(/\)/g, "");
	rgb = rgb.split(',');
	var hex = "#";
	hex += decToHex(rgb[0]);
	hex += decToHex(rgb[1]);
	hex += decToHex(rgb[2]);
	return hex;
}

function decToHex(dec)
{
	var hexStr = "0123456789abcdef";
	var low = dec % 16;
	var high = (dec - low)/16;
	hex = "" + hexStr.charAt(high) + hexStr.charAt(low);
	return hex;
}
function lllColors() {
	var form = document.colorForm;
	var str = form.tt.value.replace(/\r/g, "");
	var dizi = str.split('\n');
	for (var i=0; i<form.shipcolor.length; i++) {
		try {
			if (dizi[i])
				form.shipcolor[i].style.color = dizi[i];
			else
				form.shipcolor[i].style.color = '#FFFFFF';
		}
		catch (err) {
			form.shipcolor[i].style.color = '#FFFFFF';
		}
	}
}

function colorTable() {
	var obj = parent.document.getElementById("note1");
	obj.innerHTML = "Color Palette";
	var obj =parent.document.getElementById("note0");
	obj.innerHTML = "Color Palette";

	color = parent.color;
	var bg = color[color.length-1];
	var b;
	if (bg != 1) {
		b = '#ddddff';
	}
	else {
		b = '#1F273C';
	}
	var str = "";
	str += "<table width='99%'><tr><td width='50%'><table width='99%'>";
	for (var i=0; i<ship[lang].length; i++) {
		str += "<tr><td><nobr><input name='shipcolor' onclick='cp2.select(this,\"ship"+i+"\");return false;' type='button' maxlength='7' class='colInp' style='color:"+color[i]+"; background-color:"+b+"' value='"+ship[lang][i]+"' >"+
			"<a href='#' NAME='ship"+i+"' ID='ship"+i+"'></a></nobr></td></tr>";
	}
	str += "</table></td><td align='center'><input type='button' onclick='lllColors()' value='<' class='button' style='width:25px; height: 25px'><br><br>"+
		"<input type='button' value='>' class='button' onclick='sssColors()' style='width:25px; height: 25px'><br><br><br><br><br><br>"+
		"</td><td valign='top'><textarea id='colorTextArea' name='tt' rows='33' style='width:300px;'></textarea>"+
		"</td></tr></table>";
	document.getElementById('colortable').innerHTML = str;
	
	var form = document.colorForm;
	form.bg.value = bg;	
}

ColorPicker_targetInput = null;
function ColorPicker_writeDiv() {
	document.writeln("<DIV ID=\"colorPickerDiv\" STYLE=\"position:absolute;visibility:hidden;\"> </DIV>");
	}

function ColorPicker_show(anchorname) {
	this.showPopup(anchorname);
	}

function ColorPicker_pickColor(color,obj) {
	obj.hidePopup();
	pickColor(color);
	}

// A Default "pickColor" function to accept the color passed back from popup.
// User can over-ride this with their own function.
function pickColor(color) {
	if (ColorPicker_targetInput==null) {
		alert("Target Input is null, which means you either didn't use the 'select' function or you have no defined your own 'pickColor' function to handle the picked color!");
		return;
		}
	ColorPicker_targetInput.style.color = color;
	}

// This function is the easiest way to popup the window, select a color, and
// have the value populate a form field, which is what most people want to do.
function ColorPicker_select(inputobj,linkname) {
	if (inputobj.type!="text" && inputobj.type!="hidden" && inputobj.type!="textarea" && inputobj.type!="button") { 
		alert("colorpicker.select: Input object passed is not a valid form input object"); 
		window.ColorPicker_targetInput=null;
		return;
		}
	window.ColorPicker_targetInput = inputobj;
	this.show(linkname);
	}
	
// This function runs when you move your mouse over a color block, if you have a newer browser
function ColorPicker_highlightColor(c) {
	var thedoc = (arguments.length>1)?arguments[1]:window.document;
	var d = thedoc.getElementById("colorPickerSelectedColor");
	d.style.backgroundColor = c;
	d = thedoc.getElementById("colorPickerSelectedColorValue");
	d.innerHTML = c;
	}

function ColorPicker() {
	var windowMode = false;
	// Create a new PopupWindow object
	if (arguments.length==0) {
		var divname = "colorPickerDiv";
		}
	else if (arguments[0] == "window") {
		var divname = '';
		windowMode = true;
		}
	else {
		var divname = arguments[0];
		}
	
	if (divname != "") {
		var cp = new PopupWindow(divname);
		}
	else {
		var cp = new PopupWindow();
		cp.setSize(225,250);
		}

	// Object variables
	cp.currentValue = "#FFFFFF";
	
	// Method Mappings
	cp.writeDiv = ColorPicker_writeDiv;
	cp.highlightColor = ColorPicker_highlightColor;
	cp.show = ColorPicker_show;
	cp.select = ColorPicker_select;
	// Code to populate color picker window
	var colors = new Array("#000000","#000033","#000066","#000099","#0000CC","#0000FF","#330000","#330033","#330066","#330099","#3300CC",
							"#3300FF","#660000","#660033","#660066","#660099","#6600CC","#6600FF","#990000","#990033","#990066","#990099",
							"#9900CC","#9900FF","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#FF0000","#FF0033","#FF0066",
							"#FF0099","#FF00CC","#FF00FF","#003300","#003333","#003366","#003399","#0033CC","#0033FF","#333300","#333333",
							"#333366","#333399","#3333CC","#3333FF","#663300","#663333","#663366","#663399","#6633CC","#6633FF","#993300",
							"#993333","#993366","#993399","#9933CC","#9933FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF",
							"#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#006600","#006633","#006666","#006699","#0066CC",
							"#0066FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF","#666600","#666633","#666666","#666699",
							"#6666CC","#6666FF","#996600","#996633","#996666","#996699","#9966CC","#9966FF","#CC6600","#CC6633","#CC6666",
							"#CC6699","#CC66CC","#CC66FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC","#FF66FF","#009900","#009933",
							"#009966","#009999","#0099CC","#0099FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#669900",
							"#669933","#669966","#669999","#6699CC","#6699FF","#999900","#999933","#999966","#999999","#9999CC","#9999FF",
							"#CC9900","#CC9933","#CC9966","#CC9999","#CC99CC","#CC99FF","#FF9900","#FF9933","#FF9966","#FF9999","#FF99CC",
							"#FF99FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#33CC00","#33CC33","#33CC66","#33CC99",
							"#33CCCC","#33CCFF","#66CC00","#66CC33","#66CC66","#66CC99","#66CCCC","#66CCFF","#99CC00","#99CC33","#99CC66",
							"#99CC99","#99CCCC","#99CCFF","#CCCC00","#CCCC33","#CCCC66","#CCCC99","#CCCCCC","#CCCCFF","#FFCC00","#FFCC33",
							"#FFCC66","#FFCC99","#FFCCCC","#FFCCFF","#00FF00","#00FF33","#00FF66","#00FF99","#00FFCC","#00FFFF","#33FF00",
							"#33FF33","#33FF66","#33FF99","#33FFCC","#33FFFF","#66FF00","#66FF33","#66FF66","#66FF99","#66FFCC","#66FFFF",
							"#99FF00","#99FF33","#99FF66","#99FF99","#99FFCC","#99FFFF","#CCFF00","#CCFF33","#CCFF66","#CCFF99","#CCFFCC",
							"#CCFFFF","#FFFF00","#FFFF33","#FFFF66","#FFFF99","#FFFFCC","#FFFFFF");
	var total = colors.length;
	var width = 18;
	var cp_contents = "";
	var windowRef = (windowMode)?"window.opener.":"";
	if (windowMode) {
		cp_contents += "<HTML><HEAD><TITLE>Select Color</TITLE></HEAD>";
		cp_contents += "<BODY MARGINWIDTH=0 MARGINHEIGHT=0 LEFTMARGIN=0 TOPMARGIN=0><CENTER>";
		}
	cp_contents += "<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=0>";
	var use_highlight = (document.getElementById || document.all)?true:false;
	for (var i=0; i<total; i++) {
		if ((i % width) == 0) { cp_contents += "<TR>"; }
		if (use_highlight) { var mo = 'onMouseOver="'+windowRef+'ColorPicker_highlightColor(\''+colors[i]+'\',window.document)"'; }
		else { mo = ""; }
		cp_contents += '<TD BGCOLOR="'+colors[i]+'"><FONT SIZE="-3"><A HREF="#" onClick="'+windowRef+'ColorPicker_pickColor(\''+colors[i]+'\','+windowRef+'window.popupWindowObjects['+cp.index+']);return false;" '+mo+' STYLE="text-decoration:none;">&nbsp;&nbsp;&nbsp;</A></FONT></TD>';
		if ( ((i+1)>=total) || (((i+1) % width) == 0)) { 
			cp_contents += "</TR>";
			}
		}
	// If the browser supports dynamically changing TD cells, add the fancy stuff
	if (document.getElementById) {
		var width1 = Math.floor(width/2);
		var width2 = width = width1;
		cp_contents += "<TR><TD COLSPAN='"+width1+"' BGCOLOR='#ffffff' ID='colorPickerSelectedColor'>&nbsp;</TD><TD COLSPAN='"+width2+"' ALIGN='CENTER' ID='colorPickerSelectedColorValue'>#FFFFFF</TD></TR>";
		}
	cp_contents += "</TABLE>";
	if (windowMode) {
		cp_contents += "</CENTER></BODY></HTML>";
		}
	// end populate code

	// Write the contents to the popup object
	cp.populate(cp_contents+"\n");
	// Move the table down a bit so you can see it
	cp.offsetY = 25;
	cp.autoHide();
	return cp;
}

function setPaletteBG(bg) {
	var form = document.colorForm;
	var b;
	if (bg != 1) {
		b = '#ddddff';
	}
	else {
		b = '#1F273C';
	}

	for (var i=0; i<form.shipcolor.length; i++) {
		form.shipcolor[i].style.backgroundColor = b;
	}
}