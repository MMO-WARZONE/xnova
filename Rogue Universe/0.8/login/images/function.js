function translate(s)
{
	return s;
}

var browserType = 'unknown';
if (navigator.userAgent.match(/Opera/)) {
	browserType = 'opera';
} else if (navigator.userAgent.match(/MSIE/)) {
	browserType = 'ie';
} else if (navigator.userAgent.match(/Mozilla/)) {
	browserType = 'ns';
}


function domGet(id)

{

	if (typeof(id) != 'string') {

		return id;

	} else {

		return document.getElementById(id);

	}

}



function domGetChild(obj, id)

{

	for (var i=0; i<obj.childNodes.length; i++) {

		var n = obj.childNodes[i];

		if (n.nodeType != 1) continue;

		if (n.id == id) return n;

		var r = domGetChild(n, id);

		if (r != false) return r;

	}

	return false;

}



function domGetBody()

{

	var tmp = document.getElementsByTagName('BODY');

	return tmp[0];

}



function domGetOffset(obj)

{

	obj = domGet(obj);

	var offset = { x:0, y:0 };

	if (obj.offsetX) return { x:obj.offsetX, y:obj.offsetY };

	while (obj) {

		offset.x += obj.offsetLeft;

		offset.y += obj.offsetTop;

		obj = obj.offsetParent;

	}

	return offset;

}



function domFireEvent(obj, name)

{

	if (browserType == 'ns') {

//		var evnt = createEventObject(); //obj.ownerDocument.createEventObject();

//		evnt.initEvent(name.slice(2), false, false);

//		obj.dispatchEvent(evnt);

/*

		if (!event) event = obj.ownerDocument.createEventObject();

		event.initEvent(name.slice(2), false, false);

		obj.dispatchEvent(event);

*/		

		if (typeof(obj[name]) == 'function') {

			obj[name]();

		} else if (obj.getAttribute(name)) {

			eval(obj.getAttribute(name));

		}

	} else {

		obj.fireEvent(name, window.event);

	}

}



function domAttachEvent(obj, name, handler)

{

	if (browserType == 'ns') {

		obj.addEventListener(name.slice(2), handler, false);

	} else {

		obj.attachEvent(name, handler);

	}

}



function domDetachEvent(obj, name, handler)

{

	if (browserType == 'ns') {

		obj.removeEventListener(name.slice(2), handler, false);

	} else {

		obj.removeEvent(name, handler);

	}

}



function domOnLoad(handler)

{

	domAttachEvent(window, 'onload', handler);

}



function domEventGetCoords()

{

	if (window.event) {

		return { x:window.event.clientX, y:window.event.clientY };

	} else {

		return { x:window.nsevent.pageX, y:window.nsevent.pageY };

	}

}



function domEventGetTarget()

{

	if (window.event) {

		return window.event.srcElement;

	} else {

		return window.nsevent.target;

	}

}



function domEventPreventDefault()

{

	if (window.event) { 

		window.event.returnValue = false; 

	} else {

		window.nsevent.preventDefault();

	}

}



function domEventCancelBubble()

{

	if (window.event) { 

		window.event.cancelBubble = true; 

	} else {

		window.nsevent.stopPropagation();

	}

}



function domGetParent(obj, tagName)

{

	if (!tagName) {

		while (obj && obj.nodeType && obj.nodeType != 1) obj = obj.parentNode;

	} else {

		while (obj && obj.tagName && obj.tagName.toLowerCase() != tagName.toLowerCase()) obj = obj.parentNode;

	}

	return obj;

}



function domGetPrevious(obj, tagName)

{

	obj = domGet(obj);

	while (true) {

		if (obj.nodeType == 1) {

			if (typeof(tagName) == 'object') {

				for (var i=0; i<tagName.length; i++) if (tagName[i].toLowerCase() == obj.tagName.toLowerCase()) return obj;

			} else if (typeof(tagName) == 'string') {

				if (tagName.toLowerCase() == obj.tagName.toLowerCase()) return obj;

			} else {

				return obj;

			}

		}

		if (obj.previousSibling) {

			obj = obj.previousSibling;

		} else if (obj.parentNode) {

			obj = obj.parentNode;

		} else {

			return null;

		}

	}

}



function domGetNext(obj, tagName)

{

	obj = domGet(obj);

	while (true) {

		if (obj.nodeType == 1) {

			if (typeof(tagName) == 'object') {

				for (var i=0; i<tagName.length; i++) if (tagName[i].toLowerCase() == obj.tagName.toLowerCase()) return obj;

			} else if (typeof(tagName) == 'string') {

				if (tagName.toLowerCase() == obj.tagName.toLowerCase()) return obj;

			} else {

				return obj;

			}

		}

		if (obj.nextSibling) {

			obj = obj.nextSibling;

		} else if (obj.parentNode) {

			obj = obj.parentNode;

		} else {

			return null;

		}

	}

}



function domSetAlpha(obj, alpha)

{

	obj = domGet(obj);

	if (document.addEventListener) {

		obj.style.MozOpacity = parseInt(alpha)/100;

	} else {

		obj.style.filter = 'alpha(opacity='+parseInt(alpha)+', finishopacity=0, style=0)';

	}

}



function domRemove(obj)

{

	obj = domGet(obj);

	obj.parentNode.removeChild(obj);

}











var gDomSetFlashVarQueue = new Array();

