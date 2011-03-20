<style>
dt {
	float: left;
	width: auto;
}
fieldset #licencia{

	text-align: left;

}
.overlib{
        font-size: 10px;
        text-align: left;
        border: dotted;
}
fieldset dt {
	width: 45%;
	text-align: left;
	border: none;
	border-right: 1px solid #CCCCCC;
	padding-top: 3px;
}
fieldset dd {
	margin: 0 0 0 45%;
	padding: 0 0 0 5px;
	border: none;
	border-left: 1px solid #CCCCCC;
	vertical-align: top;
	font-size: 1.00em;
        text-align: left;
}

blockquote {
        padding:  8px;
        background-color:  #CCCCCC;
        margin:  15px 0;
        clear: both;
        color: red;
        text-align: left
}
blockquote a {
        color:red;
}


</style>
<table width="700">
<tr>
	<td width="120px" colspan="3" class="c" align="center">


<font size="2px">Menú de instalación [<a href="?mode=intro">Inicio</a> - <a href="?mode=ins&page=1">Instalar</a> - <a href="index.php?mode=license">Licencia</a> - <a href="index.php?mode=upgrade">Actualizar</a>]</font></td>
</tr>
<form action="{dis_ins_btn}" method="post">
<!-- START BLOCK : intro -->
<tr>
	<th colspan="2" align="left"><div id="main" align="left">
      <h1>Introducción</h1>
	  <p>¡Bienvenido a Xnova Svn!<br />
	      <br />
	    Xnova Svn es uno de los mejores clones de OGame que se separan de este. Xnova Svn v2.0 es el &uacute;ltimo y m&aacute;s estable paquete nunca antes desarrollado. Tal cual como las otras versiones, Xnova Svn recibe soporte del equipo de Xnova Svn, asegur&aacute;ndonos siempre de lograr la mejor calidad en atenci&oacute;n y la estabilidad de la versi&oacute;n. Xnova Svn 2 d&iacute;a a d&iacute;a busca; crecimiento, estabilidad, flexibilidad, dinamismo, calidad y la confianza del usuario en que es su mejor opci&oacute;n y elecci&oacute;n. Siempre esperamos que Xnova Svn sea mejor que sus expectativas.<br />
	    <br />
	    El sistema de instalaci&oacute;n te guiar&aacute; a trav&eacute;s de la instalaci&oacute;n del mismo, o la actualizaci&oacute;n de una versi&oacute;n anterior a la m&aacute;s reciente. Cualquier duda, problema o consulta no dudes en consulta nuestra <a href="http://foro.xnova-svn.es/"><em>comunidad de desarrollo y soporte</em></a>. <br />
	    <br />
	    Xnova Svn es un proyecto Creative Commons (Reconocimiento-No comercial-Compartir bajo la misma licencia 3.0 Unported), para ver las especificaciones de la licencia haz click en licencia en la barra superior. Para comenzar la instalación haz click en el botón instalar o para actualizar a la versión más nueva haz click en el botón actualizar.</p>
    </div></th>
</tr>
<!-- END BLOCK : intro -->
<!-- START BLOCK : requisitos -->

<tr>
    <th colspan=2>

        <h1>Compatibilidad de la instalación</h1>
        <p>Antes de proceder con la instalación completa Xnova Svn llevará a cabo algunas pruebas de la configuración y archivos en su servidor para asegurarse de que puede instalar y ejecutar Xnova Svn. Por favor asegúrese de leer completa y cuidadosamente los resultados y no continuar hasta que todos las pruebas requeridas estén aprobadas. Si quiere usar algunas de las capacidades dependientes de las pruebas opcionales, debería asegurarse de que esas pruebas también se aprueben.</p>
    </th>

</tr>
<tr>

    <th><fieldset>
            <legend style="font-size:large" >Versión y parámetros PHP</legend>
			<p><strong>Obligatorio</strong> - Necesitá al menos la versión 5.1 de PHP con el fin de instalar Xnova Svn.</p>

			<dl>
				<dt>Versión PHP >= 5.1:</dt>
				<dd><strong style="color:{version_color}">{version}</strong></dd>
			</dl>
        </fieldset>
        <fieldset>
			
            <legend style="font-size:large" >Bases de datos soportadas</legend>
            <p><strong>Obligatorio</strong> - Necesitá soporte para al menos una base de datos compatible con PHP. Si no se muestran módulos disponibles debería contactar a su proveedor de hosting o revisar la documentacion de PHP pertinente.</p>
            <!--<dl>
                    <dt>MySQL con Extensiones MySQLi:</dt>
                    <dd><strong style="color: green;">Disponible</strong></dd>
            </dl>
