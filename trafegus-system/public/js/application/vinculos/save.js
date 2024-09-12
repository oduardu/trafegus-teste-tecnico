$(document).ready(function() {
    $('#bondForm').on('submit', function(event) {
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    alert('Vínculo salvo com sucesso!');
                    window.location.href = '/vinculos';
                } else {
                    alert('Erro ao salvar Vínculo: ' + response.message);
                }
            },
            error: function() {
                alert('Erro ao processar a solicitação.');
            }
        });
    });
});