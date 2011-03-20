{sBuildListScript}
    {BuildList}
    {ScriptList}
    <script  type="text/javascript" >
        var i=0;
var a=0;
if (typeof array_list != "undefined"){
function t() {

	var blc         = document.getElementById('blc');
	v           = new Date();
        n           = new Date();
	var ss          = pp;
	var aa          = Math.round( (n.getTime() - v.getTime() ) / 1000. );
	var s           = ss -  aa;
	var m           = 0;
	var h           = 0;
	var d           = 0;

	if ( (ss + 3) < aa ) {
		if ((ss + 6) >= aa) {
                    a++;
                    prueba();
		}
	} else {
		if ( s < 0 ) {
                    blc.innerHTML = "Terminado";
                } else {
			if ( s > 59) {
				m = Math.floor( s / 60);
				s = s - m * 60;
			}
			if ( m > 59) {
				h = Math.floor( m / 60);
				m = m - h * 60;
			}
			if ( h > 23 ) {
				d = Math.floor( h / 24);
				h = h - d * 24;
			}
			if ( s < 10 ) {
				s = "0" + s;
			}
			if ( m < 10 ) {
				m = "0" + m;
			}
			if ( d < 1 ) {
				d = "" ;
			}else{
				d = d + "d " ;
			}
			blc.innerHTML =d  + h + ":" + m + ":" + s + "<br><a href=game.php?page=buildings&listid=" + pk + "&cmd=" + pm + "&planet=" + pl + ">Cancelar</a>";

		}
		pp = pp - 1;
		//if (timeout == 1) {
			window.setTimeout("t();", 1000);
		//}

	}
}

var num = array_list.length-1;
function prueba(){

        prueba2();

        for (i=a;i<=(array_list.length-1);i++) {

            if(i==a){
                pp = array_seg[i];
                pk = array_list[i];
                pm = "cancel";
                pl = "1";
                t();
                pp2 = array_seg[i];
                pp3 = i;// temps necessaire (a compter de maintenant et sans ajouter time() )
		barupdate();
            }

       }
       if(a==(array_list.length)){
            document.getElementById('table').style.display='none';
            document.getElementById('list').style.display='none';
       }
}


function prueba2(){
        table=document.getElementById('table');
        var num=1;
        var total=0;
        for (sa=a;sa==1;sa--) {
            total+=array_seg[sa];
            total+=3;
        }

        for (e=a;e<=(array_list.length-1);e++) {
            if(e==a){
                page=("<tr id='"+num+"'>\n\
                <th colspan='3'>\n\
                <table width='100%'>\n\
                            <tr>\n\
                                <td class='anything l' width='80' height='80' style='background-image: url(\"styles/skins/xnova/gebaeude/"+array_build[e]+".gif\");' width='80' rowspan='2'>\n\
                                    </td>\n\
                                <td class='anything'>\n\
                                    <center>\n\
                                        <table >\n\
                                            <tr>\n\
                                                <td width='24' class='anything'>\n\
                                                    <img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'>\n\
                                                </td>\n\
                                                <td class='anything'>\n\
                                                    <center>\n\
                                                        <font color ='#6699FF'>\n\
                                                            <a href='game.php?page=infos&gid="+array_build[e]+"'>\n\
                                                                <font color ='#6699FF'>.::. "+array_name[e]+" .::.</font>\n\
                                                            </a>\n\
                                                            <br />Ampliar al <font color='#FF8C00'><b>Nivel "+array_nivel[e]+"</b></font>\n\
                                                        </font>\n\
                                                    </center>\n\
                                                </td>\n\
                                                <td class='anything' width='24'>\n\
                                                    <img border='0' src='./styles/images/enproceso.gif' align='top' width='24' height='24'>\n\
                                                </td>\n\
                                            </tr>\n\
                                            <tr>\n\
                                                <td class='anything' colspan='3'>\n\
                                                    <center>\n\
                                                        <input type='button' onclick=\"top.location = 'game.php?page=buildings&cmd=insert&building="+array_build[e]+"';\" value='Repetir' />\n\
                                                    </center>\n\
                                                </td>\n\
                                            </tr>\n\
                                        </table>\n\
                                    </center>\n\
                                </td>\n\
                                <td class='anything' width='56' rowspan='2'>\n\
                                    <center>\n\
                                        <div id='blc' class='z'>18<br>\n\
                                            <a href='game.php?page=buildings&listid=1&amp;cmd=cancel&amp;planet=1'>Interrumpir</a>\n\
                                        </div>\n\
                                        \n\
                                        <strong color='lime'>\n\
                                            <br>\n\
                                            <font color='lime'>\n\ "+ Reloj(array_seg2[e]) +
"</font></strong>\n\
                                    </center>\n\
                                </td>\n\
                            </tr>\n\
                            <tr>\n\
                                <td class='anything' height='18'>\n\
                                    <div id='barcontainer' style='border: 1px solid rgb(153, 153, 255); width: 364px;'>\n\
                                        <div id='prodBar'   style='background-color: #dfd; width: 0px;'></div>\n\
                                            </div>\n\
                                \n\
            \n\
                                </td>\n\
                            </tr>\n\
                            </tbody>\n\
                        </table>\n\
                    </th>\n\
                </tr>");

                }else{
                   page+=("<tr id='"+num+"'>\n\
                        <th colspan='3'>\n\
                            <table width='100%'>\n\
                                <tbody>\n\
                                    <tr>\n\
                                        <td class='l'>\n\
                                            <font color='#6699ff'>"+num+"\n\
                                                <a href='game.php?page=infos&amp;gid="+array_build[e]+"'>\n\
                                                    <font color='#6699ff'>.::. "+array_name[e]+" .::.</font>\n\
                                                </a> Ampliar al <font color='#ff8c00'><b>Nivel "+array_nivel[e]+"</b></font>\n\
                                            </font>\n\
                                        </td>\n\
                                        <td class='l' width='56'>\n\
                                            <center>\n\
                                                <input onclick=\"top.location = 'game.php?page=buildings&amp;cmd=insert&amp;building="+array_build[e]+"';\" value='Repetir' type='button'>\n\
                                            </center>\n\
                                        </td>\n\
                                        <td class='l' width='56'>\n\
                                            <font color='red'>\n\
                                                <a href='game.php?page=buildings&amp;listid="+array_list[e]+"&amp;cmd=remove&amp;planet=1'>Cancelar</a>\n\
                                            </font>\n\
                                        </td>\n\
                                    </tr>\n\
                                </tbody>\n\
                            </table>\n\
                        </th>\n\
                    </tr>");

                }


                num++;
        }
        table.innerHTML =page;
}

function barupdate() {
     var barra   = document.getElementById('prodBar');
     var totaltime  = array_barra[pp3];
     ss2         = pp2;
     if ( ss2 <= 0 ) {
         barra.innerHTML = '<font color=\"#000\">100%</font>';
         barra.style.width = 364;
     } else {
         if ( ss2 <= 0 ) {
             barra.innerHTML = '<font color=\"red\">100%</font>';
             barra.style.width = 364;
         } else {
             var percent = Math.round(((totaltime - pp2) / totaltime) *10000) / 100;
             var width = Math.round( percent * 3.64 );
             barra.innerHTML = '<center><font color=\"red\" align=\"center\"><b>' + percent + '%</b></font></center>';
             barra.style.width = width;
         }
         pp2 = pp2 - 0.5;
         //if (timeout == 1) {
             window.setTimeout("barupdate();", 500);
         //}
     }
 }
hora_server =  {time_time};



function Reloj(vars){

    date    =new Date();
    server=date.getTime();
    hora_server1= server - hora_server;


    hora_server2 =  hora_server + hora_server1 + vars*1000;

    var d=new Date(hora_server2);

    var day=d.getDate();
    var hour=d.getHours();
    var min=d.getMinutes();
    var mes=d.getMonth()+1;
    var second=d.getSeconds() ;

    return(day+"/"+mes +" " +hour+":"+min+":"+second);
}

function Reloj2(){

    var ds=new Date();

    var day=ds.getDate();
    var hour=ds.getHours();
    var min=ds.getMinutes();
    var mes=ds.getMonth()+1;
    var second=ds.getSeconds() ;
    document.getElementById('time').innerHTML=day+"/"+mes +" " +hour+":"+min+":"+second;

}

prueba();
}
    </script>
