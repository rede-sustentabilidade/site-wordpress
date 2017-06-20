<?php

namespace Rede;

require "Api.php";

class Filiados
{
    private $jsAdmin = 'js/main.js';
    private $apiPath;
    private $mainTemplate = 'templates/grid.templ.php';
    private $profileTemplate = 'templates/profile.templ.php';
    private $newFiliadoTemplate = 'templates/new-filiado.templ.php';

    public function __construct($type)
    {
      $this->apiPath = WP_API_PATH;

      if (isset($_GET['export_filiados'])) {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=export-filiados.csv");
        // Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies

        $data = $this->buildUrlFilters();

        $result = file_get_contents($data['url'].'per_page=100000000');
        $result_csv = json_decode($result, true);

        $this->outputCSV(array_merge(array(array_keys($result_csv[1][0])),$result_csv[1]));
      }

      switch ($type) {
          case 'admin':
              add_action('admin_enqueue_scripts', array($this, 'addScripts'));

              add_action('admin_menu', array($this, 'registerMenuOptions'));

              add_action( 'admin_action_rs_filiado_profile', array($this, 'rs_filiado_profile_admin_action') );

              add_action( 'load-filiados_page_rs_filiado_new', array($this, 'rs_filiado_new_passaporte') );
              
              add_action( 'admin_action_rs_filiado_new_filiado', array($this, 'rs_filiado_new_filiado_admin_action') );

              add_action( 'show_user_profile', array($this, 'rs_personal_options_custom_user_profile_fields') );
              add_action( 'edit_user_profile', array($this, 'rs_add_custom_user_profile_fields') );

              add_action( 'edit_user_profile_update', array($this, 'rs_save_custom_user_profile_fields')  );

              // Register the Post Type
              // $this->registerPostType(
              //     $this->postTypeNameSingle,
              //     $this->postTypeNamePlural
              // );

              // Add the Meta Box
              // add_action('add_meta_boxes', array($this, 'addMetaBox'));

              // Accept an Ajax Request
              // add_action('wp_ajax_save_answer', array($this, 'saveAnswers'));

              // Watch for Post being saved
              // add_action('save_post', array($this, 'savePost'));
          case 'admin_profile':

      }
    }

    public function outputCSV($data) {
      $output = fopen("php://output", "w");
      foreach ($data as $row) {
          fputcsv($output, $row); // here you can change delimiter/enclosure
      }
      fclose($output);
      exit;
    }

    public function registerMenuOptions()
    {
        add_menu_page('Filiados', 'Filiados', 'manage_filiados', 'rs_filiados', array($this, 'getFiliados'), 'dashicons-businessman');
        add_submenu_page( 'rs_filiados', 'Adicionar novo', 'Adicionar novo', 'manage_filiados', 'rs_filiado_new', array($this, 'newFiliado'));
        add_submenu_page( 'rs_filiados', 'Detalhes do filiado', 'Detalhes do filiado', 'manage_filiados', 'rs_filiado_profile', array($this, 'getProfile'));
    }



