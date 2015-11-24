<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Email Fields <small>Manage all e-mail fields for when you require the user to submit their emails.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Email Fields</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <button type="button" class="btn bg-maroon"
                        ng-click="addField()"><i class="fa fa-plus"></i> Add Field</button>
                <hr>
                <div ng-repeat="field in settings.email_fields">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Label</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="Label"
                                   ng-model="field.label">
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-sm btn-danger" ng-click="removeField($index)">
                                <i class="fa fa-remove"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Placeholder</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="Placeholder"
                                   ng-model="field.placeholder">
                        </div>
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