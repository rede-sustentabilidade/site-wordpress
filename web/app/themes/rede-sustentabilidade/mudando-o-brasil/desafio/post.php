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


    <div class="desafio-post">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <div class="aviso-autor-desafio">
        <?php
        $participacao_category = get_the_terms(get_the_ID(), 'participacao_category');
        reset($participacao_category);
        $first_key = key($participacao_category);
        ?>
            <a class="" href="<?php echo site_url('/mudando-o-brasil/desafios/'.$participacao_category[$first_key]->slug); ?>">
                Veja todas as contribuições de <?php echo $participacao_category[$first_key]->name; ?>
            </a>
        </div>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <?php if ( has_post_thumbnail() ) { ?>

            <div class="pinbin-image"><?php the_post_thumbnail( 'detail-image' );  ?></div>
	            <div class="post-nav">
                <div class="post-prev"><?php previous_post_link('%link', '&larr;'); ?></div>
                <div class="post-next"><?php next_post_link('%link', '&rarr;'); ?></div>
            	</div>
            <div class="pinbin-copy">

        <?php } else { ?>

        <div class="post-nav">
            <div class="post-prev"><?php previous_post_link('%link', '&larr;'); ?></div>
            <div class="post-next"><?php next_post_link('%link', '&rarr;'); ?></div>
        </div>
        <div class="pinbin-copy">

        <?php } ?>

            <h1><?php the_title(); ?></h1>
            <!--p  class="disclaimer-participe">Este texto não reflete, necessariamente, a opinião da Rede Sustentabilidade. Trata-se de uma contribuição ao debate, sendo de total responsabilidade de seu autor.</p-->
            <div class="meta-user">
                <i class="icon-user-comment"></i>
                <p class="author">Contribuição espontânea postada por:<?php  the_author_meta( 'user_nicename' ); ?><br/></p>
                <p class="date"><?php the_time(get_option('date_format')); ?></p>
            </div>

            <div class="category">
                <a href="#"><?php comments_number( 'Nenhum comentário', 'Um comentário', '% comentários' ); ?></a>
            </div>

            <?php the_content('Read more'); ?>
            <div class="box-like-dislike">
                <?php echo add_list_content(); ?>
            </div>

            <?php comments_template(); ?>
            </div>

        </div>

        <?php endwhile; endif; ?>

    </div>

</div>


<?php get_footer(); ?>
