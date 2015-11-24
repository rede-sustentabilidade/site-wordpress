/**
 * Created by jaskokoyn on 5/23/2015.
 */
onyxFilesApp.controller("emailFieldsCtrl", ["$scope", "$rootScope", "$http", function($scope, $rootScope, $http){
    $scope.isSubmitted                              =   false;
    $scope.alertClass                               =   null;
    $scope.alertMessage                             =   null;

    $scope.addField                                 =   function(){
        $rootScope.settings.email_fields.push({
            label: null,
            placeholder: null
        });
    };

    $scope.removeField                              =   function($index){
            $rootScope.settings.email_fields.splice($index, 1);
    };

    $scope.submit                                   =   function(){
        $rootScope.settings.action                  =   'jkof_save_fields_settings';
        $scope.isSubmitted                          =   true;
        $scope.alertClass                           =   'alert-info';
        $scope.alertMessage                         =   jkof_i18n.wait;

        $http({
            url: 'admin-post.php',
            method: 'POST',
            data: jQuery.param($rootScope.settings),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data,status,headers,config){
            console.log(data);
            if(data.status === 2){
                $scope.alertClass                           =   'alert-success';
                $scope.alertMessage                         =   jkof_i18n.success;
            }else{
                $scope.alertClass                           =   'alert-warning';
                $scope.alertMessage                         =   jkof_i18n.fail;
            }
        });
    };
}]);