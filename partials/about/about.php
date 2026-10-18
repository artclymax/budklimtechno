<?php

$page = get_queried_object();
$title = get_field('about_title', $page) ?? '';
$descr = get_field('about_descr', $page) ?? '';
$image = get_field('about_image', $page) ?? null;
?>

<?php if ($title || $descr || ($image && is_array($image) && !empty($image['ID']))): ?>
	<section class="section about" id="about">
		<div class="container about__container">
			<div class="about__content">
				<?php if ($title): ?>
					<h2 class="about__title title-2">
						<?php echo esc_html($title); ?>
					</h2>
				<?php endif; ?>

				<?php if ($descr): ?>
					<div class="about__descr descr card-box">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="about__image image-box">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img',
							'alt' => $image['alt'] ?: $title,
							'loading' => 'lazy'
						]
					); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>