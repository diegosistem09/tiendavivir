<?php global $base_url;?>

<figure class="widget shadow r_corners wrapper m_bottom_30">
    <?php if(isset($wishlist_title)): ?>
		<figcaption>
			<h3 class="color_light"><?php print $wishlist_title;?></h3>
		</figcaption>
	<?php endif;?>
    <?php if(isset($wishlist)):?>
		<div class="widget_content">
			<?php foreach($wishlist as $key => $value):
				$single_image = $value->field_single_image['und'][0]['uri'];
				?>
				<div class="clearfix m_bottom_15 relative cw_product">
					<img src="<?php print image_style_url('blog_latest_80x80',$single_image);?>" alt="" class="f_left m_right_15 m_sm_bottom_10 f_sm_none f_xs_left m_xs_bottom_0">
					<a href="<?php print drupal_get_path_alias('node/'.$value->nid);?>" class="color_dark d_block bt_link"><?php print $value->title;?></a>
				</div>
				<hr class="m_bottom_15">
			<?php endforeach;?>
			<a href="<?php print $base_url.'/wishlist';?>" class="color_dark"><i class="fa fa-heart-o m_right_10"></i><?php print t('Go to Wishlist');?></a>
		</div>
    <?php else:?>
        <div class="widget_content">
            <?php print t('You have no product to compare.');?>
        </div>
    <?php endif;?>
</figure>
