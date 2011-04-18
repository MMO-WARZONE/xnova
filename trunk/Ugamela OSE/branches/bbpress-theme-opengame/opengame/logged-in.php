<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package OpenGame
 * @version 0.01
 * @copyright (c) 2008 Ugamela
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

?><span id="login">
	<?php printf(__('Welcome, %1$s!'), bb_get_profile_link(bb_get_current_user_info( 'name' )));?>
	<?php bb_admin_link( 'before= | ' );?>
	| <?php bb_logout_link(); ?>
</span>
