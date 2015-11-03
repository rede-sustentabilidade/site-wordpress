<?php
if ( is_user_logged_in() ) {
    $disable = '';
} else {
    $disable = 'disabled="disabled"';
}
?>
<?php get_header(); ?>

	<div id="desafios">
	    <?php require_once REDETHEME . '/mudando-o-brasil/desafio/header.php' ?>

	    <?php require_once REDETHEME . '/mudando-o-brasil/desafio/header-categories.php' ?>

	    <?php require_once REDETHEME . '/mudando-o-brasil/desafio/form.php' ?>

	    <?php require_once REDETHEME . '/mudando-o-brasil/desafio/list-posts.php' ?>
	</div>

<?php get_footer(); ?>