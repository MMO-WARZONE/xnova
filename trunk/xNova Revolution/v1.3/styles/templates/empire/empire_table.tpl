<script language = “javacript”>
</script>
<br />
<div id="content">
<!--<div style="background-image: url(./styles/images/imperio.png);background-repeat:no-repeat;height:160px;margin:10px
auto;position:relative;width:519px;margin-bottom:10px ">   -->
<img src="styles/images/headers/imperio.png">
            <div style="position: absolute; right: 160px;top: 8px; font-size: 16px" ><span class="Estilo2">Imperio - Organiza tus planetas, controla todo</span><font style="font-size:10px"></div><br />
    <center>
    <table width="400" border="0" align="center" cellpadding="0" cellspacing="1"> <!-- 539 -->
<tbody>

            <tr height="75">
                <th width="75"><div align="left">{iv_planet}</div></th>
                {file_images}            </tr>
            <tr height="20">
            <th width="75"><div align="left">{iv_name}</div></th>
            {file_names}            </tr>
            <tr height="20">
            <th width="75"><div align="left">{iv_coords}</div></th>
            {file_coordinates}            </tr>
            <tr height="20">
            <th width="75"><div align="left">{iv_fields}</div></th>
            {file_fields}            </tr>
            <tr>
            <td class="c" colspan="{mount}" align="left"><div align="left">{iv_resources}</div></td>
            </tr>
            <tr>
            <th width="75"><div align="left">{Metal}</div></th>
            {file_metal}            </tr>
            <tr>
            <th width="75"><div align="left">{Crystal}</div></th>
            {file_crystal}            </tr>
            <tr>
            <th width="75"><div align="left">{Deuterium}</div></th>
            {file_deuterium}            </tr>
            <tr>
            <th width="75"><div align="left">{Darkmatter}</div></th>
            {file_darkmatter}            </tr>
            <tr>
            <th width="75"><div align="left">{Energy}</div></th>
            {file_energy}            </tr>
                 <tr>
                <td class="c" colspan="{mount}" align="left"><div align="left">{iv_buildings}</div></td>
            </tr>
        <!-- Buildings list -->
        {building_row}
            <tr height="20">
                <td class="c" colspan="{mount}" align="left"><div align="left">{iv_technology}</div></td>
            </tr>
        <!-- Technology list -->
        {technology_row}
            <tr height="20">
                <td class="c" colspan="{mount}" align="left"><div align="left">{iv_ships}</div></td>
            </tr>
        <!-- Ships list -->
        {fleet_row}
            <tr height="20">
                <td class="c" colspan="{mount}" align="left"><div align="left">{iv_defenses}</div></td>
            </tr>
        <!-- Defenses list -->
        {defense_row}
        </tbody>
    </table>
  </center>
</div>
