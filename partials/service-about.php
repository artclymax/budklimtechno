<?php
$page = get_queried_object();
$title = get_field('service_about_title', $page) ?? '';
$descr = get_field('service_about_descr', $page) ?? '';
$list = get_field('service_about_list', $page) ?? [];
?>

<?php if ($title || $descr || !empty($list)): ?>
	<section class="section service-about" id="service-about">
		<div class="container service-about__container">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr
			]); ?>

			<?php if (!empty($list)): ?>
				<ul class="service-about__list card-box">
					<?php foreach ($list as $item):
						$item_descr = $item['descr'] ?? '';
						if (!$item_descr)
							continue;
						?>
						<li class="service-about__item service-about-item descr icon icon--check">
							<?php echo wp_kses_post($item_descr); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>