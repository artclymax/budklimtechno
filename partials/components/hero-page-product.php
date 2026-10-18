<?php
$title = get_field('hero_page_title') ?: (is_singular() ? get_the_title() : (is_archive() ? get_the_archive_title() : ''));
$descr = get_field('hero_page_descr') ?? '';
$btn = get_field('hero_page_btn') ?? [];
$small = get_field('hero_page_small') ?? '';
$image = get_field('hero_page_image') ?? null;
$image_mobile = get_field('hero_page_image_mobile') ?? null;
?>

<section class="hero-page hero-page-product" id="hero-page">
	<div class="container hero-page__container">
		<?php if (function_exists('mx_breadcrumbs')): ?>
			<div class="hero-page__breadcrumbs">
				<?php mx_breadcrumbs(['show_archive' => false]); ?>
			</div>
		<?php endif; ?>

		<div class="hero-page__content">
			<?php if ($title): ?>
				<h1 class="hero-page__title title-1">
					<?php echo wp_kses_post($title); ?>
				</h1>
			<?php endif; ?>

			<?php if ($descr): ?>
				<div class="hero-page__descr descr">
					<?php echo wp_kses_post($descr); ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($btn) && !empty($btn['url'])): ?>
				<a class="hero-page__btn btn btn--accent" href="<?php echo esc_attr($btn['url']); ?>">
					<?php echo esc_html($btn['title']); ?>
				</a>
			<?php endif; ?>

			<?php if ($small): ?>
				<small class="hero-page__small descr">
					<?php echo wp_kses_post($small); ?>
				</small>
			<?php endif; ?>
		</div>


	</div><?php if (($image && !empty($image['ID'])) || ($image_mobile && !empty($image_mobile['ID']))): ?>
		<div class="hero-page__image image-box">
			<?php if ($image && !empty($image['ID'])): ?>
				<?php echo wp_get_attachment_image(
					$image['ID'],
					'large',
					false,
					[
						'class' => 'img'. ($image_mobile && !empty($image_mobile['ID']) ? ' hidden-tablet' : ''),
						'alt' => $image['alt'] ?: $title,
					]
				); ?>
			<?php endif; ?>

			<?php if ($image_mobile && !empty($image_mobile['ID'])): ?>
				<?php echo wp_get_attachment_image(
					$image_mobile['ID'],
					'medium',
					false,
					[
						'class' => 'img visible-tablet',
						'alt' => $image_mobile['alt'] ?: $title,
						'loading' => 'lazy'
					]
				); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

</section>