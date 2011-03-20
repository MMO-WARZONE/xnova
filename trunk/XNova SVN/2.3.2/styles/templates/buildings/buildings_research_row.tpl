{abrirtr} 
     <td class="l">
            <table align="left" border = "0" width="200px" valign="top" style="background-repeat: no-repeat;" background="{dpath}gebaeude/{tech_id}.gif">
                     <tr height="80px">
                             <td align="left" width="80" valign="top"> 
                                 <a href="game.php?page=infos&gid={tech_id}" onmouseover="return overlib('<center><font size=1 color=white><b>{tech_descr}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();"> 
                                         <img border="0" src="{dpath}gebaeude/{tech_id}.gif" align="top" width="80"> 
                                 </a>
                         </td>
                         <td> 
                                 <a href="game.php?page=infos&gid={tech_id}">{tech_name}</a><br>
                                 {tech_level}<br>
                                 {search_time}<br>
                         </td>
                 </tr>
                 <tr height="85px">
                         <td colspan="2" align="center" valign="top"> 
                                 {tech_price} 
                                 <!--<br>{tech_restp}-->                                    
                            </td>
                     </tr>
                     <tr height="10px">
                           <td colspan="2" align = "center" valign="middle" style='background-color: #000000;-moz-opacity: 9;-khtml-opacity: 9;opacity: 9;'>{tech_link}</td>
                    
			
			</tr>
             </table>
     </td> 
 {cerrartr}
