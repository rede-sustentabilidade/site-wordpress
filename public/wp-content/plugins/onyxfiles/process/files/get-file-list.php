<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/14/2015
 * Time: 2:27 PM
 */
function jkof_load_file_list(){
    global $wpdb;
    $offset                 =   intval($_POST['offset']);
    $uid                    =   get_current_user_id();

    $filesRow               =   $wpdb->get_results("
        SELECT `ID`,`post_title` FROM $wpdb->posts
        WHERE post_author = '" . $uid . "' AND post_type='of_files' AND post_status='publish'
        LIMIT " . $offset . ", 10
    ");

    foreach ( $filesRow as $file ) {
    ?>
    <div class="jkof_file_list_item" data-fid="<?php echo $file->ID; ?>">
        <?php echo $file->post_title; ?>
    </div>
    <?php
    }

    die();
}