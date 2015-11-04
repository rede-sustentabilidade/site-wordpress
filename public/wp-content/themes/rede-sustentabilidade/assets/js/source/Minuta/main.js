require.config({

    baseUrl: '/wp-content/themes/rede-sustentabilidade/assets/js/source/',

    paths: {
        jquery:     '../../bower_components/jquery/dist/jquery',
        minimalect: '../../bower_components/minimalect/jquery.minimalect',
        expander:   '../../bower_components/jquery-expander/jquery.expander',
        form:       '../../bower_components/jquery-form/jquery.form',
        spinjs:     '../../bower_components/spin.js/spin',
        moment:     '../../bower_components/moment/min/moment.min',
        moment_br:  '../../bower_components/moment/min/lang/pt-br',
        introjs :   '../../bower_components/intro.js/intro',
        cookie:     '../../bower_components/jquery.cookie/jquery.cookie',
        countable : '../../bower_components/Countable/Countable',
        Minuta : 'minuta'
    },

    shim : {
        expander: {
            deps : ['jquery'],
            exports : 'jQuery'
        },
        minimalect: {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        form: {
            deps : ['jquery'],
            exports : 'jQuery'
        },

        cookie : {
            deps : ['jquery'],
            exports : 'jQuery'
        }
    }
});

require(['Minuta/App', 'minimalect', 'expander', 'form'], function (App) {
    'use strict';
    //jQuery(document).on('load', function () {
        console.log('inicia minuta');
        App.init();
    //});
});
