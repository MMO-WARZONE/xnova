<?php

/**
 * install.mo
 *
 * @version 0.5
 * @copyright 2008
 */

$lang['ins_appname']      = "Installation du CMS <a href=\"http://xnova.fr\" target=\"_blank\">XNova</a>";
$lang['ins_tx_state']     = "Etape";
$lang['ins_tx_sys']       = "Gestion syst&egrave;me";
$lang['ins_btn_next']     = "Suivant";
$lang['ins_btn_inst']     = "Installer";
$lang['ins_btn_creat']    = "Cr&eacute;er";
$lang['ins_btn_login']    = "Connexion";
$lang['ins_btn_prev']     = "Pr&eacute;c&eacute;dant";

$lang['ins_mnu_intro']    = "Introduction";
$lang['ins_mnu_inst']     = "Installer";
$lang['ins_mnu_goto']     = "Transfert";
$lang['ins_mnu_upgr']     = "Mise &agrave; Jour";
$lang['ins_mnu_quit']     = "Quitter";

$lang['ins_error']        = "Erreur";
$lang['ins_error1']       = "La connexion &agrave; la base de donn&eacute;e a &eacute;chou&eacute;";
$lang['ins_error2']       = "Le fichier config.php ne pas &ecirc;tre remplacer";

$lang['ins_tx_welco']     = "<p align=\"center\"><strong>Bienvenue dans le setup du CMS XNova.</strong></p>
<p align=\"center\"><strong>Dans cet assistant, vous pourrez configurer tr&egrave;s simplement votre jeu et cr&eacute;er le premier compte administrateur avec pouvoirs.</strong></p>
<p align=\"center\"><strong>XNova est un produit <a href=\"http://fr.wikipedia.org/wiki/Open_Source\" target=\"_blank\">OPEN SOURCE</a> sous <a href=\"http://creativecommons.org/licenses/by-nc/2.0/fr/\" target=\"_blank\">licence Creative Common.</a></strong></p>
<p align=\"center\"><strong>Ce qui implique que toute suppression de lien vers les cr&eacute;dits et suppression des copyright constitue un d&eacute;lit et une violation de la charte.</strong></p>
<p align=\"center\"><strong>N&eacute;anmoins ce d&eacute;tail juridique, nous esp&eacute;rons que votre s&eacute;jour sur le r&eacute;seau XNova et votre installation de d&eacute;roule le mieux possible.</strong></p>";
$lang['ins_tx_intr1']     = "Le projet XNova vous permettra d'installer un clone d'ogame quasi parfait";
$lang['ins_tx_intr2']     = "Le projet XNova est libre, gratuit et OpenSource. Merci de ne pas en faire d'utilisation commerciale";
$lang['ins_tx_intr3']     = "Par respect pour l'equipe de d&eacute;veloppement de ce projet, vous &ecirc;tes pri&eacute;s de ne pas supprimer les copyright des fichiers source.";
$lang['ins_tx_inst1']     = "Le fichier config.php doit &ecirc;tre en CHMOD 777";
$lang['ins_tx_inst2']     = "Vous devez poss&eacute;der une base de donn&eacute;e MySQL";
$lang['ins_tx_inst3']     = "Vous devez remplir le formulaire suivant correctement pour continuer l'installation:";
$lang['ins_tx_acc1']      = "Vous &ecirc;tes sur le point de cr&eacute;er un compte administrateur";
$lang['ins_tx_acc2']      = "Remplissez le formulaire suivant avec les informations du compte:";
$lang['ins_tx_goto1']     = "En choisissant cette m&eacute;tode d'installation, vous allez transformer une base de donn&eacute;e UGamela en base de donn&eacute;e XNova.";
$lang['ins_tx_goto2']     = "Cette option fonctionne, mais il reste pr&eacute;f&eacute;rable de faire une installation compl&egrave;te d'XNova.";
$lang['ins_tx_goto3']     = "Vous prenez un risque en transformant votre base de donn&eacute;e, faites une sauvegarde avant!";
$lang['ins_tx_goto4']     = "Vous devez d&eacute;j&agrave; avoir install&eacute; UGamela";
$lang['ins_tx_goto5']     = "Remplissez le formulaire suivant avec les informations exactes de la base de donn&eacute;e o&ugrave; a &eacute;t&eacute; install&eacute; UGamela. Si vous vous trompez, le transfert &eacute;choura:";
$lang['ins_tx_done1']     = "La base de donn&eacute;e a bien &eacute;t&eacute; install&eacute;e!";
$lang['ins_tx_done2']     = "Le compte administrateur a correctement &eacute;t&eacute; cr&eacute;&eacute;!";
$lang['ins_tx_done3']     = "Il est conseill&eacute; de supprimer le dossier <i>install</i> si vous n'avez plus besoin de l'installateur!";
$lang['ins_tx_done4']     = "Le transf&egrave;re a &eacute;t&eacute; correctement effectu&eacute;!";

$lang['ins_form_server']  = "Serveur SQL";
$lang['ins_form_db']      = "Base de donn&eacute;e";
$lang['ins_form_prefix']  = "Pr&eacute;fix des tables";
$lang['ins_form_login']   = "Identifiant";
$lang['ins_form_pass']    = "Mot-de-passe";
$lang['ins_form_install'] = "Installer";

