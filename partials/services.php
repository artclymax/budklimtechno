<?php
/**
 * Section: Services (вывод CPT services)
 */

$page = get_page_by_path('home', OBJECT, 'page');
$title = get_field('services_title') ?: get_field('services_title', $page) ?? '';
$descr =  get_field('services_descr') ?: get_field('services_descr', $page) ?? '';

$services_args = [
	'post_type' => 'services',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
];
$services_query = new WP_Query($services_args);
?>

<?php if ($title || $descr || ($services_query && $services_query->have_posts())): ?>
	<section class="section services" id="services">
		<div class="container services__container">
			<?php if ($title || $descr): ?>
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'descr' => $descr
				]); ?>
			<?php endif; ?>

			<?php if ($services_query && $services_query->have_posts()): ?>
				<ul class="services__list">
					<?php while ($services_query->have_posts()):
						$services_query->the_post();
						$service_image = get_field('service_card_image', get_the_ID()) ?? null;
						$service_short_descr = get_the_excerpt();
						$permalink = get_permalink();
						?>
						<li class="services__item services-item">
							<div class="services-item__content">
								<h3 class="services-item__title">
									<?php echo esc_html(get_the_title()); ?>
								</h3>

								<?php if ($service_short_descr): ?>
									<div class="services-item__descr descr">
										<?php echo wp_kses_post($service_short_descr); ?>
									</div>
								<?php endif; ?>

								<a class="services-item__btn btn" href="<?php echo esc_url($permalink); ?>">
									Подробнее
								</a>
							</div>

							<?php if ($service_image && is_array($service_image) && !empty($service_image['ID'])): ?>
								<div class="services-item__bg image-box">
									<?php echo wp_get_attachment_image(
										$service_image['ID'],
										'large',
										false,
										[
											'class' => 'img',
											'alt' => $service_image['alt'] ?: get_the_title(),
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php else: ?>
								<div class="services-item__bg image-box">
									<?php the_post_thumbnail() ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endwhile;
					wp_reset_postdata(); ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>