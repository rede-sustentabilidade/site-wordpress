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
        add_menu_page('Filiados', 'Filiados', 'filiados', 'rs_filiados', array($this, 'getFiliados'), 'dashicons-businessman');
        add_submenu_page( 'rs_filiados', 'Adicionar novo', 'Adicionar novo', 'filiados', 'rs_filiado_new', array($this, 'newFiliado'));
        add_submenu_page( 'rs_filiados', 'Detalhes do filiado', 'Detalhes do filiado', 'filiados', 'rs_filiado_profile', array($this, 'getProfile'));
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

      foreach (explode('&',$_SERVER['QUERY_STRING']) as $query) {
        $filter_field = substr($query, 0,strpos($query, '='));

        if (strpos($query, '=') < (strlen($query) - 1)) {
          $filter_value = substr($query, strpos($query, '=')+1);
          $filters[$filter_field] = $filter_value;
          if ( ($filter_value !== '') && ($filter_field !== 'page') ) {
            $url_params .= $filter_field.'='.$filter_value.'&';
          }
        }
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
            'filters' => $data['filters']
            // 'answers' => json_encode($json),
            // 'correct' => json_encode(get_post_meta($post->ID, 'correct_answer'))
        );

        echo $this->getTemplatePart($this->mainTemplate, $viewData);

    }

    public function getProfile() {

      $api = Api::getInstance();
      $aviso = '';

      if ( (isset($_SESSION)) && (!empty($_SESSION['aviso'])) ) {
        $aviso = $_SESSION['aviso'];
        $_SESSION['aviso'] = '';
      }

      $data = $api->getProfile($_GET['user_id']);
      $viewData = array('profile'=>$data, 'aviso'=>$aviso);
      echo $this->getTemplatePart($this->profileTemplate, $viewData);
    }

    public function newFiliado() {

      $api = Api::getInstance();
      $aviso = '';

      if ( (isset($_SESSION)) && (!empty($_SESSION['aviso'])) ) {
        $aviso = $_SESSION['aviso'];
        $_SESSION['aviso'] = '';
      }

      if ( (isset($_SESSION)) && (!empty($_SESSION['passaporte'])) ) {
        $passaporte = $_SESSION['passaporte'];
        $_SESSION['passaporte'] = '';
      }

      if ( (isset($_SESSION)) && (!empty($_SESSION['afiliado'])) ) {
        $filiado = $_SESSION['afiliado'];
        $_SESSION['afiliado'] = '';
      }

      $data = $api->getProfile($_GET['user_id']);
      $viewData = array('profile'=>$data, 'aviso'=>$aviso, 'passaporte'=>$passaporte, 'afiliado' => $afiliado);
      echo $this->getTemplatePart($this->newFiliadoTemplate, $viewData);
    }

    public function rs_filiado_profile_admin_action()
    {
      $api = Api::getInstance();
      $data = "";
      if ( (isset($_POST)) && (count($_POST)>0) ) {

        $updatedProfile = array(
          'user_id'                   => $_POST['user_id'],
          'tipo'                      => $_POST['tipo'],
          'bandeira'                  => $_POST['bandeira'],
          'cartao_nome'               => $_POST['cartao_nome'],
          'cartao_numero'             => $_POST['cartao_numero'],
          'cartao_validade_mes'       => $_POST['cartao_validade_mes'],
          'cartao_validade_ano'       => $_POST['cartao_validade_ano'],
          'cartao_codigo_verificacao' => $_POST['cartao_codigo_verificacao'],
          // 'nome_titular'              => $_POST['nome_titular'],
          // 'agencia'                   => $_POST['agencia'],
          // 'banco'                     => $_POST['banco'],
          // 'numero_conta'              => $_POST['numero_conta'],
          'contribuicao'              => str_replace(',', '.', $_POST['contribuicao']),
          'telefone_residencial'      => $_POST['telefone_residencial'],
          'telefone_celular'          => $_POST['telefone_celular'],
          // 'telefone_comercial'        => $_POST['telefone_comercial'],
          'cep'                       => $_POST['cep'],
          'endereco'                  => $_POST['endereco'],
          'numero'                    => $_POST['numero'],
          'complemento'               => $_POST['complemento'],
          'bairro'                    => $_POST['bairro'],
          'cidade'                    => $_POST['cidade'],
          'uf'                        => $_POST['uf'],
          'cpf'                       => $_POST['cpf'],
          'fullname'                      => $_POST['fullname'],
          'titulo_eleitoral'          => $_POST['titulo_eleitoral'],
          'zona_eleitoral'            => $_POST['zona_eleitoral'],
          'secao_eleitoral'           => $_POST['secao_eleitoral'],

          'nome_mae'           => $_POST['nome_mae'],
          'birthday'           => $_POST['birthday'],
          'sexo'           => $_POST['sexo'],
          'status'           => $_POST['status'],


          'contribupdate' => ((!empty($_POST['tipo'])) ? 1 : 0)
        );

        $data = $api->updateProfile($updatedProfile);
      }

      if ( (isset($data->status)) && ($data->status == 'ok')) {
        $_SESSION['aviso'] = 'Atualizações salvas com sucesso!';
      }else {
        $_SESSION['aviso'] = 'Atualizações não foram realizada, algo está errado, tente novamente mais tarde.';
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
                // error_log('response code:'. $data['response']['code']);
                // error_log('response dump:'. var_dump($data));
                if ( !$data->errors && $data['response']['code'] && $data['response']['code'] == 200 ) {
                    $res = json_decode($data['body']);
                    //var_dump($res);
                    if($data->error == true) {
                        $_SESSION['aviso'] = $res->message[0]->msg;
                        $_SESSION['erro'] = false;
                    } else if ($res->passaporte == false){
                        $_SESSION['passaporte'] = false;
                        $_SESSION['afiliado'] = false;
                        $_SESSION['aviso'] = 'Passaporte registrado com sucesso! Prossiga com o cadastramento.';
                    } else if($res->passaporte == true && $res->afiliado == false) {
                        $_SESSION['passaporte'] = true;
                        $_SESSION['afiliado'] = false;
                        $_SESSION['aviso'] = 'Este e-mail já possui um passaporte associado, mas ainda não é um AFILIADO, prossiga com o cadastramento!';
                    } else if ($res->passaporte == true && $res->afiliado == true) {
                        $_SESSION['passaporte'] = true;
                        $_SESSION['afiliado'] = true;
                        $_SESSION['aviso'] = 'Este e-mail já está vinculado a um usuário afiliado, informe outro e-mail para prosseguir!';
                    }
                } else {
                    $_SESSION['aviso'] = 'Atualizações não foram realizadas, algo está errado, tente novamente mais tarde.';
                    $_SESSION['erro'] = true;
                    $_SESSION['passaporte'] = false;
                    $_SESSION['afiliado'] = false;
                }
            } else if ($_POST['action'] == 'createFiliacao') {
                $filiado = array(
                    //Dados de Acesso
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
                    'cpf'                           => $_POST['cpf'],
                    'titulo_eleitoral'              => $_POST['titulo_eleitoral'],
                    'zona_eleitoral'                => $_POST['zona_eleitoral'],
                    'secao_eleitoral'               => $_POST['secao_eleitoral'],
                    'quer_ser_candidato'            => $_POST['quer_ser_candidato'],
                    'candidato_cargo'               => $_POST['candidato_cargo'],
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
                    'cep'                       => $_POST['cep'],
                    'uf'                        => $_POST['uf'],
                    'cidade'                    => $_POST['cidade'],
                    'bairro'                    => $_POST['bairro'],
                    'endereco'                  => $_POST['endereco'],
                    'numero'                    => $_POST['numero'],
                    'complemento'               => $_POST['complemento'],

                    //Contribuição
                    'tipo'                      => $_POST['tipo'],
                    'contribuicao'              => str_replace(',', '.', $_POST['contribuicao']),
                    'bandeira'                  => $_POST['bandeira'],
                    'cartao_nome'               => $_POST['cartao_nome'],
                    'cartao_numero'             => $_POST['cartao_numero'],
                    'cartao_codigo_verificacao' => $_POST['cartao_codigo_verificacao'],
                    'cartao_validade_mes'       => $_POST['cartao_validade_mes'],
                    'cartao_validade_ano'       => $_POST['cartao_validade_ano'],
                    
                    //Interesses
                    'ativista'                  => $_POST['ativista'],
                    'escolaridade'              => $_POST['escolaridade'],
                    'atuacoesProfissionais'     => $_POST['atuacoesProfissionais'],
                    'areasInteresse'            => $_POST['areasInteresse'],
                    'local_trabalho'            => $_POST['local_trabalho'],
                    'voluntario'                => $_POST['voluntario'],

                    'contribupdate'             => ((!empty($_POST['tipo'])) ? 1 : 0)
                );

                $data = $api->saveFiliado($filiado);
            }
        }
    }


    public function rs_filiado_new_filiado_admin_action() {
      $api = Api::getInstance();
      if ( (isset($_POST)) && (count($_POST)>0) ) {

        $updatedProfile = array(
          'user_id'                   => $_POST['user_id'],
          'tipo'                      => $_POST['tipo'],
          'bandeira'                  => $_POST['bandeira'],
          'cartao_nome'               => $_POST['cartao_nome'],
          'cartao_numero'             => $_POST['cartao_numero'],
          'cartao_validade_mes'       => $_POST['cartao_validade_mes'],
          'cartao_validade_ano'       => $_POST['cartao_validade_ano'],
          'cartao_codigo_verificacao' => $_POST['cartao_codigo_verificacao'],
          // 'nome_titular'              => $_POST['nome_titular'],
          // 'agencia'                   => $_POST['agencia'],
          // 'banco'                     => $_POST['banco'],
          // 'numero_conta'              => $_POST['numero_conta'],
          'contribuicao'              => str_replace(',', '.', $_POST['contribuicao']),
          'telefone_residencial'      => $_POST['telefone_residencial'],
          'telefone_celular'          => $_POST['telefone_celular'],
          // 'telefone_comercial'        => $_POST['telefone_comercial'],
          'cep'                       => $_POST['cep'],
          'endereco'                  => $_POST['endereco'],
          'numero'                    => $_POST['numero'],
          'complemento'               => $_POST['complemento'],
          'bairro'                    => $_POST['bairro'],
          'cidade'                    => $_POST['cidade'],
          'uf'                        => $_POST['uf'],
          'cpf'                       => $_POST['cpf'],
          'fullname'                      => $_POST['fullname'],
          'titulo_eleitoral'          => $_POST['titulo_eleitoral'],
          'zona_eleitoral'            => $_POST['zona_eleitoral'],
          'secao_eleitoral'           => $_POST['secao_eleitoral'],

          'nome_mae'           => $_POST['nome_mae'],
          'birthday'           => $_POST['birthday'],
          'sexo'           => $_POST['sexo'],
          'status'           => $_POST['status'],


          'contribupdate' => ((!empty($_POST['tipo'])) ? 1 : 0)
        );

        $data = $api->updateProfile($updatedProfile);
      }

      if ( (isset($data->status)) && ($data->status == 'ok')) {
        $_SESSION['aviso'] = 'Atualizações salvas com sucesso!';
      }else {
        $_SESSION['aviso'] = 'Atualizações não foram realizada, algo está errado, tente novamente mais tarde.';
      }

      wp_redirect( $_SERVER['HTTP_REFERER'] );
      exit();
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
