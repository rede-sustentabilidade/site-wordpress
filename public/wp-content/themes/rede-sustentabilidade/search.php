<?php

/* The template for displaying Search Results pages. */

get_header(); ?>

<section id="search" class="site-content type-page results-page">
  <div id="content" role="main">

    <?php if ( have_posts() ) : ?>

    <header class="page-header">
      <h1 class="page-title"><?php printf( __( 'resultados encontrados na busca por: %s', 'pinbin' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header>
    <?php while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <?php if ( has_post_thumbnail() ) { ?>
      <div class="pinbin-image"><?php the_post_thumbnail( 'detail-image' );  ?></div>
      <?php } ?>
      <div class="pinbin-copy"><h2><a class="front-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <p class="pinbin-date"><?php the_time(get_option('date_format')); ?>  </p>

        <?php the_excerpt(); ?>

      </div>

      <a class="read-more" href="<?php the_permalink() ?>"> <i class="icon-seta-em-frente"></i> </a>
    </div>
    <?php endwhile; ?>

			<?php else : ?>

    <article id="post-0" class="post no-results not-found">
      <header class="entry-header">
	<h1 class="entry-title"><?php _e( 'Não encontrado', 'pinbin' ); ?></h1>
      </header><!-- .entry-header -->

      <div class="entry-content">
	<p><?php _e( 'Desculpe, mas nada foi encontrado utilizando os temos de sua busca. Por favor, tente novamente com palavras-chave diferentes.', 'pinbin' ); ?></p>
      </div><!-- .entry-content -->
    </article><!-- #post-0 -->

      <?php endif; ?>

  </div><!-- #content -->
</section><!-- #primary .site-content -->

<nav id="nav-below" class="navigation" role="navigation">
    <div class="view-previous button-pagination"><?php next_posts_link( __( 'Próximo', 'pinbin' ) ) ?></div>
    <div class="view-next button-pagination"><?php previous_posts_link( __( 'Anterior', 'pinbin' ) ) ?> </div>
</nav>

<?php get_footer(); ?>
