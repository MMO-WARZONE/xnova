<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//ES">
<html>
<head>

  <title>{servername}</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <script>try {document.execCommand("BackgroundImageCache", false, true);} catch(err) {} </script>

</head>
<body>
<div id="rmstbar">
<div id="container">
<div id="specialtext">
<div id="rmslogo">
<a onclick="javascript:window.open(this.href);return false;" href="http://www.xnovarevolution.com.ar"><span class="Estilo5">RV</span>{servername}</a></div>
<div id="gameselector">
  <div class="menu">
</div>
</div>
<!--<div id="scroll_container" style="opacity: 0.9;"><a href="#" onclick="javascript:window.open(this.href);return false;" style="color: rgb(204, 204, 204);"><font color="#99cc00">Revolution Genuino</font> </a> <a href="#" onclick="javascript:window.open(this.href);return false;" style="color: rgb(204, 204, 204);"> - XSGAMES Studios - xNova Revolution</a></div>-->
<form action="index.php" method="POST">
<td colspan=2>Usuario: <input type="text" name="username" size="15" maxlength="25" id="login" />
       Contrase&ntilde;a: <input type="password" name="password" size="15" maxlength="25" />
       <input type="submit" name="submit" value="Entrar" /></td></form>
</div>
</div>
</div>
<br>
<br>
<div id="divImg0" style="position: absolute; left: 250px; top: 150px; height: 450px; width:600px;"><a href="javascript:clickImg(0);"><img id="slide0" src="http://img79.imageshack.us/img79/7978/30479313gy8.gif" height=0px width=0px ></a></div>
<div id="divImg1" style="position: absolute; left: 250px; top: 150px; height: 450px; width:600px;"><a href="javascript:clickImg(1);"><img id="slide1" src="http://img79.imageshack.us/img79/7978/30479313gy8.gif" onclick="clickImg(1);" height=0px width=0px></a></div>

<tr>
<table class="c" style="filter:alpha(opacity=80); opacity:.80; background-color: Black;">
<div style="position: absolute; left: 150px; top: 50px; height: 400px; width:300px;">
  <br>
</div>
</table>
<img src="styles/images/logo.png">
<br>
<br>

<!--<div id='divlogin' style="position: absolute; right:0; bottom:0; "> -->
<div>
<form action="index.php" method="POST">
<table class="c" style="filter:alpha(opacity=80); opacity:.80; background-color: Black;">
<tr>
  <td align="center" valign="center" width="400px">

    <table class="c" style="filter:alpha(opacity=80); opacity:.80; background-color: Black;">
      <tr><th width="400px" style="background-image:url(styles/css/img/bg1.png);"><font color="D0E0FF" size="2">Bienvenido a {servername}</font></font></th></tr>
      <tr><th style="text-align: left;">
<li>  Desarrolla tus planetas construyendo estructuras avanzadas
<li>  Desarrolla sofesticadas estructuras militares

<li>  Fortifica tus posiciones
<li>  Desarrolla naves civiles y de combate
<li>  Explora el universo
<li>  Intercambia recursos
<li>  Ampl&iacute;a tu Imperio, coloniza nuevos planetas
<li>  Organiza tus planetas, controla todo
<li>  &Uacute;nete a otros jugadores formando alianzas
<li>  Forja pactos o declara guerras entre alianzas
<li>  Esp&iacute;a a tus vecinos, at&aacute;cales si interesa

<li>  Descubre sus movimientos desde tus lunas
<li>  Destruye las lunas del enemigo
<li>  Accede a mayores objetivos con los ataques conjuntos
<li>  Destaca sobre el resto
<li>  <font color="#99cc00">{servername} esta optimizado para Safari 4 y Firefox 3.5</font>
</th></tr></th></tr>
      <tr><th width="400px" style="background-image:url(styles/css/img/bg1.png);"><a href="reg.php"><font color="#99cc00">Empieza a Jugar desde y&aacute;!</font></a></font></th></tr>
    </table>
  <br>
    <table style="filter:alpha(opacity=80); opacity:.80; background-color: Black;">

      <tr><td align="center"><a href="reg.php"><font color="#99cc00">Reg&iacute;strate (nuevo usuario)</font></a></td>
          <td align="center"><a href="index.php?page=lostpassword"><font color="#99cc00">¿Olvidaste tu contrase&ntilde;a?<font></a></td>
      </tr>
      <tr><td align="center"><a href="{forum_url}"><font color="#99cc00">Foro</font></a></td>
          <td align="center"><a href="game.php?page=changelog"><font color="#99cc00">Changelog</font></a></td>
      </tr>
    </table>
  <br>
    <div id=browser></div>
    <script> document.getElementById("login").focus(); </script>
  </tr>
  </table>
</td></tr>

</table>
</form>
</div>
<script>
var browser=navigator.appName;
var b_version=navigator.appVersion;
var version=parseFloat(b_version);

