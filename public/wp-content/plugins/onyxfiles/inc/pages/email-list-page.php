<?php

function jkof_display_email_list_page(){
    global $wpdb;

    $page_num    =    (isset($_GET['page_num'])) ? intval($_GET['page_num']) : 1;
    $row_offset  =    ($page_num * 25) - 25;
    $row_offset  =    ($page_num < 0) ? 0 : $row_offset;
    $prev_page   =    ($page_num <= 1) ? 1 : $page_num - 1;
    $of_emails = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "of_emails ORDER BY `id` DESC LIMIT " . $row_offset . ", 25");
?>
<div class="wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading"><i class="fa fa-envelope"></i> Onyx File <?php _e('Email List', 'onyxfiles') ;?></div>
                <div class="panel-body">
                    <div id="jkof_email_action_status_placeholder"></div>
                    <button type="button" class="btn btn-danger" id="jkof_deleteSelectedBtn"><?php _e('Delete Selected', 'onyxfiles') ;?></button>
                    <button type="button" class="btn btn-info" id="jkof_exportSelectedBtn"><?php _e('Export Selected', 'onyxfiles') ;?></button>
                    <button type="button" class="btn btn-info" id="jkof_exportAllBtn"><?php _e('Export All', 'onyxfiles') ;?></button>
                    <button type="button" class="btn btn-info" id="jkof_exportUniqueBtn"><?php _e('Export Unique', 'onyxfiles') ;?></button>
                    <table class="table" id="emailListTbl">
                        <thead>
                            <tr>
                                <th width="3%"><input type="checkbox" id="checkAllCB"></th>
                                <th width="5%" class="text-center">ID</th>
                                <th><?php _e('Fields', 'onyxfiles') ;?></th>
                                <th><?php _e('File', 'onyxfiles') ;?></th>
                                <th><?php _e('Date Inserted', 'onyxfiles') ;?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ( $of_emails as $of_email ) {
                            $fields             =   json_decode($of_email->form_fields);
                            ?>
                            <tr>
                                <td><input type="checkbox" class="jkof_email" value="<?php echo $of_email->id; ?>"></td>
                                <td class="text-center"><?php echo $of_email->id; ?></td>
                                <td>
                                    <?php
                                    foreach($fields as $fv){
                                        foreach($fv as $field_key => $field_value){
                                            echo '<strong>' . $field_key . '</strong>:' . $field_value . '<br>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td>
                                    <a href="post.php?post=<?php echo $of_email->fid; ?>&action=edit">
                                        <?php echo get_the_title($of_email->fid); ?>
                                    </a>
                                </td>
                                <td><?php echo @date("M d, Y h:ia", $of_email->time_sent); ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="col-md-offset-6 col-md-6">
                        <nav>
                            <ul class="pagination pull-right">
                                <li><a href="edit.php?post_type=of_files&page=of_email_list&page_num=<?php echo $prev_page; ?>">&laquo;</a></li>
                                <li><a href="edit.php?post_type=of_files&page=of_email_list&page_num=<?php echo $page_num + 1; ?>">&raquo;</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}