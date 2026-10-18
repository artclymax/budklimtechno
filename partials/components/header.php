<?php
$page = 'option';

$catalog_btn = get_field('header_catalog_btn', $page) ?? [];
$class = $args['class'] ?? '';
?>

<header class="header <?= esc_attr($class) ?>" data-auto-calc="header, height">
	<div class="header__top-box">

		<div class="container header__container-top">
			<div class="header__top visible-tablet">
				<?php get_template_part('partials/header-contacts'); ?>
			</div>
			<div class="header__middle">
				<div class="header__logo logo">
					<?php mx_logo(); ?>
				</div>
				<div class="header__aws aws-search hidden-tablet">
					<?php echo do_shortcode('[aws_search_form]') ?>
				</div>
				<div class="header__contacts hidden-tablet">
					<?php get_template_part('partials/header-contacts'); ?>
				</div>
				<button class="header__search-btn burger-btn-icon icon icon--search visible-tablet" type="button"
					aria-label="Поиск">
				</button>
				<a class="header__cart-btn cart-btn" href="<?php echo esc_url(home_url('/cart/')); ?>"
					arial-label="Корзина">
					<span class="cart-btn__counter" id="cart-counter" <?php echo WC()->cart->get_cart_contents_count() === 0 ? 'style="display:none;"' : ''; ?>>
						<?php echo WC()->cart->get_cart_contents_count(); ?>
					</span>
					<span class="cart-btn__icon icon icon--cart">
					</span>
				</a>
				<!-- BURGER -->
				<button class="header__burger-btn burger-btn-icon header-mobile-btn visible-tablet" type="button"
					aria-label="Открыть/закрыть меню">
					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M27 21C27.5523 21 28 21.4477 28 22C28 22.5523 27.5523 23 27 23H5C4.44772 23 4 22.5523 4 22C4 21.4477 4.44772 21 5 21H27ZM27 15C27.5523 15 28 15.4477 28 16C28 16.5523 27.5523 17 27 17H5C4.44772 17 4 16.5523 4 16C4 15.4477 4.44772 15 5 15H27ZM27 9C27.5523 9 28 9.44772 28 10C28 10.5523 27.5523 11 27 11H5C4.44772 11 4 10.5523 4 10C4 9.44772 4.44772 9 5 9H27Z"
							fill="currentColor" />
					</svg>
				</button>
			</div>
		</div>
	</div>
	<div class="header__bottom-box">
		<div class="container header__container-bottom">

			<div class="header__bottom">
					<?php if (!empty($catalog_btn)): ?>
					<a class="header__catalog-btn icon icon--catalog" href="<?php echo esc_html($catalog_btn['url']) ?>">
							<?php echo esc_html($catalog_btn['title']) ?>
					</a>
					<?php endif; ?>

				<nav class="header__menu header-menu">
					<div class="header-menu__header visible-tablet">
						<div class="header-menu__logo logo">
								<?php mx_logo(); ?>
						</div>
						<button class="header-menu__close-btn menu-close-btn" type="button" aria-label="Закрыть меню">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path
									d="M18.75 6.81984L17.1802 5.25L12 10.4302L6.81984 5.25L5.25 6.81984L10.4302 12L5.25 17.1802L6.81984 18.75L12 13.5698L17.1802 18.75L18.75 17.1802L13.5698 12L18.75 6.81984Z"
									fill="currentColor" />
							</svg>
						</button>
						<div class="header-menu__aws aws-search">
								<?php echo do_shortcode('[aws_search_form]') ?>
						</div>
					</div>
					<div class="header-menu__main-menu">
							<?php
							wp_nav_menu(array(
								'theme_location' => 'header-menu',
								'container' => false,
								'menu_class' => 'header-menu__list',
								'fallback_cb' => false,
								'depth' => 1
							));
							?>
						</div>
					<div class="header-menu__catalog-menu visible-tablet">
						<h3 class="header-menu__title">
							Каталог
						</h3>
						<?php
						wp_nav_menu(array(
							'theme_location' => 'services-menu',
							'container' => false,
							'menu_class' => 'header-menu__list catalog-menu',
							'fallback_cb' => false,
							'depth' => 1
						));
						?>
					</div>
					<div class="header-menu__item header-menu__contacts-box visible-tablet">
						<?php get_template_part('partials/contacts-box'); ?>
					</div>
				</nav>
			</div>
		</div>
	</div>
</header>