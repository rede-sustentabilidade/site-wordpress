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

	    <?php require_once REDETHEME . '/mudando-o-brasil/desafio/list-posts.php' ?>
	</div>

<script>
jQuery('.menu a').removeClass("active");
jQuery('.desafio').addClass("active");
</script>
<?php get_footer(); ?>