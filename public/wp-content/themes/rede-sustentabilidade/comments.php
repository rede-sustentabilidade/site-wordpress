<?php
/**
 * The template for comments section
 */

?>

<?php

	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		This post is password protected. Enter the password to view comments.
	<?php
		return;
	}
?>

<?php if ( comments_open() ) : ?>

</div> <!-- close pin-copy -->
<?php /*
<div class="agir-box" id="agindo-box">
	<h3 class="agir-title">Quer agir agora e ajudar a Rede?</h3>

	<div class="espalhe">
		<h4>Espalhe esta notícia</h4>

		<div id="twitter" data-url="<?php echo get_permalink(); ?>" data-text="<?php the_title(); ?>"></div>
		<div id="facebook" data-url="<?php echo get_permalink(); ?>" data-text="<?php the_title(); ?>"></div>
		<div id="googleplus" data-url="<?php echo get_permalink(); ?>" data-text="<?php the_title(); ?>"></div>

		<div class="box-horizontal">
			<label for="shortlink">Link:</label>
			<input readonly="readonly" id="shortlink" name="shortlink" type="text" value="<?php echo esc_attr(get_permalink()); ?>" />
			<a href="#" class="button">Copiar</a>
		</div>
	</div>

</div>
*/ ?>

<div style="width:750px;margin:0 auto;">
  <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-num-posts="15" data-width="750" data-colorscheme="light"></div>
</div>

<?php /* ?>

	<div id="comment-form">

		<h4>Qual sua opinião?</h4>

		<div class="cancel-comment-reply">
			<?php cancel_comment_reply_link(); ?>
		</div>

		<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
			<p>Você deve fazer conectar-se através da <a href="<?php echo wp_login_url( get_permalink() ); ?>">conexão rede</a> para postar um comentário.</p>
		<?php else : ?>

		<?php comment_form(array('title_reply'=>'')); ?>
	 </div>

	<?php endif; // If registration required and not logged in ?>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
	
  <div class="comments-area"> 
	<h4><?php comments_number('Nenhum comentário', 'Um comentário', '% Comentários' );?></h4>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>
   
	<ol class="commentlist">
		<?php wp_list_comments(); ?>
	</ol>

	<div class="navigation">
		<div class="next-posts"><?php previous_comments_link() ?></div>
		<div class="prev-posts"><?php next_comments_link() ?></div>
	</div>

</div>
	
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
	<?php endif; ?>
	
<?php */ ?>
<?php endif; ?>

