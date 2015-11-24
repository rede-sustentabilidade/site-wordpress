<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Storage Settings <small>Manage all your storage settings for Onyx Files here.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Storage Settings Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <div class="form-group">
                    <label for="inputDropboxAppKey" class="col-sm-3 control-label">Dropbox App Key</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter dropbox app key here"
                               ng-model="settings.storage.dropbox_app_key">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAWSAcessKey" class="col-sm-3 control-label">Amazon Access Key</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter amazon access key here"
                               ng-model="settings.storage.aws_access_key">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAWSSecretKey" class="col-sm-3 control-label">Amazon Secret Key</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter amazon secret keyhere"
                               ng-model="settings.storage.aws_secret_key">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAWSBucketName" class="col-sm-3 control-label">AWS Bucket Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter aws bucket name here"
                               ng-model="settings.storage.aws_bucket_name">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </div>
                </div>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->