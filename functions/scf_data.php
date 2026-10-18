<?php


if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Контактные данные',
		'menu_title' => 'Контактные данные',
		'menu_slug' => 'opt-contacts',
		'position' => 20,
	));

	acf_add_options_page(array(
		'page_title' => 'Общие поля товаров',
		'menu_title' => 'Общие поля товаров',
		'menu_slug' => 'opt-products',
		'position' => 15,
	));

	
	acf_add_options_page(array(
		'page_title' => 'Шапка',
		'menu_title' => 'Шапка',
		'menu_slug' => 'opt-header',
		'position' => 21,
	));

	acf_add_options_page(array(
		'page_title' => 'Подвал / Футер',
		'menu_title' => 'Подвал / Футер',
		'menu_slug' => 'opt-footer',
		'position' => 22,
	));

	acf_add_options_page(array(
		'page_title' => 'Модальные окна',
		'menu_title' => 'Модальные окна',
		'menu_slug' => 'opt-modals',
		'position' => 23,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница благодарности',
		'menu_title' => 'Страница благодарности',
		'menu_slug' => 'opt-thank_you',
		'position' => 24,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница 404',
		'menu_title' => 'Страница 404',
		'menu_slug' => 'opt-page-404',
		'position' => 24,
	));

}

// OPTIONS
add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// HEADER
	acf_add_local_field_group(array(
		'key' => 'group_header_settings',
		'title' => 'Поля шапки',
		'fields' => array(
			array(
				'key' => 'field_header_info_message',
				'name' => 'header_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			// телефон
			//array(
			//	'key' => 'field_header_phone',
			//	'label' => 'Телефон в шапке',
			//	'name' => 'header_phone',
			//	'type' => 'text',
			//),

			// Кнопка
			//array(
			//	'key' => 'field_header_btn',
			//	'label' => 'Кнопка в шапке',
			//	'name' => 'header_btn',
			//	'type' => 'link',
			//	'instructions' => 'Ссылка на модальное окно (якорь #modal-call) или страницу.',
			//),
			array(
				'key' => 'field_header_catalog_btn',
				'label' => 'Кнопка каталога',
				'name' => 'header_catalog_btn',
				'type' => 'link',
				'instructions' => 'Ссылка на каталог',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-header',
				),
			),
		),
	));

	// FOOTER
	acf_add_local_field_group(array(
		'key' => 'flds_opt_footer',
		'title' => 'Поля футера',
		'fields' => array(
			array(
				'key' => 'footer_info_message',
				'name' => 'footer_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			//array(
			//	'key' => 'footer_logo',
			//	'name' => 'footer_logo',
			//	'label' => 'Логотип',
			//	'type' => 'image',
			//),
			array(
				'key' => 'footer_descr',
				'name' => 'footer_descr',
				'label' => 'Описание',
				'type' => 'textarea',
				'new_lines' => 'wpautop',
				'rows' => 2,
			),
			array(
				'key' => 'footer_company',
				'name' => 'footer_company',
				'label' => 'Название компании',
				'type' => 'text',
			),
			array(
				'key' => 'footer_copy',
				'name' => 'footer_copy',
				'label' => 'Копирайт',
				'type' => 'text',
			),
			array(
				'key' => 'footer_links',
				'name' => 'footer_links',
				'label' => 'Ссылки',
				'type' => 'repeater',
				'sub_fields' => array(
					array(
						'key' => 'footer_links_link',
						'name' => 'footer_links_link',
						'label' => 'Ссылка',
						'type' => 'link',
					),
				)
			),
			array(
				'key' => 'footer_content',
				'name' => 'footer_content',
				'label' => 'Контентное описание',
				'type' => 'wysiwyg',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-footer',
				),
			),
		),
	));

	// CONTACTS
	acf_add_local_field_group(array(
		'key' => 'group_contacts_page',
		'title' => 'Страница: Контакты',
		'fields' => array(
			array(
				'key' => 'field_contacts_title',
				'label' => 'Заголовок секции',
				'name' => 'contacts_title',
				'type' => 'text',
			),
			array(
				'key' => 'field_contacts_tab_phones',
				'label' => 'Телефон',
				'name' => 'contacts_tab_phones',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_phones',
				'label' => 'Телефоны',
				'name' => 'contacts_phones',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_phone_number',
				'button_label' => 'Добавить телефон',
				'sub_fields' => array(
					array(
						'key' => 'field_contact_phone_number',
						'label' => 'Номер телефона',
						'name' => 'phone',
						'type' => 'text',
					),
					array(
						'key' => 'field_contact_phone_messengers',
						'label' => 'Мессенджеры',
						'name' => 'messengers',
						'type' => 'repeater',
						'layout' => 'table',
						'collapsed' => 'field_contact_messenger_link',
						'button_label' => 'Добавить мессенджер',
						'sub_fields' => array(
							array(
								'key' => 'field_contact_messenger_icon',
								'label' => 'Иконка',
								'name' => 'image',
								'type' => 'image',
							),
							array(
								'key' => 'field_contact_messenger_link',
								'label' => 'Ссылка',
								'name' => 'link',
								'type' => 'link',
							),
						)
					)
				)
			),
			array(
				'key' => 'field_contacts_tab_email',
				'label' => 'Email',
				'name' => 'contacts_tab_email',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_emails',
				'label' => 'Email адреса',
				'name' => 'contacts_emails',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_email_link',
				'button_label' => 'Добавить email',
				'sub_fields' => array(
					array(
						'key' => 'field_contact_email_link',
						'label' => 'Email',
						'name' => 'email',
						'type' => 'email',
					)
				)
			),
			array(
				'key' => 'field_contacts_tab_address_time',
				'label' => 'Адрес и время работы',
				'name' => 'contacts_tab_address_time',
				'type' => 'tab',
			),
			array(
				'key' => 'field_contacts_address',
				'label' => 'Адрес',
				'name' => 'contacts_address',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_contacts_time',
				'label' => 'Время работы',
				'name' => 'contacts_time',
				'type' => 'wysiwyg',
			),
			//array(
			//	'key' => 'field_contacts_tab_messengers',
			//	'label' => 'Мессенджеры и соцсети',
			//	'name' => 'contacts_tab_messengers',
			//	'type' => 'tab',
			//),
			//array(
			//	'key' => 'field_contacts_messengers',
			//	'label' => 'Мессенджеры',
			//	'name' => 'contacts_messengers',
			//	'type' => 'repeater',
			//	'sub_fields' => array(
			//		array(
			//			'key' => 'field_contact_phone_icon',
			//			'label' => 'Иконка',
			//			'name' => 'image',
			//			'type' => 'image',
			//		),
			//		array(
			//			'key' => 'field_contact_phone_link',
			//			'label' => 'Ссылка',
			//			'name' => 'link',
			//			'type' => 'link',
			//		)
			//	)
			//),
			array(
				'key' => 'field_contacts_tab_form',
				'label' => 'Форма контактов',
				'name' => 'contacts_tab_form',
				'type' => 'tab',
			),
			[
				'key' => 'field_contacts_form_title',
				'label' => 'Заголовок формы',
				'name' => 'contacts_form_title',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_form_descr',
				'label' => 'Описание формы',
				'name' => 'contacts_form_descr',
				'type' => 'textarea',
				'rows' => '4',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_contacts_form_shortcode',
				'label' => 'Шорткод формы',
				'name' => 'contacts_form_shortcode',
				'type' => 'text',
				'instructions' => 'Вставьте шорткод формы, например: [contact-form-7 id="123" title="Форма контактов"]',
			],
			array(
				'key' => 'field_contacts_tab_map',
				'label' => 'Карта',
				'name' => 'contacts_tab_map',
				'type' => 'tab',
			),
			[
				'key' => 'field_contacts_map_title',
				'label' => 'Заголовок карты',
				'name' => 'contacts_map_title',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_map',
				'label' => 'Код карты (iframe)',
				'name' => 'contacts_map',
				'type' => 'textarea',
				'rows' => 4,
				'instructions' => 'Вставьте iframe код из Яндекс.Карт или Google Maps',
			],
			[
				'key' => 'field_contacts_map_card_title',
				'label' => 'Заголовок карточки на карте',
				'name' => 'contacts_map_card_title',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_map_card_text',
				'label' => 'Текст карточки на карте',
				'name' => 'contacts_map_card_text',
				'type' => 'textarea',
				'rows' => 3,
				'new_lines' => 'wpautop',
			],
			array(
				'key' => 'field_contacts_tab_payment',
				'label' => 'Реквизиты',
				'name' => 'contacts_tab_payment',
				'type' => 'tab',
			),
			[
				'key' => 'field_contacts_payment_title',
				'label' => 'Заголовок блока реквизитов',
				'name' => 'contacts_payment_title',
				'type' => 'text',
			],
			[
				'key' => 'field_contacts_payment_blocks',
				'label' => 'Блоки реквизитов',
				'name' => 'contacts_payment_blocks',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить блок',
				'sub_fields' => [
					[
						'key' => 'field_contacts_payment_list',
						'label' => 'Реквизиты',
						'name' => 'list',
						'type' => 'repeater',
						'layout' => 'table',
						'button_label' => 'Добавить реквизит',
						'sub_fields' => [
							[
								'key' => 'field_contacts_payment_item_value',
								'label' => 'Значение',
								'name' => 'value',
								'type' => 'text',
							],
							[
								'key' => 'field_contacts_payment_item_key',
								'label' => 'Подпись',
								'name' => 'key',
								'type' => 'text',
							],
						],
					],
				],
			],
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-contacts'
				)
			)
		),
		'menu_order' => 0,
	));

	// MODALS
	acf_add_local_field_group(array(
		'key' => 'group_opt_modals',
		'title' => 'Глобальные модальные окна',
		'fields' => array(
			array(
				'key' => 'field_modals_list',
				'label' => 'Список модальных окон',
				'name' => 'modals',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_modal_id',
				'button_label' => 'Добавить модальное окно',
				'sub_fields' => array(
					array(
						'key' => 'field_modal_id',
						'label' => 'ID модального окна',
						'name' => 'id',
						'type' => 'text',
						'required' => 1,
						'maxlength' => 50,
						'instructions' => 'Только латиница, цифры, дефис. Пример: <code>order-form</code>. Используется в <code>id</code> и <code>data-modal</code>.',
						'prepend' => '#',
						'character_limit' => 50,
						'allow_custom' => 0,
					),
					array(
						'key' => 'field_modal_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_modal_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					),
					array(
						'key' => 'field_modal_shortcode',
						'label' => 'Шорткод формы',
						'name' => 'shortcode',
						'type' => 'text',
						'placeholder' => '[contact-form-7 id="123"]',
						'instructions' => 'Вставьте шорткод форм (CF7, WPForms, Forminator и свой шорткод).',
					),
					array(
						'key' => 'field_modal_image',
						'label' => 'Картинка',
						'name' => 'image',
						'type' => 'image',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-modals',
				),
			),
		),
	));


	// THANK YOU
	acf_add_local_field_group(array(
		'key' => 'flds_opt_thank_you',
		'title' => 'Страница благодарности',
		'fields' => array(
			array(
				'key' => 'field_thank_you_title',
				'name' => 'thank_you_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_thank_you_descr',
				'name' => 'thank_you_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_thank_you_btn',
				'name' => 'thank_you_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),
			array(
				'key' => 'field_thank_you_btn_second',
				'name' => 'thank_you_btn_second',
				'label' => 'Кнопка вторая',
				'type' => 'link',
			),
			array(
				'key' => 'field_thank_you_image',
				'name' => 'thank_you_image',
				'label' => 'Картинка',
				'type' => 'image',
			),
			array(
				'key' => 'field_thank_you_note',
				'name' => 'thank_you_note',
				'label' => 'Заметка',
				'type' => 'wysiwyg',
			),
			//array(
			//	'key' => 'field_thank_you_image_mobile',
			//	'name' => 'thank_you_image_mobile',
			//	'label' => 'Картинка мобильная',
			//	'type' => 'image',
			//)
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-thank_you',
				),
			),
		),
	));

	// PAGE 404 
	acf_add_local_field_group(array(
		'key' => 'flds_opt_page_404',
		'title' => 'Страница 404',
		'fields' => array(
			array(
				'key' => 'field_page_404_title',
				'name' => 'page_404_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_page_404_descr',
				'name' => 'page_404_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_page_404_btn',
				'name' => 'page_404_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),
			array(
				'key' => 'field_page_404_btn_second',
				'name' => 'page_404_btn_second',
				'label' => 'Кнопка вторая',
				'type' => 'link',
			),
			array(
				'key' => 'field_page_404_image',
				'name' => 'page_404_image',
				'label' => 'Картинка',
				'type' => 'image',
			),
			array(
				'key' => 'field_page_404_image_num',
				'name' => 'page_404_image_num',
				'label' => 'Картинка 404',
				'type' => 'image',
			),
			//array(
			//	'key' => 'field_page_404_image_404',
			//	'name' => 'page_404_image_404',
			//	'label' => 'Картинка c цифрой 404',
			//	'type' => 'image',
			//),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page-404',
				),
			),
		),
	));

	// product
	acf_add_local_field_group(array(
		'key' => 'flds_opt_page_product',
		'title' => 'Страница благодарности',
		'fields' => array(
			array(
				'key' => 'fieldpage_product_btn',
				'name' => 'page_product_btn',
				'label' => 'Кнопка "Получить консультацию',
				'type' => 'link',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-products',
				),
			),
		),
	));

	// SECTIONS
});


