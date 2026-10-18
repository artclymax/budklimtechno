<?php 
$page = 'option';
$title = get_field('contacts_title', $page) ?? 'Контакты';
$map = get_field('contacts_map', $page) ?? '';
?>
<section class="section section-contacts" id="section-contacts">
	<div class="container section-contacts__container">
		<div class="section-contacts__content">
			<h2 class="section-contacts__title title-3">
				<?php echo esc_html($title) ?>
			</h2>
			<?php get_template_part('partials/contacts-box'); ?>
		</div>
		<?php if (!empty($map)): ?>
			<div class="section-contacts__map card-box">
				<?php echo wp_kses($map, [
					'iframe' => [
						'src' => true,
						'width' => true,
						'height' => true,
						'style' => true,
						'allowfullscreen' => true,
						'loading' => true,
					],
				]) ?>
			</div>
		<?php endif; ?>
	</div>
</section>