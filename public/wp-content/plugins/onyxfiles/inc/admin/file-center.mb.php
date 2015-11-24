<?php
/**
 * Created by PhpStorm.
 * User: jaskokoyn
 * Date: 4/30/2015
 * Time: 4:17 PM
 */

function jkof_file_center_mb( $post ){
    $file_data                          =   get_post_meta( $post->ID, 'jkof_dl_settings', true );
    $file_list                          =   isset($file_data['files']) ? $file_data['files'] : '[]';

    if(empty($file_data)){
        $file_data                      =   jkof_get_dl_defaults();
    }else{
        $file_data['access_level']      =   json_decode($file_data['access_level']);
        $file_data['lock_opts']         =   json_decode($file_data['lock_opts']);
    }

    // Button Settings
    $dl_btn                             =   new JKOF_Download_Btn($file_data);
    $dl_btn->build(true);
    ?>

    <ul class="nav nav-tabs navbar-material-red nav-justified" style="margin-bottom: 20px;">
        <li class="active"><a class="active" href="#jkof_filesTab" data-toggle="tab"><i class="fa fa-archive"></i> <?php _e('Files', 'onyxfiles'); ?></a></li>
        <li><a href="#jkof_basicTab" data-toggle="tab"><i class="fa fa-dashboard"></i> <?php _e('Basic', 'onyxfiles'); ?></a></li>
        <li><a href="#jkof_usersTab" data-toggle="tab"><i class="fa fa-users"></i> <?php _e('Users', 'onyxfiles'); ?></a></li>
        <li><a href="#jkof_locksTab" data-toggle="tab"><i class="fa fa-lock"></i> <?php _e('Locks', 'onyxfiles'); ?></a></li>
        <li><a href="#jkof_buttonTab" data-toggle="tab"><i class="fa fa-paint-brush"></i> <?php _e('Button', 'onyxfiles'); ?></a></li>
    </ul>
    <div id="jkof_fileCenterTabs" class="tab-content">
        <div id="jkof_filesTab" class="tab-pane fade active in">
            <textarea id="jkof_inputFilesArr" name="jkof_inputFilesArr" style="display: none;"><?php echo $file_list; ?></textarea>
            <div class="row">
            <?php
            $file_list              =   json_decode($file_list);
            foreach( $file_list as $file_key => $file_value ){
                $icon               =   $file_value->isDirect == 1 ? "fa-file-text-o" : "fa-chain";
                $file_name          =   $file_value->isDirect == 1 ? $file_value->name: $file_value->direct_url;
                ?>
                    <div class="col-sm-4 text-center">
                        <div class="jkof_file_container">
                            <i class="fa <?php echo $icon; ?> fa-5x"></i><br>
                            <strong><?php echo $file_name ?></strong><br>
                            <small>
                                <?php echo $file_value->type; ?><br>
                                <?php echo $file_value->readable_size ?>
                            </small>
                            <button type="button" class="btn btn-xs btn-material-red jkof_removeFileBtn"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
            <?php
            }
            ?>
            </div>
        </div>
        <div id="jkof_basicTab" class="tab-pane fade">
            <div class="form-group">
                <input class="form-control floating-label" id="inputDLLimit" type="number" name="jkof_dl_limit"
                       placeholder="<?php _e('Download Limit', 'onyxfiles'); ?>" value="<?php echo $file_data['dl_limit']; ?>">
            </div>
            <div class="form-group">
                <input class="form-control floating-label" id="inputDLLimitPerUser" type="number" name="jkof_dl_limit_per_user"
                       placeholder="<?php _e('Download Limit Per User', 'onyxfiles'); ?>" value="<?php echo $file_data['dl_user_limit']; ?>">
            </div>
            <div class="form-group">
                <input class="form-control floating-label" id="inputDLDailyLimit" type="number" name="inputDLDailyLimit"
                       placeholder="<?php _e('Download Limit Per Day', 'onyxfiles'); ?>" value="<?php echo $file_data['dl_daily_limit']; ?>">
            </div>
            <div class="form-group">
                <input class="form-control floating-label" id="inputViewCount" type="number" name="jkof_view_count"
                       placeholder="<?php _e('View Count', 'onyxfiles'); ?>" value="<?php echo $file_data['view_count']; ?>">
            </div>
            <div class="form-group">
                <input class="form-control floating-label" id="inputDLCount" type="number" name="jkof_download_count"
                       placeholder="<?php _e('Download Count', 'onyxfiles'); ?>" value="<?php echo $file_data['dl_count']; ?>">
            </div>
            <div class="form-group">
                <label for="selectIndivDownloads"><?php _e('Individual File Downloads', 'onyxfiles'); ?></label>
                <select class="form-control" id="selectIndivDownloads" name="jkof_idl">
                    <option value="1"><?php _e('Disable', 'onyxfiles'); ?></option>
                    <option value="2" <?php echo ($file_data['indiv_dls'] == 2) ? "SELECTED": ""; ?>><?php _e('Enable', 'onyxfiles'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="selectAudioPlayer"><?php _e('Audio Player', 'onyxfiles'); ?></label>
                <select class="form-control" id="selectAudioPlayer" name="jkof_audio_player">
                    <option value="1"><?php _e('Disable', 'onyxfiles'); ?></option>
                    <option value="2" <?php echo ($file_data['audio_player'] == 2) ? "SELECTED": ""; ?>><?php _e('Enable', 'onyxfiles'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputDLAvailable"><?php _e('Download Available On', 'onyxfiles'); ?></label>
                <input type="text" class="form-control datepicker" id="inputDLAvailable"
                       value="<?php echo @date("m/d/Y", $file_data['available']); ?>" name="jkof_dl_available">
            </div>
            <div class="col s12">
                <label for="inputDLExpire"><?php _e('Download Expires On', 'onyxfiles'); ?></label>
                <input type="text" class="form-control datepicker" id="inputDLExpire"
                       value="<?php echo @date("m/d/Y", $file_data['expires']); ?>" name="jkof_dl_expire">
            </div>
        </div>
        <div id="jkof_usersTab" class="tab-pane fade">
            <div class="form-group">
                <label for="selectAccessLevel"><?php _e('Role Access Level', 'onyxfiles'); ?></label>
                <select class="form-control" id="selectAccessLevel" name="jkof_access_level[]" multiple>
                    <option <?php echo in_array("Guests", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Guests', 'onyxfiles'); ?></option>
                    <option <?php echo in_array("Subscriber", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Subscriber', 'onyxfiles'); ?></option>
                    <option <?php echo in_array("Contributor", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Contributor', 'onyxfiles'); ?></option>
                    <option <?php echo in_array("Author", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Author', 'onyxfiles'); ?></option>
                    <option <?php echo in_array("Editor", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Editor', 'onyxfiles'); ?></option>
                    <option <?php echo in_array("Administrator", $file_data['access_level']) ? "SELECTED" : null; ?>><?php _e('Administrator', 'onyxfiles'); ?></option>
                </select>
            </div>
            <div class="form-group">
                <label for="inputUsersAllowed"><?php _e('Share with the following usernames (comma separated)', 'onyxfiles'); ?></label>
                <textarea id="inputUsersAllowed" class="form-control"
                          name="inputUsersAllowed"><?php echo $file_data['users_allowed']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="inputUsersDisallowed"><?php _e('Users disallowed to download (comma separated)', 'onyxfiles'); ?></label>
                <textarea id="inputUsersDisallowed" class="form-control"
                          name="inputUsersDisallowed"><?php echo $file_data['users_disallowed']; ?></textarea>
            </div>
        </div>
        <div id="jkof_locksTab" class="tab-pane fade">
            <div class="row">
                <div class="col-md-4">
                    <div class="checkbox">
                        <label for="c1">
                            <input type="checkbox" class="updateLockCB" id="c1" name="selectLockOpts[]"
                                   value="1" <?php echo (in_array(1,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-lock"></i> Password
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="c2">
                            <input type="checkbox" class="updateLockCB" id="c2" name="selectLockOpts[]"
                                   value="2" <?php echo (in_array(2,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-linkedin"></i> Linkedin Share</label>
                    </div>
                    <div class="checkbox">
                        <label for="c3">
                            <input type="checkbox" class="updateLockCB" id="c3" name="selectLockOpts[]"
                                               value="3" <?php echo (in_array(3,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-facebook"></i> Facebook Share</label>
                    </div>
                    <div class="checkbox">
                        <label for="c4">
                            <input type="checkbox" class="updateLockCB" id="c4" name="selectLockOpts[]"
                                   value="4" <?php echo (in_array(4,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-facebook"></i> Facebook Like</label>
                    </div>
                    <div class="checkbox">
                        <label for="c5">
                            <input type="checkbox" class="updateLockCB" id="c5" name="selectLockOpts[]"
                                   value="5" <?php echo (in_array(5,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-twitter"></i> Twitter Follow
                        </label>
                    </div>
                    <div class="checkbox">
                        <label for="c6">
                            <input type="checkbox" class="updateLockCB" id="c6" name="selectLockOpts[]"
                                   value="6" <?php echo (in_array(6,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-twitter"></i> Tweet</label>
                    </div>
                    <div class="checkbox">
                        <label for="c7">
                            <input type="checkbox" class="updateLockCB" id="c7" name="selectLockOpts[]"
                                   value="7" <?php echo (in_array(7,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-google-plus"></i> Google +1</label>
                    </div>
                    <div class="checkbox">
                        <label for="c8">
                            <input type="checkbox" class="updateLockCB" id="c8" name="selectLockOpts[]"
                                   value="8" <?php echo (in_array(8,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-envelope"></i> E-mail</label>
                    </div>
                    <div class="checkbox">
                        <label for="c9">
                            <input type="checkbox" class="updateLockCB" id="c9" name="selectLockOpts[]"
                                   value="9" <?php echo (in_array(9,$file_data['lock_opts'])) ? "checked" : ""; ?>>
                            <i class="fa fa-paypal"></i> Paypal
                        </label>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(1,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="1">
                        <label for="inputLockPW">Password</label>
                        <input type="text" id="inputLockPW" name="inputLockPW" class="form-control"
                               value="<?php echo $file_data['lock_password']; ?>">
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(2,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="2">
                        <div class="input-field col s12">
                            <label for="inputLockLinkedinShareMessage">Linkedin Share Message</label>
                            <textarea id="inputLockLinkedinShareMessage" class="form-control"
                                      name="inputLockLinkedinShareMessage"><?php echo $file_data['lock_li_m']; ?></textarea>
                        </div>
                        <div class="input-field col s12">
                            <label for="inputLockLinkedinShareURL">Linkedin Share URL</label>
                            <input type="text" id="inputLockLinkedinShareURL" name="inputLockLinkedinShareURL"
                                   value="<?php echo $file_data['lock_li_url']; ?>" class="form-control">
                        </div>
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(3,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="3">
                        <label for="inputLockFBShareURL">Facebook Share URL</label>
                        <input type="text" id="inputLockFBShareURL" name="inputLockFBShareURL" class="form-control"
                               value="<?php echo $file_data['lock_fb_share_url']; ?>">
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(4,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="4">
                        <label for="inputLockFBLikeURL">Facebook Like URL</label>
                        <input type="text" id="inputLockFBLikeURL" name="inputLockFBLikeURL" class="form-control"
                               value="<?php echo $file_data['lock_fb_like_url']; ?>">
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(5,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="5">
                        <label for="inputLockTwitterUsername">Twitter Username</label>
                        <input type="text" id="inputLockTwitterUsername" name="inputLockTwitterUsername" class="form-control"
                               value="<?php echo $file_data['lock_twitter_u']; ?>">
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(6,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="6">
                        <label for="inputLockTweetMessage">Tweet Message</label>
                        <textarea class="form-control" id="inputLockTweetMessage"
                                  name="inputLockTweetMessage" class="form-control"><?php echo $file_data['lock_tweet_m']; ?></textarea>
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(7,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="7">
                        <label for="inputLockGPlusURL">Google+ URL</label>
                        <input type="text" id="inputLockGPlusURL" name="inputLockGPlusURL" class="form-control"
                               value="<?php echo $file_data['lock_gplus_url']; ?>">
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(8,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="8">
                        <label for="selectLockEmailDLType">E-mail Download Type</label>
                        <select id="selectLockEmailDLType" name="selectLockEmailDLType" class="form-control">
                            <option value="1">E-mail Link</option>
                            <option value="2" <?php echo ($file_data['lock_email_type']==2) ? "selected" :""; ?>>Download Instantly</option>
                        </select>
                    </div>

                    <div class="form-group lockerGroupCtr" style="<?php echo (in_array(9,$file_data['lock_opts'])) ? "display:block;" : "display:none;"; ?>" data-locker-id="9">
                        <label for="inputPPAmount">Paypal Amount</label>
                        <input type="text" id="inputPPAmount" name="inputPPAmount"
                               value="<?php echo $file_data['lock_pp_amount']; ?>" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div id="jkof_buttonTab" class="tab-pane fade">
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="text-center"><strong><?php _e('This is what your button will look like', 'onyxfiles'); ?></strong></p>
                    <?php echo $dl_btn->display_btn(); ?>
                    <hr>
                </div>
            </div>
            <div class="form-group">
                <label for="inputBtnLabel"><?php _e('Button Label', 'onyxfiles'); ?></label>
                <input type="text" class="form-control updateBtn" id="inputBtnLabel"
                       value="<?php echo $file_data['label']; ?>" name="jkof_btn_label">
            </div>
            <div class="form-group">
                <label for="selectBtnColor"><?php _e('Color', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnColor" name="jkof_btn_color">
                    <?php
                    foreach(JKOF_Download_Btn::$colors as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo ($key == $file_data['color']) ? " SELECTED" : '';
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="selectBtnSize"><?php _e('Size', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnSize" name="jkof_btn_size">
                    <?php
                    foreach(JKOF_Download_Btn::$sizes as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo ($key == $file_data['size']) ? " SELECTED" : '';
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="selectBtnEffects"><?php _e('Effects', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnEffects" name="jkof_btn_effect">
                    <option value=""><?php _e('None', 'onyxfiles'); ?></option>
                    <?php
                    foreach(JKOF_Download_Btn::$effects as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo $key == $file_data['effect'] ? " SELECTED" : "";
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="selectBtnEnhancements"><?php _e('Enhancements', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnEnhancements" name="jkof_btn_enhancement">
                    <option value=""><?php _e('None', 'onyxfiles'); ?></option>
                    <?php
                    foreach(JKOF_Download_Btn::$enhancements as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo $key == $file_data['enhancement'] ? " SELECTED" : "";
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="selectBtnShape"><?php _e('Shape', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnShape" name="jkof_btn_shape">
                    <option value=""><?php _e('Normal', 'onyxfiles'); ?></option>
                    <?php
                    foreach(JKOF_Download_Btn::$shapes as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo $key == $file_data['shape'] ? " SELECTED" : "";
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="selectBtnStyles"><?php _e('Button Styles', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn" id="selectBtnStyles" name="jkof_btn_style">
                    <?php
                    foreach(JKOF_Download_Btn::$styles as $key => $value){
                        echo '<option value="' . $key . '"';
                        echo $key == $file_data['style'] ? " SELECTED" : "";
                        echo '>' . $value . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group" id="jkof_display_icons" name="jkof_btn_icon">
                <label for="selectBtnIcons"><?php _e('Button Icons', 'onyxfiles'); ?></label>
                <select class="form-control updateBtn btn-block" id="selectBtnIcons" name="selectBtnIcons">
                    <?php
                    foreach(smk_font_awesome() as $icon_key => $icon_val){
                        echo '<option value="' . $icon_key . '">' . $icon_val . '</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <?php
}