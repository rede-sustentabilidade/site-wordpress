
<?php
//require_once("../aviso-mobile/verifica.php");

if (!defined('MUDANDOBRASIL')) define('MUDANDOBRASIL', true);

if ( is_user_logged_in() ) {
    $disable = '';
} else {
    $disable = 'disabled="disabled"';
}
?>
<?php get_header(); ?>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

  <div id="landing">
    <div class="header">

      <?php require_once REDETHEME . '/mudando-o-brasil/menu.php' ?>

      <div class="content">
        <span class="partidos"></span>
        <h1><?php the_title(); ?></h1>

        <?php the_content(); ?>
        <a href="#">apresentação</a>
      </div>

      <div class="video">
      	<iframe width="480" height="360" src="//www.youtube.com/embed/E0xhqvPFAEU" frameborder="0" allowfullscreen></iframe>
        <div class="texto-home">
          <p>O modo de construir e detalhar o Programa que orienta a coligação PSB /
          Rede está fundamentado na firme convicção de que a participação e o
          compartilhamento são elementos essenciais para forças políticas que
          desejam, efetivamente, contribuir para que o Brasil avance, no sentido
          de se tornar mais justo, inclusivo e sustentável.</p>

          <p>Nesse sentido, em 28 de outubro houve o Primeiro Encontro Programático
          PSB / REDE, do qual resultou um Documento Síntese. Nessa oportunidade
          ocorreu um debate caloroso e interessado, que envolveu dirigentes
          partidários, militantes, parlamentares e chefes de executivo, além de
          intelectuais, artistas, colaboradores dos dois campos políticos e
          público em geral - pois se desenvolveram meios para a transmissão ao
          vivo do encontro e para a coleta de sugestões de todos os participantes.</p>

          <p>A tarefa de ouvir os brasileiros e brasileiras está, contudo, apenas
          começando. PSB e Rede compreendem que o Documento Síntese deva ser
          instrumento para um diálogo com o País; base por meio da qual
          expectativas, anseios e críticas sejam ouvidos, reconhecidos e
          adequadamente documentados. Esta etapa de construção comum, em um
          diálogo que será permanente, irá até 01 de fevereiro de 2014.</p>

          <p>A partir das sugestões elaboradas pelo conjunto da população será
          produzido, então, um Documento de referência, que deve conter eixos e
          diretrizes que servirão de fundamento para a produção do Programa de
          Governo da coligação.</p>

          <p>Para que esse verdadeiro processo de co-construção alcance as escalas do
          Brasil apresentou-se como alternativa mais adequada à coligação o
          lançamento de um Portal, em que o Documento Síntese vai estar disponível
          para apreciação e sugestões.</p>

          <p>O PSB e a Rede têm no Portal um convite sincero à reflexão
          comum e contam com a contribuição de todos, porque acreditam
          firmemente que a participação gera o comprometimento político,
          que transforma sonhos em realidades. Juntos, com certeza,
          poderemos fazer mais e melhor</p>

          <p>
          </p>
        </div>
        <a href="#"><span class="icon-fechar"></span> fechar</a>
      </div>

    </div>

    <div class="main">
        <h2>Construção em Rede <span class="icon-seta-em-frente"></h2>
          <p>Este é um texto base para o Programa da Coligação, construído a muitas mãos, e aberto agora para a sua participação.</p>
          <div class="info"></div>
          <a href="<?php echo site_url('mudando-o-brasil/desafios/');?>" class="azul">
        <h2>Desafios <span class="icon-seta-em-frente"></h2>
          <p>Aqui você pode dar sua colaboração sobre os 9 desafios encontrados para construirmos um Brasil mais justo, participativo e sustentável.</p>
          <div class="info"></div>
      </a>
    </div>

    <div class="footer">
      <p class="disclaimer"></p>
      <p class="rede">Mudando o Brasil é uma plataforma conjunta da Rede Sustentabilidade e do Partido Socialista Brasileiro, cujo objetivo é construir de forma aberta e transparente o Programa de Governo dessa Coligação.</p>
      <span class="partidos">
        <a href="http://www.psb40.org.br/"></a>
        <a href="http://redesustentabilidade.org.br/"></a>
      </span>

    </div>
  </div>
        <?php endwhile; ?>
  <?php endif; ?>

<script>
jQuery('body').css( "background", "#D8D8D4" );
jQuery('.menu a').removeClass("active");
jQuery('.muda').addClass("active");
</script>
<?php get_footer(); ?>
