<?php ini_set('display_errors', 0); wp_enqueue_style('rs-regionalization', get_stylesheet_directory_uri().'/css/regionalization.css', array('style'), time()); ?>
<?php get_header(); ?>
  <?php $showing_events = 'event' == get_query_var('post_type'); if (!$showing_events) : ?>
  <?php $events = get_posts(array('post_type' => 'event', 'tax_query' => array(array('taxonomy' => 'state', 'terms' => get_queried_object()->term_id)), 'numberposts' => -1, 'meta_query' => array(array('key' => '__event_date', 'value' => date('Y-m-d'), 'compare' => '>=')), 'meta_key' => '__event_date', 'order' => 'ASC', 'orderby' => 'meta')); ?>
  <?php if (!empty($events)) : ?>
  <div class="region-events">
    <div class="wrap">
      <h2>Agenda</h2>
      <?php foreach ($events as $post) : setup_postdata($post); ?>
      <?php
      $date = get_post_meta(get_the_ID(), '__event_date', true);
      $time = get_post_meta(get_the_ID(), '__event_time', true);
      $place = get_post_meta(get_the_ID(), '__event_place', true);
      ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="copy"><h2><a class="front-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <?php if (has_post_thumbnail()) : ?>
        <div class="image"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('regional-thumb');  ?></a></div>
        <?php endif; ?>
        <div class="category"><?php the_taxonomies(array('sep' => ', ', 'template' => '%2$l')) ?></div>
        <p class="date <?php if (has_post_thumbnail()) echo 'has-image'; ?>"><?php echo date_i18n(get_option('date_format'), strtotime($date)); ?><?php if ($time) echo ', '.$time; ?><?php if ($place) echo ', '.$place; ?></p>
        <div class="excerpt <?php if (has_post_thumbnail()) echo 'has-image'; ?>">
          <?php the_excerpt(); ?>
        </div>
        <a class="link" href="<?php the_permalink() ?>"><i class="icon-seta-em-frente"></i></a>
        </div>
      </div>
      <?php endforeach; wp_reset_postdata(); ?>
    </div>
  </div>
  <?php endif; ?>
  <?php endif; ?>
  <?php if (have_posts()) : ?>
  <div class="region-posts">
    <div class="wrap">
      <?php if ('event' == get_post_type()) : ?>
      <h2>Agenda</h2>
      <?php else: ?>
      <h2>Últimas notícias</h2>
      <?php endif; ?>
      <?php while (have_posts()) : the_post(); ?>
      <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="copy"><h2><a class="front-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <?php if (has_post_thumbnail()) : ?>
        <div class="image"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail('regional-thumb');  ?></a></div>
        <?php endif; ?>
        <div class="category"><?php the_taxonomies(array('sep' => ', ', 'template' => '%2$l')) ?></div>
        <?php if ('event' == get_post_type()) : ?>
        <?php
        $date = get_post_meta(get_the_ID(), '__event_date', true);
        $time = get_post_meta(get_the_ID(), '__event_time', true);
        $place = get_post_meta(get_the_ID(), '__event_place', true);
        ?>
        <p class="date <?php if (has_post_thumbnail()) echo 'has-image'; ?>"><?php echo date_i18n(get_option('date_format'), strtotime($date)); ?><?php if ($time) echo ', '.$time; ?><?php if ($place) echo ', '.$place; ?></p>
        <?php else : ?>
        <p class="date <?php if (has_post_thumbnail()) echo 'has-image'; ?>"><?php the_time(get_option('date_format')); ?></p>
        <?php endif; ?>
        <div class="excerpt <?php if (has_post_thumbnail()) echo 'has-image'; ?>">
          <?php the_excerpt(); ?>
        </div>
        <a class="link" href="<?php the_permalink() ?>"><i class="icon-seta-em-frente"></i></a>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <?php elseif (empty($events)) : ?>
  <article id="post-0" class="post no-results not-found">
    <header class="entry-header">
      <h1 class="entry-title"><?php _e('Nothing Found', 'pinbin'); ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
      <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'pinbin'); ?></p>
      <?php get_search_form(); ?>
    </div><!-- .entry-content -->
  </article><!-- #post-0 -->
  <?php endif; ?>
  <nav id="nav-below" class="navigation" role="navigation">
    <div class="view-previous button-pagination"><?php next_posts_link(__('Próximo', 'pinbin')); ?></div>
    <div class="view-next button-pagination"><?php previous_posts_link(__('Anterior', 'pinbin')); ?> </div>
  </nav>
<?php get_footer(); ?>
