<?php

$page = get_page_by_path('home', OBJECT, 'page');
$title = get_field('docs_title') ?: get_field('docs_title', $page) ?? '';
$descr = get_field('docs_descr') ?: get_field('docs_descr', $page) ?? '';

$docs_args = [
	'post_type' => 'documents',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
];
$docs_query = new WP_Query($docs_args);
?>

<?php if ($title || $descr || ($docs_query && $docs_query->have_posts())): ?>
	<section class="section section-docs" id="section-docs">
		<div class="section-docs__container container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if ($docs_query && $docs_query->have_posts()): ?>
				<div class="swiper docs-swiper"
					data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true, "breakpoints": { "768": { "slidesPerView": 2 }, "1024": { "slidesPerView": 3 } } }'>
					<div class="swiper-wrapper docs-swiper__wrapper">
						<?php while ($docs_query->have_posts()):
							$docs_query->the_post();
							?>
							<div class="swiper-slide docs-slide card-box">
								<a class="docs-slide__wrapper-link image-box" href="<?php echo esc_url(get_the_post_thumbnail_url()); ?>"
									data-fancybox="docs-gallery" data-caption="<?php echo esc_attr(get_the_title()); ?>"
									aria-label="<?php echo esc_attr(get_the_title()); ?>">
									<?php the_post_thumbnail() ?>
								</a>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>
					<div class="swiper-pagination docs-swiper__pagination hidden-mobile" data-swiper-pagination=".docs-swiper">
					</div>
					<?php if ($docs_query->post_count > 1): ?>
						<div class="docs-swiper__controls swiper-btn-box visible-mobile">
							<button class="swiper-btn swiper-btn__prev" data-swiper-btn-prev=".docs-swiper" aria-label="Назад"
								data-swiper-btn-prev=".docs-swiper"></button>
							<button class="swiper-btn swiper-btn__next" data-swiper-btn-next=".docs-swiper" aria-label="Вперёд"
								data-swiper-btn-next=".docs-swiper"></button>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>