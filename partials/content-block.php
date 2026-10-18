<?php
$title = get_field('content_block_title') ?? get_the_title();
$content = get_field('content_block_descr') ?? '';
$term = $args['term'] ?? '';


if ($term) {
	$title = get_field('content_block_title', $term->taxonomy . '_' . $term->term_id) ?? '';
	$content = get_field('content_block_descr', $term->taxonomy . '_' . $term->term_id) ?? '';
}

if (is_archive()) {
	$slug = get_queried_object()->has_archive;
	$page = get_page_by_path($slug, OBJECT, 'page');

	$title = get_field('content_block_title', $page) ?? get_the_archive_title() ?? get_the_title() ?? '';
	$content = get_field('content_block_descr', $page) ?? '';
}

if (is_tax()) {
	$term = get_queried_object();
	$title = get_field('content_block_title', $term->taxonomy . '_' . $term->term_id) ?? '';
	$content = get_field('content_block_descr', $term->taxonomy . '_' . $term->term_id) ?? '';
}
?>
<?php if (!empty($content)): ?>
	<section class="section content-block" id="content-block">
		<div class="container content-block__container">
			<div class="content-block__wrapper card-box">
				<h2 class="content-block__title title-4">
					<?php echo esc_html($title) ?>
				</h2>
				<?php if (!empty($content)): ?>
					<div class="content-block__descr descr">
						<?php echo wp_kses_post($content) ?>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</section>
<?php endif; ?>