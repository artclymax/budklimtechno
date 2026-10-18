<?php
$specs = get_field('product_specs') ?? [];
$docs = get_field('product_docs') ?? [];
$content = apply_filters('the_content', get_the_content());
$delivery = get_field('product_delivery') ?? [];
$producer = get_field('product_producer') ?? [];
?>

<?php if (!empty($content) || !empty($specs) || !empty($docs) || !empty($delivery) || !empty($producer)): ?>
	<section class="section product-details" id="product-details">
		<div class="container product-details__container">


			<ul class="product-details__links product-details-links">
				<?php if (!empty($content)): ?>
					<li class="product-details-links__item">
						<a class="product-details-links__link is-active" href="#product-content" data-tab-link>
							Описание
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($specs)): ?>
					<li class="product-details-links__item">
						<a class="product-details-links__link" href="#product-specs" data-tab-link>
							Характеристики
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($docs)): ?>
					<li class="product-details-links__item">
						<a class="product-details-links__link" href="#product-docs" data-tab-link>
							Документация
						</a>
					</li>
				<?php endif; ?>
				<?php if (!empty($delivery)): ?>
					<li class="product-details-links__item">
						<a class="product-details-links__link" href="#product-delivery" data-tab-link>
							Доставка и оплата
						</a>
					</li>
				<?php endif; ?>
			</ul>

			<!-- CONTENT -->
			<?php if (!empty($content)): ?>
				<article class="product-details__article product-details-tab" id="product-content" data-tab>
					<div class="product-details-tab__descr descr">
						<?php echo wp_kses_post($content); ?>
					</div>
				</article>
			<?php endif; ?>

			<!-- SPECS -->
			<?php if (!empty($specs)): ?>
				<article class="product-details__article product-details-tab" id="product-specs" data-tab>

					<ul class="product-details-tab__specs product-details-specs">
						<?php foreach ($specs as $item):
							$item_key = $item['key'] ?? '';
							$item_value = $item['value'] ?? '';

							if (!$item_key && !$item_value)
								continue;
							?>
							<li class="product-details-specs__item">
								<?php if ($item_key): ?>
									<p class="product-details-specs__key">
										<?php echo esc_html($item_key); ?>
									</p>
								<?php endif; ?>

								<?php if ($item_value): ?>
									<p class="product-details-specs__value">
										<?php echo esc_html($item_value); ?>
									</p>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endif; ?>

			<!-- DOCS -->
			<?php if (!empty($docs)): ?>
				<article class="product-details__article product-details-tab" id="product-docs" data-tab>
					<ul class="product-details-tab__docs product-details-docs">
						<?php foreach ($docs as $doc):
							$file = $doc['file'] ?? null;
							$file_title = $doc['title'] ?? '';
							$file_descr = $doc['descr'] ?? '';

							if (!$file || empty($file['url']))
								continue;

							$file_url = $file['url'];
							$file_size = !empty($file['filesize']) ? size_format($file['filesize']) : '';

							$file_type = '';
							if (!empty($file['filename'])) {
								$ext = pathinfo($file['filename'], PATHINFO_EXTENSION);
								$file_type = strtoupper($ext);
							}

							if (empty($file_title) && !empty($file['filename'])) {
								$file_title = pathinfo($file['filename'], PATHINFO_FILENAME);
							}
							?>
							<li class="product-details-docs__item">
								<a class="product-details-docs__link" href="<?php echo esc_url($file_url); ?>" target="_blank"
									rel="noopener" data-fancybox>
									<div class="product-details-docs__content">
										<?php if ($file_title): ?>
											<p class="product-details-docs__title">
												<?php echo esc_html($file_title); ?>
											</p>
										<?php endif; ?>

										<?php if ($file_descr): ?>
											<p class="product-details-docs__descr">
												<?php echo esc_html($file_descr); ?>
											</p>
										<?php endif; ?>
									</div>

									<div class="product-details-docs__meta">
										<?php if ($file_type): ?>
											<span class="product-details-docs__type">
												<?php echo esc_html($file_type); ?>
											</span>
										<?php endif; ?>

										<?php if ($file_size): ?>
											<span class="product-details-docs__size">
												<?php echo esc_html($file_size); ?>
											</span>
										<?php endif; ?>
									</div>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</article>
			<?php endif; ?>

			<!-- DELIVERY -->
			<?php if (!empty($delivery)): ?>
				<article class="product-details__article product-details-tab" id="product-delivery" data-tab>
					<div class="product-details-tab__grid">
						<?php foreach ($delivery as $block):
							$block_descr = $block['descr'] ?? '';
							if (!$block_descr)
								continue;
							?>
							<div class="product-details-tab__descr descr">
								<?php echo wp_kses_post($block_descr); ?>
							</div>
						<?php endforeach; ?>
					</div>
				</article>
			<?php endif; ?>
			<?php if (!empty($producer)): ?>
				<div class="product-details__producer descr">
					<?php echo wp_kses_post($producer) ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>