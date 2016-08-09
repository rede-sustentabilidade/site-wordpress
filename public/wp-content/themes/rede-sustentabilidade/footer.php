<?php
/**
 * The template for displaying the footer.
 */

?>
<footer class="site-footer" id="footer-linkss">
    <div class="col">
        <div class="notes social-network">
        <?php the_social_links(); ?>
        </div>

        <div class="notes">
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" viewBox="0 0 500 500" version="1.1" x="0px" y="0px"><g stroke="none" stoke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"><g sketch:type="MSArtboardGroup" fill="#dadad5"><path d="M456.5,250 C456.5,135.953199 364.046801,43.5 250,43.5 C135.953199,43.5 43.5,135.953199 43.5,250 C43.5,364.046801 135.953199,456.5 250,456.5 C364.046801,456.5 456.5,364.046801 456.5,250 Z M56.5,250 C56.5,143.132901 143.132901,56.5 250,56.5 C356.867099,56.5 443.5,143.132901 443.5,250 C443.5,356.867099 356.867099,443.5 250,443.5 C143.132901,443.5 56.5,356.867099 56.5,250 Z" sketch:type="MSShapeGroup"/><path d="M309.5,245.973684 L309.5,343.499998 L190.5,343.499998 L190.5,245.973684 L309.5,245.973684 Z M177.5,239.473684 L177.5,350 C177.5,353.589851 180.410149,356.5 184,356.5 L316,356.5 C319.589851,356.5 322.5,353.589851 322.5,350 L322.5,239.473684 C322.5,235.883833 319.589851,232.973684 316,232.973684 L184,232.973684 C180.410149,232.973684 177.5,235.883833 177.5,239.473684 Z" sketch:type="MSShapeGroup"/><path d="M252.64,143.5 C224.480127,143.5 201.643637,166.263646 201.643637,194.354428 L201.643637,234.752264 C201.643637,238.342115 204.553786,241.252264 208.143637,241.252264 C211.733488,241.252264 214.643637,238.342115 214.643637,234.752264 L214.643637,194.354428 C214.643637,173.452662 231.650548,156.5 252.64,156.5 C273.629452,156.5 290.636363,173.452662 290.636363,194.354428 C290.636363,197.944279 293.546512,200.854428 297.136363,200.854428 C300.726214,200.854428 303.636363,197.944279 303.636363,194.354428 C303.636363,166.263646 280.799873,143.5 252.64,143.5 Z" sketch:type="MSShapeGroup"/></g></g></svg>
    <p>Este site é um software livre.</p></div>
        <div class="notes">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve"><path fill="#dadad5" d="M38.156,64.088c3.562,0,6.961-1.333,9.573-3.751c0.81-0.75,0.858-2.016,0.108-2.826  c-0.751-0.811-2.016-0.859-2.827-0.108c-1.869,1.732-4.304,2.686-6.854,2.686c-5.563,0-10.088-4.526-10.088-10.088  s4.525-10.088,10.088-10.088c2.548,0,4.98,0.952,6.849,2.681c0.811,0.75,2.076,0.701,2.827-0.11c0.75-0.811,0.701-2.076-0.11-2.826  c-2.61-2.415-6.007-3.745-9.565-3.745c-7.769,0-14.088,6.32-14.088,14.088S30.387,64.088,38.156,64.088z"/><path fill="#dadad5" d="M65.156,64.088c3.562,0,6.961-1.333,9.573-3.751c0.81-0.75,0.858-2.016,0.108-2.826  c-0.751-0.811-2.016-0.859-2.827-0.108c-1.869,1.732-4.304,2.686-6.854,2.686c-5.563,0-10.088-4.526-10.088-10.088  s4.525-10.088,10.088-10.088c2.548,0,4.98,0.952,6.849,2.681c0.811,0.75,2.076,0.701,2.827-0.11c0.75-0.811,0.701-2.076-0.11-2.826  c-2.61-2.415-6.007-3.745-9.565-3.745c-7.769,0-14.088,6.32-14.088,14.088S57.387,64.088,65.156,64.088z"/><path fill="#dadad5" d="M50,92c22.766,0,42-19.233,42-42S72.766,8,50,8S8,27.233,8,50S27.234,92,50,92z M50,12  c20.598,0,38,17.402,38,38S70.598,88,50,88S12,70.598,12,50S29.402,12,50,12z"/></svg>
         <p>Todo o conteúdo está disponível <br>
            sob a licença <a href="https://creativecommons.org/licenses/by-sa/3.0/deed.pt_BR" target="_blank">Creative Commons.</a></p></div>
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

<div id="fb-root"></div>
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
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=536115646469279";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>
