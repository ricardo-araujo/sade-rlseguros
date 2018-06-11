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
            url: '/home',
            data: { '_token': token, 'licitacao': idLicitacao, 'reserva': input.val() },
            dataType: 'json',
            success: function(data) {
                // para nao fazer append no html atual, remove ele antes de adicionar o button da reserva
                if (div.html().trim() == 'Nenhuma Reserva para a oportunidade.') { div.html(''); }

                div.append('<button id="btn-reserva-' + data.nm_reserva + '" type="button" onclick="deleteReserva(\'' + data.nm_reserva + '\')" title="Clique na reserva para excluí-la" class="btn btn-outline-primary btn-sm ml-1">' + data.nm_reserva+ '</button>');
                input.val('').focus();
            },
            error: function(data) {
                let message = data.responseJSON.errors['reserva'][0];

                input.removeClass('form-control')
                     .addClass('form-control is-invalid')
                     .focus();
                if ($('.invalid-feedback').length == 0) {
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
            url: '/home',
            data: {'_token': token, 'reserva': nuReserva},
            dataType: 'json',
            success: function(data) {
                button.remove();

                if (parentDiv.html() == '') {
                    parentDiv.html('Nenhuma Reserva para a oportunidade.');
                }
            },
            error: function(data) {
                console.log(data.responseJSON.message);
            }
        });
    });
}