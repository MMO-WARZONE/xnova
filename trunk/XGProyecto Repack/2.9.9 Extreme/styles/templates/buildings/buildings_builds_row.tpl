{abrirtr} 
     <td class="l">
            <table align="left" border = "0" width="200px" valign="top" style="background-repeat: no-repeat;" background="{dpath}gebaeude/planeten/{i}.gif">
                     <tr height="80px">
                             <td align="left" width="80" valign="top"> 
                                 <a href="game.php?page=infos&gid={i}" onmouseover="return overlib('<center><font size=1 color=white><b>{descriptions}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();"> 
                                         <img border="0" src="{dpath}gebaeude/{i}.gif" align="top" width="80"> 
                                 </a>
                         </td>
                         <td> 
                                 <a href="game.php?page=infos&gid={i}">{n}</a><br>
                                 {nivel}<br>{energia}<br>
                                 {time}<br>
                         </td>
                 </tr>
                 <tr height="85px">
                         <td colspan="2" align="center" valign="top"> 
                                 {price}<br> 
                                 {rest_price} 
                                 {build_restp}
                            </td>
                     </tr>
                     <tr height="10px">
                            <td colspan="2" align = "center" valign="middle" style='background-color: #000000;-moz-opacity: 9;-khtml-opacity: 9;opacity: 9;'>{click}</td>
                     </tr>
             </table>
     </td> 
 {cerrartr}