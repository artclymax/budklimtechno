<?php
/**
 * Template Name: Custom Checkout
 * 
 * Кастомная страница оформления заказа
 */

defined('ABSPATH') || exit;

// Проверяем, есть ли товары в корзине
if (WC()->cart->is_empty()) {
	wp_redirect(wc_get_page_permalink('shop'));
	exit;
}

$term_link = get_field('checkout_term_link') ?? get_permalink(get_option('woocommerce_terms_page_id'));
$payment_note = get_field('checkout_payment_note') ?? 'После отправки заказа менеджер свяжется с вами для уточнения стоимости, наличия и условий поставки.';
$btn = get_field('checkout_btn') ?? [];

get_header(); ?>

<div class="checkout">
	<div class="checkout__container container">
		<div class="checkout__hero checkout-hero">
			<div class="checkout-hero__breadcrumbs page-breadcrumbs">
				<?php woocommerce_breadcrumb(['delimiter' => '']); ?>
			</div>
			<h1 class="checkout-hero__title title-2">Оформление заказа</h1>
		</div>


		<form class="checkout__form" id="checkout-form" novalidate>

			<?php wp_nonce_field('custom_checkout', 'checkout_nonce'); ?>

			<div class="checkout__layout">

				<!-- ЛЕВАЯ КОЛОНКА: ФОРМА -->
				<div class="checkout__main">

					<!-- Блок 1: Контактные данные -->
					<div class="checkout__section card-box">
						<h2 class="checkout__section-title title-3">Контактные данные</h2>
						<div class="checkout__fields checkout__fields-grid">
							<div class="checkout__field">
								<label class="checkout__label" for="checkout-name">
									Ваше имя <span class="checkout__required">*</span>
								</label>
								<input type="text" id="checkout-name" name="customer_name" class="checkout__input"
									placeholder="Иван Иванов" required>
								<span class="checkout__error" data-error="customer_name"></span>
							</div>

							<div class="checkout__field">
								<label class="checkout__label" for="checkout-phone">
									Телефон <span class="checkout__required">*</span>
								</label>
								<input type="tel" id="checkout-phone" name="customer_phone" class="checkout__input"
									placeholder="+375 (29) 123-45-67" required>
								<span class="checkout__error" data-error="customer_phone"></span>
							</div>

							<div class="checkout__field">
								<label class="checkout__label" for="checkout-email">
									E-mail <span class="checkout__required">*</span>
								</label>
								<input type="email" id="checkout-email" name="customer_email" class="checkout__input"
									placeholder="example@mail.com" required>
								<span class="checkout__error" data-error="customer_email"></span>
							</div>

							<div class="checkout__field">
								<label class="checkout__label" for="checkout-comment">
									Комментарий (не обязательно)
								</label>
								<textarea id="checkout-comment" name="customer_comment" class="checkout__textarea"
									placeholder="Дополнительная информация к заказу" rows="4"></textarea>
							</div>
						</div>
					</div>

					<!-- Блок 2: Способ получения -->
					<div class="checkout__section card-box">
						<h2 class="checkout__section-title title-3">Способ получения</h2>

						<div class="checkout__radio-group">
							<label class="checkout__radio">
								<input type="radio" name="delivery_method" value="manager" class="checkout__radio-input"
									checked>
								<span class="checkout__radio-mark"></span>
								<span class="checkout__radio-text">Согласовать с менеджером</span>
							</label>

							<label class="checkout__radio">
								<input type="radio" name="delivery_method" value="delivery" class="checkout__radio-input">
								<span class="checkout__radio-mark"></span>
								<span class="checkout__radio-text">Доставка до объекта</span>
							</label>
						</div>

						<!-- Дополнительные поля для доставки -->
						<div class="checkout__delivery-fields checkout__fields-grid" id="delivery-fields"
							style="display: none;">
							<div class="checkout__field">
								<label class="checkout__label" for="checkout-city">
									Город <span class="checkout__required">*</span>
								</label>
								<input type="text" id="checkout-city" name="delivery_city" class="checkout__input"
									placeholder="Минск">
								<span class="checkout__error" data-error="delivery_city"></span>
							</div>

							<div class="checkout__field">
								<label class="checkout__label" for="checkout-address">
									Адрес <span class="checkout__required">*</span>
								</label>
								<input type="text" id="checkout-address" name="delivery_address" class="checkout__input"
									placeholder="пр-т Независимости, 1">
								<span class="checkout__error" data-error="delivery_address"></span>
							</div>

							<div class="checkout__field checkout__field--wide">
								<label class="checkout__label" for="delivery-info">
									Дополнительная информация
								</label>
								<textarea id="delivery-info" name="delivery_info" class="checkout__textarea"
									placeholder="Код домофона, этаж, время доставки" rows="3"></textarea>
							</div>
						</div>
					</div>

					<!-- Блок 3: Способ оплаты -->
					<div class="checkout__section card-box">
						<h2 class="checkout__section-title title-3">Способ оплаты</h2>

						<div class="checkout__radio-group">
							<label class="checkout__radio">
								<input type="radio" name="payment_method" value="bank_transfer" class="checkout__radio-input"
									checked>
								<span class="checkout__radio-mark"></span>
								<span class="checkout__radio-text">Безналичный расчёт</span>
							</label>
						</div>

						<p class="checkout__payment-note">
							<?php echo esc_html($payment_note) ?>
						</p>
					</div>

				</div>

				<!-- ПРАВАЯ КОЛОНКА: СОСТАВ ЗАКАЗА -->
				<div class="checkout__sidebar">
					<div class="checkout-summary card-box">

						<h2 class="checkout-summary__title title-3">Состав заказа</h2>

						<!-- Товары -->
						<div class="checkout-summary__items">
							<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
								$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

								if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0) {
									continue;
								}

								$product_id = $cart_item['product_id'];
								$categories = get_the_terms($product_id, 'product_cat');
								$category_name = '';

								if ($categories && !is_wp_error($categories)) {
									$category_name = $categories[0]->name;
								}
								?>
								<div class="checkout-summary__item card-box">
									<div class="checkout-summary__thumbnail">
										<?php echo $_product->get_image('thumbnail'); ?>
									</div>
									<div class="checkout-summary__info">
										<?php if ($category_name): ?>
											<div class="checkout-summary__category">
												<?php echo esc_html($category_name); ?>
											</div>
										<?php endif; ?>
										<div class="checkout-summary__name">
											<?php echo esc_html($_product->get_name()); ?>
										</div>
									</div>
									<span class="checkout-summary__price">
										<?php echo WC()->cart->get_product_price($_product); ?>
									</span>
								</div>
							<?php endforeach; ?>
						</div>

						<!-- Итого -->
						<div class="checkout-summary__total">
							<span>Товары (
								<?php echo WC()->cart->get_cart_contents_count(); ?> )
							</span>
							<span>
								<?php echo WC()->cart->get_cart_total(); ?>
							</span>
						</div>
						<div class="checkout-summary__total checkout-summary__final-total">
							<span class="checkout-summary__final-total-title title-3">Итого</span>
							<span>
								<?php echo WC()->cart->get_cart_total(); ?>
							</span>
						</div>

						<!-- Согласия -->
						<div class="checkout-summary__agreements">
							<label class="checkout__checkbox">
								<input type="checkbox" name="privacy_policy" class="checkout__checkbox-input" required>
								<span class="checkout__checkbox-mark"></span>
								<span class="checkout__checkbox-text">
									Продолжая, вы соглашаетесь с

									<a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" target="_blank">
										политикой конфиденциальности
									</a>
								</span>
							</label>

							<label class="checkout__checkbox">
								<input type="checkbox" name="terms_conditions" class="checkout__checkbox-input" required>
								<span class="checkout__checkbox-mark"></span>
								<span class="checkout__checkbox-text">
									Я ознакомлен с
									<a href="<?php echo esc_url($term_link); ?>" target="_blank">
										условиями оплаты и доставки
									</a>
								</span>
							</label>
						</div>

						<!-- Кнопки -->
						<div class="checkout-summary__actions">
							<button type="submit" class="checkout-summary__btn btn btn--accent" id="submit-order">
								<span class="checkout-summary__btn-text">Перейти к оформлению</span>
								<span class="checkout-summary__btn-loader" style="display: none;"></span>
							</button>

							<?php if (!empty($btn)): ?>
								<a class="checkout-summary__btn btn" href="<?php echo esc_html($btn['url']); ?>">
									<?php echo esc_html($btn['title']); ?>
								</a>
							<?php endif; ?>

							<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="checkout-summary__link">
								Вернуться в корзину
							</a>
						</div>

					</div>
				</div>

			</div>

		</form>

	</div>
