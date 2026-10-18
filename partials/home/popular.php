<?php
$page = get_queried_object();
$title = get_field('home_popular_title', $page) ?: 'Популярные товары';
$descr = get_field('home_popular_descr', $page) ?? '';
$selected_products = get_field('home_popular_products', $page) ?? [];

if (!empty($selected_products)) {
	$args = [
		'post_type' => 'product',
		'post__in' => $selected_products,
		'orderby' => 'post__in',
		'posts_per_page' => -1,
	];
} else {
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 12,
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
		'tax_query' => [
			[
				'taxonomy' => 'product_visibility',
				'field' => 'name',
				'terms' => 'featured',
				'operator' => 'IN',
			],
		],
	];
}

$product_query = new WP_Query($args);
?>

<?php if ($title || $descr || $product_query->have_posts()): ?>
	<section class="section home-popular" id="home-popular">
		<div class="container home-popular__container">

			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if ($product_query->have_posts()): ?>
				<div class="home-popular__slider">
					<div class="swiper home-popular-swiper"
						data-swiper="{'slidesPerView': 1, 'spaceBetween': 20, 'rewind': true, 'breakpoints': {'768': { 'slidesPerView': 2 }, '1024': { 'slidesPerView': 3}}}">
						<div class="swiper-wrapper home-popular-swiper__wrapper">

							<?php
							while ($product_query->have_posts()):
								$product_query->the_post();
								global $product;
								$product = wc_get_product(get_the_ID());
								?>
								<div class="swiper-slide home-popular-slide">
									<?php get_template_part('partials/product-card', null, ['class' => 'home-popular-slide__wrapper product-card--popular']); ?>
								</div>
							<?php endwhile; ?>

							<?php wp_reset_postdata(); ?>

						</div>
					</div>

					<div class="swiper-btn-box">
						<button class="swiper-btn swiper-btn__prev home-popular-swiper__btn home-popular-swiper__btn-prev"
							type="button" aria-label="Назад" data-swiper-btn-prev=".home-popular-swiper"></button>
						<button class="swiper-btn swiper-btn__next home-popular-swiper__btn home-popular-swiper__btn-next"
							type="button" aria-label="Вперёд" data-swiper-btn-next=".home-popular-swiper"></button>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>