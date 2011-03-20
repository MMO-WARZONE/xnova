<br>
<center>
<h2>Configuracion del juego</h2>

<form action="?mode=change" method="post">
 <table width="519">

     <tbody><tr><td class="c" colspan="2">Datos del juego</td></tr>
<tr>
      <th>Nombre del juego<br><small>Todo texto que mensione al nombre del juego, se reemplazara con este texto</small></th>
   <th><input name="game_name" size="20" value="{game_name}" type="text"></th>
    </tr>
  <tr>
  <th>Texto copyright<br><small>Pequeño texto se muestra al pie.</small></th>
   <th><input name="copyright" size="40" maxlength="254" value="{copyright}" type="text"></th>
  </tr>

   <tr><th colspan="2"></th></tr>
  

	<!-- Planet Settings -->
  
  <tr>
  <td class="c" colspan="2">Configuracion de planetas</td>
  </tr>
  <tr>
   <th>Campos iniciales</th>
   <th><input name="initial_fields" maxlength="80" size="10" value="{initial_fields}" type="text"> campos
   </th>
  </tr>
  <tr>
   <th>Multiplicador de recursos</th>
   <th>x<input name="resource_multiplier" maxlength="80" size="10" value="{resource_multiplier}" type="text">
   </th>
  </tr>
  <tr>
   <th>Metal basico</th>
   <th><input name="metal_basic_income" maxlength="80" size="10" value="{metal_basic_income}" type="text"> por hora
  </tr>
  <tr>
   <th>Cristal basico</th>
   <th><input name="crystal_basic_income" maxlength="80" size="10" value="{crystal_basic_income}" type="text"> por hora
   </th>
  </tr>
  <tr>
   <th>Deuterio Basico</th>
   <th><input name="deuterium_basic_income" maxlength="80" size="10" value="{deuterium_basic_income}" type="text"> por hora
   </th>
  </tr>
  <tr>
   <th>Energia basica</th>
   <th><input name="energy_basic_income" maxlength="80" size="10" value="{energy_basic_income}" type="text"> por hora
   </th>
  </tr>

	<!-- Miscelaneos Settings -->

    <tr>
     <td class="c" colspan="2">Miscelaneos</td>
	</tr>

  <tr>
     <th>Modo debug</a></th>
   <th>
    <input name="debug"{debug} type="checkbox" />
   </th>
  </tr>

  <tr>
   <th colspan="2"><input value="Guardar cambios" type="submit"></th>
  </tr>


   
 </tbody></table>

 
</form>

</center>
