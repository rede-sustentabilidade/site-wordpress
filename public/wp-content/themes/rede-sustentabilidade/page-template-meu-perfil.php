<?php
/*
Template Name: Formulário do Perfil
*/
$filiado = is_filiado();

if (!$filiado) {
    require_once('page-template-acesso-negado.php');
    exit;
}

function doUserUpdate()
{
	global $usuario;
    $apiErrors = null;
	$profile = ApiRede::getInstance()->getProfile($usuario->id);
    error_log(print_r($profile,true));
	if ($profile->user_id == $usuario->id) {
        $profile = (array) $profile;
        unset($profile['dados_contribuicao']);
        $profile['fullname'] = $_POST['display_name'];

        foreach ($_POST as $k => $v) {
            if (preg_match('/^\*+$/', $v)) {
                continue;
            }
            if ($k == 'user_id') { // Preventing an injection here.
                continue;
            }
            if ($k == 'contribuicao') {
                $v = str_replace(',', '.', preg_replace('/[^0-9,]+/', '', $v));
            }
            $profile[$k] = $v;
        }
        if ($_POST['contribupdate'] == 1) {
            if ($profile['tipo'] == 'boleto') {
                unset($profile['bandeira']);
                unset($profile['cartao_nome']);
                unset($profile['cartao_numero']);
                unset($profile['cartao_codigo_verificacao']);
                unset($profile['cartao_validade_mes']);
                unset($profile['cartao_validade_ano']);
            }
        }
		$response = ApiRede::getInstance()->updateProfile($profile);
        error_log(print_r($response,true));
        if (!empty($response->errors)) {
            $apiErrors = 'Os seguintes campos contém dados inválidos ou estão vazios: ' . implode(', ', array_keys((array) $response->errors));
        } else if ((is_array($response)) && (!empty($response['httpCode']))) {
            $apiErrors = 'Os dados não foram salvos. Por favor, verifique os dados informados e tente novamente.';
        }
    }
    if (null !== $apiErrors) {
        return $apiErrors;
    }
    return 'Perfil atualizado com sucesso';
}

$message = null;
if ((isset($_COOKIE['usuario'])) && !empty($_POST)) {
    $message = doUserUpdate();
}

get_header();

