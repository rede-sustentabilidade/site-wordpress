<?php
/*
Template Name: Formulário Seja conectado
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
    <div ng-controller="SejaConectadoForm">

        <ol class="progtrckr">
            <li ng-repeat="step in steps" class="{{step.status}}"><strong>{{step.id}}</strong><span class="hmo">{{step.name}}</span></li>
        </ol>
        <div ng-switch="getCurrentStep()" class="slide-frame">
            <form ng-switch-when="Introdução" novalidate class="pure-form pure-form-stacked form-1" name="form_1" onsubmit="$">
                <fieldset ng-show="!$parent.ja_preencheu">
                    <p>Olá,<br/>
                    você optou por ser Conectad@ à Rede.</br>
                    @ Conectad@ terá acesso às funcionalidades abertas de nossa Plataforma e receberá nossas Newsletters.<br/>
                    Conheça mais o projeto da Rede Sustentabilidade, leia <a href="https://redesustentabilidade.org.br/estatuto/" target="_blank">nosso estatuto</a> e <a href="https://redesustentabilidade.org.br/manifesto/" target="_blank">manifesto partidário</a> e peça sua filiação.</p>
                    <p>Atenciosamente,<br/>
                    Comissão Executiva Nacional<br/>
                    Rede Sustentabilidade"</p>
                </fieldset>
                <button ng-show="!$parent.ja_preencheu" ng-click="handleNext(dismiss)" ng-disabled="form_1.$invalid" class="proximo"><span class="hmo">{{getNextLabel()}}</span> <i class="icon-seta-em-frente"></i></button>
            </form>
            <form ng-switch-when="Dados Pessoais" novalidate class="pure-form pure-form-stacked form-2" name="form_2">
                <fieldset ng-show="!$parent.enviado_sucesso && !$parent.registro_ja_afiliado && !$parent.registro_ja_passaporte && !enviado_falha">
                     <div class="pure-g">
                         <div class="pure-u-1">
                            <p class="mensagem duvida">Dúvidas? Escreva para o email <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a></p>
                             <label for="birthday">Nome Completo</label>
                             <input id="fullname" name="fullname" required ng-model="$parent.filiado.fullname" type="text" class="pure-input-1-3">
                         </div>
                         <div class="pure-u-1">
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
                            <input name="endereco" placeholder="Logradouro" required ng-model="$parent.filiado.endereco" id="endereco" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-5">
                            <label for="numero">&nbsp;</label>
                            <input name="numero" placeholder="Número" required ng-model="$parent.filiado.numero" id="numero" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-5">
                            <label for="complemento">&nbsp;</label>
                            <input name="complemento" placeholder="Complemento" ng-model="$parent.filiado.complemento" id="complemento" type="text" class="pure-input-1">
                        </div>
                    </div>
                    <div class="pure-g">
                        <div class="pure-u-1-3">
                            <!--label for="bairro">Bairro</label-->
                            <input name="bairro" placeholder="Bairro" required ng-model="$parent.filiado.bairro" id="bairro" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <!--label for="cidade">Cidade</label-->
                            <input name="cidade" placeholder="Cidade" required ng-model="$parent.filiado.cidade" id="cidade" type="text" class="pure-input-1">
                        </div>
                        <div class="pure-u-1-3">
                            <!--label for="uf">Estado</label-->
                            <!--<input name="uf" placeholder="Estado" required ng-model="$parent.filiado.uf" id="uf" type="text" class="pure-input-1">-->
                            <select name="uf" required ng-model="$parent.filiado.uf" id="uf" class="pure-select">
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
                            <input placeholder="Residencial" required ng-model="$parent.filiado.telefone_residencial" name="telefone_residencial" id="telefone_residencial" type="text"  class="pure-input-1">
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
                <div class="pure-u-1 box-aviso-resultado pronto" ng-show="$parent.enviado_sucesso">
                    <h2>Olá,</h2>
                    <p class="mensagem">o cadastro do seu pedido de filiação finalizou.<br/>
                    Seus dados foram enviados para a direção estadual da sua região e serão analisados.<br/>
                    Fique atento à sua caixa de e-mail e/ou telefone pois eles farão contato brevemente.<br/><br/><br/>

                    Atenciosamente,<br/>
                    Comissão Executiva Nacional<br/>
                    Rede Sustentabilidade</p>
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
