<?php
$page = get_queried_object();
$blocks = get_field('purchase_info_blocks', $page) ?? [];
?>

<?php if (!empty($blocks)): ?>
	<section class="section purchase-info" id="purchase-info">
		<div class="container purchase-info__container">
			<?php foreach ($blocks as $block):
				$block_title = $block['block_title'] ?? '';
				$block_list = $block['block_list'] ?? [];

				if (!$block_title && empty($block_list))
					continue;
				?>
				<div class="purchase-info__content">
					<?php if ($block_title): ?>
						<?php get_template_part('partials/section-header', null, [
							'title' => $block_title
						]); ?>
					<?php endif; ?>

					<?php if (!empty($block_list)): ?>
						<ul class="purchase-info__list">
							<?php foreach ($block_list as $item):
								$item_icon = $item['item_icon'] ?? null;
								$item_title = $item['item_title'] ?? '';
								$item_descr = $item['item_descr'] ?? '';

								if (!$item_title && !$item_descr)
									continue;
								?>
								<li class="purchase-info__item purchase-info-item">
									<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
										<div class="purchase-info-item__icon">
											<?php echo wp_get_attachment_image(
												$item_icon['ID'],
												'thumbnail',
												false,
												[
													'class' => 'img',
													'alt' => $item_icon['alt'] ?: $item_title,
													'loading' => 'lazy'
												]
											); ?>
										</div>
									<?php endif; ?>

									<?php if ($item_title): ?>
										<h3 class="purchase-info-item__title">
											<?php echo esc_html($item_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($item_descr): ?>
										<div class="purchase-info-item__descr descr">
											<?php echo wp_kses_post($item_descr); ?>
										</div>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</section>
<?php endif; ?>