<?php
$title = get_field('hero_title') ?: get_the_title() ?: '';
$descr = get_field('hero_descr') ?? '';
$btn = get_field('hero_btn') ?? '';
$image = get_field('hero_image') ?? '';
?>
<section class="hero-page hero-single-news" id="hero-single-news">
	<div class="container hero-page__container">
		<div class="hero-page__breadcrumbs page-breadcrumbs">
			<?php woocommerce_breadcrumb(['delimiter' => '']); ?>
		</div>
		<div class="hero-page__content">
			<h1 class="hero-page__title title-2">
				<?php the_title(); ?>
			</h1>
			<?php if (has_excerpt()): ?>
				<div class="hero-page__descr descr">
					<?php the_excerpt(); ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
	<?php if (has_post_thumbnail()): ?>
		<div class="hero-page__image image-box">
			<?php the_post_thumbnail(); ?>
		</div>
	<?php endif; ?>
</section>