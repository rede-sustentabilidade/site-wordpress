<?php

function jkof_display_settings_page(){
    $jkof_settings                         =    get_option( 'jkof_settings' );
    $jkof_settings['blocked']['domains']   =   implode( ",", $jkof_settings['blocked']['domains'] );
    $jkof_settings['blocked']['emails']    =   implode( ",", $jkof_settings['blocked']['emails'] );
    $jkof_settings['message']['denied_dl'] =   wp_kses_stripslashes( $jkof_settings['message']['denied_dl'] );
    ?>
<script>
    var onyxFilesSettings   =   <?php echo json_encode($jkof_settings); ?>;
    var onyxFilesPluginURL  =   '<?php echo plugins_url( '/app/admin/views/', OF_PLUGIN_URL ); ?>';
</script>
<div class="wrap">
    <div class="skin-yellow-light sidebar-mini" ng-app="onyxFilesApp" id="jkof_settings_page">
        <!-- Site wrapper -->
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <span class="logo-lg"><b><i class="fa fa-cloud-download"></i> Onyx Files</b></span>
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <ul class="sidebar-menu">
                        <li class="header"><?php _e('CONFIGURATION', 'onyxfiles'); ?></li>
                        <li><a ui-sref="general"><i class="fa fa-list"></i> <span><?php _e('General', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="social"><i class="fa fa-twitter"></i> <span><?php _e('Social', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="paypal"><i class="fa fa-paypal"></i> <span><?php _e('Paypal', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="blocked"><i class="fa fa-ban"></i> <span><?php _e('Blocked', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="messages"><i class="fa fa-envelope"></i> <span><?php _e('Messages', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="storage"><i class="fa fa-cubes"></i> <span><?php _e('Storage', 'onyxfiles'); ?></span></a></li>
                        <li><a ui-sref="emailFields"><i class="fa fa-list"></i> <span><?php _e('E-mail Fields', 'onyxfiles'); ?></span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- =============================================== -->
            <div class="content-wrapper">
                <div ui-view></div>
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.0
                </div>
                <strong><a href="http://codecanyon.net/item/onyx-files-download-manager-for-wordpress/9409350" target="_blank">Onyx Files</a></strong>
            </footer>
        </div><!-- ./wrapper -->
    </div>
</div>
<?php
}