<?php
global $base_url;
global $theme_root;
$curr_uri = request_uri();

if (!empty($node->field_product['und'][0])) {
    $product = commerce_product_load($node->field_product['und'][0]['product_id']);
    $id = $product->product_id;
}

$single_image = '';
if (!empty($node->field_single_image['und'])) {
    $single_image = image_style_url("product_block_242x242", $node->field_single_image['und'][0]['uri']);
}
$str_att = '';
if (isset($node->field_product_attributes)):
    if(isset($node->field_product_attributes['und'])){
        foreach ($node->field_product_attributes['und'] as $att) {
            $str_att .= ' ' . strtolower($att['taxonomy_term']->name);
        }
    }
endif;

$multiple_image = array();
if (!empty($node->field_image['und'])) {
    $multiple_image = $node->field_image['und'];
}

?>

<!--product item-->
<div class="product_item <?php print $str_att; ?> w_xs_full">
    <figure class="r_corners photoframe animate_ftb long type_2 t_align_c shadow relative">
        <!--product preview-->
        <a href="#" class="d_block relative pp_wrap m_bottom_15">
            <!--hot product-->
            <?php if(theme_get_setting('demo') == 'interior' || strpos($curr_uri, 'interior-variant') || strpos($curr_uri, 'interior-landing')):?>
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
            <span role="button" data-popup="#quick_view_product_<?php echo $id ?>" class="button_type_5 box_s_none color_light r_corners tr_all_hover d_xs_none">
                <?php print t('Quick View') ?>
            </span>
        </a>
        <!--description and price of product-->
        <figcaption>
            <h5 class="m_bottom_10"><a href="<?php echo $node_url ?>" class="color_dark ellipsis"><?php print $title; ?></a></h5>
            <div class="clearfix m_bottom_15">
                <!--rating-->
                <div class="horizontal_list type_2 m_bottom_10 d_inline_b clearfix rating_list tr_all_hover">
                    <?php print render($content['field_rating']); ?>
                </div>
                <p class="scheme_color f_size_large">
                    <s><?php print render($content['product:field_regular_price']);?></s>
                    <?php print render($content['product:commerce_price']); ?>
                </p>
            </div>
            <div class="clearfix m_bottom_15 relative">
                <div class="p_left"><?php print render($content['field_product']); ?></div>
                <div class="p_right">
					<ul class="horizontal_list d_inline_b l_width_divider">
						<li class="f_md_none m_md_right_0">
							<?php if (module_exists('flag')): ?>
								<?php print flag_create_link('shop', $node->nid); ?>
							<?php endif; ?>
						</li>
					</ul>
				</div>
            </div>
        </figcaption>
    </figure>
</div>
