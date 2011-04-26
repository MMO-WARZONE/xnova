{abrirtr} 
     <td class="l" width="33%">
            <table align="center" border = "0" width="100%" valign="top" style="background-repeat: no-repeat;">
                     <tr height="80px">
                             <td align="left" width="80" valign="top"> 
                                 <a href="javascript:infodiv({i});javascript:animatedcollapse.toggle('{i}')"> 
                                         <img border="0" src="{dpath}gebaeude/{i}.gif" align="top" width="80"> 
                                 </a>
                         </td>
                         <td> 
                                 <a href="javascript:infodiv({i});javascript:animatedcollapse.toggle('{i}')">{n}</a>{nivel}<br>
                                 {build_need_diff}
                                 {time}<br>
								 {cancel}<br>
                         </td>
                 </tr>
                 <tr height="75px">
                         <td colspan="2" align="center" valign="top">
                                 <div align="justify">{descriptions}</div>
                         </td>
                 </tr>
                 <tr height="85px">
                         <td colspan="2" align="center" valign="top"> 
                                 {price}<br> 
                                 {rest_price}                                    
                            </td>
                     </tr>
                     <tr height="10px">
                            <td colspan="2" align="center" valign="middle">{click}</td>
                     </tr>
             </table>
     </td> 
 {cerrartr}