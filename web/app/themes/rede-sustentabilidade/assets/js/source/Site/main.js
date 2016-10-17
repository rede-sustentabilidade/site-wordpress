define('jquery', [], function() {
    return window.jQuery;
});

require.config({

    baseUrl: '/wp-content/themes/rede-sustentabilidade/assets/js/source/',
    //waitSeconds: 90,
    paths: {
        //'jquery':        '../../bower_components/jquery/dist/jquery.min',
        'jValAdicional':   '../../bower_components/jquery-validation/dist/jquery.validate',
        //'jValAdicional': '../../bower_components/jquery-validation/dist/additional-methods',
        'accounting':    '../../bower_components/accounting.js/accounting',
        //'inputmask':     '../../bower_components/jquery.inputmask/dist/jquery.inputmask.bundle',
        'magnificPopup': '../../bower_components/Magnific-Popup/dist/jquery.magnific-popup',
        'cookie':       '../../bower_components/jquery.cookie/jquery.cookie',
        'spinjs':        '../../bower_components/spin.js/spin',
        'tooltipsy':     '../../bower_components/tooltipsy/tooltipsy.source',
        'sharrre':       '../../bower_components/Sharrre/jquery.sharrre',
        'masonry' :      '../../bower_components/masonry/dist/masonry.pkgd',
        'imagesloaded':  '../../bower_components/imagesloaded/imagesloaded'
    },

    shim : {
        imagesloaded : {
            deps : ['masonry'],
            exports: 'imagesLoaded'
        },
    	masonry : {
            deps : ['jquery'],
            exports: 'jQuery'
        },
        // jValAdicional: {
        //     deps : ['jquery', 'jValidation'],
        //     exports : 'jQuery'
        // },
        jValAdicional: {
            deps : ['jquery'],
            exports: 'jQuery'
        },
        accounting: {
            deps : ['jquery'],
            exports : 'jQuery'
        },
        inputmask: {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        magnificPopup: {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        cookie : {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        tooltipsy: {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        sharrre: {
            deps : ['jquery'],
            exports : 'jQuery'
        },
        'Site/plugins': {
            exports: 'jQuery'
        }
    }
});

require(['Site/App', 'jquery','cookie','spinjs','sharrre'],
    function (App) {
    'use strict';
    //jQuery(document).on('load', function () {
        App.init();
    //});
  if (jQuery('.container-filiacao').size() > 0) {
    require(['Filiacao/main']);
  }
});
