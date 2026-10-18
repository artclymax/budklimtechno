<?php
$phones = get_field('contacts_phones', 'option') ?? [];
?>
<?php if (!empty($phones)): ?>
	<ul class="header-contacts">
		<?php foreach ($phones as $phone):
			$messengers = $phone['messengers'] ?? [];
			?>
			<li class="header-contacts__item">
				<?php if (!empty($messengers)): ?>
					<ul class="header-contacts__messengers messengers">
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
				<a class="header-contacts__phone icon icon--phone link"
					href="tel:+<?php echo esc_html(correct_phone($phone['phone'])); ?>">
					<?php echo esc_html($phone['phone']); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>