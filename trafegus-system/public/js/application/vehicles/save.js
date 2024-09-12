$(document).ready(function() {
    $('#vehicleForm').on('submit', function (event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.success) {
                    alert('Veículo salvo com sucesso!');
                    window.location.href = '/vehicles';
                } else {
                    alert('Erro ao salvar veículo: ' + response.message);
                }
            },
            error: function () {
                alert('Erro ao processar a solicitação.');
            }
        });
    });
});