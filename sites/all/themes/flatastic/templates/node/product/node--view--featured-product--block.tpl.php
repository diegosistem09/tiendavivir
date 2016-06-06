<?php include_once 'node_all.inc';?>
<figure class="r_corners photoframe shadow relative d_inline_b d_md_block d_xs_inline_b tr_all_hover">
    <!--product preview-->
    <a href="<?php echo $node_url ?>" class="d_block relative pp_wrap">
        <!--hot product-->
        <?php if(theme_get_setting('demo') == 'interior'):?>
            <?php if (strpos($str_att,'hit')): ?>
                <span class="hot_interior"><?php print t('HOT');?></span>
            <?php endif; ?>
            <?php if (strpos($str_att,'specials')): ?>
                <span class="hot_interior type_2"><?php print t('SALE');?></span>
            <?php endif; ?>
        <?php else:?>
            <?php if (strpos($str_att,'hit')): ?>
                <span class="hot_stripe"><img width="82px" height="82px" src="<?php print $theme_root; ?>/images/hot_product.png" alt=""></span>
            <?php endif; ?>
            <?php if (strpos($str_att,'specials')): ?>
                <span class="hot_stripe type_2"><img width="82px" height="82px" src="<?php print $theme_root; ?>/images/sale_product_type_2.png" alt=""></span>
            <?php endif; ?>
        <?php endif;?>
        <img width="242px" height="242px" src="<?php print $single_image; ?>" class="tr_all_hover" alt="">
    </a>
    <!--description and price of product-->
    <figcaption class="t_xs_align_l">
        <h5 class="m_bottom_10"><a href="<?php echo $node_url ?>" class="color_dark ellipsis"><?php print $title; ?></a></h5>
        <div class="clearfix">
            <div class="scheme_color f_left f_size_large m_bottom_15">
                <?php print render($content['product:field_regular_price']);?>
                <?php print render($content['product:commerce_price']); ?>
            </div>
            <!--rating-->
            <div class="horizontal_list f_right clearfix rating_list tr_all_hover">
                <?php print render($content['field_rating']);?>
            </div>
        </div>
        <div class="clearfix relative">
            <div class="f_left>
                <?php print render($content['field_product']);?>
            </div>
            <?php if (module_exists('flag')):    ?>
                <div class="p_right">
                    <?php print flag_create_link('shop', $node->nid); ?>
                </div>
            <?php endif; ?>
        </div>
    </figcaption>
</figure>
