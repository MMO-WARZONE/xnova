<?php
/**
 * @author Perberos perberos@gmail.com
 * 
 * @package OpenGame
 * @version 0.01
 * @copyright (c) 2008 Ugamela
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

bb_get_header(); ?>

<table id="useravatar" width="840px">
	<tr>
		<td class="c" colspan="2"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Profile') ?></th>
	</tr>

	<tr>
		<th class="userlogin" width="100px" align="center" valign="center"><?php echo bb_get_avatar($user->ID); ?><br><?php echo get_user_name( $user->ID ); ?></td>

		<td class="b" align="left">
<?php if ($updated): ?>

		<td class="notice">
			<p><?php _e('Profile updated'); ?>. <a href="<?php profile_tab_link( $user_id, 'edit' ); ?>"><?php _e('Edit again &raquo;'); ?></a></p>
		</td>

<?php elseif ($user_id == bb_get_current_user_info('id')): ?>
	<p><?php _e('This is how your profile appears to a logged in member.'); ?>
	<?php if (bb_current_user_can( 'edit_user', $user->ID )) : ?>
		<?php printf(__('You may <a href="%1$s">edit this information</a>.'), attribute_escape( get_profile_tab_link( $user_id, 'edit' ) ) ); ?>
	<?php endif; ?>
</p>

<?php if (bb_current_user_can( 'edit_favorites_of', $user->ID )) : ?>
<p><?php printf(__('You can also <a href="%1$s">manage your favorites</a> and subscribe to your favorites&#8217; <a href="%2$s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>.'), attribute_escape( get_favorites_link() ), attribute_escape( get_favorites_rss_link() )); ?></p>
<?php endif; ?>
<?php endif; ?>

<?php bb_profile_data(); ?>
		</td>
	</tr>
</table>



<table id="user-threads" class="useractivity" width="840px">
	<tr>
		<td class="c" colspan="2"><?php _e('User Activity') ?></td>
	</tr>
	<tr>
		<td class="c"><?php _e('Recent Replies'); ?></td>
		<td class="c"><?php _e('Topics Started') ?></td>
	</tr>
	
	<tr>
		<td class="b" align="left">

<?php if ( $posts ) : ?>
	<ol>
		<?php foreach ($posts as $bb_post): $topic = get_topic($bb_post->topic_id) ?>
		<li<?php alt_class('replies'); ?>>
			<a href="<?php topic_link(); ?>"><?php topic_title(); ?></a>
			<br>
			<?php if ($user->ID == bb_get_current_user_info('id')) printf(__('You last replied: %s ago.'), bb_get_post_time()); else printf(__('User last replied: %s ago.'), bb_get_post_time()); ?>
			
			<span class="freshness"><?php
			
			if ( bb_get_post_time( 'timestamp' ) < get_topic_time( 'timestamp' ) )
				printf(__('Most recent reply: %s ago'), get_topic_time());
			else
				_e('No replies since.');
			
			?></span>
		</li>
		<?php endforeach; ?>
	</ol>

<?php else: if ($page): ?>
	<p><?php _e('No more replies.') ?></p>
<?php else : ?>
	<p><?php _e('No replies yet.') ?></p>
<?php endif; endif; ?>
	</span>
		</td>


		<td class="b" align="left">
<?php if ( $topics ) : ?>
	<ol>
	<?php foreach ($topics as $topic) : ?>
		<li<?php alt_class('topics'); ?>>
		<a href="<?php topic_link(); ?>"><?php topic_title(); ?></a>
		<?php printf(__('Started: %s ago'), get_topic_start_time()); ?>
		<br>
		<span class="freshness"><?php
		if ( get_topic_start_time( 'timestamp' ) < get_topic_time( 'timestamp' ) )
			printf(__('Most recent reply: %s ago.'), get_topic_time());
		else
			_e('No replies.');
		?></span>
		</li>
	<?php endforeach; ?>
	</ol>
<?php else : if ( $page ) : ?>
	<p><?php _e('No more topics posted.') ?></p>
<?php else : ?>
	<p><?php _e('No topics posted yet.') ?></p>
<?php endif; endif;?>
		</td>
	</tr>

</table>

<br style="clear: both;" />
<small><?php profile_pages(); ?></small>

<?php bb_get_footer(); ?>
