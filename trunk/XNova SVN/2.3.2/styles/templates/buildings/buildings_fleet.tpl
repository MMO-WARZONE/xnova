<br />
    {message}
        <form action="" method="post">
            <table align="top" width="600">
                <tr>
                    <!-- START BLOCK : fleet -->
                    <td class="l">
                            <table align="center" border = "0" width="200px" valign="top" >
                                 <tr height="80px">
                                         <td class="l" align="left" width="80" valign="top" style="background-image: url({dpath}gebaeude/{i}.gif)" onclick="window.location.href='game.php?page=infos&gid={i}'" onmouseover="return overlib('<center><font size=1 color=white><b>{descripcion}</b></font></a></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();">
                                         </td>
                                         <td class="anything">
                                                 <a href="game.php?page=infos&gid={i}">{name}</a><br> {count}<br>
                                                    {time}
                                         </td>
                                 </tr>
                                 <tr height="85px">
                                         <td class="anything" colspan="2" align="center" valign="top">
                                                 {price}
                                            </td>
                                     </tr>
                                     <tr height="10px">
                                            <td class="l" colspan="2" align = "center" valign="middle" >
                                                <input type=text name=fmenge[{i}] alt='{name}' size=9 maxlength=9 value=0 tabindex="{TabIndex}">
                                                <a href='javascript:' onclick="document.getElementsByName('fmenge[{i}]')[0].value = '{max}';">{max2}</a>
                                            </td>
                                     </tr>
                             </table>
                     </td>
                 {cerrartr}
                 <!-- END BLOCK : fleet -->

                {build_fleet}
            </table>
        </form>
    <!-- START BLOCK : buildinglist-->
                    <br>
                    {bd_actual_production}
                    <div id=bx class=z></div>
                    <script  type="text/javascript">
                    v  = new Date();
                    p  = 0;
                    g  = {b_hangar_id_plus};
                    s  = 0;
                    hs = 0;
                    of = 1;
                    c  = new Array({c}'');
                    b  = new Array({b}'');
                    a  = new Array({a}'');
                    aa = '{bd_completed}';

                    function t() {
                            if ( hs == 0 ) {
                                    xd();
                                    hs = 1;
                            }
                            n = new Date();
                            s = c[p] - g - Math.round((n.getTime() - v.getTime()) / 1000.);
                            s = Math.round(s);
                            m = 0;
                            h = 0;
                            if ( s < 0 ) {
                                    a[p]--;
                                    xd();
                                    if ( a[p] <= 0 ) {
                                            p++;
                                            xd();
                                    }
                                    g = 0;
                                    v = new Date();
                                    s = 0;
                            }
                            if ( s > 59 ) {
                                    m = Math.floor(s / 60);
                                    s = s - m * 60;
                            }
                            if ( m > 59 ) {
                                    h = Math.floor(m / 60);
                                    m = m - h * 60;
                            }
                            if ( s < 10 ) {
                                    s = "0" + s;
                        }
                        if (m < 10) {
                          m = "0" + m;
                            }
                            if ( p > b.length - 2 ) {
                                    document.getElementById("bx").innerHTML=aa ;
                        } else {
                                    document.getElementById("bx").innerHTML=b[p]+" "+h+":"+m+":"+s;
                        }
                            window.setTimeout("t();", 200);
                    }

                    function xd() {
                            while (document.Atr.auftr.length > 0) {
                                    document.Atr.auftr.options[document.Atr.auftr.length-1] = null;
                            }
                            if ( p > b.length - 2 ) {
                                    document.Atr.auftr.options[document.Atr.auftr.length] = new Option(aa);
                            }
                            for ( iv = p; iv <= b.length - 2; iv++ ) {
                                    if ( a[iv] < 2 ) {
                                            ae = " ";
                                    } else {
                                            ae = " ";
                                    }
                                    if ( iv == p ) {
                                            act = " {bd_operating}";
                                    } else {
                                            act = "";
                                    }
                                    document.Atr.auftr.options[document.Atr.auftr.length] = new Option( a[iv] + ae + " \"" + b[iv] + "\"" + act, iv + of );
                            }
                    }

                    window.onload = t;
                    </script>
                    <br />
                    <form name="Atr" method="get" action="game.php?page=buildings">
                    <input type="hidden" name="mode" value="fleet">
                    <table width="530">
                    <tr>
                            <td class="c" >{work_todo}</td>
                    </tr>
                    <tr>
                            <th ><select name="auftr" size="10"></select></th>
                    </tr>
                    <tr>
                            <td class="c" ></td>
                    </tr>
                    </table>
                    </form>
                    <br />
                    {total_left_time} {pretty_time_b_hangar}<br></center>
                    <br />
                <!-- END BLOCK : buildinglist -->