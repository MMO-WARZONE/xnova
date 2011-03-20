//object detection to return the correct object depending upon broswer type. Used by the getAXHA(); function.
function getNewHttpObject() {
	 var objType = false;
	 try {
		  objType = new ActiveXObject('Msxml2.XMLHTTP');
	 } catch(e) {
		  try {
				objType = new ActiveXObject('Microsoft.XMLHTTP');
		  } catch(e) {
				objType = new XMLHttpRequest();
		  }
	 }
	 return objType;
}

//Function used to update page content with new xhtml fragments by using a javascript object, the dom, and http.
function getAXAH(url,elementContainer,title,pageid,extra,dofunction){
	if (typeof extra == "undefined") {
		extra = false;
	}
	if (typeof dofunction == "undefined") {
		dofunction = false;
	}

	//document.getElementById(elementContainer).innerHTML = '<blink class="redtxt">Loading...<\/blink>';
	var theHttpRequest = getNewHttpObject();
	theHttpRequest.onreadystatechange = function() {processAXAH(elementContainer,title,pageid,extra,dofunction);};
	theHttpRequest.open("GET", url);
	theHttpRequest.send(false);

		function processAXAH(elementContainer,title,pageid,extra,dofunction){
			if (theHttpRequest.readyState == 4) {
				if (theHttpRequest.status == 200) {
					document.getElementById(elementContainer).innerHTML = theHttpRequest.responseText;
					if(extra){
						update(title,pageid);
						run(pageid);
					}
					if(dofunction){
						setTimeout(dofunction,0);
					}
					document.getElementById('rechts').style.height = (window.innerHeight-175)+'px';
				} else {
					document.getElementById(elementContainer).innerHTML="<p><span class='redtxt'>Error!<\/span> HTTP request return the following status message:&nbsp;" + theHttpRequest.statusText +"<\/p><br>Press F5 to go back to the homepage.";
				}
			}
		}

}


//Some things that should be run when a page is started
function run(page){
	switch(page){
		case "overview":

			break;
	}
}

//Mr box
function mrbox(url,width,margintop,title,method){
	var oldtitle = document.title;
	if (typeof title == "undefined") {
		title = oldtitle;
	}
	document.title = "Loading";
	document.getElementById('mrbox').style.display = 'block';

	if (typeof width == "undefined") {
		document.getElementById('mrbox').style.width = width+'px';
	}
	if (typeof margintop == "undefined") {
		document.getElementById('mrbox').style.marginTop = margintop+'px';
	}
	if(method == 'div'){
		document.getElementById('mrbox_content').innerHTML = document.getElementById(url).innerHTML;
		document.title = "title";
	}else{
		getAXAH(url,'mrbox_content',title,document.body.id,true);
	}
}
function mrbox_close(title){
	if (typeof title != "undefined") { document.title = title; }
	document.getElementById('mrbox').style.display = 'none';
}

//Simple laod page function
function loadpage(url,title,pageid){
	document.title = "XNova Forum";
	link = url;//+'&axah=true';
	getAXAH(link,'axah',title,pageid,true);
}

//And finaly the bit we've been waiting for, the ajax.
function ajax(url,elementContainer,timeout,dofunction){
	getAXAH(url,elementContainer,'','',false,dofunction);
	t=setTimeout("ajax('"+url+"','"+elementContainer+"',"+timeout+",'"+dofunction+"')",timeout);
}
