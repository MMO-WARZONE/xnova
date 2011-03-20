<form action="" name="reg_form" method="post">
<table>
<tr>
     <td>{cu_user_reg}:</td>
     <td><input name="character" size="20" maxlength="20" type="text"></td>
</tr><tr>
     <td>{cu_pass_reg}:</td>
     <td><input name="passwrd" size="20" maxlength="20" type="password"></td>
</tr><tr>
      <td>{cu_email_reg}:</td>
      <td><input name="email" size="20" maxlength="40" type="text"></td>
</tr><tr>
     <td>Posicion</td>
     <td><input name="random" type="checkbox">
         <input name="galaxy" size="6" maxlength="2" type="text">
         <input name="system" size="6" maxlength="3" type="text">
         <input name="planet" size="6" maxlength="2" type="text">
     </td>
</table>
<div  class="bigbutton" onclick="document.reg_form.submit();">Crear</div>