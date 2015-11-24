jQuery(function($){
    // Initialize Plugins
    $.material.init();
    $(".datepicker").datepicker();
    $(".btn-tooltip").tooltip();
    $('#selectBtnIcons').select2({
        templateResult: function(state){
            return $('<span><i class="' + state.id + '"></i> ' + state.text + '</span>');
        },
        width: '100%'
    });

    // Botstrap Fixes
    $(".jkof_dropdownBtn").dropdown();
    $(".jkof_modalBtn").click(function(e){
        e.preventDefault();
        $($(this).data('target')).modal();
    });

    var filesArr                =   JSON.parse($("#jkof_inputFilesArr").val());

    Dropzone.autoDiscover       =   false;
    toastr.options              =   {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    jkof_dropzone               =   new Dropzone( "#jkof_upload_dropzone", {
        url: ajaxurl,
        clickable: true,
        previewTemplate: 
        '<div class="text-center">' +
        '<span data-dz-name></span> - <span class="dz-size" data-dz-size></span>' +
        '<div class="progress progress-striped active"><div class="progress-bar progress-bar-warning" data-dz-uploadprogress></div></div>' +
        '</div>',
        addRemoveLinks: true,
        maxFilesize: jkof_max_upl_size,
        previewsContainer: "#jkof_dropzone_preview",
        error: function(file, errorMessage, xhr){
            toastr.error(errorMessage, jkof_edit_i18n.upload_fail);
            console.log(errorMessage);
            console.log(xhr);
        },
        sending: function(file, xhr, fd){
            fd.append("action", "jkof_upload");
        },
        success: function( file, res ){
            jkof_dropzone.removeFile(file);

            var resObj              =   null;

            try {
                resObj              =   JSON.parse(res);
            }
            catch (e) {
                toastr.error(jkof_edit_i18n.upload_fail, 'Uh Oh!');
                console.log(res);
                console.log(e);
                return false;
            }

            if(resObj.status == 1){
                console.log(resObj);
                toastr.error(resObj.err, 'Uh Oh!');
                return false;
            }

            if(resObj === 0){
                toastr.error(jkof_edit_i18n.upload_fail, "Uh Oh!");
                return false;
            }

            updateFiles(resObj, 1, null);
            toastr.success(jkof_edit_i18n.upload_success, "Success!");
        }
    });

    function updateFiles(res, isDirect, url){
        var fileObj             =    {
            name: res.name,
            type: res.type,
            size: res.size,
            readable_size: filesize( res.size ),
            isDirect: isDirect,
            direct_url: url,
            upl_dir: res.upl_dir
        };
        var fileIcon            =   'fa-file-text-o';
        if(isDirect == 2){
            fileIcon            =   'fa-link';
        }

        $("#jkof_filesTab .row").append(
            '<div class="col-sm-4 text-center">' +
            '<div class="jkof_file_container">' +
            '<i class="fa ' + fileIcon+ ' fa-5x"></i><br>' +
            '<strong>' + fileObj.name + '</strong><br>' +
            '<small>' + fileObj.type + '<br>' + fileObj.readable_size  + '</small>' +
            '<button type="button" class="btn btn-xs btn-material-red jkof_removeFileBtn"><i class="fa fa-remove"></i></button>'  +
            '</div>' +
            '</div>'
        );

        filesArr.push(fileObj);
        $(".btn-tooltip").tooltip();
        $("#jkof_inputFilesArr").val( JSON.stringify(filesArr) );
        console.log(filesArr);
        return true;
    }

    $(document).on('click', '.jkof_removeFileBtn', function(e){
        e.preventDefault();

        var fileIndex   =   $(".jkof_removeFileBtn").index(this);

        $(this).closest(".col").fadeOut('fast', function(){
            $(this).remove();
            filesArr.splice(fileIndex, 1);
            $("#jkof_inputFilesArr").val( JSON.stringify(filesArr) );
        });
    });

    //$("#selectBtnIcons, .selectLockOpts").selectpicker();

    $(document).on( 'input', '.updateBtn', updateBtn);
    $(document).on( 'change', '.updateBtn', updateBtn);

    function updateBtn(){
        console.log('ayy');
        var btn_id              =   "#jkof-ex-dl-btn";
        var btnText             =   $("#inputBtnLabel").val().trim();
        var btnIcon             =   $("#selectBtnIcons").val();
        var btnStyle            =   parseInt($("#selectBtnStyles").val().substr(-1,1));

        $(btn_id).removeClass();
        $(btn_id).addClass($("#selectBtnColor").val());
        $(btn_id).addClass($("#selectBtnSize").val());
        $(btn_id).addClass($("#selectBtnEffects").val());
        $(btn_id).addClass($("#selectBtnEnhancements").val());
        $(btn_id).addClass($("#selectBtnStyles").val());
        $(btn_id).addClass($("#selectBtnShape").val());

        if(btnText === ''){
            $(btn_id).addClass('no-text');
        }

        if( btnStyle == 0 ){
            $("#jkof-ex-dl-btn").text( btnText );
        }else if( btnStyle == 1 || btnStyle == 2 ||  btnStyle == 3){
            $("#jkof-ex-dl-btn").html( '<span class="button-icon ' + btnIcon + '"></span> ' + btnText );
        }else if( btnStyle == 4 || btnStyle == 5 ||  btnStyle == 6 || btnStyle == 7 ){
            $("#jkof-ex-dl-btn").html(
                '<span class="icon-bg"></span> <span class="button-icon ' + btnIcon + '"></span> ' + btnText
            );
        }

        if( !$(btn_id).hasClass('rcw-button-0') ){
            $(btn_id)
                .find('.button-icon')
                .removeClass()
                .addClass('button-icon fa ' + $("#selectBtnIcons").val() );
        }
    }

    $(".updateLockCB").change(function(){
        var lockOptsArr         =    $(".updateLockCB:checked").map(function(){
            return parseInt($(this).val());
        }).get();

        console.log(lockOptsArr);

        $(".lockerGroupCtr").each(function(){
            var locker_id       =   $(this).data('locker-id');

            if($.inArray(locker_id,lockOptsArr) > -1){
                $(this).show();
            }else{
                $(this).hide();
            }
        });
    });

    $('#jkof_file_browser').fileTree({ script: ajaxurl, action: "jkof_filetree" }, function(file) {
        $("#jkof_browser_add_status").html(
            '<div class="alert alert-info"><strong>'+ jkof_edit_i18n.wait +'</strong> '+ jkof_edit_i18n.adding_file +'</div>'
        );

        var formObj    =    {
            action: "jkof_add_browser_file",
            file: file
        };

        $.post(ajaxurl, formObj, function(res){
            var resObj              =   null;

            try {
                resObj              =   JSON.parse(res);
            }
            catch (e) {
                $("#jkof_browser_add_status").html(
                    '<div class="alert alert-warning"><strong>'+ jkof_edit_i18n.error +'</strong> '+ jkof_edit_i18n.unable +'</div>'
                );
                console.log(e);
                return false;
            }

            if(resObj.status == 1){
                $("#jkof_browser_add_status").html(
                    '<div class="alert alert-warning"><strong>'+ jkof_edit_i18n.error +'</strong> ' + resObj.err + '</div>'
                );
                return false;
            }

            updateFiles(resObj, 1, null);
            $("#jkof_browser_add_status").html(
                '<div class="alert alert-success"><strong>'+ jkof_edit_i18n.success +'</strong> '+ jkof_edit_i18n.unable +'</div>'
            );
        });
    });

    $("#importUrlBtn").click(function(e){
        e.preventDefault();
        $("#jkof_url_import_status").html(
            '<div class="alert alert-info"><strong>'+ jkof_edit_i18n.wait +'</strong> '+ jkof_edit_i18n.adding_file +'</div>'
        ).hide().slideDown('fast');

        var formObj             =    {
            action: "jkof_import_url_file",
            import_url: $("#jkof_inputUrl").val()
        };

        $.post(ajaxurl, formObj, function(data){
            var resObj              =   null;

            try {
                resObj              =   JSON.parse(data);
            }
            catch (e) {
                $("#jkof_url_import_status").html(
                    '<div class="alert alert-danger"><strong>'+ jkof_edit_i18n.error +'</strong> '+ jkof_edit_i18n.unable +'</div>'
                );
                console.log(e);
                return false;
            }

            if(resObj.status == 1){
                $("#jkof_url_import_status").html(
                    '<div class="alert alert-danger"><strong>'+ jkof_edit_i18n.error +'</strong> '+ jkof_edit_i18n.unable +'</div>'
                );
                return false;
            }

            updateFiles(resObj, 1, null);

            $("#jkof_url_import_status").html(
                '<div class="alert alert-success"><strong>'+ jkof_edit_i18n.success +'</strong> '+ jkof_edit_i18n.file_upl_success +'</div>'
            );
        });
    });

    var jkof_dropboxBtn = (typeof Dropbox == "object") ? Dropbox.createChooseButton({
        linkType: "direct",
        success: function(drophox_files){
            $("#jkof_import_dropbox_status").html(
                '<div class="alert alert-info"><strong>'+ jkof_edit_i18n.wait +'</strong> '+ jkof_edit_i18n.adding_file +'</div>'
            );

            var formObj    =    {
                action: "jkof_import_url_file",
                import_url: drophox_files[0].link
            };

            $.post(ajaxurl, formObj, function(res){
                var resObj              =   null;

                try {
                    resObj              =   JSON.parse(res);
                }
                catch (e) {
                    $("#jkof_import_dropbox_status").html(
                        '<div class="alert alert-warning"><strong>'+ jkof_edit_i18n.error +'</strong> '+ jkof_edit_i18n.unable +'</div>'
                    );
                    console.log(e);
                    return false;
                }

                if(resObj.status == 1){
                    $("#jkof_import_dropbox_status").html(
                        '<div class="alert alert-warning"><strong>'+ jkof_edit_i18n.error +'</strong> '+ jkof_edit_i18n.unable +'</div>'
                    );
                    return false;
                }

                updateFiles(resObj, 1, null);
                $("#jkof_import_dropbox_status").html(
                    '<div class="alert alert-success"><strong>'+ jkof_edit_i18n.success +'</strong> '+ jkof_edit_i18n.file_upl_success +'</div>'
                );
            });
        }
    }) : null;
    $("#jkof_dropboxBtn").html(jkof_dropboxBtn);

    $("#jkof_submitDirectURL").click(function(e){
        e.preventDefault();

        $("#jkof_directURLStatusPlaceholder").html(
            '<div class="alert alert-info"><strong>'+ jkof_edit_i18n.wait +'</strong> '+ jkof_edit_i18n.adding_url +'</div>'
        );

        var fileObj    =    {
            name: $("#jkof_inputDirectURL").val(),
            type: "URL",
            size: 0,
            upl_dir: null
        };

        updateFiles(fileObj, 2, $("#jkof_inputDirectURL").val());

        $("#jkof_directURLStatusPlaceholder").html(
            '<div class="alert alert-success"><strong>'+ jkof_edit_i18n.success +'</strong> '+ jkof_edit_i18n.file_upl_success +'</div>'
        );
    });
});