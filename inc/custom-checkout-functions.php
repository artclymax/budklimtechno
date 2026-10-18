<?php
/**
 * Функции обработки кастомного checkout
 */

defined('ABSPATH') || exit;

/**
 * AJAX обработчик оформления заказа
 */
add_action('wp_ajax_custom_checkout_submit', 'custom_checkout_process_order');
add_action('wp_ajax_nopriv_custom_checkout_submit', 'custom_checkout_process_order');

function custom_checkout_process_order()
{
	// Логируем начало
	error_log('=== Custom Checkout Process Started ===');

	// Проверяем nonce
	if (!isset($_POST['checkout_nonce']) || !wp_verify_nonce($_POST['checkout_nonce'], 'custom_checkout')) {
		error_log('Nonce verification failed');
		wp_send_json_error(array('message' => 'Ошибка безопасности. Обновите страницу.'));
	}

	// Валидация
	$errors = array();

	// Контактные данные
	$customer_name = isset($_POST['customer_name']) ? sanitize_text_field($_POST['customer_name']) : '';
	$customer_phone = isset($_POST['customer_phone']) ? sanitize_text_field($_POST['customer_phone']) : '';
	$customer_email = isset($_POST['customer_email']) ? sanitize_email($_POST['customer_email']) : '';
	$customer_comment = isset($_POST['customer_comment']) ? sanitize_textarea_field($_POST['customer_comment']) : '';

	if (empty($customer_name)) {
		$errors[] = 'Введите ваше имя';
	}
	if (empty($customer_phone)) {
		$errors[] = 'Введите телефон';
	}
	if (empty($customer_email) || !is_email($customer_email)) {
		$errors[] = 'Введите корректный email';
	}

	// Способ доставки
	$delivery_method = isset($_POST['delivery_method']) ? sanitize_text_field($_POST['delivery_method']) : 'manager';
	$delivery_city = '';
	$delivery_address = '';
	$delivery_info = '';

	if ($delivery_method === 'delivery') {
		$delivery_city = isset($_POST['delivery_city']) ? sanitize_text_field($_POST['delivery_city']) : '';
		$delivery_address = isset($_POST['delivery_address']) ? sanitize_text_field($_POST['delivery_address']) : '';
		$delivery_info = isset($_POST['delivery_info']) ? sanitize_textarea_field($_POST['delivery_info']) : '';

		if (empty($delivery_city)) {
			$errors[] = 'Введите город';
		}
		if (empty($delivery_address)) {
			$errors[] = 'Введите адрес';
		}
	}

	// Способ оплаты
	$payment_method = isset($_POST['payment_method']) ? sanitize_text_field($_POST['payment_method']) : 'bank_transfer';

	// Чекбоксы
	$privacy_policy = isset($_POST['privacy_policy']) && $_POST['privacy_policy'] === 'on';
	$terms_conditions = isset($_POST['terms_conditions']) && $_POST['terms_conditions'] === 'on';

	if (!$privacy_policy || !$terms_conditions) {
		$errors[] = 'Необходимо принять условия';
	}

	// Если есть ошибки
	if (!empty($errors)) {
		error_log('Validation errors: ' . implode(', ', $errors));
		wp_send_json_error(array('message' => implode(', ', $errors)));
	}

	// Проверяем корзину
	if (WC()->cart->is_empty()) {
		error_log('Cart is empty');
		wp_send_json_error(array('message' => 'Корзина пуста'));
	}

	// Создаём заказ
	try {
		$order = wc_create_order();

		if (is_wp_error($order)) {
			throw new Exception('Не удалось создать заказ: ' . $order->get_error_message());
		}

		// Добавляем товары из корзины
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$product_id = $cart_item['product_id'];
			$variation_id = $cart_item['variation_id'];
			$quantity = $cart_item['quantity'];

			if ($variation_id) {
				$order->add_product(
					wc_get_product($variation_id),
					$quantity,
					array(
						'variation' => $cart_item['variation'],
					)
				);
			} else {
				$order->add_product(
					wc_get_product($product_id),
					$quantity
				);
			}
		}

		// Устанавливаем адреса
		$address = array(
			'first_name' => $customer_name,
			'phone' => $customer_phone,
			'email' => $customer_email,
		);

		if ($delivery_method === 'delivery') {
			$address['city'] = $delivery_city;
			$address['address_1'] = $delivery_address;
		}

		$order->set_address($address, 'billing');
		$order->set_address($address, 'shipping');

		// Сохраняем дополнительные данные в мета
		$order->update_meta_data('_customer_name', $customer_name);
		$order->update_meta_data('_customer_phone', $customer_phone);
		$order->update_meta_data('_customer_email', $customer_email);
		$order->update_meta_data('_customer_comment', $customer_comment);
		$order->update_meta_data('_delivery_method', $delivery_method);
		$order->update_meta_data('_payment_method', $payment_method);

		if ($delivery_method === 'delivery') {
			$order->update_meta_data('_delivery_city', $delivery_city);
			$order->update_meta_data('_delivery_address', $delivery_address);
			$order->update_meta_data('_delivery_info', $delivery_info);
		}

		// Рассчитываем итоги
		$order->calculate_totals();

		// Устанавливаем статус
		$order->update_status('pending', 'Заказ создан через кастомный checkout');

		// Сохраняем заказ
		$order->save();

		$order_id = $order->get_id();
		error_log('Order created successfully: #' . $order_id);

		// Отправляем email
		custom_checkout_send_emails($order);

		// Очищаем корзину
		WC()->cart->empty_cart();
		
		$thank_you_page_id = get_page_by_path('order-received'); // или 'thank-you'

		if ($thank_you_page_id) {
			$redirect_url = add_query_arg(
				array(
					'order_id' => $order_id,
					'key' => $order->get_order_key(),
				),
				get_permalink($thank_you_page_id)
			);
		} else {
			// Фолбэк на стандартную страницу
			$redirect_url = $order->get_checkout_order_received_url();
		}

		// Возвращаем успех
		wp_send_json_success(array(
			'message' => 'Заказ успешно оформлен',
			'order_id' => $order_id,
			'redirect_url' => $redirect_url,
		));

	} catch (Exception $e) {
		error_log('Order creation error: ' . $e->getMessage());
		wp_send_json_error(array('message' => 'Ошибка создания заказа: ' . $e->getMessage()));
	}
}

