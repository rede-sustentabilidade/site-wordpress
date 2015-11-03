<?php
require('../../../../wp-config.php');

// Create post object
$my_post = array(
  'post_title'    => wp_strip_all_tags( $_POST['desafio_title'] ),
  'post_content'  => $_POST['desafio_content'],
  //'participacao_category' => $_POST['desafio_category'],
  'post_status'   => 'pending',
  'post_author'   => $current_user->ID,
  'comment_status' => 'open',
  'post_type'     => 'participacao'
);

// Insert the post into the database
$novo_post = wp_insert_post( $my_post );

wp_set_post_terms( $novo_post, $_POST['desafio_category'], 'participacao_category' );
?>
<?php
if ($novo_post) {
	echo "<p>Seu desafio foi gravada com sucesso e aguarda moderação. Em breve será liberado!</p>";
}else {
	echo "<p>Encontramos um problema ao tentar gravar seu desafio.</p>";
	echo "<p>O título fornecido foi: ".wp_strip_all_tags( $_POST['participe_title'] )."</p>";
	echo "<p>O conteúdo: ".$_POST['participe_content']."</p>";
	echo "<p>Tente novamente mais tarde.</p>";
}
?>
<style>
#desafios #desafio-form p {color: #533B8C;}
</style>