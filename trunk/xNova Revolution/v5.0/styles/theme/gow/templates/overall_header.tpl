<!DOCTYPE html>

<html lang="{$lang}">
<head>
<title>{$title}</title>
{if $goto}
<meta http-equiv="refresh" content="{$gotoinsec};URL={$goto}">
{/if}
<meta http-equiv="content-language" content="{$lang}">
<meta name="robots" content="index, follow">
<link rel="stylesheet" type="text/css" href="./styles/css/ingame.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<link rel="icon" href="favicon.ico">
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<div id="fadeBox" class="fadeBox" style="display:none;"><div><span id="fadeBoxStyle" class="success"></span><p id="fadeBoxContent"></p><br class="clearfloat" /></div></div>
<div id="barra_top"><b>{if !empty($forum_url)}<a href="{$forum_url}" target="forum">{$lm_forums}</a>{/if} &nbsp; &nbsp;  {if !CheckModule(22)}<a href="?page=records">{$lm_records}</a>{/if} &nbsp; &nbsp;  {if !CheckModule(12)}<a href="?page=topkb">{$lm_topkb}</a>{/if} &nbsp; &nbsp;  {if !CheckModule(26)}<a href="?page=search">{$lm_search}</a>{/if} &nbsp; &nbsp;  <a href="?page=creditos">Creditos</a> &nbsp; &nbsp; {if !CheckModule(7)}<a href="?page=chat">{$lm_chat}</a>{/if} &nbsp; &nbsp; <a href="?page=logout"><font color="red">{$lm_logout}</font></a></b></div><br/>