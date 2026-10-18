<?php
defined('ABSPATH') || exit;

$image = get_template_directory_uri() . '/assets/images/cart-empty-icon.webp';
$title = get_field('cart_empty_title') ?? 'Ваша корзина пуста';
$text = get_field('cart_empty_text') ?? 'Добавьте товары из каталога, чтобы оформить заказ.';
$btn = get_field('cart_empty_btn') ?? [];

if (wc_get_page_id('shop') > 0): ?>
	<div class="return-to-shop">
		<div class="return-to-shop__icon">
			<img src="<?= esc_url($image) ?>" alt="<?= esc_attr($title) ?>">
		</div>
		<h3 class="return-to-shop__title title-3">
			<?php echo esc_html($title) ?>
		</h3>
		<p class="return-to-shop__text">
			<?php echo esc_html($text) ?>
		</p>
		<?php if (!empty($btn)): ?>
			<a class="return-to-shop__btn btn btn--accent" href="<?php echo esc_html($btn['url']) ?>">
				<?php echo esc_html($btn['title']) ?>
			</a>
		<?php else: ?>
			<a class="button wc-backward<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> return-to-shop__btn btn btn--accent"
				href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
				<?php
				echo esc_html(apply_filters('woocommerce_return_to_shop_text', __('Return to shop', 'woocommerce')));
				?>
			</a>
		<?php endif; ?>
	</div>
<?php endif; ?>