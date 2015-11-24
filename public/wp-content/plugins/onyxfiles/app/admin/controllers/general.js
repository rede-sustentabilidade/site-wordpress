/**
 * Created by jaskokoyn on 5/27/2015.
 */
onyxFilesApp.controller("generalCtrl", ["$scope", "$rootScope", "$http", function($scope, $rootScope, $http){
    $scope.isSubmitted                              =   false;
    $scope.alertClass                               =   null;
    $scope.alertMessage                             =   null;

    $scope.submit                                   =   function(){
        $rootScope.settings.general.action          =   'jkof_save_general_settings';
        $scope.isSubmitted                          =   true;
        $scope.alertClass                           =   'alert-info';
        $scope.alertMessage                         =   jkof_i18n.wait;

        $http({
            url: 'admin-post.php',
            method: 'POST',
            data: jQuery.param($rootScope.settings.general),
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