<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 5/31/2015
 * Time: 5:55 PM
 */
function jkof_admin_footer(){
?>
    <div class="modal fade" id="jkof-file-stat-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title"><?php _e('Downloads past 7 days', 'onyxfiles'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-spin fa-5x"></i>
                    </div>
                    <canvas id="jkof_fileStatCtr" width="550" height="400" class="center-block"></canvas>
                </div>
            </div>
        </div>
    </div>
<?php
}