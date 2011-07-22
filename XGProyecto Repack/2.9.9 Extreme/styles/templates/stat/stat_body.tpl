<br />
<div id="content">
    <form name="stats" method="post">
        <table width="650">
            <tr>
               <td colspan="6" class="c">{st_statistics} ({st_updated}: {stat_date})</td>
            </tr>
            <tr>
                <th colspan="6" class="c">{st_show} <select name="who" onChange="javascript:document.stats.submit()">{who}</select> {st_per} <select name="type" onChange="javascript:document.stats.submit()">{type}</select> {st_in_the_positions} <select name="range" onChange="javascript:document.stats.submit()">{range}</select></th>
            <tr>
        </table>
    </form>
    <table width="650">
        {stat_header}
        {stat_values}
 <td colspan="7" class="c"><p align="center">»«</p></td>
           
<tr>
          </tr>
    </table>
</div>
