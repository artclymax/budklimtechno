<?php
function register_documents_cpt()
{
	$labels = [
		'name' => 'Документы и сертификаты',
		'singular_name' => 'Документ',
		'menu_name' => 'Документы',
		'add_new' => 'Добавить документ',
		'add_new_item' => 'Добавить новый документ',
		'edit_item' => 'Редактировать документ',
		'new_item' => 'Новый документ',
		'view_item' => 'Просмотр документа',
		'search_items' => 'Поиск документов',
		'not_found' => 'Документы не найдены',
		'not_found_in_trash' => 'В корзине документы не найдены',
		'all_items' => 'Все документы',
	];

	$args = [
		'labels' => $labels,
		'menu_icon' => 'dashicons-media-document',
		'public' => false,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => false,
		'show_in_rest' => true,
		'query_var' => false,
		'rewrite' => false,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 10,
		'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
	];

	register_post_type('documents', $args);
}
add_action('init', 'register_documents_cpt');

function budklim_register_services_cpt()
{
	$labels = [
		'name' => 'Услуги',
		'singular_name' => 'Услуга',
		'menu_name' => 'Услуги',
		'add_new' => 'Добавить услугу',
		'add_new_item' => 'Добавить новую услугу',
		'edit_item' => 'Редактировать услугу',
		'new_item' => 'Новая услуга',
		'view_item' => 'Просмотр услуги',
		'search_items' => 'Поиск услуг',
		'not_found' => 'Услуги не найдены',
		'not_found_in_trash' => 'В корзине услуги не найдены',
		'all_items' => 'Все услуги',
		'archives' => 'Архив услуг',
	];

	$args = [
		'labels' => $labels,
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 10,
		'menu_icon' => 'dashicons-hammer',
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
		'has_archive' => false,
		'query_var' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
	];

	register_post_type('services', $args);
}
add_action('init', 'budklim_register_services_cpt');