<?php if($header): print $header; endif;?>
<?php $taxonomy = taxonomy_vocabulary_machine_name_load('portfolio_categories');
      $vid = taxonomy_get_tree($taxonomy->vid);
?>
<div class="d_table full_width d_xs_block">
        <?php if($footer): print $footer; endif;?>
    <div class="d_table_cell v_align_m t_align_r d_xs_block">
        <div class="custom_select relative color_dark portfolio_filter d_inline_b t_align_l d_xs_block">
            <div class="select_title type_2 r_corners relative mw_0"><?php print t('Sort Porfolio')?></div>
            <ul id="filter_portfolio" class="select_list d_none"></ul>
            <select>
                <option data-filter="*" value="All"><?php print t('All'); ?></option>
                <?php foreach($vid as $key => $value):
                    ?>
                <option data-filter=".<?php print strtolower($value->name);?>" value="Fashion"><?php print $value->name;?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
</div>
<section class="portfolio_isotope_container three_columns  portfolio-onepage">
    <?php print $rows;?>
</section>