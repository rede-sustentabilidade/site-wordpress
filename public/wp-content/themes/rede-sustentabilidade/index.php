<?php
/**
 * Theme index file
 */
get_header(); ?>
<?php get_sidebar(); ?>
<?php if (have_posts()) : ?>
<div id="post-area">
    <?php while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if (has_post_thumbnail()) : ?>
        <div class="image">
            <a href="<?php the_permalink() ?>">
                <?php the_post_thumbnail('summary-image');  ?>
                <?php if (get_post(get_post_thumbnail_id())->post_excerpt) echo '<p>' . get_post(get_post_thumbnail_id())->post_excerpt . '</p>'; ?>
            </a>
        </div>
        <?php endif; ?>
        <div class="copy">
            <h2><a class="front-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
            <div class="category"><?php the_category(', ') ?></div>
            <p class="author"><?php the_author(); ?></p>
            <p class="date"><?php the_time(get_option('date_format')); ?></p>
            <div class="excerpt">
                <?php the_excerpt(); ?>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>
<?php else : ?>
<article id="post-0" class="post no-results not-found">
        <header class="entry-header">
          <h1 class="entry-title"><?php _e( 'Nothing Found', 'pinbin' ); ?></h1>
        </header><!-- .entry-header -->
        <div class="entry-content">
          <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pinbin' ); ?></p>
          <?php get_search_form(); ?>
        </div><!-- .entry-content -->
</article><!-- #post-0 -->
<?php endif; ?>
<nav id="nav-below" class="navigation" role="navigation">
    <div class="view-previous button-pagination"><?php next_posts_link(__('Anterior', 'pinbin')); ?></div>
    <div class="view-next button-pagination"><?php previous_posts_link(__('Próximo', 'pinbin')); ?></div>
</nav>
<?php get_footer(); ?>
