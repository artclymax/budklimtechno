<?php 
global $product;
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php get_template_part('partials/product-card'); ?>
</li>