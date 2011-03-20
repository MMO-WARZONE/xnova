<form action="" method="post"><table style="border: 1px solid #BC2A4D;">
<!-- START BLOCK : plugins_list -->
<tr>
    <td style="border: 1px solid #BC2A4D;">{name_plugin} {check_link}
        <!-- START BLOCK : check -->
        <div>{prueba}</div>
        <!-- END BLOCK : check --></td>
    <td style="border: 1px solid #BC2A4D;">{install}
            <input type="checkbox" name="{name_2_plugin}" {value} {check}  />
                   
            <!-- START BLOCK : posicion -->
            <br>  Posicion
            <select name="pos:{id}" size="1">
                <option value="1" {selected_1}>Menu usuario (1 seccion)</option>
                <option value="2" {selected_2}>Menu usuario (2 seccion)</option>
                <option value="3" {selected_3}>Menu usuario (3 seccion)</option>
            </select>
            <!-- END BLOCK : posicion -->
    </td>
</tr>
<!-- END BLOCK : plugins_list -->
<tr>
    <td colspan=2 align="center" style="border: 1px solid #BC2A4D;">
    <input type="submit" value="send" name="submit">
    </td>
</tr>
</table>
</form>