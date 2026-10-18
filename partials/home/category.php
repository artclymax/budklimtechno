<?php
$page = get_page_by_path('home', OBJECT, 'page');

$title = get_field('home_category_title') ?: get_field('home_category_title') ?? '';
$descr = get_field('home_category_descr') ?: get_field('home_category_descr', $page) ?? '';

// 1. Получаем выбранные категории из ACF
$selected_cats = get_field('home_category_selected') ?: get_field('home_category_selected', $page) ?? [];

// 2. Если ничего не выбрано — берём 4 последние категории верхнего уровня
if (empty($selected_cats) || is_wp_error($selected_cats)) {
	$categories = get_terms([
		'taxonomy' => 'product_cat',
		'parent' => 0,
		'hide_empty' => false,
		'number' => 4,
		'orderby' => 'date',
		'order' => 'DESC',
	]);
} else {
	$categories = $selected_cats;
}
?>

<?php if ($title || $descr || (!empty($categories) && !is_wp_error($categories))): ?>
	<section class="section home-category" id="home-category">
		<h2 class="visually-hidden">
			<?php echo esc_html($title ?: 'Категории'); ?>
		</h2>
		<div class="container home-category__container">

			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($categories) && !is_wp_error($categories)): ?>
				<ul class="home-category__list grid">
					<?php foreach ($categories as $category):
						$term_link = get_term_link($category);
						$image_id = get_term_meta($category->term_id, 'thumbnail_id', true);

						if (is_wp_error($term_link))
							continue;
						?>
						<li class="home-category__item home-category-item">
							<a class="home-category-item__link card-box" href="<?php echo esc_url($term_link); ?>">
								<div class="home-category-item__image image-box">
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
								<h3 class="home-category-item__title title-5">
									<?php echo esc_html($category->name) ?>
								</h3>
								<div class="home-category-item__descr descr">
									<?php echo wp_kses_post($category->description); ?>
								</div>
								<span class="home-category-item__btn icon icon--link"></span>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>
	</section>
<?php endif; ?>