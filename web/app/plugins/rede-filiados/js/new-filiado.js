jQuery(document).ready(function() {
    // Show hide from QUER_SER_CANDIDATO
    jQuery('input[type=radio][name=quer_ser_candidato]').change(function() {
        if (this.value == 'S') {
            jQuery('.quer_ser_candidato_child').show();
            jQuery('.quer_ser_candidato_child input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.quer_ser_candidato_child').hide();
            jQuery('.quer_ser_candidato_child input').prop('required', false);
        }
    });

    // Show hide from QUER_SER_CANDIDATO
    jQuery('input[type=radio][name=filiado_partido]').change(function() {
        if (this.value == 'S') {
            jQuery('.filiado_partido_quais').show();
            jQuery('.filiado_partido_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.filiado_partido_quais').hide();
            jQuery('.filiado_partido_quais input').prop('required', false);
        }
    });

    // Show hide from FOI_CANDIDATO
    jQuery('input[type=radio][name=foi_candidato]').change(function() {
        if (this.value == 'S') {
            jQuery('.foi_candidato_quais').show();
            jQuery('.foi_candidato_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.foi_candidato_quais').hide();
            jQuery('.foi_candidato_quais input').prop('required', false);
        }
    });
    
    // Show hide from ATUAL_ANTERIOR_ELEITO
    jQuery('input[type=radio][name=atual_anterior_eleito]').change(function() {
        if (this.value == 'S') {
            jQuery('.atual_anterior_eleito_quais').show();
            jQuery('.atual_anterior_eleito_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.atual_anterior_eleito_quais').hide();
            jQuery('.atual_anterior_eleito_quais input').prop('required', false);
        }
    });
    
    // Show hide from CARGO_CONFIANCA
    jQuery('input[type=radio][name=cargo_confianca]').change(function() {
        if (this.value == 'S') {
            jQuery('.cargo_confianca_quais').show();
            jQuery('.cargo_confianca_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.cargo_confianca_quais').hide();
            jQuery('.cargo_confianca_quais input').prop('required', false);
        }
    });


    // Show hide from CARGO_CONFIANCA
    jQuery('input[type=radio][name=ativista]').change(function() {
        if (this.value == 'S') {
            jQuery('.ativista_quais').show();
            jQuery('.ativista_quais input').prop('required', true);
        }
        else if (this.value == 'N') {
            jQuery('.ativista_quais').hide();
            jQuery('.ativista_quais input').prop('required', false);
        }
    });
});