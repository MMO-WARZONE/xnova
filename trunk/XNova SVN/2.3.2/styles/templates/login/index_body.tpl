<style type="text/css" >
dt {float: left;width: auto;}fieldset #licencia{text-align: left;}fieldset{text-align: left;}.overlib{font-size: 10px; text-align: left;border: dotted;}
fieldset dt {width: 45%;text-align: left;border: none;border-right: 1px solid #CCCCCC;padding-top: 3px;}fieldset dd {	margin: 0 0 0 45%;	padding: 0 0 0 5px;border: none;border-left: 1px solid #CCCCCC;	vertical-align: top;font-size: 1.00em;text-align: left;}
blockquote { padding:  8px; background-color:  #CCCCCC;margin:  15px 0;clear: both; color: red;  text-align: left}
blockquote a { color:red;}
.Stil1 {color: #FF0000}
.Stil2 {color: #FFFFFF}
</style>
<!--<link  rel="stylesheet"  type="text/css" href="./styles/css/ui.all.css">-->
<!--<script type="text/javascript" src="./scripts/jquery.js"></script>-->
<script type="text/javascript" src="./scripts/jquery2.js"></script>
<!--<script type="text/javascript" src="./scripts/ui.core.js"></script>
<script type="text/javascript" src="./scripts/ui.dialog.js"></script>
<script type="text/javascript" src="./scripts/jquery.bgiframe.js"></script>-->
<script type="text/javascript">
        $(function() {
		$("#registro").dialog({
			bgiframe: false,
                        autoOpen: false,
			modal: true,
                        height: 'auto',
                        width:  '500',
                        title: '{register_at_reg} {servername}',
			buttons: {
				Registrarse: function() {
                                      $.post("reg.php", $("#registro form").serialize(),
                                        function(html) {
                                            htmlArray = html.split('||');
                                            $("#registro #error").html(htmlArray[1]);
                                            if(htmlArray[0]==0){
                                                setTimeout('$("#registro").dialog("close")',2000);
                                            }
                                        });
                                }
			}
                        
		});
	
		$("#lostpassword").dialog({
			bgiframe: false,
                        autoOpen: false,
			modal: true,
                        height: 'auto',
                        width:  '500',
                        title: '{lost_pass_title}',
			buttons: {
				Recuperar: function() {
                                      $.post("index.php?page=lostpassword", $("#lostpassword form").serialize(),
                                        function(html) {
                                            htmlArray = html.split('||');
                                            $("#lostpassword #error").html(htmlArray[1]);
                                            if(htmlArray[0]==0){
                                                setTimeout('$("#lostpassword").dialog("close")',2000);
                                            }
                                        });
                                }
			}

		});
	
		$("#terminos").dialog({
			bgiframe: false,
                        autoOpen: false,
			modal: true,
                        height: '500',
                        width:  'auto',
                        title: 'Terminos de {servername}',
                        buttons: {
				Leidas: function() {
                                      $(this).dialog("close");
                                      $("#rgt").removeAttr("disabled");
                                      $("#rgt").attr("checked","checked");
                                }
			}

		});
	});
      	</script>
<!--INICIO CONDICIONES DE USO -->

<div id="terminos" style="background: #111111 url(styles/css/images/ui-bg_gloss-wave_20_111111_500x100.png) 50% top repeat-x;">

    <table>

        <tr>

    <th><fieldset>
            <legend style="font-size:large"><span style="font-size:11px">1)</span> Servicios</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">1.1)</span> Condiciones de participación</legend>
                <p>Para participar en {servername}, cada usuario tiene que aceptar los Términos y Condiciones de uso.</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">1.2)</span> Responsabilidad</legend>
                <p>{servername} siempre intenta asegurar que sus servicios estén disponibles. Sin embargo, por circunstancias fuera de nuestro alcance, algunos servicios pueden no estar disponibles en un momento dado. El proveedor no es responsable, de ninguna manera, de caídas de servidores, errores de programación, etc.
                En caso de que un usuario se viese perjudicado por caídas de servidores, errores de programación, etc. no le posibilita reclamar la recuperación del estado de su cuenta a un estado anterior al del suceso.
                Véase la sección 8 de estos Términos y Condiciones de uso, concernientes a los términos de responsabilidad.
                </p>
            </fieldset>
        </fieldset>

        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">2)</span> Membresía</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">2.1)</span> Comienzo de la membresía</legend>
                <p>La membresía comienza después de haber registrado una cuenta, en un foro o juego. El usuario debe usar una dirección de e-mail válida. Xnova.es se reserva el derecho de comprobar la validez en cualquier momento.</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">2.2)</span> Cancelación del usuario</legend>
                <p>La membresía puede ser finalizada por el usuario, borrando su cuenta. La destrucción de información, puede retrasarse por motivos técnicos. La retención de datos personales está regulada por la sección 6.</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">2.3)</span> Finalización por el proveedor</legend>
                <p> Ningún usuario tiene derecho a reclamar su participación en {servername}</p>
            </fieldset>
        </fieldset>

        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">3)</span> Contenidos / Responsabilidad</legend>
            <p>
               {servername} proporciona una plataforma que permite a los usuarios comunicarse con los demás. Los usuarios son responsables de los contenidos de sus comunicaciones. La pornografía, xenofobia, contenido ofensivo e/o ilegal, no está permitido, y no forman parte de la responsabilidad del proveedor. Las infracciones podrían desembocar en un borrado directo o bloqueo en {servername}.
</p>
               <p>El proveedor se reserva el derecho de borrar o bloquear cuentas, principal, pero no exclusivamente, en caso de que se produzca una violación de estos Términos y Condiciones de uso o de las reglas del foro o juego.</p>
                <p>La coordinación de proyecto decidirá si una cuenta es borrada.</p>
                <p>Las objeciones sólo pueden dirigirse hacia los miembros del proyecto (administradores). No hay ninguna reclamación legal con respecto a la cancelación de cuenta.

            </p>
        </fieldset>

        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">4)</span> Acciones prohibidas</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">4.1)</span> Acciones manipulativas</legend>
                <p>Ningún usuario tiene derecho a usar cualquier acción, mecanismo, o programa en conjunción con el/los sitios web que pueda interferir con la función y desarrollo del juego. Los usuarios no pueden realizar acciones que causen un estrés inaceptable de las capacidades técnicas del servidor. Los usuarios no pueden bloquear, sobreescribir o modificar el contenido que ha sido generado por la coordinación del proyecto.</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">4.2)</span> Programas prohibidos</legend>
                <p>Está prohibido acceder a cualquier sitio del juego con un programa diferente a un navegador web. Tales programas pueden ser denominados particularmente "Bots", así como otras herramientas, que simulen, reemplacen o suplementen a la interfaz web. Lo mismo se aplica para los scripts y programas completa o parcialmente automatizados que proporcionen ventajas respecto al resto de usuarios. Las funciones de auto actualización y otros mecanismos integrados del navegador web, forman parte de este apartado, siempre y cuando sean acciones automatizadas. El uso de mecanismos que desactiven o eliminen la publicidad está prohibido.
                </p><p> Es irrelevante si el anuncio ha sido bloqueado a propósito o a través de un bloqueador de popups, navegador basado en texto, o cualquier otra función similar. Las únicas excepciones a este apartado, son aquellas que hayan obtenido permiso explícito de Xnova.es.
</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">4.3)</span> Logins directos (entradas directas)</legend>
                <p> El login en una cuenta está permitido solamente desde la página de inicio del juego. La apertura automática de cuentas, sin importar si se muestra la página principal o no, está prohibido.
</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">4.4)</span> Publicidad</legend>
                <p> La publicidad de otras webs que no sean propiedad de los creadores de {servername} o relacionadas con {servername} esta totalmente prohibida.
            *Aclaración*->Con el termino webs relacionadas con {servername} son aquellas que dan algun tipo beneficio a {servername} (Este beneficio tiene que ser visible por la administración)

</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">4.5)</span> Uso de bugs</legend>
                <p>Todo el uso de bugs, ya sea en beneficio propio o en perjuicio de los demás, está terminantemente prohibido y será sancionado, tanto al autor como a los usuarios relacionados con el.
</p>
            </fieldset>
        </fieldset>



        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">5)</span> Restricciones</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">5.1)</span> Número máximo de cuentas</legend>
                <p>Todos los usuarios aceptan usar sólo una cuenta por servidor. Las llamadas "Multis", p. ej. usuarios que no cumplan con esta sección, pueden ser bloqueados o borrados sin previo aviso. (*)
                </p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">5.2)</span> Reglas</legend>
                <p>Los apartados particulares están contenidos en el reglamento de juego. Todos los usuarios están sujetos a dicho reglamento.
                </p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">5.3)</span> Bloqueo</legend>
                <p> Los usuarios pueden ser bloqueados temporal o continuamente a discreción del proveedor. El bloqueo podría ser también en cualquier otro servicio.
