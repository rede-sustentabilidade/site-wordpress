/*jslint browser:true */
/*global jQuery, API_USER_STATUS, WP_USER_ID */

var listas = {};
listas.apiURL = API_PATH;

jQuery(function ($) {
    'use strict';

    function processHash() {
        listas.hash = window.location.hash.substring(2).split('/');
    }

    function getListas(page, items, order, status, name, state, email, password, cb) {
        var data = {};
        data.page  = page;
        data.items  = items;
        data.order  = order;
        data.status  = status;
        if (email && password) {
            data.email = email;
            data.password = password;
        }
        data.filters = '';
        if (name) {
            data.filters += 'fullname,ilike,%'  + decodeURIComponent(name) + '%';

            if (state) {
                data.filters += ':';
            }
        }
        if (state) {
            data.filters += 'uf,=,' + state;
        }

		$.ajax({
            dataType: 'json',
            url: listas.apiURL + '/users',
            data: data
        }).done(function (data) {
            listas.data = data || [];
            cb(null);
        });
    }

    function makeAbono(filiadoId, userId, cb) {
        $.ajax({
            type: 'POST',
            url: listas.apiURL + '/usuario/filiado/abono',
            data: {'user_id': filiadoId, 'quem_abonou': userId},
            dataType: 'json'
        }).always(function () {
            cb(null);
        });
    }

    function makeConfirmacao(filiadoId, userId, cb) {
        $.ajax({
            type: 'POST',
            url: listas.apiURL + '/usuario/filiado/confirmacao',
            data: {'user_id': filiadoId},
            dataType: 'json'
        }).always(function () {
            cb(null);
        });
    }

    function makeImpugnacao(filiadoId, userId, justification, cb) {
        $.ajax({
            type: 'POST',
            url: listas.apiURL + '/usuario/filiado/impugnacao',
            data: {'impugnado': filiadoId, 'quem_impugnou': userId, 'motivo': justification},
            dataType: 'json'
        }).always(function () {
            cb(null);
        });
    }

    function insertLoading() {
        $('#lists').html("<div class='loading'><span class='icon-refresh'></span> Processando...</div>");
        $('html,body').animate({scrollTop: 0}, 0);
    }

    function getNavigation() {
        var o = '';
        o += '<p>';
        o += '<a href="/listas/#/filiados/1/50/nome/asc">Lista de filiados</a>';
        if (API_USER_STATUS == 99) {
            o += ' | ';
            o += '<a href="/listas/#/abonos/1/50/nome/asc">Pré-filiados aguardando abono</a>';
            o += ' | ';
            o += '<a href="/listas/#/impugnacoes/1/50/nome/asc">Pré-filiados em fase de avaliação</a>';
        }
        if (API_USER_STATUS > 10) {
            o += ' | ';
            o += '<a href="/listas/#/confirmacao/1/50/nome/asc">Filiados aguardando confirmação</a>';
        }
        if (API_USER_STATUS == 99) {
            o += ' | ';
            o += '<a href="/listas/#/admin/1/50/nome/asc">Lista de filiados para administradores</a>';
        }
        o += '</p>';
        return o;
    }

    function getControlPagination() {
        var o = '',
        tempHash = listas.hash.slice(0);
        o += '<div class="controls right">';
        tempHash[1] = 1;
        if (parseInt(listas.hash[1], 10) > 1) {
            tempHash[1] = (parseInt(listas.hash[1], 10) - 1).toString();
        }
        if (listas.hash[1] !== '1') {
            o += '<a href="#/' + tempHash.join('/') + '"><span class="icon-seta-para-tras"></span> Página anterior</a>';
        }
        tempHash[1] = (parseInt(listas.hash[1], 10) + 1).toString();
        o += '<a href="#/' + tempHash.join('/') + '">Próxima página <span class="icon-seta-em-frente"></span></a>';
        o += '</div>';
        return o;
    }

    function getControlResultsPerPage() {
        var o = '',
        tempHash = listas.hash.slice(0);
        tempHash[1] = '1';
        o += '<div class="controls left">';
        o += 'Resultados por página';
        tempHash[2] = '50';
        if (listas.hash[2] === '50') {
            o += '<div>50</div>';
        } else {
            o += '<a href="#/' + tempHash.join('/') + '">50</a>';
        }
        tempHash[2] = '100';
        if (listas.hash[2] === '100') {
            o += '<div>100</div>';
        } else {
            o += '<a href="#/' + tempHash.join('/') + '">100</a>';
        }
        tempHash[2] = '200';
        if (listas.hash[2] === '200') {
            o += '<div>200</div>';
        } else {
            o += '<a href="#/' + tempHash.join('/') + '">200</a>';
        }
        o += '</div>';
        return o;
    }

    function processHeaderFixed() {
        var $table = $('#lists #list table');
        $table.floatThead({
            scrollContainer: function ($table) {
                return $table.closest('.wrapper');
            }
        });
    }

    function getSearch() {
        var o = '';
        o += '<div id="search">';
        o += '<input type="text" id="searchbox" placeholder="Entre com o nome que deseja pesquisar">';
        o += '<select id="selectbox" name="Combo_Estados">';
        o += '<option value="">Todos</option>';
        o += '<option value="ac">Acre</option>';
        o += '<option value="al">Alagoas</option>';
        o += '<option value="am">Amazonas</option>';
        o += '<option value="ap">Amapá</option>';
        o += '<option value="ba">Bahia</option>';
        o += '<option value="ce">Ceará</option>';
        o += '<option value="df">Distrito Federal</option>';
        o += '<option value="es">Espírito Santo</option>';
        o += '<option value="go">Goiás</option>';
        o += '<option value="ma">Maranhão</option>';
        o += '<option value="mg">Minas Gerais</option>';
        o += '<option value="ms">Mato Grosso do Sul</option>';
        o += '<option value="mt">Mata Grosso</option>';
        o += '<option value="pa">Pará</option>';
        o += '<option value="pb">Paraíba</option>';
        o += '<option value="pe">Pernambuco</option>';
        o += '<option value="pi">Piauí</option>';
        o += '<option value="pr">Paraná</option>';
        o += '<option value="rj">Rio de Janeiro</option>';
        o += '<option value="rn">Rio Grande do Norte</option>';
        o += '<option value="ro">Rondônia</option>';
        o += '<option value="rr">Roraima</option>';
        o += '<option value="rs">Rio Grande do Sul</option>';
        o += '<option value="sc">Santa Catarina</option>';
        o += '<option value="se">Sergipe</option>';
        o += '<option value="sp">São Paulo</option>';
        o += '<option value="to">Tocantins</option>';
        o += '</select>';
        o += '<input type="submit" id="searchbutton" value="Pesquisar">';
        o += '</div>';
        return o;
    }

    function processFiliadosPublica() {
        var o = '',
        l = '',
        fields =
                [
                    ['name', 'Nome'],
                    ['city', 'Cidade'],
                    ['state', 'Estado']
                ];
        o += getNavigation();
        o += '<h1>Filiados(as)</h1>';
        o += '<p>Lista de filiadas e filiados à Rede Sustentabilidade. Dúvidas? Escreva para <a href="mailto:filiacao@redesustentabilidade.org.br">filiacao@redesustentabilidade.org.br</a>.</p>';
        o += getSearch();
        o += '<div id="list">';
        o += '<table>';
        o += '<thead>';
        o += '<tr>';
        fields.forEach(function (v) {
            o += '<th>';
            o += v[1];
            o += '</th>';
        });
        o += '</tr>';
        o += '</thead>';
        o += '<tbody>';
        listas.data.forEach(function (v) {
            l += '<tr>';
            fields.forEach(function (x) {
                l += '<td>' + v[x[0]]  + '</td>';
            });
            l += '</tr>';
        });
        if (l === '') {
            l += '<tr><td colspan="' + (fields.length + 1).toString()  + '" class="no-data">Nenhum dado para exibir</td></tr>';
        }
        o += l;
        o += '</tbody>';
        o += '</table>';
        o += '</div>';
        o += getControlPagination();
        o += getControlResultsPerPage();
        o += '<div class="clear"></div>';
        $('#lists').html(o);
        processHeaderFixed();
    }

    function listenAbono() {
        $('.abono-action').on('click', function (e) {
            var id = e.currentTarget.id;
            insertLoading();
            makeAbono(id, WP_USER_ID, function (err, data) {
                if (!err) {
                    $.prompt('Abono realizado com sucesso! Obrigado.', {
                        title: 'Rede Sustentabilidade',
                        top: '35%',
                        buttons: {'Ok': true},
                        submit: function () {
                            location.reload();
                        }
                    });
                } else {
                    if (data && data.responseJSON) {
                        $.prompt('Erro ao abonar. Veja os erros abaixo:\n\n' + data.responseJSON.join('\n\n'), {
                            title: 'Rede Sustentabilidade',
                            top: '35%',
                            buttons: {'Ok': true},
                            submit: function () {
                                location.reload();
                            }
                        });
                    } else {
                        $.prompt('Erro ao abonar. Tente novamente em alguns instantes.', {
                            title: 'Rede Sustentabilidade',
                            top: '35%',
                            buttons: {'Ok': true},
                            submit: function () {
                                location.reload();
                            }
                        });
                    }
                }
            });
        });
    }

    function processAbonos() {
        var o = '',
        l = '',
            fields =
                [
                    ['fullname', 'Nome'],
                    ['cidade', 'Cidade'],
                    ['uf', 'Estado'],
                    ['tipo_Filiacao', 'Filiação'],
                    ['filiado_partido', 'Já foi filiado?', true],
                    ['foi_candidato', 'Já foi candidato?', true],
                    ['atual_anterior_eleito', 'Já foi eleito?', true],
                    ['cargo_confianca', 'Já foi comissionado?', true]
                ];
        o += getNavigation();
        o += '<h1>Pré-filiados aguardando abono</h1>';
        if (!WP_USER_ID) {
            o += '<p>';
            o += 'Você precisa estar logado para ver essas informações. <a href="/wp/wp-login.php?redirect_to=' + encodeURIComponent(document.URL) + '"><strong>Clique aqui para logar</strong></a>';
            o += '</p><br />';
            $('#listas').html(o);
            return;
        }
        o += '<p>Abaixo está a lista de novos pré-filiados à Rede Sustentabilidade. Para que se tornem filiados, precisam receber o abono de outro filiado. Se você aprova e abona a filiação de algum deles, clique em "abonar". PS: Movimente a tabela lateralmente para ver todos os dados de cada linha.</p>';
        o += getSearch();
        o += '<div id="list">';
        o += '<table>';
        o += '<thead>';
        o += '<tr>';
        o += '<th>Abono</th>';
        fields.forEach(function (v) {
            o += '<th>';
            o += v[1];
            o += '</th>';
        });
        o += '</tr>';
        o += '</thead>';
        o += '<tbody>';
        listas.data.forEach(function (v) {
            l += '<tr>';
            l += '<td id="' + v.user_id + '" class="abono-action"><span class="icon-ok-sign"></span> Abonar</td>';
            fields.forEach(function (x) {
                if (x[2]) {
                    if (v[x[0]] === 'S') {
                        l += '<td>Sim</td>';
                    } else if (v[x[0]] === 'N') {
                        l += '<td>Não</td>';
                    } else {
                        l += '<td></td>';
                    }
                } else if (x[0] === 'tipo_Filiacao') {
                    if (v[x[0]] === 'P') {
                        l += '<td>Pleno</td>';
                    } else if (v[x[0]] === 'A') {
                        l += '<td>Cívica</td>';
                    } else {
                        l += '<td></td>';
                    }
                } else {
                    l += '<td>' + v[x[0]]  + '</td>';
                }
            });
            l += '</tr>';
        });
        if (l === '') {
            l += '<tr><td colspan="' + (fields.length + 1).toString()  + '" class="no-data">Nenhum dado para exibir</td></tr>';
        }
        o += l;
        o += '</tbody>';
        o += '</table>';
        o += '</div>';
        o += getControlPagination();
        o += getControlResultsPerPage();
        o += '<div class="clear"></div>';
        $('#lists').html(o);
        listenAbono();
        processHeaderFixed();
    }

    function processConfirmacao() {
        var o = '',
        l = '',
            fields =
                [
                    ['fullname', 'Nome'],
                    ['cidade', 'Cidade'],
                    ['uf', 'Estado']
                ];
        o += getNavigation();
        o += '<h1>Pré-filiados aguardando confirmação</h1>';
        if (!WP_USER_ID) {
            o += '<p>';
            o += 'Você precisa estar logado para ver essas informações. <a href="/wp/wp-login.php?redirect_to=' + encodeURIComponent(document.URL) + '"><strong>Clique aqui para logar</strong></a>';
            o += '</p><br />';
            $('#listas').html(o);
            return;
        }
        o += '<p>Abaixo está a lista de novos pré-filiados à Rede Sustentabilidade. Para que se tornem filiados, precisam receber o abono de outro filiado. Se você aprova e abona a filiação de algum deles, clique em "abonar". PS: Movimente a tabela lateralmente para ver todos os dados de cada linha.</p>';
        o += getSearch();
        o += '<div id="list">';
        o += '<table>';
        o += '<thead>';
        o += '<tr>';
        fields.forEach(function (v) {
            o += '<th>';
            o += v[1];
            o += '</th>';
        });
        o += '</tr>';
        o += '</thead>';
        o += '<tbody>';
        listas.data.forEach(function (v) {
            l += '<tr>';
            fields.forEach(function (x) {
                if (x[2]) {
                    if (v[x[0]] === 'S') {
                        l += '<td>Sim</td>';
                    } else if (v[x[0]] === 'N') {
                        l += '<td>Não</td>';
                    } else {
                        l += '<td></td>';
                    }
                } else if (x[0] === 'tipo_Filiacao') {
                    if (v[x[0]] === 'P') {
                        l += '<td>Pleno</td>';
                    } else if (v[x[0]] === 'A') {
                        l += '<td>Cívica</td>';
                    } else {
                        l += '<td></td>';
                    }
                } else {
                    l += '<td>' + v[x[0]]  + '</td>';
                }
            });
            l += '</tr>';
        });
        if (l === '') {
            l += '<tr><td colspan="' + (fields.length + 1).toString()  + '" class="no-data">Nenhum dado para exibir</td></tr>';
        }
        o += l;
        o += '</tbody>';
        o += '</table>';
        o += '</div>';
        o += getControlPagination();
        o += getControlResultsPerPage();
        o += '<div class="clear"></div>';
        $('#lists').html(o);
        processHeaderFixed();
    }

    function listenImpugnacao() {
        var o = '';
        o += '<tr class="impugnacao-form">';
        o += '<td colspan="9">';
        o += '<p>Você deve fornecer motivos que fundamentem a impugnação desta pré-filiação. Seu pedido de impugnação será analisado. O pré-filiado terá direito a defesa com base na justificativa abaixo.</p>';
        //o += '<p>Para VETAR a filiação de alguém, você deve fornecer motivos para isso. Seu pedido de veto será analisado pela equipe da #Rede.</p>';
        o += '<textarea placeholder="Motivo da impugnação"></textarea>';
        o += '<button class="send">Enviar</button>';
        o += '<button class="cancel">Cancelar</button>';
        o += '</td>';
        o += '</tr>';
        $('.impugnacao-action').on('click', function (e) {
            var filiadoId = e.currentTarget.id;
            if ($('#' + filiadoId).hasClass('active')) {
                return;
            }
            $('#' + filiadoId).addClass('active');
            $('.impugnacao-form').remove();
            $('#' + filiadoId).parent().after(o);
            $('textarea').focus();
            $('.impugnacao-form .cancel').on('click', function () {
                $('#' + filiadoId).removeClass('active');
                $('.impugnacao-form').remove();
            });
            $('.impugnacao-form .send').on('click', function () {
                var justification = $('textarea').val();
                if (justification) {
                    insertLoading();
                    makeImpugnacao(filiadoId, WP_USER_ID, justification, function (err, data) {
                        if (!err) {
                            $.prompt('Impuganção enviada com sucesso! Obrigado.', {
                                title: 'Rede Sustentabilidade',
                                top: '35%',
                                buttons: {'Ok': true},
                                submit: function () {
                                    location.reload();
                                }
                            });
                        } else {
                            if (data && data.responseJSON) {
                                $.prompt('Erro ao enviar impugnação. Veja os erros abaixo:\n\n' + data.responseJSON.join('\n\n'), {
                                    title: 'Rede Sustentabilidade',
                                    top: '35%',
                                    buttons: {'Ok': true},
                                    submit: function () {
                                        location.reload();
                                    }
                                });
                            } else {
                                $.prompt('Erro ao enviar impugnação. Tente novamente em alguns instantes.', {
                                    title: 'Rede Sustentabilidade',
                                    top: '35%',
                                    buttons: {'Ok': true},
                                    submit: function () {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    }

    function processImpugnacoes() {
        var o = '',
        l = '',
        fields = [
            ['fullname', 'Nome'],
            ['cidade', 'Cidade'],
            ['uf', 'Estado'],
            ['tipo_Filiacao', 'Filiação'],
            ['filiado_partido', 'Já foi filiado?', true],
            ['foi_candidato', 'Já foi candidato?', true],
            ['atual_anterior_eleito', 'Já foi eleito?', true],
            ['cargo_confianca', 'Já foi comissionado?', true]
        ];
        o += getNavigation();
        o += '<h1>Pré-filiados em fase de avaliação</h1>';
        if (!WP_USER_ID) {
            o += '<p>';
            o += 'Você precisa estar logado para ver essas informações. <a href="/wp/wp-login.php?redirect_to=' + encodeURIComponent(document.URL) + '"><strong>Clique aqui para logar</strong></a>';
            o += '</p><br />';
            $('#listas').html(o);
            return;
        }
        o += '<p>Abaixo está a lista dos pré-filiados à #Rede já abonados. Se você discorda da filiação de algum deles, clique em "impugnar" e justifique. Uma comissão analisará os pedidos de impugnação e, se houver dúvida quanto à justificativa, entrará em contato. PS: Movimente a tabela lateralmente para ver todos os dados de cada linha.</p>';
        //o += '<p>Abaixo está a lista de novos pré-filiados à Rede Sustentabilidade que já receberam o abono de outro filiado. Se não receberem nenhum pedido de impugnação, tornarão-se filiados. Se você discorda com a filiação de algum deles, clique em "impugnar" e justifique. A Comissão Regional da #Rede analisará todos os pedidos de impugnação. Se tivermos alguma dúvida quanto à sua justificativa de impugnação, entraremos em contato.</p>';
        o += getSearch();
        o += '<div id="list">';
        o += '<table>';
        o += '<thead>';
        o += '<tr>';
        o += '<th>Impugnação</th>';
        fields.forEach(function (v) {
            o += '<th>';
            o += v[1];
            o += '</th>';
        });
        o += '</tr>';
        o += '</thead>';
        o += '<tbody>';
        listas.data.forEach(function (v) {
            l += '<tr>';
            l += '<td id="' + v.user_id + '" class="impugnacao-action"><span class="icon-ban-circle"></span> Impugnar</td>';
            fields.forEach(function (x) {
                if (x[2]) {
                    if (v[x[0]] === 'S') {
                        l += '<td>Sim</td>';
                    }
                    if (v[x[0]] === 'N') {
                        l += '<td>Não</td>';
                    }
                } else if (x[0] === 'tipo_Filiacao') {
                    if (v[x[0]] === 'P') {
                        l += '<td>Pleno</td>';
                    }
                    if (v[x[0]] === 'A') {
                        l += '<td>Cívica</td>';
                    }
                } else {
                    l += '<td>' + v[x[0]]  + '</td>';
                }
            });
            l += '</tr>';
        });
        if (l === '') {
            l += '<tr><td colspan="' + (fields.length + 1).toString()  + '" class="no-data">Nenhum dado para exibir</td></tr>';
        }
        o += l;
        o += '</tbody>';
        o += '</table>';
        o += '</div>';
        o += getControlPagination();
        o += getControlResultsPerPage();
        o += '<div class="clear"></div>';
        $('#lists').html(o);
        processHeaderFixed();
        listenImpugnacao();
    }

    function processFiliadosAdmin() {
        var o = '',
        l = '',
        fields = [
            ['user_id', 'Id'],
            ['fullname', 'Nome'],
            ['sexo', 'Sexo'],
            ['cidade', 'Cidade'],
            ['uf', 'Estado'],
            ['birthday', 'Aniversário'],
            ['escolaridade', 'Escolaridade'],
            ['titulo_eleitoral', 'Título eleitoral'],
            ['zona_eleitoral', 'Zona'],
            ['secao_eleitoral', 'Seção'],
            ['cpf', 'CPF'],
            ['ativista', 'É ativista?', true],
            ['ativista_quais', 'Se ativista, onde atuou', true],
            ['volutario', 'É voluntário?', true],
            ['local_trabalho', 'Local de trabalho'],
            ['filiado_partido', 'Já foi filiado', true],
            ['filiado_partido_quais', 'A quais partidos?'],
            ['tipo_Filiacao', 'Filiação'],
            ['quer_ser_candidato', 'Quer ser candidato?', true],
            ['foi_candidato', 'Já foi candidato?', true],
            ['atual_anterior_eleito', 'Já foi eleito?', true],
            ['cargo_confianca', 'Já foi comissionado?', true],
            ['atuacoesProfissionais', 'Atuações profissionais'],
            ['areasInteresse', 'Áreas de interesse']
        ];
        o += getNavigation();
        o += '<h1>Filiados(as) (dados para administradores)</h1>';
        o += '<p>Esta lista é de uso exclusivo dos administradores, permitindo acesso a dados pessoais. Utilize este recurso com moderação.</p>';
        o += getSearch();
        o += '<div id="list">';
        o += '<table>';
        o += '<thead>';
        o += '<tr>';
        fields.forEach(function (v) {
            o += '<th>';
            o += v[1];
            o += '</th>';
        });
        o += '</tr>';
        o += '</thead>';
        o += '<tbody>';
        listas.data.forEach(function (v, i) {
            l += '<tr>';
            fields.forEach(function (x) {
                if (v[x[0]] === undefined) {
                    v[x[0]] = '';
                }
                if (Array.isArray(v[x[0]])) {
                    l += '<td>' + v[x[0]].join(', ')  + '</td>';
                } else {
                    l += '<td>' + v[x[0]]  + '</td>';
                }
            });
            l += '</tr>';
        });
        if (l === '') {
            l += '<tr><td colspan="' + (fields.length + 1).toString()  + '" class="no-data">Nenhum dado para exibir</td></tr>';
        }
        o += l;
        o += '</tbody>';
        o += '</table>';
        o += '</div>';
        o += getControlPagination();
        o += getControlResultsPerPage();
        o += '<div class="clear"></div>';
        $('#lists').html(o);
        processHeaderFixed();
    }

    function recarregaCampos() {
        if(listas.hash[5]) {
            $('#searchbox').val(decodeURIComponent(listas.hash[5]));
        }
        $('#selectbox').val(listas.hash[6]);
    }

    function router() {
        processHash();
        if (listas.hash.length < 5) {
            listas.hash = ['filiados', '1', '50', 'nome', 'asc'];
            window.location.hash = '#/' + listas.hash.join('/');
        } else {
            insertLoading();
            switch (listas.hash[0]) {
                case 'filiados':
                    getListas(listas.hash[1], listas.hash[2], listas.hash[3] + ':' + listas.hash[4], '3', listas.hash[5], listas.hash[6], false, false, function () {
                    processFiliadosPublica();
                    recarregaCampos();
                });
                break;
                case 'abonos':
                    //getListas(listas.hash[1], listas.hash[2], '1', function () {
                    getListas(listas.hash[1], listas.hash[2], listas.hash[3] + ':' + listas.hash[4], '1', listas.hash[5], listas.hash[6], 1, 1, function () {
                    processAbonos();
                    recarregaCampos();
                });
                break;
                case 'impugnacoes':
                    //getListas(listas.hash[1], listas.hash[2], '2', function () {
                    getListas(listas.hash[1], listas.hash[2], listas.hash[3] + ':' + listas.hash[4], '2', listas.hash[5], listas.hash[6], 1, 1, function () {
                    processFiliadosPublica();
                    processImpugnacoes();
                    recarregaCampos();
                });
                break;
                case 'confirmacao':
                    //getListas(listas.hash[1], listas.hash[2], '2', function () {
                    getListas(listas.hash[1], listas.hash[2], listas.hash[3] + ':' + listas.hash[4], '8', listas.hash[5], listas.hash[6], 1, 1, function () {
                    processFiliadosAdmin();
                    processConfirmacao();
                    recarregaCampos();
                });
                break;
                case 'admin':
                    //getListas(listas.hash[1], listas.hash[2], '3', function () {
                    getListas(listas.hash[1], listas.hash[2], listas.hash[3] + ':' + listas.hash[4], '3', listas.hash[5], listas.hash[6], '1', '1', function () {
                    processFiliadosAdmin();
                    recarregaCampos();
                });
                break;
                default:
                    break;
            }
        }
    }

    function search() {
        var value = $('#searchbox').val();
        listas.hash[1] = '1';
        listas.hash[5] = encodeURIComponent(value);
        listas.hash[6] = $('#selectbox').val();
        window.location.hash = '#/' + listas.hash.join('/');
    }

    $(document).on('keypress',function (e) {
        if(e.which == 13) {
          search();
        }
    });

    $('#lists').on('click','#searchbutton', function() {
        search();
    });

    window.onhashchange = router;

    router();
});
