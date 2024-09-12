$(document).ready(function() {
    $('.delete').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            data: {
                placa: $(this).data('placa'),
                cpf: $(this).data('cpf')
            },
            success: function(response) {
                if (response.success) {
                    alert('Vínculo deletado com sucesso!');
                    window.location.reload();
                } else {
                    alert('Erro ao deletar vínculo: ' + response.message);
                }
            },
            error: function(data) {
                console.log(data)
                alert('Erro ao processar a solicitação.');
            }
        });
    });
});