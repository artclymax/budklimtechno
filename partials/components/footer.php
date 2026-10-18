<?php
$page = 'option';
$descr = get_field('footer_descr', $page) ?: get_bloginfo('description') ?? '';
$content = get_field('footer_content', $page) ?? '';
$copy = get_field('footer_copy', $page) ?: '';
$links = get_field('footer_links', $page) ?? '';
$company = get_field('footer_company', $page) ?: get_bloginfo('name') ?? '';

?>

<footer class="footer">
	<div class="footer__container container">
		<div class="footer__top">
			<div class="footer__info">
				<div class="footer__logo logo">
					<?php mx_logo(); ?>
				</div>
				<div class="footer__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			</div>
			<nav class="footer__menu footer-col">
				<div class="footer-spoiler" data-spoiler>
					<button class="footer-spoiler__btn" data-spoiler-title>
						<h3 class="footer-spoiler__title">
							Навигация
						</h3>
						<span class="footer-spoiler__icon"></span>
					</button>
					<div class="footer-spoiler__content" data-spoiler-content>
						<div class="footer-spoiler__wrapper">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'footer-menu',
									'container' => false,
									'menu_class' => 'footer-menu',
									'depth' => 1
								)
							); ?>
						</div>
					</div>
				</div>
			</nav>
			<nav class="footer__menu footer-col">
				<div class="footer-spoiler" data-spoiler>
					<button class="footer-spoiler__btn" data-spoiler-title>
						<h3 class="footer-spoiler__title">
							Каталог
						</h3>
						<span class="footer-spoiler__icon"></span>
					</button>
					<div class="footer-spoiler__content" data-spoiler-content>
						<div class="footer-spoiler__wrapper">
							<?php
							wp_nav_menu(
								array(
									'theme_location' => 'services-menu',
									'container' => false,
									'menu_class' => 'footer-menu',
									'depth' => 1
								)
							); ?>
						</div>
					</div>
				</div>
			</nav>
			<div class="footer-col footer__contacts-box">
				<div class="footer-spoiler" data-spoiler>
					<button class="footer-spoiler__btn" data-spoiler-title>
						<h3 class="footer-spoiler__title">
							Контакты
						</h3>
						<span class="footer-spoiler__icon"></span>
					</button>
					<div class="footer-spoiler__content" data-spoiler-content>
						<div class="footer-spoiler__wrapper">
							<?php get_template_part('partials/contacts-box'); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if (!empty($content)): ?>
			<div class="footer__middle">
				<div class="footer__content descr">
					<?php echo wp_kses_post($content) ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="footer__bottom">
			<div class="footer__links">
				<?php if ($links): ?>
					<?php foreach ($links as $item): ?>
						<a class="footer__link link" href="<?php echo esc_attr($item['footer_links_link']['url'] ?? '') ?>"
							target="_blank">
							<?php echo esc_html($item['footer_links_link']['title'] ?? '') ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
			<?php if ($copy || $company): ?>
				<div class="footer__copy">
					&copy;
					<?php echo esc_html($company) . ', ' . date('Y') . '. ' . esc_html($copy) ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>