    function rs_add_custom_user_profile_fields( $user ) {
    ?>
      <h3><?php _e('Organizador Estadual', 'your_textdomain'); ?></h3>
      <span class="description">Se este usuário for um Organizador Estadual, selecione uma UF.</span>
      
      <table class="form-table">
        <tr>
          <th>
            <label for="address">UF</label></th>
          <td>
            <select name="uf" id="uf">
              <option value="">Selecione</option>
              <option value="AC" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "AC" ? print "selected=selected" : ""); ?>>AC</option>
              <option value="AL" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "AL" ? print "selected=selected" : ""); ?>>AL</option>
              <option value="AM" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "AM" ? print "selected=selected" : ""); ?>>AM</option>
              <option value="AP" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "AP" ? print "selected=selected" : ""); ?>>AP</option>
              <option value="BA" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "BA" ? print "selected=selected" : ""); ?>>BA</option>
              <option value="CE" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "CE" ? print "selected=selected" : ""); ?>>CE</option>
              <option value="DF" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "DF" ? print "selected=selected" : ""); ?>>DF</option>
              <option value="ES" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "ES" ? print "selected=selected" : ""); ?>>ES</option>
              <option value="GO" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "GO" ? print "selected=selected" : ""); ?>>GO</option>
              <option value="MA" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "MA" ? print "selected=selected" : ""); ?>>MA</option>
              <option value="MG" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "MG" ? print "selected=selected" : ""); ?>>MG</option>
              <option value="MS" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "MS" ? print "selected=selected" : ""); ?>>MS</option>
              <option value="MT" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "MT" ? print "selected=selected" : ""); ?>>MT</option>
              <option value="PA" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "PA" ? print "selected=selected" : ""); ?>>PA</option>
              <option value="PB" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "PB" ? print "selected=selected" : ""); ?>>PB</option>
              <option value="PE" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "PE" ? print "selected=selected" : ""); ?>>PE</option>
              <option value="PI" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "PI" ? print "selected=selected" : ""); ?>>PI</option>
              <option value="PR" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "PR" ? print "selected=selected" : ""); ?>>PR</option>
              <option value="RJ" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "RJ" ? print "selected=selected" : ""); ?>>RJ</option>
              <option value="RN" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "RN" ? print "selected=selected" : ""); ?>>RN</option>
              <option value="RS" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "RS" ? print "selected=selected" : ""); ?>>RS</option>
              <option value="RO" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "RO" ? print "selected=selected" : ""); ?>>RO</option>
              <option value="RR" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "RR" ? print "selected=selected" : ""); ?>>RR</option>
              <option value="SC" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "SC" ? print "selected=selected" : ""); ?>>SC</option>
              <option value="SE" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "SE" ? print "selected=selected" : ""); ?>>SE</option>
              <option value="SP" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "SP" ? print "selected=selected" : ""); ?>>SP</option>
              <option value="TO" <?php (esc_attr( get_the_author_meta( 'uf', $user->ID ) ) == "TO" ? print "selected=selected" : ""); ?>>TO</option>
            </select>
          </td>
        </tr>
      </table>
    <?php }

    function rs_personal_options_custom_user_profile_fields( $user ) {
    ?>
      <h3><?php _e('Organizador Estadual', 'your_textdomain'); ?></h3>
      <span class="description">Se este usuário for um Organizador Estadual, consulte abaixo seu estado. Lembre-se, somente o Administrador Geral poderá alterar a uf do organizador.</span>
      
      <table class="form-table">
        <tr>
          <th>
            <label for="address">UF</label></th>
          <td>
            <?php print esc_attr( get_the_author_meta( 'uf', $user->ID ) ); ?>
          </td>
        </tr>
      </table>
    <?php }

    function rs_save_custom_user_profile_fields( $user_id ) {
      if ( !current_user_can( 'edit_user', $user_id ) )
        return FALSE;

      update_usermeta( $user_id, 'uf', $_POST['uf'] );
    }

    










    public function buildUrlFilters() {
      $filters = array(
        'afiliados.user_id'=>'',
        'afiliados.fullname'=>'',
        'afiliados.cpf'=>'',
        'afiliados.titulo_eleitoral'=>'',
        'afiliados.zona_eleitoral'=>'',
        'afiliados.secao_eleitoral'=>'',
        'afiliados.sexo'=>'',
        'afiliados.status'=>'',
        'afiliados.uf'=>'',
        'afiliados.cidade'=>'',
        'afiliados.bairro'=>'',
        'afiliados.endereco'=>'',
        'afiliados.cep'=>'',
        'afiliados.created_at'=>''
      );

      $url_params = '';
      $params = explode('&',$_SERVER['QUERY_STRING']);

      $current_user = wp_get_current_user();
      
      foreach ($params as $query) {
        $filter_field = substr($query, 0,strpos($query, '='));

        if (strpos($query, '=') < (strlen($query) - 1)) {
          $filter_value = substr($query, strpos($query, '=')+1);
          if($filter_field == 'afiliados.uf' && $current_user->get('uf')) {
              $filter_value = $current_user->get('uf');
          }
          $filters[$filter_field] = $filter_value;
          if ( ($filter_value !== '') && ($filter_field !== 'page') ) {
            $url_params .= $filter_field.'='.$filter_value.'&';
          }
        }
      }

      if($current_user->get('uf') && $filters['afiliados.uf'] == '') {
        $filters['afiliados.uf'] = $current_user->get('uf');
        $url_params .= 'afiliados.uf='.$current_user->get('uf').'&';
      }

      // $url_filters = str_replace('page=rs_contribuicoes&', '', $_SERVER['QUERY_STRING']);
      return array('filters'=>$filters,'url'=>$this->apiPath . '/admin_filiados?' . $url_params);
    }

    public function getFiliados()
    {

        // Get the current values for the questions
        // $json = array();
        // foreach ($this->answerIds as $id) {
        //     $json[] = $this->getOneAnswer($post->ID, $id);
        // }

        $data = $this->buildUrlFilters();

        // Set data needed in the template
        $viewData = array(
            'url' => $data['url'],
            'filters' => $data['filters'],
            'aviso' => $_GET['aviso'],
            // 'answers' => json_encode($json),
            // 'correct' => json_encode(get_post_meta($post->ID, 'correct_answer'))
        );

        echo $this->getTemplatePart($this->mainTemplate, $viewData);

    }

    public function getProfile() {

      $api = Api::getInstance();
      $aviso = '';
      $data = null;

      if ( (isset($_SESSION)) && (!empty($_SESSION['aviso'])) ) {
        $aviso = $_SESSION['aviso'];
        $_SESSION['aviso'] = '';
      }

      if(isset($_SESSION) && (!empty($_SESSION['updatedProfile']))) {
        $data = $_SESSION['updatedProfile'];
        $_SESSION['updatedProfile'] = null;
      } else {
        $data = $api->getProfile($_GET['user_id']);
        
        //deixa plana a lista de areas de interesse
        $areasInteresse = array();
        foreach ($data->areas_interesse as $key => $value) {
            array_push($areasInteresse, $value->id);
        }
        $data->areasInteresse = $areasInteresse;
        unset($data->areas_interesse);

        //deixa plana a lista atuacoes profissionais
        $atuacoes_profissionais = array();
        foreach ($data->atuacoes_profissionais as $key => $value) {
            array_push($atuacoes_profissionais, $value->id);
        }
        $data->atuacoesProfissionais = $atuacoes_profissionais;
        unset($data->atuacoes_profissionais);

      }

      

      
      $viewData = array('profile'=>$data, 'aviso'=>$aviso);
      echo $this->getTemplatePart($this->profileTemplate, $viewData);
    }

    public function newFiliado() {

      $api = Api::getInstance();
      $aviso = '';


      if ( (isset($_SESSION)) && (!empty($_SESSION['aviso'])) ) {
        $aviso = $_SESSION['aviso'];
        $_SESSION['aviso'] = '';

        $error = $_SESSION['error'];
        $_SESSION['error'] = '';
      }

      if ( (isset($_SESSION)) && (!empty($_SESSION['isPassaporte'])) ) {
        $isPassaporte = $_SESSION['isPassaporte'];
        $_SESSION['isPassaporte'] = '';
      }

      if ( (isset($_SESSION)) && (!empty($_SESSION['isAfiliado'])) ) {
        $isAfiliado = $_SESSION['isAfiliado'];
        $_SESSION['isAfiliado'] = '';
      }

      if ( (isset($_POST)) && (!empty($_POST['isPassaporte'])) ) {
        $isPassaporte = $_POST['isPassaporte'];
      }

      if ( (isset($_POST)) && (!empty($_POST['isAfiliado'])) ) {
        $isAfiliado = $_POST['isAfiliado'];
      }

      if ( (isset($_SESSION)) && (!empty($_SESSION['idUser'])) ) {
        $idUser = $_SESSION['idUser'];
        $_SESSION['idUser'] = '';
      }

      if ( (isset($_POST)) && (!empty($_POST['user_id'])) ) {
        $idUser = $_POST['user_id'];
      }

      $viewData = array('aviso'=>$aviso, 'isPassaporte'=>$isPassaporte, 'isAfiliado' => $isAfiliado, 'idUser' => $idUser, 'error' => $error);
      echo $this->getTemplatePart($this->newFiliadoTemplate, $viewData);
    }

    public function rs_filiado_profile_admin_action()
    {
      $api = Api::getInstance();
      $data = "";
      if ( (isset($_POST)) && (count($_POST)>0) ) {
        $updatedProfile = array(
            //Dados de Acesso
            'user_id'                       => $_POST['user_id'],
            'email'                         => $_POST['email'],

            //Dados básicos
            'fullname'                      => $_POST['fullname'],
            'nome_mae'                      => $_POST['nome_mae'],
            'birthday'                      => $_POST['birthday'],
            'sexo'                          => $_POST['sexo'],
            'status'                        => $_POST['status'],
            'telefone_residencial'          => $_POST['telefone_residencial'],
            'telefone_celular'              => $_POST['telefone_celular'],
            'telefone_comercial'            => $_POST['telefone_comercial'],
            'nacionalidade'                 => $_POST['nacionalidade'],

            //Dados eleitorais
            'cpf'                           => preg_replace('/\D/', '', $_POST['cpf']),
            'titulo_eleitoral'              => $_POST['titulo_eleitoral'],
            'zona_eleitoral'                => $_POST['zona_eleitoral'],
            'secao_eleitoral'               => $_POST['secao_eleitoral'],
            'tipo_Filiacao'                 => $_POST['tipo_Filiacao'],
            'quer_ser_candidato'            => $_POST['quer_ser_candidato'],
            'candidato_cargo'               => $_POST['candidato_cargo'],
            'candidato_base'               => $_POST['candidato_base'],
            'candidato_motivo'              => $_POST['candidato_motivo'],
            'candidato_estatuto'            => $_POST['candidato_estatuto'],
            'candidato_antecedentes'        => $_POST['candidato_antecedentes'],
            'filiado_partido'               => $_POST['filiado_partido'],
            'filiado_partido_quais'         => $_POST['filiado_partido_quais'],
            'foi_candidato'                 => $_POST['foi_candidato'],
            'foi_candidato_quais'           => $_POST['foi_candidato_quais'],
            'atual_anterior_eleito'         => $_POST['atual_anterior_eleito'],
            'atual_anterior_eleito_quais'   => $_POST['atual_anterior_eleito_quais'],
            'cargo_confianca'               => $_POST['cargo_confianca'],
            'cargo_confianca_quais'         => $_POST['cargo_confianca_quais'],

            //Localização
            'cep'                       => preg_replace('/\D/', '', $_POST['cep']),
            'uf'                        => $_POST['uf'],
            'cidade'                    => $_POST['cidade'],
            'bairro'                    => $_POST['bairro'],
            'endereco'                  => $_POST['endereco'],
            'numero'                    => $_POST['numero'],
            'complemento'               => $_POST['complemento'],

            //Contribuição
            'contribupdate'             => ((!empty($_POST['tipo'])) ? 1 : 0),
            'contribuicao'              => str_replace(',', '.', $_POST['contribuicao']),
            'dados_contribuicao'           => array(
                'tipo'                      => $_POST['tipo'],
                'bandeira'                  => $_POST['bandeira'],
                'cartao_nome'               => $_POST['cartao_nome'],
                'cartao_numero'             => $_POST['cartao_numero'],
                'cartao_codigo_verificacao' => $_POST['cartao_codigo_verificacao'],
                'cartao_validade_mes'       => $_POST['cartao_validade_mes'],
                'cartao_validade_ano'       => $_POST['cartao_validade_ano'],
            ),

            
            //Interesses
            'ativista'                  => $_POST['ativista'],
            'ativista_quais'            => $_POST['ativista_quais'],
            'escolaridade'              => $_POST['escolaridade'],
            'atuacoesProfissionais'     => $_POST['atuacoesProfissionais'],
            'areasInteresse'            => $_POST['areasInteresse'],
            'local_trabalho'            => $_POST['local_trabalho'],
            'voluntario'                => $_POST['voluntario'],

            //Hardcoded infos
            'leu_estatuto'              => true,
            'leu_manifesto'             => true,
        );

        $data = $api->updateProfile($updatedProfile);
        $_SESSION['updatedProfile'] = (object) $updatedProfile;

      }

      if ( (isset($data->status)) && ($data->status == 'ok')) {
        $_SESSION['aviso'] = 'Atualizações salvas com sucesso!';
      }else {
        $_SESSION['aviso'] = 'Atualizações não foram realizadas, algo está errado, tente novamente mais tarde.';
        error_log('Ocorreu o erro 500 ao executar cadastramento da filiação:'. print_r($data, true));
      }

      wp_redirect( $_SERVER['HTTP_REFERER'] );
      exit();
    }


    public function rs_filiado_new_passaporte() {
        $api = Api::getInstance();
        if ( (isset($_POST)) && (count($_POST)>0) ) {
            if($_POST['action'] == 'createRegistration') {
                $newRegister = array(
                    'email'                   => $_POST['email']
                );

                $data = $api->registration($newRegister);
                if ( !$data->errors && $data['response']['code'] && $data['response']['code'] == 200 ) {
                    $res = json_decode($data['body']);

                    if($data->error == true) {
                        $_SESSION['aviso'] = $res->message[0]->msg;
                        $_SESSION['erro'] = false;
                    } else if ($res->passaporte == false){
                        $_SESSION['isPassaporte'] = false;
                        $_SESSION['isAfiliado'] = false;
                        $_SESSION['idUser'] = $res->idUser;
                        $_SESSION['aviso'] = 'Passaporte registrado com sucesso! Prossiga com o cadastramento.';
                    } else if($res->passaporte == true && $res->afiliado == false) {
                        $_SESSION['isPassaporte'] = true;
                        $_SESSION['isAfiliado'] = false;
                        $_SESSION['idUser'] = $res->idUser;
                        $_SESSION['aviso'] = 'Este e-mail já possui um passaporte associado, mas ainda não é um AFILIADO, prossiga com o cadastramento!';
                    } else if ($res->passaporte == true && $res->afiliado == true) {
                        $_SESSION['isPassaporte'] = true;
                        $_SESSION['isAfiliado'] = true;
                        $_SESSION['idUser'] = $res->idUser;
                        $_SESSION['aviso'] = 'Este e-mail já está vinculado a um usuário afiliado, informe outro e-mail para prosseguir!';
                    }
                } else {
                    error_log('Ocorreu o erro 500 ao executar cadastramento da filiação:'. print_r($data, true));
                    $_SESSION['aviso'] = 'Atualizações não foram realizadas, algo está errado, tente novamente mais tarde.';
                    $_SESSION['erro'] = true;
                    $_SESSION['isPassaporte'] = false;
                    $_SESSION['isAfiliado'] = false;
                }
            } else if ($_POST['action'] == 'createFiliacao') {
                $filiado = array(
                    //Dados de Acesso
                    'user_id'                       => $_POST['user_id'],
                    'email'                         => $_POST['email'],

                    //Dados básicos
                    'fullname'                      => $_POST['fullname'],
                    'nome_mae'                      => $_POST['nome_mae'],
                    'birthday'                      => $_POST['birthday'],
                    'sexo'                          => $_POST['sexo'],
                    'status'                        => $_POST['status'],
                    'telefone_residencial'          => $_POST['telefone_residencial'],
                    'telefone_celular'              => $_POST['telefone_celular'],
                    'telefone_comercial'            => $_POST['telefone_comercial'],
                    'nacionalidade'                 => $_POST['nacionalidade'],

                    //Dados eleitorais
                    'cpf'                           => preg_replace('/\D/', '', $_POST['cpf']),
                    'titulo_eleitoral'              => $_POST['titulo_eleitoral'],
                    'zona_eleitoral'                => $_POST['zona_eleitoral'],
                    'secao_eleitoral'               => $_POST['secao_eleitoral'],
                    'tipo_Filiacao'                 => $_POST['tipo_Filiacao'],
                    'quer_ser_candidato'            => $_POST['quer_ser_candidato'],
                    'candidato_cargo'               => $_POST['candidato_cargo'],
                    'candidato_base'                => $_POST['candidato_base'],
                    'candidato_motivo'              => $_POST['candidato_motivo'],
                    'candidato_estatuto'            => $_POST['candidato_estatuto'],
                    'candidato_antecedentes'        => $_POST['candidato_antecedentes'],
                    'filiado_partido'               => $_POST['filiado_partido'],
                    'filiado_partido_quais'         => $_POST['filiado_partido_quais'],
                    'foi_candidato'                 => $_POST['foi_candidato'],
                    'foi_candidato_quais'           => $_POST['foi_candidato_quais'],
                    'atual_anterior_eleito'         => $_POST['atual_anterior_eleito'],
                    'atual_anterior_eleito_quais'   => $_POST['atual_anterior_eleito_quais'],
                    'cargo_confianca'               => $_POST['cargo_confianca'],
                    'cargo_confianca_quais'         => $_POST['cargo_confianca_quais'],

                    //Localização
                    'cep'                       => preg_replace('/\D/', '', $_POST['cep']),
                    'uf'                        => $_POST['uf'],
                    'cidade'                    => $_POST['cidade'],
                    'bairro'                    => $_POST['bairro'],
                    'endereco'                  => $_POST['endereco'],
                    'numero'                    => $_POST['numero'],
                    'complemento'               => $_POST['complemento'],

                    //Contribuição
                    'contribuicao'              => str_replace(',', '.', $_POST['contribuicao']),
                    'forma_pagamento'           => array(
                        'tipo'                      => $_POST['tipo'],
                        'bandeira'                  => $_POST['bandeira'],
                        'cartao_nome'               => $_POST['cartao_nome'],
                        'cartao_numero'             => $_POST['cartao_numero'],
                        'cartao_codigo_verificacao' => $_POST['cartao_codigo_verificacao'],
                        'cartao_validade_mes'       => $_POST['cartao_validade_mes'],
                        'cartao_validade_ano'       => $_POST['cartao_validade_ano'],
                    ),

                    
                    //Interesses
                    'ativista'                  => $_POST['ativista'],
                    'ativista_quais'            => $_POST['ativista_quais'],
                    'escolaridade'              => $_POST['escolaridade'],
                    'atuacoesProfissionais'     => $_POST['atuacoesProfissionais'],
                    'areasInteresse'            => $_POST['areasInteresse'],
                    'local_trabalho'            => $_POST['local_trabalho'],
                    'voluntario'                => $_POST['voluntario'],

                    //Hardcoded infos
                    'leu_estatuto'              => true,
                    'leu_manifesto'             => true,


                );

                $data = $api->saveFiliado($filiado);

                if ( $data['response']['code'] != 500 ) {
                    $_SESSION['aviso'] = 'O cadastro da filiação não foi realizado, algo está errado, tente novamente mais tarde.';
                    $_SESSION['error'] = true;
                    error_log('Ocorreu um erro ao executar cadastramento da filiação:'. print_r($data, true));
                } else {
                    error_log('Ocorreu o erro 500 ao executar cadastramento da filiação:'. print_r($data, true));
                    wp_redirect( admin_url( 'admin.php?page=rs_filiados&aviso=created'));
                }
            }
        }
    }

    public function addScripts($hook)
    {
      if ( (isset($hook)) && ($hook == 'toplevel_page_rs_filiados') ) {
        wp_register_style('backgrid_f', ppf() . 'css/backgrid.css');
        wp_register_style('backgrid-paginator_f', ppf() . 'css/backgrid-paginator.css');
        wp_register_style('main_f', ppf() . 'css/main.css');
        wp_enqueue_style(array('backgrid_f', 'backgrid-paginator_f'));

        wp_register_script('backbone-paginator_f', ppf() . 'js/backbone-paginator.js', array('backbone'), null, true);
        wp_register_script('backgrid_f', ppf() . 'js/backgrid.js', array('backbone-paginator_f'), null, true);
        wp_register_script('backgrid-paginator_f', ppf() . 'js/backgrid-paginator.js', array('backgrid_f'), null, true);
        wp_register_script('rede_filiados_main_js', ppf() . 'js/main.js', array('backgrid-paginator_f', 'backbone-paginator_f'), null, true);
        wp_enqueue_script('rede_filiados_main_js');
      } else if ( (isset($hook)) && ($hook == 'filiados_page_rs_filiado_profile') ) {
        wp_register_style('profile_f', ppf() . 'css/profile.css');
        wp_enqueue_style(array('profile_f'));
        wp_register_script('rede_filiados_filiado_new_js', ppf() . 'js/new-filiado.js', null, null, true);
        wp_enqueue_script('rede_filiados_filiado_new_js');
      } else if ( (isset($hook)) && ($hook == 'filiados_page_rs_filiado_new') ) {
        wp_register_style('filiado_new_f', ppf() . 'css/new-filiado.css');
        wp_register_script('rede_filiados_filiado_new_js', ppf() . 'js/new-filiado.js', null, null, true);
        wp_enqueue_style(array('filiado_new_f'));
        wp_enqueue_script('rede_filiados_filiado_new_js');
      }

    }

    /**
    * Render a Template File
    *
    * @param $filePath
    * @param null $viewData
    * @return string
    */
    public function getTemplatePart($filePath, $viewData = null)
    {

        ( $viewData ) ? extract($viewData) : null;

        ob_start();
        include ( "$filePath" );
        $template = ob_get_contents();
        ob_end_clean();

        return $template;
    }
}
