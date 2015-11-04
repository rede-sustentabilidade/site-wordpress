<div class="wrap">
  <h2>Filiado: <?php echo $profile->fullname; ?> <!-- <a href="http://rede.local/wp/wp-admin/post-new.php?post_type=page" class="add-new-h2">Adicionar Nova</a> --></h2>
  <p>Tenha cuidado ao editar o filiado, os dados apresentados estão exatamente como são salvos no banco de dados.</p>
  <p>É muito importante só alterar o necessário e incluir apenas informações reais.</p>

<?php if ( (isset($aviso)) && (!empty($aviso))) { ?>
  <div class="updated">
        <p><?php _e( $aviso, 'my-text-domain' ); ?></p>
  </div>
<?php } ?>

  <form method="POST" id="profileFiliado" action="<?php echo admin_url( 'admin.php' ); ?>">
    <input type="hidden" value="rs_filiado_profile" name="action">
    <fieldset>
      <legend>Dados básicos</legend>

      <div class="input text alignleft">
        <label for="">ID Usuário</label>
        <input type="text" name="user_id" value="<?php echo $profile->user_id; ?>" readonly="readonly">
      </div>

      <div class="input text alignleft">
        <label for="">E-mail</label>
        <input type="text" name="email" value="<?php echo $profile->email; ?>" readonly="readonly">
      </div>

      <div class="input text alignleft">
        <label for="">Nome</label>
        <input type="text" name="fullname" required value="<?php echo $profile->fullname; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Nome da mãe</label>
        <input type="text" name="nome_mae" value="<?php echo $profile->nome_mae; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Data de nascimento (AAAA-MM-DD)</label>
        <input type="text" name="birthday" required value="<?php echo $profile->birthday; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Sexo</label>
        <select name="sexo" required>
            <option value="">Todos</option>
            <option class="level-0" value="M" <?php echo (strtoupper($profile->sexo) == 'M' ? 'selected=selected' : ''); ?>>Masculino</option>
            <option class="level-0" value="F" <?php echo (strtoupper($profile->sexo) == 'F' ? 'selected=selected' : ''); ?>>Feminino</option>
        </select>
      </div>

      <div class="input text alignleft">
        <label for="">Status</label>
        <select name="status" required>
            <option value="">Todos</option>
            <option class="level-0" value="1" <?php echo (strtoupper($profile->status) == '1' ? 'selected=selected' : ''); ?>>Aguardando Abono</option>
            <option class="level-0" value="2" <?php echo (strtoupper($profile->status) == '2' ? 'selected=selected' : ''); ?>>Aguardando Impugnação</option>
            <option class="level-0" value="3" <?php echo (strtoupper($profile->status) == '3' ? 'selected=selected' : ''); ?>>Filiado</option>
            <option class="level-0" value="4" <?php echo (strtoupper($profile->status) == '4' ? 'selected=selected' : ''); ?>>Não abonado</option>
            <option class="level-0" value="5" <?php echo (strtoupper($profile->status) == '5' ? 'selected=selected' : ''); ?>>Em Impugnação</option>
            <option class="level-0" value="6" <?php echo (strtoupper($profile->status) == '6' ? 'selected=selected' : ''); ?>>Impugnado</option>
            <option class="level-0" value="7" <?php echo (strtoupper($profile->status) == '7' ? 'selected=selected' : ''); ?>>Desfiliado</option>
        </select>
      </div>

      <div class="input text alignleft">
        <label for="">Telefone Residencial</label>
        <input type="text" name="telefone_residencial" required value="<?php echo $profile->telefone_residencial; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Telefone Celular</label>
        <input type="text" name="telefone_celular" value="<?php echo $profile->telefone_celular; ?>">
      </div>
    </fieldset>

    <fieldset>
      <legend>Documentos</legend>

      <div class="input text alignleft">
        <label for="">CPF</label>
        <input type="text" name="cpf" required value="<?php echo $profile->cpf; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Título Eleitoral</label>
        <input type="text" name="titulo_eleitoral" required value="<?php echo $profile->titulo_eleitoral; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Zona Eleitoral</label>
        <input type="text" name="zona_eleitoral" required value="<?php echo $profile->zona_eleitoral; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Seção Eleitoral</label>
        <input type="text" name="secao_eleitoral" required value="<?php echo $profile->secao_eleitoral; ?>">
      </div>
    </fieldset>

    <fieldset>
      <legend>Localização</legend>

      <div class="input text alignleft">
        <label for="">CEP (99999-999)</label>
        <input type="text" name="cep" required value="<?php echo $profile->cep; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">UF</label>
        <select name="uf" required>
            <option value="">Todos</option>
            <option class="level-0" value="AC" <?php echo (strtoupper($profile->uf) == 'AC' ? 'selected=selected' : ''); ?>>Acre</option>
            <option class="level-0" value="AL" <?php echo (strtoupper($profile->uf) == 'AL' ? 'selected=selected' : ''); ?>>Alagoas</option>
            <option class="level-0" value="AP" <?php echo (strtoupper($profile->uf) == 'AP' ? 'selected=selected' : ''); ?>>Amapá</option>
            <option class="level-0" value="AM" <?php echo (strtoupper($profile->uf) == 'AM' ? 'selected=selected' : ''); ?>>Amazonas</option>
            <option class="level-0" value="BA" <?php echo (strtoupper($profile->uf) == 'BA' ? 'selected=selected' : ''); ?>>Bahia</option>
            <option class="level-0" value="CE" <?php echo (strtoupper($profile->uf) == 'CE' ? 'selected=selected' : ''); ?>>Ceará</option>
            <option class="level-0" value="DF" <?php echo (strtoupper($profile->uf) == 'DF' ? 'selected=selected' : ''); ?>>Distrito Federal</option>
            <option class="level-0" value="ES" <?php echo (strtoupper($profile->uf) == 'ES' ? 'selected=selected' : ''); ?>>Espírito Santo</option>
            <option class="level-0" value="GO" <?php echo (strtoupper($profile->uf) == 'GO' ? 'selected=selected' : ''); ?>>Goiás</option>
            <option class="level-0" value="MA" <?php echo (strtoupper($profile->uf) == 'MA' ? 'selected=selected' : ''); ?>>Maranhão</option>
            <option class="level-0" value="MT" <?php echo (strtoupper($profile->uf) == 'MT' ? 'selected=selected' : ''); ?>>Mato Grosso</option>
            <option class="level-0" value="MS" <?php echo (strtoupper($profile->uf) == 'MS' ? 'selected=selected' : ''); ?>>Mato Grosso do Sul</option>
            <option class="level-0" value="MG" <?php echo (strtoupper($profile->uf) == 'MG' ? 'selected=selected' : ''); ?>>Minas Gerais</option>
            <option class="level-0" value="PA" <?php echo (strtoupper($profile->uf) == 'PA' ? 'selected=selected' : ''); ?>>Pará</option>
            <option class="level-0" value="PB" <?php echo (strtoupper($profile->uf) == 'PB' ? 'selected=selected' : ''); ?>>Paraíba</option>
            <option class="level-0" value="PR" <?php echo (strtoupper($profile->uf) == 'PR' ? 'selected=selected' : ''); ?>>Paraná</option>
            <option class="level-0" value="PE" <?php echo (strtoupper($profile->uf) == 'PE' ? 'selected=selected' : ''); ?>>Pernambuco</option>
            <option class="level-0" value="PI" <?php echo (strtoupper($profile->uf) == 'PI' ? 'selected=selected' : ''); ?>>Piauí</option>
            <option class="level-0" value="RJ" <?php echo (strtoupper($profile->uf) == 'RJ' ? 'selected=selected' : ''); ?>>Rio de Janeiro</option>
            <option class="level-0" value="RN" <?php echo (strtoupper($profile->uf) == 'RN' ? 'selected=selected' : ''); ?>>Rio Grande do Norte</option>
            <option class="level-0" value="RS" <?php echo (strtoupper($profile->uf) == 'RS' ? 'selected=selected' : ''); ?>>Rio Grande do Sul</option>
            <option class="level-0" value="RO" <?php echo (strtoupper($profile->uf) == 'RO' ? 'selected=selected' : ''); ?>>Rondônia</option>
            <option class="level-0" value="RR" <?php echo (strtoupper($profile->uf) == 'RR' ? 'selected=selected' : ''); ?>>Roraima</option>
            <option class="level-0" value="SC" <?php echo (strtoupper($profile->uf) == 'SC' ? 'selected=selected' : ''); ?>>Santa Catarina</option>
            <option class="level-0" value="SP" <?php echo (strtoupper($profile->uf) == 'SP' ? 'selected=selected' : ''); ?>>São Paulo</option>
            <option class="level-0" value="SE" <?php echo (strtoupper($profile->uf) == 'SE' ? 'selected=selected' : ''); ?>>Sergipe</option>
            <option class="level-0" value="TO" <?php echo (strtoupper($profile->uf) == 'TO' ? 'selected=selected' : ''); ?>>Tocantins</option>
          </select>
      </div>

      <div class="input text alignleft">
        <label for="">Cidade</label>
        <input type="text" required name="cidade" value="<?php echo $profile->cidade; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Bairro</label>
        <input type="text" required name="bairro" value="<?php echo $profile->bairro; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Endereço</label>
        <textarea name="endereco" required><?php echo $profile->endereco; ?></textarea>
      </div>

      <div class="input text alignleft">
        <label for="">Número</label>
        <textarea name="numero" required><?php echo $profile->numero; ?></textarea>
      </div>

      <div class="input text alignleft">
        <label for="">Complemento</label>
        <textarea name="complemento"><?php echo $profile->complemento; ?></textarea>
      </div>
    </fieldset>

    <fieldset>
      <legend>Contribuição</legend>
      <div class="pure-u-1-2">
        <label class="inner-label" for="forma_pagamento_tipo_CC">
            <input type="radio" name="tipo" id="forma_pagamento_tipo_CC" value="cartao-credito" <?php if (!empty($profile->dados_contribuicao) && $profile->dados_contribuicao->tipo == 'cartao-credito') echo 'checked="checked"'; ?> onclick="jQuery('#tipo-cartao-credito').show();jQuery('#tipo-debito-conta').hide();" />
            Cartão de crédito
        </label>
        <label class="inner-label" for="forma_pagamento_tipo_BOLETO">
            <input type="radio" name="tipo" id="forma_pagamento_tipo_BOLETO" value="boleto" <?php if (!empty($profile->dados_contribuicao) && $profile->dados_contribuicao->tipo == 'boleto') echo 'checked="checked"'; ?> onclick="jQuery('#tipo-cartao-credito').hide();" />
            Boleto
        </label>
      </div>
      <div class="pure-u-1-2">
          <label for="contribuicao">Valor (R$) - use "," para separação</label>
          <input id="contribuicao" required name="contribuicao" type="text" class="pure-input-1-2" value="<?php echo number_format($profile->contribuicao, 2, ',', ''); ?>">
      </div>

      <div id="tipo-cartao-credito" <?php if (empty($profile->dados_contribuicao) || $profile->dados_contribuicao->tipo != 'cartao-credito') echo 'style="display:none;"'; ?>>
        <div class="pure-u-1">
          <label for="forma_pagamento_bandeira">Bandeira</label>
        </div>
        <div class="pure-u-1-4">
          <label class="inner-label" for="forma_pagamento_bandeira_mastercard">
            <input type="radio" name="bandeira" id="forma_pagamento_bandeira_mastercard" value="mastercard" style="vertical-align:middle;" <?php if (!empty($profile->dados_contribuicao) && $profile->dados_contribuicao->bandeira == 'mastercard') echo 'checked="checked"'; ?> />
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/mastercard.png" style="vertical-align:middle;" />
          </label>
        </div>
        <div class="pure-u-3-4">
          <label class="inner-label" for="forma_pagamento_bandeira_visa">
              <input type="radio" name="bandeira" id="forma_pagamento_bandeira_visa" value="visa" style="vertical-align:middle;" <?php if (!empty($profile->dados_contribuicao) && $profile->dados_contribuicao->bandeira == 'visa') echo 'checked="checked"'; ?> />
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/visa.png" style="vertical-align:middle;" />
          </label>
        </div>
        <div class="pure-u-1">
          <label for="cartao_nome">Nome no cartão</label>
          <input id="cartao_nome" name="cartao_nome" type="text" class="pure-input-1" value="<?php if (!empty($profile->dados_contribuicao)) echo $profile->dados_contribuicao->cartao_nome; ?>">
        </div>
        <div class="pure-u-2-5">
          <label for="cartao_numero">Número do cartão</label>
          <input id="cartao_numero" name="cartao_numero" type="text" class="pure-input-1" value="<?php if (!empty($profile->dados_contribuicao)) echo $profile->dados_contribuicao->cartao_numero; ?>">
        </div>
        <div class="pure-u-3-5">
          <label for="cartao_codigo_verificacao">Código de verificação</label>
          <input id="cartao_codigo_verificacao" name="cartao_codigo_verificacao" type="text" class="pure-input-1-4" value="<?php if (!empty($profile->dados_contribuicao)) echo $profile->dados_contribuicao->cartao_codigo_verificacao; ?>">
        </div>
        <div class="pure-u-1-5">
          <label for="cartao_validade_mes">Validade</label>
          <select id="cartao_validade_mes" name="cartao_validade_mes" class="pure-input-1">
              <option value="**">Mês</option>
              <?php // Preenche com 12 meses do ano
              for ($x=1; $x<=12; $x++ ){
                  $selected = $x == $profile->dados_contribuicao->cartao_validade_mes ? 'selected="selected"' : '';
                  printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
              }
              ?>
          </select>
        </div>
        <div class="pure-u-3-5">
          <label for="cartao_validade_ano">&nbsp;</label>
          <select id="cartao_validade_ano" name="cartao_validade_ano" class="pure-input-1-3">
              <option value="****">Ano</option>
              <?php
              $ano_atual = date("Y");
              for ($x=$ano_atual; $x<=$ano_atual+10; $x++ ){
                  $selected = $x == $profile->dados_contribuicao->cartao_validade_ano ? 'selected="selected"' : '';
                  printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
              }
              ?>
          </select>
        </div>
      </div>
    </fieldset>

    <input id="limpar" class="button alignright" value="Limpar" type="button">
    <input name="filtrar" class="button alignright" value="Salvar" type="submit">
  </form>
</div>
