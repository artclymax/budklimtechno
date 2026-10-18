<?php
$page = get_page_by_path('home', OBJECT, 'page');
$title = get_field('benefits_title') ?: get_field('benefits_title', $page) ?? '';
$descr = get_field('benefits_descr') ?: get_field('benefits_descr', $page) ?? '';
$list = get_field('benefits_list') ?: get_field('benefits_list', $page) ?? [];
?>

<?php if ($title || $descr || !empty($list)): ?>
	<section class="section benefits-section" id="benefits-section">
		<div class="container benefits-section__container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($list)): ?>
				<ul class="benefits-section__list grid">
					<?php foreach ($list as $item):
						$item_icon = $item['icon'] ?? null;
						$item_title = $item['title'] ?? '';
						$item_descr = $item['descr'] ?? '';

						if (!$item_title && !$item_descr)
							continue;
						?>
						<li class="benefits-section__item benefits-section-item">
							<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
								<div class="benefits-section-item__icon">
									<?php echo wp_get_attachment_image(
										$item_icon['ID'],
										'thumbnail',
										false,
										[
											'class' => 'img',
											'alt' => $item_icon['alt'] ?: $item_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<?php if ($item_title): ?>
								<h3 class="benefits-section-item__title">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="benefits-section-item__descr descr">
									<?php echo wp_kses_post($item_descr); ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>