<?php

//require_once get_template_directory() . '/functions/vite.php';

// === Helpers ===
require_once get_template_directory() . '/functions/helpers/theme_asset_version.php';
require_once get_template_directory() . '/functions/helpers/print_dump.php';
require_once get_template_directory() . '/functions/helpers/mx_logo.php';
require_once get_template_directory() . '/functions/helpers/mx_pagination.php';
//require_once get_template_directory() . '/functions/helpers/mx_category_list.php';
//require_once get_template_directory() . '/functions/helpers/trim_text.php';
require_once get_template_directory() . '/functions/helpers/correct_phone.php';
require_once get_template_directory() . '/functions/helpers/smart_breadcrumbs.php';


/* get_json_from_query
$json = get_json_from_query($query);
<div class="select-products-data" data-select-from-acf="<?= esc_attr($json) ?>"></div>
*/
//require_once get_template_directory() . '/functions/helpers/get_json_from_query.php';

/** Добавление картинки для кастомных полей в таблице админки
 * add_admin_thumbnail_column('castom-post-slug'); // projects
 */
//require_once get_template_directory() . '/functions/helpers/add_admin_thumbnail_column.php';
//add_admin_thumbnail_column('portfolio');

//require_once get_template_directory() . '/functions/helpers/get_prev_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/get_next_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/custom_product_category.php';
//require_once get_template_directory() . '/functions/helpers/get_product_attributes_array.php';

// === BASE ====
// Общая настройка темы (лого, название и т.п.)
require_once get_template_directory() . '/functions/default_settings.php';

// Подключение стилей
require_once get_template_directory() . '/functions/connect_styles.php';

// Подключение скриптов
require_once get_template_directory() . '/functions/connect_scripts.php';

// Отключение стилей Woocommerce
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Поддержка темы на Woocommerce
add_action('after_setup_theme', function () {
	add_theme_support('woocommerce');
});
// Создание меню
require_once get_template_directory() . '/functions/register_nav_menus.php';

// Регистрация новых записей
require_once get_template_directory() . '/functions/register_post_type.php';

// Кастомная админка (новая версия)
require_once get_template_directory() . '/functions/admin/admin-page.php';
require_once get_template_directory() . '/functions/admin/plugin-installer.php';
//add_action('admin_init', function() {
//    if (current_user_can('manage_options')) {
//        delete_transient('verda_admin_post_types');
//    }
//});
// Создание SCF-полей
require_once get_template_directory() . '/functions/scf_data.php';

function mx_fix_orphans($text)
{
	if (is_admin())
		return $text;
	if (!is_string($text))
		return $text;

	// Если нет коротких слов — сразу выходим (оптимизация)
	if (!preg_match('/\s[а-яА-Яa-zA-Z]{1,2}\s/u', $text)) {
		return $text;
	}

	// Разделяем текст на блоки: защищённые (script, style, code, pre, textarea) и обычный текст
	// Регулярка захватывает открывающий тег, содержимое и закрывающий тег
	$protected_pattern = '/(<script\b[^>]*>.*?<\/script>|<style\b[^>]*>.*?<\/style>|<code\b[^>]*>.*?<\/code>|<pre\b[^>]*>.*?<\/pre>|<textarea\b[^>]*>.*?<\/textarea>)/uis';

	// Разбиваем текст на части: [текст, защищённый_блок, текст, защищённый_блок, ...]
	$parts = preg_split($protected_pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

	$result = '';
	foreach ($parts as $part) {
		// Если часть — защищённый блок (начинается с <script, <style и т.д.), не трогаем
		if (preg_match('/^<(script|style|code|pre|textarea)\b/i', $part)) {
			$result .= $part;
		} else {
			// Иначе применяем замену неразрывных пробелов
			$result .= preg_replace('/(\s|&nbsp;)([а-яА-Яa-zA-Z]{1,2})\s/u', '$1$2&nbsp;', $part);
		}
	}

	return $result;
}

// ACF
add_filter('acf/format_value', 'mx_fix_orphans', 20);
add_filter('the_content', 'mx_fix_orphans', 20);
add_filter('the_title', 'mx_fix_orphans', 20);
add_filter('the_excerpt', 'mx_fix_orphans', 20);
add_filter('nav_menu_item_title', 'mx_fix_orphans', 20);

// Внимание: навигация и ACF требуют осторожности
// add_filter('nav_menu_item_title', 'mx_fix_orphans', 20); 
// add_filter('acf/format_value', 'mx_fix_orphans', 20); 


add_action('admin_head', function () {
	echo '<style>
        #postexcerpt p {
            display: none !important;
        }
    </style>';
});
//add_filter('big_image_size_threshold', '__return_false');

