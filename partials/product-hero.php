<?php

if (!defined('ABSPATH')) {
	exit;
}

// ACF поля
$btn = get_field('page_product_btn', 'option') ?? '';

global $product;

// Получаем изображения
$main_image_id = get_post_thumbnail_id($product->get_id());
$gallery_ids = $product->get_gallery_image_ids();

// Все изображения (главное + галерея)
$all_images = array_merge([$main_image_id], $gallery_ids);
$all_images = array_filter($all_images); // убираем пустые
?>


<section class="section product-hero" id="product-hero">
	<div class="container product-hero__container">

		<!-- Breadcrumbs -->
		<div class="hero-page__breadcrumbs page-breadcrumbs">
			<?php woocommerce_breadcrumb(['delimiter' => '']); ?>
		</div>

		<div class="product-hero__wrapper">

			<!-- ========== ГАЛЕРЕЯ ========== -->
			<div class="product-hero__gallery-wrapper card-box">
				<?php if (!empty($all_images)): ?>

					<!-- Main gallery -->
					<div class="swiper product-hero-gallery">
						<div class="swiper-wrapper product-hero-gallery__wrapper">
							<?php foreach ($all_images as $image_id):
								$full_src = wp_get_attachment_image_url($image_id, 'full');
								$large_src = wp_get_attachment_image_url($image_id, 'large');
								$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
								?>
								<div class="swiper-slide product-hero-gallery-slide">
									<a class="product-hero-gallery-slide__wrapper image-box" data-fancybox="product-gallery"
										href="<?php echo esc_url($full_src); ?>">
										<img src="<?php echo esc_url($large_src); ?>" alt="<?php echo esc_attr($alt); ?>"
											loading="lazy">
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					</div>

					<!-- Thumbs -->
					<?php if (count($all_images) > 1): ?>
						<div class="product-hero__wrapper-thumbs">
							<div class="swiper product-hero-thumbs">
								<div class="swiper-wrapper product-hero-thumbs__wrapper">
									<?php foreach ($all_images as $image_id):
										$thumb_src = wp_get_attachment_image_url($image_id, 'thumbnail');
										$alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
										?>
										<div class="swiper-slide product-hero-thumbs-slide">
											<div class="product-hero-thumbs-slide__wrapper image-box">
												<img src="<?php echo esc_url($thumb_src); ?>" alt="<?php echo esc_attr($alt); ?>"
													loading="lazy">
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<button class="swiper-btn swiper-btn__prev product-hero-thumbs__btn product-hero-thumbs__btn-prev"
								type="button" aria-label="Назад"></button>
							<button class="swiper-btn swiper-btn__next product-hero-thumbs__btn product-hero-thumbs__btn-next"
								type="button" aria-label="Вперёд"></button>
						</div>
					<?php endif; ?>

				<?php else: ?>
					<!-- Заглушка, если нет изображений -->
					<div class="product-hero-gallery">
						<img src="<?php echo esc_url(wc_placeholder_img_src('large')); ?>"
							alt="<?php echo esc_attr(get_the_title()); ?>">
					</div>
				<?php endif; ?>
			</div>

			<!-- ========== КОНТЕНТ ========== -->
			<div class="product-hero__content">

				<!-- Категории -->
				<?php
				$category_list = get_the_term_list(
					$product->get_id(),
					'product_cat',
					'<li>',
					'</li><li>',
					'</li>'
				);
				if ($category_list && !is_wp_error($category_list)):
					?>
					<ul class="product-hero__category">
						<?php echo $category_list; // WPCS: XSS ok. ?>
					</ul>
				<?php endif; ?>

				<!-- Заголовок -->
				<h1 class="product-hero__title title-3">
					<?php the_title(); ?>
				</h1>

				<!-- Краткое описание -->
				<div class="product-hero__excerpt descr">
					<?php the_excerpt(); ?>
				</div>

				<!-- Цена (нативная функция WooCommerce) -->
				<div class="product-hero__price">
					<?php woocommerce_template_single_price(); ?>
				</div>

				<!-- Вариации + кнопка "В корзину" (нативная функция WooCommerce) -->
				<div class="product-hero__variations">
					<?php woocommerce_template_single_add_to_cart(); ?>
				</div>

				<!-- Кнопка консультации из ACF -->
				<?php if (!empty($btn) && !empty($btn['url'])): ?>
					<div class="product-hero__buttons">
						<a class="product-hero__btn btn" href="<?php echo esc_url($btn['url']); ?>">
							<?php echo esc_html($btn['title']); ?>
						</a>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>