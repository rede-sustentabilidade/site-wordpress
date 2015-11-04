<?php
/**
 * The template for displaying the footer.
 */

?>
<footer class="site-footer" id="footer-linkss">
    <div class="col">
        <div class="notes social-network">
          <a target="_blank" href="https://www.facebook.com/BrasilEmRede"><i class="icon-facebook"></i></a>
          <a target="_blank" href="http://www.flickr.com/photos/brasilemrede/"><i class="icon-flickr"></i></a>
          <a target="_blank" href="http://www.youtube.com/BrasilEmRede"><i class="icon-youtube"></i></a>
          <a target="_blank" href="https://twitter.com/maisumnarede"><i class="icon-twitter"></i></a>
        </div>
        <div class="notes"><i class="icon-software-livre"></i><p>Este site é um<br>software livre.</p></div>
        <div class="notes"><i class="icon-creative-commons"></i><p>Todo o conteúdo está disponível <br>
            sob a licença <a href="http://creativecommons.org/licenses/by-sa/3.0/deed.pt_BR" target="_blank">Creative Commons.</a></p></div>
    </div>
    <div class="col">
        <h4>Últimas publicações</h4>
        <ul>
            <?php $posts = get_posts(array('numberposts' => 4)); foreach ($posts as $post) : setup_postdata($post); ?>
            <li><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr(get_the_title()); ?>"><?php the_title(); ?></a></li>
            <?php endforeach; ?>
            <li><a href="<?php echo esc_url(home_url('/')); ?>">ver tudo</a></li>
        </ul>
    </div>
    <div class="col">
        <h4>Sites relacionados</h4>
        <ul>
            <?php $links = get_bookmarks(array('limit' => 5)); foreach ($links as $link) : ?>
            <li><a href="<?php echo $link->link_url; ?>" title="<?php echo esc_attr($link->link_description ?: $link->link_name); ?>" target="<?php echo $link->link_target ?: '_blank'; ?>"><?php echo $link->link_name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</footer>

</div><!-- // close wrap div -->

<?php wp_footer(); ?>

<script>
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-40405673-1']);
  <?php if ( is_user_logged_in() ) { ?>
  <?php global $current_user; get_currentuserinfo(); ?>
  _gaq.push(['_setCustomVar',1,'UserEmail','<?php echo $current_user->user_email; ?>',1]);
  <?php } ?>
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=536115646469279";
fjs.parentNode.insertBefore(js, fjs);
}(document, \'script\', \'facebook-jssdk\'));</script>
</body>
</html>
