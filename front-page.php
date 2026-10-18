<?php
/*
Template Name: Главная страница
*/
?>
<?php get_header() ?>
<?php get_template_part('partials/home/hero'); ?>
<?php get_template_part('partials/home/category'); ?>
<?php get_template_part('partials/home/popular'); ?>
<?php get_template_part('partials/benefits-section'); ?>
<?php get_template_part('partials/services'); ?>

<?php get_template_part('partials/section-slider'); ?>
<?php get_template_part('partials/section-process'); ?>
<?php get_template_part('partials/section-docs'); ?>
<?php get_template_part('partials/section-form'); ?>
<?php get_template_part('partials/section-contacts'); ?>
<?php get_footer() ?>