var gDomSetFlashVarTimer = false;



function domSetFlashVarTimer()

{

	if (gDomSetFlashVarQueue.length == 0) {

		clearInterval(gDomSetFlashVarTimer);

		gDomSetFlashVarTimer = false;

		return;

	}

	var queueItem = gDomSetFlashVarQueue.pop();

	try {

		queueItem.obj.SetVariable(queueItem.name, queueItem.value);

	} catch (e) {

	}

	try {

		queueItem.obj.SetVariable('c.'+queueItem.name, queueItem.value);

	} catch (e) {

	}

	queueItem.count--;

	if (queueItem.count > 0) {

		gDomSetFlashVarQueue.unshift(queueItem);

	}

}



function domSetFlashVar(id, name, value)

{

	var obj = false;

	if (document.embeds) obj = document.embeds[id];

	if (!obj) obj = document.getElementById(id);

	if (!obj) return;

	var queueItem = new Object();

	queueItem.obj = obj;

	queueItem.name = name;

	queueItem.value = value;

	queueItem.count = 3;

	gDomSetFlashVarQueue.unshift(queueItem);

	if (!gDomSetFlashVarTimer) {

		gDomSetFlashVarTimer = setInterval('domSetFlashVarTimer()', 20);

	}

}





if (browserType == 'ns') {

	document.addEventListener('mousedown', function(e) { window.nsevent=e; }, true);

	document.addEventListener('mouseup', function(e) { window.nsevent=e; }, true);

	document.addEventListener('mousemove', function(e) { window.nsevent=e; }, true);

	document.addEventListener('click', function(e) { window.nsevent=e; }, true);

	document.addEventListener('keyup', function(e) { window.nsevent=e; }, true);

	document.addEventListener('keydown', function(e) { window.nsevent=e; }, true);

	document.addEventListener('keypressed', function(e) { window.nsevent=e; }, true);

	document.addEventListener('blur', function(e) { window.nsevent=e; }, true);

	document.addEventListener('focus', function(e) { window.nsevent=e; }, true);

}



////////////////////////////////////////////////////////////////////////////////

function popup(width, height, name, url)
{
	if (!url) {
		var a = domGetParent(domEventGetTarget(), 'A');
		if (a) url = a.href;
	}
	if (url) {
		if (!name) name = '';
		var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
		if (w) {
			w.focus();
			if (window.event || window.nsevent) {
				domEventPreventDefault();
				domEventCancelBubble();
			}
			return false;
		}
	}
	return false;
}
function popupAbo(width, height, name, url)
{
	if (!url) {
		var a = domGetParent(domEventGetTarget(), 'A');
		if (a) url = a.href;
	}
	if (url) {
		if (!name) name = '';
		var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
		if (w) {
			w.focus();
			if (window.event || window.nsevent) {
				domEventPreventDefault();
				domEventCancelBubble();
			}
			return false;
		}
	}
}

function popupClose(reload)
{
	if (window.opener) {
		if (reload) if (window.opener.location) window.opener.location.reload();
		window.close();
	} else {
		history.back();
	}
}


////////////////////////////////////////////////////////////////////////////////

function changeButtons(welchen) {
	var image = welchen.src;
	var endung = (image.substr(image.length-3,3));
	if((image.substr(image.length-5,1)) == 0)  var teil = 1;
	else teil = 0;
	var newImage = (image.substring(0,image.length-5)) + teil + "." +endung;
	welchen.src = newImage;
}
/*
var F1;
function popup(ziel,breite,hoehe) {
	if(F1 && !F1.closed) {
		F1.close();
	}
	F1 = window.open(ziel, "Fenster1", "width="+breite+",height="+hoehe+",left=0,top=0");
}
*/


function bilderVorladen() {
	document.Vorladen = new Array();
	if(document.images) {
		for(var i = 0; i < bilderVorladen.arguments.length; i++) {
			document.Vorladen[i] = new Image();
			document.Vorladen[i].src = bilderVorladen.arguments[i];
		}
	}
}

function popMap(width, height, name, url)
{
	if (!url) {
		var a = domGetParent(domEventGetTarget(), 'A');
		if (a) url = a.href;
	}
	if (url) {
		if (!name) name = '';
		var w = window.open(url, name, 'width='+width+',height='+height+',menubar=no,location=no,status=yes,toolbar=no');
		if (w) {
			w.focus();
			if (window.event || window.nsevent) {
				domEventPreventDefault();
				domEventCancelBubble();
			}
			return false;
		}
		else
		{
                  nextpage =confirm('Bitte Deaktiviere bei deinem Browser den Popupblocker. Dieser verhindert das die Karte geladen wird. Soll nun die Karte ohne Popup angezeigt werden');
                  if (nextpage) window.location.href=url;
                }
	}
}

// ############################################################
// Seitenabdeckung bei infolayern #############################
// ############################################################
function showBusyLayer() {
    var busyLayer = document.getElementById("busy_layer")
    if (busyLayer != null) {
        busyLayer.style.visibility = "visible";
        // Would be nicer to have something like window.height, but that does not work with all browsers. 
        busyLayer.style.height = "700px";
    }
}
    
function hideBusyLayer() {
    var busyLayer = document.getElementById("busy_layer")
    if (busyLayer != null) {
        busyLayer.style.visibility = "hidden";
        busyLayer.style.height = "0px";
    }
}