jQuery(document).ready(function() {
    // Show hide from QUER_SER_CANDIDATO
    jQuery('input[type=radio][name=quer_ser_candidato]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.quer_ser_candidato_child').show();
            jQuery('.quer_ser_candidato_child input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.quer_ser_candidato_child').hide();
            jQuery('.quer_ser_candidato_child input').prop('required', false);
        }
    }).trigger('change');

    // Show hide from QUER_SER_CANDIDATO
    jQuery('input[type=radio][name=filiado_partido]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.filiado_partido_quais').show();
            jQuery('.filiado_partido_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.filiado_partido_quais').hide();
            jQuery('.filiado_partido_quais input').prop('required', false);
        }
    }).trigger('change');

    // Show hide from FOI_CANDIDATO
    jQuery('input[type=radio][name=foi_candidato]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.foi_candidato_quais').show();
            jQuery('.foi_candidato_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.foi_candidato_quais').hide();
            jQuery('.foi_candidato_quais input').prop('required', false);
        }
    }).trigger('change');
    
    // Show hide from ATUAL_ANTERIOR_ELEITO
    jQuery('input[type=radio][name=atual_anterior_eleito]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.atual_anterior_eleito_quais').show();
            jQuery('.atual_anterior_eleito_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.atual_anterior_eleito_quais').hide();
            jQuery('.atual_anterior_eleito_quais input').prop('required', false);
        }
    }).trigger('change');
    
    // Show hide from CARGO_CONFIANCA
    jQuery('input[type=radio][name=cargo_confianca]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.cargo_confianca_quais').show();
            jQuery('.cargo_confianca_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.cargo_confianca_quais').hide();
            jQuery('.cargo_confianca_quais input').prop('required', false);
        }
    }).trigger('change');


    // Show hide from CARGO_CONFIANCA
    jQuery('input[type=radio][name=ativista]').on('change', function() {
        if (this.value == 'S' && this.checked) {
            jQuery('.ativista_quais').show();
            jQuery('.ativista_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.ativista_quais').hide();
            jQuery('.ativista_quais input').prop('required', false);
        }
    }).trigger('change');

    // Show hide from TIPO (COBRANÇA)
    jQuery('input[type=radio][name=tipo]').on('change', function() {
        if (this.value == 'cartao-credito' && this.checked) {
            jQuery('#tipo-cartao-credito').show();
        }
        else if (this.value == 'boleto' && this.checked) {
            jQuery('#tipo-cartao-credito').hide();
        }
    }).trigger('change');



    //Birthday MASK
    jQuery.datetimepicker.setLocale('pt-BR');
    if(jQuery("input[name='birthday-formatted']").val().indexOf('-') > -1) {
        jQuery("input[name='birthday-formatted']").val(destroyMaskUS(jQuery("input[name='birthday-formatted']").val())).trigger('change');
    }
    jQuery("input[name='birthday-formatted']").datetimepicker({
        format:'d/m/Y',
        timepicker:false,
        mask: true
    });
    jQuery("input[name='birthday-formatted']").on("keyup change", function(){
        jQuery("input[name='birthday']").val(destroyMask(this.value));
    }).trigger('change');

    function createMask(string){
        return string.replace(/(\d{2})(\d{2})(\d{4})/,"$1/$2/$3");
    }

    function destroyMask(string) {
        return string.replace(/(\d{2})\/(\d{2})\/(\d{4})/,"$3-$2-$1");
    }

    function destroyMaskUS(string) {
        return string.replace(/(\d{4})-(\d{2})-(\d{2})/,"$3/$2/$1");
    }


    jQuery.mask.definitions['~']='[+-]';

	//Inicio Mascara Telefone
	jQuery('input[type=tel]').on("focusout", function(){
		var phone, element;
		element = jQuery(this);
		element.unmask();
		phone = element.val().replace(/\D/g, '');
		if(phone.length > 10) {
			element.mask("(99) 99999-999?9");
		} else {
			element.mask("(99) 9999-9999?9");
		}
	}).trigger('focusout');
	//Fim Mascara Telefone
	jQuery("input[name=cpf]").mask("999.999.999-99");
	jQuery("input[name=cartao_numero]").mask("9999 9999 9999 9999");

    jQuery("#contribuicao-formatted").maskMoney({
         prefix: "R$:",
         decimal: ",",
         thousands: ""
     });

     jQuery("#contribuicao-formatted").on("keyup change", function(){
        var withoutf = this.value.replace(/[^\d,]+/g,"").replace(",",".");
        jQuery('#contribuicao').val(withoutf);
     });
    


});