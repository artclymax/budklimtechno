<?php
$categories = get_terms([
	'taxonomy' => 'product_cat',
	'parent' => 0,
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);
?>
<section class="section section-category" id="section-category">
	<div class="container section-category__container">
		<h2 class="section-category__title title-3">
			Выберите направление
		</h2>
		<?php if (!empty($categories) && !is_wp_error($categories)): ?>
			<ul class="section-category__list grid">
				<?php foreach ($categories as $category):
					$term_link = get_term_link($category);
					$image_id = get_term_meta($category->term_id, 'thumbnail_id', true);

					if (is_wp_error($term_link))
						continue;
					?>
					<li class="section-category__item section-category-item">
						<a class="section-category-item__link card-box" href="<?php echo esc_url($term_link); ?>">
							<div class="section-category-item__image image-box">
								<?php echo wp_get_attachment_image(
									$image_id,
									'large',
									false,
									array(
										'class' => 'img',
										'alt' => $category->name,
										'loading' => 'lazy'
									)
								); ?>
							</div>
							<h3 class="section-category-item__title">
								<?php echo esc_html($category->name) ?>
							</h3>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>