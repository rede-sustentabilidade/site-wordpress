<?php
define('REDETHEME', dirname(__FILE__));
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php wp_title('&#124;', true, 'right'); ?></title>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php if (rs_is_mudando()) : ?>
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/facebook-mudandobrasil/16x16.png" type="image/png">
        <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/facebook-mudandobrasil/16x16.png" type="image/png">
        <meta property="fb:app_id" content="590792857635324">
        <?php if (is_page('mudando-o-brasil-embed') || is_home()) : ?>
        <meta property="og:title" content="Mudando o Brasil">
        <meta property="og:description" content="Conheça a plataforma colaborativa que vai receber sugestões dos cidadãos para auxiliar na construção do Programa de Governo da Coligação #Rede e PSB">
        <meta property="og:type" content="<?php echo is_home() ? 'website' : 'article'; ?>">
        <meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/open-graph.png">
        <?php elseif (is_single() || is_page()) : if (have_posts()) the_post(); ?>
        <meta property="og:url" content="<?php the_permalink(); ?>">
        <meta property="og:title" content="<?php single_post_title(''); ?>">
        <meta name="description" content="<?php the_excerpt_rss(); ?>">
        <meta property="og:type" content="article">
        <?php if (has_post_thumbnail()) : $thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID())); ?>
        <meta property="og:image" content="<?php echo esc_attr($thumbURL[0]); ?>">
        <?php else: ?>
        <meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/open-graph.png">
        <?php endif; ?>
        <?php rewind_posts(); endif; ?>
        <?php else : /* if (rs_is_mudando()) */ ?>
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon">
        <meta property="fb:app_id" content="536115646469279">
        <?php if (is_page( 'filie-se' )) : ?>
        <meta property="og:title" content="#Rede, um partido de fato. Filie-se!">
        <meta property="og:description" content="Se você realizar a sua pré-filiação até 30 de novembro e tiver sua ficha confirmada, terá o direito de participar das convenções estaduais que ocorrerão em fevereiro e março do ano que vem.">
        <meta property="og:type" content="article">
        <meta property="og:image" content="<?php echo content_url('uploads/2013/11/rede.png'); ?>">
        <?php elseif (is_single() || is_page()) : if (have_posts()) the_post(); ?>
        <meta property="og:url" content="<?php the_permalink(); ?>">
        <meta property="og:title" content="<?php single_post_title(''); ?>">
        <meta name="description" content="<?php the_excerpt_rss(); ?>">
        <meta property="og:type" content="article">
        <?php if (has_post_thumbnail()) : $thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID())); ?>
        <meta property="og:image" content="<?php echo esc_attr($thumbURL[0]); ?>">
        <?php else: ?>
        <meta property="og:image" content="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/open-graph.png">
        <?php endif; ?>
        <?php rewind_posts(); elseif (is_home()) : ?>
        <meta property="og:title" content="Seja mais um elo da Rede Sustentabilidade!">
        <meta property="og:description" content="A Rede Sustentabilidade é fruto de um movimento aberto, autônomo e suprapartidário que reúne brasileiros decididos a reinventar o futuro do país.">
        <meta property="og:type" content="website">
        <meta property="og:image" content="<?php echo content_url('uploads/2013/11/rede.png'); ?>">
        <?php endif; ?>
        <?php endif; /* if (rs_is_mudando()) */ ?>
        <?php global $current_user; get_currentuserinfo(); ?>
        <script>
        var
        SERVER_DOMAIN = <?php echo json_encode($_SERVER['SERVER_NAME']); ?>,
        WP_USER_ID = <?php echo json_encode($current_user->ID); ?>,
        THEME_URL = <?php echo json_encode(get_stylesheet_directory_uri()); ?>;
        </script>
        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
		<?php if (!rs_is_mudando()) : ?>
        <nav id="site-navigation" class="main-nav" role="navigation">
            <div id="main-nav-wrapper">
                <?php if (has_nav_menu('main_nav')) : ?>
                <?php
                    $nav_args = array('theme_location' => 'main_nav');

                    if (get_post_type() == 'post_region')
                        $nav_args['items_wrap'] = '<ul id="%1$s" class="%2$s"><li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-site-principal" id="menu-item-site-principal"><a href="' . esc_url(home_url('/')) . '">Site Principal</a></li>%3$s</ul>';

                    wp_nav_menu($nav_args);
                ?>
                <?php else : ?>
                <ul><?php wp_list_pages(array('depth' => 3, 'title_li' => '')); ?></ul>
                <?php endif; ?>
                <h1 id="logo">
                    <?php
                        $h1_link = esc_url(home_url('/'));

                        if (get_post_type() == 'post_region') $h1_link .= 'regional/' . wp_get_post_terms( $post->ID , 'state')[0]->slug;
                     ?>
                    <a href="<?php echo $h1_link; ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                        <?php echo get_option('blogname'); ?>
                    </a>
                </h1>
                <?php $title = get_the_title(); ?>
                <?php $short_url = $url = get_home_url(); ?>
                <div class="extra-content">
                    <div class="compartilhar-na-rede">
                        <div class="share-container clearfix">
                            <ul id="rrssb-buttons" class="rrssb-buttons clearfix no-margin fix-line-height tiny-format">
                                <li class="facebook small">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank">
                                        <span class="icon"><?php echo file_get_contents('icons/facebook.svg', true); ?></span>
                                        <span class="text">facebook</span>
                                    </a>
                                </li>
                                <li class="twitter small">
                                    <a href="http://twitter.com/home?status=<?php echo urlencode($title); ?> - <?php echo urlencode($short_url); ?>" target="_blank">
                                        <span class="icon"><?php echo file_get_contents('icons/twitter.svg', true); ?></span>
                                        <span class="text">twitter</span>
                                    </a>
                                </li>
                                <li class="googleplus small">
                                    <a href="https://plus.google.com/share?url=<?php echo urlencode($title); ?> - <?php echo urlencode($url); ?>" target="_blank">
                                        <span class="icon"><?php echo file_get_contents('icons/google_plus.svg', true); ?></span>
                                        <span class="text">google+</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="fazer">
                        <div class="fazer-participacao">
                            <!--a target="_blank" href="http://www.marinasilva.org.br/?ref=redesustentabilidade"><span class="label">marina presidente</span></a-->
                        </div>
                        <?php get_template_part('login-menu', 'login-menu'); ?>
                        <div class="fazer-doacao">
                          <a href="<?php echo home_url('/faca-sua-doacao/'); ?>"><span class="label">apoie a rede</span></a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>

        <?php if (is_home()) : ?>
        <div class="side-tabs faq-active close">
            <div class="content">
                <div class="faq">
                    <span class="btn-side-tabs">
                        <i class="icon-fechar"></i>
                    </span>

                    <div class="item open">
                        <div class="question">
                            A #Rede agora faz parte do PSB?
                        </div>

                        <div class="answer">
                            <p>N&atilde;o. A #Rede n&atilde;o est&aacute; subordinada ao PSB. Ao se coligar, por meio da filia&ccedil;&atilde;o democr&aacute;tica de alguns de seus membros, a #Rede se afirma como partido aut&ocirc;nomo, em uma rela&ccedil;&atilde;o que valoriza vis&otilde;es em comum, program&aacute;ticas, e na qual as identidades de cada partido ser&atilde;o preservadas.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="question">
                            Como foi constru&iacute;da a coliga&ccedil;&atilde;o da Rede Sustentabilidade com o PSB?
                        </div>
                        <div class="answer">
                            <p>O objetivo central da alian&ccedil;a entre a #Rede e o PSB &eacute; aprofundar a democracia e construir as bases para um ciclo duradouro de desenvolvimento sustent&aacute;vel, os dois pilares da verdadeira soberania nacional. Essa uni&atilde;o ser&aacute; constru&iacute;da a partir de uma base program&aacute;tica e da busca de uma nova pol&iacute;tica.</p>
                            <p>Sabemos que n&atilde;o ser&aacute; f&aacute;cil e h&aacute; muitas incertezas envolvidas que s&oacute; ser&atilde;o superadas com a participa&ccedil;&atilde;o efetiva da milit&acirc;ncia da Rede. Mas sabemos tamb&eacute;m que o PSB &eacute; a for&ccedil;a pol&iacute;tica que mais oferece condi&ccedil;&otilde;es para, junto com a REDE, oferecer uma resist&ecirc;ncia aos retrocessos na democracia, na cidadania, na economia e no meio ambiente.</p>
                            <p>Em conjunto, vamos construir um programa comum, que atenda as nossas principais demandas: aprofundamento da democracia; manuten&ccedil;&atilde;o dos avan&ccedil;os sociais e econ&ocirc;micos dos &uacute;ltimos anos e a sustentabilidade no eixo da agenda estrat&eacute;gica de desenvolvimento. A converg&ecirc;ncia program&aacute;tica entre a #Rede e o PSB ser&aacute; desdobrada num calend&aacute;rio que leve a discuss&atilde;o &agrave; sociedade, que precisa ser a real balizadora do processo.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="question">
                            As coliga&ccedil;&otilde;es estaduais seguir&atilde;o a coliga&ccedil;&atilde;o nacional?
                        </div>
                        <div class="answer">
                            <p>Tentaremos manter as coliga&ccedil;&otilde;es estaduais dos dois partidos. &Eacute; esperado que ocorram entretanto circunst&acirc;ncias locais onde esta alian&ccedil;a se demonstrar&aacute; invi&aacute;vel. Nestes casos a Rede adotar&aacute; um posicionamento independente, apoiando a coliga&ccedil;&atilde;o nacional, mas realizando a t&aacute;tica eleitoral que for adequada ao nosso programa, valores e princ&iacute;pios.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="question">
                            O que &eacute; a Filia&ccedil;&atilde;o democr&aacute;tica?
                        </div>
                        <div class="answer">
                            <p>A filia&ccedil;&atilde;o democr&aacute;tica e transit&oacute;ria &eacute; uma tradi&ccedil;&atilde;o brasileira nas situa&ccedil;&otilde;es em que correntes pol&iacute;ticas s&atilde;o impedidas de se organizar formalmente e de participar com sua pr&oacute;pria legenda dos processos pol&iacute;ticos e eleitorais. </p>
                            <p>A coliga&ccedil;&atilde;o program&aacute;tica entre a #Rede e o PSB se d&aacute; nacionalmente, com a possibilidade de filia&ccedil;&otilde;es democr&aacute;ticas e transit&oacute;rias para a disputa eleitoral de 2014, preservando a identidade dos dois partidos. Onde cada um respeita a sua personalidade pr&oacute;pria e se disp&otilde;e a um di&aacute;logo para um objetivo comum.
                            Temos a plena convic&ccedil;&atilde;o que somos um partido, pois temos um programa e base de representa&ccedil;&atilde;o social, nos constitu&iacute;mos em um processo que visa aprofundar a discuss&atilde;o pelo desenvolvimento sustent&aacute;vel e democratiza&ccedil;&atilde;o da democracia.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="question">
                            Como fica a Rede? Ou qual o futuro da Rede Sustentabilidade?
                        </div>
                        <div class="answer">
                            <p>A Rede mant&eacute;m seu firme prop&oacute;sito de superar velhos h&aacute;bitos e v&iacute;cios da pol&iacute;tica brasileira e fortalecer seus princ&iacute;pios e valores. Sua milit&acirc;ncia e suas lideran&ccedil;as continuar&atilde;o comprometidos com o objetivo de constitui&ccedil;&atilde;o e organiza&ccedil;&atilde;o do partido e Marina Silva continua sendo representante e porta-voz da Rede, mesmo tendo se filiado ao PSB. </p>
                            <p>Vamos retomar as coletas de assinaturas e nos preparar para o momento da legaliza&ccedil;&atilde;o, organizando nossos diret&oacute;rios, coletivos e n&uacute;cleos nos estados, aprofundando as discuss&otilde;es do programa do partido e levando nossa mensagem em todo o Pa&iacute;s.</p>
                        </div>
                    </div>

                    <div class="item">
                        <div class="question">
                            Quais s&atilde;o as a&ccedil;&otilde;es da Rede daqui para frente?
                        </div>
                        <div class="answer">
                            <p>Como somos um partido de fato, vamos iniciar o processo de filia&ccedil;&atilde;o &agrave; Rede, mesmo n&atilde;o tendo o registro do TSE. &Eacute; uma filia&ccedil;&atilde;o de car&aacute;ter pol&iacute;tico, mas com todas as prerrogativas, direitos e deveres previstos no Estatuto. Vamos realizar encontros estaduais e regionais, constituir Diret&oacute;rios nos 27 Estados e em in&uacute;meros Munic&iacute;pios.</p>
                            <p>Al&eacute;m disso, a Rede Sustentabilidade tem uma contribui&ccedil;&atilde;o singular para Democratizar a Democracia e para construir o Desenvolvimento Sustent&aacute;vel. Por isso, vamos discutir o Programa de Governo e fortalecer a Coliga&ccedil;&atilde;o Democr&aacute;tica com o PSB e procurar participar ativamente das pr&oacute;ximas elei&ccedil;&otilde;es.</p>
                        </div>
                    </div>

                </div>

                <div class="sugestions">
                    <span class="btn-side-tabs">
                        <i class="icon-fechar"></i>
                    </span>
                    <p>Envie sua sugest&atilde;o para a #Rede, reporte um problema ou deixe um elogio</p>
                    <form id="sugestion-form" action="">
                        <fieldset>
                            <input type="text" name="name" placeholder="Nome">
                        </fieldset>
                        <fieldset>
                            <input type="text" name="email" placeholder="E-mail">
                        </fieldset>
                        <fieldset>
                            <textarea name="message" placeholder="Mensagem"></textarea>
                        </fieldset>
                        <fieldset>
                            <input type="submit" value="Contribuir" class="input-submit wpcf7-form-control wpcf7-submit">
                        </fieldset>
                    </form>
                </div>

            </div>
            <div class="tabs tabs-faq-active">
                <div class="tabs-opt tabs-sugestions" data-name="sugestions"></div>
                <div class="tabs-opt tabs-faq" data-name="faq"></div>
            </div>
        </div>
        <?php endif; ?>


        <?php
        /* ===================================================================
         *
         *
         *                             BANNER
         *
         *
         * ===================================================================
         */
        date_default_timezone_set('America/Sao_Paulo');
        if (is_home()) {
        ?>

        <div id="slider">
            <?php
            	if (function_exists('putRevSlider')) {
            		putRevSlider("home");
            	}
            ?>
        </div>

        <?php }
        /* === BANNER, FIM === */
        ?>


        <?php endif; ?>
        <div class="clear"></div>
        <div id="wrap" class="<?php if ('sim' == get_post_meta(get_queried_object_id(), 'remover-rodape', true)) echo 'pagina-sem-header'; ?>">
