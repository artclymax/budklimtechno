<?php
$content = apply_filters('the_content', get_the_content());

?>
<?php if (!empty($content)): ?>
	<section class="section page-content" id="page-content">
		<h2 class="visually-hidden">
			<?php the_title(); ?>
		</h2>
		<div class="container page-content__container">
			<div class="page-content__descr descr">
				<?php echo wp_kses_post($content) ?>
			</div>
		</div>
	</section>
<?php endif; ?>