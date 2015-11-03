/**
 * loads sub modules and wraps them up into the main module
 * this should be used for top-level module definitions only
 */
define([
    'spinjs',
    'jquery',
    'jValAdicional'
], function (Spinner, jQuery) {
    "use strict";

    var sideTabs  = {

      init: function(){

          if( jQuery('.side-tabs').length > 0 ){

              sideTabs.formValidade();
              sideTabs.events.verticalPosition();
              sideTabs.events.containerSize();
              sideTabs.events.questionsClick();
              sideTabs.events.tabsClick();
          }

      },

      formValidade: function(){

        jQuery('#sugestion-form').validate({

            submitHandler: function(form) {

            // do other things for a valid form
            jQuery(form).on('submit', function (e) { e.preventDefault(); });

            jQuery.ajax({

              url:THEME_URL + '/registro-sugestao/index.php',
              type:'POST',
              data : jQuery(form).serialize(),

              beforeSend: function () {

                var target = form;

                target.innerHTML = '';
                var spinner = new Spinner().spin(target);
              }

            }).done(function (data) {

              var msg = '';

              data = JSON.parse(data);

              if( data.status ){
                msg = 'Sugestão enviada com sucesso!';
              }else{
                msg = 'Sugestão não foi enviada. Tente novamente mais tarde';
              }
                jQuery('#sugestion-form').html('<p>' + msg + '</p>');

              // alert('Sugestão enviada com sucesso!');

              // jQuery('#sugestion-form').find('input').val('');
              // jQuery('#sugestion-form').find('textarea').val('');
              // jQuery('#sugestion-form').find('.input-submit').val('Contribuir');

            });

          },
          rules: {
            name: {
              required:true,
              minlength: 3
            },
            email: {
              required:true,
              email: true
            },
            message: {
              required:true
            }
          },
          messages: {
            name: {
              required:'Preenchimento obrigatório desse campo.',
              minlength:'Preenchimento mínimo de 3 caracteres'
            },
            email: {
              required:'Preenchimento obrigatório desse campo.',
              email:'Preenchimento com email válido.'
            },
            message: {
              required:'Preenchimento obrigatório desse campo.'
            }
          }
        })
      },

      events: {

        tabsClick: function(){

          jQuery('.side-tabs').delegate('.btn-side-tabs', 'click', function(){
            jQuery(this).closest('.side-tabs').toggleClass('close');
          });

          jQuery('.side-tabs').delegate('.tabs-opt', 'click', function(){

              if( jQuery(this).closest('.side-tabs').hasClass( jQuery(this).attr('data-name') + '-active') ){

                  jQuery(this).closest('.side-tabs').toggleClass('close');

              }else{

                  jQuery(this).closest('.side-tabs').removeClass('close');

                  jQuery(this).closest('.side-tabs').removeClass('faq-active');
                  jQuery(this).closest('.side-tabs').removeClass('sugestions-active');

                  jQuery(this).closest('.side-tabs').addClass( jQuery(this).attr('data-name') + '-active');

              }

          });

        },

        verticalPosition: function(){

            return '35px';

          //jQuery(window).scroll(function(){

            //var srollPosition = jQuery(window).scrollTop();

            //jQuery('.side-tabs').find('.faq').stop().animate({
              //"marginTop": ( srollPosition ) + "px"
            //}, "slow");

            //jQuery('.side-tabs').find('.sugestions').stop().animate({
              //"marginTop": ( srollPosition ) + "px"
            //}, "slow");

            //jQuery(".tabs").stop().animate({
              //"marginTop": ( ( srollPosition + 288 ) ) + "px"
            //}, "slow");

          //});

        },

        containerSize: function(){

          if( jQuery('body').height() > jQuery('.side-tabs').height() ){
              //jQuery('.side-tabs').css('height', jQuery('body').height() + 'px');
              jQuery('.side-tabs').css('position', 'fixed');
              jQuery('.side-tabs').css('top', '0');
              jQuery('.side-tabs').css('bottom', '0');
          }

        },

        questionsClick: function(){

          jQuery('.side-tabs').delegate('.question', 'click', function(){
              jQuery(this).parent('.item').toggleClass('open');
          });

        }
      }
    };

    return sideTabs;

});
