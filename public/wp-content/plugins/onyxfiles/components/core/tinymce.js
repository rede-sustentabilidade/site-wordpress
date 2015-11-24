/**
 * Created by jaskokoyn on 5/13/2015.
 */
jQuery(function($){
    tinymce.PluginManager.add('jkof_files_btn', function( editor, url ) {
        editor.addButton( 'jkof_files_btn', {
            icon: 'onyxfile',
            onclick: function() {
                $('#jkof_tinymce_modal').modal('show');
            }
        });
    });

    var formObj     =   {
        offset:     0,
        action:     'jkof_load_file_list'
    };

    $.post(ajaxurl, formObj, function(res){
        $("#jkof_tmce_file_list").append(res);
        formObj.offset += 10;
    });

    $(document).on( 'click', '.jkof_file_list_item', function(e){
        e.preventDefault();

        $('#jkof_tinymce_modal').modal('hide');
        tinymce.activeEditor.insertContent('[onyxfile id=' + $(this).data('fid') + ']');
    });

    $(document).on( 'click', '#jkof_loadMoreFiles', function(e){
        e.preventDefault();
        $.post(ajaxurl, formObj, function(res){
            $("#jkof_tmce_file_list").append(res);
        });
    });
});