add_action('acf/init', 'register_fields');
function register_fields()
{
	$page = get_page_by_path('home', OBJECT, 'page');
	// !== COMMON ===
	acf_add_local_field_group([
		'key' => 'group_hero_page_section',
		'title' => 'Первый экран',
		'fields' => [
			[
				'key' => 'field_hero_page_title',
				'label' => 'Заголовок H1',
				'name' => 'hero_title',
				'type' => 'text',
			],
			[
				'key' => 'field_hero_page_descr',
				'label' => 'Описание',
				'name' => 'hero_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_hero_page_btn',
				'label' => 'Номер телефона',
				'name' => 'hero_btn',
				'type' => 'text',
				'instructions' => 'Если отсутствует то будет брать из Главной страницы.',
				'default_value' => get_field('home_hero_phone', $page->ID),
			],
			[
				'key' => 'field_hero_page_image',
				'label' => 'Фоновая картинка',
				'name' => 'hero_image',
				'type' => 'image',
			],
			[
				'key' => 'field_hero_page_btn_first',
				'label' => 'Кнопка первая',
				'name' => 'hero_btn_first',
				'type' => 'link',
			],
			[
				'key' => 'field_hero_page_btn_second',
				'label' => 'Кнопка вторая',
				'name' => 'hero_btn_second',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '!=',
					'value' => 'front-page.php'
				],
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page'
				]
			],
			[
				[
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_cat'
				]
			]
		],
		'menu_order' => 1,
	]);
	acf_add_local_field_group([
		'key' => 'group_content_block_section',
		'title' => 'Контентное описание',
		'fields' => [
			[
				'key' => 'field_content_block_title',
				'label' => 'Заголовок',
				'name' => 'content_block_title',
				'type' => 'text',
			],
			[
				'key' => 'field_content_block_descr',
				'label' => 'Описание',
				'name' => 'content_block_descr',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '!=',
					'value' => 'front-page.php'
				],
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page'
				]
			],
			[
				[
					'param' => 'taxonomy',
					'operator' => '==',
					'value' => 'product_cat'
				]
			]
		],
		'menu_order' => 34,
	]);
	acf_add_local_field_group([
		'key' => 'group_section_form',
		'title' => 'Секция "Форма"',
		'fields' => [
			[
				'key' => 'field_section_form_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => 'Обязательно введите данные на Главной странице, остальные страницы по умолчанию будут брать данные от туда <a href="' . esc_url(admin_url('/edit.php?post_type=page')) . '" target="_blank">Перейти</a>',
			],
			[
				'key' => 'field_section_form_title',
				'label' => 'Заголовок',
				'name' => 'section_form_title',
				'type' => 'text'
			],
			[
				'key' => 'field_section_form_descr',
				'label' => 'Описание',
				'name' => 'section_form_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_section_form_form',
				'label' => 'Шорткод формы',
				'name' => 'section_form_form',
				'type' => 'text',
				'placeholder' => '[contact-form-7 id="123" title="Контактная форма"]',
				'instructions' => 'Вставьте шорткод CF7, WPForms или другой формы'
			],
			[
				'key' => 'field_section_form_image',
				'label' => 'Изображение (Desktop)',
				'name' => 'section_form_image',
				'type' => 'image',
				'return_format' => 'array',
				'instructions' => 'Изображение для десктопной версии'
			],
			[
				'key' => 'field_section_form_image_mobile',
				'label' => 'Изображение (Tablet/Mobile)',
				'name' => 'section_form_image_mobile',
				'type' => 'image',
				'return_format' => 'array',
				'instructions' => 'Изображение для планшетной/мобильной версии. Если не заполнено, будет использовано десктопное.'
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page'
				]
			]
		],
		'menu_order' => 34,
	]);
	//! HOME
	acf_add_local_field_group(array(
		'key' => 'group_home_hero_section',
		'title' => 'Секция: Первый экран (Hero)',
		'fields' => array(
			array(
				'key' => 'field_home_hero_slides',
				'label' => 'Слайды',
				'name' => 'home_hero_slides',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить слайд',
				'sub_fields' => array(
					array(
						'key' => 'field_slide_label',
						'label' => 'Лейбл (над заголовком)',
						'name' => 'label',
						'type' => 'text',
					),
					array(
						'key' => 'field_slide_title',
						'label' => 'Заголовок слайда',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_slide_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					),
					array(
						'key' => 'field_slide_btn',
						'label' => 'Кнопка',
						'name' => 'btn',
						'type' => 'link',
					),
					array(
						'key' => 'field_slide_image',
						'label' => 'Изображение (Десктоп)',
						'name' => 'image',
						'type' => 'image',
					),
					array(
						'key' => 'field_slide_image_mobile',
						'label' => 'Изображение (Мобильное)',
						'name' => 'image_mobile',
						'type' => 'image',
					),
				),
			),

			array(
				'key' => 'field_phone_number',
				'label' => 'Номер телефона',
				'name' => 'home_hero_phone',
				'type' => 'text',
				'instructions' => 'Введите номер телефона для отображения',
			),
		),

		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php',
				),
			),
		),
	));
	// category
	acf_add_local_field_group([
		'key' => 'group_home_category',
		'title' => 'Секция "Категории на главной"',
		'fields' => [
			[
				'key' => 'field_home_category_title',
				'label' => 'Заголовок',
				'name' => 'home_category_title',
				'type' => 'text'
			],
			[
				'key' => 'field_home_category_descr',
				'label' => 'Описание',
				'name' => 'home_category_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_home_category_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Чтобы добавить Категорию > В боковом меню > Товары > Категории</b><br/><a href="' . esc_url(home_url('/wp-admin/edit-tags.php?taxonomy=product_cat&post_type=product')) . '" target="_blank">Перейти</a>'
			],
			[
				'key' => 'field_home_category_selected',
				'label' => 'Выбрать категории для показа',
				'name' => 'home_category_selected',
				'type' => 'taxonomy',
				'taxonomy' => 'product_cat',
				'field_type' => 'checkbox',
				'return_format' => 'object',
				'add_term' => 0,
				'save_terms' => 0,
				'load_terms' => 0,
				'instructions' => 'Если ничего не выбрано, будут показаны 4 последние категории верхнего уровня'
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php'
				]
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php'
				]
			]
		],
		'menu_order' => 2,
	]);
	// popular
	acf_add_local_field_group([
		'key' => 'group_home_popular',
		'title' => 'Секция "Популярные товары"',
		'fields' => [
			[
				'key' => 'field_home_popular_title',
				'label' => 'Заголовок',
				'name' => 'home_popular_title',
				'type' => 'text',
				'default_value' => 'Популярные товары'
			],
			[
				'key' => 'field_home_popular_descr',
				'label' => 'Описание',
				'name' => 'home_popular_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_home_popular_products',
				'label' => 'Выбрать товары',
				'name' => 'home_popular_products',
				'type' => 'post_object',
				'post_type' => 'product',
				'field_type' => 'multi_select',
				'return_format' => 'id',
				'multiple' => 1,
				'instructions' => 'Выберите товары для отображения в секции. Если ничего не выбрано, будут показаны все рекомендуемые товары (отмечены звездочкой)',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php'
				]
			]
		],
		'menu_order' => 3,
	]);
	// benefits
	acf_add_local_field_group([
		'key' => 'group_section_benefits',
		'title' => 'Секция "Преимущества"',
		'fields' => [
			[
				'key' => 'field_benefits_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => 'Секция по умолчанию будет брать данные с Главной страницы. <a href="' . admin_url('/post.php?post=10&action=edit') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_benefits_title',
				'label' => 'Заголовок',
				'name' => 'benefits_title',
				'type' => 'text',
			],
			[
				'key' => 'field_benefits_descr',
				'label' => 'Описание',
				'name' => 'benefits_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_benefits_list',
				'label' => 'Преимущества',
				'name' => 'benefits_list',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_benefits_item_title',
				'button_label' => 'Добавить преимущество',
				'sub_fields' => [
					[
						'key' => 'field_benefits_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_benefits_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_benefits_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-services.php',
				],
			],
		],
		'menu_order' => 4
	]);
	// services
	acf_add_local_field_group([
		'key' => 'group_service_card_image_fields',
		'title' => 'Изображение для карточки',
		'fields' => [

			[
				'key' => 'field_service_card_image',
				'label' => 'Изображение для карточки',
				'name' => 'service_card_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'services',
				],
			],
		],
	]);

	// Поля секции "Услуги" на странице
	acf_add_local_field_group([
		'key' => 'group_section_services',
		'title' => 'Секция "Услуги"',
		'fields' => [
			[
				'key' => 'field_services_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => 'Карточки услуг выводятся автоматически из раздела <b>Админка → Услуги</b><br/>Чтобы добавить/изменить карточку — перейдите в раздел «Услуги» и отредактируйте нужную запись<br/> <a href="' . admin_url('/edit.php?post_type=services') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_services_title',
				'label' => 'Заголовок',
				'name' => 'services_title',
				'type' => 'text',
			],
			[
				'key' => 'field_services_descr',
				'label' => 'Описание',
				'name' => 'services_descr',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-services.php',
				],
			],
		],
		'menu_order' => 5,
	]);

	// slider
	acf_add_local_field_group([
		'key' => 'group_section_slider',
		'title' => 'Секция "Слайдер"',
		'fields' => [
			[
				'key' => 'field_slider_slides',
				'label' => 'Слайды',
				'name' => 'slider_slides',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_slider_slide_title',
				'button_label' => 'Добавить слайд',
				'sub_fields' => [
					[
						'key' => 'field_slider_slide_label',
						'label' => 'Надзаголовок',
						'name' => 'label',
						'type' => 'text',
					],
					[
						'key' => 'field_slider_slide_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_slider_slide_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 4,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_slider_slide_image',
						'label' => 'Изображение (Desktop)',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_slider_slide_image_mobile',
						'label' => 'Изображение (Mobile)',
						'name' => 'image_mobile',
						'type' => 'image',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
		'menu_order' => 6,
	]);

	// process
	acf_add_local_field_group([
		'key' => 'group_section_process',
		'title' => 'Секция "Как мы работаем"',
		'fields' => [
			[
				'key' => 'field_process_title',
				'label' => 'Заголовок',
				'name' => 'process_title',
				'type' => 'text',
			],
			[
				'key' => 'field_process_descr',
				'label' => 'Описание',
				'name' => 'process_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_process_steps',
				'label' => 'Шаги процесса',
				'name' => 'process_steps',
				'type' => 'repeater',
				'required' => 0,
				'layout' => 'block',
				'collapsed' => 'field_process_step_title',
				'button_label' => 'Добавить шаг',
				'sub_fields' => [
					[
						'key' => 'field_process_step_icon',
						'label' => 'Иконка',
						'name' => 'step_icon',
						'type' => 'image',
					],
					[
						'key' => 'field_process_step_title',
						'label' => 'Заголовок шага',
						'name' => 'step_title',
						'type' => 'text',
					],
					[
						'key' => 'field_process_step_descr',
						'label' => 'Описание шага',
						'name' => 'step_descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php'
				]
			]
		],
		'menu_order' => 7,
	]);

	acf_add_local_field_group([
		'key' => 'group_section_docs',
		'title' => 'Секция "Документы и сертификаты"',
		'fields' => [
			[
				'key' => 'field_docs_title',
				'label' => 'Заголовок',
				'name' => 'docs_title',
				'type' => 'text',
			],
			[
				'key' => 'field_docs_descr',
				'label' => 'Описание',
				'name' => 'docs_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_docs_message',
				'label' => 'Инструкция',
				'name' => 'docs_message',
				'type' => 'message',
				'message' => '<b>Чтобы добавить документы:</b><br/>Перейдите в Панель управления сайтом → Записи →  Документы → Добавить новый.<br/><a href="' . esc_url(admin_url('edit.php?post_type=documents')) . '" target="_blank" rel="noopener">Открыть раздел «Документы»</a>',

			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-services.php',
				],
			],
		],
		'menu_order' => 8,
	]);


	// single-product
	acf_add_local_field_group([
		'key' => 'group_product_details',
		'title' => 'Детали товара',
		'fields' => [
			[
				'key' => 'field_product_tab_specs',
				'label' => 'Характеристики',
				'name' => 'product_tab_specs',
				'type' => 'tab',
			],
			// Характеристики
			[
				'key' => 'field_product_specs',
				'label' => 'Характеристики',
				'name' => 'product_specs',
				'type' => 'repeater',
				'layout' => 'table',
				'collapsed' => 'field_product_specs_key',
				'button_label' => 'Добавить характеристику',
				'sub_fields' => [
					[
						'key' => 'field_product_specs_key',
						'label' => 'Название',
						'name' => 'key',
						'type' => 'text',
						'column_width' => '40'
					],
					[
						'key' => 'field_product_specs_value',
						'label' => 'Значение',
						'name' => 'value',
						'type' => 'text',
						'column_width' => '60'
					],
				],
			],
			[
				'key' => 'field_product_tab_docs',
				'label' => 'Документация',
				'name' => 'product_tab_docs',
				'type' => 'tab',
			],
			// Документация
			[
				'key' => 'field_product_docs',
				'label' => 'Документация',
				'name' => 'product_docs',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_product_docs_title',
				'button_label' => 'Добавить документ',
				'sub_fields' => [
					[
						'key' => 'field_product_docs_title',
						'label' => 'Название документа',
						'name' => 'title',
						'type' => 'text',
						'instructions' => 'Если оставить пустым, будет использовано имя файла'
					],
					[
						'key' => 'field_product_docs_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'text',
						'placeholder' => 'Краткое описание документа'
					],
					[
						'key' => 'field_product_docs_file',
						'label' => 'Файл',
						'name' => 'file',
						'type' => 'file',
					],
				],
			],
			[
				'key' => 'field_product_tab_delivery',
				'label' => 'Доставка и оплата',
				'name' => 'product_tab_delivery',
				'type' => 'tab',
			],
			// Доставка и оплата
			[
				'key' => 'field_product_delivery',
				'label' => 'Доставка и оплата',
				'name' => 'product_delivery',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_product_delivery_descr',
				'button_label' => 'Добавить блок',
				'sub_fields' => [
					[
						'key' => 'field_product_delivery_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					],
				],
			],
			[
				'key' => 'field_product_tab_producer',
				'label' => 'Производство',
				'name' => 'product_tab_producer',
				'type' => 'tab',
			],
			[
				'key' => 'field_product_producer',
				'label' => 'Производство',
				'name' => 'product_producer',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product'
				]
			]
		],
		'menu_order' => 8,
	]);
	// cart
	acf_add_local_field_group([
		'key' => 'group_cart',
		'title' => 'Контент корзины',
		'fields' => [
			[
				'key' => 'field_cart_tab',
				'label' => 'Блок итого',
				'name' => 'cart_tab',
				'type' => 'tab',
			],
			[
				'key' => 'field_cart_btn',
				'label' => 'Кнопка консультации',
				'name' => 'cart_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_cart_note',
				'label' => 'Описание',
				'name' => 'cart_note',
				'type' => 'textarea',
				'rows' => 3
			],
			[
				'key' => 'field_cart_empty_tab',
				'label' => 'Пустая корзина',
				'name' => 'cart_empty_tab',
				'type' => 'tab',
			],
			[
				'key' => 'field_cart_empty_title',
				'label' => 'Заголовок',
				'name' => 'cart_empty_title',
				'type' => 'textarea',
				'default_value' => 'Ваша корзина пуста',
			],
			[
				'key' => 'field_cart_empty_text',
				'label' => 'Описание',
				'name' => 'cart_empty_text',
				'type' => 'textarea',
				'rows' => 2,
				'default_value' => 'Добавьте товары из каталога, чтобы оформить заказ.',
			],
			[
				'key' => 'field_cart_empty_btn',
				'label' => 'Кнопка',
				'name' => 'cart_empty_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-cart.php'
				]
			]
		],
		'menu_order' => 1,
	]);
	// checkout
	acf_add_local_field_group([
		'key' => 'group_checkout',
		'title' => 'Контент страницы оформления заказа',
		'fields' => [

			[
				'key' => 'field_checkout_payment_note',
				'label' => 'Описание',
				'name' => 'checkout_payment_note',
				'type' => 'textarea',
				'rows' => 3
			],
			[
				'key' => 'field_checkout_term_link',
				'label' => 'Ссылка на условиями оплаты и доставки',
				'name' => 'checkout_term_link',
				'type' => 'link',
			],
			[
				'key' => 'field_checkout_btn',
				'label' => 'Кнопка консультации',
				'name' => 'checkout_btn',
				'type' => 'link',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-checkout.php'
				]
			]
		],
		'menu_order' => 1,
	]);

}
// page-about
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_about',
		'title' => 'Секция "О компании"',
		'fields' => [
			[
				'key' => 'field_about_title',
				'label' => 'Заголовок',
				'name' => 'about_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_descr',
				'label' => 'Описание',
				'name' => 'about_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_about_image',
				'label' => 'Изображение',
				'name' => 'about_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}
// page-services
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_services_process',
		'title' => 'Секция "Процесс работы"',
		'fields' => [
			[
				'key' => 'field_services_process_title',
				'label' => 'Заголовок',
				'name' => 'services_process_title',
				'type' => 'text',
			],
			[
				'key' => 'field_services_process_descr',
				'label' => 'Описание',
				'name' => 'services_process_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_services_process_steps',
				'label' => 'Шаги процесса',
				'name' => 'services_process_steps',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_services_process_step_title',
				'button_label' => 'Добавить шаг',
				'sub_fields' => [
					[
						'key' => 'field_services_process_step_title',
						'label' => 'Заголовок шага',
						'name' => 'step_title',
						'type' => 'text',
					],
					[
						'key' => 'field_services_process_step_descr',
						'label' => 'Описание шага',
						'name' => 'step_descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-services.php',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'services',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_service_about',
		'title' => 'Секция "О услуге"',
		'fields' => [
			[
				'key' => 'field_service_about_title',
				'label' => 'Заголовок',
				'name' => 'service_about_title',
				'type' => 'text',
			],
			[
				'key' => 'field_service_about_descr',
				'label' => 'Описание',
				'name' => 'service_about_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_service_about_list',
				'label' => 'Пункты',
				'name' => 'service_about_list',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_service_about_item_descr',
				'button_label' => 'Добавить пункт',
				'sub_fields' => [
					[
						'key' => 'field_service_about_item_descr',
						'label' => 'Текст пункта',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
						'instructions' => 'Краткое описание преимущества или особенности услуги',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'services',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_service_benefits',
		'title' => 'Секция "Преимущества услуги"',
		'fields' => [
			[
				'key' => 'field_service_benefits_list',
				'label' => 'Преимущества',
				'name' => 'service_benefits_list',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_service_benefits_item_title',
				'button_label' => 'Добавить преимущество',
				'sub_fields' => [
					[
						'key' => 'field_service_benefits_item_image',
						'label' => 'Иконка/Изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_service_benefits_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_service_benefits_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'services',
				],
			],
		],
	]);
}

// page-for-buyers
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_how_to_order',
		'title' => 'Секция "Как оформить заказ"',
		'fields' => [
			[
				'key' => 'field_how_to_order_title',
				'label' => 'Заголовок',
				'name' => 'how_to_order_title',
				'type' => 'text',
			],
			[
				'key' => 'field_how_to_order_descr',
				'label' => 'Описание',
				'name' => 'how_to_order_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_how_to_order_list',
				'label' => 'Пункты',
				'name' => 'how_to_order_list',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_how_to_order_item_title',
				'button_label' => 'Добавить пункт',
				'sub_fields' => [
					[
						'key' => 'field_how_to_order_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_how_to_order_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_how_to_order_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-for-buyers.php',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_purchase_info',
		'title' => 'Секция "Оплата"',
		'fields' => [
			[
				'key' => 'field_purchase_info_blocks',
				'label' => 'Блоки с информацией',
				'name' => 'purchase_info_blocks',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_purchase_info_block_title',
				'button_label' => 'Добавить блок',
				'sub_fields' => [
					[
						'key' => 'field_purchase_info_block_title',
						'label' => 'Заголовок блока',
						'name' => 'block_title',
						'type' => 'text',
					],
					[
						'key' => 'field_purchase_info_block_list',
						'label' => 'Список карточек',
						'name' => 'block_list',
						'type' => 'repeater',
						'layout' => 'block',
						'collapsed' => 'field_purchase_info_item_title',
						'button_label' => 'Добавить карточку',
						'sub_fields' => [
							[
								'key' => 'field_purchase_info_item_icon',
								'label' => 'Иконка',
								'name' => 'item_icon',
								'type' => 'image',
							],
							[
								'key' => 'field_purchase_info_item_title',
								'label' => 'Заголовок карточки',
								'name' => 'item_title',
								'type' => 'text',
							],
							[
								'key' => 'field_purchase_info_item_descr',
								'label' => 'Описание',
								'name' => 'item_descr',
								'type' => 'textarea',
								'rows' => 3,
								'new_lines' => 'wpautop',
							],
						],
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-for-buyers.php',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_install',
		'title' => 'Секция "Установка/Монтаж"',
		'fields' => [
			[
				'key' => 'field_install_title',
				'label' => 'Заголовок',
				'name' => 'install_title',
				'type' => 'text',
			],
			[
				'key' => 'field_install_descr',
				'label' => 'Описание',
				'name' => 'install_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_install_btn',
				'label' => 'Кнопка',
				'name' => 'install_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_install_list',
				'label' => 'Список преимуществ',
				'name' => 'install_list',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_install_item_descr',
				'button_label' => 'Добавить пункт',
				'sub_fields' => [
					[
						'key' => 'field_install_item_descr',
						'label' => 'Текст пункта',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],
			[
				'key' => 'field_install_image',
				'label' => 'Изображение',
				'name' => 'install_image',
				'type' => 'image',
			],
			[
				'key' => 'field_install_image_mobile',
				'label' => 'Изображение мобильное',
				'name' => 'install_image_mobile',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-for-buyers.php',
				],
			],
		],
	]);
}
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_guarantee',
		'title' => 'Секция "Гарантия"',
		'fields' => [
			[
				'key' => 'field_guarantee_title',
				'label' => 'Заголовок',
				'name' => 'guarantee_title',
				'type' => 'text',
			],
			[
				'key' => 'field_guarantee_descr',
				'label' => 'Описание',
				'name' => 'guarantee_descr',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-for-buyers.php',
				],
			],
		],
	]);
}