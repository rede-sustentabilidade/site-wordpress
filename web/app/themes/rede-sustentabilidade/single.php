<?php
/**
* Single post template
*/
ini_set('display_errors', 0);
?>
<?php if (has_term(null, 'state')) wp_enqueue_style('rs-regionalization', get_stylesheet_directory_uri().'/css/regionalization.css', array('style'), time()); ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="post-header">
            <?php if (has_post_thumbnail()) { ?>
            <div class="pinbin-image"><?php the_post_thumbnail(); ?></div>
            <!--style>.pinbin-image { background-image: url("<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'detail-image')[0];  ?>"); }</style-->
            <?php } ?>
            <div class="pinbin-category"><p><?php the_category(', ') ?></p></div>
        </header>
        <div class="pinbin-copy">
            <h1><?php the_title(); ?></h1>
            <p class="pinbin-meta"><strong><?php the_author(); ?></strong> <?php the_time(get_option('date_format')); ?></p>
            <?php the_content('Read more'); ?>
            <?php if ('event' == get_post_type()) : ?>
            <?php
            $date = get_post_meta(get_the_ID(), '__event_date', true);
            $time = get_post_meta(get_the_ID(), '__event_time', true);
            $place = get_post_meta(get_the_ID(), '__event_place', true);
            ?>
            <dl>
              <?php if (!empty($date)) : ?>
              <dt>Data</dt>
              <dd><?php echo date('d/m/Y', strtotime($date)); ?>
              <?php endif; ?>
              <?php if (!empty($time)) : ?>
              <dt>Hora</dt>
              <dd><?php echo $time; ?>
              <?php endif; ?>
              <?php if (!empty($place)) : ?>
              <dt>Local</dt>
              <dd><?php echo $place; ?>
              <?php endif; ?>
            </dl>
            <?php endif ?>
            <?php comments_template(); ?>
        </div>
    </div>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
