<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Paypal Settings <small>Manage all your paypal settings for Onyx Files here.</small></h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Paypal Settings Form</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div ng-show="isSubmitted" class="alert {{ alertClass }}"><strong>{{ alertMessage }}</strong></div>
            <form class="form-horizontal" ng-submit="submit()">
                <div class="form-group">
                    <label for="inputPPEmail" class="col-sm-3 control-label">Paypal E-mail</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter paypal e-mail here"
                               ng-model="settings.paypal.email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputCurrencyCode" class="col-sm-3 control-label">Currency Code</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="enter currency code here"
                               ng-model="settings.paypal.currency">
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