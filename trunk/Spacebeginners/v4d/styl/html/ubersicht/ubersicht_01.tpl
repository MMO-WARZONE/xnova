
<!--

/**
  * ubersicht_01.tpl
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

-->

<div style='position:absolute; bottom:1%; right:1%' >{bannerframe}             </div>
<div style='position:absolute; bottom:1%; left:180px'  >{ExternalTchatFrame}   </div>

<table cellspacing='0' cellpadding='0' style='width:100%'>
    <tr><td align='left' valign='top' style='width:5%'>

        {NewsFrame2}

        <table style='width:10px'>
            <tr><td align='left'><a href="javascript:animatedcollapse.toggle('new0001')" title='{over_0012}'><img src='./styl/image/overview/User.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
        </table>

        <table style='width:10px'>
            <tr><td align='left'><a href="javascript:animatedcollapse.toggle('new0002')" title='{over_0013}'><img src='./styl/image/overview/Punkte.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
        </table>

        <table style='width:10px'>
            <tr><td align='left'><a href="javascript:animatedcollapse.toggle('new0003')" title='{over_0014}'><img src='./styl/image/overview/Flotten.gif' style='height:25px; width:25px;' alt=''></a></td></tr>
        </table>

        {mienen}
        {raid}

            </td>
        <td align='center' valign='top' style='width:85%'>

        <table cellspacing='0' cellpadding='0' >
            <tr><td align='center' valign='top' >

                <table cellspacing='0' cellpadding='0' style='width:700px;'>
                    <tr><td valign='top'>

                        <div id='new0004' style='display:none'><table cellpadding='0' cellspacing='0' style='height:1px;'>
                            <tr><td></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px' >
                            <tr><td valign='top'>

                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><img style='width:40px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:120px;'>
                                    <tr><td valign='top' class='sb' style='width:120px; height:17px;' align='center'><u>News:</u></td></tr>
                                </table>

                                    </td>
                                <td valign='bottom'><img style='width:29px;  height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                <td valign='bottom'><img style='width:471px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''></td>
                                <td valign='bottom'><img style='width:80px;  height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px;'>
                            <tr><td class='sb' style='width:100%' align='center'>{NewsFrame}</td></tr>
                        </table><img style='width:701px; height:12px' src='./{dpath}balken/menu_57.png' alt='komplettunten.png'></div>

                        <div id='new0005' style='display:none'><table cellpadding='0' cellspacing='0' style='height:1px;'>
                            <tr><td></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px' >
                            <tr><td valign='top'>

                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><img style='width:40px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:120px;'>
                                    <tr><td valign='top' class='sb' style='width:120px; height:17px;' align='center'><u>Raidlevel:</u></td></tr>
                                </table>

                                    </td>
                                <td valign='bottom'><img style='width:29px;  height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                <td valign='bottom'><img style='width:471px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''></td>
                                <td valign='bottom'><img style='width:80px;  height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px;'>
                            <tr><td class='sb' style='width:100%' align='center'>{Have_new_level_raid}</td></tr>
                        </table><img style='width:701px; height:12px' src='./{dpath}balken/menu_57.png' alt='komplettunten.png'></div>

                        <div id='new0006' style='display:none'><table cellpadding='0' cellspacing='0' style='height:1px;'>
                            <tr><td></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px' >
                            <tr><td valign='top'>

                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><img style='width:40px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:120px;'>
                                    <tr><td valign='top' class='sb' style='width:120px; height:17px;' align='center'><u>Mien-Level:</u></td></tr>
                                </table>

                                    </td>
                                <td valign='bottom'><img style='width:29px;  height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                <td valign='bottom'><img style='width:471px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''></td>
                                <td valign='bottom'><img style='width:80px;  height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px;'>
                            <tr><td class='sb' style='width:100%' align='center'>{Have_new_level_mineur}</td></tr>
                        </table><img style='width:701px; height:12px' src='./{dpath}balken/menu_57.png' alt='komplettunten.png'></div>

                        </td></tr>
                </table>

                <table cellspacing='0' cellpadding='0' style='width:700px;'>
                    <tr><td valign='top'><div id='new0001' style='display:none'>

                        <table cellpadding='0' cellspacing='0' style='height:1px;'>
                            <tr><td></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px' >
                            <tr><td valign='top'>

                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><img style='width:40px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:120px;'>
                                    <tr><td valign='top' class='sb' style='width:120px; height:17px;' align='center'><u>User-Information</u></td></tr>
                                </table>

                                    </td>
                                <td valign='bottom'><img style='width:29px;  height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                <td valign='bottom'><img style='width:471px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''></td>
                                <td valign='bottom'><img style='width:80px;  height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:700px;'>
                            <tr><td class='sb' style='width:25%' align='left'                     >- {over_0201} </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    >{uID}         </td>
                                <td class='sb' style='width:25%' align='left'                     >- {over_0202} </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    >{username}    </td>
                            <tr><td class='sb' style='width:25%' align='left'                     >- {over_0203} </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    >{regtime}     </td>
                                <td class='sb' style='width:25%' align='left'                     >- {over_0204} </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    ><a href='alliance.php?mode=ainfo&amp;tag={ally_tag}' >{ally_name} {over_9901}{ally_tag}{over_9902} </a></td></tr>
                            <tr><td class='sb' style='width:25%' align='left'                     >- {over_0205}  </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    >{angriffszone} </td>
                                <td class='sb' style='width:25%' align='left'                     >- {over_0206}  </td>
                                <td class='sb' style='width:25%; color:skyblue' align='center'    >{PlanetCount} {over_0208} {Max_Planets} </td></tr>
                        </table><img style='width:701px; height:12px' src='./{dpath}balken/menu_57.png' alt='komplettunten.png'></div>

                        </td></tr>
                </table>

                    </td></tr>
            <tr><td align='center'>

                <table cellspacing='0' cellpadding='0' style='width:700px;'>
                    <tr><td>

                        <table cellpadding='0' cellspacing='0' style='height:2px;'>
                            <tr><td></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0' style='width:100%'>
                            <tr><td align='center' valign='top'>

                                <table cellpadding='0' cellspacing='0'>
                                    <tr><td valign='top'>

                                        <img style='width:100px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><table cellspacing='0' cellpadding='0' style='width:100px;'>
                                            <tr><td valign='top' class='sb' style='width:100px' align='left'><a href='buildings.php' target='_self'><img src='{dpath}planeten/{planet_image}.gif' style='height:96px; width:96px;' alt=''></a></td></tr>
                                        </table><img style='width:100px; height:12px;' src='./{dpath}balken/menu_10.png' alt=''>

                                            </td>
                                        <td valign='top'>

                                        <img style='width:29px; height:29px;' src='./{dpath}balken/menu_14.png' alt=''><table cellspacing='0' cellpadding='0' style='width:29px;'>
                                            <tr><td valign='top' class='sb' style='height:79px; width:29px;' >&nbsp;</td></tr>
                                        </table><img style='width:29px; height:12px;' src='./{dpath}balken/menu_05.png' alt=''>

                                            </td>
                                        <td valign='bottom'>

                                        <img style='width:102px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:102px; height:79px;'>
                                            <tr><td valign='top' class='sb' style='width:29px;' align='left' >{over_0001}{over_9900}</td></tr>
                                            <tr><td valign='top' class='sb' style='width:29px;' align='left' >{over_0002}{over_9900}</td></tr>
                                            <tr><td valign='top' class='sb' style='width:29px;' align='left' >{over_0003}{over_9900}</td></tr>
                                            <tr><td valign='top' class='sb' style='width:29px;' align='left' >{over_0004}{over_9900}</td></tr>
                                        </table><img style='width:102px; height:12px;' src='./{dpath}balken/menu_05.png' alt=''>

                                            </td>
                                        <td valign='bottom'>

                                        <img style='width:200px; height:12px;' src='./{dpath}balken/menu_11.png' alt=''><table cellspacing='0' cellpadding='0' style='width:200px; height:79px;'>
                                            <tr><td valign='top' class='sb' style='width:200px;' align='center' ><a href='overview.php?mode=renameplanet' >{planet_name}</a></td></tr>
                                            <tr><td valign='top' class='sb' style='width:200px;' align='center' ><a href='galaxy.php?mode=0&amp;galaxy={galaxy_galaxy}&amp;system={galaxy_system}'>{over_9901}{galaxy_galaxy}{over_9900}{galaxy_system}{over_9900}{galaxy_planet}{over_9902}</a></td></tr>
                                            <tr><td valign='top' class='sb' style='width:200px;' align='center' >{planet_diameter} {over_0006}{over_9906} {over_9901}<a title='{over_0010}'>{planet_field_current}</a> {over_9905} <a title='{over_0011}'>{planet_field_max}</a> {over_0009}{over_9902}</td></tr>
                                            <tr><td valign='top' class='sb' style='width:200px;' align='center' >{over_0005}{over_9903} {planet_temp_min}{over_9904}{over_0007} {over_0008} {planet_temp_max}{over_9904}{over_0007}</td></tr>
                                        </table><img style='width:200px; height:12px;' src='./{dpath}balken/menu_05.png' alt=''>

                                            </td>
                                        <td valign='bottom'>

                                        <img style='width:80px; height:12px;' src='./{dpath}balken/menu_12.png' alt=''><table cellspacing='0' cellpadding='0' style='width:80px;'>
                                            <tr><td class='sb' style='height:79px; width:29px;' align='center' valign='middle'>{moon_img}</td></tr>
                                        </table><img style='width:80px; height:12px;' src='./{dpath}balken/menu_13.png' alt=''>

                                            </td></tr>
                                </table>

                                    </td></tr>
                            <tr><td align='center'>

                                <table cellpadding='0' cellspacing='0' style='height:2px;'>
                                    <tr><td></td></tr>
                                </table>

                                <table cellspacing="0" cellpadding="0" style='width:100%'>
                                    <tr><td valign="top" >

                                        <table cellpadding='0' cellspacing='0' style='width:135px;'>
                                            <tr><td valign='top'>

                                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><table cellspacing='0' cellpadding='0' style='width:80px;'>
                                                    <tr><td valign='top' class='sb' style='width:100px; height:17px;' align='center'><u>{over_0101}</u></td></tr>
                                                </table>
                                                    </td>
                                                <td valign='bottom'><img style='width:29px; height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                                <td valign='bottom'><img style='width:58px; height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                                            <tr><td class='sb' valign='middle' colspan="3"  align='center' style='width:100%;' >{build}</td> </tr>
                                        </table><img style='width:167px; height:12px;' src='./{dpath}balken/menu_53.png' alt=''>

                                            </td>
                                        <td style="width:3px;" ></td>
                                        <td valign="top" >

                                        <table cellpadding='0' cellspacing='0' style='width:135px;'>
                                            <tr><td valign='top'>

                                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><table cellspacing='0' cellpadding='0' style='width:80px;'>
                                                    <tr><td valign='top' class='sb' style='width:100px; height:17px;' align='center'><u>{over_0102}</u></td></tr>
                                                </table>
                                                    </td>
                                                <td valign='bottom'><img style='width:29px; height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                                <td valign='bottom'><img style='width:58px; height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                                            <tr><td class='sb' valign='middle' colspan="3"  align='center' style='width:100%;' >{tech}</td> </tr>
                                        </table><img style='width:167px; height:12px;' src='./{dpath}balken/menu_53.png' alt=''>

                                            </td>
                                        <td style="width:3px;" ></td>
                                        <td valign="top" >

                                        <table cellpadding='0' cellspacing='0' style='width:135px;'>
                                            <tr><td valign='top'>

                                                <img style='width:80px; height:12px;' src='./{dpath}balken/menu_09.png' alt=''><table cellspacing='0' cellpadding='0' style='width:80px;'>
                                                    <tr><td valign='top' class='sb' style='width:100px; height:17px;' align='center'><u>{over_0110}</u></td></tr>
                                                </table>
                                                    </td>
                                                <td valign='bottom'><img style='width:29px; height:29px;' src='./{dpath}balken/menu_14.png' alt=''></td>
                                                <td valign='bottom'><img style='width:58px; height:12px;' src='./{dpath}balken/menu_12.png' alt=''></td></tr>
                                            <tr><td class='sb' valign='middle' colspan="3"  align='center' style='width:100%;' >{hangar}</td> </tr>
                                        </table><img style='width:167px; height:12px;' src='./{dpath}balken/menu_53.png' alt=''>

                                            </td></tr>
                                </table>

                                    </td></tr>
                        </table>

                            </td>
                        <td align='center' style='width:1px' valign='top'></td>
                        <td align='center'  valign='top' >

                        <table cellspacing='0' cellpadding='0' style='width:188px; height:31px;'>
                            <tr><td valign='bottom'><img style='width:188px; height:12px;' src='./{dpath}balken/menu_52.png' alt=''></td></tr>
                        </table>

                        <table cellspacing='0' cellpadding='0'  style='width:188px;'>
                            <tr><td style='width:5%;' class='sb' align='left' title="{over_0101}"><a href="./game.php?page=stat" >1.</a></td>
                                <td class='sb' style='width:95%;' align='center'>{user_points}          </td></tr>
                            <tr><td class='sb' style='width:5%;' align='left' title="{over_0102}"><a href="./game.php?page=stat" >2.</a></td>
                                <td class='sb' style='width:95%;' align='center'>{player_points_tech}   </td></tr>
                            <tr><td class='sb' style='width:5%;' align='left' title="{over_0103}"><a href="./game.php?page=stat" >3.</a></td>
                                <td class='sb' style='width:95%;' align='center'>{user_fleet}           </td></tr>
                            <tr><td class='sb' style='width:5%;' align='left' title="{over_0104}"><a href="./game.php?page=stat" >4.</a></td>
                                <td class='sb' style='width:95%;' align='center'>{user_def}             </td></tr>
                            <tr><td class='sb' style='width:5%;' align='left' title="{over_0105}"><a href="./game.php?page=stat" >5.</a></td>
                                <td class='sb' style='width:95%; color:#FF0000; height:15px;' align='center'>{total_points} </td></tr>
                        </table><img style='width:188px; height:12px;' src='./{dpath}balken/menu_53.png' alt=''>

                        <div id='new0002' style='display:none'><table cellspacing='0' cellpadding='0'>
                            <tr><td style='height:1px;'></td></tr>
                        </table>

                        <img style='width:188px; height:12px' src='./{dpath}balken/menu_52.png' alt='oben.png' ><table cellspacing='0' style='width:188px'>
                            <tr><td class='sb' style='width:50%;' align='center'><img src='./styl/image/pfeile/linku.png' alt=''> {over_0106} <img src='./styl/image/pfeile/rechtu.png' alt=''></td>
                                <td class='sb' style='width:50%;' align='center'><img src='./styl/image/pfeile/linku.png' alt=''> {over_0107} <img src='./styl/image/pfeile/rechtu.png' alt=''></td></tr>
                            <tr><td class='sb' style='width:50%;' align='center'>{over_0108} {over_9900} {lvl_minier}    </td>
                                <td class='sb' style='width:50%;' align='center'>{xpminier}  {over_9905} {lvl_up_minier} </td></tr>
                            <tr><td class='sb' style='width:50%;' align='center'>{over_0109} {over_9900} {lvl_raid}      </td>
                                <td class='sb' style='width:50%;' align='center'>{xpraid}    {over_9905} {lvl_up_raid}   </td></tr>
                        </table><img style='width:188px; height:12px' src='./{dpath}balken/menu_53.png' alt='unten.png'></div>

                            </td></tr>
                </table>

                    </td></tr>
            <tr><td align='center' style='width:700px;'>

                <table style='width:700px;'>
                     <tr><td align='center'>

                         <div id='new0003' style='display:none'><img style='width:100%; height:12px' src='./{dpath}balken/menu_56.png' alt=''><table cellspacing='0' style='width:700px'>
                             <tr><td style='width:20%' class='sb' align='center'><img src='./styl/image/pfeile/linku.png' alt='linku.png'> {over_0301} <img src='./{dpath}img/rechtu.png' alt='rechtu.png'></td>
                                 <td style='width:20%' class='sb' align='center'><img src='./styl/image/pfeile/linku.png' alt='linku.png'> {over_0302} <img src='./{dpath}img/rechtu.png' alt='rechtu.png'></td>
                                 <td style='width:20%' class='sb' align='center'><img src='./styl/image/pfeile/linku.png' alt='linku.png'> {over_0303} <img src='./{dpath}img/rechtu.png' alt='rechtu.png'></td>
                                 <td style='width:20%' class='sb' align='center'><img src='./styl/image/pfeile/linku.png' alt='linku.png'> {over_0304} <img src='./{dpath}img/rechtu.png' alt='rechtu.png'></td>
                                 <td style='width:20%' class='sb' align='center'><img src='./styl/image/pfeile/linku.png' alt='linku.png'> {over_0305} <img src='./{dpath}img/rechtu.png' alt='rechtu.png'></td></tr>
                             <tr><td style='width:20%' class='sb' align='left'>{over_0306}: </td>
                                 <td style='width:20%' class='sb' align='center'>{res_atk_metal}                  </td>
                                 <td style='width:20%' class='sb' align='center'>{res_atk_crystal}                </td>
                                 <td style='width:20%' class='sb' align='center'>{res_atk_deuterium}              </td>
                                 <td style='width:20%' class='sb' align='center'>{res_atk_appolonium}             </td></tr>
                             <tr><td style='width:20%' class='sb' align='left'>{over_0307}: </td>
                                 <td style='width:20%' class='sb' align='center'>{res_trans_metal}                </td>
                                 <td style='width:20%' class='sb' align='center'>{res_trans_crystal}              </td>
                                 <td style='width:20%' class='sb' align='center'>{res_trans_deuterium}            </td>
                                 <td style='width:20%' class='sb' align='center'>{res_trans_appolonium}           </td></tr>
                             <tr><td style='width:20%' class='sb' align='left'>{over_0308}: </td>
                                 <td style='width:20%' class='sb' align='center'>{res_statio_metal}               </td>
                                 <td style='width:20%' class='sb' align='center'>{res_statio_crystal}             </td>
                                 <td style='width:20%' class='sb' align='center'>{res_statio_deuterium}           </td>
                                 <td style='width:20%' class='sb' align='center'>{res_statio_appolonium}          </td></tr>
                             <tr><td style='width:20%' class='sb' align='left'>{over_0309}: </td>
                                 <td style='width:20%' class='sb' align='center'>{res_debris_metal}               </td>
                                 <td style='width:20%' class='sb' align='center'>{res_debris_crystal}             </td>
                                 <td style='width:20%' class='sb' align='center'>{res_debris_deuterium}           </td>
                                 <td style='width:20%' class='sb' align='center'>{res_debris_appolonium}           </td></tr>
                             <tr><td style='width:20%' class='sb'  align='left'>{over_0310}:                </td>
                                 <td style='width:20%; color:#FF0000' class='sb' align='center'>{res_all_metal}        </td>
                                 <td style='width:20%; color:#FF0000' class='sb' align='center'>{res_all_crystal}      </td>
                                 <td style='width:20%; color:#FF0000' class='sb' align='center'>{res_all_deuterium}    </td>
                                 <td style='width:20%; color:#FF0000' class='sb' align='center'>{res_all_appolonium}   </td></tr>
                             <tr><td style='width:20%' class='sb'  align='left'>&nbsp;              </td>
                                 <td colspan="5" class='sb' align='center'>&nbsp;        </td></tr>
                             <tr><td style='width:20%;' class='sb' align='left' >{over_0311}:                           </td>
                                 <td style='width:20%;' class='sb' align='center'>{metal_debris}         </td>
                                 <td style='width:20%;' class='sb' align='center'>{crystal_debris}       </td>
                                 <td style='width:20%;' class='sb' align='center'>-                      </td>
                                 <td style='width:20%;' class='sb' align='center'>{appolonium_debris}    </td></tr>
                         </table><img style='width:100%; height:12px' src='./{dpath}balken/menu_57.png' alt=''>

                         <br><br></div>

                         {fleet_anfang}
                         {fleet_mitte}
                         {fleet_ende}

                             </td></tr>
                </table>

                    </td></tr>
        </table>

            </td>
        <td style='width:10%' align='center' valign='top'>

        <table style='width:100%' cellspacing='0' >
            {anothers_planets}<td>&nbsp;</td></tr>
        </table>

            </td></tr>
</table>
