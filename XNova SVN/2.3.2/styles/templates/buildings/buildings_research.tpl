<font color="#ff0000">{noresearch}</font>
        
{BuildListScript}
<table width=530>
    {BuildList}
    
    <tr>
        <!-- START BLOCK : research -->
        <td class="l">
            <table align="left" border = "0" width="200px" valign="top">
                     <tr height="80px">
                         <td class="l" align="left" width="80" valign="top" style="background-image: url({dpath}gebaeude/{tech_id}.gif)" onclick="window.location.href='game.php?page=infos&gid={tech_id}'" style="cursor: pointer" onmouseover="return overlib('<center><font size=1 color=white ><b>{tech_descr}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();" >
                                
                         </td>
                         <td class="anything">
                                 <a href="game.php?page=infos&gid={tech_id}">{tech_name}</a><br>
                                 {tech_level}<br>
                                 {search_time}<br>
                         </td>
                 </tr>
                 <tr height="85px">
                         <td class="anything" colspan="2" align="center" valign="top">
                                 {tech_price}
                                 <!--<br>{tech_restp}-->
                            </td>
                 </tr>
                 <tr height="10px">
                         <td  colspan="2" class="l" align = "center" valign="middle">
                             

                            <!-- START BLOCK : script -->
                            <div id="brp" class="z"></div>
                            <script   type="text/javascript">
                            v = new Date();
                            var brp = document.getElementById('brp');
                            function t(){
                                    n  = new Date();
                                    ss = {tech_time};
                                    s  = ss - Math.round( (n.getTime() - v.getTime()) / 1000.);
                                    m  = 0;
                                    h  = 0;
                                    if ( s < 0 ) {
                                            brp.innerHTML = '{bd_ready}<br><a href=game.php?page=buildings&mode=research&cp={tech_home}>{bd_continue}</a>';
                                    } else {
                                            if ( s > 59 ) { m = Math.floor( s / 60 ); s = s - m * 60; }
                                            if ( m > 59 ) { h = Math.floor( m / 60 ); m = m - h * 60; }
                                            if ( s < 10 ) { s = "0" + s }
                                            if ( m < 10 ) { m = "0" + m }
                                            brp.innerHTML = h + ':' + m + ':' + s + '<br><a href=game.php?page=buildings&mode=research&cmd=cancel&tech={tech_id}>{bd_cancel}<br>{tech_name}</a>';
                                    }
                                    window.setTimeout("t();",999);
                            }
                            window.onload=t;
                            </script>
                            <!-- END BLOCK : script -->
{tech_link}
                        </td>
                 </tr>
             </table>
     </td>
    {cerrar}
        <!-- END BLOCK : research -->
    </tr>
</table>