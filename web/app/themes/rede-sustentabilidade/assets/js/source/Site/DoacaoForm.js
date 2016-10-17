define(['accounting', 'jValAdicional', 'inputmask','cookie','spinjs','sharrre', 'magnificPopup', 'tooltipsy', 'Site/plugins'],
function (accounting, jQuery) {

		function DoacaoForm () {

		}

		DoacaoForm.prototype.init = function (form) {

			this.$form = jQuery(form);

			this.$donationInput = this.$form.find('input#ipt_contribuicao');
			this.$paymentMethods = this.$form.find('.formas-pagamento');
			this.$creditCardDetails = this.$form.find('.dados-do-cc');
			this.paymentMethod = 'boleto'; //input starts checked
			
			var self = this;
			var m = jQuery('#popup-modal').magnificPopup({
				type: 'inline',
				closeBtnInside:true,
				modal: true
			});

			jQuery(document).on('click', ".fechar", function (e) {
				e.preventDefault();
				m.close();
			});

			jQuery(document).on('click', ".encerrar", function (e) {
				e.preventDefault();
				window.location.reload();
			});

			
			//jQuery('.popup-modal').trigger('click');
			////// inicializa plugin de validacao de formulario
			this.$form.validate({
				// errorContainer: containerErrors,
				// errorLabelContainer: jQuery("ol", containerErrors),
				// wrapper: 'li',

				submitHandler: function(form) {

					// do other things for a valid form
					jQuery(form).on('submit', function (e) { e.preventDefault(); });
					jQuery.ajax({
						url:THEME_URL + '/pagamento-simples/criaDiv.php',
						type:'POST',
						data : jQuery(form).serialize(),
						async: false,
						beforeSend: function () {
							jQuery('#test-modal').html('Carregando...');
							m.magnificPopup('open');
						}
					}).done(function (data) {
						jQuery('#div_ajax').html(data);
						var settings ;
		                if(jQuery(form).find('.formas-pagamento input:checked').val()==='boleto') {
		                    settings = { 'Forma': 'BoletoBancario' };
		                } else {
		                    var cc_expir = [jQuery('#cc_month').val(), jQuery('#cc_year').val()];
		                    settings = {
		                        'Forma': 'CartaoCredito',
		                        'Instituicao': jQuery('.formas-pagamento input:checked').val(),
		                        'Parcelas': '1',
		                        'Recebimento': 'AVista',
		                        'CartaoCredito': {
		                            'Numero': jQuery('#cc_number').val(),
		                            'Expiracao': cc_expir.join('/'),
		                            'CodigoSeguranca': jQuery('#cc_code').val(),
		                            'Portador': {
		                                'Nome': jQuery('#ipt_cc_nome').val(),
		                                'DataNascimento': jQuery('#ipt_nascimento').val(),
		                                'Telefone': jQuery('#ipt_bln_add_phone').val(),
		                                'Identidade': jQuery('#ipt_cpf').val()
		                            }
		                        }
		                    };
		                }
		                //console.log(settings);
		                MoipWidget(settings);
					});
				},
				rules: {
					cc_selection: {
						required:true
					},
					ipt_contribuicao: {
						required:true,
						number:true
					},
					ipt_bln_name: {
						required: true,
						minlength: 5
					},
					ipt_bln_email: {
						required: true,
						email: true
					},
					ipt_cpf: {
						required: true,
						minlength: 11,
						cpf: {cpf:true}
					},
					ipt_nascimento: {
						required: true,
						minlength: 10
					},
					ipt_bln_add_zipCode: {
						required: true,
						minlength: 9
					},
					ipt_bln_add_address: {
						required: true
					},
					ipt_bln_add_number: {
						required: true,
						number:true
					},
					ipt_bln_add_neighborhood: {
						required: true
					},
					ipt_bln_add_city: {
						required: true
					},
					ipt_bln_add_state: {
						required: true,
						minlength: 2
					},
					ipt_bln_add_phone: {
						required: true
					},
					ipt_cc_nome: { 
						required: { depends: this.isCreditCard },
					},
					cc_number : {
						required: { depends: this.isCreditCard },
						creditcard: { depends: this.isCreditCard }
					},
					cc_month : {
						required: { depends: this.isCreditCard }
					},
					cc_year: {
						required: { depends: this.isCreditCard }
					},
					cc_code: {
						required: { depends: this.isCreditCard }
					}
				},
				messages: {
					ipt_contribuicao: {
						required:'Informe o valor da doação.',
						number:'Permitido apenas números.'
					},
					ipt_bln_name: {
						required: 'Nome é obrigatório.',
						minlength: 'Nome deve conter ao menos 5 caracteres.'
					},
					ipt_bln_email: {
						required: 'E-mail é obrigatório.',
						email: 'E-mail inválido.'
					},
					ipt_cpf: {
						required: 'CPF é obrigatório.',
						minlength: 'CPF deve conter 11 caracteres.'
					},
					ipt_nascimento: {
						required: 'Data de nascimento é obrigatório.',
						minlength: 'Deve conter 10 caracteres.'
					},
					ipt_bln_add_zipCode: {
						required: 'CEP é obrigatório.',
						minlength: 'Deve conter 9 caracteres.'
					},
					ipt_bln_add_address : {
						required: 'Endereço é obrigatório.'
					},
					ipt_bln_add_number: {
						required: 'Número é obrigatório.',
						number: 'Deve conter apenas números.'
					},
					ipt_bln_add_neighborhood: {
						required: 'Bairro é obrigatório.',
					},
					ipt_bln_add_city: {
						required: 'Cidade é obrigatório.'
					},
					ipt_bln_add_state: {
						required: 'Estado é obrigatório.',
						minlength: 2
					},
					ipt_bln_add_phone : {
						required: 'Telefone é obrigatório.'
					},
					ipt_cc_nome: { 
						required: 'Nome impresso no cartão é obrigatório.'
					},
					cc_number : {
						required: 'Número do cartão é obrigatório.',
						creditcard: 'Número do cartão inválido.'
					},
					cc_month : {
						required: 'Mês de validade do cartão é obrigatório.'
					},
					cc_year: {
						required: 'Ano de validade do cartão é obrigatório.'
					},
					cc_code: {
						required: 'Código de Segurança do cartão é obrigatório.'
					}
				}
			});

			this.setMaskForm();

			/////// formata valor da doação
			this.$donationInput.on('keyup', function (e) {
				self.formatDonationValue();
			});
			this.formatDonationValue();

			/////// mostra ou esconde dados do cartao de credito
			this.$paymentMethods.find('input[name="cc_selection"]').on('click', function (e) {
				var el = this;
				self.toggleCreditCardDetails(el.value);
			});
		};

		DoacaoForm.prototype.isCreditCard = function () {
			if (this.paymentMethod === 'boleto') {
				return false;
			} else {
				return true;
			}
		}

		DoacaoForm.prototype.toggleCreditCardDetails = function (paymentMethod) {
			this.paymentMethod = paymentMethod;

			if (paymentMethod === 'boleto') {
				this.$creditCardDetails.hide();
				
			} else {
				this.$creditCardDetails.show();
			}
		};

		DoacaoForm.prototype.setMaskForm = function () {
			this.$form.find("input[name='ipt_cpf']").inputmask("999.999.999-99");
			this.$form.find("input[name='ipt_nascimento']").inputmask("d/m/y"); //,{ "placeholder": "dd/mm/yyyy" }
			this.$form.find("input[name='ipt_bln_add_zipCode']").inputmask("99999-999", { oncomplete: this.searchAddressDetailsByCEP});
			
			// var phones = [
			//         { "mask": "(11) # ####-####", "cc": "SP", "name_en": "São Paulo" },
			//         { "mask": "(21) # ####-####", "cc": "RJ", "name_en": "Rio de Janeiro"},
			//         { "mask": "(##) # ####-####", "cc": "AA", "name_en": "Todos"}
			// ];
			//this.$form.find("input[name='ipt_bln_add_phone']").inputmask({ mask: phones, definitions: { '#': { validator: "[0-9]", cardinality: 1}} });

			this.$form.find("input[name='ipt_bln_add_phone']").inputmask({ mask: "(99) 9 9999-9999"});
			
		};

		DoacaoForm.prototype.searchAddressDetailsByCEP = function (e) {
			var cep = e.currentTarget.value.replace('-','');
			
			jQuery.ajax({
				url: 'http://cep.correiocontrol.com.br/'+cep+'.json',
				dataType: 'json'
			}).done(function (data) {
				
				var $form = jQuery('form.form-doacao');
				$form.find('input[name="ipt_bln_add_address"]').val(data.logradouro);
				$form.find('input[name="ipt_bln_add_neighborhood"]').val(data.bairro);
				$form.find('input[name="ipt_bln_add_city"]').val(data.localidade);
				$form.find('input[name="ipt_bln_add_state"]').val(data.uf);
				$form.find('input[name="ipt_bln_add_number"]').focus();
			});
			///
		};

		DoacaoForm.prototype.formatDonationValue = function () {
			var formattedValue = accounting.formatMoney(this.$donationInput.val(), { symbol: "BRL",  format: "%v %s" });

			this.$form.find('.total-contribuicao span').html(formattedValue);
		};



		/*function correiocontrolcep(data) {
		{
			"Status":"EmAnalise",
			"Codigo":0,
			"CodigoRetorno":"",
			"TaxaMoIP":"0.69",
			"StatusPagamento":"Sucesso",
			"Classificacao":{"Codigo":999,"Descricao":"Não suportado no ambiente Sandbox"},
			"CodigoMoIP":176208,
			"Mensagem":"Requisição processada com sucesso",
			"TotalPago":"4.00",
			"url":"https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=V2E011N341B0L1Q1D1R8W398T1Q6Y9Y941I0G0N0Z0F0X0O4J1L518A4N3B0"} 
		}*/

		return DoacaoForm;
});