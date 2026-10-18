<?php
// Получаем массив слайдов и группу с телефоном
$slides = get_field('home_hero_slides');
$phone = get_field('home_hero_phone');
?>

<section class="section home-hero" id="home-hero">
	<h1 class="visually-hidden">
		<?php the_title(); ?>
	</h1>
	<div class="container home-hero__container">
		<div class="swiper home-hero-swiper" data-swiper="{'rewind': true}">
			<div class="swiper-wrapper home-hero-swiper__wrapper">

				<?php if (!empty($slides) && is_array($slides)): ?>
					<?php foreach ($slides as $slide):
						// Извлекаем переменные для каждого слайда
						$label = $slide['label'] ?? '';
						$title = $slide['title'] ?? '';
						$descr = $slide['descr'] ?? '';
						$btn = $slide['btn'] ?? [];
						$image = $slide['image'] ?? [];
						$image_mobile = $slide['image_mobile'] ?? [];
						?>
						<div class="swiper-slide home-hero-slide">
							<div class="home-hero-slide__wrapper">
								<div class="home-hero-slide__content">
									<?php if (!empty($label)): ?>
										<p class="home-hero-slide__label">
											<?php echo esc_html($label); ?>
										</p>
									<?php endif; ?>

									<?php if (!empty($title)): ?>
										<h3 class="home-hero-slide__title title-2">
											<?php echo esc_html($title); ?>
										</h3>
									<?php endif; ?>

									<?php if (!empty($descr)): ?>
										<div class="home-hero-slide__descr descr">
											<?php echo wp_kses_post($descr) ?>
										</div>
									<?php endif; ?>

									<?php if (!empty($btn)): ?>
										<a class="home-hero-slide__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php echo !empty($btn['target']) ? 'target="' . esc_attr($btn['target']) . '"' : ''; ?>>
											<?php echo esc_html($btn['title']); ?>
										</a>
									<?php endif; ?>
								</div>

								<?php if (!empty($image) || !empty($image_mobile)): ?>
									<div class="home-hero-slide__image image-box">
										<?php if (!empty($image)): ?>
											<?php echo wp_get_attachment_image(
												$image['ID'],
												'full',
												false,
												array(
													'class' => 'img' . ($image_mobile && !empty($image_mobile['ID']) ? ' hidden-mobile' : ''),
													'alt' => $image['alt'] ?: $title ?? ''
												)
											); ?>
										<?php endif; ?>

										<?php if (!empty($image_mobile)): ?>
											<?php echo wp_get_attachment_image(
												$image_mobile['ID'],
												'full',
												false,
												array(
													'class' => 'img' . ($image && !empty($image['ID']) ? ' visible-mobile' : ''),
													'alt' => $image_mobile['alt'] ?: $title ?? '',
													'loading' => 'lazy'
												)
											); ?>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>

			</div>
			<div class="swiper-pagination home-hero-swiper__pagination" data-swiper-pagination=".home-hero-swiper"></div>
		</div>
	</div>

	<div class="container home-hero__container-phone-btn">
		<?php if (!empty($phone)): ?>
			<a class="home-hero__phone" href="tel:+<?php echo esc_attr(correct_phone($phone)) ?>"
				aria-label="Позвонить по номеру <?php echo esc_attr($phone) ?>">
				<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path
						d="M31.3112 23.561V28.2044C31.313 28.6355 31.2245 29.0622 31.0514 29.4572C30.8784 29.8521 30.6246 30.2067 30.3063 30.4981C29.9881 30.7895 29.6123 31.0114 29.2031 31.1495C28.794 31.2876 28.3604 31.3389 27.9302 31.3001C23.1579 30.7826 18.5737 29.155 14.546 26.5483C10.7988 24.1718 7.62178 21.0011 5.24064 17.2613C2.61959 13.2234 0.988456 8.626 0.479385 3.84169C0.440629 3.41367 0.491598 2.98228 0.629047 2.57499C0.766496 2.1677 0.987413 1.79344 1.27773 1.47603C1.56805 1.15862 1.92142 0.905019 2.31532 0.731373C2.70923 0.557727 3.13505 0.46784 3.56567 0.467435H8.21836C8.97102 0.460042 9.70069 0.726043 10.2714 1.21586C10.8421 1.70567 11.2148 2.38588 11.3201 3.12969C11.5165 4.61571 11.8807 6.07478 12.4058 7.47908C12.6144 8.03308 12.6596 8.63517 12.5359 9.214C12.4122 9.79283 12.1249 10.3241 11.7079 10.745L9.73824 12.7107C11.946 16.5858 15.1609 19.7942 19.0436 21.9977L21.0133 20.0319C21.4349 19.6158 21.9673 19.329 22.5473 19.2055C23.1273 19.0821 23.7305 19.1272 24.2856 19.3354C25.6927 19.8594 27.1547 20.2229 28.6437 20.4189C29.397 20.525 30.0851 20.9037 30.5769 21.483C31.0687 22.0623 31.3301 22.8019 31.3112 23.561Z"
						fill="currentColor" stroke="currentColor" stroke-width="0.934708" stroke-linecap="round"
						stroke-linejoin="round" />
				</svg>
			</a>
		<?php endif; ?>
	</div>
</section>