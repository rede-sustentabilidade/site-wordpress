<?php

namespace Rede;

class Contribuicoes
{
    private $jsAdmin = 'js/main.js';
    private $apiPath;
    private $mainTemplate = 'templates/grid.templ.php';

    public function __construct($type)
    {
      $this->apiPath = WP_API_PATH;

      if (isset($_GET['export'])) {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=export-contribuicoes.csv");
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
        add_menu_page('Contribuições', 'Contribuições', 'finance', 'rs_contribuicoes', array($this, 'getContribuicoes'), 'dashicons-backup');
        //add_submenu_page('rs-payment-profile', 'Filiados contribuintes', 'Filiados contribuintes', 'administrator', 'rs-payment-profile', 'rs_payment_profile');
        //add_submenu_page('rs-payment-profile', 'Contribuições processadas', 'Contribuições processadas', 'administrator', 'rs-payment-payment', 'rs_payment_payment');
    }

    public function buildUrlFilters() {
      $filters = array(
        'afiliados.user_id'=>'',
        'afiliados.fullname'=>'',
        'afiliados.cpf'=>'',
        'dados_contribuicoes.tipo'=>'',
        'afiliados.uf'=>'',
        'afiliados.cidade'=>'',
        'dados_contribuicoes.tipo'=>'',
        'payments.return_message'=>'',
        'payments.created_at'=>''
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
      return array('filters'=>$filters,'url'=>$this->apiPath . '/payment?' . $url_params);
    }

    public function getContribuicoes()
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


    public function addScripts($hook)
    {
      if ( (isset($hook)) && ($hook == 'toplevel_page_rs_contribuicoes') ) {
        wp_register_style('backgrid', pp() . 'css/backgrid.css');
        wp_register_style('backgrid-paginator', pp() . 'css/backgrid-paginator.css');
        wp_enqueue_style(array('backgrid', 'backgrid-paginator'));

        wp_register_script('backbone-paginator', pp() . 'js/backbone-paginator.js', array('backbone'), null, true);
        wp_register_script('backgrid', pp() . 'js/backgrid.js', array('backbone-paginator'), null, true);
        wp_register_script('backgrid-paginator', pp() . 'js/backgrid-paginator.js', array('backgrid'), null, true);
        wp_register_script('rede_contribuicoes_main_js', pp() . 'js/main.js', array('backgrid-paginator', 'backbone-paginator'), null, true);
        wp_enqueue_script('rede_contribuicoes_main_js');
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
