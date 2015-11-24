jQuery(function($){
    // Initialize Plugins
    $(".btn-tooltip").tooltip();

    // Botstrap Fixes
    $(".jkof_dropdownBtn").dropdown();

    $(document).on("click", ".jkof_openDLModalBtn", function(e){
        e.preventDefault();
        $($(this).data('target')).modal();

        var btnFID  =   $(this).attr("data-fid");
        $("#jkof-dl-modal").attr( "data-fid", $(this).attr("data-fid") ); // Set File ID

        if($(this).data('file-share') == "1"){
            getDownload();
            return null;
        }

        // Determine Locks
        var modalLocks    =    $(this).attr('data-locks').split(",");

        $(".jkof_changeLockBtn").each(function(){
            if( $.inArray( $(this).data('lock-type').toString() , modalLocks ) > -1 ){
                $(this).show();
            }else{
                $(this).hide();
            }
        });

        $(".jkof-idl-ctr").hide();

        // LinkedIn
        $("#jkof-dl-modal").attr('data-li-message', $(this).attr('data-li-message'));
        var liURL    =    $(this).attr('data-li-url') === "" ? window.location.href : $(this).attr('data-li-url');
        $("#jkof-dl-modal").attr('data-li-url', liURL);

        // Facebook
        var fbURL    =    $(this).attr('data-fb-share-url') === "" ? window.location.href : $(this).attr('data-fb-share-url');
        var fbLikeURL    =    ($(this).attr('data-fb-like-url') === "") ? window.location.href : $(this).attr('data-fb-like-url');
        $("#jkof-dl-modal").attr('data-fb-share-url', fbURL);
        $("#jkof_fbDLLikeBtn").attr('data-href', fbLikeURL);

        // Twitter
        twttr.widgets.createFollowButton(
            $(this).data('twitter-username'),
            document.getElementById('jkof_twitterFollowBtnPlaceholder'), {
                size: 'large'
            }
        );
        twttr.widgets.createShareButton(
            window.location.href,
            document.getElementById('jkof_tweetBtnCtr'), {
                text: $(this).data('tweet')
            }
        );

        // Google+
        var gplus_url    =     $(this).attr('data-gplus-url') === "" ? window.location.href : $(this).attr('data-gplus-url');
        $("#jkof_gPlusOneCtr").html('<div id="jkof_gPlusOneBtn""></div>');
        gapi.plusone.render("jkof_gPlusOneBtn",{
            size: "tall",
            callback: "jkof_gplus_download_file",
            href: gplus_url
        });

        // Paypal
        $("#jkof_inputPPAmount").val( $(this).data('pp-amount') );
        $("#jkof_ppDisplayPrice").text( $(this).data('pp-amount') );
        $("#jkof_inputPPReturnURL").val(window.location.href);
        $("#jkof_inputPPItemName").val( $(this).data('item-name') );
        $("#jkof_inputPPfid").val( $(this).data('fid') );

        getDownload();
    });

    $(document).on("click", ".jkof_lockOpenBtn", function(e){
        e.preventDefault();
        var targetElem              =   $(this).data('lock-target');
        $(this).parent().fadeOut('fast', function(){
            $(targetElem).fadeIn('fast');
        });
    });

    $("#jkof_passwordForm").submit(function(e){
        e.preventDefault();

        $(this).slideUp('fast', function(){
            $(".jkof_password_status_placeholder").html(
                '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait +'</strong> '+ jkof_dl_i18n.checking_password +'</div>'
            ).hide().slideDown('fast');

            var formObj    =    {
                password:    $("#jkof_inputPassword").val(),
                action:      'jkof_check_password',
                fid:         $("#jkof-dl-modal").attr("data-fid")
            };

            $.post( jkof_ajax_url, formObj, function(response){
                try{
                    var jsonRes         =   JSON.parse(response);
                }catch(e){
                    console.log(e, response);
                    $("#jkof-dl-modal").find(".jkof_password_status_placeholder").html(
                        '<div class="alert alert-warning"><strong>'+ jkof_dl_i18n.error +'</strong> '+ jkof_dl_i18n.try_later +'</div>'
                    );
                    $("#jkof_passwordForm").slideDown('fast');
                    return null;
                }

                if(jsonRes.status == 2){
                    $(".jkof_password_status_placeholder").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.success +'</strong> '+ jkof_dl_i18n.getting_download +'</div>'
                    );
                    getDownload();
                }else{
                    $("#jkof-dl-modal").find(".jkof_password_status_placeholder").html(
                        '<div class="alert alert-danger"><strong>'+ jkof_dl_i18n.denied +'</strong> ' + jsonRes.err + '.</div>'
                    );
                    $("#jkof_passwordForm").slideDown('fast');
                }
            });
        });
    });

    window.fbAsyncInit = function() {
        FB.init({
            appId      : jkof_fb_app_id,
            xfbml      : true,
            version    : 'v2.3'
        });

        FB.Event.subscribe('edge.create', function(url, html_element){
            $(".jkof_fb_like_status_placeholder").html(
                '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait + '</strong> '+ jkof_dl_i18n.getting_download +'</div>'
            );

            var formObj    =    {
                action:      'jkof_add_verified_download',
                fid:         jQuery("#jkof-dl-modal").attr("data-fid")
            };

            $.post( jkof_ajax_url, formObj, function(response) {
                try {
                    var jsonRes = JSON.parse(response);
                } catch (e) {
                    console.log(e, response);
                    return false;
                }


                if(jsonRes.status === 1){
                    $("#jkof-dl-modal").find(".jkof_fb_like_status_placeholder").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error + '</strong> '+ jkof_dl_i18n.unable + '</div>'
                    );
                    return null;
                }

                getDownload();
            });
        });
    };

    $(".jkofFBShareLockBtn").click(function(e){
        e.preventDefault();
        FB.ui({
            method: 'share',
            href:  $("#jkof-dl-modal").attr('data-fb-share-url')
        }, function(response){
            if(response){
                $(".jkof_fb_share_status_placeholder").html(
                    '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait + '</strong> '+ jkof_dl_i18n.getting_download + '</div>'
                );

                var formObj    =    {
                    action:      'jkof_add_verified_download',
                    fid:         jQuery("#jkof-dl-modal").attr("data-fid")
                };

                $.post( jkof_ajax_url, formObj, function(response) {
                    try {
                        var jsonRes = JSON.parse(response);
                    } catch (e) {
                        console.log(e, response);
                        return false;
                    }


                    if(jsonRes.status === 1){
                        $("#jkof-dl-modal").find(".jkof_fb_share_status_placeholder").html(
                            '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error + '</strong> '+ jkof_dl_i18n.unable + '</div>'
                        );
                        return null;
                    }

                    getDownload();
                });
            }
        });
    });

    twttr.ready(function (twttr) {
        // bind events here
        twttr.events.bind( 'follow', function (event) {
            $("#jkof_twitter_follow_status").html(
                '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait + '</strong> '+ jkof_dl_i18n.getting_download + '</div>'
            );

            var formObj    =    {
                action:      'jkof_add_verified_download',
                fid:         jQuery("#jkof-dl-modal").attr("data-fid")
            };

            $.post( jkof_ajax_url, formObj, function(response) {
                try {
                    var jsonRes = JSON.parse(response);
                } catch (e) {
                    console.log(e, response);
                    return false;
                }


                if(jsonRes.status === 1){
                    $("#jkof-dl-modal").find("#jkof_twitter_follow_status").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error + '</strong> '+ jkof_dl_i18n.unable + '</div>'
                    );
                    return null;
                }

                getDownload();
            });
        });

        twttr.events.bind('tweet', function (event) {
            $("#jkof_twitter_tweet_status").html(
                '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait + '</strong> '+ jkof_dl_i18n.getting_download + '</div>'
            );

            var formObj    =    {
                action:      'jkof_add_verified_download',
                fid:         jQuery("#jkof-dl-modal").attr("data-fid")
            };

            $.post( jkof_ajax_url, formObj, function(response) {
                try {
                    var jsonRes = JSON.parse(response);
                } catch (e) {
                    console.log(e, response);
                    return false;
                }


                if(jsonRes.status === 1){
                    $("#jkof-dl-modal").find("#jkof_twitter_tweet_status").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error + '</strong> '+ jkof_dl_i18n.unable + '</div>'
                    );
                    return null;
                }

                getDownload();
            });
        });
    });

    $("#jkof_emailDLForm").submit(function(e){
        e.preventDefault();
        var formObj             =           $(this).serialize();
        formObj                 +=          '&action=jkof_check_email';
        formObj                 +=          '&fid=' + $("#jkof-dl-modal").attr("data-fid");

        $(this).slideUp('fast', function(){
            $(".jkof_email_status_placeholder").html(
                '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait +'</strong> '+ jkof_dl_i18n.adding_email +'</div>'
            ).hide().slideDown('fast');

            $.post( jkof_ajax_url, formObj, function(response){
                console.log(response);
                try{
                    var jsonRes         =   JSON.parse(response);
                }catch(e){
                    console.log(e, response);
                    $("#jkof-dl-modal").find(".jkof_email_status_placeholder").html(
                        '<div class="alert alert-warning"><strong>'+ jkof_dl_i18n.error +'</strong> '+ jkof_dl_i18n.try_later +'</div>'
                    );
                    $("#jkof_emailDLForm").slideDown('fast');
                    return null;
                }

                if(jsonRes.status == 2){ // Instant
                    $(".jkof_email_status_placeholder").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.success +'</strong> '+ jkof_dl_i18n.getting_download +'</div>'
                    );
                    getDownload();
                }else if(jsonRes.status == 3){
                    $(".jkof_email_status_placeholder").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.success +'</strong> '+ jkof_dl_i18n.emailing_download +'</div>'
                    );
                }else{
                    $(".jkof_email_status_placeholder").html(
                        '<div class="alert alert-danger"><strong>'+ jkof_dl_i18n.denied +'</strong> '+ jkof_dl_i18n.try_later +'</div>'
                    );
                    $("#jkof_emailDLForm").slideDown('fast');
                }
            });
        });
    });

    $("#jkof-dl-modal").on('hidden.bs.modal', function (e) {
        $(".jkof-main-ctr, .jkof-download-files-ctr, .jkof_lockCtr, .jkof_password_status_placeholder, .jkof_linkedin_status_placeholder, .jkof_fb_share_status_placeholder, .jkof_fb_like_status_placeholder, #jkof_twitter_tweet_status, #jkof_twitter_follow_status, .jkof_email_status_placeholder").hide();
        $(".jkof-loading-ctr, .jkof_passwordForm, #jkof_emailDLForm").show();

        // Password
        $("#jkof_inputPassword").val('');

        // Facebook Share

        // Twitter
        $("#jkof_twitterFollowBtnPlaceholder, #jkof_tweetBtnCtr").html('');

        // E-mail
        $("#jkof_emailDLForm").find("input").val('');
    });
});

