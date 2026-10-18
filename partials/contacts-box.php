<?php
$phones = get_field('contacts_phones', 'option') ?? [];
$emails = get_field('contacts_emails', 'option') ?? [];
$address = get_field('contacts_address', 'option') ?? '';
$time = get_field('contacts_time', 'option') ?? '';
?>
<div class="contacts-box">
	<?php if (!empty($phones)): ?>
		<ul class="contacts-box__list">
			<?php foreach ($phones as $phone):
				$messengers = $phone['messengers'] ?? []; ?>
				<li class="contacts-box__item contacts-box__phones icon icon--phone">
					<a class="contacts-box__link link" href="tel:+<?php echo esc_html(correct_phone($phone['phone'])); ?>">
						<?php echo esc_html($phone['phone']); ?>
					</a>
					<?php if (!empty($messengers)): ?>
						<ul class="contacts-box__messengers messengers">
							<?php foreach ($messengers as $msg): ?>
								<li class="messengers__item">
									<a class="messengers__link link-icon" href="<?= esc_attr($msg['link']['url']) ?>"
										aria-label="<?= esc_attr($msg['link']['title']) ?>">
										<?php echo wp_get_attachment_image(
											$msg['image']['ID'],
											'large',
											false,
											array(
												'class' => 'img',
												'alt' => $msg['image']['alt'] ?: ''
											)
										); ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if (!empty($emails)): ?>
		<ul class="contacts-box__list">
			<?php foreach ($emails as $email): ?>
				<li class="contacts-box__item icon icon--email">
					<a class="contacts-box__link link" href="mailto:<?php echo esc_html($email['email']); ?>">
						<?php echo esc_html($email['email']); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
	<?php if (!empty($address)): ?>
		<div class="contacts-box__content icon icon--address">
			<address class="contacts-box__descr descr">
				<?php echo wp_kses_post($address) ?>
			</address>
		</div>
	<?php endif; ?>
	<?php if (!empty($time)): ?>
		<div class="contacts-box__content icon icon--time">
			<div class="contacts-box__descr descr">
				<?php echo wp_kses_post($time) ?>
			</div>
		</div>
	<?php endif; ?>
</div>