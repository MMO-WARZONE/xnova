<?php /* Smarty version Smarty3-SVN$Rev: 3286 $, created on 2011-04-29 18:09:53
         compiled from "C:/xampp/htdocs/RevolutionFive - copia/styles/theme/gow/templates/install/ins_header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:100374dbae2d165fa69-51968229%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0a3975d52fb28c8165c142c71b4eb07bce1724f' => 
    array (
      0 => 'C:/xampp/htdocs/RevolutionFive - copia/styles/theme/gow/templates/install/ins_header.tpl',
      1 => 1303148590,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '100374dbae2d165fa69-51968229',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html lang="es">
<head>
<link rel="stylesheet" type="text/css" href="./styles/theme/gow/formate.css">
<link rel="stylesheet" type="text/css" href="./styles/css/admin.css">
<style type="text/css">
body{
	padding-top: 20px;
    height: auto;
}
</style>
<link rel="icon" href="./favicon.ico">
<title><?php echo $_smarty_tpl->getVariable('title')->value;?>
</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta http-equiv="content-script-type" content="text/javascript">
<meta http-equiv="content-style-type" content="text/css">
<meta http-equiv="X-UA-Compatible" content="IE=100">
<?php if ($_smarty_tpl->getVariable('goto')->value){?>
<meta http-equiv="refresh" content="<?php echo $_smarty_tpl->getVariable('gotoinsec')->value;?>
;URL=<?php echo $_smarty_tpl->getVariable('goto')->value;?>
">
<?php }?>
<script type="text/javascript" src="./scripts/base.js"></script>
<script type="text/javascript" src="./scripts/install.js"></script>
<?php  $_smarty_tpl->tpl_vars['scriptname'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('scripts')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['scriptname']->key => $_smarty_tpl->tpl_vars['scriptname']->value){
?>
<script type="text/javascript" src="./scripts/<?php echo $_smarty_tpl->tpl_vars['scriptname']->value;?>
"></script>
<?php }} ?>
</head>
<body>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<table width="700">
<tr>
	<th colspan="3"><?php echo $_smarty_tpl->getVariable('menu_install')->value;?>
</th>
</tr>