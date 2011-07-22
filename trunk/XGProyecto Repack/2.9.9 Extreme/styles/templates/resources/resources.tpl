<br />
<div id="content">
    <form action="" method="post">
    <table width="569">
    <tbody>
    <tr>
        <td class="c" colspan="5">{Production_of_resources_in_the_planet}</td>
    </tr><tr>
        <th height="22">&nbsp;</th>
        <th width="60">{Metal}</th>
        <th width="60">{Crystal}</th>
        <th width="60">{Deuterium}</th>
        <th width="60">{Energy}</th>
    </tr><tr>
        <th height="22">{rs_basic_income}</th>
        <td class="k">{metal_basic_income}</td>
        <td class="k">{crystal_basic_income}</td>
        <td class="k">{deuterium_basic_income}</td>
        <td class="k">{energy_basic_income}</td>
    </tr>
    {resource_row}
    <tr>
        <th height="22">{rs_storage_capacity}</th>
        <td class="k">{metal_max}</td>
        <td class="k">{crystal_max}</td>
        <td class="k">{deuterium_max}</td>
        <td class="k">-</td>
        <td class="k"><input name="action" value="{rs_calculate}" type="submit"></td>
    </tr>
     </tbody>
    </table>
    </form>
    <br>
    <table width="569">
        <tbody>
            <tr>
                <td class="c" colspan="7">{rs_widespread_production}</td>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th>{Secondly}</th>
                <th>{Minutly}</th>   
                <th>{Hourly}</th>            
                <th>{rs_daily}</th>
                <th>{rs_weekly}</th>
                <th>{rs_monthly}</th>
            </tr>
            <tr>
                <th>{Metal}</th>
                <th>{secondly_metal}</th>
                <th>{minutly_metal}</th>
                <th>{hourly_metal}</th>
                <th>{daily_metal}</th>
                <th>{weekly_metal}</th>
                <th>{monthly_metal}</th>
            </tr>
            <tr>
                <th>{Crystal}</th>
                <th>{secondly_crystal}</th>
                <th>{minutly_crystal}</th>
                <th>{hourly_crystal}</th>
                <th>{daily_crystal}</th>
                <th>{weekly_crystal}</th>
                <th>{monthly_crystal}</th>
            </tr>
            <tr>
                <th>{Deuterium}</th>
                <th>{secondly_deuterium}</th>
                <th>{minutly_deuterium}</th>
                <th>{hourly_deuterium}</th>
                <th>{daily_deuterium}</th>
                <th>{weekly_deuterium}</th>
                <th>{monthly_deuterium}</th>
            </tr>
        </tbody>
    </table>
    <br>
    <table width="569">
        <tbody>
            <tr>
                <td class="c" colspan="3">{rs_storage_state}</td>
            </tr><tr>
                <th>{Metal}</th>
                <th>{metal_storage}</th>
                <th width="250">
                    <div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
                    <div id="AlmMBar" style="background-color: {metal_storage_barcolor}; width: {metal_storage_bar}px;">
                    &nbsp;
                    </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>{Crystal}</th>
                <th>{crystal_storage}</th>
                <th width="250">
                    <div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
                    <div id="AlmCBar" style="background-color: {crystal_storage_barcolor}; width: {crystal_storage_bar}px; opacity: 0.98;">
                    &nbsp;
                    </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>{Deuterium}</th>
                <th>{deuterium_storage}</th>
                <th width="250">
                    <div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
                    <div id="AlmDBar" style="background-color: {deuterium_storage_barcolor}; width: {deuterium_storage_bar}px;">
                    &nbsp;
                    </div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>{rs_production_level}</th>
                <th>{production_level}</th>
                <td class="c" width="250">
                    <div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
                    <div id="AlmDBar" style="background-color: {production_level_barcolor}; width: {production_level_bar}px;">
                    &nbsp;
                    </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>  

