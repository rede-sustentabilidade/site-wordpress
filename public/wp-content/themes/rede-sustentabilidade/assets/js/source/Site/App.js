define([
    'magnificPopup',
    'Site/sideTabs',
    'Site/sidebarWidget',
    // 'Site/DoacaoForm',
    // 'Site/DesafioForm',
    'Site/redesign',
    'masonry',
    'imagesloaded'
], function (jQuery, sideTabs, sidebarWidget, redesign, Masonry, imagesLoaded) { // DoacaoForm, DesafioForm,
    "use strict";

    var App = {
        init : function () {
            jQuery(document).ready(function () {

                if (jQuery('#sidebar-viral').length > 0){
                    var sidebar = new sidebarWidget(jQuery('#sidebar-viral'));
                    sidebar.init();
                }

                var re = new redesign();
                re.init();

                if ( (typeof document.forms['doacao']) !== 'undefined'){
                    var doe = new DoacaoForm();
                    doe.init(document.forms['doacao']);
                }

                if ( (typeof document.forms['desafio']) !== 'undefined'){
                    var desafio = new DesafioForm();
                    desafio.init(document.forms['desafio']);
                }

                //jQuery('#post-area').masonry('destroy');
                jQuery('.fazer-conexao a.popup').magnificPopup({
                    type: 'inline',
                    closeBtnInside:true,
                    modal: true
                });

                jQuery(document).on('click', '.popup-modal-dismiss', function (e) {
                  e.preventDefault();
                  jQuery.magnificPopup.close();
                });

                jQuery('.fazer-conexao').on('mouseenter', function () {
                    jQuery('.dropdown').fadeIn();
                });

                jQuery('.dropdown').on('mouseleave', function () {
                    jQuery('.dropdown').hide();
                });

                jQuery('.box-visualizacao > .lista').click(function() {
                    jQuery('.box-visualizacao > a').removeClass('active');
                    jQuery(this).addClass('active');
                    jQuery('#post-area').masonry('destroy');
                    jQuery('#post-area').addClass('lista');
                    jQuery('.post').addClass('masonry-brick');
                    return false
                });

                jQuery('.box-visualizacao > .quadros').click(function() {
                    jQuery('.box-visualizacao > a').removeClass('active');
                    jQuery(this).addClass('active');
                    jQuery('#post-area').removeClass('lista');
                    jQuery('#post-area').addClass('blocos');
                    jQuery('#post-area').masonry({
                // options…
                isAnimated: true,
                animationOptions: {
                    duration: 400,
                    easing: 'linear',
                    queue: false
                }
                });
                    return false
                });

                jQuery('.hastip').click(function(){
                    jQuery('.more').show();
                    jQuery('.questao').hide();
                    var $hastipContent = jQuery(this).find('p').clone();
                    jQuery('.more > .content').html($hastipContent);
                });

                jQuery('.more > .volta').click(function(){
                    jQuery('.more').hide();
                    jQuery('.questao').show();
                });

                // tip que ficava para sugestao de cores no logo, nao existe mais e foi comentado
                // jQuery('.hastip-login').tooltipsy({
                // //offset: [0,-1]
                // className : 'tooltipsy-login'
                // });


                // Side Tabs
                sideTabs.init();

                //----- Desafios -----//

                jQuery('.category').click(function(){
                    jQuery('.question').show();
                });

                jQuery('.content a').click(function(){
                    jQuery('.video').slideDown();
                    jQuery(this).hide();
                });

                jQuery('.video a').click(function(){
                    jQuery('.video').slideUp();
                    jQuery('.content a').show();
                });

                /* General Pinbin Functions
                  ================================================== */

                // masonry customization
                var container = document.querySelector('#post-area');
                var msnry;
                // initialize Masonry after all images have loaded
                if ( (container != null) && (jQuery(container).length > 0)) {
                    imagesLoaded( container, function() {
                        msnry = new Masonry( container, {
                            columnWidth: 318,
                            isAnimated: true,
                            animationOptions: {
                                duration: 400,
                                easing: 'linear',
                                queue: false
                            }
                        });
                    });
                }
            });
          /* Mobile Navigation
================================================== */
jQuery(function(e){e(document).ready(function(){e("<select />").appendTo(".main-nav");e("<option />",{selected:"selected",value:"",text:"Navegue pelo site..."}).appendTo(".main-nav select");e(".main-nav ul.menu li a").each(function(){var t=e(this);var n="";for(var r=0;r<t.parentsUntil("div > ul").length-1;r++)n+="–";e("<option />",{value:t.attr("href"),html:n+t.text()}).appendTo(".main-nav select")});e(".main-nav select").change(function(){window.location=e(this).find("option:selected").val()})})})
        }
    };

    return App;

});
