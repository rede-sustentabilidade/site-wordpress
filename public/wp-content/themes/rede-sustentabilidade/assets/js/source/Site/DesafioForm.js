define(['spinjs', 'jValAdicional', 'Site/plugins'],
function (Spinner, jQuery) {

    function DesafioForm() {
    }

    DesafioForm.prototype.init = function (form) {
        var self = this;
        this.$form = jQuery(form);

        jQuery('#btn_desafio').on('click', function (e) {
            e.preventDefault();

            self.$form.submit();
        });

        this.$form.validate({

            submitHandler: function(form) {

                // do other things for a valid form
                jQuery(form).on('submit', function (e) { e.preventDefault(); });
                jQuery.ajax({
                    url:THEME_URL + '/registro-desafio/index.php',
                    type:'POST',
                    data : jQuery(form).serialize(),
                    beforeSend: function () {
                        var target = document.getElementById('desafio-form');
                        target.innerHTML = '';
                        var spinner = new Spinner().spin(target);
                    }
                }).done(function (data) {
                    jQuery('#desafio-form').html(data);
                });
            },
            rules: {
                desafio_title: {
                    required:true
                },
                desafio_content: {
                    required:true
                }
            },
            messages: {
                desafio_title: {
                    required:'Preenchimento obrigatório desse campo.'
                },
                desafio_content: {
                    required:'Preenchimento obrigatório desse campo.'
                }
            }
        });
    };

    return DesafioForm;
});