</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">5.4)</span> Bashing</legend>
                <p> Si un usuario supera los 6 ataques en 24 horas en un mismo planeta, se considera Bashing y será sancionado durante 7 días. Para reportar actos de Bashing, dirigirse a el GO correspondiente adjuntando los encabezados de los informes. Los ataques con misiles NO cuentan como bashing. Toda nave que inicie una batalla, ya sea una sonda, se considera como ataque. Los ataques a jugadores inactivos, no pueden ser reportados como Bashing.

</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">5.5)</span> Pushing</legend>
                <p>No está permitido a ninguna cuenta obtener provecho injusto de otra cuenta de menor puntuación en materia de recursos. Esto también incluye el comercio fuera de los ratios máximos permitidos [5:3:1] - [3:2:1]. Otro motivo de pushing es el destruir voluntariamente una flota de un jugador de menor puntuación contra un jugador de mayor puntuación, obteniendo el defensor los recursos reciclados para obtener beneficio.
</p>
            </fieldset>
        </fieldset>

        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">6)</span> Restricciones</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">6.1)</span> Almacenamiento de datos personales</legend>
                <p>El proveedor se reserva el derecho de almacenar datos personales de los usuarios a fin de supervisar la obediencia de los usuarios a las reglas, los Términos y Condiciones de uso y la legislación aplicable. Los datos objeto de almacenamiento, pueden ser la dirección IP al conectarse, la hora de conexión, y el método empleado, la dirección de email registrada y - si estuviera disponible - todos los datos introducidos en el perfil de usuario de forma voluntaria. En los foros, sólo los datos del perfil de usuario, introducidos por el/ella mismo/a son almacenados.
                </p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">6.2)</span> Transmisión y usos de datos</legend>
                <p>El proveedor se reserva el derecho, en cumplimiento con el Acto de protección de datos alemán y todos los demás estatutos legales aplicables, de divulgar datos personales a las autoridades, abogados o vendedores, si fuese necesario para, y tanto como fuese necesario, la protección de los intereses del proveedor y sus derechos o la protección de los deberes de las autoridades legales.
                    <br>
                    Los datos personales no serán divulgados a terceros, en particular a socios de publicidad o comerciales o publicidad propia. Los datos que se transmitan durante un pago, están explícitamente exentos de divulgación, excepto para los requerimientos legales esenciales.
                </p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">6.3)</span> Objeción</legend>
                <p> El usuario puede objetar el almacenamiento de datos personales en cualquier momento.
                    <br>Dado que la participación en los juegos requiere el almacenamiento de datos personales por motivos técnicos, la/s cuenta/s del usuario serán borradas a la recepción de la objeción, en el menor tiempo posible, dependiendo de la disponibilidad técnica.
                </p>
            </fieldset>
        </fieldset>
        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">7)</span> Derechos del proveedor concerniente a las cuentas</legend>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">7.1)</span> Derechos generales</legend>
                <p>Todas las cuentas, incluyendo sus recursos, unidades, etc. son objetos virtuales del juego. El usuario no obtiene la propiedad o cualquier otro derecho sobre la cuenta. Todos los derechos son reservados por el proveedor. No se otorgan derechos al usuario, en particular y especialmente, derechos de explotación.
