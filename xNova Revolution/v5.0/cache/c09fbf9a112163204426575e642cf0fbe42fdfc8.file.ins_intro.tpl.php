<?php /* Smarty version Smarty3-SVN$Rev: 3286 $, created on 2011-04-29 18:09:53
         compiled from "C:/xampp/htdocs/RevolutionFive - copia/styles/theme/gow/templates/install/ins_intro.tpl" */ ?>
<?php /*%%SmartyHeaderCode:177724dbae2d153b0f1-39224739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c09fbf9a112163204426575e642cf0fbe42fdfc8' => 
    array (
      0 => 'C:/xampp/htdocs/RevolutionFive - copia/styles/theme/gow/templates/install/ins_intro.tpl',
      1 => 1299335444,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '177724dbae2d153b0f1-39224739',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_html_options')) include 'C:\xampp\htdocs\RevolutionFive - copia\includes\libs\Smarty\plugins\function.html_options.php';
?><?php $_template = new Smarty_Internal_Template("install/ins_header.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
<tr>
	<td colspan="3">[<a href="?mode=intro&amp;<?php echo $_smarty_tpl->getVariable('lang')->value;?>
"><?php echo $_smarty_tpl->getVariable('menu_intro')->value;?>
</a> &bull; <a href="?mode=req&amp;<?php echo $_smarty_tpl->getVariable('lang')->value;?>
"><?php echo $_smarty_tpl->getVariable('menu_install')->value;?>
</a> &bull; <a href="?mode=license&amp;<?php echo $_smarty_tpl->getVariable('lang')->value;?>
"><?php echo $_smarty_tpl->getVariable('menu_license')->value;?>
</a>]</td>
</tr>
<tr>
	<td colspan="2"><div id="lang" align="right"><?php echo $_smarty_tpl->getVariable('intro_lang')->value;?>
:&nbsp;<select id="lang" name="lang" onchange="document.location = '?lang='+$(this).val();"><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->getVariable('Selector')->value,'selected'=>$_smarty_tpl->getVariable('lang')->value),$_smarty_tpl);?>
</select></div><div id="main" align="left">
		<h1><?php echo $_smarty_tpl->getVariable('intro_install')->value;?>
</h1>
		<h2><?php echo $_smarty_tpl->getVariable('intro_welcome')->value;?>
</h2><br>
		<?php echo $_smarty_tpl->getVariable('intro_text')->value;?>

		</div><br><a href="?mode=req&amp;lang=<?php echo $_smarty_tpl->getVariable('lang')->value;?>
"><button style="cursor: pointer;" value="<?php echo $_smarty_tpl->getVariable('intro_instal')->value;?>
"><?php echo $_smarty_tpl->getVariable('intro_instal')->value;?>
</button></a></td>
</tr>
<?php $_template = new Smarty_Internal_Template("install/ins_footer.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>