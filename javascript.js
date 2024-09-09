$(document).ready(function () {
    $('#form1').on('submit', function(event){
        event.preventDefault();
        var dados = $(this).serialize();
        var cep = $('#cep').val();

        $.ajax({
            url: 'correios.php', // Altere para o caminho do seu script PHP
            method: 'GET',
            data: { cep: cep }, // Passa o CEP como parâmetro
            dataType: 'json',
            success: function(response){
                if (response.erro) {
                    Swal.fire({
                        title: 'CEP',
                        text: 'CEP não encontrado! Tente novamente.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    $('#cep').val('');
                } else {
                    $('.ResultadoCEP').html(
                        '<div>' + response.logradouro + ' , ' + response.bairro + ' - ' + response.localidade + ' - ' + response.uf + '</div>'
                    );
                }
            },
            error: function(){
                Swal.fire({
                    title: 'CEP',
                    text: 'Ocorreu um erro na busca do CEP! Tente novamente.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $('#cep').val('');
            },
        });
    });
});
