/**
 * Created by jaskokoyn on 5/22/2015.
 */
onyxFilesApp.controller("storageCtrl", ["$scope", "$rootScope", "$http", function($scope, $rootScope, $http){
    $scope.isSubmitted                              =   false;
    $scope.alertClass                               =   null;
    $scope.alertMessage                             =   null;

    $scope.submit                                   =   function(){
        $rootScope.settings.storage.action          =   'jkof_save_storage_settings';
        $scope.isSubmitted                          =   true;
        $scope.alertClass                           =   'alert-info';
        $scope.alertMessage                         =   jkof_i18n.wait;

        $http({
            url: 'admin-post.php',
            method: 'POST',
            data: jQuery.param($rootScope.settings.storage),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(data,status,headers,config){
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