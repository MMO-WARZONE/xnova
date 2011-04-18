<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package OpenGame
 * @version 0.01
 * @copyright (c) 2008 Ugamela
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

?><form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php">
<input name="re" type="hidden" value="<?php echo $re; ?>">
<table>
	<tr>
		<td class="c" colspan="2"><?php printf(__('<a href="%1$s">Register</a> or log in'), bb_get_option('uri').'register.php') ?></td>
	</tr>
	
	<tr>
		<th><?php _e('Username:'); ?></th><th><input name="user_login" type="text" id="user_login" size="13" maxlength="40" value="<?php if (!is_bool($user_login)) echo $user_login; ?>" tabindex="1"></th>
	</tr>

	<tr>
		<th><?php _e('Password:'); ?></th><th><input name="password" type="password" id="password" size="13" maxlength="40" tabindex="2"></th>
	</tr>

	<tr>
		<th colspan="2">
		<label class="hand">
		<input name="remember" type="checkbox" id="remember" value="1" tabindex="3"<?php echo $remember_checked; ?> /> <?php _e('Remember me'); ?>
		</label>
		</th>
	</tr>
	
	<tr>
		<td class="c" colspan="2" align="center">
		<input type="submit" name="Submit" id="submit" value="<?php echo attribute_escape( __('Log in &raquo;') ); ?>" tabindex="4" width="">
		</td>
	</tr>

</table>
<?php wp_referer_field(); ?>

</form>
