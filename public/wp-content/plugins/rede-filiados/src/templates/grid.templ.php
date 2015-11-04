<div class="wrap">
  <h2>Filiados (<span id="total_contribuicoes">0</span>) <!-- <a href="http://rede.local/wp/wp-admin/post-new.php?post_type=page" class="add-new-h2">Adicionar Nova</a> --></h2>

  <form method="GET" id="filtrosContribuicao">
    <input type="hidden" value="rs_filiados" name="page">
    <fieldset>
      <p>Abaixo você encontra a lista de filiados cadastrados. Você poderá criar visualizações com uso dos filtros e exportar essa visão como relatório no botão "Exportar .CSV".</p>

      <div class="input text alignleft">
        <label for="">ID Usuário</label>
        <input type="text" name="afiliados.user_id" value="<?php echo $filters['afiliados.user_id']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Nome</label>
        <input type="text" name="afiliados.fullname" value="<?php echo $filters['afiliados.fullname']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">CPF</label>
        <input type="text" name="afiliados.cpf" value="<?php echo $filters['afiliados.cpf']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Título Eleitoral</label>
        <input type="text" name="afiliados.titulo_eleitoral" value="<?php echo $filters['afiliados.titulo_eleitoral']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Zona Eleitoral</label>
        <input type="text" name="afiliados.zona_eleitoral" value="<?php echo $filters['afiliados.zona_eleitoral']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Seção Eleitoral</label>
        <input type="text" name="afiliados.secao_eleitoral" value="<?php echo $filters['afiliados.secao_eleitoral']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Sexo</label>
        <select name="afiliados.sexo">
            <option value="">Todos</option>
            <option class="level-0" value="M" <?php echo (urldecode($filters['afiliados.sexo']) == 'M' ? 'selected=selected' : ''); ?>>Masculino</option>
            <option class="level-0" value="F" <?php echo (urldecode($filters['afiliados.sexo']) == 'F' ? 'selected=selected' : ''); ?>>Feminino</option>
        </select>
      </div>

      <div class="input text alignleft">
        <label for="">Status</label>
        <select name="afiliados.status">
            <option value="">Todos</option>
            <option class="level-0" value="1" <?php echo (urldecode($filters['afiliados.status']) == '1' ? 'selected=selected' : ''); ?>>Aguardando Abono</option>
            <option class="level-0" value="2" <?php echo (urldecode($filters['afiliados.status']) == '2' ? 'selected=selected' : ''); ?>>Aguardando Impugnação</option>
            <option class="level-0" value="3" <?php echo (urldecode($filters['afiliados.status']) == '3' ? 'selected=selected' : ''); ?>>Filiado</option>
            <option class="level-0" value="4" <?php echo (urldecode($filters['afiliados.status']) == '4' ? 'selected=selected' : ''); ?>>Não abonado</option>
            <option class="level-0" value="5" <?php echo (urldecode($filters['afiliados.status']) == '5' ? 'selected=selected' : ''); ?>>Em Impugnação</option>
            <option class="level-0" value="6" <?php echo (urldecode($filters['afiliados.status']) == '6' ? 'selected=selected' : ''); ?>>Impugnado</option>
            <option class="level-0" value="7" <?php echo (urldecode($filters['afiliados.status']) == '7' ? 'selected=selected' : ''); ?>>Desfiliado</option>
            <option class="level-0" value="8" <?php echo (urldecode($filters['afiliados.status']) == '8' ? 'selected=selected' : ''); ?>>À Confirmar</option>
        </select>
      </div>

      <br class="clear">

      <div class="input text alignleft">
        <label for="">UF</label>
        <select name="afiliados.uf">
            <option value="">Todos</option>
            <option class="level-0" value="AC" <?php echo (urldecode($filters['afiliados.uf']) == 'AC' ? 'selected=selected' : ''); ?>>Acre</option>
            <option class="level-0" value="AL" <?php echo (urldecode($filters['afiliados.uf']) == 'AL' ? 'selected=selected' : ''); ?>>Alagoas</option>
            <option class="level-0" value="AP" <?php echo (urldecode($filters['afiliados.uf']) == 'AP' ? 'selected=selected' : ''); ?>>Amapá</option>
            <option class="level-0" value="AM" <?php echo (urldecode($filters['afiliados.uf']) == 'AM' ? 'selected=selected' : ''); ?>>Amazonas</option>
            <option class="level-0" value="BA" <?php echo (urldecode($filters['afiliados.uf']) == 'BA' ? 'selected=selected' : ''); ?>>Bahia</option>
            <option class="level-0" value="CE" <?php echo (urldecode($filters['afiliados.uf']) == 'CE' ? 'selected=selected' : ''); ?>>Ceará</option>
            <option class="level-0" value="DF" <?php echo (urldecode($filters['afiliados.uf']) == 'DF' ? 'selected=selected' : ''); ?>>Distrito Federal</option>
            <option class="level-0" value="ES" <?php echo (urldecode($filters['afiliados.uf']) == 'ES' ? 'selected=selected' : ''); ?>>Espírito Santo</option>
            <option class="level-0" value="GO" <?php echo (urldecode($filters['afiliados.uf']) == 'GO' ? 'selected=selected' : ''); ?>>Goiás</option>
            <option class="level-0" value="MA" <?php echo (urldecode($filters['afiliados.uf']) == 'MA' ? 'selected=selected' : ''); ?>>Maranhão</option>
            <option class="level-0" value="MT" <?php echo (urldecode($filters['afiliados.uf']) == 'MT' ? 'selected=selected' : ''); ?>>Mato Grosso</option>
            <option class="level-0" value="MS" <?php echo (urldecode($filters['afiliados.uf']) == 'MS' ? 'selected=selected' : ''); ?>>Mato Grosso do Sul</option>
            <option class="level-0" value="MG" <?php echo (urldecode($filters['afiliados.uf']) == 'MG' ? 'selected=selected' : ''); ?>>Minas Gerais</option>
            <option class="level-0" value="PA" <?php echo (urldecode($filters['afiliados.uf']) == 'PA' ? 'selected=selected' : ''); ?>>Pará</option>
            <option class="level-0" value="PB" <?php echo (urldecode($filters['afiliados.uf']) == 'PB' ? 'selected=selected' : ''); ?>>Paraíba</option>
            <option class="level-0" value="PR" <?php echo (urldecode($filters['afiliados.uf']) == 'PR' ? 'selected=selected' : ''); ?>>Paraná</option>
            <option class="level-0" value="PE" <?php echo (urldecode($filters['afiliados.uf']) == 'PE' ? 'selected=selected' : ''); ?>>Pernambuco</option>
            <option class="level-0" value="PI" <?php echo (urldecode($filters['afiliados.uf']) == 'PI' ? 'selected=selected' : ''); ?>>Piauí</option>
            <option class="level-0" value="RJ" <?php echo (urldecode($filters['afiliados.uf']) == 'RJ' ? 'selected=selected' : ''); ?>>Rio de Janeiro</option>
            <option class="level-0" value="RN" <?php echo (urldecode($filters['afiliados.uf']) == 'RN' ? 'selected=selected' : ''); ?>>Rio Grande do Norte</option>
            <option class="level-0" value="RS" <?php echo (urldecode($filters['afiliados.uf']) == 'RS' ? 'selected=selected' : ''); ?>>Rio Grande do Sul</option>
            <option class="level-0" value="RO" <?php echo (urldecode($filters['afiliados.uf']) == 'RO' ? 'selected=selected' : ''); ?>>Rondônia</option>
            <option class="level-0" value="RR" <?php echo (urldecode($filters['afiliados.uf']) == 'RR' ? 'selected=selected' : ''); ?>>Roraima</option>
            <option class="level-0" value="SC" <?php echo (urldecode($filters['afiliados.uf']) == 'SC' ? 'selected=selected' : ''); ?>>Santa Catarina</option>
            <option class="level-0" value="SP" <?php echo (urldecode($filters['afiliados.uf']) == 'SP' ? 'selected=selected' : ''); ?>>São Paulo</option>
            <option class="level-0" value="SE" <?php echo (urldecode($filters['afiliados.uf']) == 'SE' ? 'selected=selected' : ''); ?>>Sergipe</option>
            <option class="level-0" value="TO" <?php echo (urldecode($filters['afiliados.uf']) == 'TO' ? 'selected=selected' : ''); ?>>Tocantins</option>
          </select>
      </div>

      <div class="input text alignleft">
        <label for="">Cidade</label>
        <input type="text" name="afiliados.cidade" value="<?php echo $filters['afiliados.cidade']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Bairro</label>
        <input type="text" name="afiliados.bairro" value="<?php echo $filters['afiliados.bairro']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Endereço</label>
        <input type="text" name="afiliados.endereco" value="<?php echo $filters['afiliados.endereco']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">CEP</label>
        <input type="text" name="afiliados.cep" value="<?php echo $filters['afiliados.cep']; ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Período</label>
        <select name="afiliados.created_at">
            <option value="">Todo</option>
            <option class="level-0" value="<?php $atual = date('Y-m-01'); echo $atual; ?>" <?php echo (urldecode($filters['afiliados.created_at']) == $atual ? 'selected=selected' : ''); ?>>Mês atual</option>
            <option class="level-0" value="<?php $anterior = date('Y-m-d', strtotime("first day of previous month")); echo $anterior; ?>" <?php echo (urldecode($filters['afiliados.created_at']) == $anterior ? 'selected=selected' : ''); ?>>Mês anterior</option>
        </select>
      </div>

      <br class="clear">

      <input id="limpar" class="button alignright" value="Limpar" type="button">
      <input name="export_filiados" class="button alignright" value="Exportar .CSV" type="submit">
      <input name="filtrar" class="button alignright" value="Filtrar" type="submit">

    </fieldset>
  </form>
  <br class="clear">
  <div id="box-contribuicoes"></div>
  <script type="text/javascript">
    var RS_API_PAYMENTS = "<?php echo $url; ?>";
  </script>
</div>
