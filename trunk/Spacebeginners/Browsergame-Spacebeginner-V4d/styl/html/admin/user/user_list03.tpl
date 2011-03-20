<script type="text/javascript" src="./../scripts/jquery.js"></script>
<script type="text/javascript" src="./../scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('01', 'fade=1,height=auto')
animatedcollapse.addDiv('02', 'fade=1,height=auto')
animatedcollapse.addDiv('03', 'fade=1,height=auto')
animatedcollapse.addDiv('04', 'fade=1,height=auto')
animatedcollapse.addDiv('05', 'fade=1,height=auto')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()

</script><form action="" method="post"><input type="hidden" name="currid" value="{id}">
<table width="100%">

<tr><th width="5%">&nbsp;</th>
    <th align="left" width="95%"><u>{username} Einstellungen</u></th></tr>

</table><p></p><table><tr><th align="center" valign="top" width="90%" ><table width="500px">
<tr><td class="c" align="left" ><a href="javascript:animatedcollapse.toggle('01')">Grund Informationen</a></td></tr>
</table><div id="01" style="display:none"><table width="510px">

<tr><th width="50%" align="left"   >Id des Users:                                                        </th>
    <th width="50%" align="center" >{id}                                                                 </th></tr>
<tr><th width="50%" align="left"   >{user_akt_name}                                               </th>
    <th width="50%" align="center" >{username}                                                           </th></tr>
<tr><th width="50%" align="left"   >Name des Users &auml;ndern:                                          </th>
    <th width="50%" align="center" ><input type="text" name="username" size="30" value="{username}" />   </th></tr>
<tr><th width="50%" align="left"   >Aktuelle E-Mail des Users:                                           </th>
    <th width="50%" align="center" >{email}                                                              </th></tr>
<tr><th width="50%" align="left"   >E-Mail des Users &auml;ndern:                                        </th>
    <th width="50%" align="center" ><input type="text" name="email" size="30" value="{email}"/>          </th></tr>
<tr><th width="50%" align="left"   >Gesperrt: Ja/ Nein                                                   </th>
    <th width="50%" align="center" ><input type="checkbox" name="gesperrt" value="1" {banchecked}/>      </th></tr>
<tr><th width="50%" align="left"   >Urlaub: Ja/Nein                                                      </th>
    <th width="50%" align="center" ><input type="checkbox" name="umod" value="1" {umodchecked}/>         </th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c" align="left" ><a href="javascript:animatedcollapse.toggle('02')">Details der Sperrung (wenn aktiviert)</a></td></tr>
</table><div id="02" style="display:none"><table width="510px">

<tr><th width="50%" align="left"   >Grund der Sperrung:                                                  </th>
    <th width="50%" align="center" ><input name="reason" type="text" size="25" maxlength="50" />         </th></tr>
<tr><th width="50%" align="left"   >Wieviele Tage:                                                       </th>
    <th width="50%" align="center" ><input type="text" name="ban_days" value="0" />                      </th></tr>
<tr><th width="50%" align="left"   >Wieviele Stunden:                                                    </th>
    <th width="50%" align="center" ><input type="text" name="ban_hours" value="0" />                     </th></tr>
<tr><th width="50%" align="left"   >Wieviele Minuten:                                                    </th>
    <th width="50%" align="center" ><input type="text" name="ban_mins" value="0" />                      </th></tr>
<tr><th width="50%" align="left"   >Wieviele Sekunden:                                                   </th>
    <th width="50%" align="center" ><input type="text" name="ban_secs" value="0" />                      </th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c" align="left" ><a href="javascript:animatedcollapse.toggle('03')">Die Forschungsliste</a></td></tr>
</table><div id="03" style="display:none"><table width="510px">

<tr><th width="50%" align="left"   >Spionagetechnik                                                                      </th>
    <th width="50%" align="center" ><input name="spy_tech" type="text" value="{spy_tech}" />                             </th></tr>
<tr><th width="50%" align="left"   >Produktionstechnik                                                                   </th>
    <th width="50%" align="center" ><input name="prod_op" type="text" value="{prod_op}" />                               </th></tr>
<tr><th width="50%" align="left"   >Computertechnik                                                                      </th>
    <th width="50%" align="center" ><input name="computer_tech" type="text" value="{computer_tech}" />                   </th></tr>
<tr><th width="50%" align="left"   >Waffentechnik                                                                        </th>
    <th width="50%" align="center" ><input name="military_tech" type="text" value="{military_tech}" />                   </th></tr>
<tr><th width="50%" align="left"   >Schildtechnik                                                                        </th>
    <th width="50%" align="center" ><input name="defence_tech" type="text" value="{defence_tech}" />                     </th></tr>
<tr><th width="50%" align="left"   >Raumschiffpanzerung                                                                  </th>
    <th width="50%" align="center" ><input name="shield_tech" type="text" value="{shield_tech}" />                       </th></tr>
<tr><th width="50%" align="left"   >Energietechnik                                                                       </th>
    <th width="50%" align="center" ><input name="energy_tech" type="text" value="{energy_tech}" />                       </th></tr>
<tr><th width="50%" align="left"   >Hyperraumtechnik                                                                     </th>
    <th width="50%" align="center" ><input name="hyperspace_tech" type="text" value="{hyperspace_tech}" />               </th></tr>
<tr><th width="50%" align="left"   >Verbrennungstriebwerk                                                                </th>
    <th width="50%" align="center" ><input name="combustion_tech" type="text" value="{combustion_tech}" />               </th></tr>
