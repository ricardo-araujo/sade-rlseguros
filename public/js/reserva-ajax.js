$('#btn-fecha-redefinir-senha-modal').click(function() {

    $('#modal-redefinir-senha').modal('toggle');

    let errorSpam = $('.invalid-feedback');

    if (errorSpam.length > 0) {
        errorSpam.remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    $('#senha').val('');
    $('#senha_confirmation').val('');
});

$('#btn-redefinir-senha-modal').click(function() {

    let inputSenha = $('#senha');
    let inputConfirmaSenha = $('#senha_confirmation');
    let token = $('meta[name="csrf-token"]').attr('content');
    let errorSpam = $('.invalid-feedback');

    if (errorSpam.length > 0) {
        errorSpam.remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    $(document).ready(function() {

        $.ajax({
            type: 'PUT',
            url: '/senha/redefine',
            data: { '_token': token, 'senha': inputSenha.val(), 'senha_confirmation': inputConfirmaSenha.val() },
            dataType: 'json',
            success: function(data) {

                $('#modal-redefinir-senha').modal('toggle');
                inputSenha.val('');
                inputConfirmaSenha.val('');
            },
            error: function(data) {

                let errors = data.responseJSON.errors;

                for (let err in errors) {
                    if (errors.hasOwnProperty(err)) {
                        let input = $('#' + err);
                        input.removeClass('form-control').addClass('form-control is-invalid');
                        let errorMsg = errors[err][0];
                        input.after('<span class="invalid-feedback"><strong>' + errorMsg + '</strong></span>')
                    }
                }
            }
        });
    });
});

$('#btn-fecha-reserva-io-modal').click(function() {

    $('#modal-inclui-reserva-io').modal('toggle');

    let errorSpam = $('.invalid-feedback');

    if (errorSpam.length > 0) {
        errorSpam.remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    $('#input-reserva').val('');
    $('#input-cnpj').val('');
    $('#input-processo').val('');
});

$('#btn-grava-reserva-io-modal').click(function() {

    let inputReserva = $('#input-reserva');
    let inputCNPJ = $('#input-cnpj');
    let inputProcesso = $('#input-processo');
    let divReserva = $('#div-reserva-io');
    let token = $('meta[name="csrf-token"]').attr('content');
    let errorSpam = $('.invalid-feedback');

    //remove as respectivas classes de erro caso elas estejam presentes
    if (errorSpam.length > 0) {
        errorSpam.remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    //ajax para cadastrar a reserva
    $(document).ready(function() {

        $.ajax({
            type: 'POST',
            url: '/io/reserva/create',
            data: { '_token': token, 'reserva': inputReserva.val(), 'cnpj': inputCNPJ.val(), 'processo': inputProcesso.val() },
            dataType: 'json',
            success: function(data) {

                inputReserva.val('');
                inputCNPJ.val('');
                inputProcesso.val('');

                let buttonReserva = $('<button>').addClass('btn btn-outline-primary btn-sm ml-1').text(data.nm_reserva).prop('title', 'Clique na reserva para excluí-la');
                divReserva.append(buttonReserva);

            },
            error: function(data) {
                let errors = data.responseJSON.errors;

                for (let err in errors) {
                    if (errors.hasOwnProperty(err)) {
                        let input = $('#input-' + err);
                        input.removeClass('form-control').addClass('form-control is-invalid');
                        let errorMsg = errors[err][0];
                        input.after('<span class="invalid-feedback"><strong>' + errorMsg + '</strong></span>')
                    }
                }
            }
        });
    });
});

function addReserva(idLicitacao) {

    let div = $('#div-reserva-' + idLicitacao);
    let input = $('#input-reserva-' + idLicitacao);
    let token = $('meta[name="csrf-token"]').attr('content');
    let errorSpam = $('.invalid-feedback');

    //remove as respectivas classes de erro caso elas estejam presentes
    if (errorSpam.length > 0) {
        errorSpam.remove();
        $('.is-invalid').removeClass('is-invalid');
    }

    //zera o valor de todos os inputs exceto o atual
    $('input').not(input).each(function() {
        $(this).val('');
    });

    //ajax para cadastrar a reserva
    $(document).ready(function() {

        $.ajax({
            type: 'POST',
            url: '/cn/reserva/create',
            data: { '_token': token, 'licitacao': idLicitacao, 'reserva': input.val() },
            dataType: 'json',
            success: function(data) {
                // para nao fazer append no html atual, remove ele antes de adicionar o button da reserva
                if (div.html().trim() === 'Nenhuma Reserva para a oportunidade.') { div.html(''); }

                div.append('<button id="btn-reserva-' + data.nm_reserva + '" type="button" onclick="deleteReserva(\'' + data.nm_reserva + '\')" title="Clique na reserva para excluí-la" class="btn btn-outline-primary btn-sm ml-1">' + data.nm_reserva+ '</button>');
                input.val('').focus();
            },
            error: function(data) {

                let message = data.responseJSON.errors['reserva'][0];

                input.removeClass('form-control')
                     .addClass('form-control is-invalid')
                     .focus();
                if ($('.invalid-feedback').length === 0) {
                    input.parent()
                         .append('<span class="invalid-feedback"><strong>' + message + '</strong></span>');
                }
            }
        });
    });
}

function deleteReserva(nuReserva) {

    $(document).ready(function() {

        let token = $('meta[name="csrf-token"]').attr('content');
        let button = $('#btn-reserva-' + nuReserva);
        let parentDiv = button.parent();

        $.ajax({
            type: 'DELETE',
            url: '/cn/reserva/delete',
            data: {'_token': token, 'reserva': nuReserva},
            dataType: 'json',
            success: function(data) {
                button.remove();

                if (parentDiv.html().trim() === '') {
                    parentDiv.html('Nenhuma Reserva para a oportunidade.');
                }
            },
            error: function(data) {
                console.log(data.responseJSON.message);
            }
        });
    });
}
