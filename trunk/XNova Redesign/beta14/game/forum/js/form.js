// JavaScript Document
function postforum(){
	var f;
	var i;
	var k;
	f = document.postform.forum;
	i = document.postform.info;
	k = document.postform.keuze;
	loadpage('createforum.php?forum=f&info=i&keuze=k','XNova Forum','bodyid');
}