<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die('Please do not load this page directly.');

global $post;

if (get_comments_number() != 0) :
	?>

	<!-- - - - - - - - - - - - Post Comments - - - - - - - - - - - - - - -->

	<div id="comments">

		<h6><?php echo get_comments_number() . " " . __('Comments', TMM_THEME_FOLDER_NAME); ?></h6> 

		<?php paginate_comments_links() ?>

		<ol class="comments-list"> 
			<?php wp_list_comments('avatar_size=60&callback=tmk_comment'); ?>
		</ol>

		<?php paginate_comments_links() ?>

	</div><!--/ #comments-->

	<!-- - - - - - - - - - - end Post Comments - - - - - - - - - - - - - -->

	<?php
endif;

if (comments_open()) :
	?>

	<!-- - - - - - - - - - - Add Comment - - - - - - - - - - - - - -->

	<section id="respond">

		<div class="comment-form">

			<form id="commentform" class="comments-form" action="<?php echo home_url(); ?>/wp-comments-post.php" method="post">

				<?php
				$comment_notes_after = (int)get_option(TMM_THEME_PREFIX . "comment_notes_after");
				if ($comment_notes_after) {
					comment_form();
				} else {
					comment_form(array('comment_notes_after' => ''));
				}
				?>

				<?php comment_id_fields(); ?>
				<?php do_action('comment_form', $post->ID); ?>

			</form><!--/ .comment-form-->			

		</div><!--/ .comment-form-->

	</section><!--/ .add-comment-->

	<!-- - - - - - - - - - end Add Comment - - - - - - - - - - - - -->

<?php endif; ?>
<script type="text/javascript" src="<?php echo home_url() ?>/wp-includes/js/comment-reply.js"></script>   
<input type="hidden" name="current_post_id" value="<?php echo $post->ID ?>" />
<input type="hidden" name="current_post_url" value="<?php echo get_permalink($post->ID) ?>" />
<input type="hidden" name="is_user_logged_in" value="<?php echo (is_user_logged_in() ? 1 : 0) ?>" />


<script type="text/javascript">
<?php if (isset($_GET['new_comment'])): ?>
		jQuery(document).ready(function() {
			jQuery('html,body').animate({scrollTop: jQuery('#comment-<?php echo $_GET['new_comment']; ?>').offset().top - 50}, 'slow');
			jQuery('#comment-<?php echo $_GET['new_comment']; ?>').addClass("new_comment");
		});
<?php endif; ?>

</script>


<div style="display: none;" id="addcomments_template">

	<div class="clear"></div>

    <div class="js-add-comment add-template-comment" id-reply="__INDEX__">

        <h6><?php _e('Leave a Reply', TMM_THEME_FOLDER_NAME); ?></h6>

        <p class="textarea-block">
            <textarea name="comment" id="comment" cols="50" rows="10" class="textarea"></textarea>
        </p><!--/ .row-textfield-->

        <p class="input-block">
            <button type="button" class="button default reset"><?php _e('Cancel', TMM_THEME_FOLDER_NAME); ?></button>
            <button type="submit" class="button default reply"><?php _e('Send', TMM_THEME_FOLDER_NAME); ?></button>
        </p><!--/ .row-->

        <div class="clear"></div>

    </div><!--/ .add-comment-->

</div>

<!-- - - - - - - - - - Comments Item  - - - - - - - - - - - - -->

<?php

function tmk_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>

	<li class="comment" id="comment-<?php echo comment_ID() ?>" comment-id="<?php echo comment_ID() ?>">

		<article>

			<div class="bordered alignleft">
				<figure class="add-border">
					<?php echo get_avatar($comment, $size = '60', TMM_THEME_URI . '/images/gravatar.png'); ?>
				</figure>
			</div><!--/ .bordered-->

			<div class="comment-body">

				<div class="comment-meta">

					<div class="date"><b><?php _e('Date', TMM_THEME_FOLDER_NAME); ?>:</b>&nbsp;<?php comment_date('F j, Y'); ?></div>
					<div class="author"><b><?php _e('Author', TMM_THEME_FOLDER_NAME); ?>:</b>&nbsp;<?php echo get_comment_author_link(); ?></div>

				</div><!--/ .comment-meta -->

				<p>
					<?php comment_text_rss(); ?>
				</p> 

				<?php echo get_comment_reply_link(array_merge(array('reply_text' => '<span class="comment-reply button default">' . __('Reply', TMM_THEME_FOLDER_NAME) . '</span>'), array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

				<div class="clear"></div>

			</div><!--/ .comment-body -->

			<div class="clear"></div>

		</article><!--/ .comment-body-->

	</li>

<?php } ?>

<!-- - - - - - - - - - end Comments Item  - - - - - - - - - - - - -->