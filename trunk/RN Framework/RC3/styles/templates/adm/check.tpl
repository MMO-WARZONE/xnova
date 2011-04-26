<br>
<h2>Datenbank &Uuml;bersicht</h2>

<br>
<form name="" action="db.check.php" method="post">
<table width="500">
{informacion}
<tr>
<th>Tabelle</th>
   <th>Eintr&auml;ge</th>
   <th>Engine</th>
   <th>Kollation</th>
   <th>Gr&ouml;&szlig;e</th>
   <th>Noch Frei</th>
   <th>Ausw&auml;hlen</th>
</tr>


    
    
 {tabla} 
    <tr>
    <th colspan="7" style="text-align:center;">Tabellen <br>
    <select name="accion">
    <option value="Reparar">Reparieren</option>
    <option value="Analizar">Analysieren</option>
    <option value="Revisar">&Uuml;berprüfen</option>
    <option value="Optimizar">Optimieren</option>
    </select><input style="width:100%;" name="ejecutar" value="Absenden" type="submit"></th>
</tr>
</table>
</form> 