if (b_version.indexOf("MSIE 6.0")>0) {
  document.getElementById('browser').innerHTML=
  '<table class=l style="filter:alpha(opacity=80); opacity:.80; background-color: Black;"><tr><td>'
  +'<b><font color="red" size="2"><em>A&uacute;n con Internet Explorer?<p>Vas a tener problemas, debido a sus muchos bugs, y no s&oacute;lo en este sitio. Deberías actualizar el navegador.<br>'
  +'&nbsp;-&nbsp;Cambiate a <a href="http://www.mozilla-europe.org/es/firefox/">FireFox</a>.<br>'
  +'&nbsp;-&nbsp;Este juego esta optimizado especialmente para <a href="http://safari.softonic.com/">Safari 4</a><br> de appel.'
  +'Cualquier otro navegador tambi&eacute;n te funcionar&aacute; bien. Opera, Google Chrome... El &uacute;nico que da problemas es Internet Explorer<br>'
  +'A&uacute;n as&iacute; puedes acceder. Si te salen p&aacute;ginas en blanco usa F5 (actualizar). Algunas im&aacute;genes se van a ver mal o me&uacute;s descuadrados.<br>'
  +'</em></b></font></td></tr></table><br>';
}

if (b_version.indexOf("MSIE 7.0")>0) {
  document.getElementById('browser').innerHTML=
  '<table class=l style="filter:alpha(opacity=80); opacity:.80; background-color: Black;"><tr><td>'
  +'<b><font color="red" size="2"><em>A&uacute;n con Internet Explorer?<p>Vas a tener problemas, debido a sus muchos bugs, y no s&oacute;lo en este sitio. Deberías actualizar el navegador.<br>'
  +'&nbsp;-&nbsp;Cambiate a <a href="http://www.mozilla-europe.org/es/firefox/">FireFox</a>.<br>'
  +'&nbsp;-&nbsp;Este juego esta optimizado especialmente para <a href="http://safari.softonic.com/">Safari 4</a><br> de appel.'
  +'Cualquier otro navegador tambi&eacute;n te funcionar&aacute; bien. Opera, Google Chrome... El &uacute;nico que da problemas es Internet Explorer<br>'
  +'A&uacute;n as&iacute; puedes acceder. Si te salen p&aacute;ginas en blanco usa F5 (actualizar). Algunas im&aacute;genes se van a ver mal o me&uacute;s descuadrados.<br>'
  +'</em></b></font></td></tr></table><br>';
}

if (b_version.indexOf("MSIE 8.0")>0) {
  document.getElementById('browser').innerHTML=
  '<table class=l style="filter:alpha(opacity=80); opacity:.80; background-color: Black;"><tr><td>'
  +'<b><font color="red" size="2"><em>A&uacute;n con Internet Explorer?<p>Vas a tener problemas, debido a sus muchos bugs, y no s&oacute;lo en este sitio. Deberías actualizar el navegador.<br>'
  +'&nbsp;-&nbsp;Cambiate a <a href="http://www.mozilla-europe.org/es/firefox/">FireFox</a>.<br>'
  +'&nbsp;-&nbsp;Este juego esta optimizado especialmente para <a href="http://safari.softonic.com/">Safari 4</a><br> de appel.'
  +'Cualquier otro navegador tambi&eacute;n te funcionar&aacute; bien. Opera, Google Chrome... El &uacute;nico que da problemas es Internet Explorer<br>'
  +'A&uacute;n as&iacute; puedes acceder. Si te salen p&aacute;ginas en blanco usa F5 (actualizar). Algunas im&aacute;genes se van a ver mal o me&uacute;s descuadrados.<br>'
  +'</em></b></font></td></tr></table><br>';
}

var winW = 630, winH = 460;

if (parseInt(navigator.appVersion)>3) {
 if (navigator.appName=="Netscape") {
  winW = parseInt(window.innerWidth);
  winH = parseInt(window.innerHeight);
 }
 if (navigator.appName.indexOf("Microsoft")!=-1) {
  winW = parseInt(document.body.offsetWidth);
  winH = parseInt(document.body.offsetHeight);
 }
}

var o=document.getElementById('divlogin');
// o.style.left=(winW-parseInt(o.style.width))+"px";

function clickImg(n) {
  document.location.href=document.getElementById("slide"+n).src;
}

function rota(n,m,primera) {
  var i;
  if (!m) {
    n++;
    if (n>imags.length) n=1,primera=0; // document.getElementById("guion").
    i=document.getElementById("slide"+(1-(n&1)));
    i.src=imags[n-1];
    setTimeout("rota("+n+",1,"+primera+")",5000);
  } else {
    if (m>100) m=100;
    if (!n) { // aparece guion
      if (m==1) guion(0);
      document.getElementById("guionTbl").style.opacity=0.6*m/100;
      i=document.getElementById("divImg0");
      i.style.left=winW*0.15+"px";
      i.style.top=winH*0.15+"px";
    } else {
      var w,h;
      if (m==1) guion(n);
      if (n&1) {
        w=winW*0.7*m/100;
        h=winH*0.7*m/100;
      } else {
        w=winW*0.7*(100-m)/100;
        h=winH*0.7*(100-m)/100;
      }
      i=document.getElementById("slide0");
      i.width=w;
      i.height=h;
      i=document.getElementById("slide1");
      if (!primera || n!=1) {
        i.width=winW*0.7-w;
        i.height=winH*0.7-h;
        i=document.getElementById("divImg1");
        i.style.left=(winW*0.15+w)+"px";
        i.style.top=(winH*0.15+h)+"px";
        i.style.width=(winW*0.7-w)+"px";
        i.style.height=(winH*0.7-h)+"px";
      }
    }
    if (m==100) {
      setTimeout("rota("+n+",0,"+primera+")",500);
    } else {
      setTimeout("rota("+n+","+(m+5)+","+primera+")",100);
    }
  }
}

setTimeout("rota(0,1,1)",200);


</script>
</body>
</html>
