require.config({
    baseUrl: '/app/themes/rede-sustentabilidade/assets/js/source/',

    //waitSeconds: 90,

    paths: {
        jquery:         '../../bower_components/jquery/jquery',
        jqueryChosen:   '../../bower_components/chosen/chosen.jquery',
        domReady:       '../../bower_components/domReady/domReady',
        angular:        '../../bower_components/angular/angular',
        ngChosen:       '../../bower_components/angular-chosen/chosen',
        ngCookie:       '../../bower_components/angular-cookies/angular-cookies',
        ngLocalStorage: '../../bower_components/angularLocalStorage/src/angularLocalStorage',
        ngMask:         '../../bower_components/angular-ui-utils/modules/mask/mask',
        magnificPopup:  '../../bower_components/Magnific-Popup/dist/jquery.magnific-popup'
    },

    shim : {
        angular: {
            exports: 'angular'
        },
        jqueryChosen: {
            deps: ['jquery'],
            exports: 'jQuery'
        },
        ngChosen: {
            deps: ['angular', 'jqueryChosen'],
            exports: 'angular'
        },
        ngCookie: {
            deps: ['angular'],
            exports: 'angular'
        },
        ngLocalStorage: {
            deps: ['angular'],
            exports: 'angular'
        },
        ngMask: {
            deps: ['angular'],
            exports: 'angular'
        }
    },
    deps: [
        // kick start application... see bootstrap.js
        'Filiacao/bootstrap'
    ]
});
