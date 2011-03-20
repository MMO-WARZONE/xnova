
<div id="content">
    <center>
        <br />
        <form name="planets" action="game.php?page=reciclador" method="post">
            <select name="ship_type_id" onchange="this.form.submit();">
                {shiplist}
            </select>
        </form>
        
        <script type="text/javascript">
        function calc_recursos()
        {
            var recuperar_metal = {scrap_metal};
            var recuperar_cristal = {scrap_cristal};
            var recuperar_deuterium = {scrap_deuterium};
            var max_ships_sell = {max_ships_to_sell};
            var num = parseInt(document.getElementById('numscrap').value, 10);

            if (num < 0){
                num = 0;
                document.getElementById('numscrap').value=num;
            }

            if (num > max_ships_sell){
                num = max_ships_sell;
                document.getElementById('numscrap').value=num;
            }

            document.getElementById('scrap_metal').innerHTML = num * recuperar_metal;
            document.getElementById('scrap_cristal').innerHTML = num * recuperar_cristal;
            document.getElementById('scrap_deuterium').innerHTML = num * recuperar_deuterium;
        }
        </script>
        
        <form action="" method="post">
            <table border="0" cellpadding="0" cellspacing="1" width="600">
                <tr height="20">
                    <td colspan="3" class="c">{ch_intergalactic_merchant}</td>
                </tr>
                <tbody>
                    <tr height="20">
                        <th rowspan="4" align="center" valign="middle"><img src="{dpath}gebaeude/{image}.gif" width="120" height="120"></th>
                        <th class="1" colspan="2" align="center"><p>{ch_merchant_text_decript}</p>
                    </th>
                    </tr>
                        <tr height="20">
                            <th align="center">{ch_how_much_want_exchange}</th>
                            <th align="center">
                                <input type="hidden" name="ship_type_id" value="{shiptype_id}">
                                <input id="numscrap" type="text" name="number_ships_sell" size="6" maxlength="6" value="0" tabindex="1" onKeyup="calc_recursos();">
                                <span style="color:gray;">/ {max_ships_to_sell}</span>
                            </th>
                    </tr>
                    <tr height="20">
                        <th colspan="2" align="center">{ch_merchant_give_metal} {ch_merchant_give_crystal} {ch_merchant_give_deutetium}</th>
                    </tr>
                    <tr height="20" align="center">
                        <th colspan="2"><input name="submit" type="submit" value="{ch_exchange}"></th>
                    </tr>
                </tbody>
            </table>
        </form>
    </center>