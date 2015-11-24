/**
 * Created by jaskokoyn on 5/22/2015.
 */
var onyxFilesApp        =   angular.module("onyxFilesApp", [
    'ui.router'
]);

onyxFilesApp.run(function($rootScope){
    $rootScope.settings     =   onyxFilesSettings;
});

onyxFilesApp.config(function($stateProvider, $urlRouterProvider, $locationProvider) {
    // For any unmatched url, redirect to /state1
    $urlRouterProvider.otherwise("/general");

    // Now set up the states
    $stateProvider
        .state('general', {
            url: "/general",
            templateUrl: onyxFilesPluginURL + 'general.php',
            controller: "generalCtrl"
        })
        .state('social', {
            url: "/social",
            templateUrl: onyxFilesPluginURL + 'social.php',
            controller: "socialCtrl"
        })
        .state('paypal', {
            url: "/paypal",
            templateUrl: onyxFilesPluginURL + 'paypal.php',
            controller: "paypalCtrl"
        })
        .state('blocked', {
            url: "/blocked",
            templateUrl: onyxFilesPluginURL + 'blocked.php',
            controller: "blockedCtrl"
        })
        .state('messages', {
            url: "/messages",
            templateUrl: onyxFilesPluginURL + 'messages.php',
            controller: "messagesCtrl"
        }).state('storage', {
            url: "/storage",
            templateUrl: onyxFilesPluginURL + 'storage.php',
            controller: "storageCtrl"
        }).state('emailFields', {
            url: "/email-fields",
            templateUrl: onyxFilesPluginURL + 'email-fields.php',
            controller: "emailFieldsCtrl"
        });
});