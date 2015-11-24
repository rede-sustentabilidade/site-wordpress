<?php
/*******************************************
 * Plugin Name: Onyx Files - Download Manager
 * Plugin URI: http://jaskokoyn.com
 * Description: Onyx Files is a powerful & flexible download manager for all your files.
 * Author: Jasko Koyn
 * Version: 2.0
 * Author URI: http://jaskokoyn.com
 * Text Domain: onyxfiles
 *******************************************/

// Setup
$jkof_upload_dir    =   wp_upload_dir();
define( 'OF_DIR', $jkof_upload_dir['basedir'] . '/onyx-files/' );
define( 'OF_DIR_URL', $jkof_upload_dir ['baseurl'] . '/onyx-files/' );
define( 'OF_PLUGIN_URL', __FILE__ );

// Include Files
include( 'inc/helpers/func.inc.php' );
include( 'inc/font-awesome.php' );
include( 'inc/Download_Button.class.php' );
include( 'inc/init.php' );
include( 'inc/textdomain.php' );
include( 'inc/admin/init.php' );
include( 'inc/admin/admin-head.php' );
include( 'inc/pages/settings-page.php' );
include( 'inc/pages/email-list-page.php' );
include( 'inc/pages/stats-page.php' );
include( 'inc/activate-plugin.php' );
include( 'inc/register-post-type.php' );
include( 'inc/front/enqueue.php');
include( 'inc/front/shortcodes/file-center.php' );
include( 'inc/front/head.php' );
include( 'inc/front/shortcodes/onyxfile.php');
include( 'inc/menus.php' );
include( 'inc/front/create-modal.php');
include( 'inc/front/download-page.php');
include( 'inc/register-widgets.php' );
include( 'inc/widgets/top-downloads.widget.php');
include( 'inc/widgets/recently-uploaded.widget.php');
include( 'inc/filetree.php' );
include( 'process/files/upload.php' );
include( 'process/files/create-upl-dir.php' );
include( 'process/files/add-url-file.php' );
include( 'process/files/add-browser-file.php' );
include( 'process/files/get-file-list.php' );
include( 'process/files/file-center.php' );
include( 'process/files/download.php');
include( 'process/files/verify-download.php');
include( 'process/files/stats.php');
include( 'process/settings/update-general.php' );
include( 'process/settings/update-social.php' );
include( 'process/settings/update-paypal.php' );
include( 'process/settings/update-blocked.php' );
include( 'process/settings/update-message.php' );
include( 'process/settings/update-storage.php' );
include( 'process/settings/update-email-fields.php' );
include( 'process/validate/password.php' );
include( 'process/validate/download.php' );
include( 'process/validate/email.php' );
include( 'process/email/actions.php' );
include( 'process/post/save.php' );
include( 'process/paypal/process-payment.php');
require_once( 'inc/libs/aws/S3.php' );

// Action & Filter Hooks
register_activation_hook( __FILE__, 'jkof_activate_plugin' );
add_action( 'init', 'jkof_init' );
add_action( 'init', 'jkof_download_file' );
add_action( 'init', 'jkof_create_post_type' );
add_action( 'init', 'jkof_process_pp_payment' );
add_action( 'plugins_loaded', 'jkof_load_textdomain' );
add_action( 'admin_init', 'jkof_admin_init' );
add_action( 'admin_menu', 'jkof_add_admin_menu' );
add_action( 'admin_head', 'jkof_admin_head' );
add_action( 'wp_ajax_jkof_upload', 'jkof_upload' );
add_action( 'wp_ajax_jkof_import_url_file', 'jkof_import_url_file' );
add_action( 'wp_ajax_jkof_load_file_list', 'jkof_load_file_list' );
add_action( 'wp_ajax_jkof_add_browser_file', 'jkof_add_browser_file');
add_action( 'wp_ajax_jkof_get_file_center_files', 'jkof_get_file_center_files');
add_action( 'wp_ajax_nopriv_jkof_get_file_center_files', 'jkof_get_file_center_files');
add_action( 'wp_ajax_jkof_check_password', 'jkof_check_password' );
add_action( 'wp_ajax_jkof_get_downloads', 'jkof_get_downloads' );
add_action( 'wp_ajax_jkof_add_verified_download', 'jkof_add_verified_download' );
add_action( 'wp_ajax_jkof_check_email', 'jkof_check_email' );
add_action( 'wp_ajax_nopriv_jkof_check_password', 'jkof_check_password' );
add_action( 'wp_ajax_nopriv_jkof_get_download', 'jkof_get_download' );
add_action( 'wp_ajax_nopriv_jkof_add_verified_download', 'jkof_add_verified_download' );
add_action( 'wp_ajax_nopriv_jkof_check_email', 'jkof_check_email' );
add_action( 'wp_ajax_nopriv_jkof_get_downloads', 'jkof_get_downloads' );
add_action( 'wp_enqueue_scripts', 'jkof_front_enqueue' );
add_action( 'wp_head', 'jkof_head' );
add_action( 'wp_footer', 'jkof_create_dl_modal');
add_filter( 'the_content', 'jkof_create_dl_page');
add_action( 'widgets_init', 'jkof_register_widgets' );

//Shortcodes
add_shortcode( 'onyxfile', 'jkof_download_shortcode');
add_shortcode( 'onyxfile_file_center', 'jkof_front_file_center' );