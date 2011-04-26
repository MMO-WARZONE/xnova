<table width="305">
<tbody>
<form action="" method="POST">
<tr>
   <td class="c" colspan="6">Dantenbank-Sichern</td>
</tr><tr>
   <th>Struktur</th>
   <th><select name="tabla">
     <option value="si">Daten + Tabellenstruktur</option>
     <option value="no">Nur Daten</option>
     </select>
	</th>
	</tr><tr>
   <th>Packen</th>
   <th>
     <select name='compre'>
       <option value='norm'>Nicht Packen</option>
       <option value='gz'>GZ</option>
       <option value='bz2'>BZ2</option>
       </select>
	    </th></tr><tr>
   <th colspan="2">
     <input type="submit" value="Backup" /></th>
</tr></form>
<form method="POST" action="" enctype="multipart/form-data"><tr>
   <td class="c" colspan="6">Dantenbank-Sichern</td>
</tr><tr>
   <th><nobr>Pfad zur SQL Datei</nobr></th>
   </tr><tr>
   <th colspan="2">
<input type="file" name="file" /><input type="submit" value="Wiederherstellen" />
</th>
</tr>
</form>
</tbody>
</table> 