<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/30/2015
 * Time: 11:14 PM
 */

function jkof_upload_mb( $post ){
    $jkof_settings              =   get_option( 'jkof_settings' );
    $dropbox_key                =   $jkof_settings['storage']['dropbox_app_key'];
    if(!empty($dropbox_key)){
        ?><script src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="<?php echo $dropbox_key; ?>"></script><?php
    }
    ?>
    <script>
        var jkof_max_upl_size           =   <?php echo $jkof_settings['general']['max_upl_size']; ?>;
    </script>
    <div id="jkof_upload_dropzone" class="dropzone dz-clickable roboto">
        <div class="dz-default dz-message text-center">
            <p class="text-center"><i class="fa fa-cube fa-fw fa-5x"></i></p>
            <small>(Drop files here to upload.)</small>
        </div>
    </div>

    <div id="jkof_dropzone_preview" class="roboto"></div>


    <!-- Single button -->
    <div class="btn-group btn-block">
        <button type="button" class="btn btn-info btn-block jkof_dropdownBtn" data-toggle="dropdown">
            <i class="fa fa-cubes"></i> Import <span class="caret"></span>
        </button>
        <ul class="dropdown-menu btn-block" role="menu">
            <li><a href="#" class="jkof_modalBtn" data-target="#urlImportModal"><i class="fa fa-link"></i> Import from URL</a></li>
            <li><a href="#" class="jkof_modalBtn" data-target="#fileBrowserModal"><i class="fa fa-list"></i> Import from File Browser</a></li>
            <?php if(!empty($dropbox_key)){ ?>
                <li><a href="#" class="jkof_modalBtn" data-target="#dropboxModal"><i class="fa fa-dropbox"></i> Import from Dropbox</a></li>
            <?php } ?>
            <li><a href="#" class="jkof_modalBtn" data-target="#directURLModal"><i class="fa fa-magnet"></i> Direct or Magnet URL</a></li>
        </ul>
    </div>

    <div class="modal jkof_modal fade" id="urlImportModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Import from URL</h4>
                </div>
                <div class="modal-body">
                    <p class="text-center">Onyx Files will download the file provided by the URL.</p>
                    <div id="jkof_url_import_status"></div>
                    <div class="form-group">
                        <input id="jkof_inputUrl" type="text" class="form-control floating-label" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-material-deep-purple" id="importUrlBtn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal jkof_modal fade" id="fileBrowserModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">File Browser</h4>
                </div>
                <div class="modal-body">
                    <div id="jkof_browser_add_status"></div>
                    <div id="jkof_file_browser"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal jkof_modal fade" id="dropboxModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Import from Dropbox</h4>
                </div>
                <div class="modal-body text-center">
                    <div id="jkof_import_dropbox_status"></div>
                    <div id="jkof_dropboxBtn"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal jkof_modal fade" id="directURLModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Add Direct or Magnet URL</h4>
                </div>
                <div class="modal-body text-center">
                    <div id="jkof_directURLStatusPlaceholder"></div>
                    <p class="alert alert-warning">
                        Direct & Magnet URLs will not be downloaded. Instead, the user will be able to visit
                        this link. It is suggested you enable individual downloads if you have mutliple files
                        in this package and you're using direct or magnet URLs.
                    </p>
                    <div class="form-group">
                        <input id="jkof_inputDirectURL" type="text" class="form-control floating-label" placeholder="URL">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-material-deep-purple" id="jkof_submitDirectURL">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}