</p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">7.2)</span> Prohibición de explotación</legend>
                <p> Sin permiso escrito del proveedor, está prohibido acordar con terceros la transferencia, utilización o provisión de cuentas o datos de acceso. En particular, está prohibido vender cuentas o recursos, u obtener cualquier beneficio dejando dicha cuenta o recursos a terceros.
                    <br>  Lo mismo se aplica a los datos de acceso, derechos de uso, o cualquier otro intento de evasión de esta regulación. Las violaciones de estos u otros derechos del proveedor, en particular copyrights, serán informados a las autoridades y perseguidos.
                </p>
            </fieldset>
            <fieldset>
                <legend style="font-size:large"><span style="font-size:11px">7.3)</span> Excepciones</legend>
                <p> No está prohibido transferir cuentas de modo terminante y gratuito, al igual que el "comercio" interno de recursos, siempre que las reglas de juego así lo permitan.
                </p>
            </fieldset>

        </fieldset>

        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">8)</span> Responsabilidad</legend>
            <p>El proveedor no es responsable de cualquier daño causado por el uso de juegos.</p>

        </fieldset>
        <fieldset>
            <legend style="font-size:large"><span style="font-size:11px">9)</span> Modificación de los Términos y Condiciones de uso</legend>
            <p>El proveedor se reserva el derecho de modificar o extender estos Términos y Condiciones de uso en cualquier momento. La modificación o extensión será publicada con al menos dos semanas de antelación antes de ser efectivos.</p>

        </fieldset>


    </th>
        </tr><tr><th class="overlib" style=" color:red">(*) Las cuentas las cuales sean posibles multicuentas y sean bloqueadas y se avise posteriormente al Game Operator correspondiente del universo de la cuenta, no se desbloquearán. Se tiene que avisar anteriormente al Game Operator del universo correspondiente para advertir que las cuentas son de hermanos, compañeros de piso, etcétera.
