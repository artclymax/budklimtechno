<?php
$page = get_queried_object();
$slides = get_field('slider_slides', $page) ?? [];
?>

<?php if (!empty($slides) && is_array($slides)): ?>
	<section class="section section-slider" id="section-slider">
		<div class="swiper section-slider-swiper"
			data-swiper='{"rewind": true, "loop": false, "autoplay": {"delay": 5000, "disableOnInteraction": false}}'>
			<div class="swiper-wrapper section-slider-swiper__wrapper">
				<?php foreach ($slides as $slide):
					$label = $slide['label'] ?? '';
					$title = $slide['title'] ?? '';
					$descr = $slide['descr'] ?? '';
					$btn = $slide['btn'] ?? [];
					$image = $slide['image'] ?? null;
					$image_mobile = $slide['image_mobile'] ?? null;

					// Пропускаем пустые слайды
					if (!$title && !$descr && (!$image || empty($image['ID'])) && (!$image_mobile || empty($image_mobile['ID']))) {
						continue;
					}
					?>
					<div class="swiper-slide section-slider-slide home-hero-slide">
						<div class="home-hero-slide__container container">
							<div class="home-hero-slide__wrapper">
								<div class="home-hero-slide__content">
									<?php if ($label): ?>
										<p class="home-hero-slide__label">
											<?php echo esc_html($label); ?>
										</p>
									<?php endif; ?>

									<?php if ($title): ?>
										<h3 class="home-hero-slide__title title-2">
											<?php echo esc_html($title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($descr): ?>
										<div class="home-hero-slide__descr descr">
											<?php echo wp_kses_post($descr); ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($btn) && is_array($btn) && !empty($btn['url'])): ?>
										<a class="home-hero-slide__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php echo !empty($btn['target']) ? 'target="' . esc_attr($btn['target']) . '"' : ''; ?>>
											<?php echo esc_html($btn['title'] ?? 'Подробнее'); ?>
										</a>
									<?php endif; ?>
								</div>
							</div>

							<?php if (($image && is_array($image) && !empty($image['ID'])) || ($image_mobile && is_array($image_mobile) && !empty($image_mobile['ID']))): ?>
								<div class="home-hero-slide__image image-box">
									<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
										<?php echo wp_get_attachment_image(
											$image['ID'],
											'full',
											false,
											[
												'class' => 'img' . ($image_mobile && !empty($image_mobile['ID']) ? ' hidden-mobile' : ''),
												'alt' => $image['alt'] ?: $title,
												'loading' => 'lazy'
											]
										); ?>
									<?php endif; ?>

									<?php if ($image_mobile && is_array($image_mobile) && !empty($image_mobile['ID'])): ?>
										<?php echo wp_get_attachment_image(
											$image_mobile['ID'],
											'full',
											false,
											[
												'class' => 'img' . ($image && !empty($image['ID']) ? ' visible-mobile' : ''),
												'alt' => $image_mobile['alt'] ?: $title,
												'loading' => 'lazy'
											]
										); ?>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if (count($slides) > 1): ?>
				<div class="swiper-pagination section-slider__pagination" data-swiper-pagination=".section-slider-swiper"></div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>