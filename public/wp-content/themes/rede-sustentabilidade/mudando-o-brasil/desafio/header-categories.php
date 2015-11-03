<div class="categories">
    <?php foreach( $participacaoCategory as $item ) : ?>
      <?php
          /*
           * De/para de categories e icons
           */
          if($item->term_taxonomy_id == 48){
            $iconClass = 'icon-reforma-estado';

          }elseif( $item->term_taxonomy_id == 49 ){
            $iconClass = 'icon-reforma-urbana';

          }elseif( $item->term_taxonomy_id == 50 ){
            $iconClass = 'icon-planejamento-estrategico';

          }elseif( $item->term_taxonomy_id == 51 ){
            $iconClass = 'icon-novo-federalismo';

          }elseif( $item->term_taxonomy_id == 52 ){
            $iconClass = 'icon-desenvolvimento-tecnologico';

          }elseif( $item->term_taxonomy_id == 53 ){
            $iconClass = 'icon-educacao-conhecimento';

          }elseif( $item->term_taxonomy_id == 54 ){
            $iconClass = 'icon-reducao-desigualdade';

          }elseif( $item->term_taxonomy_id == 55 ){
            $iconClass = 'icon-valorizacao-biodiversidade';

          }elseif( $item->term_taxonomy_id == 56 ){
            $iconClass = 'icon-politica-saude';

          }elseif( $item->term_taxonomy_id == 57 ){
            $iconClass = 'icon-seguranca-publica';

          }elseif( $item->term_taxonomy_id == 58 ){
            $iconClass = 'icon-mais-um';

          }
      ?>

      <a href="<?php echo site_url('mudando-o-brasil/desafios/') . $item->slug ?>/#participe" class="category <?php echo (( $item->slug == $categoryCurrent ) ? ' active ' : '') ?>#participe">
        <i class="<?php echo $iconClass ?>"></i> <p><?php
        if (strlen($item->name) > 47) {
          echo substr($item->name , 0, 47) . ' ...';
        }else {
          echo $item->name;
        }
        ?></p>
      </a>

    <?php endforeach; ?>

  </div>
