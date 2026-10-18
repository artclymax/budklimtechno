<?php get_header(null, ['class' => 'header-absolute']); ?>
<?php get_template_part('partials/components/hero-page-simple') ?>

<?php if (have_posts()): ?>
	<?php while (have_posts()):
		the_post(); ?>
		<section class="section index-section">
			<div class="container descr ">
				<?php the_content(); ?>
			</div>
		</section>
	<?php endwhile; ?>
<?php else: ?>
	<section class="section index-section">
		<div class="container descr ">
			<p>Записей не найдено.</p>
		</div>
	</section>
<?php endif; ?>


<?php get_footer(); ?>