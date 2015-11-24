<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Social Settings <small>Manage all your social media settings for Onyx Files here.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Social Settings Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <div class="form-group">
                    <label for="inputFBAppID" class="col-sm-3 control-label">Facebook App ID</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ng-model="settings.social.fb_app_id"
                               placeholder="enter facebook app id here">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputLIAPIKey" class="col-sm-3 control-label">LinkedIn API Key</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ng-model="settings.social.li_api_key"
                               placeholder="enter linkedin api key here">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputTwitterUsername" class="col-sm-3 control-label">Twitter Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ng-model="settings.social.twitter_u"
                               placeholder="enter twitter username here">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </form>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</section><!-- /.content -->