$lang['ins_acc_user']     = "Pseudo";
$lang['ins_acc_pass']     = "Mot-de-passe";
$lang['ins_acc_email']    = "Adresse e-Mail";
$lang['ins_acc_planet']   = "Plan&egrave;te m&egrave;re";
$lang['ins_acc_sex']      = "Sexe";
$lang['ins_acc_sex0']     = "-ind&eacute;fini-";
$lang['ins_acc_sex1']     = "Homme";
$lang['ins_acc_sex2']     = "Femme";

//Bono entre en sc&egrave;ne avec sa r&eacute;volution du setup !
$lang['txt_1'] = "  <p>Bonjour et bienvenue dans le setup d'installation du CMS XNova. Cet assistant vous permettra d'installer votre serveur tr&egrave;s simplement.<br>
Tout ce que vous aurez &agrave; faire, c'est lire et r&eacute;pondre aux questions qui vous seront pos&eacute;es.<br>
En cas de probl&egrave;me, vous pouvez demander de l'aide sur le forum.<br>";
$lang['txt_2'] = "Lors de cette installation, le fichier <i>config.php</i> <u>doit &ecirc;tre </u>avec l'attribut \"CHMOD 777\"";
$lang['txt_3'] = "Merci de saisir l'adresse de votre serveur et base de donn&eacute;es <u>MySQL</u>.<BR>
Cette adresse peut &ecirc;tre du type suivant : <em>base.domaine.ext</em> ou encore sous la forme d'une adresse IP (<em>192.168.0.1</em> ou <em>127.0.0.1</em>)<BR>
Le plus souvant, l'adresse par d&eacute;faut est celle qui vous correspond. Vous n'aurez alors pas besoin de changer ce r&eacute;glage.";
$lang['txt_4'] = "Indiquez dans ce champ le nom de la base de donn&eacute;es qui h&eacute;bergera XNova. </p>
<p align=\"left\">Cette base contiendra toutes les donn&eacute;es requises au fonctionnement du jeu. Si vous avez un forum ou une application quelquonque utilisant MySQL, il est fortement d&eacute;conseill&eacute; d'y installer XNova.";
$lang['txt_5'] = "<p align=\"left\">Dans cette partie vous est demand&eacute; l'identifiant de connexion &agrave; MySQL.</p>
    <p align=\"left\">Un utilisateur MySQL correspond &agrave; un groupe ou &agrave; une personne avec des privil&egrave;ges d'utilisation pr&eacute;cis, d&eacute;termin&eacute;s par vous m&ecirc;me (si local ou d&eacute;di&eacute;) ou par votre h&eacute;bergeur.</p>
    <p align=\"left\">Dans le cas d'h&eacute;bergeurs tels <em>free</em>, le CMS ne peut pas y &ecirc;tre install&eacute;. Les utilisateurs MySQL n'ont pas les privil&egrave;ges d'utilisations de la fonction<em> LOCK TABLE</em>.</p>";
$lang['txt_6'] = "<p align=\"left\">Indiquez dans cette &eacute;tape le pr&eacute;fix des tables qui seront cr&eacute;es et peupl&eacute;es par ce setup.</p>
	            <p align=\"left\">Cela sert au bon fonctionnement du jeu, au classement et &agrave; la s&eacute;paration d'univers multiples (<em>bien qu'il ne soit pas conseill&eacute; d'installer plusieurs jeux sur la m&ecirc;me base.</em>)</p>";

$lang['create_aks'] = "Cr&eacute;ation de la table \"aks\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_annonce'] = "Cr&eacute;ation de la table \"annonce\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";		
$lang['create_alliance'] = "Cr&eacute;ation de la table \"alliance\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_banned'] = "Cr&eacute;ation de la table \"banned\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_buddy'] = "Cr&eacute;ation de la table \"buddy\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_chat'] = "Cr&eacute;ation de la table \"chat\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_config'] = "Cr&eacute;ation de la table \"config\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['populate_config'] = "Population de la table \"config\"........<b><font color=\"lime\">Peupl&eacute;e !</font></b>";
$lang['create_declared'] = "Cr&eacute;ation de la table \"declared\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_errors'] = "Cr&eacute;ation de la table \"errors\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_fleets'] = "Cr&eacute;ation de la table \"fleets\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_galaxy'] = "Cr&eacute;ation de la table \"galaxy\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_iraks'] = "Cr&eacute;ation de la table \"iraks\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_lunas'] = "Cr&eacute;ation de la table \"lunas\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_messages'] = "Cr&eacute;ation de la table \"messages\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_notes'] = "Cr&eacute;ation de la table \"notes\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
 $lang['create_planets'] = "Cr&eacute;ation de la table \"planets\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_rw'] = "Cr&eacute;ation de la table \"rw\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_statpoints'] = "Cr&eacute;ation de la table \"statpoints\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_users'] = "Cr&eacute;ation de la table \"users\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
$lang['create_multi'] = "Cr&eacute;ation de la table \"multi\"........<b><font color=\"lime\">Termin&eacute; !</font></b>";
?>