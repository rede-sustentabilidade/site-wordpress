<?php
  /*
   * Consumindo categorias de participacao (desafios)
   */

  $get_back = get_permalink();
  $participacaoCategory = get_terms( 'participacao_category', 'orderby=id' );

  // Current category
  $categoryCurrent = $wp_query->query_vars['participacao_category'];

  // Definindo qual é o tipo da página que esta sendo visualizada
  if( $wp_query->query_vars['post_type'] == 'participacao' ){
    $desafioTypePage = 'post';

  }elseif( $wp_query->query_vars['participacao_category'] != '' ){
    $desafioTypePage = 'category';

  }else{
    $desafioTypePage = 'landing';
  }

  // Pegando os dados da categoria para exibir na página interna da categoria

  foreach( $participacaoCategory as $item ){

	  /*
	   * De/para de categories e icons
	   */

	  if( ($item->term_taxonomy_id == 48) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-reforma-estado';
      $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 49 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-reforma-urbana';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 50 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-planejamento-estrategico';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 51 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-novo-federalismo';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 52 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-desenvolvimento-tecnologico';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 53 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-educacao-conhecimento';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 54 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-reducao-desigualdade';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 55 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-valorizacao-biodiversidade';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 56 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-politica-saude';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 57 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-seguranca-publica';
	    $categoryData = $item;

	  }elseif( ($item->term_taxonomy_id == 58 ) && ($item->slug == $categoryCurrent ) ){
	    $categoryCurrentClass = 'icon-mais-um';
	  }

	}

?>
<div class="header">

    <?php require_once REDETHEME . '/mudando-o-brasil/menu.php' ?>

    <div class="content">

      <div class="sub-header">
				<a href="<?php echo site_url('mudando-o-brasil/desafios/') ?>">
	        <i class="partido psb"></i>
	        <i class="partido rede"></i>
	        <h1>
	          <span class="title">Mudando o Brasil</span>
	          <span class="sub">Desafios</span>
	        </h1>
	      </a>

      </div>

      <p>Aqui você pode dar a sua colaboração sobre os 9 desafios encontrados para construirmos um Brasil mais justo e sustentável. Escolha uma categoria para incluir sua contribuição.</p>

    </div>
    <?php if ( (preg_match('/mudando/', $_SERVER['HTTP_HOST'])) ){  ?>
      <div class="login">
        <?php if ( is_user_logged_in() ) { ?>
            <?php global $current_user; wp_get_current_user(); ?>
              <a class="welcome-message label"><?php echo $current_user->user_nicename; ?></a>
              <a href="<?php echo wp_logout_url(); ?>">Sair</a>
        <?php } else {

         ?>
              <a href="<?php echo wp_registration_url() . '&redirect_to=' . $get_back; ?>" class="label borderd">registre-se</a>
              <a href="<?php echo wp_login_url($get_back); ?>" class="label"><strong>login</strong></a>
        <?php } ?>
      </div>
    <?php } ?>
  </div>
