<?php get_header() ?>
<?php if (have_posts()): ?>
	<?php while (have_posts()):
		the_post(); ?>
		<?php get_template_part('partials/product-hero'); ?>
		<?php get_template_part('partials/product-details'); ?>
	<?php endwhile; ?>
<?php endif; ?>
<?php get_template_part('partials/section-form'); ?>
<?php get_template_part('partials/content-block', null, ['term' => get_the_terms(get_the_ID(), 'product_cat')[0]]); ?>
<?php get_template_part('partials/section-contacts'); ?>
<?php get_footer() ?>