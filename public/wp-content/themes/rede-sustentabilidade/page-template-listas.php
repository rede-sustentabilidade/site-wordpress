<?php
/*
Template Name: Listas
 */

wp_enqueue_style('listas', get_stylesheet_directory_uri() . '/css/listas.css');
wp_enqueue_script('underscore', get_stylesheet_directory_uri() . '/assets/js/source/underscore-min.js', array('jquery'), '1.5.2', true);
wp_enqueue_script('jquery.floatThead', get_stylesheet_directory_uri() . '/assets/js/source/jquery.floatThead.min.js', array('jquery', 'underscore'), '1.1.1', true);
wp_enqueue_script('impromptu', get_stylesheet_directory_uri() . '/assets/js/source/jquery-impromptu.min.js', array('jquery'), '5.2.1', true);
wp_enqueue_script('listas', get_stylesheet_directory_uri() . '/assets/js/source/listas.js', array('jquery'), '0.1', true);

get_header();

?>

<div id="lists">
<div class="loading">
<span class="icon-refresh"></span> Processando...
</div>
</div>

<?php get_footer(); ?>
