
<?php
/**
 * Theme index file
 */

get_header();
echo "</div><div class='slide-posts-featured'>";
echo do_shortcode('[advps-slideshow optset="3"]');
echo "</div><div id='wrap'>";
get_sidebar();
if (have_posts()) : ?>
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
            <p class="date" title="<?php the_date(); echo " "; the_time(); ?>">
                <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> atrás
            </p>
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
<style>
    #bannerAmazonia {
      display: block;
      position: fixed;
      top: 200px;
      right: 200px;
      width: 350px;
      height: 350px;
      background: white;
      border: 1px solid #24603C;
      box-shadow: 0 20px 30px rgba(0, 0, 0, .5);
      z-index: 99999;
    }

    #bannerAmazonia a:nth-child(2) {
      display: inline-block;
      position: absolute;
      top: 0;
      right: 0;
      font-family: sans-serif;
      font-weight: lighter;
      font-style: normal;
      font-size: 10px;
      text-decoration: none;
      text-transform: uppercase;
      color: white;
      background-color: #24603C;
      padding: 5px 10px;
      z-index: 10;
      border-bottom-left-radius: 10px;
    }
  </style>
  <div id="bannerAmazonia">
    <a href="https://redesustentabilidade.org.br/2017/08/31/rede-participa-do-ato-mundial-em-defesa-da-amazonia-neste-sabado-em-macapa/"
      target="_self">
      <img src="https://rede-sustentabilidade-org.s3-sa-east-1.amazonaws.com/2017/09/rede-amazonia.jpg" alt="Ato em defesa da Amazônia - 2 set - 16h" />
    </a>
    <a href="javascript: bannerAmazoniaFechar();">fechar</a>
  </div>
  <script>
    function bannerAmazoniaFechar() {
      var banner = document.getElementById('bannerAmazonia');

      if (banner) {
        banner.parentElement.removeChild(banner);
      }
    }
  </script>
<?php get_footer(); ?>