/**
 * Отправка email уведомлений
 */
function custom_checkout_send_emails($order)
{
	$order_id = $order->get_id();

	// Получаем данные из мета
	$customer_name = $order->get_meta('_customer_name');
	$customer_phone = $order->get_meta('_customer_phone');
	$customer_email = $order->get_meta('_customer_email');
	$customer_comment = $order->get_meta('_customer_comment');
	$delivery_method = $order->get_meta('_delivery_method');
	$payment_method = $order->get_meta('_payment_method');

	// Формируем текст письма
	$subject = 'Новый заказ #' . $order_id . ' на сайте ' . get_bloginfo('name');

	$message = '<h2>Новый заказ #' . $order_id . '</h2>';
	$message .= '<h3>Контактные данные:</h3>';
	$message .= '<p><strong>Имя:</strong> ' . esc_html($customer_name) . '</p>';
	$message .= '<p><strong>Телефон:</strong> ' . esc_html($customer_phone) . '</p>';
	$message .= '<p><strong>Email:</strong> ' . esc_html($customer_email) . '</p>';

	if (!empty($customer_comment)) {
		$message .= '<p><strong>Комментарий:</strong> ' . esc_html($customer_comment) . '</p>';
	}

	$message .= '<h3>Способ получения:</h3>';
	if ($delivery_method === 'delivery') {
		$delivery_city = $order->get_meta('_delivery_city');
		$delivery_address = $order->get_meta('_delivery_address');
		$delivery_info = $order->get_meta('_delivery_info');

		$message .= '<p>Доставка до объекта</p>';
		$message .= '<p><strong>Город:</strong> ' . esc_html($delivery_city) . '</p>';
		$message .= '<p><strong>Адрес:</strong> ' . esc_html($delivery_address) . '</p>';

		if (!empty($delivery_info)) {
			$message .= '<p><strong>Доп. информация:</strong> ' . esc_html($delivery_info) . '</p>';
		}
	} else {
		$message .= '<p>Согласовать с менеджером</p>';
	}

	$message .= '<h3>Способ оплаты:</h3>';
	$message .= '<p>Безналичный расчёт</p>';

	$message .= '<h3>Товары:</h3>';
	$message .= '<table style="width: 100%; border-collapse: collapse;">';
	$message .= '<tr style="background: #f5f5f5;"><th style="padding: 10px; text-align: left;">Товар</th><th style="padding: 10px; text-align: right;">Кол-во</th><th style="padding: 10px; text-align: right;">Цена</th></tr>';

	foreach ($order->get_items() as $item_id => $item) {
		$product = $item->get_product();
		$message .= '<tr>';
		$message .= '<td style="padding: 10px; border-bottom: 1px solid #ddd;">' . esc_html($item->get_name()) . '</td>';
		$message .= '<td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">' . esc_html($item->get_quantity()) . '</td>';
		$message .= '<td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: right;">' . wp_kses_post($order->get_formatted_line_subtotal($item)) . '</td>';
		$message .= '</tr>';
	}

	$message .= '</table>';
	$message .= '<p style="font-size: 18px; font-weight: bold; margin-top: 20px;">Итого: ' . wp_kses_post($order->get_formatted_order_total()) . '</p>';

	// Отправляем администратору
	$admin_email = get_option('admin_email');
	$headers = array('Content-Type: text/html; charset=UTF-8');

	wp_mail($admin_email, $subject, $message, $headers);

	// Отправляем клиенту
	if ($customer_email) {
		$client_subject = 'Ваш заказ #' . $order_id . ' принят';
		$client_message = '<h2>Спасибо за заказ!</h2>';
		$client_message .= '<p>Ваш заказ #' . $order_id . ' успешно принят.</p>';
		$client_message .= '<p>Наш менеджер свяжется с вами в ближайшее время для уточнения деталей.</p>';
		$client_message .= '<p><strong>Сумма заказа:</strong> ' . wp_kses_post($order->get_formatted_order_total()) . '</p>';

		wp_mail($customer_email, $client_subject, $client_message, $headers);
	}
}