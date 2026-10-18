<?php

$page = get_queried_object();
$title = get_field('services_process_title', $page) ?? '';
$descr = get_field('services_process_descr', $page) ?? '';
$steps = get_field('services_process_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps)): ?>
	<section class="section section-services-process" id="section-services-process">
		<div class="section-services-process__container container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($steps)): ?>
				<div class="swiper services-process-swiper"
					data-swiper='{ "slidesPerView": 1.2, "spaceBetween": 10, "breakpoints": { "480": { "slidesPerView": 2 }, "768": { "slidesPerView": 2}, "1024": { "slidesPerView": 4, "spaceBetween": 20 } } }'>
					<div class="swiper-wrapper services-process-swiper__wrapper">
						<?php foreach ($steps as $index => $step):
							$step_number =$index + 1;
							$step_title = $step['step_title'] ?? '';
							$step_descr = $step['step_descr'] ?? '';

							if (!$step_title && !$step_descr)
								continue;
							?>
							<div class="swiper-slide services-process-slide">
								<div class="services-process-slide__inner">
									<div class="process-slide__number services-process-slide__number">
										<?= esc_html($step_number); ?>
									</div>

									<?php if ($step_title): ?>
										<h3 class="services-process-slide__title title-4">
											<?= esc_html($step_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($step_descr): ?>
										<div class="services-process-slide__descr descr">
											<?= wp_kses_post($step_descr); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>