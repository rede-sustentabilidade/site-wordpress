<?php
/*
Template Name: Formulário Filiação
*/

wp_enqueue_style( 'chosen-jquery', get_stylesheet_directory_uri() . '/assets/bower_components/chosen/chosen.css' );
wp_enqueue_style( 'page-filiacao', get_stylesheet_directory_uri() . '/css/page-filiacao.css' );

get_header();
the_content();


global $usuario;
?>

<script type="text/javascript">
	var WP_EMAIL = "<?php echo $usuario->email;?>";
</script>



<div class="container-filiacao">
    <div ng-controller="FiliacaoForm">

        <ol class="progtrckr">
            <li ng-repeat="step in steps" class="{{step.status}}"><strong>{{step.id}}</strong><span class="hmo">{{step.name}}</span></li>
        </ol>
        <div ng-switch="getCurrentStep()" class="slide-frame">
            <form ng-switch-when="Introdução" novalidate class="pure-form pure-form-stacked form-1" name="form_1" onsubmit="$">
                <fieldset ng-show="!$parent.ja_preencheu">
                    <?php print get_post_meta( get_the_ID(), 'texto_1', true ); ?>
                    <label for="leu_manifesto">
                        <input type="checkbox" iCheck ng-model="$parent.filiado.leu_manifesto" required name="leu_manifesto" id="leu_manifesto" value="sim" />
                        li o <a class="simple-ajax-popup" target="_blank" href="https://redesustentabilidade.org.br/manifesto/">Manifesto da Rede Sustentabilidade</a>
                    </label>
                    <p class="mensagem erro" ng-show="form_1.leu_manifesto.$dirty && form_1.leu_manifesto.$invalid">É obrigatória a leitura do manifesto.</p>
                    <label for="leu_estatuto">
                        <input type="checkbox" iCheck ng-model="$parent.filiado.leu_estatuto" required name="leu_estatuto" id="leu_estatuto" value="sim" />
                        li o <a class="simple-ajax-popup" target="_blank" href="https://redesustentabilidade.org.br/estatuto/">Estatuto de fundação da Rede Sustentabilidade</a>
                    </label>
                    <p class="mensagem erro" ng-show="form_1.leu_estatuto.$dirty && form_1.leu_estatuto.$invalid">É obrigatória a leitura do Estatuto.</p>
                    <p class="mensagem"><?php print get_post_meta( get_the_ID(), 'texto_2', true ); ?></p>
                </fieldset>
                <button ng-show="!$parent.ja_preencheu" ng-click="handleNext(dismiss)" ng-disabled="form_1.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}}</span> <i class="icon-seta-em-frente"></i></button>
                <div class="box-aviso-resultado pure-u-1" ng-show="$parent.ja_preencheu">
                    <h2>Você já preencheu a ficha, obrigado!</h2><p class="mensagem">Constam em nosso sistema que suas informações para a processo de filiação estão sendo validadas. Assim que for concluído você receberá um e-mail.</p>
                </div>
            </form>
            <form ng-switch-when="Dados Pessoais" novalidate class="pure-form pure-form-stacked form-2" name="form_2">
                <fieldset>
                     <div class="pure-g">
                         <div class="pure-u-1">
                            <p class="mensagem duvida">Dúvidas? Escreva para o email <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a></p>
                             <label for="birthday">Nome Completo</label>
                             <input id="fullname" name="fullname" required ng-model="$parent.filiado.fullname" type="text" class="pure-input-1-3">
                         </div>
                         <div class="pure-u-1" ng-if="logged == false">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" required ng-model="$parent.filiado.email" type="text" class="pure-input-1-3">
                         </div>
                         <div class="pure-u-1">
                             <label for="birthday">Data de nascimento</label>
                             <input id="birthday" name="birthday" required ng-model="$parent.filiado.birthday" ui-mask="99/99/9999" type="text" class="pure-input-1-3">
                         </div>
                        <div class="pure-u-1">
                            <label for="nome_mae">Nome da mãe</label>
                            <input id="nome_mae" name="nome_mae" required ng-model="$parent.filiado.nome_mae" type="text" class="pure-input-1-3">
                        </div>
                        <div class="pure-u-1">
                            <label for="">Sexo</label>
                            <label class="inner-label" for="sexo_f">
                                <input type="radio" ng-model="$parent.filiado.sexo" required name="sexo" id="sexo_f" value="F" />
                                Feminino
                            </label>
                            <label class="inner-label" for="sexo_m">
                                <input type="radio" ng-model="$parent.filiado.sexo" required name="sexo" id="sexo_m" value="M" />
                                Masculino
                            </label>
                        </div>
                        <div class="pure-u-1">
                            <label for="nacionalidade">Sua nacionalidade</label>
                            <select chosen id="nacionalidade" name="nacionalidade" required ng-model="$parent.filiado.nacionalidade" ng-options="s for s in nacionalidades" type="text" class="pure-input-1-3" data-placeholder="Nacionalidade">

                            </select>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1">

                            <label for="cep">CEP</label>
                            <input name="cep" ng-change="$parent.carregaEndereco()" required ng-model="$parent.filiado.cep" id="cep" ui-mask="99999-999" type="text" class="pure-input-1-3">
                            <p>Após preenchimento do CEP, o endereço é completado automaticamente. Apenas insira o número e complemento abaixo.</p>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-3-5">
                            <label for="endereco">Seu Endereço <!-- span>(Se você mora fora do Brasil, informe o país em "complemento")</span--> </label>
                            <input name="endereco" placeholder="Logradouro" ng-model="$parent.filiado.endereco" id="endereco" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-5">
                            <label for="numero">&nbsp;</label>
                            <input name="numero" placeholder="Número" ng-model="$parent.filiado.numero" id="numero" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-5">
                            <label for="complemento">&nbsp;</label>
                            <input name="complemento" placeholder="Complemento" ng-model="$parent.filiado.complemento" id="complemento" type="text" class="pure-input-1">
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1-3">
                            <!--label for="bairro">Bairro</label-->
                            <input name="bairro" placeholder="Bairro" ng-model="$parent.filiado.bairro" id="bairro" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <!--label for="cidade">Cidade</label-->
                            <input name="cidade" placeholder="Cidade" ng-model="$parent.filiado.cidade" id="cidade" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <!--label for="uf">Estado</label-->
                            <!--<input name="uf" placeholder="Estado" required ng-model="$parent.filiado.uf" id="uf" type="text" class="pure-input-1">-->
                            <select name="uf" ng-model="$parent.filiado.uf" id="uf" class="pure-select">
                                <option value="">Estado</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AM">Amazonas</option>
                                <option value="AP">Amapá</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MT">Mata Grosso</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="PR">Paraná</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SE">Sergipe</option>
                                <option value="SP">São Paulo</option>
                                <option value="TO">Tocantins</option>
                                <option value="XX">Não aplicável</option>
                            </select>
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1-3">
                            <label for="telefone_residencial">Telefone Residencial</label>
                            <input placeholder="Residencial" ng-model="$parent.filiado.telefone_residencial" name="telefone_residencial" id="telefone_residencial" type="text"  class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <label for="telefone_celular">Celular</label>
                            <input placeholder="Celular" ng-model="$parent.filiado.telefone_celular" name="telefone_celular" id="telefone_celular" type="text"  class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <label for="telefone_comercial">Comercial</label>
                            <input placeholder="Comercial" ng-model="$parent.filiado.telefone_comercial" name="telefone_comercial" id="telefone_comercial" type="text"  class="pure-input-1">
                        </div>
                    </div>
                </fieldset>
                <button ng-click="handleNext(dismiss)" ng-disabled="form_2.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}} </span><i class="icon-seta-em-frente"></i></button>
            </form>
            <form ng-switch-when="Dados Eleitorais" novalidate class="pure-form pure-form-stacked form-3" name="form_3">
                <fieldset>
                    <legend>Por favor, preencha seus dados eleitorais. Assim conseguiremos entender seu histórico político e suas motivações para filiar-se.</legend>
                    <div class="pure-g">
                        <div class="pure-u-1">
                            <p class="mensagem duvida">Dúvidas? Escreva para o email <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a></p>
                        </div>
                        <div class="pure-g">
                            <div class="pure-u-1-3">
                                <label for="titulo_eleitoral">Título Eleitoral <span>(complete com 0 a esquerda)</span></label>
                                <input ng-model="$parent.filiado.titulo_eleitoral" required name="titulo_eleitoral" ui-mask="9999 9999 9999" placeholder="Título Eleitoral" id="titulo_eleitoral" type="text" class="pure-input-1">
                            </div>
                            <div class="pure-u-1-3">
                                <label  for="zona_eleitoral">Zona Eleitoral</label>
                                <input ng-maxlength="3" ng-model="$parent.filiado.zona_eleitoral" required name="zona_eleitoral" placeholder="Ex. 243" id="zona_eleitoral" type="text" class="pure-input-1">
                            </div>
                            <div class="pure-u-1-3">
                                <label  for="secao_eleitoral">Seção Eleitoral</label>
                                <input ng-maxlength="4" ng-model="$parent.filiado.secao_eleitoral" required name="secao_eleitoral" placeholder="Ex. 332N" id="secao_eleitoral" type="text" class="pure-input-1">
                            </div>
                            <div class="pure-u-1-3">
                                <label class="inner-label" for="titulo_eleitoral">CPF</label>
                                <input ng-model="$parent.filiado.cpf" required name="cpf" ui-mask="999.999.999-99" placeholder="CPF" id="cpf" type="text" class="pure-input-1">
                            </div>
                        </div>
                        <div class="pure-u-1">
                            <label for="tipo_Filiacao">Informe que tipo de filiação pretende estabelecer com a #Rede</label>
                            <select disable-search="true" id="tipo_Filiacao" name="tipo_Filiacao" required ng-model="$parent.filiado.tipo_Filiacao" type="text" class="pure-input-1-3" data-placeholder="Tipo de filiação">
	                            <option value=""</option>
	                            <option value="C">Cívica Independente (Responde à Carta Compromisso)</option>
	                            <option value="P">Plena</option>
                            </select>
                            <p class="mensagem ajuda">
                                O filiado "pleno" goza de todos os Direitos e Deveres presentes no Estatuto da #Rede. O filiado "cívico independente", indicado por um movimento ou coletivo autônomo à #Rede, responderá, de forma complementar, aos termos estabelecidos em uma Carta Compromisso.
                            </p>
                        </div>
                        <div class="pure-u-1">
                            <label for="quer_ser_candidato_N">Você pretende candidatar-se pela Rede Sustentabilidade?</label>
                            <label class="inner-label" for="quer_ser_candidato_N">
                                <input type="radio" ng-model="$parent.filiado.quer_ser_candidato" required name="quer_ser_candidato" id="quer_ser_candidato_N" value="N" />
                                Não
                            </label>
                            <label class="inner-label" for="quer_ser_candidato_S">
                                <input type="radio" ng-model="$parent.filiado.quer_ser_candidato" required name="quer_ser_candidato" id="quer_ser_candidato_S" value="S" />
                                Sim
                            </label>
                        </div>



                        <div class="pure-u-3-5" ng-show="$parent.filiado.quer_ser_candidato=='S'">
                            <p class="mensagem ajuda">A omissão de qualquer informação solicitada neste cadastro pode resultar em rejeição e anulação da filiação.</p>
                            <label for="candidato_cargo">A que cargo pretende candidatar-se pela #Rede?</label>
                            <input ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_cargo" placeholder="Coloque o nome do cargo" ng-model="$parent.filiado.candidato_cargo" id="candidato_cargo" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-3-5" ng-show="$parent.filiado.quer_ser_candidato=='S'">
                            <label for="candidato_motivo">Em poucas palavras, diga por que você quer ser candidato? Qual é a sua motivação pela vida política?</label>
                            <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_motivo" ng-model="$parent.filiado.candidato_motivo" id="candidato_motivo" rows="3" class="pure-input-1"></textarea>
                        </div>
                        <div class="pure-u-3-5" ng-show="$parent.filiado.quer_ser_candidato=='S'">
                            <label for="candidato_base">Qual é sua base eleitoral?</label>
                            <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" placeholder="região, segmento populacional, área de atuação, serviços prestados" name="candidato_base" ng-model="$parent.filiado.candidato_base" id="candidato_base" rows="3" class="pure-input-1"></textarea>
                        </div>
                        <div class="pure-u-3-5" ng-show="$parent.filiado.quer_ser_candidato=='S'">
                            <label for="candidato_estatuto">Você leu, detalhadamente, o Estatuto e o Manifesto da #Rede? Você concorda com seus termos? Caso discorde de algum ponto especifico, indique(-os) e justifique(-os).</label>
                            <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_estatuto" ng-model="$parent.filiado.candidato_estatuto" id="candidato_estatuto" rows="3" class="pure-input-1"></textarea>
                        </div>
                        <div class="pure-u-3-5" ng-show="$parent.filiado.quer_ser_candidato=='S'">
                            <label for="candidato_antecedentes">Você tem antecedentes criminais, é ou já foi réu em ação criminal, é ou já foi investigado em inquérito policial? Em caso positivo indique o número do processo e a instância judicial (cartório, cidade, tribunal) em curso ou da decisão judicial respectiva (com ou sem trânsito em julgado).</label>
                            <textarea ng-required="$parent.filiado.quer_ser_candidato=='S'" name="candidato_antecedentes" ng-model="$parent.filiado.candidato_antecedentes" id="candidato_antecedentes" rows="3" class="pure-input-1"></textarea>
                        </div>
                        <div class="pure-u-1">
                            <label for="filiado_partido">É ou já foi filiado a partido político??</label>
                            <label class="inner-label" for="filiado_partido_N">
                                <input type="radio" ng-model="$parent.filiado.filiado_partido" required name="filiado_partido" id="filiado_partido_N" value="N" />
                                Não
                            </label>
                            <label class="inner-label" for="filiado_partido_S">
                                <input type="radio" ng-model="$parent.filiado.filiado_partido" required name="filiado_partido" id="filiado_partido_S" value="S" />
                                Sim
                            </label>
                        </div>
                        <div class="pure-u-1" ng-show="$parent.filiado.filiado_partido=='S'">
                            <label for="filiado_partido_quais">Quais Partidos?</label>
                            <input ng-model="$parent.filiado.filiado_partido_quais" ng-required="$parent.filiado.filiado_partido=='S'" name="filiado_partido_quais" placeholder="Ex. Fui filiado durante X anos no partido XX." id="filiado_partido_quais" type="text" class="pure-input-1">
                        </div>

                        <div class="pure-u-1">
                            <label for="foi_candidato">Já candidatou-se a cargo eletivo no Executivo ou Legislativo Federal, Estadual ou Municipal?</label>
                            <label class="inner-label" for="foi_candidato_N">
                                <input type="radio" ng-model="$parent.filiado.foi_candidato" required name="foi_candidato" id="foi_candidato_N" value="N" />
                                Não
                            </label>
                            <label class="inner-label" for="foi_candidato_S">
                                <input type="radio" ng-model="$parent.filiado.foi_candidato" required name="foi_candidato" id="foi_candidato_S" value="S" />
                                Sim
                            </label>
                        </div>
                        <div class="pure-u-1" ng-show="$parent.filiado.foi_candidato=='S'">
                            <label for="foi_candidato_quais">Quais você tentou?</label>
                            <input ng-model="$parent.filiado.foi_candidato_quais" ng-required="$parent.filiado.foi_candidato=='S'" name="foi_candidato_quais" placeholder="Ex. Fui candidato a Deputado Estadual no estado XX nas eleições de XXXX." id="foi_candidato_quais" type="text" class="pure-input-1">
                        </div>

                        <div class="pure-u-1">
                            <label for="atual_anterior_eleito">Exerce ou exerceu cargo eletivo no Executivo ou Legislativo Federal, Estadual ou Municipal ?</label>
                            <label class="inner-label" for="atual_anterior_eleito_N">
                                <input type="radio" ng-model="$parent.filiado.atual_anterior_eleito" required name="atual_anterior_eleito" id="atual_anterior_eleito_N" value="N" />
                                Não
                            </label>
                            <label class="inner-label" for="atual_anterior_eleito_S">
                                <input type="radio" ng-model="$parent.filiado.atual_anterior_eleito" required name="atual_anterior_eleito" id="atual_anterior_eleito_S" value="S" />
                                Sim
                            </label>
                        </div>
                        <div class="pure-u-1" ng-show="$parent.filiado.atual_anterior_eleito=='S'">
                            <label for="atual_anterior_eleito_quais">Quais você exerceu ou exerce?</label>
                            <input ng-model="$parent.filiado.atual_anterior_eleito_quais" ng-required="$parent.filiado.atual_anterior_eleito=='S'" name="atual_anterior_eleito_quais" placeholder="Ex. Sou vereador na cidade X e já fui vereador no ano XXXX na cidade X." id="atual_anterior_eleito_quais" type="text" class="pure-input-1">
                        </div>

                        <div class="pure-u-1">
                            <label for="cargo_confianca">Já foi nomeado a cargo de confiança ou comissionado no Serviço Público Federal, Estadual ou Municipal?</label>
                            <label class="inner-label" for="cargo_confianca_N">
                                <input type="radio" ng-model="$parent.filiado.cargo_confianca" required name="cargo_confianca" id="cargo_confianca_N" value="N" />
                                Não
                            </label>
                            <label class="inner-label" for="cargo_confianca_S">
                                <input type="radio" ng-model="$parent.filiado.cargo_confianca" required name="cargo_confianca" id="cargo_confianca_S" value="S" />
                                Sim
                            </label>
                        </div>
                        <div class="pure-u-1" ng-show="$parent.filiado.cargo_confianca=='S'">
                            <label for="cargo_confianca_quais">Quais você já foi nomeado?</label>
                            <input ng-model="$parent.filiado.cargo_confianca_quais" ng-required="$parent.filiado.cargo_confianca=='S'" name="cargo_confianca_quais" placeholder="Ex. Atualmente sou prefeito do município X." id="cargo_confianca_quais" type="text" class="pure-input-1">
                        </div>
                    </div>
                </fieldset>
                <button ng-click="handleNext(dismiss)" ng-disabled="form_3.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}}</span> <i class="icon-seta-em-frente"></i></button>
            </form>
            <!--<form ng-switch-when="Doação" novalidate class="pure-form pure-form-stacked form-4" name="form_4">
                <fieldset>
                    <legend>Visando garantir a sua autonomia e independência política, a #Rede propõe o financiamento de sua estrutura e ações através da contribuição direta de seus filiados. Com qual valor pretende colaborar mensalmente?</legend>
                    <div class="pure-g">
                        <div class="pure-u-1">
                            <p class="mensagem duvida">Dúvidas? Escreva para o email <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a></p>
                        </div>
                        <div class="pure-u-1-2">
                            <label for="contribuicao">Valor da contribuição</label>

                            <label class="inner-label" for="contribuicao_dez">
                                <input type="radio" ng-click="$parent.validaValor()" ng-model="$parent.filiado.contribuicao" required name="forma_pagamento_contribuicao" id="contribuicao_dez" value="10" />
                                R$ 10,00
                            </label><br />
                            <label class="inner-label" for="contribuicao_trinta">
                                <input type="radio" ng-click="$parent.validaValor()" ng-model="$parent.filiado.contribuicao" required name="forma_pagamento_contribuicao" id="contribuicao_trinta" value="30" />
                                R$ 30,00
                            </label><br />
                            <label class="inner-label" for="contribuicao_noventa">
                                <input type="radio" ng-click="$parent.validaValor()" ng-model="$parent.filiado.contribuicao" required name="forma_pagamento_contribuicao" id="contribuicao_noventa" value="90" />
                                R$ 90,00
                            </label><br />
                            <label class="inner-label" for="contribuicao_mais">
                                <input type="radio" ng-model="$parent.filiado.contribuicao_mais" required name="forma_pagamento_contribuicao" id="contribuicao_mais" value="S" />
                                <span>Mais</span>
                                <input value="100" ng-pattern="$parent.somenteNumeros" type="text" ng-require="$parent.filiado.contribuicao_mais=='S'" ng-show="$parent.filiado.contribuicao_mais=='S'" ng-model="$parent.filiado.contribuicao" id="contribuicao" name="contribuicao" ibol class="pure-input-1-2" >
                            </label>
                        </div>
                        <div class="pure-u-1-2 total-contribuicao">
                            <label>Total da contribuição mensal:</label>
                            <p>{{$parent.filiado.contribuicao | currency:"R$ "}}</p>
                        </div>
                    </div>
                    <div class="pure-u-1">
                        <label for="forma_pagamento_tipo">Forma de pagamento</label>
                        <label class="inner-label" for="forma_pagamento_tipo_CC">
                            <input type="radio" ng-model="$parent.filiado.forma_pagamento.tipo" required name="forma_pagamento_tipo" id="forma_pagamento_tipo_CC" value="cartao-credito" />
                            Cartão de crédito
                        </label>
                        <label class="inner-label" for="forma_pagamento_tipo_boleto">
                            <input type="radio" ng-model="$parent.filiado.forma_pagamento.tipo" required name="forma_pagamento_tipo" id="forma_pagamento_tipo_boleto" value="boleto" />
                            Boleto
                        </label>
                        <p class="mensagem ajuda"><img width="20" height="20" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/formulario-cadeado.png" />Não se preocupe, você está em uma conexão segura. Você só será cobrado(a) depois que sua filiação for concluída.</p>
                    </div>

                    <div class="pure-g dados-do-cc" ng-show="$parent.filiado.forma_pagamento.tipo=='cartao-credito'">
                        <div class="pure-u-1" ng-show="$parent.filiado.forma_pagamento.tipo=='cartao-credito'">
                            <label for="forma_pagamento_bandeira">Bandeira</label>
                            <label class="inner-label" for="forma_pagamento_bandeira_mastercard">
                                <input type="radio" ng-model="$parent.filiado.forma_pagamento.bandeira" name="forma_pagamento_bandeira" id="forma_pagamento_bandeira_mastercard" value="mastercard" />
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/mastercard.png" />
                            </label>
                            <label class="inner-label" for="forma_pagamento_bandeira_visa">
                                <input type="radio" ng-model="$parent.filiado.forma_pagamento.bandeira" name="forma_pagamento_bandeira" id="forma_pagamento_bandeira_visa" value="visa" />
                                <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/cartao/visa.png" />
                            </label>
                        </div>
                        <div class="pure-u-1">
                            <label class="inner-label" for="cartao_nome">Nome impresso no cartão</label>
                            <input ng-required="$parent.filiado.forma_pagamento.tipo=='cartao-credito'" id="cartao_nome" ng-model="$parent.filiado.forma_pagamento.cartao_nome" name="cartao_nome" type="text"  class="pure-input-2-3"/>
                        </div>

                        <div class="pure-u-1">
                            <label class="inner-label" for="cartao_numero">Número do cartão</label>
                            <input ng-required="$parent.filiado.forma_pagamento.tipo=='cartao-credito'" id="cartao_numero" ng-model="$parent.filiado.forma_pagamento.cartao_numero" name="cartao_numero" type="text" class="pure-input-2-3">
                        </div>

                        <div class="pure-u-1-5">
                            <label class="inner-label" for="cartao_validade_mes">Validade</label>
                            <select ng-required="$parent.filiado.forma_pagamento.tipo=='cartao-credito'"  id="cartao_validade_mes" ng-model="$parent.filiado.forma_pagamento.cartao_validade_mes" name="cartao_validade_mes" class="pure-input-1">
                                <option value="">Mês</option>
                                <?php // Preenche com 12 meses do ano
                                for ($x=1; $x<=12; $x++ ){
                                    printf("<option value=\"%d\">%d</option>", $x, $x);
                                }
                                ?>
                            </select>
                        </div>
                        <div class="pure-u-1-5">
                            <label class="inner-label" for="cartao_validade_ano">&nbsp;</label>
                            <select ng-required="$parent.filiado.forma_pagamento.tipo=='cartao-credito'"  id="cartao_validade_ano" ng-model="$parent.filiado.forma_pagamento.cartao_validade_ano" name="cartao_validade_ano" class="pure-input-1">
                                <option value="">Ano</option>
                                <?php // 10 próximos anos
                                    $ano_atual = date("Y");
                                    for ($x=$ano_atual; $x<=$ano_atual+10; $x++ ){
                                        printf("<option value=\"%d\">%d</option>", $x, $x);
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="pure-u-1-5">
                            <label class="inner-label" for="cartao_codigo_verificacao">Cód. Segurança</label>
                            <input ng-required="$parent.filiado.forma_pagamento.tipo=='cartao-credito'" ng-maxlength="5" id="cartao_codigo_verificacao" ng-model="$parent.filiado.forma_pagamento.cartao_codigo_verificacao" name="cartao_codigo_verificacao" type="text" class="pure-u-1" />
                        </div>
                    </div>
                </fieldset>
                <button ng-click="handleNext(dismiss)" ng-disabled="form_4.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}}</span> <i class="icon-seta-em-frente"></i></button>
            </form>-->
            <form ng-switch-when="Interesses" novalidate class="pure-form pure-form-stacked form-5" name="form_5">
                <fieldset ng-show="!$parent.enviado_sucesso && !$parent.registro_ja_afiliado && !$parent.registro_ja_passaporte && !enviado_falha">
                    <legend>Acreditamos no Ativismo Autoral, e por isso queremos conhecer as áreas e temas que te interessam, se exerce alguma militância, e também se você tem disponibilidade para colaborar voluntariamente com a #Rede.</legend>
                    <div class="pure-u-1">
                    <p class="mensagem duvida">Dúvidas? Escreva para o email <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a></p>
                        <label for="ativista">Você é ativista de alguma causa ou movimento social?</label>
                        <label class="inner-label" for="ativista_N">
                            <input type="radio" ng-model="$parent.filiado.ativista" required name="ativista" id="ativista_N" value="N" />
                            Não
                        </label>
                        <label class="inner-label" for="ativista_S">
                            <input type="radio" ng-model="$parent.filiado.ativista" required name="ativista" id="ativista_S" value="S" />
                            Sim
                        </label>
                    </div>

                    <div class="pure-u-1" ng-show="$parent.filiado.ativista=='S'">
                        <label for="ativista_quais">Descreva como é seu ativismo e onde geralmente atua?</label>
                        <input ng-model="$parent.filiado.ativista_quais" ng-required="$parent.filiado.ativista=='S'" name="ativista_quais" placeholder="Ex. Atualmente faço ativismo social." id="ativista_quais" type="text" class="pure-input-1">
                    </div>

                    <div class="pure-u-1">
                        <label for="escolaridade">Escolaridade</label>
                        <select disable-search="true" chosen id="escolaridade" name="escolaridade" required ng-model="$parent.filiado.escolaridade" ng-options="f for f in listaEscolaridade" type="text" class="pure-input-1-3" data-placeholder="Informe teu nível de escolaridade">
                        </select>
                    </div>

                    <div class="pure-u-1">
                        <label for="atuacoesProfissionais">Em qual área você atua?</label>
                        <select multiple="multiple" id="atuacoesProfissionais" name="atuacoesProfissionais" required ng-model="$parent.filiado.atuacoesProfissionais" type="text" class="pure-input-1-3" data-placeholder="Diga-nos onde atua profissionalmente">
<option value="1">Administração e Negócios</option><option value="2">Artes e Design</option><option value="3">Campo de Públicas</option><option value="4">Ciências Agrárias</option><option value="5">Ciências Exatas e Informática</option><option value="6">Ciências Humanas e Sociais</option><option value="7">Comunicação e Informação</option><option value="8">Engenharia</option><option value="9">Meio Ambiente</option><option value="10">Saúde</option><option value="11">Outro</option>
                        </select>
<br />
Pressione e segure a tecla Control no Windows, ou Command no Mac, para selecionar mais de uma opção
                    </div>

                    <div class="pure-u-1">
                        <label for="areasInteresse">Áreas de interesse</label>
                        <select multiple="multiple" id="areasInteresse" name="areasInteresse" required ng-model="$parent.filiado.areasInteresse" type="text" class="pure-input-1-3" data-placeholder="Diga-nos suas áreas de interesse">
                        <option value="1">Meio Ambiente</option><option value="2">Educação</option><option value="3">Saúde</option><option value="4">Moradia</option><option value="5">Tecnologia</option><option value="6">Energias Alternativas</option><option value="7">Mobilidade Urbana</option><option value="8">Economia Criativa</option><option value="9">Economia Solidária</option><option value="10">Causa Indígena</option><option value="11">Direitos Humanos</option><option value="12">Diversidade</option><option value="13">Ativismo Autoral</option><option value="14">Patrimônio Genético</option><option value="15">Arte</option><option value="16">Outros</option>
                        </select>
<br />
Pressione e segure a tecla Control no Windows, ou Command no Mac, para selecionar mais de uma opção
                    </div>

                    <div class="pure-u-1">
                        <label for="local_trabalho">Qual seu local de trabalho?</label>
                        <input id="local_trabalho" required ng-model="$parent.filiado.local_trabalho" name="local_trabalho" type="text"  class="pure-input-2-3" placeholder="Nome da empresa ou organização onde trabalha." />
                    </div>

                    <div class="pure-u-1">
                        <label for="voluntario">Você gostaria de oferecer voluntariamente algum serviço ou habilidade profissional para a #Rede?</label>
                        <label class="inner-label" for="voluntario_N">
                            <input type="radio" ng-model="$parent.filiado.voluntario" required name="voluntario" id="voluntario_N" value="N" />
                            Não
                        </label>
                        <label class="inner-label" for="voluntario_S">
                            <input type="radio" ng-model="$parent.filiado.voluntario" required name="voluntario" id="voluntario_S" value="S" />
                            Sim
                        </label>
                    </div>

                </fieldset>
                <div class="pure-u-1 box-aviso-resultado pronto" ng-show="$parent.enviado_sucesso">
                    <h2>Olá,</h2>
                    <p class="mensagem">você finalizou seu cadastro e o pedido de filiação foi enviado para a direção regional.<br/>
                    A confirmação de sua filiação ocorrerá pela direção estadual, depois de você passar pelo processo de formação. <br/><br/><br/>

                    Atenciosamente,<br/>
                    Comissão Executiva Nacional<br/>
                    Rede Sustentabilidade</p>
                    

                    <br /><br /><br />

                    <a href="/">Clique aqui para voltar para a página inicial</a>

                    </p>

                </div>
                <div class="pure-u-1 box-aviso-resultado" ng-show="$parent.enviado_falha">
                    <h2>Algo deu errado!</h2><p class="mensagem">Tente novamente ou envie um email para <a href="mailto:filiacao@reFdesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a> se o problema persistir.</p>
                </div>
                <div class="pure-u-1 box-aviso-resultado" ng-show="$parent.registro_ja_afiliado">
                    <h2>E-mail já filiado!</h2><p class="mensagem">Tente outro e-mail ou entre com suas credenciais na página de login.</p>
                </div>
                <div class="pure-u-1 box-aviso-resultado" ng-show="$parent.registro_ja_passaporte">
                    <h2>E-mail já possui passaporte!</h2><p class="mensagem">Tente outro e-mail ou entre com suas credenciais na página de login e inicie a filiação.</p>
                </div>
                <button ng-show="!$parent.enviado_sucesso && !registro_ja_afiliado && !registro_ja_passaporte && !enviado_falha" ng-click="handleNext(saveFiliado)" ng-disabled="form_5.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}}</span> <i class="icon-seta-em-frente"></i></button>
            </form>
        </div>

        <button ng-show="!isFirstStep() && !enviado_sucesso && !registro_ja_afiliado && !registro_ja_passaporte && !enviado_falha" ng-click="handlePrevious()" ><i class="icon-seta-para-tras"></i> <span class="hmo">Anterior</span></button>

        <button ng-show="registro_ja_passaporte || registro_ja_afiliado || enviado_falha" ng-click="handleBack()" ><i class="icon-seta-para-tras"></i> <span class="hmo">Voltar</span></button>

        <!--pre>form = {{user | json}}</pre>
        <pre>master = {{master | json}}</pre-->
    </div>
</div>
<?php get_footer(); ?>
