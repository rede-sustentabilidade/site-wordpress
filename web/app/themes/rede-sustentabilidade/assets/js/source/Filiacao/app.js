/**
 * loads sub modules and wraps them up into the main module
 * this should be used for top-level module definitions only
 */
define([
    'angular',
    'ngChosen',
    'ngCookie',
    'ngLocalStorage',
    'ngMask',
    'magnificPopup'
], function (ng) {
    'use strict';

    var conexaoRedeApp = ng.module('conexaoRedeApp', ['ui.mask', 'localytics.directives', 'angularLocalStorage']);

    jQuery.support.cors = true;

    conexaoRedeApp.directive('gallery', function(){
        return function ($scope, $element, attrs) {
            jQuery('.simple-ajax-popup').magnificPopup({
                type: 'ajax',
                midClick: true
            });
         }
    });


    conexaoRedeApp.controller('FiliacaoForm', ['$scope', '$http', 'storage',
        function FiliacaoForm($scope, $http, storage) {

            $scope.ja_preencheu = false;
            $scope.logged = (window.WP_USER_ID ? true : false) ;
            //$http.defaults.headers.post = {'Content-Type': 'application/json'};
            //$http.defaults.headers.post["Content-Type"] = "application/json";
            $http.defaults.useXDomain = true;
            delete $http.defaults.headers.common['X-Requested-With'];

            if(window.WP_USER_ID) {
                jQuery.ajax({ type: 'GET', url: API_PATH+'/usuario/filiado/'+WP_USER_ID })
                .done(function (data) {
                    $scope.$apply(function(){
                    $scope.ja_preencheu = true;
                    });
                });
            }

            $scope.master= {};
            $scope.filiado= {};

            $scope.somenteNumeros = /^[0-9]+$/;

            storage.bind($scope,'filiado');

            $scope.steps = [
                {'name': 'Introdução',       'id': '1', 'status': 'doing'},
                {'name': 'Dados Pessoais',   'id': '2', 'status': 'todo'},
                {'name': 'Dados Eleitorais', 'id': '3', 'status': 'todo'},
                {'name': 'Interesses',       'id': '4', 'status': 'todo'}
            ];

            // $http.get(API_PATH+'/area-interesse').success(function(data) {
            //     $scope.listaAreasInteresse = data;
            // });

            // $http.get(API_PATH+'/atuacao-profissional').success(function(data) {
            //     $scope.listaAtuacoesProfissionais = data;
            // });

            $scope.listaEscolaridade = [
            		'',
                'Não Alfabetizado',
                'Ensino Fundamental - Incompleto',
                'Ensino Fundamental - Completo',
                'Ensino Médio - Incompleto',
                'Ensino Médio - Completo',
                'Superior - Incompleto',
                'Superior - Completo',
                'Especialização - Incompleto',
                'Especialização - Completo',
                'Mestrado - Incompleto',
                'Mestrado - Completo',
                'Doutorado - Incompleto',
                'Doutorado - Completo'
            ];

            $scope.nacionalidades = [
            		'',
                'Brasil - Brasileiro',
                'Antígua e Barbuda - Antiguano',
                'Argentina - Argentino',
                'Bahamas - Bahamense',
                'Barbados - Barbadiano, barbadense',
                'Belize - Belizenho',
                'Bolívia - Boliviano',
                'Chile - Chileno',
                'Colômbia - Colombiano',
                'Costa Rica - Costarriquenho',
                'Cuba - Cubano',
                'Dominica - Dominicano',
                'Equador - Equatoriano',
                'El Salvador - Salvadorenho',
                'Granada - Granadino',
                'Guatemala - Guatemalteco',
                'Guiana - Guianês',
                'Guiana Francesa - Guianense',
                'Haiti - Haitiano',
                'Honduras - Hondurenho',
                'Jamaica - Jamaicano',
                'México - Mexicano',
                'Nicarágua - Nicaraguense',
                'Panamá - Panamenho',
                'Paraguai - Paraguaio',
                'Peru - Peruano',
                'Porto Rico - Portorriquenho',
                'República Dominicana - Dominicana',
                'São Cristóvão e Nevis - São-cristovense',
                'São Vicente e Granadinas - São-vicentino',
                'Santa Lúcia - Santa-lucense',
                'Suriname - Surinamês',
                'Trinidad e Tobago - Trindadense',
                'Uruguai - Uruguaio',
                'Venezuela - Venezuelano',
                'Alemanha - Alemão',
                'Áustria - Austríaco',
                'Bélgica - Belga',
                'Croácia - Croata',
                'Dinamarca - Dinamarquês',
                'Eslováquia - Eslovaco',
                'Eslovênia - Esloveno',
                'Espanha - Espanhol',
                'França - Francês',
                'Grécia - Grego',
                'Hungria - Húngaro',
                'Irlanda - Irlandês',
                'Itália - Italiano',
                'Noruega - Noruego',
                'Países Baixos - Holandês',
                'Polônia - Polonês',
                'Portugal - Português',
                'Reino Unido - Britânico',
                'Inglaterra - Inglês',
                'País de Gales - Galês',
                'Escócia - Escocês',
                'Romênia - Romeno',
                'Rússia - Russo',
                'Sérvio - Sérvio',
                'Suécia - Sueco',
                'Suíça - Suíço',
                'Turquia - Turco',
                'Ucrânia - Ucraniano',
                'Estados Unidos - Americano',
                'Canadá - Canadense',
                'Angola - Angolano',
                'Moçambique - Moçambicano',
                'África do Sul - Sul-africano',
                'Zimbabue - Zimbabuense',
                'Argélia - Argélia',
                'Comores - Comorense',
                'Egito - Egípcio',
                'Líbia - Líbio',
                'Marrocos - Marroquino',
                'Gana - Ganés',
                'Quênia - Queniano',
                'Ruanda - Ruandês',
                'Uganda - Ugandense',
                'Botsuana - Bechuano',
                'Costa do Marfim - Marfinense',
                'Camarões - Camaronense',
                'Nigéria - Nigeriano',
                'Somália - Somali',
                'Austrália - Australiano',
                'Nova Zelândia - Neozelandês',
                'Afeganistão - Afegão',
                'Arábia Saudita - Saudita',
                'Armênia - Armeno',
                'Armeno - Bangladesh',
                'China - Chinês',
                'Coréia do Norte - Norte-coreano, coreano',
                'Coréia do Sul - Sul-coreano, coreano',
                'Índia - Indiano',
                'Indonésia - Indonésio',
                'Iraque - Iraquiano',
                'Irã - Iraniano',
                'Israel - Israelita',
                'Japão - Japonês',
                'Malásia - Malaio',
                'Nepal - Nepalês',
                'Omã - Omanense',
                'Paquistão - Paquistanês',
                'Palestina - Palestino',
                'Qatar - Qatarense',
                'Síria - Sírio',
                'Sri Lanka - Cingalês',
                'Tailândia - Tailandês',
                'Timor-Leste - Timorense, maubere',
                'Emirados Árabes Unidos - Árabe, emiratense',
                'Vietnã - Vietnamita',
                'Iêmen - Iemenita'
            ];

        //$scope.steps = ['Leitura', 'Dados Pessoais', 'Dados Eleitorais', 'Pré-filiação', 'Dados Adicionais'];
        $scope.step = 0;

        $scope.isCurrentStep = function(step) {
            return $scope.step === step;
        };

        $scope.setCurrentStep = function(step) {
            $scope.step = step;
        };

        $scope.getCurrentStep = function() {
            return $scope.steps[$scope.step].name;
        };

        $scope.isFirstStep = function() {
            return $scope.step === 0;
        };

        $scope.isLastStep = function() {
            var len = jQuery.map($scope.steps, function(n, i) { return i; }).length;
            return $scope.step === (len - 1);
        };

        $scope.getNextLabel = function() {
            return ($scope.isLastStep()) ? 'Finalizar' : 'Próximo';
        };

        $scope.moveTopScroll = function () {
            jQuery('html, body').animate({
                scrollTop: jQuery(".container-filiacao").offset().top
            }, 500);
        };

        $scope.handlePrevious = function() {
            $scope.steps[$scope.step].status = 'todo';
            if ($scope.isFirstStep()) {
                $scope.step -= 0;
            } else {
                $scope.step -= 1;
            }
            $scope.steps[$scope.step].status = 'doing';
            $scope.moveTopScroll();
        };

        $scope.handleBack = function() {
            $scope.registro_ja_afiliado = false;
            $scope.registro_ja_passaporte = false;
            $scope.enviado_falha = false;
            $scope.moveTopScroll();
        };

        $scope.handleNext = function(dismiss) {

            if($scope.isLastStep()) {
                dismiss();
                _gaq.push(['_trackEvent', 'Filiação', 'Concluiu passo', $scope.steps[$scope.step].name]);
            } else {
                $scope.moveTopScroll();
                _gaq.push(['_trackEvent', 'Filiação', 'Concluiu passo', $scope.steps[$scope.step].name]);
                $scope.steps[$scope.step].status = 'done';
                $scope.step += 1;
                $scope.steps[$scope.step].status = 'doing';
            }
        };

        $scope.isUnchanged = function(filiado) {
            return ng.equals(filiado, $scope.master);
        };

        $scope.carregaEndereco = function () {
            var cep = $scope.filiado.cep;

            jQuery.ajax({type:'GET', url:'http://cep.correiocontrol.com.br/'+cep+'.json'})
            .done(function(data) {
                $scope.filiado.endereco = data.logradouro;
                $scope.filiado.bairro = data.bairro;
                $scope.filiado.cidade = data.localidade;
                $scope.filiado.uf = data.uf;
                jQuery('#numero').focus();
            });

        };

        $scope.validaValor = function () {
            $scope.filiado.contribuicao_mais = 'N';
        };

        $scope.saveFiliado = function () {

            var filiado = $scope.filiado,
                areasInteresse = new Array,
                atuacoesProfissionais = new Array;

            if(window.WP_USER_ID && window.WP_EMAIL) {
                filiado.user_id = WP_USER_ID;
                filiado.email = WP_EMAIL;

                call_rest_filiacao();
            } else {
                var data = new FormData();
                data.append('email', filiado.email);

                jQuery.ajax({
                    type: "POST",
                    contentType: 'application/json',
                    url: PASSPORT_PATH+'/registration',
                    data: JSON.stringify({
                        'email': filiado.email
                    }),
                    headers: {          
                        "Accept": "application/json",
                        "Content-Type": "application/json"   
                    },
                    crossDomain: true
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                    $scope.registro_erro = true;
                })
                .done(function (data, textStatus) {
                        console.log('filiado:', filiado);
                        console.log('data:', data, textStatus);

                        if(!data.passaporte && !data.afiliado) {
                            $scope.$apply(function(){
                                filiado.user_id = data.idUser;

                                $scope.registro_sucesso = true;
                                $scope.registro_ja_afiliado = false;
                                $scope.registro_ja_passaporte = false;

                                call_rest_filiacao();
                            });
                        } else if (data.afiliado) {
                            $scope.$apply(function() {
                                $scope.registro_ja_afiliado = true;
                                $scope.registro_sucesso = false;
                                $scope.registro_ja_passaporte = false;

                            })
                        } else if (data.passaporte) {
                            $scope.$apply(function () {
                                $scope.registro_ja_passaporte = true;
                                $scope.registro_ja_afiliado = false;
                                $scope.registro_sucesso = false;
                            })
                        }

                        
                        window.scrollTo(0, 0);
                });
            }

            function call_rest_filiacao() {
                // jQuery.each(filiado.areasInteresse, function(key, element) {
                //     areasInteresse.push(element.id);
                // });

                // jQuery.each(filiado.atuacoesProfissionais, function(key, element) {
                //     atuacoesProfissionais.push(element.id);
                // });

                delete filiado.contribuicao_mais;
                // delete filiado.areasInteresse;
                // delete filiado.atuacoesProfissionais;
                delete filiado.enviado_sucesso;

                // filiado.areasInteresse = areasInteresse;
                // filiado.atuacoesProfissionais = atuacoesProfissionais;
                //$scope.enviado_sucesso = true;
                // $http.post( API_PATH+'/usuario/filiado',  filiado).
                // success(function (data, status, headers, config) {
                //     $scope.enviado_sucesso = true;
                // }).
                // error(function (data, status, headers, config) {
                //     $scope.enviado_falha = false;
                // });
                
                jQuery.ajax({
                    type: "POST",
                    processData: false,
                    url: API_PATH+'/usuario/filiado',
                    data: JSON.stringify(filiado),
                    contentType: 'application/json',
                    dataType: 'json',
                    crossDomain: true
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                     $scope.$apply(function(){
                        $scope.enviado_falha = true;
                    });
                    
                    console.log(jqXHR, textStatus, errorThrown);
                })
                .done(function (data, textStatus) {
                        console.log('filiado:', filiado);
                        console.log('data:', data, textStatus);
                        $scope.$apply(function(){
                            $scope.enviado_sucesso = true;
                        });
                        window.scrollTo(0, 0);
                });
            }
        }
    }]);

    conexaoRedeApp.controller('SejaConectadoForm', ['$scope', '$http', 'storage',
        function SejaConectadoForm($scope, $http, storage) {

            $http.defaults.useXDomain = true;
            delete $http.defaults.headers.common['X-Requested-With'];

            $scope.master= {};
            $scope.filiado= {};

            storage.bind($scope,'filiado');

            $scope.steps = [
                {'name': 'Dados Pessoais',   'id': '1', 'status': 'todo'}
            ];

            

        //$scope.steps = ['Leitura', 'Dados Pessoais'];
        $scope.step = 0;

        $scope.isCurrentStep = function(step) {
            return $scope.step === step;
        };

        $scope.setCurrentStep = function(step) {
            $scope.step = step;
        };

        $scope.getCurrentStep = function() {
            return $scope.steps[$scope.step].name;
        };

        $scope.isFirstStep = function() {
            return $scope.step === 0;
        };

        $scope.isLastStep = function() {
            var len = jQuery.map($scope.steps, function(n, i) { return i; }).length;
            return $scope.step === (len - 1);
        };

        $scope.getNextLabel = function() {
            return ($scope.isLastStep()) ? 'Finalizar' : 'Próximo';
        };

        $scope.moveTopScroll = function () {
            jQuery('html, body').animate({
                scrollTop: jQuery(".container-filiacao").offset().top
            }, 500);
        };

        $scope.handlePrevious = function() {
            $scope.steps[$scope.step].status = 'todo';
            if ($scope.isFirstStep()) {
                $scope.step -= 0;
            } else {
                $scope.step -= 1;
            }
            $scope.steps[$scope.step].status = 'doing';
            $scope.moveTopScroll();
        };

        $scope.handleBack = function() {
            $scope.registro_ja_afiliado = false;
            $scope.registro_ja_passaporte = false;
            $scope.enviado_falha = false;
            $scope.moveTopScroll();
        };

        $scope.handleNext = function(dismiss) {

            if($scope.isLastStep()) {
                dismiss();
                _gaq.push(['_trackEvent', 'Filiação', 'Concluiu passo', $scope.steps[$scope.step].name]);
            } else {
                $scope.moveTopScroll();
                _gaq.push(['_trackEvent', 'Filiação', 'Concluiu passo', $scope.steps[$scope.step].name]);
                $scope.steps[$scope.step].status = 'done';
                $scope.step += 1;
                $scope.steps[$scope.step].status = 'doing';
            }
        };

        $scope.isUnchanged = function(filiado) {
            return ng.equals(filiado, $scope.master);
        };

        $scope.saveFiliado = function () {

            var filiado = $scope.filiado;

            var data = new FormData();
            data.append('email', filiado.email);

            jQuery.ajax({
                type: "POST",
                contentType: 'application/json',
                url: PASSPORT_PATH+'/registration',
                data: JSON.stringify({
                    'email': filiado.email
                }),
                headers: {          
                    "Accept": "application/json",
                    "Content-Type": "application/json"   
                },
                crossDomain: true
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
                $scope.registro_erro = true;
            })
            .done(function (data, textStatus) {
                    console.log('filiado:', filiado);
                    console.log('data:', data, textStatus);

                    if(!data.passaporte && !data.afiliado) {
                        $scope.$apply(function(){
                            filiado.user_id = data.idUser;

                            $scope.enviado_sucesso = true;

                            $scope.registro_sucesso = true;
                            $scope.registro_ja_afiliado = false;
                            $scope.registro_ja_passaporte = false;

                        });
                    } else if (data.afiliado) {
                        $scope.$apply(function() {
                            $scope.registro_ja_afiliado = true;
                            $scope.registro_sucesso = false;
                            $scope.registro_ja_passaporte = false;

                        })
                    } else if (data.passaporte) {
                        $scope.$apply(function () {
                            $scope.registro_ja_passaporte = true;
                            $scope.registro_ja_afiliado = false;
                            $scope.registro_sucesso = false;
                        })
                    }

                    
                    window.scrollTo(0, 0);
            });
        }
    }]);

    return conexaoRedeApp;

});
