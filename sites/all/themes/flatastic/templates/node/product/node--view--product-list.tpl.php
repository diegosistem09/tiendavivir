<?php
global $base_url;
global $theme_root;

if (!empty($node->field_product['und'][0])) {
    $product = commerce_product_load($node->field_product['und'][0]['product_id']);
    $id = $product->product_id;
}

$single_image = ' ';
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
<?php if(isset($_GET['mode']) && $_GET['mode'] == 'list') : ?>


	<div class="product_item full_width list_type <?php print $str_att; ?> m_left_0 m_right_0 c-list">
		<figure class="r_corners photoframe tr_all_hover type_2 shadow relative clearfix">
			<!--product preview-->
			<a href="<?php echo $node_url ?>" class="d_block f_left relative pp_wrap m_right_30 m_xs_right_25">
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
				<img width="242" height="242" src="<?php print $single_image; ?>" class="tr_all_hover" alt="">

			</a>
			<!--description and price of product-->
			<figcaption>
				<div class="clearfix">
					<div class="f_left p_list_description w_sm_full f_sm_none m_xs_bottom_10">
						<h4 class="fw_medium"><a href="<?php echo $node_url ?>" class="color_dark"><?php print $title; ?></a></h4>
						<div class="m_bottom_10">
							<!--rating-->
							<div class="horizontal_list d_inline_middle clearfix rating_list type_2 tr_all_hover">
								<?php print render($content['field_rating']); ?>
							</div>
						</div>
						<hr class="m_bottom_10">
						<div class="d_sm_none d_xs_block">
							<?php
								$summary = '';
								if($node->body['und'][0]['summary'] != Null){
									$summary = $node->body['und'][0]['summary'];
								}
								print $summary;
							?>
						</div>
					</div>
					<div class="f_right t_align_r f_sm_none t_sm_align_l">
						<div class="scheme_color f_size_large m_bottom_15">
							<div class="fw_medium">
								  <?php print render($content['product:field_regular_price']);?>
                                <?php print render($content['product:commerce_price']); ?>
							</div>
						</div>
						<?php print render($content['field_product']); ?><br class="d_sm_none">
						<?php if (module_exists('flag')): ?>
							<?php print flag_create_link('shop', $node->nid); ?>
						<?php endif; ?>
					</div>
				</div>
			</figcaption>
		</figure>
	</div>

<?php else :?>


	<div class="product_item <?php print $str_att; ?> w_xs_full c-grid">
		<figure class="r_corners photoframe tr_all_hover type_2 shadow relative">
			<!--product preview-->
			<a href="<?php echo $node_url ?>" class="d_block relative pp_wrap m_bottom_15">
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
			<figcaption class="t_xs_align_l p-right">
				<h5 class="m_bottom_10"><a href="<?php echo $node_url ?>" class="color_dark ellipsis"><?php print $title; ?></a></h5>
				<div class="clearfix">
					<div class="scheme_color f_left f_size_large m_bottom_15">
                        <s><?php print render($content['product:field_regular_price']);?></s>
                        <?php print render($content['product:commerce_price']); ?>
					</div>
					<!--rating-->
					<div class="horizontal_list f_right clearfix rating_list tr_all_hover">
						<?php print render($content['field_rating']);?>
					</div>
				</div>
				<div class="clearfix relative">
					<div class="f_left">
						<?php print render($content['field_product']);?>
					</div>
					<?php if (module_exists('flag')): ?>
						<div class="p_right">
							<?php print flag_create_link('shop', $node->nid); ?>
						</div>
					<?php endif; ?>
				</div>
			</figcaption>
		</figure>
	</div>
<?php endif; ?>
