<?php
/**
 * @file
 * Zen theme's implementation to provide an HTML container for comments.
 *
 * Available variables:
 * - $content: The array of content-related elements for the node. Use
 *   render($content) to print them all, or print a subset such as
 *   render($content['comment_form']).
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default value has the following:
 *   - comment-wrapper: The current template type, i.e., "theming hook".
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * The following variables are provided for contextual information.
 * - $node: Node object the comments are attached to.
 * The constants below the variables show the possible values and should be
 * used for comparison.
 * - $display_mode
 *   - COMMENT_MODE_FLAT
 *   - COMMENT_MODE_THREADED
 *
 * Other variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 *
 * @see template_preprocess_comment_wrapper()
 * @see theme_comment_wrapper()
 */

// Render the comments and form first to see if we need headings.
$comments = render($content['comments']);
$comment_form = render($content['comment_form']);

?>
<?php if(!empty($comments)):?>
<div class="col-lg-8 col-md-8 col-sm-8">
    <h5 class="fw_medium m_bottom_15"><?php print t('Last Reviews');?></h5>
    <?php print $comments; ?>
</div>
<div class="col-lg-4 col-md-4 col-sm-4">
    <?php if ($comment_form): ?>
        <?php print $comment_form; ?>
    <?php endif; ?>

</div>
<?php else:?>
    <?php print $comments; ?>
    <div class="form-wrapper p-20">
        <?php if ($comment_form): ?>
            <?php print $comment_form; ?>
        <?php endif; ?>
    </div>
<?php endif;?>
