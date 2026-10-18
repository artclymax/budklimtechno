<?php
$page = 'options';

$title = get_field('thank_you_title', $page) ?? get_the_title();
$descr = get_field('thank_you_descr', $page) ?? '';
$btn = get_field('thank_you_btn', $page) ?? '';
$btn_second = get_field('thank_you_btn_second', $page) ?? '';
$note = get_field('thank_you_note', $page) ?? '';
$image = get_field('thank_you_image', $page) ?? '';
?>
<section class="hero-404 hero-thank-you" id="hero-thank-you">
	<div class="container hero-404__container">
		<div class="hero-404__wrapper">
			<h1 class="hero-404__title title-2">
				<?php echo esc_html($title) ?>
			</h1>
			<div class="hero-404__descr descr">
				<?php echo wp_kses_post($descr) ?>
			</div>
			<div class="hero-404__btn-box">
				<?php if (!empty($btn)): ?>
					<a class="btn btn--accent hero-404__btn" href="<?php echo esc_html($btn['url'] ?? '') ?>">
						<?php echo esc_html($btn['title'] ?? '') ?>
					</a>
				<?php endif; ?>
				<?php if (!empty($btn_second)): ?>
					<a class="btn hero-404__btn" href="<?php echo esc_html($btn_second['url'] ?? '') ?>">
						<?php echo esc_html($btn_second['title'] ?? '') ?>
					</a>
				<?php endif; ?>
			</div>
			<?php if (!empty($note)): ?>
				<small class="hero-404__note descr">
					<?php echo wp_kses_post($note) ?>
				</small>
			<?php endif; ?>
		</div>
	</div>
	<?php if (!empty($image)): ?>
		<div class="hero-404__image image-box">
			<?php echo wp_get_attachment_image(
				$image['ID'],
				'large',
				false,
				array(
					'class' => 'img',
					'alt' => $image['alt'] ?: ''
				)
			); ?>
		</div>
	<?php endif; ?>
</section>