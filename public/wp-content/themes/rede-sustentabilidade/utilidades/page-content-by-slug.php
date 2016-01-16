<?php

define('ABSPATH', realpath(dirname(__FILE__) . '/../../../../') . '/');

require(ABSPATH . 'wp-config.php');

$pagename=$_GET['pagename'];

$page = get_posts(
    array(
        'name'      => $pagename,
        'post_type' => 'page'
    )
);
?>

<div class="white-popup-block">
	<h1><?php echo $page[0]->post_title; ?></h1>
	<div class="text-content">
		<?php echo nl2br($page[0]->post_content); ?>
	</div>
</div>
