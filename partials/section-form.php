<?php
$page = get_page_by_path('home', OBJECT, 'page');

$title = get_field('section_form_title') ?: get_field('section_form_title', $page) ?? '';
$descr = get_field('section_form_descr') ?: get_field('section_form_descr', $page) ?? '';
$form = get_field('section_form_form') ?: get_field('section_form_form', $page) ?? '';
$image = get_field('section_form_image') ?: get_field('section_form_image', $page) ?? null;
$image_mobile = get_field('section_form_image_mobile') ?: get_field('section_form_image_mobile', $page) ?? null;
?>

<?php if ($title || $descr || $form || ($image && !empty($image['ID'])) || ($image_mobile && !empty($image_mobile['ID']))): ?>
	<section class="section-form" id="section-form">
		<div class="container section-form__container">
			<div class="section-form__wrapper">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'descr' => $descr
				]); ?>

				<?php if ($form): ?>
					<div class="section-form__form">
						<?php echo do_shortcode($form); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<?php if (($image && !empty($image['ID'])) || ($image_mobile && !empty($image_mobile['ID']))): ?>
			<div class="section-form__image image-box">

				<?php if ($image && !empty($image['ID'])): ?>
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						[
							'class' => 'img' . (!empty($image_mobile['ID']) ? ' hidden-mobile' : ''),
							'alt' => $image['alt'] ?: $title,
							'loading' => 'lazy'
						]
					); ?>
				<?php endif; ?>

				<?php if ($image_mobile && !empty($image_mobile['ID'])): ?>
					<?php echo wp_get_attachment_image(
						$image_mobile['ID'],
						'large',
						false,
						[
							'class' => 'img' . (!empty($image['ID']) ? ' visible-mobile' : ''),
							'alt' => $image_mobile['alt'] ?: $title,
							'loading' => 'lazy'
						]
					); ?>
				<?php endif; ?>

			</div>
		<?php endif; ?>

	</section>
<?php endif; ?>