<?php
	// We hide the comments and links now so that we can render them later.
	hide($content['comments']);
	hide($content['links']);
	$categories = '';
	$i=1;
	foreach($node->field_portfolio_categories['und'] as $tid) {
		$term = taxonomy_term_load($tid['tid']); // load term object
		$term_uri = taxonomy_term_uri($term); // get array with path
		$term_title = taxonomy_term_title($term);
		$term_path = $term_uri['path'];
		if($i == count($node->field_portfolio_categories['und'])) {
			$categories .= '<a class="color_dark" href="'.$term_path.'">'.$term_title.'</a>';
		} else {
			$categories .= '<a class="color_dark" href="'.$term_path.'">'.$term_title.'</a>, ';
		}
		$i++;
	}
    $columns = $view->style_options['columns'];
	
	$original_image = 'http://placehold.it/800x600';
	$imgHtml = "<img width='800px' height='600px' src='{$original_image}' alt='' class='tr_all_long_hover'>";
    if($columns == 2){
        $original_image = image_style_url('portfolio_image_535x335',$node->field_single_image['und'][0]['uri']);
		$imgHtml = "<img width='535px' height='335px' src='{$original_image}' alt='' class='tr_all_long_hover'>";
    } elseif($columns == 3) {
		$original_image = image_style_url('portfolio_image_340x210',$node->field_single_image['und'][0]['uri']);
		$imgHtml = "<img width='340px' height='210px' src='{$original_image}' alt='' class='tr_all_long_hover'>";
	} elseif($columns == 4) {
		$original_image = image_style_url('portfolio_image_243x148',$node->field_single_image['und'][0]['uri']);
		$imgHtml = "<img width='243px' height='148px' src='{$original_image}' alt='' class='tr_all_long_hover'>";
	} else {
        $original_image = file_create_url($node->field_single_image['und'][0]['uri']);
		$imgHtml = "<img src='{$original_image}' alt='' class='tr_all_long_hover'>";
    }
$original_image_zoom = file_create_url($node->field_single_image['und'][0]['uri']);
$video = '';
if(!empty($node->field_video['und'])){
    $video = $node->field_video['und'][0]['value'];
}

?>
<?php if (!$page) : ?>
<div class="portfolio_item t_xs_align_c <?php print $classes; ?>">
	<figure class="d_xs_inline_b d_mxs_block">
		<div class="photoframe with_buttons relative shadow r_corners wrapper m_bottom_15">
			<?php print $imgHtml; ?>
			<div class="open_buttons clearfix">
                <?php if(!empty($node->field_video['und'])):?>
                <div class="f_left f_size_large tr_all_hover"><a href="<?php print $video;?>" data-thumbnail="<?php print $original_image_zoom; ?>" role="button" class="color_light button_type_13 r_corners box_s_none d_block jackbox" data-group="portfolio" data-title="<?php print $title;?>"><i class="fa fa-video-camera"></i></a></div>
                <?php else:?>
                <div class="f_left f_size_large tr_all_hover"><a href="<?php print $original_image_zoom; ?>" role="button" class="color_light button_type_13 r_corners box_s_none d_block jackbox" data-group="portfolio" data-title="<?php print $title;?>"><i class="fa fa-camera"></i></a></div>
                <?php endif;?>
				<div class="f_left m_left_10 f_size_large tr_all_hover"><a href="<?php print $node_url; ?>" role="button" class="color_light button_type_13 r_corners box_s_none d_block"><i class="fa fa-link"></i></a></div>
			</div>
		</div>
		<figcaption class="t_xs_align_l">
			<h4 class="m_bottom_3"><a href="<?php print $node_url; ?>" class="color_dark"><b><?php echo $title; ?></b></a></h4>
			<?php print $categories; ?>
		</figcaption>
	</figure>
</div>
<?php endif; ?>