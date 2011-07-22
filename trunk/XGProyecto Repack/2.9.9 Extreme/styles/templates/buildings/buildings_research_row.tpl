{abrirtr} 
     <td class="1">
            <table align="left" border = "0" width="200px" valign="top" style="width: 200px; border: 1px dashed rgb(102, 102, 102);">
                     <tr height="80px">
                             <td align="left" width="80" valign="top"> 
                                 <a href="game.php?page=infos&amp;gid={tech_id}" onmouseover="return overlib('<center><font size=1 color=white><b>{tech_descr}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();"> 
                                         <img border="0" src="{dpath}gebaeude/{tech_id}.gif" align="top" width="80">                                 </a>                         </td>
                         <td> 
                           <a href="game.php?page=infos&gid={tech_id}">{tech_name}</a><br>                           <br>                         </td>
                 </tr>
                  <tr height="10px">
                            <td colspan="2" align = "center" valign="middle">{tech_level}</td>
              </tr>
                     <tr height="10px">
                            <td colspan="2" align = "center" valign="middle">{search_time}</td>
                     </tr>
                 <tr height="85px">
                         <td colspan="2" align="center" valign="top">{tech_price}<br>
</td>
              </tr>
                     <tr height="10px">
                            <td colspan="2" align = "center" valign="middle" style="width: 550px; border: 1px dashed rgb(102, 102, 102);">{tech_link}</td>
                     </tr>
       </table>
</td> 
 {cerrartr} 