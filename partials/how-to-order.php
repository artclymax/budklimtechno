<?php
$page = get_queried_object();
$title = get_field('how_to_order_title', $page) ?? '';
$descr = get_field('how_to_order_descr', $page) ?? '';
$list = get_field('how_to_order_list', $page) ?? [];
?>

<?php if ($title || $descr || !empty($list)): ?>
	<section class="section how-to-order" id="how-to-order">
		<div class="container how-to-order__container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($list)): ?>
				<ul class="how-to-order__list grid">
					<?php foreach ($list as $item):
						$item_icon = $item['icon'] ?? null;
						$item_title = $item['title'] ?? '';
						$item_descr = $item['descr'] ?? '';

						if (!$item_title && !$item_descr)
							continue;
						?>
						<li class="how-to-order__item how-to-order-item purchase-info-item">
							<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
								<div class="purchase-info-item__icon">
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
								<h3 class="purchase-info-item__title">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="purchase-info-item__descr descr">
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