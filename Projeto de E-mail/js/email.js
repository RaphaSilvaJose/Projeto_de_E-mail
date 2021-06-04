$(document).ready(function () {
//Rolagem automatica final do chat //

    setTimeout(() => { 
        // 
        var target_offset_ = $("#chat_ .main-content").offset();
            var target_top_ = target_offset_.top; 
            var altura = $("#chat_").height();
            var result = parseInt(altura) - parseInt(target_top_)
            $('#chat_').animate({ scrollTop: result + 1000000 }, 0);
          }, 100);

});

var btn = document.getElementById("btn");

//Função pegar dados do formulario e fazer um ajax //
$('#btn').on('click', function () {

    //Recebendo os dados e substituindo tags //
    var data = $('#textarea').val();
    var email_from = $('#from').val();
    var to = $('#to').val();
    var user_id = $('#user_id').val();
    var dado_id = $('#dado_id').val();

    //Criando array de envio //
    var content= {};
    content.dado = dado_id;
    content.user = user_id;
    content.data = data;
    content.from = email_from;
    content.to = to;
    
    //Fazendo chamada ajax //
    chamadaAjaxSimples(
        webroot + 'emails/recebidos_emails/', "POST", "text", 
        {
            data:content
        },
        function () { },
        function () {
            //success
            
        },
        function () {
            //complete
            console.log(data);
        },
        function (error) {
            app.toast('Houve uma falha na comunicação! Tente novamente mais tarde.');
            console.log(error);
        }, 0, 1
    );
    //Reload pagina
    $('.modal-content #email').trigger( "click" );
})

    



