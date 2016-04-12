<?php
/**

 * @file
 * Zen theme's implementation for comments.
 *
 * Available variables:
 * - $author: Comment author. Can be link or plain text.
 * - $content: An array of comment items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $created: Formatted date and time for when the comment was created.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->created variable.
 * - $changed: Formatted date and time for when the comment was last changed.
 *   Preprocess functions can reformat it by calling format_date() with the
 *   desired parameters on the $comment->changed variable.
 * - $new: New comment marker.
 * - $permalink: Comment permalink.
 * - $submitted: Submission information created from $author and $created during
 *   template_preprocess_comment().
 * - $picture: Authors picture.
 * - $signature: Authors signature.
 * - $status: Comment status. Possible values are:
 *   comment-unpublished, comment-published or comment-preview.
 * - $title: Linked title.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - comment: The current template type, i.e., "theming hook".
 *   - comment-by-anonymous: Comment by an unregistered user.
 *   - comment-by-node-author: Comment by the author of the parent node.
 *   - comment-preview: When previewing a new or edited comment.
 *   - first: The first comment in the list of displayed comments.
 *   - last: The last comment in the list of displayed comments.
 *   - odd: An odd-numbered comment in the list of displayed comments.
 *   - even: An even-numbered comment in the list of displayed comments.
 *   The following applies only to viewers who are registered users:
 *   - comment-unpublished: An unpublished comment visible only to administrators.
 *   - comment-by-viewer: Comment by the user currently viewing the page.
 *   - comment-new: New comment since the last visit.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * These two variables are provided for context:
 * - $comment: Full comment object.
 * - $node: Node object the comments are attached to.
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess()
 * @see template_preprocess_comment()
 * @see zen_preprocess_comment()
 * @see template_process()
 * @see theme_comment()
 */
 global $base_url;
?>
<div class="clearfix comment_wrap m_bottom_25">
	<!--comment author photo-->
    <div class="c-picture">
        <?php if(!empty($comment->picture)):?>
            <?php print $picture;?>
        <?php else:?>
            <img width="100px" height="100px" src="<?php print $base_url.'/'.drupal_get_path('theme','flatastic').'/images/user.jpg';?>" alt="" />
        <?php endif;?>
    </div>
	<div class="comment_content_wrap">
		<header class="m_bottom_5">
			<b><?php print str_replace('xml:lang=""', '', $author); ?></b> - <?php print format_date($comment->created,'custom','F j, Y, g:i a');?>
            <div class="c-edit">
                <?php print render($content['links']);?>
            </div>

		</header>
		 <?php if(isset($comment->comment_body['und'])):?>
			<div class="comment relative bg_light_color_3 r_corners shadow"><?php print $comment->comment_body['und'][0]['value'];?></div>
		<?php endif;?>
	</div>
</div>