add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {

	$front_page_id = get_option('page_on_front');

	// Если это крошка главной
	//if (in_array('home', $type) || $front_page_id) {
	//	return get_the_title($front_page_id);
	//}
	if (in_array('home', $type)) {
		return 'Главная';
	}
	//if (in_array('shop', $type) || $title === 'Товары' || $title === 'Shop') {
	//	return 'Каталог';
	//}
	return $title;

}, 10, 3);

// Убираем разделитель
add_filter('bcn_display_separator', '__return_empty_string');



// === CF7 Redirect: Редирект после отправки формы ===
require_once get_template_directory() . '/functions/cf7-redirect.php';

// === CF7 Leads: Собственная система хранения заявок (замена Flamingo) ===
require_once get_template_directory() . '/functions/cf7-leads.php';

// === CF7: переопределение email получателя через настройки сайта ===
add_filter('wpcf7_mail_components', function ($components, $form) {
	$custom_email = get_option('form_email_to');

	if (!empty($custom_email) && is_email($custom_email)) {
		$components['recipient'] = $custom_email;
	}

	return $components;
}, 10, 2);

add_filter('wpcf7_autop', '__return_false', 20);
add_filter('wpcf7_form_elements', function ($content) {
	//$content = preg_replace('/<span class="wpcf7-form-control-wrap.*?">(.*?)<\/span>/is', '$1', $content);
	$content = str_replace('<br />', '', $content);
	return $content;
});


