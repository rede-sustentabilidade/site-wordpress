<div class="question">
  <a id="participe"></a>
  <h2> <i class="<?php echo $categoryCurrentClass ?>"></i> <?php echo $categoryData->name ?></h2>
  <div class="stage">
    <div class="text-intro">
      <div class="questao">
        <?php echo $categoryData->description ?>
      </div>
    </div>

    <div class="form-publish-post" id="desafio-form">
      <form action="" name="desafio" class="pure-form pure-form-stacked form-desafio">
        <fieldset>
          <?php if ( is_user_logged_in() ) { ?>
          <?php } else { ?>
          <legend>Você precisa realizar o login antes <a <?php echo $target_login ?> href="<?php echo wp_login_url( $get_back ); ?>" title="Login">clicando aqui.</a></legend>
          <?php } ?>
          <div class="pure-g-r">
            <div class="pure-u-1">


              <select name="desafio_category"<?php echo $disable; ?>>
                  <option value=''>Selecione a categoria</option>
                <?php foreach( $participacaoCategory as $item ): ?>
                  <option value='<?php echo $item->term_id ?>' <?php echo ($item->slug == $categoryCurrent ? 'selected="selected"' : ''); ?>><?php echo $item->name ?></option>
                <?php endforeach; ?>
              </select>

            </div>
            <div class="pure-u-1">
              <input type="text" name="desafio_title" id="desafio_title" <?php echo $disable; ?> class="pure-input-1" placeholder="Título do seu comentário"/>
            </div>

            <div class="pure-u-1">
              <textarea type="text" name="desafio_content" id="desafio_content" rows="10" <?php echo $disable; ?> class="pure-input-1" placeholder="Seu comentário"></textarea>
            </div>
          </div>

        </fieldset>
        <a type="button" href="#" <?php echo $disable; ?> id="btn_desafio"> <span class="enviar"></span> Enviar comentário</a>
      </form>
    </div>

  </div>
</div>
