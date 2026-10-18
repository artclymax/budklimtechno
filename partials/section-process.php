<?php
$page = get_page_by_path('home', OBJECT, 'page');
$label = get_field('process_label') ?: get_field('process_label', $page) ?? '';
$title = get_field('process_title') ?: get_field('process_title', $page) ?? '';
$descr = get_field('process_descr') ?: get_field('process_descr', $page) ?? '';
$steps = get_field('process_steps') ?: get_field('process_steps', $page) ?? [];
?>

<?php if ($title || $descr || !empty($steps)): ?>
	<section class="section section-process" id="section-process">
		<div class="section-process__container container">
			<?php get_template_part('partials/section-header', null, [
				'label' => $label,
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($steps)): ?>
				<div class="swiper process-swiper"
					data-swiper='{ "slidesPerView": 2, "breakpoints": { "768": { "slidesPerView": 3 }, "1024": { "slidesPerView": 4 } } }'>
					<div class="swiper-wrapper process-swiper__wrapper">
						<?php foreach ($steps as $index => $step):
							$step_number = ++$index;
							$step_icon = $step['step_icon'] ?? null;
							$step_title = $step['step_title'] ?? '';
							$step_descr = $step['step_descr'] ?? '';

							if (!$step_title && !$step_descr)
								continue;
							?>
							<div class="swiper-slide process-slide">
								<div class="process-slide__inner">
									<div class="process-slide__header">
										<div class="process-slide__number">
											<?= esc_html($step_number); ?>
										</div>
										<?php if ($step_icon && is_array($step_icon) && !empty($step_icon['ID'])): ?>
											<div class="process-slide__icon">
												<?php echo wp_get_attachment_image(
													$step_icon['ID'],
													'medium',
													false,
													[
														'class' => 'process-slide__icon-img',
														'alt' => $step_icon['alt'] ?: $step_title,
														'loading' => 'lazy'
													]
												); ?>
											</div>
										<?php endif; ?>
									</div>

									<?php if ($step_title): ?>
										<h3 class="process-slide__title title-4">
											<?= esc_html($step_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($step_descr): ?>
										<div class="process-slide__descr descr">
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