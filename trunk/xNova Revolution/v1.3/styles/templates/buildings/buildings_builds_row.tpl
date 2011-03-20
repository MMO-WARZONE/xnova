<script language="JavaScript" type="text/javascript" src="scripts/overlib.js"></script>
{abrirtr} 
     <td class="l">
            <table align="left" border = "0" width="200px" valign="top">
                     <tr height="80px">
                             <td align="left" width="80" valign="top">
                                 <a href="game.php?page=infos&gid={i}" onmouseover="return overlib('<center><font size=1 color=white><b>{descriptions}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();">
                                         <img border="0" src="{dpath}gebaeude/{i}.gif" align="top" width="80">
                                 </a>
                         </td>
                         <td>
                                 <a href="game.php?page=infos&gid={i}"><font color="#99cc00">{n}</font></a><br>
                                 {nivel}<br>
                                 {time}<br>
                                 {click}
                         </td>
                 </tr>
                 <tr height="85px">
                         <td colspan="2" align="center" valign="top">
                                 {price}<br>
                                 {rest_price}
                            </td>
                     </tr>
             </table>
     </td> 
 {cerrartr}
