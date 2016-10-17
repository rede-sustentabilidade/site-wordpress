<?php get_header(); ?>

   		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="pinbin-copy">
                <h1>Acesso restrito</h1>
                <p>Para acessar essa página você deve ser filiado.</p>
                <p>Preencha sua pré-filiação e habilite esta seção. <a href="<?php echo site_url("/filiacao-redesim/"); ?>">entenda a filiação.</a></p>
            </div>

       </div>

<?php get_footer(); ?>