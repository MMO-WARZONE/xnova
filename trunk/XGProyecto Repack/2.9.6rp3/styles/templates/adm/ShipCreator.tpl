<script>document.body.style.overflow = "auto";</script>
<style>table.lic{background:url(../styles/images/Adm/blank.gif);border:2px {color} solid;}
th.lic{border:0px;}</style>
<body>
<h2>Creador de naves / Ship Creator</h2>

<form action="ShipCreator.php" method="post">
<table width="500">
<tr><td class="c" colspan="2">Crear nave / Create ship</td></tr>
<tr><th>Nombre</th><th><input type="text" name="name" value="Nuevo nombre"/></th></tr>
<tr><th>Descripcion Corta</th><th><input type="text" name="description" value="Descripcion corta"/></th></tr>
<tr><th>Descripcion larga</th><th><input type="text" name="description_long" value="Descripcion larga"/></th></tr>
<tr><th>Requisitos (formato: <i>id_elemento</i>:<i>nivel_elemento</i>; )</th><th><input type="text" name="need" value="21:1;115:1;"/></th></tr>
<tr><th>Metal</th><th><input type="text" name="metal" value="0"/></th></tr>
<tr><th>Cristal</th><th><input type="text" name="crystal" value="0"/></th></tr>
<tr><th>Deuterio</th><th><input type="text" name="deuterium" value="0"/></th></tr>
<tr><th>Tritio</th><th><input type="text" name="tritium" value="0"/></th></tr>
<tr><th>Consumo deuterio</th><th><input type="text" name="consumption" value="1"/></th></tr>
<tr><th>Velocidad</th><th><input type="text" name="speed" value="1"/></th></tr>
<tr><th>Capacidad</th><th><input type="text" name="capacity" value="1"/></th></tr>
<tr><th>Escudo</th><th><input type="text" name="shield" value="1"/></th></tr>
<tr><th>Ataque</th><th><input type="text" name="attack" value="1"/></th></tr>
<tr><th>Sobreescribe una nave (poner id)</th><th><input type="text" name="overflow" value="0"/></th></tr>
<tr><th colspan="2"><input type="submit" value="Crear"/></th></tr>
</table>
</form>
</body>
