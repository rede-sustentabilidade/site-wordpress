<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/14/2015
 * Time: 2:01 PM
 */
function jkof_tinymce_modal(){
?>
    <!-- Modal Structure -->
    <div id="jkof_tinymce_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"><?php _e('Insert Onyx File', 'onyxfiles'); ?></h4>
                </div>
                <div class="modal-body">
                    <div id="jkof_tmce_file_list"></div>
                    <button type="button" class="btn btn-block btn-primary" id="jkof_loadMoreFiles">
                        <i class="fa fa-plus"></i> <?php _e('Load More Files', 'onyxfiles'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
}