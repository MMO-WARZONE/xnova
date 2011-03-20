
<!--

/**
  * menu.tpl
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->
        <div style='position:absolute; top:3.5%; right:4%;' >{message}</div>


        <table cellspacing='0' cellpadding='0' style='width:92%; height:15px;'>
            <tr><td class='sb' style='width:100%; height:15px; font-size:100%;' align='left'><div style='text-align:left; float:left;'   > <a href="javascript:animatedcollapse.toggle('new1008')" title=''> {menu_015} </a> {NumberMembersOnline} {cantmessa} {cantban} {cantsupp} {canterror} </div>
                                                                                             <div style='text-align:right; float:right;' > {4be_bb} - <a href="{forum_url}" target="_blank">{menu_012}</a> - {ADMIN_LINK} <a href="javascript:top.location.href='login.php?page=logout'" style='color:#FF0000'>{menu_013}</a> </div></td></tr>
        </table>

        <table cellspacing='0' cellpadding='0' style='width:92%;'>
            <tr><td class='sb' style='width:100%; height:3px;'></td></tr>
        </table>

        <table cellspacing='0' cellpadding='0' style='width:92%;'>
            <tr><td valign='top'  align='center' style='width:10%; height:35px;'>

                <table cellspacing='0' cellpadding='0' style='width:160px;height:17px;'>
                <tr><td class='sb' align="center" style="width:100%;" valign='middle' >{name} <a href='game.php?page=changelog' style='color:red;'>{nummer}</a></td></tr>
                </table><img style='width:160px; height:12px' src='./{dpath}balken/menu_01.png' alt=''>

                <table cellspacing='0' cellpadding='0'>
                    <tr><td style='width:100%; height:5px;'></td></tr>
                </table>

               <img src='{dpath}balken/menu_07.png' style='width:160px; height:12px;' alt=''><table cellspacing='0' cellpadding='0' style='width:160px;'>
                    <tr><td class='sb' align='left'><a href='overview.php' title="{planet_name}"><img src='{dpath}planeten/{image}.gif' alt='' style='width:25px; height:25px;' ></a></td>
                        <td class='sb' align='center'><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">{planetlist}  </select></td></tr>
                    <tr><td class='sb' align='center' style='width:25px' ><img src='./styl/image/pfeile/rechto.png' alt=''></td>
                        <td class='sb' align='left' style='width:135px'>{planet_name}</td></tr>
                </table>

                    </td>
                <td valign='top'><img style='width:29px; height:29px' src='./{dpath}balken/menu_02.png' alt=''></td>
                <td valign='top' style='width:17%;'>

                    <img style='width:100%; height:28px' src='./{dpath}balken/menu_03.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100%;'>
                        <tr><td class='sb' align='left'   style='width:5%;' ><img src='{dpath}images/metall.gif' alt='' style='width:18px; height:14px;' ></td>
                            <td class='sb' align='left'   style='width:90%; font-size:80%' > {Metal}:                                                     </td>
                            <td class='sb' align='right'  style='width:5%;  font-size:80%' > {metal_max}                                                  </td></tr>
                        <tr><td class='sb' align='center' style='height:19; font-size:80%' colspan='3'><div id='metal'>                             </div></td></tr>
                    </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_04.png' alt=''>

                    </td>
                <td valign='top'><img style='width:6px; height:12px' src='./{dpath}balken/menu_05.png' alt=''></td>
                <td valign='top' style='width:17%;'>

                    <img style='width:100%; height:28px' src='./{dpath}balken/menu_03.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100%;'>
                        <tr><td class='sb' align='left'   style='width:5%;'  ><img src='{dpath}images/kristall.gif' alt='' style='width:18px; height:14px;' ></td>
                            <td class='sb' align='left'   style='width:90%; font-size:80%' > {Crystal}:                                                      </td>
                            <td class='sb' align='right'  style='width:5%;  font-size:80%' > {crystal_max}                                                   </td></tr>
                        <tr><td class='sb' align='center' style='height:19; font-size:80%' colspan='3'><div id='crystal'>                              </div></td></tr>
                    </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_04.png' alt=''>

                    </td>
                <td valign='top'><img style='width:5px; height:12px' src='./{dpath}balken/menu_05.png' alt=''></td>
                <td valign='top' style='width:17%;'>

                    <img style='width:100%; height:28px' src='./{dpath}balken/menu_03.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100%;'>
                        <tr><td class='sb' align='left'   style='width:5%;'  ><img src='{dpath}images/deuterium.gif' alt='' style='width:18px; height:14px;' ></td>
                            <td class='sb' align='left'   style='width:90%; font-size:80%' > {Deuterium}:                                                     </td>
                            <td class='sb' align='right'  style='width:5%;  font-size:80%' > {deuterium_max}                                                  </td></tr>
                        <tr><td class='sb' align='center' style='height:19; font-size:80%' colspan='3'><div id='deut'>                                  </div></td></tr>
                    </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_04.png' alt=''>

                    </td>
                <td valign='top'><img style='width:6px; height:12px' src='./{dpath}balken/menu_05.png' alt=''></td>
                <td valign='top' style='width:17%;'>

                    <img style='width:100%; height:28px' src='./{dpath}balken/menu_03.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100%;'>
                        <tr><td class='sb' align='left'   style='width:5%;'  ><img src='{dpath}images/appolonium.gif' alt='' style='width:18px; height:14px;' ></td>
                            <td class='sb' align='left'   style='width:90%; font-size:80%' > {Appolonium}:                                                     </td>
                            <td class='sb' align='right'  style='width:5%;  font-size:80%' > {appolonium_max}                                                  </td></tr>
                        <tr><td class='sb' align='center' style='height:19; font-size:80%' colspan='3'><div id='appol'>                                  </div></td></tr>
                    </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_04.png' alt=''>

                    </td>
                <td valign='top'><img style='width:5px; height:12px' src='./{dpath}balken/menu_05.png' alt=''></td>
                <td valign='top' style='width:17%;'>

                    <img style='width:100%; height:28px' src='./{dpath}balken/menu_03.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100%;'>
                        <tr><td class='sb' align='left'  style='width:5%;'  ><img src='{dpath}images/energie.gif' alt='' style='width:18px; height:14px;' ></td>
                            <td class='sb' align='left'  style='width:95%; font-size:80%'>{Energy}:                                                        </td>
                        <tr><td class='sb' align='center' style='height:19; font-size:80%' colspan='2'>{energy_total} / {energy_max}                       </td></tr>
                    </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_04.png' alt=''>

                    </td>
                <td valign='top'><img style='width:20px; height:12px' src='./{dpath}balken/menu_06.png' alt=''></td></tr>
        </table>

            </td></tr>
    <tr><td style='width:160px' valign='top' >

        <table cellspacing='0' style='width:160px'>
            <tr><td class='sb' align="center" ></td></tr>
        </table><img src='{dpath}balken/menu_08.png' style='width:160px; height:12px;' alt=''>

        <div id="new1008" style='display:none'>

        <table cellspacing="0" style="height:5px;">
            <tr><td></td></tr>
        </table>

        <img src='{dpath}balken/menu_07.png' style='width:160px; height:12px;' alt=''><table cellspacing='0' cellpadding='0' style='width:160px;'>
            <tr><td class='sb'>

                <table cellspacing='0' cellpadding='0' style='width:100%;'>
                    <tr><td rowspan='3' align='left' > {volk}     </td></tr>
                    <tr><td align='center' ><u> {username}    </u></td></tr>
                    <tr><td align='center' ><u> {volk1}       </u></td></tr>
                    <tr><td colspan='2'><div style='text-align:left; float:left;'  >- {menu_058}                           </div>
                                        <div style='text-align:right; float:right;'>  {user-id}                            </div></td></tr>
                    <tr><td colspan='2'><div style='text-align:left; float:left;'  ><a title='{info_01}'>- {menu_059}  </a></div>
                                        <div style='text-align:right; float:right;'>  {user-zone}                          </div></td></tr>
                </table>

                    </td></tr>
        </table><img src='{dpath}balken/menu_08.png' style='width:160px; height:12px;' alt=''></div>

        <table cellspacing='0' style='height:5px;'>
            <tr><td></td></tr>
        </table>

        <img src='{dpath}balken/menu_07.png' style='width:160px; height:12px;' alt=''><table cellspacing='0' cellpadding='0' style='width:160px;'>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_050}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {1be_aa}<br>
                                                                 &nbsp;&nbsp;- {1be_ab}<br>
                                                                 &nbsp;&nbsp;- {1be_ac}<br>
                                                                 &nbsp;&nbsp;- {1be_ad}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_051}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {2be_aa}<br>
                                                                 &nbsp;&nbsp;- {2be_ab}<br>
                                                                 &nbsp;&nbsp;- {2be_ac}<br>
                                                                 &nbsp;&nbsp;- {2be_ad}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_052}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {3be_aa}<br>
                                                                 &nbsp;&nbsp;- {3be_ab}<br>
                                                                 &nbsp;&nbsp;- {3be_ac}<br>
                                                                 &nbsp;&nbsp;- {3be_ad}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_053}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {4be_aa}<br>
                                                                 &nbsp;&nbsp;- {4be_ab}<br>
                                                                 &nbsp;&nbsp;- {4be_ac}<br>
                                                                 &nbsp;&nbsp;- {4be_ad}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_054}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {1be_ba}<br>
                                                                 &nbsp;&nbsp;- {1be_bb}<br>
                                                                 &nbsp;&nbsp;- {1be_bc}<br>
                                                                 &nbsp;&nbsp;- {1be_bd}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_055}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {2be_ba}<br>
                                                                 &nbsp;&nbsp;- {2be_bb}<br>
                                                                 &nbsp;&nbsp;- {2be_bc}<br>
                                                                 &nbsp;&nbsp;- {2be_bd}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_056}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {3be_ba}<br>
                                                                 &nbsp;&nbsp;- {3be_bb}<br>
                                                                 &nbsp;&nbsp;- {3be_bc}<br>
                                                                 &nbsp;&nbsp;- {3be_bd}</td></tr>
            <tr><td class='sb' align='left' style='width:100%; height:15px;' valign='bottom'>- {menu_057}</td></tr>
            <tr><td class='sb' align='left' style='width:100%;' >&nbsp;&nbsp;- {4be_ba}<br>
                                                                 &nbsp;&nbsp;- <a href='{forum_url}' target='_blank'>{menu_012}</a><br>
                                                                 &nbsp;&nbsp;- {4be_bb}<br>
                                                                 &nbsp;&nbsp;- <a href="javascript:top.location.href='login.php?page=logout'" style='color:#FF0000'>{menu_013}</a></td></tr>
        </table><img src='{dpath}balken/menu_08.png' style='width:160px; height:12px;' alt=''>

        <table cellspacing='0' style='height:5px;'>
            <tr><td></td></tr>
        </table>

        <img src='{dpath}balken/menu_07.png' style='width:160px; height:12px;' alt=''><table cellspacing='0' cellpadding='0' style='width:160px;'>
            <tr><td class='sb' align='left' style='width:10%;'   >-</td>
                <td class='sb' align='left' style='width:70%;'   ><a href="javascript:animatedcollapse.toggle('new9999')">{menu_900}</a></td>
                <td class='sb' align='left' style='width:20%;'   ><img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
        </table>

        <div id='new9999' style='display:none'><table cellspacing='0' cellpadding='0' style='width:160px;'>
            <tr><td class='sb' align='left' style='width:50%;'  > {menu_901}{menu_951}       </td>
                <td class='sb' align='right' style='width:50%;' > {lm_tx_game}  {menu_950}   </td></tr>
            <tr><td class='sb' align='left' style='width:50%;'  > {menu_902}{menu_951}       </td>
                <td class='sb' align='right' style='width:50%;' > {lm_tx_fleet} {menu_950}   </td></tr>
            <tr><td class='sb' align='left' style='width:50%;'  > {menu_903}{menu_951}       </td>
                <td class='sb' align='right' style='width:50%;' > {lm_tx_serv}  {menu_950}   </td></tr>
            <tr><td class='sb' align='left' style='width:50%;'  > {menu_904}{menu_951}       </td>
                <td class='sb' align='right' style='width:50%;' > {lm_tx_queue}              </td></tr>
        </table><img src='{dpath}balken/menu_08.png' style='width:160px; height:12px;' alt=''>

        <table cellspacing='0' style='height:5px;'>
            <tr><td></td></tr>
        </table>

        <img src='{dpath}balken/menu_07.png' style='width:160px; height:12px;' alt=''></div><table cellspacing='0' cellpadding='0' style='width:160px;'>
            <tr><td class='sb' align='center' style='width:100%;'><a href='credit.php' target='_self' >{name}</a><br>{menu_999}</td></tr>
        </table><img src='{dpath}balken/menu_08.png' style='width:160px; height:12px;' alt=''>

            </td>
        <td align='center' valign='top' style='width:100%'>

        {show_attacklock_notice}
        {show_umod_notice}

<script type="text/javascript">
<!--
var now = new Date();
var event = new Date();
var seconds = (Date.parse(now) - Date.parse(event)) / 1000;
var val = 0;
var val2 = 0;
var val3 = 0;
var val4 = 0;

update();

function update() {
    now = new Date();
    seconds = (Date.parse(now) - Date.parse(event)) / 1000;

    val = (( {metal_perhour} / 3600) * seconds) + {metalh};
    if( val >= {metal_mmax} ) val = {metalh};
    document.getElementById('metal').innerHTML = number_format( val ,0);

    val = ( {crystal_perhour} / 3600) * seconds + {crystalh};
    if( val >= {crystal_mmax} ) val = {crystalh};
    document.getElementById('crystal').innerHTML = number_format( val ,0);

    val = ( {deuterium_perhour} / 3600) * seconds + {deuteriumh};
    if( val >= {deuterium_mmax} ) val = {deuteriumh};
    document.getElementById('deut').innerHTML = number_format( val ,0);

    val = ( {appolonium_perhour} / 3600) * seconds + {appoloniumh};
    if( val >= {appolonium_mmax} ) val = {appoloniumh};
    document.getElementById('appol').innerHTML = number_format( val ,0);

    ID=window.setTimeout('update();',1000);
}

function number_format(number,laenge) {
    number = Math.round( number * Math.pow(10, laenge) ) / Math.pow(10, laenge);
    str_number = number+'';
    arr_int = str_number.split('.');
    if(!arr_int[0]) arr_int[0] = '0';
    if(!arr_int[1]) arr_int[1] = '';

    if(arr_int[1].length < laenge){
        nachkomma = arr_int[1];
        for(i=arr_int[1].length+1; i <= laenge; i++){  nachkomma += '0';  }
        arr_int[1] = nachkomma;
    }

    if(arr_int[0].length > 3){
        Begriff = arr_int[0];
        arr_int[0] = '';

        for(j = 3; j < Begriff.length ; j+=3){
            Extrakt = Begriff.slice(Begriff.length - j, Begriff.length - j + 3);
            arr_int[0] = '.' + Extrakt +  arr_int[0] + '';
        }
        str_first = Begriff.substr(0, (Begriff.length % 3 == 0)?3:(Begriff.length % 3));
        arr_int[0] = str_first + arr_int[0];
    }
    return arr_int[0]+''+arr_int[1];
}
// -->

</script>