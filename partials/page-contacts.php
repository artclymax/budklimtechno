<?php
$page = 'option';
$title = get_field('contacts_form_title', $page) ?? '';
$descr = get_field('contacts_form_descr', $page) ?? '';
$form = get_field('contacts_form_shortcode', $page) ?? '';
$map_title = get_field('contacts_map_title', $page) ?? '';
$map = get_field('contacts_map', $page) ?? '';
$map_card_title = get_field('contacts_map_card_title', $page) ?? '';
$map_card_text = get_field('contacts_map_card_text', $page) ?? '';
$payment_title = get_field('contacts_payment_title', $page) ?? '';
$payment = get_field('contacts_payment_blocks', $page) ?? [];

$map_card = [];
if ($map_card_title || $map_card_text) {
	$map_card = [
		'title' => $map_card_title,
		'text' => $map_card_text,
	];
}
?>

<section class="section-full page-contacts" id="page-contacts">
	<div class="container page-contacts__container">
		<div class="page-contacts__wrapper">
			<div class="page-contacts__contacts">
				<h3 class="page-contacts__title title-3">
					Как с нами связаться
				</h3>
				<?php get_template_part('partials/contacts-box'); ?>
			</div>

			<?php if ($form): ?>
				<div class="page-contacts__form form-box">
					<?php if ($title): ?>
						<h3 class="form-box__title title-3">
							<?php echo esc_html($title); ?>
						</h3>
					<?php endif; ?>
					<?php if ($descr): ?>
						<div class="form-box__descr descr">
							<?php echo wp_kses_post($descr); ?>
						</div>
					<?php endif; ?>
					<div class="form-box__form">
						<?php echo do_shortcode($form); ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($map): ?>
			<div class="page-contacts__map-box">
				<?php if ($map_title): ?>
					<h3 class="page-contacts__max-title title-3">
						<?php echo esc_html($map_title); ?>
					</h3>
				<?php endif; ?>
				<div class="page-contacts__map card-box">
					<?php echo wp_kses($map, [
						'iframe' => [
							'src' => true,
							'width' => true,
							'height' => true,
							'style' => true,
							'allowfullscreen' => true,
							'loading' => true,
						],
					]); ?>

					<?php if (!empty($map_card)): ?>
						<div class="page-contacts__map-card card-box icon icon--address map-card">
							<?php if ($map_card['title']): ?>
								<h3 class="map-card__title title-3">
									<?php echo esc_html($map_card['title']); ?>
								</h3>
							<?php endif; ?>
							<?php if ($map_card['text']): ?>
								<small class="map-card__text descr">
									<?php echo wp_kses_post($map_card['text']); ?>
								</small>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if (!empty($payment)): ?>
			<div class="page-contacts__payment page-contacts-payment">
				<?php if ($payment_title): ?>
					<h3 class="page-contacts-payment__title title-3">
						<?php echo esc_html($payment_title); ?>
					</h3>
				<?php endif; ?>
				<div class="page-contacts-payment__wrapper">
					<?php foreach ($payment as $block):
						$block_list = $block['list'] ?? [];
						if (empty($block_list))
							continue;
						?>
						<ul class="page-contacts-payment__list card-box">
							<?php foreach ($block_list as $item):
								$item_value = $item['value'] ?? '';
								$item_key = $item['key'] ?? '';
								if (!$item_value && !$item_key)
									continue;
								?>
								<li class="page-contacts-payment__item page-contacts-payment-item">
									<?php if ($item_value): ?>
										<p class="page-contacts-payment-item__value">
											<?php echo esc_html($item_value); ?>
										</p>
									<?php endif; ?>
									<?php if ($item_key): ?>
										<p class="page-contacts-payment-item__key">
											<?php echo esc_html($item_key); ?>
										</p>
									<?php endif; ?>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>