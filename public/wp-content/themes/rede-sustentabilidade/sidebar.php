<?php if (is_active_sidebar('rs_sidebar')) : ?>
<?php wp_enqueue_script('swfobject');  ?>
<aside id="meta-area">
    <?php dynamic_sidebar('rs_sidebar'); ?>
</aside>
<?php endif; ?>