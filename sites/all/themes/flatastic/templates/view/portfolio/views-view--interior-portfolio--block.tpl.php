<?php if($header): print $header; endif;?>
<?php $taxonomy = taxonomy_vocabulary_machine_name_load('portfolio_categories');
$vid = taxonomy_get_tree($taxonomy->vid);
?>
<div class="d_table full_width d_xs_block">
    <div class="d_table_cell v_align_m t_align_r d_xs_block">
        <div class="custom_select relative color_dark portfolio_filter t_align_l d_xs_block">
            <ul id="filter_portfolio">
                <li data-filter="*" value="All" class="active"><?php print t('All');?></li>
                <?php foreach($vid as $key => $value):
                    ?>
                    <li data-filter=".<?php print strtolower($value->name);?>" value="Fashion"><?php print $value->name;?></li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
</div>
<section class="portfolio_isotope_container three_columns  portfolio-onepage">
    <?php print $rows;?>
</section>
<?php if ($footer): ?>
        <?php print $footer; ?>
<?php endif; ?>