<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/7/2015
 * Time: 7:26 PM
 */

function jkof_head(){
?>
    <script>
        window.twttr = (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function(f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));

        jkof_ajax_url    =    '<?php echo admin_url('admin-ajax.php');?>';
    </script>
<?php
}