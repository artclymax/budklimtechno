<?php
$page = 'option';
$modals = get_field('modals', $page) ?? [];
?>

<?php if ($modals): ?>
	<?php foreach ($modals as $item):
		// Санитизация ID: только латиница, цифры, дефис, нижнее подчёркивание
		$raw_id = $item['id'] ?? '';
		$id = preg_replace('/[^a-z0-9\-_]/i', '', sanitize_title($raw_id));

		// Пропускаем итерацию, если после очистки ID пустой
		if (empty($id))
			continue;

		$title = $item['title'] ?? '';
		$descr = $item['descr'] ?? '';
		$shortcode = $item['shortcode'] ?? '';
		$image = $item['image'] ?? '';
		?>

		<!-- OVERLAY -->
		<div class="modal modal-<?= esc_attr($id) ?>" id="<?= esc_attr($id) ?>" data-modal>
			<!-- MODAL -->
			<div class="modal__box modal-call__box" data-modal-box>
				<!-- CLOSE-BTN -->
				<button class="modal__close-btn modal-close-btn" data-modal-close aria-label="Закрыть модальное окно"
					type="button">
					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M25 9.09313L22.9069 7L16 13.9069L9.09313 7L7 9.09313L13.9069 16L7 22.9069L9.09313 25L16 18.0931L22.9069 25L25 22.9069L18.0931 16L25 9.09313Z"
							fill="currentColor" />
					</svg>
				</button>
				<!-- BODY -->
				<div class="modal__body">
					<div class="modal__wrapper">
						<?php if (!empty($image)): ?>
							<div class="modal__image image-box ">
								<?php echo wp_get_attachment_image(
									$image['ID'],
									'large',
									false,
									[
										'class' => 'img',
									]
								); ?>
							</div>
						<?php endif; ?>
						<div class="modal__form-box">
							<div class="modal__logo logo">
								<?php mx_logo(); ?>
							</div>
							<?php if ($title): ?>
								<h3 class="modal__title title-2">
									<?php echo esc_html($title); ?>
								</h3>
							<?php endif; ?>
							<?php if ($descr): ?>
								<div class="modal__descr descr" id="<?= esc_attr($id) ?>-desc">
									<?php echo wp_kses_post($descr) ?>
								</div>
							<?php endif; ?>
							<?php if ($shortcode): ?>
								<div class="modal__form">
									<?php echo do_shortcode($shortcode) ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
<?php endif; ?>