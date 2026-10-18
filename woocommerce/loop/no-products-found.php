<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

?>
<div class="woocommerce-no-products-found products-no-found">
	<div class="products-no-found__icon">
		<svg width="113" height="99" viewBox="0 0 113 99" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path
				d="M108.219 90.6328L95.8592 78.2713C97.851 75.5342 98.9225 72.2354 98.9192 68.8502C98.9192 59.99 91.7105 52.7812 82.8502 52.7812C73.99 52.7812 66.7812 59.99 66.7812 68.8502C66.7812 77.7105 73.99 84.9192 82.8502 84.9192C86.2354 84.9225 89.5342 83.851 92.2713 81.8592L104.633 94.2188L108.219 90.6328ZM82.8502 79.8441C80.6756 79.8443 78.5497 79.1996 76.7414 77.9916C74.9332 76.7835 73.5238 75.0664 72.6915 73.0573C71.8592 71.0482 71.6414 68.8374 72.0656 66.7045C72.4898 64.5716 73.537 62.6124 75.0747 61.0747C76.6124 59.537 78.5716 58.4898 80.7045 58.0656C82.8374 57.6414 85.0482 57.8592 87.0573 58.6915C89.0664 59.5238 90.7835 60.9332 91.9916 62.7414C93.1996 64.5497 93.8443 66.6756 93.8441 68.8502C93.8407 71.7649 92.6813 74.5593 90.6203 76.6203C88.5593 78.6813 85.7649 79.8407 82.8502 79.8441Z"
				fill="#0E106D" />
			<path d="M0 9.09375L36.375 54.5625V78.8125L60.625 87.9062V54.5625L97 9.09375H0Z" fill="#0E106D" />
		</svg>
	</div>
	<h3 class="products-no-found__title title-3">
		По выбранным параметрам ничего не найдено
	</h3>
	<p class="products-no-found__text">
		Попробуйте изменить фильтр или сбросить часть параметров.
	</p>
	<a class="products-no-found__btn btn btn--accent" href="<?php echo esc_url(home_url('/shop/')); ?>">Сбросить фильтры</a>
</div>