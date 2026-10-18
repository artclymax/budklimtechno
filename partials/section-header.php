<?php 
$title = isset($args['title']) ? $args['title'] : '';
$descr = isset($args['descr']) ? $args['descr'] : '';
?>
<?php if (!empty($title) || !empty($descr)): ?>
	<div class="section-header">
		<?php if (!empty($title)): ?>
			<h2 class="section-header__title title-3">
				<?php echo esc_html($title) ?>
			</h2>
		<?php endif; ?>
		<?php if (!empty($descr)): ?>
			<div class="section-header__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>