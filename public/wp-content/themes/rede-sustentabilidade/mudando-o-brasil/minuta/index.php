<?php

if (!defined('MUDANDOBRASIL')) define('MUDANDOBRASIL', true);

//wp_enqueue_script( 'page-filiacao', get_stylesheet_directory_uri() . '/assets/js/page-filiacao.min.js', array(), '0.1', true);
wp_enqueue_script( 'page-minuta', get_stylesheet_directory_uri() . '/assets/js/source/minuta/main.js', array('require'), '0.2', true);

wp_enqueue_style( 'consulta', get_stylesheet_directory_uri() . '/css/minuta.css' );
 ?>
<?php get_header(); ?>
    <div class="pure-g-r">
        <div class="menubar pure-u-1">

            <?php require_once REDETHEME . '/mudando-o-brasil/menu.php' ?>

            <div class="content">

                <div class="sub-header">

                    <i class="partido psb"></i>
                    <i class="partido rede"></i>
                    <i class="partido pps"></i>
                    <?php
                    // Caso não seja a página de uma categoria de participação, exibe o texto aqui
                    if ( $categoryCurrent == '' ):
                    ?>

                        <h1>
                            <span class="title">Mudando o Brasil</span>
                            <span class="sub"><?php the_title(); ?></span>
                        </h1>
                        <?php the_content(); ?>

                    <?php else: ?>
                        <h1>
                            <span class="title">Mudando o Brasil</span>
                            <span class="sub">Desafios</span>
                        </h1>
                    <?php endif; ?>
                </div>

            </div>
            <?php if ( (preg_match('/mudando/', $_SERVER['HTTP_HOST'])) || (defined('MUDANDOBRASIL') && MUDANDOBRASIL)){  ?>
            <div class="login">
              <?php if ( is_user_logged_in() ) { ?>
                  <?php global $current_user; get_currentuserinfo(); ?>
                    <span><?php echo $current_user->user_nicename; ?></span>
                    <a href="<?php echo wp_logout_url(); ?>">Sair</a>
              <?php } else { ?>
                    <a href="<?php $get_back = get_permalink(); echo wp_registration_url($get_back) . '&redirect_to=' . $get_back; ?>" class="label borderd">registre-se</a>
                    <a href="<?php echo wp_login_url($get_back); ?>" class="label"><strong>login</strong></a>
              <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="pure-u-3-5 content">
            <?php query_posts('category_name=Consulta'); while (have_posts()) : the_post(); ?>
            <h1 data-step="1" data-intro="Bem-vindo ao texto base da construção do Programa de Governo da Coligação REDE/PSB. Clique em 'Próximo' para entender como este site funciona ou 'Ignorar' para sair da ajuda inicial."><?php the_title(); ?></h1>
            <div class="comments-bar">
                <i class="icon-comment"></i>
                <span class="count-comment">Total de comentários <?php $comments = wp_count_comments($post->ID); echo "(" . $comments->approved . ")"; ?></span>
            </div>
            <div class="main-text">
                <?php the_content(); ?>
            </div>
        <?php endwhile; ?>
        </div>
        <div class="pure-u-2-5 sidebar">
            <?php /* div class="sidebox sub-featured" data-intro="Aqui está o texto do PDE de 2002 para consulta. Assim fica fácil ver as diferenças entre a lei antiga e a nova." data-step="3" data-position="left">
                <?php $pp = get_posts(array('post_type'=>'page', 'ID'=>2)); $pp = $pp[0]; ?>
                <h2><i class="minuta-icon-book"></i><?php echo $pp->post_title; ?></h2>
                <div class="text-content" data-url="<?php bloginfo('home'); ?>/minuta-antiga/">
                <?php //echo ($pp->post_content); ?>
                </div>
                <div class="related-content">
                    <p>
                        conteúdo relacionado:
                        <a target="_blank" href="http://www.prefeitura.sp.gov.br/cidade/secretarias/desenvolvimento_urbano/legislacao/plano_diretor/index.php?p=1391"><i class="minuta-icon-map"></i>mapas</a>
                        <a target="_blank" href="http://www.prefeitura.sp.gov.br/cidade/secretarias/desenvolvimento_urbano/legislacao/plano_diretor/index.php?p=1392"><i class="minuta-icon-quadro"></i>quadros</a>
                    </p>
                </div>
            </div>*/
            ?>

            <!--div class="sidebox featured-comment" data-intro="Estas são as explicações da Secretaria de Desenvolvimento Urbano (SMDU) e as propostas feitas pela população que estão relacionados com o trecho que você selecionar." data-step="4" data-position="left">
                <h2><i class="minuta-icon-pencil"></i>observações da smdu</h2>
                <div class="text-content" id="commentFeaturedContainer">
                </div>
                <div class="related-content">
                </div>
            </div-->

            <?php /* TODO: Move CSS to specific file. Keep it inline is not a good idea! */ ?>
            <!-- Index - start -->
            <div class="sidebox" style="padding-bottom:10px;">
                <h2 style="padding-bottom:3px;">
                  <span style="display:inline-block;width:20px;height:20px;margin:1px 7px 0;background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAzklEQVQ4T+2UwQ2DMAxF4wnKBrQbdANGaDcoTAKblBFgA0boCGWDbpD+HxEpygWH5IglywfiZ/vHRKy1lTHmDX/CJ3gnIj/EQyYALshsguwZQMINvrUIrxQygTZOAFA24IDYpwL3OmSXamOH1HCEP+AzvM3SUF1aedBpVdK8+Hc/Msb95BSghhSde+iNe0hNuTZXhDqlAIFc4kuQ9AXwtgEHxOS1iYErgOyMHR4C7o3s4FoLL8X9y9mXoq2sPVd+D8/ni9rHDyzXSm3Fn68/Bhh3cEWwb8MAAAAASUVORK5CYII=');"></span>
                  índice
                </h2>
                <div id="index-contents">
                  <ul style="list-style:none;margin:10px 0 0;">
                    <li><a href="#introducao" style="color:#7fa31a;font-size:14px;text-decoration:none;">Introdução</a></li>
                    <li><a href="#eixo-1" style="color:#7fa31a;font-size:14px;text-decoration:none;">Eixo 1 – Estado e a democracia de alta intensidade</a></li>
                    <li><a href="#eixo-2" style="color:#7fa31a;font-size:14px;text-decoration:none;">Eixo 2 – Economia para o desenvolvimento sustentável</a></li>
                    <li><a href="#eixo-3" style="color:#7fa31a;font-size:14px;text-decoration:none;">Eixo 3 – Educação, cultura e inovação</a></li>
                    <li><a href="#eixo-4" style="color:#7fa31a;font-size:14px;text-decoration:none;">Eixo 4 – Políticas sociais e qualidade de vida</a></li>
                    <li><a href="#eixo-5" style="color:#7fa31a;font-size:14px;text-decoration:none;">Eixo 5 – Novo urbanismo e o pacto pela vida</a></li>
                    <li><a href="#conclusoes" style="color:#7fa31a;font-size:14px;text-decoration:none;">Conclusões</a></li>
                  </ul>
                </div>
            </div>
            <!-- Index - end -->

            <div class="sidebox comments" data-intro="Aqui você pode acompanhar os comentários já feitos sobre cada trecho, indicado pelo ícone em destaque, ao final de cada parágrafo." data-step="3" data-position="left">
                <h2><i class="icon-comment"></i>comentários</h2>
                <div id="commentContainer">
                </div>
            </div>
        </div>
    </div>

    <div id="modal-content-box" class="pure-g-r" style="display:none"></div>
<script>
jQuery('.menu a').removeClass("active");
jQuery('.minuta').addClass("active");
</script>
<?php get_footer(); ?>