<table width=530>
    
    <tr>
        <th colspan="3">{iv_fields} {planet_field_current} / {planet_field_max}</th>
    </tr>
    <tr>
        <!-- START BLOCK : build -->
        <td class="l">
            <table align="left" border = "0" width="200px" valign="top"  >
                     <tr height="80px">
                        <td class="l" align="left" width="80" valign="top" style="background-image: url({dpath}gebaeude/{i}.gif)"  onclick="window.location.href='game.php?page=infos&gid={i}'" style="cursor: pointer" onmouseover="return overlib('<center><font size=1 color=white><b>{descriptionss}</b></font></center>', RIGHT, WIDTH, 150);" onmouseout="return nd();">
                        </td>
                        <td class="anything">
                            <a href="game.php?page=infos&gid={i}">{n}</a><br>
                                 {nivel}<br>
                                 {time}<br>
                        </td>
                 </tr>
                 <tr height="85px">
                         <td class="anything" colspan="2" align="center" valign="top">
                                 {price}<br> 
                                 {rest_price}                                    
                            </td>
                     </tr>
                     <tr height="10px">
                            <td class="l" colspan="2" align = "center" valign="middle" >{click}</td>
                     </tr>
             </table>
        </td>{cerrar}
        <!-- END BLOCK : build -->
    </tr>
</table>
