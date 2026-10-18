<?php
$page = get_queried_object();
$list = get_field('service_benefits_list', $page) ?? [];
?>

<?php if (!empty($list)): ?>
	<section class="section service-benefits" id="service-benefits">
		<h2 class="visually-hidden">Преимущества <?php the_title(); ?></h2>
		<div class="container service-benefits__container">
			<ul class="service-benefits__list grid">
				<?php foreach ($list as $item):
					$item_image = $item['image'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';

					if (!$item_title && !$item_descr && (!$item_image || empty($item_image['ID']))) {
						continue;
					}
					?>
					<li class="service-benefits__item service-benefits-item card-box">
						<?php if ($item_image && is_array($item_image) && !empty($item_image['ID'])): ?>
							<div class="service-benefits-item__icon">
								<?php echo wp_get_attachment_image(
									$item_image['ID'],
									'large',
									false,
									[
										'class' => 'img',
										'alt' => $item_image['alt'] ?: $item_title,
										'loading' => 'lazy'
									]
								); ?>
							</div>
						<?php endif; ?>

						<?php if ($item_title): ?>
							<h3 class="service-benefits-item__title">
								<?php echo esc_html($item_title); ?>
							</h3>
						<?php endif; ?>

						<?php if ($item_descr): ?>
							<div class="service-benefits-item__descr descr">
								<?php echo wp_kses_post($item_descr); ?>
							</div>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>