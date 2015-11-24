<?php

function jkof_create_dl_modal(){
    $jkof_settings    =    get_option( 'jkof_settings' );
    if(!empty($jkof_settings['social']['li_api_key'])) {
?>
<script type="text/javascript" src="http://platform.linkedin.com/in.js">
    api_key: <?php echo $jkof_settings['social']['li_api_key']; ?>

    authorize: true
    onLoad: onLinkedInLoad
</script>
<?php
    }
    if(!empty($jkof_settings['social']['fb_app_id'])) {
?>    
<script>
    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    jkof_fb_app_id   =    '<?php echo $jkof_settings['social']['fb_app_id']; ?>';
</script>
<?php
    }
?>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<!-- Modal -->
<div class="modal fade" id="jkof-dl-modal" data-backdrop="static" data-fid=""
     data-li-message="" data-li-url="" data-fb-share-url=""
     data-allow-idl="1" >
    <div class="modal-dialog" style="margin-top:50px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 15px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><?php _e('Download File', 'onyxfiles'); ?></h4>
            </div>
            <div class="modal-body">
                <div class="jkof-main-ctr">
                    <p class="text-center">
                        <?php _e('If you would like to download this file, then you will have to unlock it by
                        clicking one of the options below.', 'onyxfiles'); ?>
                    </p>
                    <button type="button" data-lock-target=".jkof-password-ctr" data-lock-type="1"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-nephritis rcw-medium rcw-button-5 btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-lock"></span> <?php _e('Unlock with password', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-linkedin-ctr" data-lock-type="2"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-linkedin btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-linkedin"></span> <?php _e('Share on LinkedIn', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-fb-share-ctr" data-lock-type="3"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-facebook rcw-medium rcw-button-5 btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-facebook"></span> <?php _e('Share on Facebook', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-fb-like-ctr" data-lock-type="4"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-facebook rcw-medium rcw-button-5 btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-facebook"></span> <?php _e('Like us', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-t-follow-ctr" data-lock-type="5"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-twitter btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-twitter"></span> <?php _e('Follow us on Twitter', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-t-tweet-ctr" data-lock-type="6"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-twitter btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-twitter"></span> <?php _e('Tweet us on Twitter', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-gp-plus-ctr" data-lock-type="7"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-googleplus btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-google-plus"></span> <?php _e('+1 on Google Plus', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-email-ctr" data-lock-type="8"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-purple btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-envelope"></span> <?php _e('Unlock with your e-mail', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-pp-ctr" data-lock-type="9"
                            class="jkof_lockOpenBtn jkof_changeLockBtn rcw-medium rcw-button-5 rcw-paypal btn-block">
                        <span class="icon-bg"></span><span class="button-icon fa fa-paypal"></span> <?php _e('Purchase with PayPal', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr jkof-password-ctr">
                    <div class="jkof_password_status_placeholder" style="display:none;"></div>
                    <form id="jkof_passwordForm">
                        <p class="text-center"><?php _e('Enter the password to download this file.', 'onyxfiles'); ?></p>
                        <div class="form-group">
                            <input type="password" class="floating-label form-control"
                                   id="jkof_inputPassword" placeholder="<?php _e('Enter Password', 'onyxfiles'); ?>"
                                   style="width:100%;">
                        </div>
                        <button type="submit" class="rcw-greensea rcw-small rcw-button-7 btn-block">
                            <span class="icon-bg"></span><span class="button-icon fa fa-download"></span> <?php _e('Download File', 'onyxfiles'); ?>
                        </button>
                    </form>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-linkedin-ctr">
                    <div class="jkof_linkedin_status_placeholder"></div>
                    <p style="margin-bottom: 10px;"><?php _e('Share a message on LinkedIn to download this file!', 'onyxfiles'); ?></p>
                    <script type="in/Login">
                        <button type="button" class="rcw-medium rcw-button-7 rcw-linkedin btn-block jkofLinkedInLockBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-linkedin"></span> <?php _e('Share and Download File', 'onyxfiles'); ?>
                        </button>
                    </script>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-fb-share-ctr">
                    <p><?php _e('Share a message on Facebook to download this file!', 'onyxfiles'); ?></p>
                    <div class="jkof_fb_share_status_placeholder"></div>
                    <button type="button" class="rcw-facebook rcw-medium rcw-button-7 btn-block jkofFBShareLockBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-facebook"></span> <?php _e('Share and Download File', 'onyxfiles'); ?>
                    </button>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-fb-like-ctr">
                    <p><?php _e('Like this page on Facebook to download this file!', 'onyxfiles'); ?></p>
                    <div class="jkof_fb_like_status_placeholder"></div>
                    <div class="fb-like" style="margin-top: 10px; margin-bottom: 10px;"
                         data-href="" id="jkof_fbDLLikeBtn" 
                         data-layout="standard" data-action="like" data-show-faces="false" data-share="false"></div>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-t-follow-ctr">
                    <p style="margin-bottom:10px;"><?php _e('Follow us on twitter to download this file!', 'onyxfiles'); ?></p>
                    <div id="jkof_twitter_follow_status"></div>
                    <div id="jkof_twitterFollowBtnPlaceholder"></div>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-t-tweet-ctr">
                    <p style="margin-bottom: 10px;"><?php _e('Tweet on twitter!', 'onyxfiles'); ?></p>
                    <div id="jkof_twitter_tweet_status"></div>
                    <div id="jkof_tweetBtnCtr"></div>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-gp-plus-ctr">
                    <p style="margin-bottom: 10px;"><?php _e('+1 us on Google Plus', 'onyxfiles'); ?></p>
                    <div id="jkof_gplus_status"></div>
                    <div id="jkof_gPlusOneCtr"></div>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-email-ctr">
                    <p class="text-center"><?php _e('Enter your email to download this file!', 'onyxfiles'); ?></p>
                    <div class="jkof_email_status_placeholder"></div>
                    <form id="jkof_emailDLForm" novalidate="novalidate">
                        <div class="form-group">
                            <input type="email" id="jkof_inputEmail" placeholder="<?php _e('Enter E-mail', 'onyxfiles'); ?>"
                                   class="floating-label form-control" name="jkof_email" style="width:100%;">
                        </div>
                        <?php
                        foreach($jkof_settings['email_fields'] as $efk => $efv){
                        ?>
                            <div class="form-group">
                                <input type="text" id="jkof_inputEmail" placeholder="<?php echo $efv['placeholder']; ?>"
                                       class="floating-label form-control" name="<?php echo $efv['label']; ?>" style="width:100%;">
                            </div>
                        <?php
                        }
                        ?>
                        <div class="form-group">
                            <button type="submit" class="rcw-purple rcw-medium rcw-button-7 btn-block">
                                <span class="icon-bg"></span><span class="button-icon fa fa-envelope"></span> <?php _e('Submit & Download File', 'onyxfiles'); ?>
                            </button>
                        </div>
                    </form>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof_lockCtr text-center jkof-pp-ctr">
                    <p><?php _e('Purchase with paypal for', 'onyxfiles'); ?></p>
                    <p style="margin: 10px 0;font-size:24px;">$<span id="jkof_ppDisplayPrice"></span></p>
                    <p class="text-danger">
                        <strong><?php _e('The download link will be e-mailed to your paypal e-mail.', 'onyxfiles'); ?></strong>
                    </p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="margin-bottom: 10px;">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="custom" value="jkof_pp">
                        <input type="hidden" name="charset" value="utf-8">
                        <input type="hidden" name="return" id="jkof_inputPPReturnURL">
                        <input type="hidden" name="currency_code" value="<?php echo $jkof_settings['paypal']['currency']; ?>">
                        <input type="hidden" name="business" value="<?php echo $jkof_settings['paypal']['email']; ?>">
                        <input type="hidden" name="item_name" id="jkof_inputPPItemName">
                        <input type="hidden" name="item_number" id="jkof_inputPPfid">
                        <input type="hidden" name="amount" id="jkof_inputPPAmount">
                        <input type="hidden" name="quantity" value="1">
                        <input type="image" src="https://www.paypalobjects.com/webstatic/en_US/btn/btn_checkout_pp_142x27.png"
                               border="0" alt="Submit">
                    </form>
                    <button type="button" data-lock-target=".jkof-main-ctr"
                            class="jkof_lockOpenBtn rcw-silver rcw-small rcw-button-7 btn-block jkof_goBackBtn">
                        <span class="icon-bg"></span><span class="button-icon fa fa-arrow-left"></span> <?php _e('Go Back', 'onyxfiles'); ?>
                    </button>
                </div>
                <div class="jkof-loading-ctr text-center">
                    <p><i class="fa fa-spinner fa-spin fa-5x text-primary"></i></p>
                </div>
                <div class="jkof-download-files-ctr"></div>
            </div>
        </div>
    </div>
</div>
<?php
}