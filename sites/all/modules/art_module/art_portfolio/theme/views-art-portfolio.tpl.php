<?php
/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<div id="<?php print $view_id; ?>">
	<!-- <div class="container"> -->
		<div class="d_table full_width d_xs_block">
			<div class="d_table_cell v_align_m d_xs_block m_xs_bottom_15">
				<?php
				$title = $view->display_handler->get_option('title');
				if (!empty($title)): ?>
					<h2 class="tt_uppercase color_dark"><?php print $title; ?></h2>
				<?php endif; ?>
			</div>
			<?php if (isset($categories) && $use_filter == 1): ?>
				<div class="d_table_cell v_align_m t_align_r d_xs_block">
					<div class="custom_select relative color_dark portfolio_filter d_inline_b t_align_l d_xs_block">
						<div class="select_title type_2 r_corners relative mw_0"><?php echo t('Sort Porfolio'); ?></div>
						<ul id="filter_portfolio" class="select_list d_none"></ul>
						<select>
							<option data-filter="*" value="All"><?php echo t('All'); ?></option>
							<?php foreach ($categories as $key => $c): ?>
								<option data-filter=".<?php echo $key; ?>" value="<?php echo $c; ?>"><?php echo $c; ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<section class="portfolio_isotope_container <?php echo $block_portfolio; ?>">
			<?php foreach ($rows as $id => $row): ?>
				<?php print $row; ?>
			<?php endforeach; ?>
		</section>
	<!-- </div> -->
</div>