-->

            <dl>
                    <dt>MySQL:</dt>

                    <dd><strong style="color: green;">{mysql}</strong></dd>
            </dl>


            </fieldset>
    </th>
</tr>
<tr>
    
    <th>
        <fieldset >

            <legend style="font-size:large" >Módulos opcionales</legend>
            <p><strong>Opcional</strong> - Estos módulos o aplicaciones son opcionales. Sin embargo, si están disponibles habilitarán capacidades extras.</p>
            <dl>
                    <dt>Soporte para librería GD [ Confirmación Visual ]:</dt>
                    <dd><strong style="color:{captcha_color}">{captcha}</strong></dd>
            </dl>
        </fieldset>
        </th>
    </tr>
<tr>
    <th><fieldset>

		<legend style="font-size:large" >Archivos y carpetas opcionales</legend>
		<p><strong>Opcional</strong> - Estos archivos, carpetas o permisos no son imprescindibles. La instalación intentará varias técnicas para crearlos si no existen o no se pueden escribir. Sin embargo, especificarlos acelerará la instalación.</p>

			<dl>
				<dt>config.php:</dt>
				<dd><strong style="color:{config_dir_color}">{config_dir}</strong>, <strong style="color:{config_color}">{config}</strong></dd>
			</dl>
	</fieldset>
        </th>
    
</tr>
<tr>

    <th colspan=2>
        <fieldset>
		<legend style="font-size:large" >Comenzar instalación</legend>

		<input name="submit" value="Comenzar la instalación" type="submit"  {disabled}>

	</fieldset></th>
</tr>
			

<!-- START BLOCK : requisitos -->
<!-- START BLOCK : form -->
<tr>
	<th colspan="3"><font color="red">Antes de instalar cambie los permisos del archivo config.php a "CHMOD 777"</font></th>
</tr>
<tr>
	<th>Servidor SQL: <br /> Ej: localhost</th>
	<th><input type="text" name="host" value="" size="30" /></th>
</tr>
<tr>
	<th>Base de datos: <br /> Ej: game</th>
	<th><input type="text" name="db" value="" size="30" /></th>
</tr>
<tr>
	<th>Usuario: <br /> Ej: root</th>
	<th><input type="text" name="user" value="" size="30" /></th>
</tr>
<tr>
	<th>Contraseña: <br /> Ej: 123456 </th>
	<th><input type="password" name="passwort" value="" size="30" /></th>
</tr>
<tr>
	<th>Prefix de las tablas: <br /> Ej: svn_ </th>
	<th><input type="text" name="prefix" value="svn_" size="30" /> <font style="color:red">*</font></th>

</tr>
<tr>
	<th colspan="3"><input type="button" name="next" onclick="submit();" value="Instalar" ></th>
</tr>
<tr>
	<th colspan=2 style="color:red">*Advertencia cambiar prefijo si vas a tener mas 2 de juegos en la misma base</th>
</tr>

<!-- END BLOCK : form -->
<!-- START BLOCK : form_2 -->
<tr>
  <th colspan="2">
	<br />
    {first}
    <br />
    {second}
    <br />
    {third}
    <br />
    <br />
    </th>
</tr>
<tr>
  <th colspan="2"><input type="button" name="next" onclick="submit();" value="Continuar" ></th>
</tr>
<!-- END BLOCK : form_2 -->

<!-- START BLOCK : admin -->
<tr>
	<th colspan="2">
    	<h1>Establecer cuenta de administración</h1>
        <table width="270" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
            	<td>Usuario:</td>
            	<td><input name="adm_user" size="20" maxlength="20" type="text"></td>
            </tr>
            <tr>
            	<td>Contraseña:</td>
            	<td><input name="adm_pass" size="20" maxlength="20" type="password"></td>
            </tr>
            <tr>
            	<td>Correo electrónico:</td>
            	<td><input name="adm_email" size="20" maxlength="40" type="text"></td>
            </tr>
        </table>
        <br />
    </th>
</tr>
<tr>
	<th colspan="2"><input type="button" name="next" onclick="submit();" value="Crear" ></th>
</tr>
<!-- END BLOCK : admin -->

