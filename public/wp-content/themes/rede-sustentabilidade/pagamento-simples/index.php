<!doctype html>
<!-- 
	A primeira coisa que o admnistrador deve fazer é habilitar o uso de cartões de crédito. Não há a necessidade de configurar parcelamento.
	CASO ESSE CUIDADO NÃO SEJA TOMADO, NÃO TERÁ A OPÇÃO DE PAGAR VIA CARTÃO, OCASIONANDO ERRO AO SE TENTAR !!!
-->
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Pagamento simples</title>
		<script type="text/javascript" src="js/modernizr.js"></script>
		<link rel="stylesheet" type="text/css" href="css/pagamentoSimples.css">
	</head>
	
	<body language="pt-br">
		<section id="pagamentoSimples">
			<h2>Contribua conosco</h2>
			<div id="divValorPagamento">
				<span class="PSLabel">Valor da contribuição:</span>
				<input type="text" id="ipt_contribuicao" ibol >
			</div>		
			<div id="frmOpcaoPagamento">
				<div class="PS_div_frmPgto">
					<div id="boleto" class="PS_div_opPgto">
						<img src="img/flag_boleto.gif"/>
						<span class="PS_FrmPgto">Boleto</span>
						<input type="radio" name="cc_selection" value="boleto" checked/>
					</div>
				</div>
				<div class="PS_div_frmPgto">
					<div id="cc_visa" class="PS_div_opPgto">
						<img src="img/flag_visa.gif"/>
						<span class="PS_FrmPgto">Visa</span>
						<input type="radio" name="cc_selection" value="Visa"/>
					</div>
					<div id="cc_master" class="PS_div_opPgto">
						<img src="img/flag_mastercard.gif"/>
						<span class="PS_FrmPgto">Mastercard</span>
						<input type="radio" name="cc_selection" value="Mastercard"/>
					</div>
					<div id="cc_diners" class="PS_div_opPgto">
						<img src="img/flag_diners.gif"/>
						<span class="PS_FrmPgto">Diners</span>
						<input type="radio" name="cc_selection" value="Diners"/>
					</div>
					<div id="cc_amex" class="PS_div_opPgto">
						<img src="img/flag_amex.gif"/>
						<span class="PS_FrmPgto">Amex</span>
						<input type="radio" name="cc_selection" value="AmericanExpress"/>
					</div>
					<div id="cc_hipercard" class="PS_div_opPgto">
						<img src="img/flag_hipercard.gif"/>
						<span class="PS_FrmPgto">Hipercard</span>
						<input type="radio" name="cc_selection" value="Hipercard"/>
					</div>
				</div>
			</div>
			<div id="opcoesCartaoCredito">
				<div id="div_cc_number">
					<span>Número do cartão:</span>
					<input type="text" id="cc_number"/>
				</div>
				<div id="div_valid_until">
					<span>Validade</span>
					<select id="cc_month">
						<?php // Preenche com 12 meses do ano
						for ($x=1; $x<=12; $x++ ){
							printf("<option value=\"%d\">%d</option>", $x, $x);
						}
						?>
					</select>
					<select id="cc_year">
						<?php // 10 próximos anos
							$ano_atual = date("Y");
							for ($x=$ano_atual; $x<=$ano_atual+10; $x++ ){
								printf("<option value=\"%d\">%d</option>", $x, $x);
							}
						?>
					</select>
				</div>
				<div id="cc_security_code">
					<span>Código de Segurança:</span>
					<input type="text" maxlength="5" id="cc_code"/>
				</div>
				<div>
					<span>Nome impresso no cartão:</span>
					<input id="ipt_cc_nome" type="text"/>
				</div>
				<div>
					<span>Telefone:</span>
					<input id="ipt_telefone" type="text"/>
				</div>
				<div>
					<span>Nascimento:</span>
					<input id="ipt_nascimento" type="text"/>
				</div>
				<div>
					<span>CPF:</span>
					<input id="ipt_cpf" type="text"/>
				</div>
			</div>
			<div id="dados_pessoais">
				<input type="checkbox" value="anonima" id="ipt_tipoDoacao" ibol /> Doação anônima
				<div>
					<div>
						<span>Nome:</span>
						<input id="ipt_bln_name" type="text" ibol />
					</div>
					<div>
						<span>Email:</span>
						<input id="ipt_bln_email" type="text" ibol />
					</div>
					<div>
						<span>Endereço:</span>
						<input id="ipt_bln_add_address" type="text" ibol />
					</div>
					<div>
						<span>Número:</span>
						<input id="ipt_bln_add_number" type="text" ibol />
					</div>
					<div>
						<span>Complemento:</span>
						<input id="ipt_bln_add_complement"	type="text" ibol />
					</div>
					<div>
						<span>Bairro:</span>
						<input id="ipt_bln_add_neighborhood" type="text" ibol />
					</div>
					<div>
						<span>Cidade:</span>
						<input id="ipt_bln_add_city" type="text" ibol />
					</div>
					<div>
						<span>Estado:</span>
						<input id="ipt_bln_add_state" type="text" ibol />
					</div>
					<div>
						<span>Cep:</span>
						<input id="ipt_bln_add_zipCode" type="text" ibol />
					</div>
					<div>
						<span>País:</span>
						<input id="ipt_bln_add_country" type="text" ibol />
					</div>
					<div>
						<span>Telefone:</span>
						<input id="ipt_bln_add_phone" type="text" ibol />
					</div>
				</div>
			</div>
			<input type="button" value="Enviar" id="btn_doacao"/>
			<div id="div_ajax">
			</div>
		</section>
		<script type='text/javascript' src='https://desenvolvedor.moip.com.br/sandbox/transparente/MoipWidget-v2.js' charset="ISO-8859-1"></script>
		<script type='text/javascript' src='js/jquery-2.0.3.js' charset="ISO-8859-1"></script>
		<script type='application/javascript' src="js/pagamentoSimples.js" charset="utf-8"></script>
	</body>
</html>