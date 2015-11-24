<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>General Settings <small>Manage all your general settings for Onyx Files here.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">General Settings Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <div class="form-group">
                    <label for="inputMaxUplSize" class="col-sm-3 control-label">Max Upload Size (mb)</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" ng-model="settings.general.max_upl_size"
                               placeholder="enter maximum upload size">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputFBAppID" class="col-sm-3 control-label">Unlocked Download Expiration (hours)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" ng-model="settings.general.unlocked_dl_exp"
                               placeholder="enter unlocked download expiration">
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