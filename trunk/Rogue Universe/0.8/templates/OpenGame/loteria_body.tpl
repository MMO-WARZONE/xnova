    <br>
    <table width="519">
    <tr>
       <td class="c" colspan="2">Lottery</td>
    </tr>
    <tr>
       <th>There is <font color="{color}">{Cantidadf}</font> Tickets left. Tickets sold: <font color="{color}">{Cantidad}/{Cantidadt}</font></th>
       <th><b><u>Resources</u></b><br><font color="yellow">Amount of Metal:</font>{Cantidadm}<br><font color="yellow">Amount of Crystal:</font>{Cantidadc}<br><font color="yellow">Amount of Deuterium:</font>{Cantidadm}<br></th>
    </tr>
    <tr>
       <td class="c" colspan="2">Lottery Tickets</td>
    </tr>
    <tr>
       <th class="c">
       <br>
       <form method="POST" action="loteria.php?cp=compra">
       <select size="1" name="Tickets">
       <option value="1">1</option>
       <option value="2">2</option>
       <option value="3">3</option>
       <option value="4">4</option>
       <option value="5">5</option>
       <option value="6">6</option>
       <option value="7">7</option>
       <option value="8">8</option>
       <option value="9">9</option>
       <option value="10">10</option>
       </select>
       <input type="submit" value="Submit" name="comprar">
    </form>
       </th>
       <th>Your Tickets<br><font color="yellow">{tustickets}</font>
    </tr>
    <tr>
       <td class="c" colspan="2">{MensajeCompra}</td>
    </tr>
    <tr>
       <th class="c" colspan="2"></th>
    </tr>
    <tr>
       <td class="c" colspan="2">Ticket Buyers</td>
    </tr>
    <tralign="left">
       <th class="c" colspan="2" >- {usuarios}</th>
    </tr>


    </body>
    </html>