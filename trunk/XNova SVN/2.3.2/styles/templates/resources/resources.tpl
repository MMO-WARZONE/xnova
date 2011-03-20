<form action="" method="post">
    <table width="569">
    <tbody>
    <tr>
        <td class="c" colspan="5">{Production_of_resources_in_the_planet}</td>
    </tr><tr>
        <th class="anything" height="22">&nbsp;</th>
        <th width="60">{Metal}</th>
        <th width="60">{Crystal}</th>
        <th width="60">{Deuterium}</th>
        <th width="60">{Energy}</th>
    </tr><tr>
        <th height="22">{rs_basic_income}</th>
        <th >{metal_basic_income}</th>
        <th >{crystal_basic_income}</th>
        <th >{deuterium_basic_income}</th>
        <th >{energy_basic_income}</th>
    </tr>
    {resource_row}
    <tr>
        <th height="22">{rs_storage_capacity}</th>
        <th >{metal_max}</th>
        <th >{crystal_max}</th>
        <th >{deuterium_max}</th>
        <th >-</th>
        <th class="anything"><input name="action" value="{rs_calculate}" type="submit"></th>
    </tr><tr>
        <th height="22">{rs_sum}:</th>
        <th >{metal_total}</th>
        <th >{crystal_total}</th>
        <th >{deuterium_total}</th>
        <th >{energy_total}</th>
    </tr>
    <tr>
        <th>{rs_daily}</th>
        <th>{daily_metal}</th>
        <th>{daily_crystal}</th>
        <th>{daily_deuterium}</th>
        <th>{energy_total}</th>
    </tr>
    <tr>
        <th>{rs_weekly}</th>
        <th>{weekly_metal}</th>
        <th>{weekly_crystal}</th>
        <th>{weekly_deuterium}</th>
        <th>{energy_total}</th>
    </tr>
    </tbody>
    </table>
</form>
