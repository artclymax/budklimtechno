<?php
/**
 * Variable product add to cart
 *
 * @package WooCommerce/Templates
 * @version 9.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

global $product;

if (!$product->is_type('variable')) {
	return;
}

$attribute_keys = array_keys($attributes);
$variations_json = wp_json_encode($available_variations);
$variations_attr = function_exists('wc_esc_json') ? wc_esc_json($variations_json) : _wp_specialchars($variations_json, ENT_QUOTES, 'UTF-8', true);

// Находим первую доступную вариацию для автовыбора
$default_variation = null;
if (!empty($available_variations)) {
	foreach ($available_variations as $variation) {
		if ($variation['is_in_stock'] && !empty($variation['attributes'])) {
			$default_variation = $variation;
			break;
		}
	}
}

do_action('woocommerce_before_add_to_cart_form');
?>

<form class="variations_form cart"
	action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>"
	method="post" enctype='multipart/form-data' data-product_id="<?php echo absint($product->get_id()); ?>"
	data-product_variations="<?php echo $variations_attr; // WPCS: XSS ok. ?>"
	data-default_variation="<?php echo $default_variation ? esc_attr(json_encode($default_variation['attributes'])) : ''; ?>">

	<?php do_action('woocommerce_before_variations_form'); ?>

	<?php if (empty($available_variations) && false !== $available_variations): ?>
		<p class="stock out-of-stock">
			<?php echo esc_html(apply_filters('woocommerce_out_of_stock_message', __('This product is currently out of stock and unavailable.', 'woocommerce'))); ?>
		</p>
	<?php else: ?>
		<ul class="variations">
			<?php foreach ($attributes as $attribute_name => $options): ?>
				<?php
				$selected = isset($_REQUEST['attribute_' . sanitize_title($attribute_name)])
					? wc_clean(wp_unslash($_REQUEST['attribute_' . sanitize_title($attribute_name)]))
					: ($default_variation && isset($default_variation['attributes']['attribute_' . sanitize_title($attribute_name)])
						? $default_variation['attributes']['attribute_' . sanitize_title($attribute_name)]
						: $product->get_variation_default_attribute($attribute_name));
				?>
				<li class="variations__item">
					<label class="variations__label" for="<?php echo esc_attr(sanitize_title($attribute_name)); ?>">
						<?php echo wc_attribute_label($attribute_name); ?>
					</label>

					<ul class="variations__sublist">
						<?php
						if (!empty($options)) {
							if (taxonomy_exists($attribute_name)) {
								$terms = wc_get_product_terms($product->get_id(), $attribute_name, array('fields' => 'all'));
								foreach ($terms as $term) {
									if (!in_array($term->slug, $options, true)) {
										continue;
									}

									$is_selected = ($selected === $term->slug) ? ' active selected' : '';
									$option_name = apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute_name, $product);

									echo '<li class="variations__subitem">';
									echo '<button type="button" class="variations__btn' . esc_attr($is_selected) . '" data-attribute="' . esc_attr(sanitize_title($attribute_name)) . '" data-value="' . esc_attr($term->slug) . '">' . esc_html($option_name) . '</button>';
									echo '</li>';
								}
							} else {
								foreach ($options as $option) {
									$sanitized_option = sanitize_title($option);
									$is_selected = ($selected === $sanitized_option) ? ' active selected' : '';
									$option_name = apply_filters('woocommerce_variation_option_name', $option, null, $attribute_name, $product);

									echo '<li class="variations__subitem">';
									echo '<button type="button" class="variations__btn' . esc_attr($is_selected) . '" data-attribute="' . esc_attr(sanitize_title($attribute_name)) . '" data-value="' . esc_attr($sanitized_option) . '">' . esc_html($option_name) . '</button>';
									echo '</li>';
								}
							}
						}
						?>
					</ul>

					<div class="variations__native-select">
						<?php
						wc_dropdown_variation_attribute_options(
							array(
								'options' => $options,
								'attribute' => $attribute_name,
								'product' => $product,
								'selected' => $selected,
							)
						);
						?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>

		<div class="custom-variation-info">
			<div class="custom-variation-meta">
				<?php
				$product_id = $product->get_id();
				$tags = get_the_terms($product_id, 'product_tag');
				if ($tags && !is_wp_error($tags)):
					?>
					<ul class="product-card__tags">
						<?php foreach ($tags as $tag): ?>
							<li>
								<?php echo esc_html($tag->name); ?>
							</li>
							<li class="dot-decor">
								•
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<div class="product-card__price price-box">
				<?php echo $product->get_price_html(); ?>
			</div>
		</div>

		<div class="reset_variations-container">
			<?php
			echo wp_kses_post(
				apply_filters(
					'woocommerce_reset_variations_link',
					'<a class="reset_variations" href="#" style="display:none;">' . esc_html__('Clear', 'woocommerce') . '</a>'
				)
			);
			?>
		</div>

		<?php do_action('woocommerce_after_variations_table'); ?>

		<div class="single_variation_wrap">
			<?php
			do_action('woocommerce_before_single_variation');
			do_action('woocommerce_single_variation');
			do_action('woocommerce_after_single_variation');
			?>
		</div>

	<?php endif; ?>

	<?php do_action('woocommerce_after_variations_form'); ?>
</form>

<?php
do_action('woocommerce_after_add_to_cart_form');