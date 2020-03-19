$(document).ready(function(){
    $('#form_recuperar').validate({
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        messages: {
            email: {
                required: "Requerido",
                email: "No es un email valido."
            }
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $('#btn-recuperar-pass').click(function(event) {
        if ($('#form_recuperar').valid()){
            $.ajax({
                type: "POST",
                url: base_url + 'recuperar-password',
                data: $('#form_recuperar').serialize(),
                cache: false,
                success: function(respuesta){
                    var datos = jQuery.parseJSON(respuesta);
                    $('#errorFormLogin').html('');
                    if (datos.Value == 1) {
                        $('#envio-correcto').show();
                    }else{
                        $('#envio-error').show();
                    }                     
                }
            });
        }
    });

});