function onLinkedInLoad() {
    IN.Event.on(IN, "auth", function() {onLinkedInLogin();});
}
function onLinkedInLogin() {
    jQuery(document).on('click', ".jkofLinkedInLockBtn", function(e){
        e.preventDefault();
        jQuery("#jkof-dl-modal").find(".jkof_linkedin_status_placeholder").html(
            '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait +'</strong> '+ jkof_dl_i18n.linkedin +'</div>'
        );
        jkof_shareLinkedIn();
    });
}
function jkof_shareLinkedIn() {
    var payload         =   {
        "content": {
            "submitted-url": jQuery("#jkof-dl-modal").attr('data-li-url'),
            "title": document.title,
            "description": document.title,
            "submitted-image-url": getFavicon()
        },
        "visibility": {
            "code": "anyone"
        },
        "comment": jQuery("#jkof-dl-modal").attr('data-li-message')
    };
    IN.API.Raw("/people/~/shares?format=json")
        .method("POST")
        .body( JSON.stringify(payload))
        .result(function(r) {
            var formObj    =    {
                action:      'jkof_add_verified_download',
                fid:         jQuery("#jkof-dl-modal").attr("data-fid")
            };

            jQuery.post( jkof_ajax_url, formObj, function(response) {
                try {
                    var jsonRes = JSON.parse(response);
                } catch (e) {
                    console.log(e, response);
                    return false;
                }

                if(jsonRes.status === 1){
                    jQuery("#jkof-dl-modal").find(".jkof_linkedin_status_placeholder").html(
                        '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error +'</strong> '+ jkof_dl_i18n.unable +'</div>'
                    );
                    return null;
                }

                jQuery("#jkof-dl-modal").find(".jkof_linkedin_status_placeholder").html(
                    '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.success +'</strong> '+ jkof_dl_i18n.getting_download +'</div>'
                );
                getDownload();
            });
        })
        .error(function(r) {
            console.log(r);
            jQuery("#jkof-dl-modal").find(".jkof_linkedin_status_placeholder").html(
                '<div class="alert alert-danger"><strong>'+ jkof_dl_i18n.error +'</strong> '+ jkof_dl_i18n.linkedin_fail +'</div>'
            );
        });
}
function getFavicon(){
    var favicon = undefined;
    var nodeList = document.getElementsByTagName("link");
    for (var i = 0; i < nodeList.length; i++) {
        if((nodeList[i].getAttribute("rel") == "icon")||(nodeList[i].getAttribute("rel") == "shortcut icon")) {
            favicon = nodeList[i].getAttribute("href");
        }
    }
    return favicon;
};
function jkof_gplus_download_file(jsonParam){
    if(jsonParam.state !== "on"){
        return null;
    }

    jQuery("#jkof_gplus_status").html(
        '<div class="alert alert-info"><strong>'+ jkof_dl_i18n.wait +'</strong> '+ jkof_dl_i18n.getting_download +'</div>'
    );

    var formObj    =    {
        action:      'jkof_add_verified_download',
        fid:         jQuery("#jkof-dl-modal").attr("data-fid")
    };

    jQuery.post( jkof_ajax_url, formObj, function(response) {
        try {
            var jsonRes = JSON.parse(response);
        } catch (e) {
            console.log(e, response);
            return false;
        }

        if (jsonRes.status === 1) {
            jQuery("#jkof-dl-modal").find("#jkof_gplus_status").html(
                '<div class="alert alert-success"><strong>'+ jkof_dl_i18n.error +'</strong> '+ jkof_dl_i18n.unable +'</div>'
            );
            return null;
        }

        getDownload();
    })
}
function getDownload(){
    var formObj    =    {
        action:      'jkof_get_downloads',
        fid:         jQuery("#jkof-dl-modal").attr("data-fid")
    };

    jQuery.post( jkof_ajax_url, formObj, function(response){
        console.log(response);
        try{
            var jsonRes         =   JSON.parse(response);
        }catch(e){
            console.log(e, response);
            return false;
        }

        if(jsonRes.status == 2){
            if(jsonRes.indiv_dls === 2){
                jQuery(".jkof-download-files-ctr").html(
                    '<a href="?ofdl=' + formObj.fid + '&idl=all" class="rcw-medium rcw-button-6 rcw-turquoise btn-block"><span class="icon-bg"></span><span class="button-icon fa fa-download"></span> '+ jkof_dl_i18n.downloading_all_files +'</a>'
                );

                jsonRes.files.forEach(function(elem,ind,arr){
                    jQuery(".jkof-download-files-ctr").append(
                        '<a href="' + elem.url + '" class="rcw-small rcw-button-6 rcw-wetasphalt btn-block">' +
                        '<span class="icon-bg"></span>' +
                        '<span class="button-icon fa fa-download"></span> ' + elem.title +
                        '</a>'
                    );
                });
            }else{
                jQuery(".jkof-download-files-ctr").html(
                    '<a href="?ofdl=' + formObj.fid + '" class="rcw-medium rcw-button-6 rcw-turquoise btn-block"><span class="icon-bg"></span><span class="button-icon fa fa-download"></span> '+ jkof_dl_i18n.download_file +'</a>'
                );
            }

            jQuery(".jkof_lockCtr, .jkof-loading-ctr").fadeOut('fast', function(){
                jQuery(".jkof-download-files-ctr").fadeIn();
            });
        }else{
            jQuery(".jkof-loading-ctr").fadeOut('fast', function(){
                jQuery(".jkof-main-ctr").fadeIn('fast');
            });
        }
    });
}