<!-- START BLOCK : config -->
<tr>
<th>
<p>Los parámetros en esta página son solamente necesarios si sabe qué quiere algo diferente que no sea por defecto. Si no está seguro, simplemente pase a la siguiente página, ya que esos parámetros pueden ser cambiados desde el Panel de Administración (ACP).</p>
	<fieldset>
            <legend>Configuración de email</legend>
            <dl>
                <dt><label for="email_enable">Habilitar envío de emails: 
                        <a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>Si se deshabilita, el Sitio no enviará ningún tipo de email. \n\
                        <em>Note que los parámetros de activación de la cuenta del Admin y del usuario requiren que esta opción esté habilitada. Si la configuración de activación actual es “usuario” o\n\
                         “administrador” en los parámetros de activación entonces la deshabilitación de esta opción no requerirá la activación de cuentas nuevas.</em></span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )' onmouseout="return nd();"> [?]</a></label></dt>
                <dd><label><input name="email_enable" value="1" checked="checked" id="email_enable" class="radio" type="radio"> Enabled</label>&nbsp;&nbsp;<label><input name="email_enable" value="0" class="radio" type="radio"> Disabled</label></dd>
            </dl>
            <dl>
                    <dt><label for="smtp_delivery">Usar servidor SMTP para email:  <a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>Elija “Sí” si quiere o necesita enviar emails mediante un servidor específico en lugar de la función de email local.</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )' onmouseout="return nd();"> [?]</a></label></dt>
                    <dd><label><input name="smtp_delivery" value="1" class="radio" type="radio"> Yes</label>&nbsp;&nbsp;<label><input name="smtp_delivery" value="0" checked="checked" id="smtp_delivery" class="radio" type="radio"> No</label></dd>

            </dl>
        <dl>
                    <dt><label for="smtp_host">Dirección servidor SMTP:</label></dt>
                    <dd><input id="smtp_host" size="25" maxlength="50" name="smtp_host" value="" type="text"></dd>
            </dl>
            <dl>
                    <dt><label for="smtp_auth">Método de autentificación para SMTP:<a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>Solo usado si se configura usuario/contraseña, pregúntele a su ISP si no está seguro de cual método usar.(tsl,ssl...)</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></label></dt>
                    <dd><input id="smtp_auth" size="4" maxlength="255" name="smtp_auth" value="" type="text">
                    </dd>
            </dl>
            <dl>
                    <dt><label for="smtp_user">Usuario SMTP:<a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>Solo introduzca un usuario si su servidor SMTP lo requiere.</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></label><br></dt>
                    <dd><input id="smtp_user" size="25" maxlength="255" name="smtp_user" value="" type="text"></dd>
            </dl>
            <dl>
                    <dt><label for="smtp_pass">Contraseña SMTP:<a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>Solo introduzca una contraseña si su servidor SMTP lo requiere.</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></label></dt>
                    <dd><input id="smtp_pass" size="25" maxlength="255" name="smtp_pass" value="" type="password"></dd>
            </dl>
            <dl>
                    <dt><label for="smtp_port">Puerto SMTP:</label></dt>
                    <dd><input id="smtp_port" size="25" maxlength="255" name="smtp_port" value="" type="text"></dd>
            </dl>
        </fieldset>

                    <fieldset>


            <legend>Configuración de URL</legend>
            <dl>
                    <dt><label for="game_name">Nombre del juego:<a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>El nombre de que quieres para tu juego</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></label></dt>

                    <dd><input id="game_name" size="40" maxlength="255" name="server_name" value="Xnova Svn" type="text"></dd>
            </dl>
            <dl>

                    <dt><label for="foro">Ruta del foro: <a href="#" onmouseover='return overlib("<table width=300 class=><tr><td class=overlib><span>La ruta dónde está ubicada el foro relativa al nombre de dominio, ej. <samp>/foro</samp>.</span></td></tr></table>", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 )'
                                                                                      onmouseout="return nd();"> [?]</a></label></dt>
                    <dd><input id="foro" maxlength="255" name="script_path" value="/foro" type="text"></dd>
            </dl>



	</fieldset>

	<fieldset class="submit-buttons">

		<legend>Continuar</legend>
		
                <input name="adm_user" value="{adm_user}" type="hidden">
                <input name="adm_pass" value="{adm_pass}" type="hidden">
                <input name="adm_email" value="{adm_email}" type="hidden">
                <input class="button1" id="submit" onclick="this.className = 'button1 disabled';" name="submit" value="Proceder al siquiente paso" type="submit">
	</fieldset>
</th>
</tr>
<!-- END BLOCK :  config -->

