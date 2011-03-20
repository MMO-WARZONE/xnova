<style type="text/css">
body{
	background:silver;
	color:black;
}
.menuLink{
	background:transparent !important;
	border: 0px solid black;	
}
a.menuLink:hover {
	color: red !important;
	font-size: 13px !important;
}
a.noRed:hover {
	color: lime !important;
	font-size: 13px !important;
}
tr.menuLink{
	height: 23px !important; 
}
th.menuLink{
	width: 150px !important;
	border-bottom: 1px dashed rgb(102, 102, 102) !important;
	
}
th, table, td{
background:skyblue;
border:0px;
}
</style>
<br>
<div style="width:750px;height:580px;border: 2px solid lime !important;background:skyblue;">
<div style="width:746px;height:576px;border: 2px solid grey !important;">
<div style="overflow:auto;width:720px;position:relative;margin:auto;top:7px;">
<table width="700" class="menuLink">
<tr class="menuLink"><th class="menuLink" style="border:0px !important;border-right:1px dashed rgb(102, 102, 102) !important;"><span style="font-size:15px;">Instalador XG Proyect</span></th>
<th class="menuLink" style="border-top: 1px dashed rgb(102, 102, 102) !important;"><a class="menuLink" href="index.php?mode=intro" style="font-size:15px;color:green;">Inicio</a></th><th style="border-top: 1px dashed rgb(102, 102, 102) !important;" colspan="2" class="menuLink">Volver al inicio</th></tr>
<tr class="menuLink"><th class="menulink" rowspan="3" style="border:0px !important;border-right:1px dashed rgb(102, 102, 102) !important;"><img src="xg-logo.png" width="200"></th>
<th class="menuLink"><a class="menuLink" href="index.php?mode=license" style="font-size:15px;color:green;">Licencia</a></th><th colspan="2" class="menuLink">GNU GENERAL PUBLIC LICENSE</th></tr><tr class="menuLink">
<th class="menuLink"><a class="menuLink noRed" href="index.php?mode=ins&page=1" style="font-size:15px;color:red;">Instalar</a></th><th colspan="2" class="menuLink">Crea una instalacion desde 0 de XG Proyect 2.9.6rp</th></tr><tr class="menuLink">
<th class="menuLink"><a class="menuLink noRed" href="index.php?mode=upgrade" style="font-size:15px;color:red;">Actualizar</a></th><th colspan="2" class="menuLink">Actualiza una version de XG proyect a XG Proyect 2.9.6rp</th></tr>
</table></div>
<div style="width:100%;height:2px;background:grey;margin-top:9px;"></div>
<div style="height:450px;overflow:auto;width:720px;position:relative;margin:auto;top:10px;"><table width="700">
<form action="{dis_ins_btn}" method="post">
{ins_page}
<tr>
</form>
</table>
</div>
</div>
</div>
<div style="margin-top:20px;font-weight:bold;">&copy; 2008 - 2010</div>