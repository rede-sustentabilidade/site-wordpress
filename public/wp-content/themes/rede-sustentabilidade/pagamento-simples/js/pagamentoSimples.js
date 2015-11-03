(function ($) {

function initPagamentoSimples() {
  $('.PS_div_opPgto').click(mudaForma);
  $('#ipt_tipoDoacao').click(dadosPessoais);
  $('#btn_doacao').click(enviaDoacao);
  mudaForma();
  dadosPessoais();
}

function mudaForma(){
  $('#opcoesCartaoCredito').css('display', $('#frmOpcaoPagamento input:checked').val()==='boleto'?'none':'block');
}

function dadosPessoais(){
  $('#dados_pessoais div').css('display',  $('#ipt_tipoDoacao:checked').size()?'none':'block');
}

function enviaDoacao() {
        /* Requisita a construação do div com os dados */
        var xmlhttp=new XMLHttpRequest();

        xmlhttp.open('POST',THEME_URL + '/pagamentoSimples/criaDiv.php',false);
        xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
        xmlhttp.onreadystatechange=function() {
            if (xmlhttp.readyState===4 && xmlhttp.status===200) {
                $('#div_ajax').html(xmlhttp.responseText);

                var settings ;
                if($('#frmOpcaoPagamento input:checked').val()==='boleto')
                    settings = { 'Forma': 'BoletoBancario' };
                else {
                    var cc_expir = [$('#cc_month').val(), $('#cc_year').val()];
                    settings = {
                        'Forma': 'CartaoCredito',
                        'Instituicao': $('#frmOpcaoPagamento input:checked').val(),
                        'Parcelas': '1',
                        'Recebimento': 'AVista',
                        'CartaoCredito': {
                            'Numero': $('#cc_number').val(),
                            'Expiracao': cc_expir.join('/'),
                            'CodigoSeguranca': $('#cc_code').val(),
                            'Portador': {
                                'Nome': $('#ipt_cc_nome').val(),
                                'DataNascimento': $('#ipt_nascimento').val(),
                                'Telefone': $('#ipt_telefone').val(),
                                'Identidade': $('#ipt_cpf').val()
                            }
                        }
                    };
                }
                console.log(settings);
                MoipWidget(settings);
            }
        };
        /* Faz a chamada, avisando do valor a ser pago */
         xmlhttp.send( montaQueryPesquisa() );
}

/*Cria query pesquisando todos os inputs que tenha 'ibol', comando o cuidado de se substutuir os espaços por '+' */
function montaQueryPesquisa() {
    var qryItm = [],
        inputs = $('input[ibol]');
    for(var x=0; x<inputs.size(); x++) {
        var val = [];
        val.push(inputs[x].id.substring(4));
        val.push((inputs[x].type.toLowerCase() === 'checkbox' )?inputs[x].checked:inputs[x].value);
        qryItm.push(val.join('='));
    }
    qry = qryItm.join('&').replace(/\s/g, '+');
    console.log(qry);
    return qry;
}

function funcaoSucesso(data){
    alert('Sucesso\n' + JSON.stringify(data));
    if($('#frmOpcaoPagamento input:checked').val()==='boleto')
        window.open(data.url);
};

function funcaoFalha(data) {
    alert('Falha\n' + JSON.stringify(data));
};


document.onload = initPagamentoSimples();
})(jQuery);