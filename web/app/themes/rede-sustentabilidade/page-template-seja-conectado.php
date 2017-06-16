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
            <form ng-switch-when="Dados Pessoais" novalidate class="pure-form pure-form-stacked form-1" name="form_1" onsubmit="$">
                <fieldset ng-show="!$parent.enviado_sucesso && !$parent.registro_ja_afiliado && !$parent.registro_ja_passaporte && !enviado_falha">
                    <p>Olá,<br/>
                    você optou por ser Conectad@ à Rede.</br>
                    @ Conectad@ terá acesso às funcionalidades abertas de nossa Plataforma e receberá nossas Newsletters.<br/>
                    Conheça mais o projeto da Rede Sustentabilidade, leia <a href="https://redesustentabilidade.org.br/estatuto/" target="_blank">nosso estatuto</a> e <a href="https://redesustentabilidade.org.br/manifesto/" target="_blank">manifesto partidário</a> e peça sua filiação.</p>
                    <p>Atenciosamente,<br/>
                    Comissão Executiva Nacional<br/>
                    Rede Sustentabilidade</p>
                </fieldset>
                <fieldset ng-show="!$parent.enviado_sucesso && !$parent.registro_ja_afiliado && !$parent.registro_ja_passaporte && !enviado_falha">
                     <div class="pure-g">
                         <div class="pure-u-1">
                            <label for="email">E-mail</label>
                            <input id="email" name="email" required ng-model="$parent.filiado.email" type="text" class="pure-input-1-3">
                         </div>
                    </div>
                </fieldset>
                <div class="pure-u-1 box-aviso-resultado pronto" ng-show="$parent.enviado_sucesso">
                    <h2>Olá,</h2>
                    <p class="mensagem">você agora é conectad@ a rede.<br/>
                    Sua senha de acesso foi enviada no seu e-mail.<br/><br/><br/>

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
