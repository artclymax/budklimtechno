<div class="shop-header-bar">
	<button class="shop-header-bar__filter btn btn--accent icon icon--filter visible-tablet" type="button">
		Фильтры
	</button>
	<div class="shop-header-bar__sorts">
		<?php woocommerce_catalog_ordering() ?>
	</div>
	<div class="shop-header-bar__filter-chips">
		<?php echo do_shortcode('[fe_chips]') ?>
	</div>
</div>