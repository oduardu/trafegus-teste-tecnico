$(document).ready(function() {
    $('.delete').on('click', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            data: {
                placa: $(this).data('placa')
            },
            success: function(response) {
                if (response.success) {
                    alert('Veículo deletado com sucesso!');
                    window.location.reload();
                } else {
                    alert('Erro ao deletar veículo: ' + response.message);
                }
            },
            error: function(data) {
                console.log(data)
                alert('Erro ao processar a solicitação.');
            }
        });
    });
});