?>
  <div class="container-meu-perfil">
    <h2>Meu Perfil</h2>
    <form action="<?php echo get_permalink(); ?>" method="post" class="pure-form pure-form-stacked form-2" name="form_2">
    	<?php if (!empty($message)) : ?>
    	<p><?php echo $message; ?></p>
    	<?php endif; ?>

      <fieldset>
        <div class="pure-g">
          <div class="pure-u-1">
            <p>Para alterar sua senha, <a href="<?php echo WP_PASSPORT_PATH . '/change_password' ?>">clique aqui</a>.</p>
          </div>
          <div class="pure-u-1">
              <label for="display_name">Nome Completo</label>
              <input id="display_name" name="display_name" type="text" class="pure-input-1" value="<?php echo $filiado->fullname; ?>">
          </div>
          <div class="pure-u-1">
              <label for="user_email">Meu e-mail</label>
              <input id="user_email" readonly name="user_email" required  type="text" class="pure-input-1" value="<?php echo $filiado->email; ?>">
              <span>Não é possível alterar email</span>
          </div>

          <div style="width:100%;height:1px;margin:20px 0;background:#ccc;"></div>

          <h3 style="width:100%;letter-spacing:0;clear:both;">Dados de contato</h3>

          <div class="pure-u-1-3">
              <label for="telefone_residencial">Telefone residencial</label>
              <input id="telefone_residencial" name="telefone_residencial" type="text" class="pure-input-1" value="<?php echo $filiado->telefone_residencial; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="telefone_celular">Telefone celular</label>
              <input id="telefone_celular" name="telefone_celular" type="text" class="pure-input-1" value="<?php echo $filiado->telefone_celular; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="telefone_comercial">Telefone comercial</label>
              <input id="telefone_comercial" name="telefone_comercial" type="text" class="pure-input-1" value="<?php echo $filiado->telefone_comercial; ?>">
          </div>
          <div class="pure-u-1">
              <label for="cep">CEP</label>
              <input id="cep" name="cep" type="text" class="pure-input-1-3" ui-mask="99999-999" value="<?php echo $filiado->cep; ?>">
          </div>
          <div class="pure-u-1">
              <label for="endereco">Endereço</label>
              <input id="endereco" name="endereco" type="text" class="pure-input-1" value="<?php echo $filiado->endereco; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="numero">Número</label>
              <input id="numero" name="numero" type="text" class="pure-input-1" value="<?php echo $filiado->numero; ?>">
          </div>
          <div class="pure-u-2-3">
              <label for="complemento">Complemento</label>
              <input id="complemento" name="complemento" type="text" class="pure-input-1-3" value="<?php echo $filiado->complemento; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="bairro">Bairro</label>
              <input id="bairro" name="bairro" type="text" class="pure-input-1" value="<?php echo $filiado->bairro; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="cidade">Cidade</label>
              <input id="cidade" name="cidade" type="text" class="pure-input-1" value="<?php echo $filiado->cidade; ?>">
          </div>
          <div class="pure-u-1-3">
              <label for="uf">UF</label>
              <select name="uf" id="uf" class="pure-select">
                  <option value=""></option>
                  <option value="AC" <?php if ($filiado->uf == 'AC') echo 'selected="selected"'; ?>>Acre</option>
                  <option value="AL" <?php if ($filiado->uf == 'AL') echo 'selected="selected"'; ?>>Alagoas</option>
                  <option value="AM" <?php if ($filiado->uf == 'AM') echo 'selected="selected"'; ?>>Amazonas</option>
                  <option value="AP" <?php if ($filiado->uf == 'AP') echo 'selected="selected"'; ?>>Amapá</option>
                  <option value="BA" <?php if ($filiado->uf == 'BA') echo 'selected="selected"'; ?>>Bahia</option>
                  <option value="CE" <?php if ($filiado->uf == 'CE') echo 'selected="selected"'; ?>>Ceará</option>
                  <option value="DF" <?php if ($filiado->uf == 'DF') echo 'selected="selected"'; ?>>Distrito Federal</option>
                  <option value="ES" <?php if ($filiado->uf == 'ES') echo 'selected="selected"'; ?>>Espírito Santo</option>
                  <option value="GO" <?php if ($filiado->uf == 'GO') echo 'selected="selected"'; ?>>Goiás</option>
                  <option value="MA" <?php if ($filiado->uf == 'MA') echo 'selected="selected"'; ?>>Maranhão</option>
                  <option value="MG" <?php if ($filiado->uf == 'MG') echo 'selected="selected"'; ?>>Minas Gerais</option>
                  <option value="MS" <?php if ($filiado->uf == 'MS') echo 'selected="selected"'; ?>>Mato Grosso do Sul</option>
                  <option value="MT" <?php if ($filiado->uf == 'MT') echo 'selected="selected"'; ?>>Mata Grosso</option>
                  <option value="PA" <?php if ($filiado->uf == 'PA') echo 'selected="selected"'; ?>>Pará</option>
                  <option value="PB" <?php if ($filiado->uf == 'PB') echo 'selected="selected"'; ?>>Paraíba</option>
                  <option value="PE" <?php if ($filiado->uf == 'PE') echo 'selected="selected"'; ?>>Pernambuco</option>
                  <option value="PI" <?php if ($filiado->uf == 'PI') echo 'selected="selected"'; ?>>Piauí</option>
                  <option value="PR" <?php if ($filiado->uf == 'PR') echo 'selected="selected"'; ?>>Paraná</option>
                  <option value="RJ" <?php if ($filiado->uf == 'RJ') echo 'selected="selected"'; ?>>Rio de Janeiro</option>
                  <option value="RN" <?php if ($filiado->uf == 'RN') echo 'selected="selected"'; ?>>Rio Grande do Norte</option>
                  <option value="RO" <?php if ($filiado->uf == 'RO') echo 'selected="selected"'; ?>>Rondônia</option>
                  <option value="RR" <?php if ($filiado->uf == 'RR') echo 'selected="selected"'; ?>>Roraima</option>
                  <option value="RS" <?php if ($filiado->uf == 'RS') echo 'selected="selected"'; ?>>Rio Grande do Sul</option>
                  <option value="SC" <?php if ($filiado->uf == 'SC') echo 'selected="selected"'; ?>>Santa Catarina</option>
                  <option value="SE" <?php if ($filiado->uf == 'SE') echo 'selected="selected"'; ?>>Sergipe</option>
                  <option value="SP" <?php if ($filiado->uf == 'SP') echo 'selected="selected"'; ?>>São Paulo</option>
                  <option value="TO" <?php if ($filiado->uf == 'TO') echo 'selected="selected"'; ?>>Tocantins</option>
                  <option value="XX" <?php if ($filiado->uf == 'XX') echo 'selected="selected"'; ?>>Não aplicável</option>
              </select>
          </div>
        </div>
      </fieldset>

      <fieldset>
        <div class="pure-g">
            <div style="width:100%;height:1px;margin:20px 0;background:#ccc;"></div>
            <h3 style="letter-spacing:0;">Dados de contribuição</h3>

            <div class="pure-u-1">
                <label><input type="checkbox" name="contribupdate" value="1" onclick="jQuery('#contrib-data').toggle(jQuery(this).prop('checked'));"> Editar dados de contribuição</label>
            </div>
        </div>
        <div class="pure-g" id="contrib-data" style="display:none;">
            <div class="pure-u-1">
                <label class="inner-label" for="forma_pagamento_tipo_CC">
                    <input type="radio" name="tipo" id="forma_pagamento_tipo_CC" value="cartao-credito" <?php if (!empty($filiado->dados_contribuicao) && $filiado->dados_contribuicao->tipo == 'cartao-credito') echo 'checked="checked"'; ?> onclick="jQuery('#tipo-cartao-credito').show();jQuery('#tipo-debito-conta').hide();" />
                    Cartão de crédito
                </label>
                <label class="inner-label" for="forma_pagamento_tipo_BOLETO">
                    <input type="radio" name="tipo" id="forma_pagamento_tipo_BOLETO" value="boleto" <?php if (!empty($filiado->dados_contribuicao) && $filiado->dados_contribuicao->tipo == 'boleto') echo 'checked="checked"'; ?> onclick="jQuery('#tipo-cartao-credito').hide();" />
                    Boleto
                </label>
            </div>
            <div class="pure-u-1">
                <label for="contribuicao">Valor (R$)</label>
                <input id="contribuicao" name="contribuicao" type="text" class="pure-input-1-2" value="<?php echo number_format($filiado->contribuicao, 2, ',', ''); ?>">
            </div>
            <div class="pure-u-1">
                <label for="cpf">CPF</label>
                <input id="cpf" name="cpf" type="text" class="pure-input-1-2" value="<?php echo $filiado->cpf; ?>">
            </div>

            <div id="tipo-cartao-credito" <?php if (empty($filiado->dados_contribuicao) || $filiado->dados_contribuicao->tipo != 'cartao-credito') echo 'style="display:none;"'; ?>>
                <div class="pure-u-1">
                    <label for="forma_pagamento_bandeira">Bandeira</label>
                </div>
                <div class="pure-u-1-4">
                    <label class="inner-label" for="forma_pagamento_bandeira_mastercard">
                        <input type="radio" name="bandeira" id="forma_pagamento_bandeira_mastercard" value="mastercard" style="vertical-align:middle;" <?php if (!empty($filiado->dados_contribuicao) && $filiado->dados_contribuicao->bandeira == 'mastercard') echo 'checked="checked"'; ?> />
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/mastercard.png" style="vertical-align:middle;" />
                    </label>
                </div>
                <div class="pure-u-3-4">
                    <label class="inner-label" for="forma_pagamento_bandeira_visa">
                        <input type="radio" name="bandeira" id="forma_pagamento_bandeira_visa" value="visa" style="vertical-align:middle;" <?php if (!empty($filiado->dados_contribuicao) && $filiado->dados_contribuicao->bandeira == 'visa') echo 'checked="checked"'; ?> />
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/visa.png" style="vertical-align:middle;" />
                    </label>
                </div>
                <div class="pure-u-1">
                    <label for="cartao_nome">Nome no cartão</label>
                    <input id="cartao_nome" name="cartao_nome" type="text" class="pure-input-1" value="<?php if (!empty($filiado->dados_contribuicao)) echo str_repeat('*', strlen($filiado->dados_contribuicao->cartao_nome)); ?>">
                </div>
                <div class="pure-u-2-5">
                    <label for="cartao_numero">Número do cartão</label>
                    <input id="cartao_numero" name="cartao_numero" type="text" class="pure-input-1" value="<?php if (!empty($filiado->dados_contribuicao)) echo str_repeat('*', strlen($filiado->dados_contribuicao->cartao_numero)); ?>">
                </div>
                <div class="pure-u-3-5">
                    <label for="cartao_codigo_verificacao">Código de verificação</label>
                    <input id="cartao_codigo_verificacao" name="cartao_codigo_verificacao" type="text" class="pure-input-1-4" value="<?php if (!empty($filiado->dados_contribuicao)) echo str_repeat('*', strlen($filiado->dados_contribuicao->cartao_codigo_verificacao)); ?>">
                </div>
                <div class="pure-u-1-5">
                    <label for="cartao_validade_mes">Validade</label>
                    <select id="cartao_validade_mes" name="cartao_validade_mes" class="pure-input-1">
                        <option value="">Mês</option>
                        <?php // Preenche com 12 meses do ano
                        for ($x=1; $x<=12; $x++ ){
                            $selected = /*$x == $filiado->dados_contribuicao->cartao_validade_mes ? 'selected="selected"' :*/ '';
                            printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
                        }
                        ?>
                    </select>
                </div>
                <div class="pure-u-3-5">
                    <label for="cartao_validade_ano">&nbsp;</label>
                    <select id="cartao_validade_ano" name="cartao_validade_ano" class="pure-input-1-3">
                        <option value="">Ano</option>
                        <?php
                        $ano_atual = date("Y");
                        for ($x=$ano_atual; $x<=$ano_atual+10; $x++ ){
                            $selected = /*$x == $filiado->dados_contribuicao->cartao_validade_ano ? 'selected="selected"' :*/ '';
                            printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
                        }
                        ?>
                    </select>
                </div>
            </div>
          </fieldset>
      <button type="submit">Salvar <i class="icon-seta-em-frente"></i></button>
  	</form>
  </div>
<?php get_footer(); ?>
