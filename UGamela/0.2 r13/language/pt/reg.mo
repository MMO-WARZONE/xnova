<?php


if(!defined('INSIDE')){ die("attemp hacking");}

// message.php
$lang['registry'] = 'Registo';
$lang['Register'] = {$lang['TITLE_GAME']};
$lang['Indefinide'] = 'Indefinido';
$lang['Male'] = 'Homem';
$lang['Female'] = 'Mulher';
$lang['Multiverse'] = 'Multi-Universo';
$lang['E-Mail'] = 'Endereço de E-Mail (por ex. eu@mail.com)';
$lang['MainPlanet'] = 'Nome do Planeta Principal (não utilize símbolos especiais)';
$lang['GameName'] = 'Nick no Jogo';
$lang['Sex'] = 'Sexo';
$lang['accept'] = 'Com a minha inscrição, afirmo que li e vi as <a href="help.php?conditions">Regras</a> do Jogo.';
$lang['signup'] = 'Registar-se!!!';

//on submit
$lang['thanksforregistry'] = "Obrigado pelo teu registo em {$lang['TITLE_GAME']}<br />Dentro de momentos, receberás no teu E-Mail a tua password de acesso.";

//errores
$lang['error_mail'] = 'Não é um E-Mail válido.<br />';
$lang['error_hplanet'] = 'Falta o Nome do Planeta Principal.<br />';
$lang['error_hplanetnum'] = 'O Nome do Planeta tem de ser alfanumérico.<br />';
$lang['error_character'] = 'Falta o Nick para o Jogo.<br />';
$lang['error_v'] = 'Utilizar o formulário do próprio jogo.<br />';
$lang['error_agb'] = 'Tem de aceitar as REGRAS do jogo.<br />';
$lang['error_userexist'] = 'Esse Nick já se encontra atribuido.<br />';
$lang['error_emailexist'] = 'Esse E-Mail já se encontra registado.<br />';
$lang['error_sex'] = 'Escolha o seu sexo.<br />';
$lang['reg_welldone'] = 'Registo Completo';

// Created by Perberos. All rights reversed (C) 2006 
?>
