<?php
/*
Template Name: Lista de Participações
 */

if ( is_user_logged_in() ) {
    $disable = '';
} else {
    $disable = 'disabled="disabled"';
}
?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div id="participe">
  <div class="header">
    <h1><?php the_title(); ?></h1>
    <div class="sticker">
    </div>
    <p>Acreditamos que toda mudança se dá através da construção
      coletiva, pois apenas com a participação de todos podemos caminhar
      em direção à um Brasil mais justo, próspero e sustentável. Nessa
      seção, você pode participar da construção da #Rede, deixando sua
      opinião sobre os diferentes temas propostos nas abas abaixo.</p>
  </div>

  <div class="box-call-to-action">
    <div class="text-intro">
      <div class="questao">
          <?php the_content(); ?>
      </div>
      <div class="more">
        <div class="volta">
          <
        </div>
        <div class="content">
        </div>
      </div>
    </div>

    <div class="form-publish-post" id="participacao-form">
      <h2>O que você quer para o Brasil</h2>
      <form action="" name="participe" class="pure-form pure-form-stacked form-doacao">
	<fieldset>
	  <?php
	  $facebookPSB = get_post_meta(get_queried_object_id(), "facebook-psb", true);

	  if ($facebookPSB === 'sim') {
	      $get_back = 'https://www.facebook.com/eduardocampos40/app_1464301680461931';
	      $target_login = "target='_top'";
	      $target_post =  "target='_blank'";
	  } else {
	      $get_back = get_permalink();
	      $target_login = "";
	      $target_post = "";
	  }
	  ?>
	  <?php if ( is_user_logged_in() ) { ?>
          <legend><?php echo $current_user->user_nicename; ?>, faça sua contribuição preenchendo os campos abaixo:</legend>
	  <?php } else { ?>
	  <legend>Você precisa conectar-se com a #rede antes <a <?php echo $target_login ?> href="<?php echo wp_login_url( $get_back ); ?>" title="Login">clicando aqui.</a></legend>
	  <?php } ?>
	  <div class="pure-g-r">
            <div class="pure-u-1">
	      <label for="participe_title">Título da sua proposta*:</label>
	      <input type="text" name="participe_title" id="participe_title" <?php echo $disable; ?> class="pure-input-1" />
	    </div>

            <div class="pure-u-1">
	      <label for="participe_content">Descreva em detalhes sua proposta*:</label>
	      <textarea type="text" name="participe_content" id="participe_content" rows="10" <?php echo $disable; ?> class="pure-input-1"></textarea>
	    </div>
	  </div>
	</fieldset>
	<button type="button" <?php echo $disable; ?> class="pure-button" id="btn_participe">Contribuir</button>
      </form>

      <script type="text/javascript">
      jQuery(document).ready(function () {
	  var participe = new ParticipeForm(document.forms[0]);
	  participe.init();
      });
      </script>
    </div>
          <?php endwhile; endif; ?>
  </div>


    <div class="box-disclamer">
      <h2><i class="icon-user-comment"></i>Opiniões dos participantes</h2>
      <p>Os textos abaixo não refletem, necessariamente, a opinião da Rede Sustentabilidade. Tratam-se de contribuições ao debate, sendo de total responsabilidade de seu autores.</p>
    </div>
    <?php
    if (empty($_GET['ordenacao'])) {
        $populares = "active";
        $recentes = "";
    }else {
        $populares = "";
        $recentes = "active";
    }

    ?>
    <div class="box-controles">

      <div class="box-visualizacao">
        <h3>Visualizar como</h3>
        <a href="#" class="quadros"><i class="icon-quadros-participe"></i> Quadros</a>
        <a href="#" class="lista active"><i class="icon-lista-participe"></i> Lista</a>
      </div>

      <div class="box-ordenacao">
        <h3>Ordenar por</h3>
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
        <div class="social">
          <div class="category"><a href="#"><?php comments_number( 'Nenhum comentário', 'Um comentário', '% comentários' ); ?></a></div>

          <div class="excerpt">
            <i class="icon-citacao"></i>
            <?php the_excerpt(); ?>
            <i class="icon-citacao-fecha"></i>
          </div>

          <div class="box-like-dislike">
            <?php
            if ($facebookPSB !== 'sim') {
                echo add_list_content();
            }
            ?>
          </div>
          <?php if ($facebookPSB !== 'sim') { ?>
          <a class="link" href="<?php the_permalink() ?>">Ler e comentar<i class="icon-seta-em-frente"></i></a>
          <?php } ?>
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
</div>



<?php get_footer(); ?>