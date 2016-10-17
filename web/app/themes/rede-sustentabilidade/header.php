<?php define('REDETHEME', dirname(__FILE__)); ?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<?php if (WP_ENV == 'staging') { ?>
			<meta name="robots" CONTENT="noindex, follow">
		<?php } ?>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title><?php wp_title('&#124;', true, 'right'); ?></title>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <?php if (is_single() || is_page()) : if (have_posts()) the_post(); ?>
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
        <?php global $usuario; ?>
        <script>
				var API_PATH = <?php echo json_encode(WP_API_PATH); ?>;
        var SERVER_DOMAIN = <?php echo json_encode($_SERVER['SERVER_NAME']); ?>;
        var THEME_URL = <?php echo json_encode(get_stylesheet_directory_uri()); ?>;
				<?php
				if (count($usuario) > 0) {
					echo "var WP_USER_ID = '".$usuario->id."';";
				}
        ?>
        </script>
        <?php wp_head(); ?>
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700,300' rel='stylesheet' type='text/css'>

<?php bwpy_customizer_head_styles(); ?>

    </head>
    <body <?php body_class(); ?>>
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

    <div id="logo" style="background:none; overflow:visible; text-indent:0%;">

<?php $h1_link = esc_url(home_url('/'));
if (get_post_type() == 'post_region') 
    $h1_link .= 'regional/' . wp_get_post_terms( $post->ID , 'state')[0]->slug;
?>
                    <a href="<?php echo $h1_link; ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">

<?php if (get_theme_mod( 'themeslug_logo' )) : $logo_image = get_theme_mod( 'themeslug_logo'); else: $logo_image = dirname( get_bloginfo('stylesheet_url') ). '/assets/images/redesign/header_logo.png'; endif; ?>

                        <img src='<?php echo $logo_image; ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
                    </a>
    </div>
                <?php $title = get_the_title(); ?>
                <?php $short_url = $url = get_home_url(); ?>
                <div class="extra-content">
                    <div class="compartilhar-na-rede">
                            <ul id="rrssb-buttons" class="rrssb-buttons clearfix no-margin fix-line-height tiny-format">
                                <li class="facebook small">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>" target="_blank">
										<span class="icon">
                                            <svg viewBox="0 0 28 28" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
xml:space="preserve" fill="#306199">
                                            <path d="M27.825,4.783c0-2.427-2.182-4.608-4.608-4.608H4.783c-2.422,0-4.608,2.182-4.608,4.608v18.434
                    c0,2.427,2.181,4.608,4.608,4.608H14V17.379h-3.379v-4.608H14v-1.795c0-3.089,2.335-5.885,5.192-5.885h3.718v4.608h-3.726
                    c-0.408,0-0.884,0.492-0.884,1.236v1.836h4.609v4.608h-4.609v10.446h4.916c2.422,0,4.608-2.188,4.608-4.608V4.783z"/>
                                            </svg>
                                        </span>
                                <li class="twitter small">
                                    <a href="http://twitter.com/home?status=<?php echo urlencode($title); ?> - <?php echo urlencode($short_url); ?>" target="_blank">
                                        <span class="icon">
                            <svg version="1.1" viewBox="0 0 28 28" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
xml:space="preserve" fill="#26C4F1">
                                            <path d="M24.253,8.756C24.689,17.08,18.297,24.182,9.97,24.62c-3.122,0.162-6.219-0.646-8.861-2.32
	c2.703,0.179,5.376-0.648,7.508-2.321c-2.072-0.247-3.818-1.661-4.489-3.638c0.801,0.128,1.62,0.076,2.399-0.155
	C4.045,15.72,2.215,13.6,2.115,11.077c0.688,0.275,1.426,0.407,2.168,0.386c-2.135-1.65-2.729-4.621-1.394-6.965
	C5.575,7.816,9.54,9.84,13.803,10.071c-0.842-2.739,0.694-5.64,3.434-6.482c2.018-0.623,4.212,0.044,5.546,1.683
	c1.186-0.213,2.318-0.662,3.329-1.317c-0.385,1.256-1.247,2.312-2.399,2.942c1.048-0.106,2.069-0.394,3.019-0.851
	C26.275,7.229,25.39,8.196,24.253,8.756z"/>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                                <li class="googleplus small">
                                    <a href="https://plus.google.com/share?url=<?php echo urlencode($title); ?> - <?php echo urlencode($url); ?>" target="_blank">
                                        <span class="icon">
                            <svg version="1.1" viewBox="0 0 28 28" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path d="M14.703,15.854l-1.219-0.948c-0.372-0.308-0.88-0.715-0.88-1.459c0-0.748,0.508-1.223,0.95-1.663
                                                        c1.42-1.119,2.839-2.309,2.839-4.817c0-2.58-1.621-3.937-2.399-4.581h2.097l2.202-1.383h-6.67c-1.83,0-4.467,0.433-6.398,2.027
                                                        C3.768,4.287,3.059,6.018,3.059,7.576c0,2.634,2.022,5.328,5.604,5.328c0.339,0,0.71-0.033,1.083-0.068
                                                        c-0.167,0.408-0.336,0.748-0.336,1.324c0,1.04,0.551,1.685,1.011,2.297c-1.524,0.104-4.37,0.273-6.467,1.562
                                                        c-1.998,1.188-2.605,2.916-2.605,4.137c0,2.512,2.358,4.84,7.289,4.84c5.822,0,8.904-3.223,8.904-6.41
                                                        c0.008-2.327-1.359-3.489-2.829-4.731H14.703z M10.269,11.951c-2.912,0-4.231-3.765-4.231-6.037c0-0.884,0.168-1.797,0.744-2.511
                                                        c0.543-0.679,1.489-1.12,2.372-1.12c2.807,0,4.256,3.798,4.256,6.242c0,0.612-0.067,1.694-0.845,2.478
                                                        c-0.537,0.55-1.438,0.948-2.295,0.951V11.951z M10.302,25.609c-3.621,0-5.957-1.732-5.957-4.142c0-2.408,2.165-3.223,2.911-3.492
                                                        c1.421-0.479,3.25-0.545,3.555-0.545c0.338,0,0.52,0,0.766,0.034c2.574,1.838,3.706,2.757,3.706,4.479
                                                        c-0.002,2.073-1.736,3.665-4.982,3.649L10.302,25.609z" fill="#E93F2E" />
                                                    <polygon points="23.254,11.89 23.254,8.521 21.569,8.521 21.569,11.89 18.202,11.89 18.202,13.604 21.569,13.604 21.569,17.004
                                                        23.254,17.004 23.254,13.604 26.653,13.604 26.653,11.89 		" fill="#E93F2E" />

                                                </g>
                                            </g>
                                            </svg>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                    </div>
                    <div class="fazer">
						<?php get_template_part('login-menu', 'login-menu'); ?>
                        <div class="fazer-doacao">
                          <a href="<?php echo home_url('/faca-sua-doacao/'); ?>"><span class="label">apoie a rede</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <?php if (is_home()) : ?>
        <!--div class="side-tabs faq-active close">
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
        </div-->
        <?php endif; ?>
	<?php date_default_timezone_set('America/Sao_Paulo'); if (is_home()) { ?>
	<div id="slider">
		<?php
			if (function_exists('putRevSlider')) {
				putRevSlider("home");
			}
		?>
	</div>
	<?php } /* === BANNER, FIM === */ ?>
	<div class="clear"></div>
	<div id="wrap">