<tr><th width="50%" align="left"   >Impulstriebwerk                                                                      </th>
    <th width="50%" align="center" ><input name="impulse_motor_tech" type="text" value="{impulse_motor_tech}" />         </th></tr>
<tr><th width="50%" align="left"   >Hyperraumantrieb                                                                     </th>
    <th width="50%" align="center" ><input name="hyperspace_motor_tech" type="text" value="{hyperspace_motor_tech}" />   </th></tr>
<tr><th width="50%" align="left"   >lasertechnik                                                                         </th>
    <th width="50%" align="center" ><input name="laser_tech" type="text" value="{laser_tech}" />                         </th></tr>
<tr><th width="50%" align="left"   >Ionentechnik                                                                         </th>
    <th width="50%" align="center" ><input name="ionic_tech" type="text" value="{ionic_tech}" />                         </th></tr>
<tr><th width="50%" align="left"   >Plasmatechnik                                                                        </th>
    <th width="50%" align="center" ><input name="buster_tech" type="text" value="{buster_tech}" />                       </th></tr>
<tr><th width="50%" align="left"   >Intergalaktisches Forschungsnetzwerk                                                 </th>
    <th width="50%" align="center" ><input name="intergalactic_tech" type="text" value="{intergalactic_tech}" />         </th></tr>
<tr><th width="50%" align="left"   >Expeditionstechnik                                                                   </th>
    <th width="50%" align="center" ><input name="expedition_tech" type="text" value="{expedition_tech}" />               </th></tr>
<tr><th width="50%" align="left"   >Gravitonforschung                                                                    </th>
    <th width="50%" align="center" ><input name="graviton_tech" type="text" value="{graviton_tech}" />                   </th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c" align="left" ><a href="javascript:animatedcollapse.toggle('04')">Magistrat-Punkte</a></td></tr>
</table><div id="04" style="display:none"><table width="510px">

<tr><th width="50%" align="left"   >Magistrat-Punkte                                                                     </th>
    <th width="50%" align="center" ><input name="rpg_points" type="text" value="{rpg_points}" />                       </th></tr>

</table></div><p></p><table width="500px">
<tr><td class="c" align="left" ><a href="javascript:animatedcollapse.toggle('05')">Magistrat-Liste</a></td></tr>
</table><div id="05" style="display:none"><table width="510px">

<tr><th width="50%" align="left"   >Geologe                                                                              </th>
    <th width="50%" align="center" ><input name="rpg_geologue" type="text" value="{rpg_geologue}" />                     </th></tr>
<tr><th width="50%" align="left"   >Admiral                                                                              </th>
    <th width="50%" align="center" ><input name="rpg_amiral" type="text" value="{rpg_amiral}" />                         </th></tr>
<tr><th width="50%" align="left"   >Ingenieur                                                                            </th>
    <th width="50%" align="center" ><input name="rpg_ingenieur" type="text" value="{rpg_ingenieur}" />                   </th></tr>
<tr><th width="50%" align="left"   >Technokrat                                                                           </th>
    <th width="50%" align="center" ><input name="rpg_technocrate" type="text" value="{rpg_technocrate}" />               </th></tr>
<tr><th width="50%" align="left"   >Construkteur                                                                         </th>
    <th width="50%" align="center" ><input name="rpg_constructeur" type="text" value="{rpg_constructeur}" />             </th></tr>
<tr><th width="50%" align="left"   >Wissenschaftler                                                                      </th>
    <th width="50%" align="center" ><input name="rpg_scientifique" type="text" value="{rpg_scientifique}" />             </th></tr>
<tr><th width="50%" align="left"   >Lagermeister                                                                         </th>
    <th width="50%" align="center" ><input name="rpg_stockeur" type="text" value="{rpg_stockeur}" />                     </th></tr>
<tr><th width="50%" align="left"   >Verteidiger                                                                          </th>
    <th width="50%" align="center" ><input name="rpg_defenseur" type="text" value="{rpg_defenseur}" />                   </th></tr>
<tr><th width="50%" align="left"   >Bunker                                                                               </th>
    <th width="50%" align="center" ><input name="rpg_bunker" type="text" value="{rpg_bunker}" />                         </th></tr>
<tr><th width="50%" align="left"   >Spion                                                                                </th>
    <th width="50%" align="center" ><input name="rpg_espion" type="text" value="{rpg_espion}" />                         </th></tr>
<tr><th width="50%" align="left"   >Commandant                                                                           </th>
    <th width="50%" align="center" ><input name="rpg_commandant" type="text" value="{rpg_commandant}" />                 </th></tr>
<tr><th width="50%" align="left"   >Zerst&ouml;rer                                                                       </th>
    <th width="50%" align="center" ><input name="rpg_destructeur" type="text" value="{rpg_destructeur}" />               </th></tr>
<tr><th width="50%" align="left"   >General                                                                              </th>
    <th width="50%" align="center" ><input name="rpg_general" type="text" value="{rpg_general}" />                       </th></tr>
<tr><th width="50%" align="left"   >Raider                                                                               </th>
    <th width="50%" align="center" ><input name="rpg_raideur" type="text" value="{rpg_raideur}" />                       </th></tr>
<tr><th width="50%" align="left"   >Imperator                                                                            </th>
    <th width="50%" align="center" ><input name="rpg_empereur" type="text" value="{rpg_empereur}" />                     </th></tr>

</table></div></th>
<th valign="middle" width="10%" align="right" ><table>

<tr><th><input type="submit" name="submit" value="Speichern"></th></tr>

</table></th></tr>
</table></form>