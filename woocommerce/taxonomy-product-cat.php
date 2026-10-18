<?php

$term = get_queried_object();

// Определяем тип категории
$is_parent = ($term->parent === 0);
$is_child = ($term->parent !== 0);
$parent_term = $is_child ? get_term($term->parent, 'product_cat') : null;
if ($is_parent) {
	get_template_part('template-taxonomy-product-cat-parent');
} else {
	get_template_part('template-taxonomy-product-cat-child');
}
?>