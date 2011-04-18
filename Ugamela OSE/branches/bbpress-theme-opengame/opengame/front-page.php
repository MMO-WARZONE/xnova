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

<?php if ($forums): ?>

<table><tr><td rowspan="2" valign="top">

	<!-- hot tags -->
	<table id="hottags" width="180px">
		<tr>
			<td class="c"><?php _e('Hot Tags'); ?></td>
		</tr>
		
		<tr>
			<th class="frontpageheatmap"><?php bb_tag_heat_map(); ?></th>
		</tr>
	</table>

</td><td>

	<table id="discussions" width="650px">
		<?php if ($topics || $super_stickies): ?>
		<tr>
			<td class="c" colspan="4"><?php _e('Latest Discussions'); ?></td>
		</tr>
		
		<tr id="latest">
			<td class="c"><?php _e('Topic'); ?> &#8212; <?php new_topic(); ?></th>
			<td class="c"><?php _e('Posts'); ?></td>
			<td class="c"><?php _e('Last Poster'); ?></td>
			<td class="c"><?php _e('Freshness'); ?></td>
		</tr>
		
		<!-- <tr height="5"><td class="c" colspan="4"></td></tr> -->
		
<?php if ($super_stickies): foreach ($super_stickies as $topic): ?>
		
		<tr<?php topic_class(); ?>>
			<td class="b"><?php bb_topic_labels(); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big></td>
			<td class="b"><?php topic_posts(); ?></td>
			<td class="b"><?php topic_last_poster(); ?></td>
			<td class="b"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></td>
		</tr>
<?php endforeach; endif; // $super_stickies ?>

<?php if ($topics): foreach ($topics as $topic): ?>
	<tr<?php topic_class(); ?>>
		<td class="b"><?php bb_topic_labels(); ?> <a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
		<td class="b"><?php topic_posts(); ?></td>
		<td class="b"><?php topic_last_poster(); ?></td>
		<td class="b"><a href="<?php topic_last_post_link(); ?>"><?php topic_time(); ?></a></td>
	</tr>
<?php endforeach; endif; // $topics ?>
</table><br>
<?php endif; // $topics or $super_stickies ?>

<?php if (bb_forums()): ?>

<table id="forumlist" width="650px">
	<tr>
		<td class="c" colspan="3"><?php _e('Forums'); ?></td>
	</tr>

	<tr>
		<td class="c"><?php _e('Main Theme'); ?></td>
		<td class="c"><?php _e('Topics'); ?></td>
		<td class="c"><?php _e('Posts'); ?></td>
	</tr>

	<!-- <tr height="5"><td class="c" colspan="3"></td></tr> -->

<?php while (bb_forum()): ?>
	<tr<?php bb_forum_class(); ?>>
		<td class="b"><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><small><?php forum_description(); ?></small><?php bb_forum_pad( '</div>' ); ?></td>
		<td class="b"><?php forum_topics(); ?></td>
		<td class="b"><?php forum_posts(); ?></td>
	</tr>
<?php endwhile; ?>
</table>
<?php endif; // bb_forums() ?>

<?php if ( bb_is_user_logged_in() ) : ?>
<div id="viewdiv">
	<h2><?php _e('Views'); ?></h2>
	<ul id="views">
		<?php foreach ( bb_get_views() as $the_view => $title ) : ?>
		<li class="view"><a href="<?php view_link( $the_view ); ?>"><?php view_name( $the_view ); ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; // bb_is_user_logged_in() ?>

</div>

<?php else : // $forums ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a></h3>

<?php post_form(); endif; // $forums ?>

<?php bb_get_footer(); ?>
