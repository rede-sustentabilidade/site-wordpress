<script  src="https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js"></script>
<script  src="https://rawgit.com/digitalBush/jquery.maskedinput/master/dist/jquery.maskedinput.min.js"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>


<div class="wrap">
  <h2>Novo Filiado</h2>
  <p>Ao registrar, será enviada uma mensagem para o e-mail inserido, contendo uma senha de acesso.</p>
  <p>Insira o e-mail do novo filiado:</p>

<?php if ( (isset($aviso)) && (!empty($aviso))) { 
  $aviso_type = "updated";
  if($error == true) $aviso_type = "error";
?>
  
  <div class="<?php echo $aviso_type ?>">
        <p><?php _e( $aviso, 'my-text-domain' ); ?></p>
  </div>
<?php } ?>

<?php 
  if ( ($isPassaporte && !$isAfiliado) || ( !empty($aviso) && !$isPassaporte && !$isAfiliado) ) { 
    $display_filiado_form = 'block';
    $display_passaporte_button = 'none';
    $readonly_email_field = 'readonly';
  } else {
    $display_filiado_form = 'none';
    $display_passaporte_button = 'block';
    $readonly_email_field = '';
  }
?>
  <form method="POST" id="newPassaporte" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input type="hidden" value="createRegistration" name="action">
    
    <fieldset>
      <legend>Dados de Acesso</legend>

      <div class="input text alignleft">
        <label for="">E-mail</label>
        <input type="email" name="email" value="<?php echo $_POST['email'] ?>" <?php echo $readonly_email_field; ?> required> 
      </div>
    </fieldset>
    <input name="registrar" style="display:<?php echo $display_passaporte_button; ?>;" class="button alignright" value="Registrar" type="submit">
  </form>

  <form method="POST" id="newFiliado" style="display:<?php echo $display_filiado_form; ?>;" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <input type="hidden" name="action" value="createFiliacao" >
    <input type="hidden" name="isPassaporte" value="<?php echo $isPassaporte ?>">
    <input type="hidden" name="isAfiliado" value="<?php echo $isAfiliado ?>">
    <input type="hidden" name="email" value="<?php echo $_POST['email'] ?>"> 
    <input type="hidden" name="user_id" value="<?php echo $idUser ?>"> 
    
    <fieldset>
      <legend>Dados básicos</legend>

      <div class="input text alignleft">
        <label for="">Nome</label>
        <input type="text" name="fullname" required value="<?php echo $_POST['fullname'] ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
        <label for="">Nome da mãe</label>
        <input type="text" name="nome_mae" value="<?php echo $_POST['nome_mae'] ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
        <label for="birthday">Data de nascimento (DD/MM/AAAA)</label>
        <input type="date" name="birthday-formatted" required value="<?php echo $_POST['birthday'] ?>">
        <input type="hidden" name="birthday" required value="<?php echo $_POST['birthday'] ?>">
      </div>

      <div class="input text alignleft">
        <label for="">Sexo</label>
        <select name="sexo" required>
            <option value="">Todos</option>
            <option class="level-0" value="M" <?php echo (strtoupper($_POST['sexo']) == 'M' ? 'selected=selected' : ''); ?>>Masculino</option>
            <option class="level-0" value="F" <?php echo (strtoupper($_POST['sexo']) == 'F' ? 'selected=selected' : ''); ?>>Feminino</option>
        </select>
      </div>

      <div class="input text alignleft">
        <label for="">Status</label>
        <select name="status" required>
            <option value="">Selecione</option>
            <option class="level-0" value="3" <?php echo  ($_POST['status'] == '3' ? 'selected=selected' : ''); ?>>Filiado</option>
            <option class="level-0" value="7" <?php echo  ($_POST['status'] == '7' ? 'selected=selected' : ''); ?>>Desfiliado</option>
            <option class="level-0" value="8" <?php echo  ($_POST['status'] == '8' ? 'selected=selected' : ''); ?>>Aguardando Confirmação</option>
        </select>
      </div>

      <div class="input text alignleft">
        <label for="">Telefone Residencial</label>
        <input type="tel" name="telefone_residencial" required value="<?php echo $_POST['telefone_residencial'] ?>" maxlength="15">
      </div>

      <div class="input text alignleft">
        <label for="">Telefone Celular</label>
        <input type="tel" name="telefone_celular" value="<?php echo $_POST['telefone_celular'] ?>" maxlength="15">
      </div>

      <div class="input text alignleft">
        <label for="">Telefone Comercial</label>
        <input type="tel" name="telefone_comercial" value="<?php echo $_POST['telefone_comercial'] ?>" maxlength="15">
      </div>

      <div class="input text alignleft">
        <label for="">Nacionalidade</label>
        <select name="nacionalidade" required>
            <option value=""></option>
            <option class="level-0" value="Brasil - Brasileiro" <?php echo ($_POST['nacionalidade'] == 'Brasil - Brasileiro' ? 'selected=selected' : ''); ?>>Brasil - Brasileiro</option>
            <option class="level-0" value="Antígua e Barbuda - Antiguano" <?php echo ($_POST['nacionalidade'] == 'Antígua e Barbuda - Antiguano' ? 'selected=selected' : ''); ?>>Antígua e Barbuda - Antiguano</option>
            <option class="level-0" value="Argentina - Argentino" <?php echo ($_POST['nacionalidade'] == 'Argentina - Argentino' ? 'selected=selected' : ''); ?>>Argentina - Argentino</option>
            <option class="level-0" value="Bahamas - Bahamense" <?php echo ($_POST['nacionalidade'] == 'Bahamas - Bahamense' ? 'selected=selected' : ''); ?>>Bahamas - Bahamense</option>
            <option class="level-0" value="Barbados - Barbadiano, barbadense" <?php echo ($_POST['nacionalidade'] == 'Barbados - Barbadiano, barbadense' ? 'selected=selected' : ''); ?>>Barbados - Barbadiano, barbadense</option>
            <option class="level-0" value="Belize - Belizenho" <?php echo ($_POST['nacionalidade'] == 'Belize - Belizenho' ? 'selected=selected' : ''); ?>>Belize - Belizenho</option>
            <option class="level-0" value="Bolívia - Boliviano" <?php echo ($_POST['nacionalidade'] == 'Bolívia - Boliviano' ? 'selected=selected' : ''); ?>>Bolívia - Boliviano</option>
            <option class="level-0" value="Chile - Chileno" <?php echo ($_POST['nacionalidade'] == 'Chile - Chileno' ? 'selected=selected' : ''); ?>>Chile - Chileno</option>
            <option class="level-0" value="Colômbia - Colombiano" <?php echo ($_POST['nacionalidade'] == 'Colômbia - Colombiano' ? 'selected=selected' : ''); ?>>Colômbia - Colombiano</option>
            <option class="level-0" value="Costa Rica - Costarriquenho" <?php echo ($_POST['nacionalidade'] == 'Costa Rica - Costarriquenho' ? 'selected=selected' : ''); ?>>Costa Rica - Costarriquenho</option>
            <option class="level-0" value="Cuba - Cubano" <?php echo ($_POST['nacionalidade'] == 'Cuba - Cubano' ? 'selected=selected' : ''); ?>>Cuba - Cubano</option>
            <option class="level-0" value="Dominica - Dominicano" <?php echo ($_POST['nacionalidade'] == 'Dominica - Dominicano' ? 'selected=selected' : ''); ?>>Dominica - Dominicano</option>
            <option class="level-0" value="Equador - Equatoriano" <?php echo ($_POST['nacionalidade'] == 'Equador - Equatoriano' ? 'selected=selected' : ''); ?>>Equador - Equatoriano</option>
            <option class="level-0" value="El Salvador - Salvadorenho" <?php echo ($_POST['nacionalidade'] == 'El Salvador - Salvadorenho' ? 'selected=selected' : ''); ?>>El Salvador - Salvadorenho</option>
            <option class="level-0" value="Granada - Granadino" <?php echo ($_POST['nacionalidade'] == 'Granada - Granadino' ? 'selected=selected' : ''); ?>>Granada - Granadino</option>
            <option class="level-0" value="Guatemala - Guatemalteco" <?php echo ($_POST['nacionalidade'] == 'Guatemala - Guatemalteco' ? 'selected=selected' : ''); ?>>Guatemala - Guatemalteco</option>
            <option class="level-0" value="Guiana - Guianês" <?php echo ($_POST['nacionalidade'] == 'Guiana - Guianês' ? 'selected=selected' : ''); ?>>Guiana - Guianês</option>
            <option class="level-0" value="Guiana Francesa - Guianense" <?php echo ($_POST['nacionalidade'] == 'Guiana Francesa - Guianense' ? 'selected=selected' : ''); ?>>Guiana Francesa - Guianense</option>
            <option class="level-0" value="Haiti - Haitiano" <?php echo ($_POST['nacionalidade'] == 'Haiti - Haitiano' ? 'selected=selected' : ''); ?>>Haiti - Haitiano</option>
            <option class="level-0" value="Honduras - Hondurenho" <?php echo ($_POST['nacionalidade'] == 'Honduras - Hondurenho' ? 'selected=selected' : ''); ?>>Honduras - Hondurenho</option>
            <option class="level-0" value="Jamaica - Jamaicano" <?php echo ($_POST['nacionalidade'] == 'Jamaica - Jamaicano' ? 'selected=selected' : ''); ?>>Jamaica - Jamaicano</option>
            <option class="level-0" value="México - Mexicano" <?php echo ($_POST['nacionalidade'] == 'México - Mexicano' ? 'selected=selected' : ''); ?>>México - Mexicano</option>
            <option class="level-0" value="Nicarágua - Nicaraguense" <?php echo ($_POST['nacionalidade'] == 'Nicarágua - Nicaraguense' ? 'selected=selected' : ''); ?>>Nicarágua - Nicaraguense</option>
            <option class="level-0" value="Panamá - Panamenho" <?php echo ($_POST['nacionalidade'] == 'Panamá - Panamenho' ? 'selected=selected' : ''); ?>>Panamá - Panamenho</option>
            <option class="level-0" value="Paraguai - Paraguaio" <?php echo ($_POST['nacionalidade'] == 'Paraguai - Paraguaio' ? 'selected=selected' : ''); ?>>Paraguai - Paraguaio</option>
            <option class="level-0" value="Peru - Peruano" <?php echo ($_POST['nacionalidade'] == 'Peru - Peruano' ? 'selected=selected' : ''); ?>>Peru - Peruano</option>
            <option class="level-0" value="Porto Rico - Portorriquenho" <?php echo ($_POST['nacionalidade'] == 'Porto Rico - Portorriquenho' ? 'selected=selected' : ''); ?>>Porto Rico - Portorriquenho</option>
            <option class="level-0" value="República Dominicana - Dominicana" <?php echo ($_POST['nacionalidade'] == 'República Dominicana - Dominicana' ? 'selected=selected' : ''); ?>>República Dominicana - Dominicana</option>
            <option class="level-0" value="São Cristóvão e Nevis - São-cristovense" <?php echo ($_POST['nacionalidade'] == 'São Cristóvão e Nevis - São-cristovense' ? 'selected=selected' : ''); ?>>São Cristóvão e Nevis - São-cristovense</option>
            <option class="level-0" value="São Vicente e Granadinas - São-vicentino" <?php echo ($_POST['nacionalidade'] == 'São Vicente e Granadinas - São-vicentino' ? 'selected=selected' : ''); ?>>São Vicente e Granadinas - São-vicentino</option>
            <option class="level-0" value="Santa Lúcia - Santa-lucense" <?php echo ($_POST['nacionalidade'] == 'Santa Lúcia - Santa-lucense' ? 'selected=selected' : ''); ?>>Santa Lúcia - Santa-lucense</option>
            <option class="level-0" value="Suriname - Surinamês" <?php echo ($_POST['nacionalidade'] == 'Suriname - Surinamês' ? 'selected=selected' : ''); ?>>Suriname - Surinamês</option>
            <option class="level-0" value="Trinidad e Tobago - Trindadense" <?php echo ($_POST['nacionalidade'] == 'Trinidad e Tobago - Trindadense' ? 'selected=selected' : ''); ?>>Trinidad e Tobago - Trindadense</option>
            <option class="level-0" value="Uruguai - Uruguaio" <?php echo ($_POST['nacionalidade'] == 'Uruguai - Uruguaio' ? 'selected=selected' : ''); ?>>Uruguai - Uruguaio</option>
            <option class="level-0" value="Venezuela - Venezuelano" <?php echo ($_POST['nacionalidade'] == 'Venezuela - Venezuelano' ? 'selected=selected' : ''); ?>>Venezuela - Venezuelano</option>
            <option class="level-0" value="Alemanha - Alemão" <?php echo ($_POST['nacionalidade'] == 'Alemanha - Alemão' ? 'selected=selected' : ''); ?>>Alemanha - Alemão</option>
            <option class="level-0" value="Áustria - Austríaco" <?php echo ($_POST['nacionalidade'] == 'Áustria - Austríaco' ? 'selected=selected' : ''); ?>>Áustria - Austríaco</option>
            <option class="level-0" value="Bélgica - Belga" <?php echo ($_POST['nacionalidade'] == 'Bélgica - Belga' ? 'selected=selected' : ''); ?>>Bélgica - Belga</option>
            <option class="level-0" value="Croácia - Croata" <?php echo ($_POST['nacionalidade'] == 'Croácia - Croata' ? 'selected=selected' : ''); ?>>Croácia - Croata</option>
            <option class="level-0" value="Dinamarca - Dinamarquês" <?php echo ($_POST['nacionalidade'] == 'Dinamarca - Dinamarquês' ? 'selected=selected' : ''); ?>>Dinamarca - Dinamarquês</option>
            <option class="level-0" value="Eslováquia - Eslovaco" <?php echo ($_POST['nacionalidade'] == 'Eslováquia - Eslovaco' ? 'selected=selected' : ''); ?>>Eslováquia - Eslovaco</option>
            <option class="level-0" value="Eslovênia - Esloveno" <?php echo ($_POST['nacionalidade'] == 'Eslovênia - Esloveno' ? 'selected=selected' : ''); ?>>Eslovênia - Esloveno</option>
            <option class="level-0" value="Espanha - Espanhol" <?php echo ($_POST['nacionalidade'] == 'Espanha - Espanhol' ? 'selected=selected' : ''); ?>>Espanha - Espanhol</option>
            <option class="level-0" value="França - Francês" <?php echo ($_POST['nacionalidade'] == 'França - Francês' ? 'selected=selected' : ''); ?>>França - Francês</option>
            <option class="level-0" value="Grécia - Grego" <?php echo ($_POST['nacionalidade'] == 'Grécia - Grego' ? 'selected=selected' : ''); ?>>Grécia - Grego</option>
            <option class="level-0" value="Hungria - Húngaro" <?php echo ($_POST['nacionalidade'] == 'Hungria - Húngaro' ? 'selected=selected' : ''); ?>>Hungria - Húngaro</option>
            <option class="level-0" value="Irlanda - Irlandês" <?php echo ($_POST['nacionalidade'] == 'Irlanda - Irlandês' ? 'selected=selected' : ''); ?>>Irlanda - Irlandês</option>
            <option class="level-0" value="Itália - Italiano" <?php echo ($_POST['nacionalidade'] == 'Itália - Italiano' ? 'selected=selected' : ''); ?>>Itália - Italiano</option>
            <option class="level-0" value="Noruega - Noruego" <?php echo ($_POST['nacionalidade'] == 'Noruega - Noruego' ? 'selected=selected' : ''); ?>>Noruega - Noruego</option>
            <option class="level-0" value="Países Baixos - Holandês" <?php echo ($_POST['nacionalidade'] == 'Países Baixos - Holandês' ? 'selected=selected' : ''); ?>>Países Baixos - Holandês</option>
            <option class="level-0" value="Polônia - Polonês" <?php echo ($_POST['nacionalidade'] == 'Polônia - Polonês' ? 'selected=selected' : ''); ?>>Polônia - Polonês</option>
            <option class="level-0" value="Portugal - Português" <?php echo ($_POST['nacionalidade'] == 'Portugal - Português' ? 'selected=selected' : ''); ?>>Portugal - Português</option>
            <option class="level-0" value="Reino Unido - Britânico" <?php echo ($_POST['nacionalidade'] == 'Reino Unido - Britânico' ? 'selected=selected' : ''); ?>>Reino Unido - Britânico</option>
            <option class="level-0" value="Inglaterra - Inglês" <?php echo ($_POST['nacionalidade'] == 'Inglaterra - Inglês' ? 'selected=selected' : ''); ?>>Inglaterra - Inglês</option>
            <option class="level-0" value="País de Gales - Galês" <?php echo ($_POST['nacionalidade'] == 'País de Gales - Galês' ? 'selected=selected' : ''); ?>>País de Gales - Galês</option>
            <option class="level-0" value="Escócia - Escocês" <?php echo ($_POST['nacionalidade'] == 'Escócia - Escocês' ? 'selected=selected' : ''); ?>>Escócia - Escocês</option>
            <option class="level-0" value="Romênia - Romeno" <?php echo ($_POST['nacionalidade'] == 'Romênia - Romeno' ? 'selected=selected' : ''); ?>>Romênia - Romeno</option>
            <option class="level-0" value="Rússia - Russo" <?php echo ($_POST['nacionalidade'] == 'Rússia - Russo' ? 'selected=selected' : ''); ?>>Rússia - Russo</option>
            <option class="level-0" value="Sérvio - Sérvio" <?php echo ($_POST['nacionalidade'] == 'Sérvio - Sérvio' ? 'selected=selected' : ''); ?>>Sérvio - Sérvio</option>
            <option class="level-0" value="Suécia - Sueco" <?php echo ($_POST['nacionalidade'] == 'Suécia - Sueco' ? 'selected=selected' : ''); ?>>Suécia - Sueco</option>
            <option class="level-0" value="Suíça - Suíço" <?php echo ($_POST['nacionalidade'] == 'Suíça - Suíço' ? 'selected=selected' : ''); ?>>Suíça - Suíço</option>
            <option class="level-0" value="Turquia - Turco" <?php echo ($_POST['nacionalidade'] == 'Turquia - Turco' ? 'selected=selected' : ''); ?>>Turquia - Turco</option>
            <option class="level-0" value="Ucrânia - Ucraniano" <?php echo ($_POST['nacionalidade'] == 'Ucrânia - Ucraniano' ? 'selected=selected' : ''); ?>>Ucrânia - Ucraniano</option>
            <option class="level-0" value="Estados Unidos - Americano" <?php echo ($_POST['nacionalidade'] == 'Estados Unidos - Americano' ? 'selected=selected' : ''); ?>>Estados Unidos - Americano</option>
            <option class="level-0" value="Canadá - Canadense" <?php echo ($_POST['nacionalidade'] == 'Canadá - Canadense' ? 'selected=selected' : ''); ?>>Canadá - Canadense</option>
            <option class="level-0" value="Angola - Angolano" <?php echo ($_POST['nacionalidade'] == 'Angola - Angolano' ? 'selected=selected' : ''); ?>>Angola - Angolano</option>
            <option class="level-0" value="Moçambique - Moçambicano" <?php echo ($_POST['nacionalidade'] == 'Moçambique - Moçambicano' ? 'selected=selected' : ''); ?>>Moçambique - Moçambicano</option>
            <option class="level-0" value="África do Sul - Sul-africano" <?php echo ($_POST['nacionalidade'] == 'África do Sul - Sul-africano' ? 'selected=selected' : ''); ?>>África do Sul - Sul-africano</option>
            <option class="level-0" value="Zimbabue - Zimbabuense" <?php echo ($_POST['nacionalidade'] == 'Zimbabue - Zimbabuense' ? 'selected=selected' : ''); ?>>Zimbabue - Zimbabuense</option>
            <option class="level-0" value="Argélia - Argélia" <?php echo ($_POST['nacionalidade'] == 'Argélia - Argélia' ? 'selected=selected' : ''); ?>>Argélia - Argélia</option>
            <option class="level-0" value="Comores - Comorense" <?php echo ($_POST['nacionalidade'] == 'Comores - Comorense' ? 'selected=selected' : ''); ?>>Comores - Comorense</option>
            <option class="level-0" value="Egito - Egípcio" <?php echo ($_POST['nacionalidade'] == 'Egito - Egípcio' ? 'selected=selected' : ''); ?>>Egito - Egípcio</option>
            <option class="level-0" value="Líbia - Líbio" <?php echo ($_POST['nacionalidade'] == 'Líbia - Líbio' ? 'selected=selected' : ''); ?>>Líbia - Líbio</option>
            <option class="level-0" value="Marrocos - Marroquino" <?php echo ($_POST['nacionalidade'] == 'Marrocos - Marroquino' ? 'selected=selected' : ''); ?>>Marrocos - Marroquino</option>
            <option class="level-0" value="Gana - Ganés" <?php echo ($_POST['nacionalidade'] == 'Gana - Ganés' ? 'selected=selected' : ''); ?>>Gana - Ganés</option>
            <option class="level-0" value="Quênia - Queniano" <?php echo ($_POST['nacionalidade'] == 'Quênia - Queniano' ? 'selected=selected' : ''); ?>>Quênia - Queniano</option>
            <option class="level-0" value="Ruanda - Ruandês" <?php echo ($_POST['nacionalidade'] == 'Ruanda - Ruandês' ? 'selected=selected' : ''); ?>>Ruanda - Ruandês</option>
            <option class="level-0" value="Uganda - Ugandense" <?php echo ($_POST['nacionalidade'] == 'Uganda - Ugandense' ? 'selected=selected' : ''); ?>>Uganda - Ugandense</option>
            <option class="level-0" value="Botsuana - Bechuano" <?php echo ($_POST['nacionalidade'] == 'Botsuana - Bechuano' ? 'selected=selected' : ''); ?>>Botsuana - Bechuano</option>
            <option class="level-0" value="Costa do Marfim - Marfinense" <?php echo ($_POST['nacionalidade'] == 'Costa do Marfim - Marfinense' ? 'selected=selected' : ''); ?>>Costa do Marfim - Marfinense</option>
            <option class="level-0" value="Camarões - Camaronense" <?php echo ($_POST['nacionalidade'] == 'Camarões - Camaronense' ? 'selected=selected' : ''); ?>>Camarões - Camaronense</option>
            <option class="level-0" value="Nigéria - Nigeriano" <?php echo ($_POST['nacionalidade'] == 'Nigéria - Nigeriano' ? 'selected=selected' : ''); ?>>Nigéria - Nigeriano</option>
            <option class="level-0" value="Somália - Somali" <?php echo ($_POST['nacionalidade'] == 'Somália - Somali' ? 'selected=selected' : ''); ?>>Somália - Somali</option>
            <option class="level-0" value="Austrália - Australiano" <?php echo ($_POST['nacionalidade'] == 'Austrália - Australiano' ? 'selected=selected' : ''); ?>>Austrália - Australiano</option>
            <option class="level-0" value="Nova Zelândia - Neozelandês" <?php echo ($_POST['nacionalidade'] == 'Nova Zelândia - Neozelandês' ? 'selected=selected' : ''); ?>>Nova Zelândia - Neozelandês</option>
            <option class="level-0" value="Afeganistão - Afegão" <?php echo ($_POST['nacionalidade'] == 'Afeganistão - Afegão' ? 'selected=selected' : ''); ?>>Afeganistão - Afegão</option>
            <option class="level-0" value="Arábia Saudita - Saudita" <?php echo ($_POST['nacionalidade'] == 'Arábia Saudita - Saudita' ? 'selected=selected' : ''); ?>>Arábia Saudita - Saudita</option>
            <option class="level-0" value="Armênia - Armeno" <?php echo ($_POST['nacionalidade'] == 'Armênia - Armeno' ? 'selected=selected' : ''); ?>>Armênia - Armeno</option>
            <option class="level-0" value="Armeno - Bangladesh" <?php echo ($_POST['nacionalidade'] == 'Armeno - Bangladesh' ? 'selected=selected' : ''); ?>>Armeno - Bangladesh</option>
            <option class="level-0" value="China - Chinês" <?php echo ($_POST['nacionalidade'] == 'China - Chinês' ? 'selected=selected' : ''); ?>>China - Chinês</option>
            <option class="level-0" value="Coréia do Norte - Norte-coreano, coreano" <?php echo ($_POST['nacionalidade'] == 'Coréia do Norte - Norte-coreano, coreano' ? 'selected=selected' : ''); ?>>Coréia do Norte - Norte-coreano, coreano</option>
            <option class="level-0" value="Coréia do Sul - Sul-coreano, coreano" <?php echo ($_POST['nacionalidade'] == 'Coréia do Sul - Sul-coreano, coreano' ? 'selected=selected' : ''); ?>>Coréia do Sul - Sul-coreano, coreano</option>
            <option class="level-0" value="Índia - Indiano" <?php echo ($_POST['nacionalidade'] == 'Índia - Indiano' ? 'selected=selected' : ''); ?>>Índia - Indiano</option>
            <option class="level-0" value="Indonésia - Indonésio" <?php echo ($_POST['nacionalidade'] == 'Indonésia - Indonésio' ? 'selected=selected' : ''); ?>>Indonésia - Indonésio</option>
            <option class="level-0" value="Iraque - Iraquiano" <?php echo ($_POST['nacionalidade'] == 'Iraque - Iraquiano' ? 'selected=selected' : ''); ?>>Iraque - Iraquiano</option>
            <option class="level-0" value="Irã - Iraniano" <?php echo ($_POST['nacionalidade'] == 'Irã - Iraniano' ? 'selected=selected' : ''); ?>>Irã - Iraniano</option>
            <option class="level-0" value="Israel - Israelita" <?php echo ($_POST['nacionalidade'] == 'Israel - Israelita' ? 'selected=selected' : ''); ?>>Israel - Israelita</option>
            <option class="level-0" value="Japão - Japonês" <?php echo ($_POST['nacionalidade'] == 'Japão - Japonês' ? 'selected=selected' : ''); ?>>Japão - Japonês</option>
            <option class="level-0" value="Malásia - Malaio" <?php echo ($_POST['nacionalidade'] == 'Malásia - Malaio' ? 'selected=selected' : ''); ?>>Malásia - Malaio</option>
            <option class="level-0" value="Nepal - Nepalês" <?php echo ($_POST['nacionalidade'] == 'Nepal - Nepalês' ? 'selected=selected' : ''); ?>>Nepal - Nepalês</option>
            <option class="level-0" value="Omã - Omanense" <?php echo ($_POST['nacionalidade'] == 'Omã - Omanense' ? 'selected=selected' : ''); ?>>Omã - Omanense</option>
            <option class="level-0" value="Paquistão - Paquistanês" <?php echo ($_POST['nacionalidade'] == 'Paquistão - Paquistanês' ? 'selected=selected' : ''); ?>>Paquistão - Paquistanês</option>
            <option class="level-0" value="Palestina - Palestino" <?php echo ($_POST['nacionalidade'] == 'Palestina - Palestino' ? 'selected=selected' : ''); ?>>Palestina - Palestino</option>
            <option class="level-0" value="Qatar - Qatarense" <?php echo ($_POST['nacionalidade'] == 'Qatar - Qatarense' ? 'selected=selected' : ''); ?>>Qatar - Qatarense</option>
            <option class="level-0" value="Síria - Sírio" <?php echo ($_POST['nacionalidade'] == 'Síria - Sírio' ? 'selected=selected' : ''); ?>>Síria - Sírio</option>
            <option class="level-0" value="Sri Lanka - Cingalês" <?php echo ($_POST['nacionalidade'] == 'Sri Lanka - Cingalês' ? 'selected=selected' : ''); ?>>Sri Lanka - Cingalês</option>
            <option class="level-0" value="Tailândia - Tailandês" <?php echo ($_POST['nacionalidade'] == 'Tailândia - Tailandês' ? 'selected=selected' : ''); ?>>Tailândia - Tailandês</option>
            <option class="level-0" value="Timor-Leste - Timorense, maubere" <?php echo ($_POST['nacionalidade'] == 'Timor-Leste - Timorense, maubere' ? 'selected=selected' : ''); ?>>Timor-Leste - Timorense, maubere</option>
            <option class="level-0" value="Emirados Árabes Unidos - Árabe, emiratense" <?php echo ($_POST['nacionalidade'] == 'Emirados Árabes Unidos - Árabe, emiratense' ? 'selected=selected' : ''); ?>>Emirados Árabes Unidos - Árabe, emiratense</option>
            <option class="level-0" value="Vietnã - Vietnamita" <?php echo ($_POST['nacionalidade'] == 'Vietnã - Vietnamita' ? 'selected=selected' : ''); ?>>Vietnã - Vietnamita</option>
            <option class="level-0" value="Iêmen - Iemenit" <?php echo ($_POST['nacionalidade'] == 'Iêmen - Iemenit' ? 'selected=selected' : ''); ?>>Iêmen - Iemenit</option>
        </select>
      </div>
    </fieldset>

    <fieldset>
      <legend>Dados Eleitorais</legend>

      <div class="input text alignleft">
        <label for="">CPF</label>
        <input type="text" name="cpf" required value="<?php echo $_POST['cpf'] ?>"  maxlength="14">
      </div>

      <div class="input text alignleft">
        <label for="">Título Eleitoral</label>
        <input type="text" name="titulo_eleitoral" required value="<?php echo $_POST['titulo_eleitoral'] ?>"  maxlength="12">
      </div>

      <div class="input text alignleft">
        <label for="">Zona Eleitoral</label>
        <input type="text" name="zona_eleitoral" required value="<?php echo $_POST['zona_eleitoral'] ?>" maxlength="3">
      </div>

      <div class="input text alignleft">
        <label for="">Seção Eleitoral</label>
        <input type="text" name="secao_eleitoral" required value="<?php echo $_POST['secao_eleitoral'] ?>" maxlength="4">
      </div>

      <div class="input text alignleft">
        <label for="tipo_Filiacao">Informe que tipo de filiação pretende estabelecer com a #Rede</label>
        <select id="tipo_Filiacao" name="tipo_Filiacao" required type="text" data-placeholder="Tipo de filiação">
            <option value=""></option>
            <option value="C" <?php echo (strtoupper($_POST['tipo_Filiacao']) == 'C' ? 'selected=selected' : ''); ?>>Cívica Independente (Responde à Carta Compromisso)</option>
            <option value="P" <?php echo (strtoupper($_POST['tipo_Filiacao']) == 'P' ? 'selected=selected' : ''); ?>>Plena</option>
        </select>
        <p class="mensagem ajuda">
            O filiado "pleno" goza de todos os Direitos e Deveres presentes no Estatuto da #Rede. O filiado "cívico independente", indicado por um movimento ou coletivo autônomo à #Rede, responderá, de forma complementar, aos termos estabelecidos em uma Carta Compromisso.
        </p>
      </div>

      <div class="questionario text alignleft">
          <label class="break" for="quer_ser_candidato_N">Você pretende candidatar-se pela Rede Sustentabilidade?</label>
          <label class="inner-label" for="quer_ser_candidato_N">
              <input type="radio" required name="quer_ser_candidato" id="quer_ser_candidato_N" value="N" <?php echo ($_POST['quer_ser_candidato'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="quer_ser_candidato_S">
              <input type="radio" required name="quer_ser_candidato" id="quer_ser_candidato_S" value="S" <?php echo ($_POST['quer_ser_candidato'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>

      <div class="questionario quer_ser_candidato_child text alignleft" style="display: none">
          <p class="mensagem ajuda">A omissão de qualquer informação solicitada neste cadastro pode resultar em rejeição e anulação da filiação.</p>
          <label for="candidato_cargo">A que cargo pretende candidatar-se pela #Rede?</label>
          <input ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_cargo" placeholder="Coloque o nome do cargo" id="candidato_cargo" type="text" class="pure-input-1" value="<?php echo $_POST['candidato_cargo'] ?>" maxlength="255">
      </div>
      <div class="questionario quer_ser_candidato_child text alignleft" style="display: none">
          <label for="candidato_motivo">Em poucas palavras, diga por que você quer ser candidato? Qual é a sua motivação pela vida política?</label>
          <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_motivo" id="candidato_motivo" rows="3" class="pure-input-1"><?php echo $_POST['candidato_motivo']; ?></textarea>
      </div>
      <div class="questionario quer_ser_candidato_child text alignleft" style="display: none">
          <label for="candidato_base">Qual é sua base eleitoral?</label>
          <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" placeholder="região, segmento populacional, área de atuação, serviços prestados" name="candidato_base" id="candidato_base" rows="3" class="pure-input-1"><?php echo $_POST['candidato_base']; ?></textarea>
      </div>
      <div class="questionario quer_ser_candidato_child text alignleft" style="display: none">
          <label for="candidato_estatuto">Você leu, detalhadamente, o Estatuto e o Manifesto da #Rede? Você concorda com seus termos? Caso discorde de algum ponto especifico, indique(-os) e justifique(-os).</label>
          <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_estatuto" id="candidato_estatuto" rows="3" class="pure-input-1"><?php echo $_POST['candidato_estatuto']; ?></textarea>
      </div>
      <div class="questionario quer_ser_candidato_child text alignleft" style="display: none">
          <label for="candidato_antecedentes">Você tem antecedentes criminais, é ou já foi réu em ação criminal, é ou já foi investigado em inquérito policial? Em caso positivo indique o número do processo e a instância judicial (cartório, cidade, tribunal) em curso ou da decisão judicial respectiva (com ou sem trânsito em julgado).</label>
          <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_antecedentes" id="candidato_antecedentes" rows="3" class="pure-input-1"><?php echo $_POST['candidato_antecedentes']; ?></textarea>
      </div>
      <div class="questionario text alignleft">
          <label for="filiado_partido">É ou já foi filiado a partido político??</label>
          <label class="inner-label" for="filiado_partido_N">
              <input type="radio" required name="filiado_partido" id="filiado_partido_N" value="N" <?php echo ($_POST['filiado_partido'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="filiado_partido_S">
              <input type="radio" required name="filiado_partido" id="filiado_partido_S" value="S" <?php echo ($_POST['filiado_partido'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>
      <div class="questionario text alignleft filiado_partido_quais" style="display: none" >
          <label for="filiado_partido_quais">Quais Partidos?</label>
          <input ng-required="$parent.filiado.filiado_partido=='S'" name="filiado_partido_quais" placeholder="Ex. Fui filiado durante X anos no partido XX." id="filiado_partido_quais" type="text" class="pure-input-1" value="<?php echo $_POST['filiado_partido_quais'] ?>" maxlength="255">
      </div>

      <div class="questionario text alignleft">
          <label for="foi_candidato">Já candidatou-se a cargo eletivo no Executivo ou Legislativo Federal, Estadual ou Municipal?</label>
          <label class="inner-label" for="foi_candidato_N">
              <input type="radio" required name="foi_candidato" id="foi_candidato_N" value="N" <?php echo ($_POST['foi_candidato'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="foi_candidato_S">
              <input type="radio" required name="foi_candidato" id="foi_candidato_S" value="S" <?php echo ($_POST['foi_candidato'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>
      <div class="questionario text alignleft foi_candidato_quais" style="display: none">
          <label for="foi_candidato_quais">Quais você tentou?</label>
          <input ng-required="$parent.filiado.foi_candidato=='S'" name="foi_candidato_quais" placeholder="Ex. Fui candidato a Deputado Estadual no estado XX nas eleições de XXXX." id="foi_candidato_quais" type="text" class="pure-input-1" value="<?php echo $_POST['foi_candidato_quais'] ?>"  maxlength="255">
      </div>

      <div class="questionario text alignleft">
          <label for="atual_anterior_eleito">Exerce ou exerceu cargo eletivo no Executivo ou Legislativo Federal, Estadual ou Municipal ?</label>
          <label class="inner-label" for="atual_anterior_eleito_N">
              <input type="radio" required name="atual_anterior_eleito" id="atual_anterior_eleito_N" value="N" <?php echo ($_POST['atual_anterior_eleito'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="atual_anterior_eleito_S">
              <input type="radio" required name="atual_anterior_eleito" id="atual_anterior_eleito_S" value="S" <?php echo ($_POST['atual_anterior_eleito'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>
      <div class="questionario text alignleft atual_anterior_eleito_quais" style="display: none">
          <label for="atual_anterior_eleito_quais">Quais você exerceu ou exerce?</label>
          <input ng-required="$parent.filiado.atual_anterior_eleito=='S'" name="atual_anterior_eleito_quais" placeholder="Ex. Sou vereador na cidade X e já fui vereador no ano XXXX na cidade X." id="atual_anterior_eleito_quais" type="text" class="pure-input-1" value="<?php echo $_POST['atual_anterior_eleito_quais'] ?>" maxlength="255">
      </div>

      <div class="questionario text alignleft">
          <label for="cargo_confianca">Já foi nomeado a cargo de confiança ou comissionado no Serviço Público Federal, Estadual ou Municipal?</label>
          <label class="inner-label" for="cargo_confianca_N">
              <input type="radio" required name="cargo_confianca" id="cargo_confianca_N" value="N" <?php echo ($_POST['cargo_confianca'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="cargo_confianca_S">
              <input type="radio" required name="cargo_confianca" id="cargo_confianca_S" value="S" <?php echo ($_POST['cargo_confianca'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>
      <div class="questionario text alignleft cargo_confianca_quais" style="display: none">
          <label for="cargo_confianca_quais">Quais você já foi nomeado?</label>
          <input ng-required="$parent.filiado.cargo_confianca=='S'" name="cargo_confianca_quais" placeholder="Ex. Atualmente sou prefeito do município X." id="cargo_confianca_quais" type="text" class="pure-input-1" value="<?php echo $_POST['cargo_confianca_quais'] ?>" maxlength="255">
      </div>
    </fieldset>

    <fieldset>
      <legend>Localização</legend>

      <div class="input text alignleft">
        <label for="">CEP (99999-999)</label>
        <input type="text" name="cep" required value="<?php echo $_POST['cep'] ?>"  maxlength="9">
      </div>

      <div class="input text alignleft">
        <label for="">UF</label>
        <select name="uf" required>
            <option value="">Todos</option>
            <option class="level-0" value="AC" <?php echo (strtoupper($_POST['uf']) == 'AC' ? 'selected=selected' : ''); ?>>Acre</option>
            <option class="level-0" value="AL" <?php echo (strtoupper($_POST['uf']) == 'AL' ? 'selected=selected' : ''); ?>>Alagoas</option>
            <option class="level-0" value="AP" <?php echo (strtoupper($_POST['uf']) == 'AP' ? 'selected=selected' : ''); ?>>Amapá</option>
            <option class="level-0" value="AM" <?php echo (strtoupper($_POST['uf']) == 'AM' ? 'selected=selected' : ''); ?>>Amazonas</option>
            <option class="level-0" value="BA" <?php echo (strtoupper($_POST['uf']) == 'BA' ? 'selected=selected' : ''); ?>>Bahia</option>
            <option class="level-0" value="CE" <?php echo (strtoupper($_POST['uf']) == 'CE' ? 'selected=selected' : ''); ?>>Ceará</option>
            <option class="level-0" value="DF" <?php echo (strtoupper($_POST['uf']) == 'DF' ? 'selected=selected' : ''); ?>>Distrito Federal</option>
            <option class="level-0" value="ES" <?php echo (strtoupper($_POST['uf']) == 'ES' ? 'selected=selected' : ''); ?>>Espírito Santo</option>
            <option class="level-0" value="GO" <?php echo (strtoupper($_POST['uf']) == 'GO' ? 'selected=selected' : ''); ?>>Goiás</option>
            <option class="level-0" value="MA" <?php echo (strtoupper($_POST['uf']) == 'MA' ? 'selected=selected' : ''); ?>>Maranhão</option>
            <option class="level-0" value="MT" <?php echo (strtoupper($_POST['uf']) == 'MT' ? 'selected=selected' : ''); ?>>Mato Grosso</option>
            <option class="level-0" value="MS" <?php echo (strtoupper($_POST['uf']) == 'MS' ? 'selected=selected' : ''); ?>>Mato Grosso do Sul</option>
            <option class="level-0" value="MG" <?php echo (strtoupper($_POST['uf']) == 'MG' ? 'selected=selected' : ''); ?>>Minas Gerais</option>
            <option class="level-0" value="PA" <?php echo (strtoupper($_POST['uf']) == 'PA' ? 'selected=selected' : ''); ?>>Pará</option>
            <option class="level-0" value="PB" <?php echo (strtoupper($_POST['uf']) == 'PB' ? 'selected=selected' : ''); ?>>Paraíba</option>
            <option class="level-0" value="PR" <?php echo (strtoupper($_POST['uf']) == 'PR' ? 'selected=selected' : ''); ?>>Paraná</option>
            <option class="level-0" value="PE" <?php echo (strtoupper($_POST['uf']) == 'PE' ? 'selected=selected' : ''); ?>>Pernambuco</option>
            <option class="level-0" value="PI" <?php echo (strtoupper($_POST['uf']) == 'PI' ? 'selected=selected' : ''); ?>>Piauí</option>
            <option class="level-0" value="RJ" <?php echo (strtoupper($_POST['uf']) == 'RJ' ? 'selected=selected' : ''); ?>>Rio de Janeiro</option>
            <option class="level-0" value="RN" <?php echo (strtoupper($_POST['uf']) == 'RN' ? 'selected=selected' : ''); ?>>Rio Grande do Norte</option>
            <option class="level-0" value="RS" <?php echo (strtoupper($_POST['uf']) == 'RS' ? 'selected=selected' : ''); ?>>Rio Grande do Sul</option>
            <option class="level-0" value="RO" <?php echo (strtoupper($_POST['uf']) == 'RO' ? 'selected=selected' : ''); ?>>Rondônia</option>
            <option class="level-0" value="RR" <?php echo (strtoupper($_POST['uf']) == 'RR' ? 'selected=selected' : ''); ?>>Roraima</option>
            <option class="level-0" value="SC" <?php echo (strtoupper($_POST['uf']) == 'SC' ? 'selected=selected' : ''); ?>>Santa Catarina</option>
            <option class="level-0" value="SP" <?php echo (strtoupper($_POST['uf']) == 'SP' ? 'selected=selected' : ''); ?>>São Paulo</option>
            <option class="level-0" value="SE" <?php echo (strtoupper($_POST['uf']) == 'SE' ? 'selected=selected' : ''); ?>>Sergipe</option>
            <option class="level-0" value="TO" <?php echo (strtoupper($_POST['uf']) == 'TO' ? 'selected=selected' : ''); ?>>Tocantins</option>
          </select>
      </div>

      <div class="input text alignleft">
        <label for="">Cidade</label>
        <input type="text" required name="cidade" value="<?php echo $_POST['cidade'] ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
        <label for="">Bairro</label>
        <input type="text" required name="bairro" value="<?php echo $_POST['bairro'] ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
        <label for="">Endereço</label>
        <textarea name="endereco" required maxlength="255"><?php echo $_POST['endereco']; ?></textarea>
      </div>

      <div class="input text alignleft">
        <label for="">Número</label>
        <input type="text" name="numero" required value="<?php echo $_POST['numero']; ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
        <label for="">Complemento</label>
        <textarea name="complemento" maxlength="255"><?php echo $_POST['complemento']; ?></textarea>
      </div>
    </fieldset>

    <fieldset>
      <legend>Contribuição</legend>
      <div class="input text alignleft">
        <p>Para alterar informações de contribuição é necessário escolher o tipo e preencher os dados novamente. <strong>Os dados antigos de contribuição serão substituídos</strong>.</p>
        <label class="inner-label" for="forma_pagamento_tipo_CC">
            <input type="radio" name="tipo" id="forma_pagamento_tipo_CC" value="cartao-credito" <?php if (!empty($_POST['tipo']) && $_POST['tipo'] == 'cartao-credito') echo 'checked="checked"'; ?> />
            Cartão de crédito
        </label>
        <label class="inner-label" for="forma_pagamento_tipo_BOLETO">
            <input type="radio" name="tipo" id="forma_pagamento_tipo_BOLETO" value="boleto" <?php if (!empty($_POST['tipo']) && $_POST['tipo'] == 'boleto') echo 'checked="checked"'; ?> />
            Boleto
        </label>
      </div>
      <div class="input text alignleft">
          <label for="contribuicao">Valor (R$) - use "," para separação</label>
          <input id="contribuicao" type="hidden" name="contribuicao" value="<?php echo $_POST['contribuicao'] ?>">
          <input id="contribuicao-formatted" name="contribuicao-formatted" required  type="text" class="pure-input-1-2" value="<?php echo $_POST['contribuicao'] ?>" maxlength="14">
      </div>

      <div id="tipo-cartao-credito" style="display:none;">
        <div class="input text alignleft">
          <label for="forma_pagamento_bandeira">Bandeira</label>
        </div>
        <div class="input text alignleft">
          <label class="inner-label" for="forma_pagamento_bandeira_mastercard">
            <input type="radio" name="bandeira" id="forma_pagamento_bandeira_mastercard" value="mastercard" style="vertical-align:middle;" <?php if ($_POST['bandeira'] == 'mastercard') echo 'checked="checked"'; ?> />
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/mastercard.png" style="vertical-align:middle;" />
          </label>
        </div>
        <div class="input text alignleft">
          <label class="inner-label" for="forma_pagamento_bandeira_visa">
              <input type="radio" name="bandeira" id="forma_pagamento_bandeira_visa" value="visa" style="vertical-align:middle;" <?php if ($_POST['bandeira'] == 'visa') echo 'checked="checked"'; ?> />
              <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/visa.png" style="vertical-align:middle;" />
          </label>
        </div>
        <div class="input text alignleft">
          <label for="cartao_nome">Nome no cartão</label>
          <input id="cartao_nome" name="cartao_nome" type="text" class="pure-input-1" value="<?php echo $_POST['cartao_nome']; ?>" maxlength="255">
        </div>
        <div class="input text alignleft">
          <label for="cartao_numero">Número do cartão</label>
          <input id="cartao_numero" name="cartao_numero" type="text" class="pure-input-1" value="<?php echo $_POST['cartao_numero']; ?>" maxlength="19">
        </div>
        <div class="input text alignleft">
          <label for="cartao_codigo_verificacao">Código de verificação</label>
          <input id="cartao_codigo_verificacao" name="cartao_codigo_verificacao" type="text" class="pure-input-1-4" value="<?php echo $_POST['cartao_codigo_verificacao']; ?>" maxlength="4">
        </div>
        <div class="input text alignleft">
          <label for="cartao_validade_mes">Validade</label>
          <select id="cartao_validade_mes" name="cartao_validade_mes" class="pure-input-1">
              <option value="">Mês</option>
              <?php // Preenche com 12 meses do ano
              for ($x=1; $x<=12; $x++ ){
                  $selected = $x == $_POST['cartao_validade_mes'] ? 'selected="selected"' : '';
                  printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
              }
              ?>
          </select>
        </div>
        <div class="input text alignleft">
          <label for="cartao_validade_ano">&nbsp;</label>
          <select id="cartao_validade_ano" name="cartao_validade_ano" class="pure-input-1-3">
              <option value="">Ano</option>
              <?php
              $ano_atual = date("Y");
              for ($x=$ano_atual; $x<=$ano_atual+10; $x++ ){
                  $selected = $x == $_POST['cartao_validade_ano'] ? 'selected="selected"' : '';
                  printf("<option value=\"%d\" %s>%d</option>", $x, $selected, $x);
              }
              ?>
          </select>
        </div>
      </div>
    </fieldset>



    <fieldset>
      <legend>Interesses</legend>

      <div class="questionario text alignleft">
          <label for="ativista">Você é ativista de alguma causa ou movimento social?</label>
          <label class="inner-label" for="ativista_N">
              <input type="radio" ng-model="$parent.filiado.ativista" required name="ativista" id="ativista_N" value="N" <?php echo ($_POST['ativista'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="ativista_S">
              <input type="radio" ng-model="$parent.filiado.ativista" required name="ativista" id="ativista_S" value="S" <?php echo ($_POST['ativista'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>

      <div class="input text alignleft ativista_quais" style="display:none">
          <label for="ativista_quais">Descreva como é seu ativismo e onde geralmente atua?</label>
          <input ng-model="$parent.filiado.ativista_quais" ng-required="$parent.filiado.ativista=='S'" name="ativista_quais" placeholder="Ex. Atualmente faço ativismo social." id="ativista_quais" type="text" class="pure-input-1" value="<?php echo $_POST['ativista_quais'] ?>" maxlength="255">
      </div>

      <div class="input text alignleft">
          <label for="escolaridade">Escolaridade</label>
          <select disable-search="true" chosen id="escolaridade" name="escolaridade" required ng-model="$parent.filiado.escolaridade" type="text" class="pure-input-1-3" data-placeholder="Informe teu nível de escolaridade">
            <option value=""></option>
            <option value="Não Alfabetizado" <?php echo ($_POST['escolaridade'] == 'Não Alfabetizado' ? 'selected=selected' : ''); ?>>Não Alfabetizado</option>
            <option value="Ensino Fundamental - Incompleto" <?php echo ($_POST['escolaridade'] == 'Ensino Fundamental - Incompleto' ? 'selected=selected' : ''); ?>>Ensino Fundamental - Incompleto</option>
            <option value="Ensino Fundamental - Completo" <?php echo ($_POST['escolaridade'] == 'Ensino Fundamental - Completo' ? 'selected=selected' : ''); ?>>Ensino Fundamental - Completo</option>
            <option value="Ensino Médio - Incompleto" <?php echo ($_POST['escolaridade'] == 'Ensino Médio - Incompleto' ? 'selected=selected' : ''); ?>>Ensino Médio - Incompleto</option>
            <option value="Ensino Médio - Completo" <?php echo ($_POST['escolaridade'] == 'Ensino Médio - Completo' ? 'selected=selected' : ''); ?>>Ensino Médio - Completo</option>
            <option value="Superior - Incompleto" <?php echo ($_POST['escolaridade'] == 'Superior - Incompleto' ? 'selected=selected' : ''); ?>>Superior - Incompleto</option>
            <option value="Superior - Completo" <?php echo ($_POST['escolaridade'] == 'Superior - Completo' ? 'selected=selected' : ''); ?>>Superior - Completo</option>
            <option value="Especialização - Incompleto" <?php echo ($_POST['escolaridade'] == 'Especialização - Incompleto' ? 'selected=selected' : ''); ?>>Especialização - Incompleto</option>
            <option value="Especialização - Completo" <?php echo ($_POST['escolaridade'] == 'Especialização - Completo' ? 'selected=selected' : ''); ?>>Especialização - Completo</option>
            <option value="Mestrado - Incompleto" <?php echo ($_POST['escolaridade'] == 'Mestrado - Incompleto' ? 'selected=selected' : ''); ?>>Mestrado - Incompleto</option>
            <option value="Mestrado - Completo" <?php echo ($_POST['escolaridade'] == 'Mestrado - Completo' ? 'selected=selected' : ''); ?>>Mestrado - Completo</option>
            <option value="Doutorado - Incompleto" <?php echo ($_POST['escolaridade'] == 'Doutorado - Incompleto' ? 'selected=selected' : ''); ?>>Doutorado - Incompleto</option>
            <option value="Doutorado - Completo" <?php echo ($_POST['escolaridade'] == 'Doutorado - Completo' ? 'selected=selected' : ''); ?>>Doutorado - Completo</option>
          </select>
      </div>

      <div class="input text alignleft">
          <label for="atuacoesProfissionais">Em qual área você atua?</label>
          <select multiple="multiple" id="atuacoesProfissionais" name="atuacoesProfissionais[]" required ng-model="$parent.filiado.atuacoesProfissionais" type="text" class="pure-input-1-3" data-placeholder="Diga-nos onde atua profissionalmente">
              <option value="1" <?php echo ($_POST['atuacoesProfissionais'] == '1' ? 'selected=selected' : ''); ?>>Administração e Negócios</option>
              <option value="2" <?php echo ($_POST['atuacoesProfissionais'] == '2' ? 'selected=selected' : ''); ?>>Artes e Design</option>
              <option value="3" <?php echo ($_POST['atuacoesProfissionais'] == '3' ? 'selected=selected' : ''); ?>>Campo de Públicas</option>
              <option value="4" <?php echo ($_POST['atuacoesProfissionais'] == '4' ? 'selected=selected' : ''); ?>>Ciências Agrárias</option>
              <option value="5" <?php echo ($_POST['atuacoesProfissionais'] == '5' ? 'selected=selected' : ''); ?>>Ciências Exatas e Informática</option>
              <option value="6" <?php echo ($_POST['atuacoesProfissionais'] == '6' ? 'selected=selected' : ''); ?>>Ciências Humanas e Sociais</option>
              <option value="7" <?php echo ($_POST['atuacoesProfissionais'] == '7' ? 'selected=selected' : ''); ?>>Comunicação e Informação</option>
              <option value="8" <?php echo ($_POST['atuacoesProfissionais'] == '8' ? 'selected=selected' : ''); ?>>Engenharia</option>
              <option value="9" <?php echo ($_POST['atuacoesProfissionais'] == '9' ? 'selected=selected' : ''); ?>>Meio Ambiente</option>
              <option value="10" <?php echo ($_POST['atuacoesProfissionais'] == '10' ? 'selected=selected' : ''); ?>>Saúde</option>
              <option value="11" <?php echo ($_POST['atuacoesProfissionais'] == '11' ? 'selected=selected' : ''); ?>>Outro</option>
          </select>
<br />
Pressione e segure a tecla Control no Windows, ou Command no Mac, para selecionar mais de uma opção
      </div>

      <div class="input text alignleft">
          <label for="areasInteresse">Áreas de interesse</label>
          <select multiple="multiple" id="areasInteresse" name="areasInteresse[]" required ng-model="$parent.filiado.areasInteresse" type="text" class="pure-input-1-3" data-placeholder="Diga-nos suas áreas de interesse">
                <option value="1" <?php echo ($_POST['areasInteresse'] == '1' ? 'selected=selected' : ''); ?>>Meio Ambiente</option>
                <option value="2" <?php echo ($_POST['areasInteresse'] == '2' ? 'selected=selected' : ''); ?>>Educação</option>
                <option value="3" <?php echo ($_POST['areasInteresse'] == '3' ? 'selected=selected' : ''); ?>>Saúde</option>
                <option value="4" <?php echo ($_POST['areasInteresse'] == '4' ? 'selected=selected' : ''); ?>>Moradia</option>
                <option value="5" <?php echo ($_POST['areasInteresse'] == '5' ? 'selected=selected' : ''); ?>>Tecnologia</option>
                <option value="6" <?php echo ($_POST['areasInteresse'] == '6' ? 'selected=selected' : ''); ?>>Energias Alternativas</option>
                <option value="7" <?php echo ($_POST['areasInteresse'] == '7' ? 'selected=selected' : ''); ?>>Mobilidade Urbana</option>
                <option value="8" <?php echo ($_POST['areasInteresse'] == '8' ? 'selected=selected' : ''); ?>>Economia Criativa</option>
                <option value="9" <?php echo ($_POST['areasInteresse'] == '9' ? 'selected=selected' : ''); ?>>Economia Solidária</option>
                <option value="10" <?php echo ($_POST['areasInteresse'] == '10' ? 'selected=selected' : ''); ?>>Causa Indígena</option>
                <option value="11" <?php echo ($_POST['areasInteresse'] == '11' ? 'selected=selected' : ''); ?>>Direitos Humanos</option>
                <option value="12" <?php echo ($_POST['areasInteresse'] == '12' ? 'selected=selected' : ''); ?>>Diversidade</option>
                <option value="13" <?php echo ($_POST['areasInteresse'] == '13' ? 'selected=selected' : ''); ?>>Ativismo Autoral</option>
                <option value="14" <?php echo ($_POST['areasInteresse'] == '14' ? 'selected=selected' : ''); ?>>Patrimônio Genético</option>
                <option value="15" <?php echo ($_POST['areasInteresse'] == '15' ? 'selected=selected' : ''); ?>>Arte</option>
                <option value="16" <?php echo ($_POST['areasInteresse'] == '16' ? 'selected=selected' : ''); ?>>Outros</option>
          </select>
<br />
Pressione e segure a tecla Control no Windows, ou Command no Mac, para selecionar mais de uma opção
      </div>

      <div class="input text alignleft">
          <label for="local_trabalho">Qual seu local de trabalho?</label>
          <input id="local_trabalho" required ng-model="$parent.filiado.local_trabalho" name="local_trabalho" type="text"  class="pure-input-2-3" placeholder="Nome da empresa ou organização onde trabalha." / value="<?php echo $_POST['local_trabalho'] ?>" maxlength="255">
      </div>

      <div class="questionario text alignleft">
          <label for="voluntario">Você gostaria de oferecer voluntariamente algum serviço ou habilidade profissional para a #Rede?</label>
          <label class="inner-label" for="voluntario_N">
              <input type="radio" ng-model="$parent.filiado.voluntario" required name="voluntario" id="voluntario_N" value="N" <?php echo ($_POST['voluntario'] == 'N' ? 'checked=checked' : ''); ?> />
              Não
          </label>
          <label class="inner-label" for="voluntario_S">
              <input type="radio" ng-model="$parent.filiado.voluntario" required name="voluntario" id="voluntario_S" value="S" <?php echo ($_POST['voluntario'] == 'S' ? 'checked=checked' : ''); ?> />
              Sim
          </label>
      </div>

  </fieldset>




    <input id="limpar" class="button alignright" value="Limpar" type="button">
    <input name="filtrar" class="button alignright" value="Salvar" type="submit">
  </form>
</div>