function sort_all_post_types_by_menu_order($query)
{

	if (is_admin() || !$query->is_main_query()) {
		return;
	}


	$post_type = $query->get('post_type');


	if (empty($post_type) || $post_type === 'any' || is_array($post_type) || is_string($post_type)) {
		$query->set('orderby', 'menu_order');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'sort_all_post_types_by_menu_order', 99);
add_filter('woocommerce_currency_symbol', 'custom_currency_symbol_html', 10, 2);

function custom_currency_symbol_html($currency_symbol, $currency)
{
	if ($currency === 'BYN') {
		$currency_symbol = '<i class="nbrb-icon">BYN</i>';
	}
	return $currency_symbol;
}
/**
 * Убирает нули в конце цены, если цена целая
 */
add_filter('woocommerce_price_trim_zeros', '__return_true');

add_filter('woocommerce_add_to_cart_fragments', 'custom_cart_counter_fragment');

function custom_cart_counter_fragment($fragments)
{
	$count = WC()->cart->get_cart_contents_count();

	ob_start();
	?>
	<span class="cart-btn__counter" id="cart-counter" <?php echo $count === 0 ? 'style="display:none;"' : ''; ?>>
		<?php echo esc_html($count); ?>
	</span>
	<?php
	$fragments['#cart-counter'] = ob_get_clean();

	return $fragments;
}

add_filter('woocommerce_get_breadcrumb', 'custom_product_breadcrumb', 20, 2);
function custom_product_breadcrumb($crumbs, $breadcrumb)
{

	// Проверяем, что мы на странице товара ИЛИ в категории товара
	if ((is_product() || is_product_category()) && !empty($crumbs)) {
		$new_crumbs = array();

		// 1. Оставляем "Главная" (это всегда первый элемент массива)
		$new_crumbs[] = $crumbs[0];

		// 2. Вставляем "Каталог"
		$shop_page_id = wc_get_page_id('shop');
		$shop_url = $shop_page_id > 0 ? get_permalink($shop_page_id) : home_url('/shop/');

		$new_crumbs[] = array('Каталог', $shop_url);

		// 3. Добавляем остальные элементы (Категория, Подкатегория, Товар)
		for ($i = 1; $i < count($crumbs); $i++) {
			$new_crumbs[] = $crumbs[$i];
		}

		// Перезаписываем массив крошек
		$crumbs = $new_crumbs;
	}

	return $crumbs;
}

// AJAX обновление корзины
// AJAX обновление корзины
add_action('wp_ajax_woocommerce_update_cart', 'custom_ajax_update_cart');
add_action('wp_ajax_nopriv_woocommerce_update_cart', 'custom_ajax_update_cart');

function custom_ajax_update_cart()
{
	// Логируем для отладки
	error_log('Update cart called');
	error_log('POST data: ' . print_r($_POST, true));

	// Проверяем nonce
	if (!isset($_POST['woocommerce-cart-nonce']) || !wp_verify_nonce($_POST['woocommerce-cart-nonce'], 'woocommerce-cart')) {
		error_log('Nonce verification failed');
		wp_send_json_error(array('message' => 'Неверный nonce'));
		return;
	}

	// Обновляем корзину
	if (isset($_POST['cart'])) {
		foreach ($_POST['cart'] as $cart_item_key => $cart_item_data) {
			if (isset($cart_item_data['qty'])) {
				$quantity = apply_filters(
					'woocommerce_stock_amount_cart_item',
					apply_filters('woocommerce_stock_amount', preg_replace('/[^0-9\.]/', '', $cart_item_data['qty'])),
					$cart_item_key
				);

				// Если количество 0 или меньше - удаляем товар
				if ($quantity <= 0) {
					error_log('Quantity is 0 or less, removing item: ' . $cart_item_key);
					WC()->cart->remove_cart_item($cart_item_key);
					continue;
				}

				// Обновляем количество
				$passed_validation = apply_filters(
					'woocommerce_update_cart_validation',
					true,
					$cart_item_key,
					$cart_item_data,
					$quantity
				);

				if ($passed_validation) {
					error_log('Setting quantity for ' . $cart_item_key . ' to ' . $quantity);
					WC()->cart->set_quantity($cart_item_key, $quantity);
				}
			}
		}
	}

	// Пересчитываем корзину
	WC()->cart->calculate_totals();

	// Возвращаем данные
	wp_send_json_success(array(
		'cart_count' => WC()->cart->get_cart_contents_count(),
		'cart_subtotal' => WC()->cart->get_cart_subtotal(),
		'cart_total' => WC()->cart->get_cart_total(),
	));
}

// AJAX удаление из корзины
add_action('wp_ajax_woocommerce_remove_from_cart', 'custom_ajax_remove_from_cart');
add_action('wp_ajax_nopriv_woocommerce_remove_from_cart', 'custom_ajax_remove_from_cart');

function custom_ajax_remove_from_cart()
{
	// Логируем для отладки
	error_log('Remove from cart called');
	error_log('POST data: ' . print_r($_POST, true));

	// Проверяем nonce
	if (!isset($_POST['woocommerce-cart-nonce']) || !wp_verify_nonce($_POST['woocommerce-cart-nonce'], 'woocommerce-cart')) {
		error_log('Nonce verification failed');
		wp_send_json_error(array('message' => 'Неверный nonce'));
		return;
	}

	if (isset($_POST['cart_item_key'])) {
		$cart_item_key = sanitize_text_field($_POST['cart_item_key']);
		error_log('Removing cart item: ' . $cart_item_key);

		// Удаляем товар
		$removed = WC()->cart->remove_cart_item($cart_item_key);

		if ($removed) {
			// Пересчитываем корзину
			WC()->cart->calculate_totals();

			wp_send_json_success(array(
				'cart_count' => WC()->cart->get_cart_contents_count(),
				'cart_subtotal' => WC()->cart->get_cart_subtotal(),
				'cart_total' => WC()->cart->get_cart_total(),
			));
		} else {
			error_log('Failed to remove cart item');
			wp_send_json_error(array('message' => 'Не удалось удалить товар'));
		}
	} else {
		error_log('No cart_item_key provided');
		wp_send_json_error(array('message' => 'Не указан товар'));
	}
}

function custom_checkout_init()
{
	require_once get_template_directory() . '/inc/custom-checkout-functions.php';
}
add_action('after_setup_theme', 'custom_checkout_init');
