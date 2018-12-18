$(document).ready(() => {

    const body = $('body');

    body.on('click', '#btn-redefinir-senha-modal', () => {

        const input = $('#senha');

        $.ajax({
            type: 'PUT',
            url: '/senha/redefine',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'senha': input.val(),
                'senha_confirmation': $('#senha_confirmation').val()
            }
        })
        .done(() => {

            criaDivSenhaAlteradaComSucesso();
            resetaValoresSenha();
            removeSpanDeErro();

        })
        .fail(data => {

            renderizaErros('senha', data.responseJSON.errors, input);

        });
    });


    body.on('click', '#btn-fecha-redefinir-senha-modal', () => {

        $('#modal-redefinir-senha').modal('toggle');

        removeSpanDeErro();

        $('#senha').val('');
        $('#senha_confirmation').val('');
        $('#div-alert-senha-alterada').remove();

    });

    body.on('click', '.btn-cadastro', event => {

        const licitacao = event.currentTarget.id.match(/\d+/g)[0];
        const input = $(`#input-reserva-${licitacao}`);

        $.ajax({
            type: 'POST',
            url: '/cn/reserva/create',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'licitacao': licitacao,
                'reserva': input.val()
            }
        })
        .done(reserva => {

            removeTextoDivLicitacao(licitacao);
            criaBotaoReservaCN(licitacao, reserva);
            input.val('').focus();
            removeSpanDeErro();

        })
        .fail(err => {

            renderizaErros('reserva', err.responseJSON.errors, input);

        });
    });

    body.on('click', '.btn-reserva', event => {

        const reserva = event.currentTarget.id.match(/\d+/g)[0];
        const btn = $(event.currentTarget);
        const div = btn.parent();

        $.ajax({
            type: 'DELETE',
            url: '/cn/reserva/delete',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'reserva': reserva
            },
        })
        .done(() => {

            btn.remove();

            if (div.html().trim() === '')
                div.html('Nenhuma reserva para a oportunidade.');

        })
        .fail(err => {

            console.error(err);

        });
    });

    body.on('click', '#btn-orgao', () => {
        $.ajax({
            url: '/orgao',
            data: {
                'content': $('#input-orgao').val()
            },
        })
        .done(orgao => {

            criaDivOrgaoEncontrado(orgao);

        })
        .fail(() => {

            criaDivOrgaoNaoEncontrado();

        });
    });

    body.on('click', '.btn-manual', () => {

        $.ajax({
            type: 'PUT',
            url: '/orgao',
            dataType: 'json',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'content' : $('#input-orgao').val()
            }
        })
        .done(orgao => {

            criaDivOrgaoEncontrado(orgao);

        })
        .fail(err => {

            console.error(err);

        });
    });

    function criaDivSenhaAlteradaComSucesso() {

        if ($('#div-alert-senha-alterada').length > 0)
            return true;

        const modal = $('#modal-body-senha');
        const div = $('<div>').attr('id', 'div-alert-senha-alterada')
                              .addClass('alert alert-success text-center')
                              .attr('role', 'alert')
                              .text('Senha alterada com sucesso!');

        modal.prepend(div.hide().fadeIn(500));
    }

    function resetaValoresSenha() {

        $('#senha').val('');
        $('#senha_confirmation').val('');
    }

    function renderizaErros(key, erros, targetElement) {

        const msgErro = erros[key][0];
        const spanErro = $('<span>').addClass('invalid-feedback');
        const strongTag = $('<strong>').text(msgErro);

        targetElement.focus();

        if (targetElement.siblings('span').text() === msgErro)
            return;

        removeSpanDeErro();

        spanErro.append(strongTag);
        targetElement.addClass('is-invalid').parent().append(spanErro);
    }

    function removeTextoDivLicitacao(licitacao) {

        const div = $(`#div-reserva-${licitacao}`);

        if (div.html().trim() === 'Nenhuma reserva para a oportunidade.') //Remove texto antes de adicionar o button da reserva
            div.html('');
    }

    function criaBotaoReservaCN(licitacao, reserva) {

        const div = $(`#div-reserva-${licitacao}`);
        const btn = $('<button>').attr('id', `btn-reserva-${reserva.nm_reserva}`)
                                 .attr('type', 'button')
                                 .addClass('btn btn-outline-primary btn-sm btn-reserva ml-1')
                                 .attr('title', 'Clique na reserva para excluí-la')
                                 .text(reserva.nm_reserva);

        div.append(btn);
    }

    function removeSpanDeErro() {

        const spanFeedback = $('.invalid-feedback');

        if (spanFeedback.length > 0)
            spanFeedback.remove();

        $('.is-invalid').removeClass('is-invalid');
    }

    function criaDivOrgaoEncontrado(orgao) {

        const div = $('#div-orgao').html('').addClass('container border rounded p-3');
        const dl = $('<dl>');
        const dtOrgao = $('<dt>').text('Órgão');
        const ddOrgao = $('<dd>').text(orgao.nm_razao_social);
        const dtCnpj = $('<dt>').text('Cnpj');
        const ddCnpj = $('<dd>').text(orgao.nm_cnpj);
        const dtCodMapfre = $('<dt>').text('Cód. Mapfre');
        const ddCodMapfre = $('<dd>').text(orgao.nm_cod_mapfre);
        const btnManual = botaoManual(orgao);

        dl.append(dtOrgao);
        dl.append(ddOrgao);
        dl.append(dtCnpj);
        dl.append(ddCnpj);
        dl.append(dtCodMapfre);
        dl.append(ddCodMapfre);
        div.append(dl);
        div.append($('<hr>'));
        div.append(btnManual);
    }

    function botaoManual(orgao) {

        const btnManual = $('<button>').attr('type', 'button').addClass('btn btn-outline-primary btn-manual');
        const i = $('<i>').attr('aria-hidden', true);

        if (orgao.is_manual) {

            btnManual.attr('title', 'Modo manual');
            i.addClass('fa fa-hand-paper-o');

        } else {

            btnManual.attr('title', 'Modo automático');
            i.addClass('fa fa-laptop');

        }

        btnManual.append(i);

        return btnManual;
    }

    function criaDivOrgaoNaoEncontrado() {

        const div = $('#div-orgao').html('');
        const small = $('<small>').addClass('text-danger').text('Órgão não encontrado');

        div.append(small);
    }
});
