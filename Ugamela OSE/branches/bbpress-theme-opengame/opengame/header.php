<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package OpenGame
 * @version 0.01
 * @copyright (c) 2008 Ugamela
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"<?php bb_language_attributes('1.1'); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php bb_title() ?></title>
<?php bb_feed_head(); ?> 
<link rel="stylesheet" href="http://80.237.203.201/download/use/epicblue/formate.css" type="text/css">
<link rel="stylesheet" href="<?php bb_stylesheet_uri(); ?>" type="text/css">
<!-- just for testing -->

<?php if ('rtl' == bb_get_option( 'text_direction' )): ?>
	<link rel="stylesheet" href="<?php bb_stylesheet_uri( 'rtl' ); ?>" type="text/css">
<?php endif; ?>

<?php bb_head(); ?>

</head>

<body id="<?php bb_location(); ?>">

<div id="header">
	<?php login_form(); ?>
	<?php if ( is_bb_profile() ) profile_menu(); ?>
</div>

<a id="title" href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a><br>

<?php if (bb_get_option('description')): ?>
	<span id="description"><?php bb_option('description'); ?></span><br>
<?php endif; ?>

<br>
<center>
