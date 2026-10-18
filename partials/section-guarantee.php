<?php
$page = get_queried_object();
$title = get_field('guarantee_title', $page) ?? '';
$descr = get_field('guarantee_descr', $page) ?? '';
?>

<?php if ($title || $descr): ?>
	<section class="section section-guarantee" id="section-guarantee">
		<div class="container section-guarantee__container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>
		</div>
	</section>
<?php endif; ?>