</th></tr>
    </table>
</div>
<!--FIN CONDICIONES DE USO -->

<!--INICIO REGISTRO -->
<div id="registro" style="background: #111111 url(styles/css/images/ui-bg_gloss-wave_20_111111_500x100.png) 50% top repeat-x;">
    <div id="error" ></div>
    <form name="reg_form">
        <input type="hidden" value="{ref}" name="ref" >
    <center>
              
                        <span id="text1">
                            <table>
                                    <tr>
                                    <td>{user_reg}:</td>
                                    <td><input id="user" name="character" size="20" maxlength="20" type="text"></td>
                                </tr>
                                    <tr>
                                    <td>{pass_reg}:</td>
                                    <td><input id="pass" name="passwrd" size="20" maxlength="20" type="password"></td>
                                </tr>
                                    <tr>
                                    <td>{email_reg}:</td>
                                    <td><input id="email" name="email" size="20" maxlength="40" type="text"></td>
                                </tr>
                                  <!-- START BLOCK : captcha -->
                                  <tr>
                                            <td height="20" colspan="2">
                                                <div align="center">
                                                <img src="captcha.php" alt="CAPTCHA" /><br><input id="captch" type="text" name="captchastring" size="38" />
                                                </div>
                                            </td>
                                  </tr>
                                  <!-- END BLOCK : captcha -->
                            </table>
                        </span>


        <span id="text2"><center><b onclick='$("#terminos").dialog("open");' onmouseover='$(this).css("color","red");' onmouseout='$(this).css("color","");' >{accept_terms_and_conditions}</b> <input id="rgt" name="rgt" type="checkbox"   disabled="disabled" ></b></center>
                            </span><br>   </center>
</form>
</div>
<!--FIN Registro -->
<!--INICIO RECUPERACION PASSWORD -->

<div id="lostpassword" style="background: #111111 url(styles/css/images/ui-bg_gloss-wave_20_111111_500x100.png) 50% top repeat-x;">
    <div id="error" ></div>
    <form action="" name="lstpass_form" method="post">
            <div id="content">
                       	{lost_pass_text}
                    <div id="text2">

                            <center><b><br>{email}: <input type="text" name="email" /></b></center>

                    </div>
			</div>
</form>

</div>
<!--FIN RECUPERACION PASSWORD -->
<!--INICIO LOGIN -->

<div id="login">
<center>{error}<br /><br />
<br />
<table  cellpadding=0  width="440"><tbody><tr><td colspan="2" class="c" align=left>
<span class="Stil1" style="font-size:20px"><b>{welcome_to} {servername}</b><table align=right>

      <th  align=right><p><a href="{forum_url}" target="new">{forum}
		</a></p></th>
	    
    </table></span></td>
        </tr><tr><th colspan="2" rowspan="2" width="100">
	    <div align="left" class="news Stil2" ><b>{servername} {server_description}</div></th>
</tr><tr><th><div align="left">{log_firefox_download} <a href="http://www.mozilla-europe.org/es/firefox/" align="right">
<font color="yellow">{log_download}</font></a></div></th></tr></tbody></table>
    
    <table cellpadding=0 cellspacing=0  width="440">
      <tbody>
        <tr>
	<form name="formular" action="" method="post" onsubmit="changeAction('login');" style="margin-top: -9px; margin-left: 70px;">
	    <input name="timestamp" value="1173621187" type="hidden"><input name="v" value="2" type="hidden">

        </tr>
        <tr>
          <th width="220"><div align="center"><a href="#" onclick='$("#registro").dialog("open");' ><font color="orange"><b>
				{server_register}</a></div></th>
          <th width="220">
              <p>
                  <a href="#" onclick='$("#lostpassword").dialog("open");' >
                      <font color="red"><b>{lostpassword}</b></font></a></p></th>
        </tr>
        <tr>
          <th width="220">{user}</th>
          <th width="220"><input name="username" value="" type="text"></th>
        </tr>
        <tr>
          <th>{pass}</th>
          <th width="220"><input name="password" value="" type="password"></th>
      </tr>
      <tr>
          <th>{remember_pass}
          <input  name="rememberme" type="checkbox">
      </th>
	<th width="220"><!--<script type="text/javascript">document.formular.Uni.focus(); </script>-->
          <input name="submit" value="{login}" type="submit">
          </th>
      </tr>
    </table>
</center>
</div>

<!--FIN LOGIN -->