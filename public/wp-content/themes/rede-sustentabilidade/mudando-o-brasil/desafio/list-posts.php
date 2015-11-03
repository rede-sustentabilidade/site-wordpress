<?php
  if (empty($_GET['ordenacao'])) {
      $populares = "active";
      $recentes = "";
  } else {
      $populares = "";
      $recentes = "active";
  }
  ?>
  <div class="box-controles">
    <div class="title">
      <h3><i class="icon-user-comment"></i> Contribuições</h3>
    </div>

    <!--div class="box-visualizacao">
      <h4>Visualizar como</h4>
      <a href="#" class="quadros"><i class="icon-quadros-participe"></i> Quadros</a>
      <a href="#" class="lista active"><i class="icon-lista-participe"></i> Lista</a>
    </div-->

    <div class="box-ordenacao">
      <h4>Ordenar por</h4>
      <a href="./" class="<?php echo $populares; ?>"><i class="icon-gostei"></i>Mais Populares</a>
      <a href="./?ordenacao=mais-recentes" class="<?php echo $recentes; ?>"><i class="icon-calendario"></i>Mais Recentes</a>
    </div>
  </div>

    <?php
    $paged = get_query_var( 'paged' );
    $participe_params = array(
    'post_type'=>'participacao',
    'post_status'=>'publish',
    'posts_per_page'=>300,
    'paged'=>$paged,
);

    if (count($categoryData)>0) {
      $participe_params['participacao_category'] = $categoryCurrent;

    }

    if (empty($_GET['ordenacao'])) {
        $orderby_params = array(
        'meta_query' => array(
        'relation' => 'OR',
        array(
        'key' => 'unlike_post',
    ),
    array(
        'key' => 'like_post',
    )
    ),
    );
    }

    if (empty($_GET['ordenacao'])) {
        add_filter('posts_orderby','double_meta_posts_orderby');
        $participe_query = new WP_Query( array_merge($participe_params, $orderby_params) );
        remove_filter('posts_orderby','double_meta_posts_orderby');
    } else {
        $participe_query = new WP_Query( $participe_params );
    }

    // $temp = array();
    // while ( $participe_query->have_posts() ) : $participe_query->the_post();
    //     $temp[] = get_the_ID() ;
    // endwhile;

    if ($participe_query->have_posts()) : ?>
    <div id="post-area" class="lista">

      <?php while ($participe_query->have_posts()) : $participe_query->the_post(); ?>

      <div id="post-<?php the_ID(); ?>" class="post post-participacao">
        <?php if ($facebookPSB !== 'sim') { ?>
        <h2><a class="front-link" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
        <?php } else { ?>
        <h2><?php the_title(); ?></h2>
        <?php } ?>
        <div class="meta-user">
          <i class="icon-user-comment"></i>
	  <p class="author"><?php  the_author_meta( 'user_nicename' ); ?><br/></p>
	  <p class="date"><?php the_time(get_option('date_format')); ?></p>
        </div>
        <div class="separador"></div>
        <div class="category"><a href="<?php echo the_permalink(); ?>#comment-form"><?php comments_number( 'Nenhum comentário', 'Um comentário', '% comentários' ); ?></a></div>

        <div class="box-like-dislike">
          <?php
          if ($facebookPSB !== 'sim') {
              echo add_list_content();
          }
          ?>
        </div>
      </div>

      <?php endwhile; ?>
    </div>
  </div>
  <nav id="nav-below" class="navigation" role="navigation">
    <div class="view-previous button-pagination"><?php next_posts_link( __( 'Próximo', 'pinbin' ), $participe_query->max_num_pages ) ?></div>
    <div class="view-next button-pagination"><?php previous_posts_link( __( 'Anterior', 'pinbin' ), $participe_query->max_num_pages ) ?> </div>
  </nav>
          <?php endif; ?>
