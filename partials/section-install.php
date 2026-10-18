<?php
$page = get_queried_object();
$title = get_field('install_title', $page) ?? '';
$descr = get_field('install_descr', $page) ?? '';
$btn = get_field('install_btn', $page) ?? [];
$list = get_field('install_list', $page) ?? [];
$image = get_field('install_image', $page) ?? null;
$image_mobile = get_field('install_image_mobile', $page) ?? null;
?>

<?php if ($title || $descr || !empty($list) || ($image && is_array($image) && !empty($image['ID']))): ?>
	<section class="section section-install" id="section-install">
		<div class="section-install__left">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($btn) && is_array($btn) && !empty($btn['url'])): ?>
				<a class="section-install__btn btn btn--accent" href="<?php echo esc_url($btn['url']); ?>" <?php echo !empty($btn['target']) ? 'target="' . esc_attr($btn['target']) . '"' : ''; ?>>
					<?php echo esc_html($btn['title'] ?? 'Подробнее'); ?>
				</a>
			<?php endif; ?>
		</div>

		<div class="section-install__right">
			<?php if (!empty($list)): ?>
				<ul class="section-install__list">
					<?php foreach ($list as $item):
						$item_descr = $item['descr'] ?? '';
						if (!$item_descr)
							continue;
						?>
						<li class="section-install__item descr icon icon--check">
							<?php echo wp_kses_post($item_descr); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if ($image && is_array($image) || !empty($image_mobile)): ?>
				<div class="section-install__image image-box">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img' . (!empty($image_mobile['ID']) ? ' hidden-mobile' : ''),
							'alt' => $image['alt'] ?: $title,
							'loading' => 'lazy'
						]
					); ?>

					<?php if (!empty($image_mobile['ID'])): ?>
						<?php echo wp_get_attachment_image(
							$image_mobile['ID'],
							'large',
							false,
							[
								'class' => 'img' . (!empty($image['ID']) ? ' visible-mobile' : ''),
								'alt' => $image_mobile['alt'] ?: $title,
								'loading' => 'lazy'
							]
						); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>