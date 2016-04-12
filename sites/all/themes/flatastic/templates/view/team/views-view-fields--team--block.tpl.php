<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */
?>
    <div class="col-lg-3 col-md-3 col-sm-3 m_xs_bottom_30">
        <figure class="info_block_type_2 t_align_c">
            <div class="team-photo m-bottom-15">
                <?php if(isset($fields['field_single_image'])): print render($fields['field_single_image']->content); endif;?>
            </div>
            <?php if(isset($fields['title'])): print $fields['title']->content; endif;?>
            <?php if(isset($fields['field_team_job'])):?>
            <div class="m-bottom-10"><?php print $fields['field_team_job']->content;?></div>
            <?php endif;?>
            <?php if(isset($fields['body'])): print render($fields['body']->content); endif;?>
            <p></p>
            <ul class="team-social clearfix horizontal_list social_icons">
                <?php if(isset($fields['field_link_facebook'])):?>
                <li class="facebook m_bottom_5 relative">
                    <span class="tooltip tr_all_hover r_corners color_dark f_size_small"><?php print t('Facebook');?></span>
                    <a href="<?php print strip_tags($fields['field_link_facebook']->content);?>" class="r_corners t_align_c tr_delay_hover f_size_ex_large">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <?php endif;?>
                <?php if(isset($fields['field_link_twitter'])):?>
                <li class="twitter m_left_5 m_bottom_5 relative">
                    <span class="tooltip tr_all_hover r_corners color_dark f_size_small"><?php print t('Twitter');?></span>
                    <a href="<?php print strip_tags($fields['field_link_twitter']->content);?>" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
                        <i class="fa fa-twitter"></i>
                    </a>
                </li>
                <?php endif;?>
                <?php if(isset($fields['field_link_google_plus'])):?>
                <li class="google_plus m_left_5 m_bottom_5 relative">
                    <span class="tooltip tr_all_hover r_corners color_dark f_size_small"><?php print t('Google Plus');?></span>
                    <a href="<?php print strip_tags($fields['field_link_twitter']->content);?>" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
                        <i class="fa fa-google-plus"></i>
                    </a>
                </li>
                <?php endif;?>
                <?php if(isset($fields['field_link_pinterest'])):?>
                <li class="pinterest m_left_5 m_bottom_5 relative">
                    <span class="tooltip tr_all_hover r_corners color_dark f_size_small"><?php print t('Pinterest');?></span>
                    <a href="<?php print strip_tags($fields['field_link_pinterest']->content);?>" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
                        <i class="fa fa-pinterest"></i>
                    </a>
                </li>
                <?php endif;?>
                <?php if(isset($fields['field_link_linkedin'])):?>
                <li class="linkedin m_bottom_5 m_sm_left_5 relative">
                    <span class="tooltip tr_all_hover r_corners color_dark f_size_small"><?php print t('LinkedIn');?></span>
                    <a href="<?php print strip_tags($fields['field_link_linkedin']->content);?>" class="r_corners f_size_ex_large t_align_c tr_delay_hover">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <?php endif;?>
            </ul>

        </figure>
    </div>
<?php unset($fields['title']);?>
<?php unset($fields['body']);?>
<?php unset($fields['field_team_job']);?>
<?php unset($fields['field_single_image']);?>
<?php unset($fields['field_link_facebook']);?>
<?php unset($fields['field_link_twitter']);?>
<?php unset($fields['field_link_google_plus']);?>
<?php unset($fields['field_link_pinterest']);?>
<?php unset($fields['field_link_linkedin']);?>
<?php foreach ($fields as $id => $field): ?>
    <?php if (!empty($field->separator)): ?>
        <?php print $field->separator; ?>
    <?php endif; ?>
    <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
    <?php print $field->wrapper_suffix; ?>
<?php endforeach; ?>