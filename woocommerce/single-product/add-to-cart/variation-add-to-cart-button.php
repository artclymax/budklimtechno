<?php
/**
 * Single variation cart button
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.5.2
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="add-to-card-box">
	<div class="woocommerce-variation-add-to-cart variations_button">
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<button type="submit"
			class="single_add_to_cart_button button btn btn--cart alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>"><?php echo esc_html($product->single_add_to_cart_text()); ?></button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>

		<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="0" />
	</div>
	<a class="add-to-card-box__link btn btn--light" href="<?php the_permalink() ?>">
		<span class="add-to-card-box__link-text ">Подробнее</span>
	</a>
</div>