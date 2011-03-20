
jQuery.noConflict();var animateCredits=null;function checkIntro()
{if(navigator.appName.indexOf("Explorer")==-1){animateCredits=true;}
else{animateCredits=false;}}
function show_hide_menus(ele)
{if(document.getElementById(ele).style.display=='block')
{document.getElementById(ele).style.display='none';}
else
{document.getElementById(ele).style.display='block';}}
function show_hide_menus_visibility(ele)
{if(document.getElementById(ele).style.visibility=='visible'||!document.getElementById(ele).style.visibility)
{document.getElementById(ele).style.visibility='hidden';}
else
{document.getElementById(ele).style.visibility='visible';}}
var url;function changeAction(type,formular)
{var uniUrl=document.forms[formular].uni_url.value;if(type=="login")
{document.forms[formular].action="game.php";}
else if(type=="getpw")
{document.forms[formular].action="lostpassword.php";}
else if(type=="register")
{document.forms[formular].action="reg.php";}}
function submitEnter(e)
{var keycode;if(window.event)keycode=window.event.keyCode;else if(e)keycode=e.which;else return true;if(keycode==13)
{changeAction("login","loginForm");document.loginForm.submit();return false;}
else
{return true;}}
var screenX;var screenY;var scrollOffset;var fensterHoehe;function setzeFensterPosition()
{if(window.innerWidth)
{screenY=window.innerHeight;scrollOffset=document.documentElement.scrollTop;}
else if(document.documentElement.clientWidth)
{screenY=document.documentElement.clientHeight;scrollOffset=document.documentElement.scrollTop;}
else
{screenY=700;scrollOffset=0;}
fensterHoehe=document.getElementById('fenster').offsetHeight;if(screenY<fensterHoehe)
{document.getElementById('fenster').style.top=parseInt(scrollOffset+25)+"px";}
else
{var offset=parseInt((screenY-fensterHoehe)/2+scrollOffset);document.getElementById('fenster').style.top=offset+"px";}}
var pos=0;var maximum=-1279;function abspann()
{pos=pos-1;if(pos>=maximum&&animateCredits==true)
{document.getElementById('fenster_content').style.top=pos+"px";setTimeout('abspann()',75);}
else
{return;}}
var lastUrl=null;var urlParams=null;function ajaxImport(url,params,mode)
{if(params==null)params=null;if(mode==null)mode="GET";jQuery.ajax({type:mode,url:url,data:params,success:loadContent});lastUrl=url;urlParams=params;}
function display_error()
{if(urlParams!=null)
{errorCode=new Array();explFirst=urlParams.split("&");i=0;i2=0;while(typeof explFirst[i]!=undefined&&explFirst[i]!=""&&explFirst[i]!=null)
{explSecond=explFirst[i].split("=");if(explSecond[0].substr(0,6)=="error[")
{printMessage(explSecond[1]);i2++;}
i++;}}}
function loadContent(data)
{document.getElementById("fenster_content").innerHTML=data;show_hide_menus_visibility('flash_oben');show_hide_menus('overlay_seite');show_hide_menus('fenster');setzeFensterPosition();showHideSelectBox("uni_select_box",0);showHideTrailerBox(0);display_error();urlSplit=lastUrl.split(".");if(urlSplit[0]=="credits"){checkIntro();abspann();}}
function showHideSelectBox(ele,show)
{value=document.getElementById(ele).style.display;if(navigator.userAgent.indexOf('MSIE 6')>0){if(value=="block"||value==""||show==0){document.getElementById(ele).style.display="none";}
else{document.getElementById(ele).style.display="block";}}}
function showHideTrailerBox(show)
{value=document.getElementById("flash_trailer_hintergrund").style.display;if(value=="block"||value==""||show==0){document.getElementById("flash_trailer_hintergrund").style.display="none";}
else{document.getElementById("flash_trailer_hintergrund").style.display="block";}}
function closeWindow()
{show_hide_menus('fenster');show_hide_menus('overlay_seite');showHideSelectBox('uni_select_box');show_hide_menus_visibility('flash_oben');stopCredits();}
function openLink(value)
{if(value!=""&&value!=0)
{var valarr=value.split(/\|/);var link="http://nwlng.gameforge.de/index.php?game=ogame&country=en&zone=ogame&target="+valarr[1];if(valarr[0]=="new_window")
{window.open(link);}
else
{top.location.href=link;}}}
function initSearch(){_langselector=document.getElementById("selector");if(_langselector)
{_langselector.onclick=function()
{if(this.parentNode.className.indexOf("open")==-1)
{this.parentNode.className+=" open";}
else
{this.parentNode.className=this.parentNode.className.replace("open","");}};var _links=_langselector.parentNode.getElementsByTagName("a");for(i=0;i<_links.length;i++)
{if(_links[i]!=_langselector)
{_links[i].onclick=function()
{_langselector.innerHTML=this.innerHTML;_langselector.parentNode.className=_langselector.parentNode.className.replace("open","");openLink(this.name);return false;};}}}}
if(window.addEventListener)
{window.addEventListener("load",initSearch,false);}
else if(window.attachEvent)
{window.attachEvent("onload",initSearch);}
function showImage(name,caption)
{Slimbox.open("images/screenshots/"+name,caption);}
function showScreenshots(number)
{number=parseInt(number);var screenShotPath="lang/"+language+"/screens/";Slimbox.open([[screenShotPath+"screenshot_1.jpg",""],[screenShotPath+"screenshot_2.jpg",""],[screenShotPath+"screenshot_3.jpg",""],[screenShotPath+"screenshot_4.jpg",""],[screenShotPath+"screenshot_5.jpg",""],[screenShotPath+"screenshot_6.jpg",""]],number);}
function showWallpapers(number)
{number=parseInt(number);var wallPaperPath="images/wallpaper/";Slimbox.open([[wallPaperPath+"ogame_1_mini.jpg",""],[wallPaperPath+"ogame_2_mini.jpg",""],[wallPaperPath+"ogame_3_mini.jpg",""],[wallPaperPath+"ogame_4_mini.jpg",""],[wallPaperPath+"ogame_5_mini.jpg",""],[wallPaperPath+"ogame_6_mini.jpg",""]],number);}
function showConceptart(number)
{var conceptPath="images/wallpaper/";number=parseInt(number);Slimbox.open([[conceptPath+"concept_1.jpg",""],[conceptPath+"concept_2.jpg",""],[conceptPath+"concept_3.jpg",""],[conceptPath+"concept_4.jpg",""],[conceptPath+"concept_5.jpg",""],[conceptPath+"concept_6.jpg",""]],number);}
function ermittleWmode()
{if(navigator.appName.indexOf("Explorer")!=-1)
{return"opaque";}
else if(navigator.appName.indexOf("Netscape")!=-1)
{return"window";}}
function stopCredits()
{animateCredits=false;document.getElementById('fenster_content').style.top="0px";pos=0;}
function setFensterHeader(name)
{document.getElementById('fenster_header').innerHTML=name;}
function set_cookie(ele,value,expire)
{expireStatement="";if(expire!="")
{var expireTime=new Date();expire=expire*1000;expireTime.setTime(expire);expireStatement=" expires="+expireTime.toGMTString()+"";}
if(document.cookie)
{document.cookie=ele+"="+value+";"+expireStatement;}
else
{document.cookie=ele+"="+value+";"+expireStatement;}}
if(sound==true){var lautstaerkeMusik=3;var lautstaerkeMusikStart=lautstaerkeMusik;soundManager.url='flash/';soundManager.debugMode=false;soundManager.flashVersion=9;soundManager.defaultOptions={volume:3}
soundManager.onload=function()
{var soundArray=new Array();soundManager.createSound({id:'bgmusic',url:'sounds/introbg.mp3',volume:lautstaerkeMusik,stream:true});soundManager.createSound({id:'defaultHover',url:'sounds/click.mp3',volume:12,autoLoad:true});soundManager.createSound({id:'defaultClick',url:'sounds/simpleClick.mp3',volume:14,autoLoad:true});soundManager.createSound({id:'dropDownHover',url:'sounds/Plop.mp3',volume:20,autoLoad:true});soundManager.createSound({id:'dropDownClick',url:'sounds/pulldown_click.mp3',volume:20,autoLoad:true});soundManager.createSound({id:'enterTextfield',url:'sounds/Hover3.mp3',volume:20,autoLoad:true});soundManager.createSound({id:'typing',url:'sounds/checkbox2.mp3',volume:20,autoLoad:true});soundManager.createSound({id:'bigHover',url:'sounds/bigHover.mp3',volume:27,autoLoad:true});soundManager.createSound({id:'bigClick',url:'sounds/bigClick.mp3',volume:9,autoLoad:true});soundManager.createSound({id:'smallHover',url:'sounds/defaultHover3.mp3',volume:3,autoLoad:true});soundManager.createSound({id:'openScreenshot',url:'sounds/Interface_Open.mp3',volume:20,autoLoad:true});soundManager.createSound({id:'checkbox',url:'sounds/checkbox.mp3',volume:3,autoLoad:true});loopSound('bgmusic');};function loopSound(soundID)
{window.setTimeout(function()
{soundManager.play(soundID,{onfinish:function()
{loopSound(soundID);}});},1);}}
function play(soundID)
{if(sound==true){if(play.arguments.length>1){soundManager.setPan(soundID,play.arguments[1]);}else{soundManager.setPan(soundID,0);}
soundManager.play(soundID);}}
var muted=false;var unMuteOnStop=true;var trailerRunning=false;function toggleMuteAll()
{if(sound==true){if(muted==false){soundManager.mute();muted=true;lautstaerkeMusik=0;document.getElementById("mute_button").style.backgroundPosition="-426px -66px";set_cookie("playSound",0,"");sendDataToFlashMovie(0);}
else
{soundManager.unmute();muted=false;lautstaerkeMusik=lautstaerkeMusikStart;document.getElementById("mute_button").style.backgroundPosition="-426px -45px";set_cookie("playSound",1,"");sendDataToFlashMovie(1);unMuteOnStop=true;}}}
function showMuteButtonHover(show)
{if(show==1)
{if(muted==false)
{document.getElementById("mute_button").style.backgroundPosition="-426px -45px";}
else
{document.getElementById("mute_button").style.backgroundPosition="-426px -66px";}}
else
{if(muted==false)
{document.getElementById("mute_button").style.backgroundPosition="-405px -45px";}
else
{document.getElementById("mute_button").style.backgroundPosition="-405px -66px";}}}
function getFlashMC(mcName)
{if(window.document[mcName])
{return window.document[mcName];}
if(navigator.appName.indexOf("Microsoft Internet")==-1)
{if(document.embeds&&document.embeds[mcName])
return document.embeds[mcName];}
else
{return document.getElementById(mcName);}}
function sendDataToFlashMovie(toggle)
{var flashMovie=getFlashMC('flash_header');flashMovie.SetVariable("/:playSound",toggle);}
function setTrailerStatus(toggle)
{if(toggle==1)
{trailerRunning=true;if(muted==true)
{unMuteOnStop=false;}}
if(toggle==0)
{trailerRunning=false;}
if(sound==true)
{if(toggle==0&&unMuteOnStop==true&&muted==true)
{toggleMuteAll();}
if(toggle==1&&muted==false)
{toggleMuteAll();}}}
function checkUsername()
{var username=document.forms['registerForm'].elements['character'].value;if(username.length>2&&username.length<20)
{return"";}
else
{return"1";}}
function checkEmail()
{var email=document.forms['registerForm'].elements['email'].value;if(email.length>=3&&email.length<64)
{validate=email.match(/[a-zA-Z0-9]+@+[a-zA-Z0-9]+[.]+[a-zA-Z0-9]{2,4}/);if(validate)
{return"";}
else
{return"2";}}
else
{return"2";}}
function checkPassword()
{var password=document.forms['registerForm'].elements['password'].value;length=password.length;if(length>0)
{if(length>20)
{return"nr28";}
else if(length<8)
{return"nr29";}
return"";}
return"nr27";}
var flashLoadCheckDone=false;var flashCompleted=false;function completeLoadingFlash(loaded){flashCompleted=true;var flashObenDiv=document.getElementById("flash_oben");if(flashLoadCheckDone==true)
{flashObenDiv.style.textIndent="0px";}}
function init(){if(arguments.callee.done)return;arguments.callee.done=true;if(_timer)clearInterval(_timer);var flashObenDiv=document.getElementById("flash_oben");if(flashCompleted==true)
{flashObenDiv.style.textIndent="0px";}
else
{flashLoadCheckDone=true;}};if(document.addEventListener){document.addEventListener("DOMContentLoaded",init,false);}
if(/WebKit/i.test(navigator.userAgent)){var _timer=setInterval(function(){if(/loaded|complete/.test(document.readyState)){init();}},10);}
window.onload=init;function checkJsFormSubmit(form,url){var params=jQuery("#"+form+"").serialize();jQuery.post(url,params,function(data){var data=data.split(":");if(data[0]==0){setFormAction(document.forms["loginForm"].elements["uni_url"].value);setLoginCookies();document.forms["loginForm"].submit();}else{errorBoxNotify(""+locaAllError+"",""+errorsByBox[data[0]]+"",""+locaAllOk+"");}},"text");}
function setUniID(id){document.forms["loginForm"].uni_id.value=id;}
function setPasswordlostUrl(url){jQuery("#getPassword").attr("href","http://"+url+"/game/reg/mail.php");}
function setFormAction(url){document.forms["loginForm"].action="http://"+url+"/game/reg/login2.php";}
function displayFlash(mode){if(mode==0){document.getElementById("flash_oben").style.display="none";}else{document.getElementById("flash_oben").style.display="block";}}
function tb_open(url)
{tb_show(null,url,false);}
function tb_remove_openNew(url)
{tb_remove();setTimeout("tb_open_new('"+url+"')",500);}