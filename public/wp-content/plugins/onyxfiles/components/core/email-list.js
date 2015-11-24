jQuery(function($){
    $("#checkAllCB").change(function() {
        if(this.checked) {
            $("#emailListTbl").find("input[type='checkbox']").prop('checked', true);
        }else{
            $("#emailListTbl").find("input[type='checkbox']").prop('checked', false);
        }
    });

    $("#jkof_deleteSelectedBtn").click(function(e){
        e.preventDefault();

        $("#jkof_email_action_status_placeholder").html(
            '<div class="alert alert-info"><strong>Please wait!</strong> We are currently deleting these emails for you.</div>'
        );

        var emailsArr    =    [];

        $(".jkof_email:checked").each(function(){
            emailsArr.push(this.value);
        });

        var formObj    =    {
            emails: emailsArr,
            action: "jkof_delete_emails"
        };

        $.post(ajaxurl, formObj, function(data){
            if(data == "ACTION_DENIED"){
                $("#jkof_email_action_status_placeholder").html(
                    '<div class="alert alert-danger"><strong>Access Denied!</strong> You do not have permission to perform this action.</div>'
                );
                return;
            }

            $("#jkof_email_action_status_placeholder").html(
                '<div class="alert alert-success"><strong>Success!</strong> We have successfully deleted these emails. We are now refreshing the page.</div>'
            );
            location.reload();
        });
    });

    $("#jkof_exportSelectedBtn").click(function(e){
        e.preventDefault();

        $("#jkof_email_action_status_placeholder").html(
            '<div class="alert alert-info"><strong>Please wait!</strong> We are currently exporting these emails for you.</div>'
        );

        var emailsArr    =    [];

        $(".jkof_email:checked").each(function(){
            emailsArr.push(this.value);
        });

        var formObj    =    {
            emails: emailsArr,
            action: "jkof_export_selected_emails"
        };

        $.post(ajaxurl, formObj, function(data){
            $("#jkof_email_action_status_placeholder").html(
                '<div class="alert alert-success"><strong>Success!</strong> Your download will begin in a moment.</div>'
            );
            location.href    =    "emails.csv";
        });
    });

    $("#jkof_exportAllBtn").click(function(e){
        e.preventDefault();

        $("#jkof_email_action_status_placeholder").html(
            '<div class="alert alert-info">'+
            '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>'+
            '<span class="sr-only">Close</span></button>'+
            '<strong>Please wait!</strong> We are currently exporting these emails for you.'+
            '</div>'
        );

        var formObj    =    {
            action: "jkof_export_all_emails"
        };

        $.post(ajaxurl, formObj, function(data){
            console.log(data);
            $("#jkof_email_action_status_placeholder").html(
                '<div class="alert alert-success">'+
                '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>'+
                '<span class="sr-only">Close</span></button>'+
                '<strong>Success!</strong> Your download will begin in a moment.'+
                '</div>'
            );
            location.href    =    "emails.csv";
        });
    });

    $("#jkof_exportUniqueBtn").click(function(e){
        e.preventDefault();

        $("#jkof_email_action_status_placeholder").html(
            '<div class="alert alert-info"><strong>Please wait!</strong> We are currently exporting these emails for you.</div>'
        );

        var formObj    =    {
            action: "jkof_export_unique_emails"
        };

        $.post(ajaxurl, formObj, function(data){
            console.log(data);
            $("#jkof_email_action_status_placeholder").html(
                '<div class="alert alert-success"><strong>Success!</strong> Your download will begin in a moment.</div>'
            );
            location.href    =    "emails.csv";
        });
    });
});