/**
 * Created by jaskokoyn on 5/7/2015.
 */
onyxfilesApp.controller("uploadCtrl", ["$scope", function($scope){
    $scope.uplDropzone              =   new Dropzone("div#jkof_uplDropzone", {
        url: jkof_ajax_url,
        previewsContainer: '#jkof_uplDropzonePreview',
        previewTemplate:
            '<div class="dz-preview dz-file-preview">' +
            '<div class="dz-icon-preview"><i class="fa fa-file-text-o fa-2x"></i></div>' +
            '<div class="dz-details">' +
            '<strong data-dz-name></strong><span class="dz-size pull-right" data-dz-size></span>' +
            '<div class="dz-progress">' +
            '<div class="progress">' +
            '<div class="progress-bar progress-bar-info progress-bar-striped active" data-dz-uploadprogress></div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>',
        sending: function(file, xhr, fd) {
            fd.append("action", "jkof_upload");
        },
        success: function(file, response){
            $scope.uplDropzone.removeFile(file);
            var jsonRes             =   null;

            try{
                jsonRes             =   JSON.parse(response);
            }catch(e){
                toastr.error("Unable to upload file.", "Error!");
                return null;
            }

            if(jsonRes.status === 1){
                toastr.error( jsonRes.err, "Uh Oh!" );
                return null;
            }

            toastr.success("Your file " + jsonRes.name + " has been uploaded!", "Success!");
            console.log(jsonRes);
        }
    });
}]);