<!-- START BLOCK : end -->
<tr>
  <th colspan="2">
<br>El Administrador ha sido creado correctamente.<br>
¡Ahora debes borrar la carpeta <i>install</i> asi evitaras problemas graves de seguridad!<br><br>
<font color="red">Antes de continuar cambie los permisos del archivo config.php a "CHMOD 640"</font> <br><br>
</th>
</tr>
<tr>
  <th colspan="2"><input type="button" name="next" onclick="self.location.href='../'" value="Finalizar" ></th>
</tr>
<!-- END BLOCK : end -->
<!-- START BLOCK : update -->
		<tr>
			<th align="center">Servidor SQL <font color="red">(ej: localhost)</font></th>
			<th align="left"><input type="text" name="servidor"/></th>
		</tr>
		<tr>
			<th align="center">Usuario SQL <font color="red">(ej: root)</font></th>
			<th align="left"><input type="text" name="usuario"/></th>
		</tr>
		<tr>
			<th align="center">Clave SQL <font color="red">(ej: abc12345)</font></th>
			<th align="left"><input type="password" name="clave"/></th>
		</tr>
		<tr>
			<th align="center">Nombre de la base SQL <font color="red">(ej: ogame)</font></th>
			<th align="left"><input type="text" name="base"/></th>
		</tr>
		<tr>
			<th align="center">Prefijo de las tablas(debe ir completo) <font color="red">(ej: game_)</font></th>
			<th align="left"><input type="text" name="prefix"/></th>
		</tr>
		<tr>
			<th align="center">Tengo la versi&oacute;n:<font color="red">(ej: 2.3)</font></th>
			<th align="left">
                <select name="modo">
                    <option value="0.8">Xnova Svn 0.8</option>
                    <option value="1.0">Xnova Svn 1.0</option>
                    <option value="1.1">Xnova Svn 1.1</option>
                    <option value="1.2">Xnova Svn 1.2</option>
                    <option value="2.0">Xnova Svn 2.0</option>
                    <option value="2.1">Xnova Svn 2.1</option>
                    <option value="2.2">Xnova Svn 2.2</option>
                    <option value="2.3">Xnova Svn 2.3</option>
                    <!--<option value="XG_2.9.x">XG 2.9.x</option>-->
                </select>
            </th>
		</tr>
		<tr>
			<th align="center" colspan="2"><input type="submit" name="continuar" value="Actualizar a la versi&oacute;n 2.3.2"/></th>
		</tr>
<!-- END BLOCK : update -->

