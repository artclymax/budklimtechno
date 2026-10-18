<?php
global $product;

$product_id = $product->get_id();
$is_variable = $product->is_type('variable');

$class = $args['class'] ?? '';
?>
<div class="product-card card-box <?php echo esc_attr($class); ?>">
	<!-- Изображение -->
	<a class="product-card__image-link image-box" href="<?php echo esc_url($product->get_permalink()); ?>">
		<?php if ($product->get_image_id()): ?>
			<?php echo wp_get_attachment_image(
				$product->get_image_id(),
				'medium_large',
				false,
				[
					'class' => 'img',
					'alt' => $product->get_name(),
					'loading' => 'lazy'
				]
			); ?>
		<?php endif; ?>
	</a>

	<!-- Категории -->
	<?php
	$categories = get_the_terms($product_id, 'product_cat');
	if ($categories && !is_wp_error($categories)):
		?>
		<ul class="product-card__categories">
			<?php foreach (array_slice($categories, 0, 2) as $cat): ?>
				<li>
					<a href="<?php echo esc_url(get_term_link($cat)); ?>">
						<?php echo esc_html($cat->name); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

	<!-- Заголовок -->
	<h3 class="product-card__title">
		<a href="<?php echo esc_url($product->get_permalink()); ?>">
			<?php echo esc_html($product->get_name()); ?>
		</a>
	</h3>
	<!-- Вариации (только для вариативных товаров) -->
	<?php if ($is_variable): ?>
		<?php woocommerce_variable_add_to_cart(); ?>
	<?php endif; ?>
	<!-- Кнопка добавления в корзину (стандартная WooCommerce) -->
	<?php if (!$is_variable): ?>
		<!-- Метки -->
		<?php
		$product_id = $product->get_id();
		$tags = get_the_terms($product_id, 'product_tag');
		if ($tags && !is_wp_error($tags)):
			?>
			<ul class="product-card__tags">
				<?php foreach (array_slice($tags, 0, 3) as $tag): ?>
					<li>
						<?php echo esc_html($tag->name); ?>
					</li>
					<li class="dot-decor">
						•
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<!-- Цена -->
		<div class="product-card__price price-box">
			<?php echo $product->get_price_html(); ?>
		</div>
		<?php woocommerce_template_single_add_to_cart(); ?>
	<?php endif; ?>

</div>