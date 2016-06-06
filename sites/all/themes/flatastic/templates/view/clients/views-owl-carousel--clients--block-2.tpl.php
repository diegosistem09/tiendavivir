<div class="<?php print $wrapper_class; ?>">
    <?php $i = 0;?>
    <?php foreach ($rows as $id => $row): ?>
		<?php if (($i++%2)==0): ?>
			<div class="c-brand">
        <?php endif ?>
			<?php echo $row; ?>
        <?php if ($i%2==0 || $i==count($rows)): ?>
			</div>
        <?php endif ?>
    <?php endforeach; ?>

</div>