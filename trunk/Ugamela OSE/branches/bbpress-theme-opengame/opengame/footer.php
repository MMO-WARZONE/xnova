<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package OpenGame
 * @version 0.01
 * @copyright (c) 2008 Ugamela
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

?><div id="footer">
	<p><?php printf(__('%1$s is proudly powered by <a href="%2$s">bbPress</a>.'), bb_option('name'), "http://bbpress.org") ?>
	OpenGame theme by <a href="http://ugamela.com/" target="_new">Ugamela</a><br>
	<!-- If you remove/edit the copyright, a cat will eat your finger. -->
	Page generated in <?php bb_timer_stop(1); ?> - <?php echo $bbdb->num_queries; ?> queries</p>
</div>
<?php do_action('bb_foot', ''); ?>
</body>
</html>
