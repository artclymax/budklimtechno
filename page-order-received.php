<?php
/**
 * Template Name: Thank You Page
 * 
 * Страница подтверждения заказа
 */

defined('ABSPATH') || exit;

// Получаем ID заказа
$order_id = wc_get_order_id_by_order_key($_GET['key'] ?? '');

// Если order_id не найден через key, пробуем получить из endpoint
if (!$order_id && is_wc_endpoint_url('order-received')) {
	global $wp;
	$order_id = absint($wp->query_vars['order-received']);
}

// Проверяем существование заказа
if (!$order_id) {
	wp_redirect(home_url());
	exit;
}

$order = wc_get_order($order_id);

if (!$order) {
	wp_redirect(home_url());
	exit;
}

// Проверка доступа: только владелец заказа или администратор
$current_user_id = get_current_user_id();
$order_user_id = $order->get_customer_id();

if ($current_user_id !== $order_user_id && !current_user_can('manage_woocommerce')) {
	wp_redirect(home_url());
	exit;
}

// Получаем мета-данные
$customer_name = $order->get_meta('_customer_name');
$customer_phone = $order->get_meta('_customer_phone');
$customer_email = $order->get_meta('_customer_email');
$delivery_method = $order->get_meta('_delivery_method');
$delivery_city = $order->get_meta('_delivery_city');
$delivery_address = $order->get_meta('_delivery_address');
$payment_method = $order->get_meta('_payment_method');

get_header(); ?>

<div class="order-received">
	<div class="order-received__container container">

		<!-- ВЕРХНИЙ БЛОК: Сообщение -->
		<div class="order-received__header card-box">
			<h1 class="order-received__title title-2">Заказ отправлен</h1>
			<p class="order-received__text">
				Спасибо! Мы получили ваш заказ и свяжемся с вами для уточнения наличия, стоимости и условий поставки.
			</p>
			<div class="order-received__order-number">
				Номер заказа: <strong>#
					<?php echo esc_html($order->get_order_number()); ?>
				</strong>
			</div>
		</div>
		<div class="order-received__wrapper card-box">
			<!-- СРЕДНИЙ БЛОК: Состав заказа -->
			<div class="order-received__section">
				<h2 class="order-received__section-title title-3">Состав заказа</h2>

				<div class="order-received__items">
					<?php foreach ($order->get_items() as $item_id => $item):
						$product = $item->get_product();

						if (!$product) {
							continue;
						}

						$product_id = $item->get_product_id();
						$variation_id = $item->get_variation_id();

						// Получаем категорию
						$categories = get_the_terms($product_id, 'product_cat');
						$category_name = '';

						if ($categories && !is_wp_error($categories)) {
							$category_name = $categories[0]->name;
						}
						?>
						<div class="order-received__item card-box">
							<div class="order-received__item-thumbnail">
								<?php echo $product->get_image('medium'); ?>
							</div>

							<div class="order-received__item-info">
								<?php if ($category_name): ?>
									<div class="order-received__item-category">
										<?php echo esc_html($category_name); ?>
									</div>
								<?php endif; ?>

								<div class="order-received__item-name">
									<?php echo esc_html($item->get_name()); ?>
								</div>

								<?php
								// Отображаем вариации
								if ($variation_id && $variation_id > 0) {
									// Получаем форматированные мета-данные вариации
									$variation_data = $item->get_formatted_meta_data('_', true);

									if (!empty($variation_data)) {
										echo '<div class="order-received__item-variations">';

										foreach ($variation_data as $meta) {
											// Очищаем от HTML-тегов
											$attribute_label = strip_tags($meta->display_key);
											$attribute_value = strip_tags($meta->display_value);

											// Очищаем от префиксов
											$attribute_label = str_replace(['attribute_pa_', 'attribute_', 'pa_'], '', $attribute_label);
											$attribute_label = ucwords(str_replace(['-', '_'], ' ', $attribute_label));

											// Убираем лишние пробелы и двоеточия
											$attribute_label = trim($attribute_label, ': ');

											echo '<span class="order-received__item-variation">';
											echo esc_html($attribute_label) . ': <strong>' . esc_html($attribute_value) . '</strong>';
											echo '</span>';
										}

										echo '</div>';
									}
								}
								?>
							</div>

							<div class="order-received__item-quantity">
								<?php echo esc_html($item->get_quantity()); ?> шт.
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- НИЖНИЙ БЛОК: Данные клиента -->
			<div class="order-received__details">

				<!-- Получатель -->
				<div class="order-received__detail">
					<div class="order-received__detail-label">Получатель</div>
					<div class="order-received__detail-value">
						<?php echo esc_html($customer_name); ?>
					</div>
					<?php if ($customer_phone): ?>
						<div class="order-received__detail-meta">
							<a href="tel:<?php echo esc_attr($customer_phone); ?>">
								<?php echo esc_html($customer_phone); ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($customer_email): ?>
						<div class="order-received__detail-meta">
							<a href="mailto:<?php echo esc_attr($customer_email); ?>">
								<?php echo esc_html($customer_email); ?>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<!-- Доставка -->
				<div class="order-received__detail">
					<div class="order-received__detail-label">Доставка</div>
					<div class="order-received__detail-value">
						<?php
						if ($delivery_method === 'delivery') {
							echo 'Доставка до объекта';
						} else {
							echo 'Согласовать с менеджером';
						}
						?>
					</div>
					<?php if ($delivery_method === 'delivery'): ?>
						<?php if ($delivery_city): ?>
							<div class="order-received__detail-meta">
								г.
								<?php echo esc_html($delivery_city); ?>
							</div>
						<?php endif; ?>
						<?php if ($delivery_address): ?>
							<div class="order-received__detail-meta">
								<?php echo esc_html($delivery_address); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>

				<!-- Оплата -->
				<div class="order-received__detail">
					<div class="order-received__detail-label">Оплата</div>
					<div class="order-received__detail-value">
						Безналичный расчёт
					</div>
				</div>

			</div>
		</div>
		<!-- Кнопка возврата -->
		<div class="order-received__actions">
			<a href="<?php echo esc_url(home_url('/')); ?>" class="order-received__btn btn btn--accent">
				Вернуться на главную
			</a>
		</div>

	</div>
</div>

<?php get_footer(); ?>