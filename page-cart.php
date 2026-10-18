<?php
/*
Template Name: Корзина
*/
?>
<?php get_header() ?>
<section class="section page-cart" id="page-cart">
	<div class="container page-cart__container">
		<div class="page-cart-hero">
			<div class="page-cart-hero__breadcrumbs page-breadcrumbs">
				<?php woocommerce_breadcrumb(['delimiter' => '']); ?>
			</div>
			<h1 class="page-cart-hero__title title-2">
				<?php the_title() ?>
			</h1>
		</div>
		<div class="page-cart-content">
			<?php the_content() ?>
		</div>
	</div>
</section>
<?php get_footer() ?>