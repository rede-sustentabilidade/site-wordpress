<?php
/**
 * Error page displayed when no results are found
 */

?>

<?php get_header(); ?>
   		<div class="type-page">
                                
       			<div class="pinbin-copy">
                
					<h1><?php _e( '404: Página não encontrada', 'pinbin') ?></h1>
			
						<p><?php _e( 'Oops! Parece que você clicou em algo que não existe ou foi movido.', 'pinbin') ?></p>
					
					<h2><?php _e( 'Precisa de ajuda?', 'pinbin') ?></h2>

					<p><?php _e( 'Você pode tentar o seguinte:', 'pinbin') ?></p>
					<ul> 
						<li><?php _e( 'Verifique a grafia', 'pinbin') ?></li>
						<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>/"><?php _e( 'Volte a página inicial', 'pinbin') ?></a></li> 
						<li><?php _e( 'Clique no ', 'pinbin') ?> <a href="javascript:history.back()"><?php _e( 'botão para voltar atrás!', 'pinbin') ?></a></li>
					</ul>
         		</div>                 
       </div>
<?php get_footer(); ?>