</div>

<!-- Скрипт обработки формы -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		const form = document.getElementById('checkout-form');
		const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
		const deliveryFields = document.getElementById('delivery-fields');
		const submitBtn = document.getElementById('submit-order');
		const btnText = submitBtn.querySelector('.checkout-summary__btn-text');
		const btnLoader = submitBtn.querySelector('.checkout-summary__btn-loader');

		// Показ/скрытие полей доставки
		deliveryRadios.forEach(radio => {
			radio.addEventListener('change', function () {
				if (this.value === 'delivery') {
					deliveryFields.style.display = 'grid';
					deliveryFields.classList.add('checkout__delivery-fields--visible');
				} else {
					deliveryFields.style.display = 'none';
					deliveryFields.classList.remove('checkout__delivery-fields--visible');
				}
			});
		});

		// Валидация формы
		function validateForm() {
			let isValid = true;
			const errors = {};

			// Очищаем ошибки
			document.querySelectorAll('.checkout__error').forEach(el => el.textContent = '');
			document.querySelectorAll('.checkout__input, .checkout__textarea').forEach(el => el.classList.remove('checkout__input--error'));

			// Контактные данные
			const name = form.querySelector('[name="customer_name"]').value.trim();
			if (!name) {
				errors.customer_name = 'Введите ваше имя';
				isValid = false;
			}

			const phone = form.querySelector('[name="customer_phone"]').value.trim();
			if (!phone) {
				errors.customer_phone = 'Введите телефон';
				isValid = false;
			}

			const email = form.querySelector('[name="customer_email"]').value.trim();
			if (!email) {
				errors.customer_email = 'Введите email';
				isValid = false;
			} else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
				errors.customer_email = 'Некорректный email';
				isValid = false;
			}

			// Поля доставки (если выбрано)
			const deliveryMethod = form.querySelector('input[name="delivery_method"]:checked').value;
			if (deliveryMethod === 'delivery') {
				const city = form.querySelector('[name="delivery_city"]').value.trim();
				if (!city) {
					errors.delivery_city = 'Введите город';
					isValid = false;
				}

				const address = form.querySelector('[name="delivery_address"]').value.trim();
				if (!address) {
					errors.delivery_address = 'Введите адрес';
					isValid = false;
				}
			}

			// Чекбоксы
			const privacy = form.querySelector('[name="privacy_policy"]').checked;
			const terms = form.querySelector('[name="terms_conditions"]').checked;

			if (!privacy || !terms) {
				errors.agreements = 'Необходимо принять условия';
				isValid = false;
			}

			// Показываем ошибки
			Object.keys(errors).forEach(field => {
				const errorEl = document.querySelector(`[data-error="${field}"]`);
				if (errorEl) {
					errorEl.textContent = errors[field];
				}

				const inputEl = form.querySelector(`[name="${field}"]`);
				if (inputEl) {
					inputEl.classList.add('checkout__input--error');
				}
			});

			return isValid;
		}

		// Отправка формы
		form.addEventListener('submit', function (e) {
			e.preventDefault();

			if (!validateForm()) {
				showNotice('Пожалуйста, заполните все обязательные поля', 'error');
				return;
			}

			// Показываем загрузку
			submitBtn.disabled = true;
			btnText.style.display = 'none';
			btnLoader.style.display = 'block';

			// Собираем данные
			const formData = new FormData(form);
			formData.append('action', 'custom_checkout_submit');

			// AJAX запрос
			fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
				method: 'POST',
				body: formData,
				credentials: 'same-origin'
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						showNotice('Заказ успешно оформлен! Перенаправляем...', 'success');
						setTimeout(() => {
							window.location.href = data.data.redirect_url;
						}, 1500);
					} else {
						showNotice(data.data.message || 'Ошибка оформления заказа', 'error');
						submitBtn.disabled = false;
						btnText.style.display = 'block';
						btnLoader.style.display = 'none';
					}
				})
				.catch(error => {
					console.error('Error:', error);
					showNotice('Ошибка соединения с сервером', 'error');
					submitBtn.disabled = false;
					btnText.style.display = 'block';
					btnLoader.style.display = 'none';
				});
		});

		// Уведомления
		function showNotice(message, type) {
			const notice = document.createElement('div');
			notice.className = `checkout-notice checkout-notice--${type}`;
			notice.textContent = message;

			const checkout = document.querySelector('.checkout');
			checkout.insertBefore(notice, checkout.firstChild);

			setTimeout(() => {
				notice.classList.add('checkout-notice--fade-out');
				setTimeout(() => notice.remove(), 300);
			}, 3000);
		}

		// Кнопка "Получить консультацию"
		document.getElementById('get-consultation').addEventListener('click', function () {
			// Здесь можно открыть модальное окно или перейти на страницу контактов
			alert('Функция консультации будет доступна позже');
		});
	});
</script>

<?php get_footer(); ?>