<!-- START BLOCK : licencia -->
<tr>
<th I>
  

        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><em>License</em></legend>
            <p>THE WORK (AS DEFINED BELOW) IS PROVIDED UNDER THE TERMS
            OF THIS CREATIVE COMMONS PUBLIC LICENSE ("CCPL" OR
            "LICENSE"). THE WORK IS PROTECTED BY COPYRIGHT AND/OR OTHER
            APPLICABLE LAW. ANY USE OF THE WORK OTHER THAN AS
            AUTHORIZED UNDER THIS LICENSE OR COPYRIGHT LAW IS
            PROHIBITED.</p>

            <p>BY EXERCISING ANY RIGHTS TO THE WORK PROVIDED HERE, YOU
            ACCEPT AND AGREE TO BE BOUND BY THE TERMS OF THIS LICENSE.
            TO THE EXTENT THIS LICENSE MAY BE CONSIDERED TO BE A
            CONTRACT, THE LICENSOR GRANTS YOU THE RIGHTS CONTAINED HERE
            IN CONSIDERATION OF YOUR ACCEPTANCE OF SUCH TERMS AND
            CONDITIONS.</p>
        </fieldset>
        <fieldset  style="text-align: left">
            <legend style="font-size:large" >1. Definitions</legend>

            <ol type="a">
          <li><strong>"Adaptation"</strong> means a work based upon
          the Work, or upon the Work and other pre-existing works,
          such as a translation, adaptation, derivative work,
          arrangement of music or other alterations of a literary
          or artistic work, or phonogram or performance and
          includes cinematographic adaptations or any other form in
          which the Work may be recast, transformed, or adapted
          including in any form recognizably derived from the
          original, except that a work that constitutes a
          Collection will not be considered an Adaptation for the
          purpose of this License. For the avoidance of doubt,
          where the Work is a musical work, performance or
          phonogram, the synchronization of the Work in
          timed-relation with a moving image ("synching") will be
          considered an Adaptation for the purpose of this
          License.</li>

          <li><strong>"Collection"</strong> means a collection of
          literary or artistic works, such as encyclopedias and
          anthologies, or performances, phonograms or broadcasts,
          or other works or subject matter other than works listed
          in Section 1(g) below, which, by reason of the selection
          and arrangement of their contents, constitute
          intellectual creations, in which the Work is included in
          its entirety in unmodified form along with one or more
          other contributions, each constituting separate and
          independent works in themselves, which together are
          assembled into a collective whole. A work that
          constitutes a Collection will not be considered an
          Adaptation (as defined above) for the purposes of this
          License.</li>

          <li><strong>"Distribute"</strong> means to make available
          to the public the original and copies of the Work or
          Adaptation, as appropriate, through sale or other
          transfer of ownership.</li>

          <li><strong>"License Elements"</strong> means the
          following high-level license attributes as selected by
          Licensor and indicated in the title of this License:
          Attribution, Noncommercial, ShareAlike.</li>

          <li><strong>"Licensor"</strong> means the individual,
          individuals, entity or entities that offer(s) the Work
          under the terms of this License.</li>

          <li><strong>"Original Author"</strong> means, in the case
          of a literary or artistic work, the individual,
          individuals, entity or entities who created the Work or
          if no individual or entity can be identified, the
          publisher; and in addition (i) in the case of a
          performance the actors, singers, musicians, dancers, and
          other persons who act, sing, deliver, declaim, play in,
          interpret or otherwise perform literary or artistic works
          or expressions of folklore; (ii) in the case of a
          phonogram the producer being the person or legal entity
          who first fixes the sounds of a performance or other
          sounds; and, (iii) in the case of broadcasts, the
          organization that transmits the broadcast.</li>

          <li><strong>"Work"</strong> means the literary and/or
          artistic work offered under the terms of this License
          including without limitation any production in the
          literary, scientific and artistic domain, whatever may be
          the mode or form of its expression including digital
          form, such as a book, pamphlet and other writing; a
          lecture, address, sermon or other work of the same
          nature; a dramatic or dramatico-musical work; a
          choreographic work or entertainment in dumb show; a
          musical composition with or without words; a
          cinematographic work to which are assimilated works
          expressed by a process analogous to cinematography; a
          work of drawing, painting, architecture, sculpture,
          engraving or lithography; a photographic work to which
          are assimilated works expressed by a process analogous to
          photography; a work of applied art; an illustration, map,
          plan, sketch or three-dimensional work relative to
          geography, topography, architecture or science; a
          performance; a broadcast; a phonogram; a compilation of
          data to the extent it is protected as a copyrightable
          work; or a work performed by a variety or circus
          performer to the extent it is not otherwise considered a
          literary or artistic work.</li>

          <li><strong>"You"</strong> means an individual or entity
          exercising rights under this License who has not
          previously violated the terms of this License with
          respect to the Work, or who has received express
          permission from the Licensor to exercise rights under
          this License despite a previous violation.</li>

          <li><strong>"Publicly Perform"</strong> means to perform
          public recitations of the Work and to communicate to the
          public those public recitations, by any means or process,
          including by wire or wireless means or public digital
          performances; to make available to the public Works in
          such a way that members of the public may access these
          Works from a place and at a place individually chosen by
          them; to perform the Work to the public by any means or
          process and the communication to the public of the
          performances of the Work, including by public digital
          performance; to broadcast and rebroadcast the Work by any
          means including signs, sounds or images.</li>

          <li><strong>"Reproduce"</strong> means to make copies of
          the Work by any means including without limitation by
          sound or visual recordings and the right of fixation and
          reproducing fixations of the Work, including storage of a
          protected performance or phonogram in digital form or
          other electronic medium.</li>

        </ol>
        </fieldset>
        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><strong>2. Fair Dealing Rights</strong>
        <p> Nothing in this
        License is intended to reduce, limit, or restrict any uses
        free from copyright or rights arising from limitations or
        exceptions that are provided for in connection with the
        copyright protection under copyright law or other
        applicable laws.</p>
        </fieldset>
        <fieldset  style="text-align: left">
        <legend style="font-size:large" ><strong>3. License Grant</strong></legend>
        <p>Subject to the terms
        and conditions of this License, Licensor hereby grants You
        a worldwide, royalty-free, non-exclusive, perpetual (for
        the duration of the applicable copyright) license to
        exercise the rights in the Work as stated below:</p>

        <ol type="a">

          <li>to Reproduce the Work, to incorporate the Work into
          one or more Collections, and to Reproduce the Work as
          incorporated in the Collections;</li>

          <li>to create and Reproduce Adaptations provided that any
          such Adaptation, including any translation in any medium,
          takes reasonable steps to clearly label, demarcate or
          otherwise identify that changes were made to the original
          Work. For example, a translation could be marked "The
          original work was translated from English to Spanish," or
          a modification could indicate "The original work has been
          modified.";</li>

          <li>to Distribute and Publicly Perform the Work including
          as incorporated in Collections; and,</li>

          <li>to Distribute and Publicly Perform Adaptations.</li>
        </ol>

        <p>The above rights may be exercised in all media and
        formats whether now known or hereafter devised. The above
        rights include the right to make such modifications as are
        technically necessary to exercise the rights in other media
        and formats. Subject to Section 8(f), all rights not
        expressly granted by Licensor are hereby reserved,
        including but not limited to the rights described in
        Section 4(e).</p>
        </fieldset>
        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><strong>4. Restrictions</strong></legend>
            <p> The license granted in
        Section 3 above is expressly made subject to and limited by
        the following restrictions:</p>

        <ol type="a">
          <li>You may Distribute or Publicly Perform the Work only
          under the terms of this License. You must include a copy
          of, or the Uniform Resource Identifier (URI) for, this
          License with every copy of the Work You Distribute or
          Publicly Perform. You may not offer or impose any terms
          on the Work that restrict the terms of this License or
          the ability of the recipient of the Work to exercise the
          rights granted to that recipient under the terms of the
          License. You may not sublicense the Work. You must keep
          intact all notices that refer to this License and to the
          disclaimer of warranties with every copy of the Work You
          Distribute or Publicly Perform. When You Distribute or
          Publicly Perform the Work, You may not impose any
          effective technological measures on the Work that
          restrict the ability of a recipient of the Work from You
          to exercise the rights granted to that recipient under
          the terms of the License. This Section 4(a) applies to
          the Work as incorporated in a Collection, but this does
          not require the Collection apart from the Work itself to
          be made subject to the terms of this License. If You
          create a Collection, upon notice from any Licensor You
          must, to the extent practicable, remove from the
          Collection any credit as required by Section 4(d), as
          requested. If You create an Adaptation, upon notice from
          any Licensor You must, to the extent practicable, remove
          from the Adaptation any credit as required by Section
          4(d), as requested.</li>

          <li>You may Distribute or Publicly Perform an Adaptation
          only under: (i) the terms of this License; (ii) a later
          version of this License with the same License Elements as
          this License; (iii) a Creative Commons jurisdiction
          license (either this or a later license version) that
          contains the same License Elements as this License (e.g.,
          Attribution-NonCommercial-ShareAlike 3.0 US) ("Applicable
          License"). You must include a copy of, or the URI, for
          Applicable License with every copy of each Adaptation You
          Distribute or Publicly Perform. You may not offer or
          impose any terms on the Adaptation that restrict the
          terms of the Applicable License or the ability of the
          recipient of the Adaptation to exercise the rights
          granted to that recipient under the terms of the
          Applicable License. You must keep intact all notices that
          refer to the Applicable License and to the disclaimer of
          warranties with every copy of the Work as included in the
          Adaptation You Distribute or Publicly Perform. When You
          Distribute or Publicly Perform the Adaptation, You may
          not impose any effective technological measures on the
          Adaptation that restrict the ability of a recipient of
          the Adaptation from You to exercise the rights granted to
          that recipient under the terms of the Applicable License.
          This Section 4(b) applies to the Adaptation as
          incorporated in a Collection, but this does not require
          the Collection apart from the Adaptation itself to be
          made subject to the terms of the Applicable License.</li>

          <li>You may not exercise any of the rights granted to You
          in Section 3 above in any manner that is primarily
          intended for or directed toward commercial advantage or
          private monetary compensation. The exchange of the Work
          for other copyrighted works by means of digital
          file-sharing or otherwise shall not be considered to be
          intended for or directed toward commercial advantage or
          private monetary compensation, provided there is no
          payment of any monetary compensation in con-nection with
          the exchange of copyrighted works.</li>

          <li>If You Distribute, or Publicly Perform the Work or
          any Adaptations or Collections, You must, unless a
          request has been made pursuant to Section 4(a), keep
          intact all copyright notices for the Work and provide,
          reasonable to the medium or means You are utilizing: (i)
          the name of the Original Author (or pseudonym, if
          applicable) if supplied, and/or if the Original Author
          and/or Licensor designate another party or parties (e.g.,
          a sponsor institute, publishing entity, journal) for
          attribution ("Attribution Parties") in Licensor's
          copyright notice, terms of service or by other reasonable
          means, the name of such party or parties; (ii) the title
          of the Work if supplied; (iii) to the extent reasonably
          practicable, the URI, if any, that Licensor specifies to
          be associated with the Work, unless such URI does not
          refer to the copyright notice or licensing information
          for the Work; and, (iv) consistent with Section 3(b), in
          the case of an Adaptation, a credit identifying the use
          of the Work in the Adaptation (e.g., "French translation
          of the Work by Original Author," or "Screenplay based on
          original Work by Original Author"). The credit required
          by this Section 4(d) may be implemented in any reasonable
          manner; provided, however, that in the case of a
          Adaptation or Collection, at a minimum such credit will
          appear, if a credit for all contributing authors of the
          Adaptation or Collection appears, then as part of these
          credits and in a manner at least as prominent as the
          credits for the other contributing authors. For the
          avoidance of doubt, You may only use the credit required
          by this Section for the purpose of attribution in the
          manner set out above and, by exercising Your rights under
          this License, You may not implicitly or explicitly assert
          or imply any connection with, sponsorship or endorsement
          by the Original Author, Licensor and/or Attribution
          Parties, as appropriate, of You or Your use of the Work,
          without the separate, express prior written permission of
          the Original Author, Licensor and/or Attribution
          Parties.</li>

          <li>
            <p>For the avoidance of doubt:</p>

            <ol type="i">
              <li><strong>Non-waivable Compulsory License
              Schemes</strong>. In those jurisdictions in which the
              right to collect royalties through any statutory or
              compulsory licensing scheme cannot be waived, the
              Licensor reserves the exclusive right to collect such
              royalties for any exercise by You of the rights
              granted under this License;</li>

              <li><strong>Waivable Compulsory License
              Schemes</strong>. In those jurisdictions in which the
              right to collect royalties through any statutory or
              compulsory licensing scheme can be waived, the
              Licensor reserves the exclusive right to collect such
              royalties for any exercise by You of the rights
              granted under this License if Your exercise of such
              rights is for a purpose or use which is otherwise
              than noncommercial as permitted under Section 4(c)
              and otherwise waives the right to collect royalties
              through any statutory or compulsory licensing scheme;
              and,</li>

              <li><strong>Voluntary License Schemes</strong>. The
              Licensor reserves the right to collect royalties,
              whether individually or, in the event that the
              Licensor is a member of a collecting society that
              administers voluntary licensing schemes, via that
              society, from any exercise by You of the rights
              granted under this License that is for a purpose or
              use which is otherwise than noncommercial as
              permitted under Section 4(c).</li>

            </ol>
          </li>

          <li>Except as otherwise agreed in writing by the Licensor
          or as may be otherwise permitted by applicable law, if
          You Reproduce, Distribute or Publicly Perform the Work
          either by itself or as part of any Adaptations or
          Collections, You must not distort, mutilate, modify or
          take other derogatory action in relation to the Work
          which would be prejudicial to the Original Author's honor
          or reputation. Licensor agrees that in those
          jurisdictions (e.g. Japan), in which any exercise of the
          right granted in Section 3(b) of this License (the right
          to make Adaptations) would be deemed to be a distortion,
          mutilation, modification or other derogatory action
          prejudicial to the Original Author's honor and
          reputation, the Licensor will waive or not assert, as
          appropriate, this Section, to the fullest extent
          permitted by the applicable national law, to enable You
          to reasonably exercise Your right under Section 3(b) of
          this License (right to make Adaptations) but not
          otherwise.</li>
        </ol>
        </fieldset>
        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><strong>5. Representations, Warranties and
                    Disclaimer</strong></legend>
        

        <p>UNLESS OTHERWISE MUTUALLY AGREED TO BY THE PARTIES IN
        WRITING AND TO THE FULLEST EXTENT PERMITTED BY APPLICABLE
        LAW, LICENSOR OFFERS THE WORK AS-IS AND MAKES NO
        REPRESENTATIONS OR WARRANTIES OF ANY KIND CONCERNING THE
        WORK, EXPRESS, IMPLIED, STATUTORY OR OTHERWISE, INCLUDING,
        WITHOUT LIMITATION, WARRANTIES OF TITLE, MERCHANTABILITY,
        FITNESS FOR A PARTICULAR PURPOSE, NONINFRINGEMENT, OR THE
        ABSENCE OF LATENT OR OTHER DEFECTS, ACCURACY, OR THE
        PRESENCE OF ABSENCE OF ERRORS, WHETHER OR NOT DISCOVERABLE.
        SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED
        WARRANTIES, SO THIS EXCLUSION MAY NOT APPLY TO YOU.</p>
        </fieldset>
        <fieldset>
            <legend style="font-size:large" ><strong>6. Limitation on Liability</strong></legend>
        <p> EXCEPT TO THE EXTENT REQUIRED BY APPLICABLE LAW, IN NO EVENT WILL
        LICENSOR BE LIABLE TO YOU ON ANY LEGAL THEORY FOR ANY
        SPECIAL, INCIDENTAL, CONSEQUENTIAL, PUNITIVE OR EXEMPLARY
        DAMAGES ARISING OUT OF THIS LICENSE OR THE USE OF THE WORK,
        EVEN IF LICENSOR HAS BEEN ADVISED OF THE POSSIBILITY OF
        SUCH DAMAGES.</p>
        </fieldset>
        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><strong>7. Termination</strong></legend>

        <ol type="a">
          <li>This License and the rights granted hereunder will
          terminate automatically upon any breach by You of the
          terms of this License. Individuals or entities who have
          received Adaptations or Collections from You under this
          License, however, will not have their licenses terminated
          provided such individuals or entities remain in full
          compliance with those licenses. Sections 1, 2, 5, 6, 7,
          and 8 will survive any termination of this License.</li>

          <li>Subject to the above terms and conditions, the
          license granted here is perpetual (for the duration of
          the applicable copyright in the Work). Notwithstanding
          the above, Licensor reserves the right to release the
          Work under different license terms or to stop
          distributing the Work at any time; provided, however that
          any such election will not serve to withdraw this License
          (or any other license that has been, or is required to
          be, granted under the terms of this License), and this
          License will continue in full force and effect unless
          terminated as stated above.</li>
        </ol>
        </fieldset>

        <fieldset  style="text-align: left">
            <legend style="font-size:large" ><strong>8. Miscellaneous</strong></legend>

        <ol type="a">
          <li>Each time You Distribute or Publicly Perform the Work
          or a Collection, the Licensor offers to the recipient a
          license to the Work on the same terms and conditions as
          the license granted to You under this License.</li>

          <li>Each time You Distribute or Publicly Perform an
          Adaptation, Licensor offers to the recipient a license to
          the original Work on the same terms and conditions as the
          license granted to You under this License.</li>

          <li>If any provision of this License is invalid or
          unenforceable under applicable law, it shall not affect
          the validity or enforceability of the remainder of the
          terms of this License, and without further action by the
          parties to this agreement, such provision shall be
          reformed to the minimum extent necessary to make such
          provision valid and enforceable.</li>

          <li>No term or provision of this License shall be deemed
          waived and no breach consented to unless such waiver or
          consent shall be in writing and signed by the party to be
          charged with such waiver or consent.</li>

          <li>This License constitutes the entire agreement between
          the parties with respect to the Work licensed here. There
          are no understandings, agreements or representations with
          respect to the Work not specified here. Licensor shall
          not be bound by any additional provisions that may appear
          in any communication from You. This License may not be
          modified without the mutual written agreement of the
          Licensor and You.</li>

          <li>The rights granted under, and the subject matter
          referenced, in this License were drafted utilizing the
          terminology of the Berne Convention for the Protection of
          Literary and Artistic Works (as amended on September 28,
          1979), the Rome Convention of 1961, the WIPO Copyright
          Treaty of 1996, the WIPO Performances and Phonograms
          Treaty of 1996 and the Universal Copyright Convention (as
          revised on July 24, 1971). These rights and subject
          matter take effect in the relevant jurisdiction in which
          the License terms are sought to be enforced according to
          the corresponding provisions of the implementation of
          those treaty provisions in the applicable national law.
          If the standard suite of rights granted under applicable
          copyright law includes additional rights not granted
          under this License, such additional rights are deemed to
          be included in the License; this License is not intended
          to restrict the license of any rights under applicable
          law.</li>
        </ol>
        </fieldset>
        <p>Creative Commons may be contacted at <a href="http://creativecommons.org/">http://creativecommons.org/</a>.</p>
        
</th>
</tr>
<!-- END BLOCK : licencia -->


</form>
</table>




