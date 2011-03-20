<html>
<head>
<title>XG Proyect Repack - Install</title>
<style type="text/css">
body{
	color:black;
	background:black;
	font-size            : 11px;
	font-family          : Tahoma,sans-serif;
}
b.red{
	color:red;
}
#logo{
	position:absolute;
	top:10px;
	width:99%;
	text-align:center;
}
#title{
	position:relative;
	top:90px;
	margin:auto;
	color:skyblue;
	background:grey;
	width: 500px;
	height:30px;
	z-index:99999;
	font-size:20px;
	font-weight:bold;
	text-align:center;
	line-height:30px;
}
#container{
	position:relative;
	top:60px;
	margin:auto;
	background:silver;
	width: 500px;
	height:350px;
	border-radius:20px;
	-moz-border-radius:20px;
	-webkit-border-radius:20px;
}
#container #continue{
	position:absolute;
	bottom:10px;
	right:15px;
	width:100px;
	height:25px;
	text-align:center;
	background:silver;
	color:grey;
	line-height:25px;
	border-radius:9px;
	-moz-border-radius:9px;
	-webkit-border-radius:9px;
	cursor:pointer;
	font-weight:bold;
	font-size:13px;
	border:1px solid grey;
}
</style>
<script type="text/javascript">
var counter = 15;
var tpl = 'Continuar';
function countdown(){

	if(counter <= 0){
		document.getElementById('continue').innerHTML = tpl + "&nbsp;&gt;&gt;";
		document.getElementById('continue').style.background = "lime";
		document.getElementById('continue').style.color = "black";
	}else{
		document.getElementById('continue').innerHTML = tpl + "&nbsp;" + counter;
		counter--;
		window.setTimeout(countdown, 1000);
	}
	
}
</script>
</head>
<body onload="countdown();">
<div id="logo">
	<img src="xg-logo.png" width="250"/>
</div>
<div id="title">
	Introducci&oacute;n
</div>
<div id="container">
	<p style="padding:20px;">
		&iexcl;Gracias por descargar este Repack de XG Proyect creado por <b>shoghicp</b>! Esperamos que tu y tus usuarios lo disfruteis jugando.<br><br><b>Este Repack incluye estas grandes novedades (entre otras):</b>
	</p>
		<ul style="margin-top:-15px;">
			<li>Nuevo recurso, el Tritio</li>
			<li>Nuevas paginas tales como los Records, Hall of Fame, Calculadora de puntos, Tutorial y Chat</li>
			<li>&Uacute;ltima implementacion de seguridad, PHP-IDS, para evitar hackeos o trampas</li>
			<li>Nueva vision de imperio con total, accesos directos, construcci&oacute;n directa, ordenaci&oacute;n...</li>
			<li>Bases de datos por SQLite, para permitir que los plugins tengan una base de datos propia</li>
			<li>Cacheado en base de datos, que posibilita una mejora del rendimiento</li>
			<li>Bot de juego integrado, con panel de control</li>
			<li>Muchos errores corregidos para un juego ameno y sin sobresaltos y perdidas causados por ellos</li>
		</ul>
		<p style="padding:20px;margin-top:-15px;">
		Igualmente, te recordamos que no dudes en actualizar a versiones nuevas, ya que traeran errores corregidos y nuevas caracteristicas.<br><br>
		<span style="font-size:12px;">Saludos, <b class="red">shoghicp</b></span>
	</p>
	<div id="continue" onclick="if(counter <= 0){window.location = 'index.php?mode=intro';}" onmouseover='if(counter <= 0){this.style.background = "yellow";}' onmouseout='if(counter <= 0){this.style.background = "lime";}'>Continuar 15</div>
</div>
</body>
</html>
