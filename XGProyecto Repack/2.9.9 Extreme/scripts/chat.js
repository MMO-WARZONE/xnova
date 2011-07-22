
var nick="";
var nick=nick.replace(/\+/,"plus");


// Scrolling automatique
function descendreTchat(){
 	var elDiv =document.getElementById('shoutbox');
 	elDiv.scrollTop = elDiv.scrollHeight-elDiv.offsetHeight;
}

// Ajout de message
function addMessage(){
	var msg = document.getElementById('msg');
	if(msg.value>""){
		var x_object = null;
		var cc_obj = document.getElementById("chat_color");
		var color = cc_obj.options[cc_obj.selectedIndex].value;
		var users = document.getElementById("chat_to").options[document.getElementById("chat_to").selectedIndex].value;
		if(users != "ALLUSERS"){
			var to = document.getElementById("to_user").value;
		}else{
			var to = "ALLUSERS";
		}
		if(window.XMLHttpRequest){
			x_object = new XMLHttpRequest();
		}else if(window.ActiveXObject){
			x_object = new ActiveXObject("Microsoft.XMLHTTP");
		}else{
			alert('AJAX Error');
			return;
		}
		
		x_object.open("POST","chat_add.php" ,true); 
		x_object.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		msg.value=msg.value.replace(/\+/g,"plus");
		if(color>""){
			msg.value = "[c="+color+"]"+msg.value+"[/c]";
		}
		msg.value = to + ": "+msg.value;
		x_object.send("&chat_type="+chat_type+"&ally_id="+ally_id+"&nick="+nick+"&msg="+msg.value);
		$('#shoutbox').append("<div align=\"left\" style='color:white;'>Enviando mensaje...</div><br>");
		msg.value = "";
		descendreTchat();
		showMessage();
	}
}
function MessageHistory(){
	var WinH = window.open("chat_msg.php?chat_type="+chat_type+"&ally_id="+ally_id+"&show=history","ChatHistory","");
}

// Affichage des messages
function showMessage(){
	var x_object2 = null;
	if(window.XMLHttpRequest){
		x_object2 = new XMLHttpRequest();
	}else if(window.ActiveXObject){
		x_object2 = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		alert('AJAX Error');
	return;
	}
	x_object2.open("GET","chat_msg.php" + "?chat_type="+chat_type+"&ally_id="+ally_id,true);
	x_object2.send();
	
	x_object2.onreadystatechange = function(){
		if(x_object2.readyState==4){
			if(x_object2.status==200){
			$('#shoutbox').html(x_object2.responseText);
			descendreTchat();
			}
		}
	}
	$.ajax({
		type: "GET",
		url: "chat.php?ajax=1",
		success: function(html){
			$("table #connectedUsers").html(html);
		}	
	});
	
}

// Raccourcis des smileys
function addSmiley(smiley){
	var msg = document.getElementById('msg');
	msg.value=msg.value+ " " + smiley;
	msg.focus();
}


setInterval(showMessage,5000);

function addNick(obj){
var msg = document.getElementById('msg');
 msg.value=msg.value+' ['+obj.innerText+'] ';
 msg.focus();
}