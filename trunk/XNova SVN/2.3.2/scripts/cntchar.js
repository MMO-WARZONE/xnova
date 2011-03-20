var x = "";
var e = null;

function cntchar(m) {
	if(window.document.forms[0].text.value.length > m) {
		window.document.forms[0].text.value = x;
	} else {
		x = window.document.forms[0].text.value;
	}
	if(e == null)
        e = document.getElementById('cntChars');
	else
	e.childNodes[0].data = window.document.forms[0].text.value.length;
}
//var sx= "";
/*function cntchar(m){

	//document.getElementById('cntChars')
        if($("#text").val().length > m) {
		$("#text").val(sx);
	} else {
		sx = $("#text").val();
	}
	$("#cntChars").text($("#text").val().length);
	
  
}*/