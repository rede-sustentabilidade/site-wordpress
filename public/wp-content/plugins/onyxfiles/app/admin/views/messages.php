<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Message Settings <small>Manage all your message settings for Onyx Files here.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Message Settings Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Download Denied Message<br><small><em>(HTML allowed)</em></small></label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="4" ng-model="settings.message.denied_dl"></textarea>
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