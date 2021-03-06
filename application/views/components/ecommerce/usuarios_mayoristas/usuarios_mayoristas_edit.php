<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/frontend/extras/jquery-ui/jquery-ui.min.css') ?>">
<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open_multipart(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
		<?php echo form_hidden('id',$usuario->id_users) ?>
        <div class="row">
            <div class="col-lg-12">
                <h6 class="subtitle-profile">INFORMACIÓN PERSONAL</h6>
                <hr> 
                    <div class="row">
                        <div class="col-sm-12">
                             <div class="row">  
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="dni"> DNI/CUIT</label>
                                        <input  id="dni" name="dni" type="text" class="form-control" placeholder="" value="<?php echo $usuario->dni ?>" data-bv-notempty-message="Campo requerido" />
                                    </div>
                                </div>
                             </div>                   
                        </div>    
                        <div class="col-md-6">               
                            <div class="form-group">
                                <label for="nombre">Nombre<span class="required">*</span></label>
                                <input  id="nombre" name="nombre" class="form-control" type="text" placeholder="Nombre" value="<?php echo $usuario->name ?>" data-bv-notempty-message="Campo requerido">
                            </div>
                            </div>
                        <div class="col-md-6">               
                            <div class="form-group">
                                <label for="apellido"> Apellido<span class="required">*</span></label>
                                <input id="apellido" name="apellido" class="form-control " type="text" placeholder="Apellido" value="<?php echo $usuario->surname ?>" data-bv-notempty-message="Campo requerido">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="pais"> País</label>
                                        <input  id="pais" name="pais" type="text" class="form-control" placeholder="Pais" value="<?php echo $usuario->country ?>" />                    
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="residencia">Condición de IVA</label>
                                        <select name="condicion_iva" class="form-control" id="condicion_iva" required="">
                                            <option value="">Seleccione</option>
                                            <?php foreach ($IVA as $key => $value): ?>
                                            <option value="<?php echo $value->id_condition_iva ?>" <?php echo ($usuario->id_condition_iva == $value->id_condition_iva) ? 'selected' : ''; ?>><?php echo $value->name ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="residencia"> Provincia</label>
                                <select name="provincia_id" class="form-control" id="provincia_residencia" required="">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($provincias as $key => $value): ?>
                                    <option value="<?php echo $value->id ?>" <?php echo ($usuario->provincia_id == $value->id) ? 'selected' : '' ; ?>><?php echo $value->provincia ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="residencia"> Localidad</label>
                                <select name="localidad_id" class="form-control" id="localidades_residencia" required="">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($localidades as $key => $value): ?>
                                    <option value="<?php echo $value->id ?>" <?php echo ($usuario->localidad_id == $value->id) ? 'selected' : '' ; ?>><?php echo $value->localidad ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                    </div>
                        <h6 class="subtitle-profile">INFORMACIÓN DE CONTACTO</h6>
                        <hr>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="direccion"> Dirección</label>
                                <input  id="direccion" name="direccion" type="text" class="form-control" placeholder="Dirección" value="<?php echo $usuario->address ?>" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="telefono"> Teléfono</label>
                                <input  id="telefono" name="telefono" type="text" class="form-control" placeholder="Telefono" value="<?php echo $usuario->phone ?>" />
                            </div>
                        </div> 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="residencia"> Lista de Precios</label>
                                <select name="precios_id" class="form-control" id="precios_id" required="">
                                    <option value="">Seleccione</option>
                                    <?php foreach ($pricelist as $key => $value): ?>
                                    <option value="<?php echo $value->id_list_price ?>" <?php echo ($usuario->id_list_price == $value->id_list_price) ? 'selected' : '' ; ?>><?php echo $value->name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>               
                        <div class="form-group">
                            <label for="active">Estado</label>
                            <label class="radio-inline">
                                <input type="radio" name="status" id="status" value="1" <?php if ($usuario->status_code_confirmation == 1) echo 'checked' ?> /> Habilitado
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="status" id="status" value="0" <?php if ($usuario->status_code_confirmation == 0) echo 'checked' ?> /> Inhabilitado
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="controls">
                    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), "Guardar"); ?> 
                    <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>">Volver</a>
                </div>
            </div>
        </div>
		<?php echo form_close(); ?>
	</div>
</div>
<script src="<?php echo base_url('assets/frontend/extras/jquery-ui/jquery-ui.min.js') ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('assets/frontend/extras/bootstrapvalidator/js/bootstrapValidator.js')?>"></script>
<SCRIPT TYPE="text/javascript">
    var base_url = '<?php echo base_url() ?>';
    function calificar(){
        let d = Math.floor(Math.random()*(6-0))+0;
        document.getElementById("valorizacion").value=d;
        
    }
    $('input,select').attr('disabled', 'disabled');
    $('input[name="status"],select[name="precios_id"],select[name="condicion_iva"]').removeAttr('disabled');

    $(document).on('change', '#provincia_residencia', function(event) {
        event.preventDefault();
        var ide = $(this).val();
        $.ajax({
            url: base_url+'frontend/ecommerce/getLocalidadesProvincia',
            type: 'POST',
            dataType: 'json',
            data: {id: ide},
            beforeSend:function(){
                $("#localidades_residencia").attr('disabled','');
            }
        })
        .done(function(data) {
            var dataJson = eval(data);
            var htm = '';
            $.each(dataJson.localidades, function(index, value) {
                htm+='<option value="'+value.id+'"><a href="#">'+value.localidad+'</option>';
            });
            $("#localidades_residencia").html(htm);
            $("#localidades_residencia").removeAttr('disabled');
            $('#localidades_residencia').select2();
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    });

    $(document).on('submit', 'form#changePassword', function(event) {
        event.preventDefault();

        var password_a = $(this).find('input#password'),
            password_b = $(this).find('input#password_n');
            
        if (password_a.val() != password_b.val()) { 
            password_a.parent('div.form-group').addClass('has-error');
            password_b.parent('div.form-group').addClass('has-error');
            return false;
        }

        else { 
            password_a.parent('div.form-group').removeClass('has-error').addClass('has-succes');
            password_b.parent('div.form-group').removeClass('has-error').addClass('has-succes');
            $(this).submit();
        }
    });

    $(function() {
        $("#localidades_list .form-group").each(function(index) {
            var elemento = $(this).find('select');
            $.each(localidades_user, function(k, v) {
                elemento.find("option[value='"+v.localidad_id+"']").attr('selected', '');
            });
            $('.chosen-select-list').select2();
        });


        $("#provincia").on("change",function(event){
            event.preventDefault();
            var provincia = $("#provincia").val();
            var selects = $("#localidades_list div.form-group").length;

            if(provincia != null){
                if ((provincia.length) < selects) {
                    $("#localidades_list .form-group").each(function(index){
                        var element = $(this);
                        var id = $(this).attr("data-id");
                        if ($.inArray(id,provincia)== -1) {
                            element.remove();
                        }
                    });
                }else{
                    $.each(provincia,function(key, value){
                        if(!$("#localidades_list #localidad_"+value).length){
                            var pro_name = $("#provincia").find("option[value="+value+"]").text();
                            $.ajax({
                                type: 'POST',
                                url: base_url+'frontend/ecommerce/getLocalidadesProvincia',
                                async:false,
                                data: {id:value},
                                dataType:'json',
                            }).done(function(response){
                                var dataJson = eval(response);
                                var htm = '<div class="form-group" data-id="'+value+'"><label>Localidades ('+pro_name+')</label><select id="localidad_'+value+'" class="form-control chosen-select-list" data-placeholder="Seleccione sus localidades" name="localidad['+value+'][]" multiple="" required="">';
                                $.each(dataJson.localidades,function(key,valor){
                                    htm+='<option value="'+valor.id+'">'+valor.localidad+'</option>';
                                });
                                htm+='</select></div>';
                                $("#localidades_list").append(htm);
                                
                            }).fail(function(){
                                console.log("error");
                            }).always(function(){
                                $('.chosen-select-list').select2();
                            });
                        }
                    });
                }

            }else{
                $("#localidades_list").html('');
            }

        });

        $("#licencia_conducir").on('change', function(event) {
            //event.preventDefault();
            
            var values = $(this).val();
            if (values != null) {
                $.each(values, function(index, val) {
                    if (val == 'No poseo') {
                        $("#licencia_conducir").val('No poseo');
                    }
                });
                $('#licencia_conducir').select2();
            }
            /*else{
                $('#licencia_conducir').trigger("chosen:updated");
            }*/

        });

    });

    $(document).ready(function() {
        setTimeout(function() {
            $("#errorFormRegistrar").fadeOut(1500);
        },3000);

        $("#experiencia").change(function(event) {
            var datos   =   $(this).val();
            var htm     =   '';

            if (datos != null) {
                $.each(datos,function(index, value) {   
                    nombre  =   $("#experiencia option[value="+value+"]").text();
                    
                    htm+=  '<div class="form-group">'+
                                '<label>Años de experiencia: '+nombre+'</label> <input type="text" class="experiencia_label" readonly style="border:0; color:#f6931f; font-weight:bold;" value="1 AÑO">'+
                                '<input class="form-control" type="hidden" name="anos_experiencia[]" id="rubro_experiencia_'+value+'" value="1">'+
                                '<div class="slider-range-min" data-id="#rubro_experiencia_'+value+'"></div>'+
                            '</div>';
                });
            }

            $("#anios-experiencia").html(htm);

            $(".slider-range-min").slider({
              range: "min",
              value: 1,
              min: 1,
              max: 25,
              slide: function( event, ui ) {
                var ide = $(this).attr('data-id');
                $(ide).val(ui.value);
                $(ide).closest('.form-group').find('.experiencia_label').val(ui.value+' AÑOS');
              }
            });
            //$("#trayectoria").val(" "+$( "#slider-range-min" ).slider("value")+" AÑOS");

        });

        $('#idiomas').change(function() {
            var datos   =   $(this).val();
            var htm     =   '';
            
            if (datos != null) {

                $.each(datos,function(index, value) {   
                    nombre  =   $("#idiomas option[value="+value+"]").text();         
                    htm+=  '<div class="form-group">'+
                                '<label>Nivel ('+nombre+')</label>'+
                                '<select class="form-control" name="nivel_idiomas[]">'+
                                    '<option value="1">Bajo</option>'+
                                    '<option value="2">Medio</option>'+
                                    '<option value="3">Alto</option>'+
                                '</select>'+
                            '</div>';
                });

            }

            $("#niveles-idiomas").html(htm);
        });

        

    });

    $('#tipo_usuario_id').change(function(){
        if ($('#tipo_usuario_id').val() == 1){  
            $('#cuil').val('');             
            $('#camp_cuil').css({display: 'none'});            
        }else{
            $('#camp_cuil').css({display: 'block'});
        }
    });  

    $(document).ready(function(){
        if ($('#tipo_usuario_id').val() == 1){               
            $('#camp_cuil').css({display: 'none'});
        }else{
            $('#camp_cuil').css({display: 'block'});
        }
    });

    $(document).ready(function() {
        $('#form_editar_cuenta').bootstrapValidator().on('success.form.bv', function(e) {
            e.preventDefault();
            var formulario = $('#form_editar_cuenta').serialize();    
            $.ajax({
                type: "POST",
                url: base_url + 'editar-cuenta',
                data: formulario,
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 1) {
                        $('#errorForm').html('');
                        $("#modalOkCuenta").modal();
                        window.setTimeout(cerrarModalOkCuenta, 2400);
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $("#modalKo").modal();
                    window.setTimeout(modalKo, 2400);
                }
            });
        });
    });
    function cerrarModalOkCuenta(){
        $('#modalOkCuenta').modal('hide');
    }  

    $(document).ready(function() {
        $('#form_editar_entrega').bootstrapValidator().on('success.form.bv', function(e) {
            e.preventDefault();
            var formulario = $('#form_editar_entrega').serialize();    
            $.ajax({
                type: "POST",
                url: base_url + 'editar-entrega',
                data: formulario,
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 1) {
                        $('#errorForm').html('');
                        $("#modalOkEntrega").modal();
                        window.setTimeout(cerrarModalOkEntrega, 2400);
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $("#modalKo").modal();
                    window.setTimeout(cerrarModalKo, 2400);
                }
            });
        });
    });

    
    function cerrarModalKo(){
        $('#modalKo').modal('hide');
    }  

    function cerrarModalOkEntrega(){
        $('#modalOkEntrega').modal('hide');
    }  

    $(document).ready(function() {
        $('#form_editar_password').bootstrapValidator().on('success.form.bv', function(e) {
            e.preventDefault();
            var formulario = $('#form_editar_password').serialize();    
            $.ajax({
                type: "POST",
                url: base_url + 'editar-password',
                data: formulario,
                cache: false, 
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },              
                success: function(respuesta){
                    $('#errorForm').html('');
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 1) {
                        $("#modalOkContrasena").modal();
                        window.setTimeout(cerrarModalOkContrasena, 2400);
                        $('#form_editar_password').bootstrapValidator('resetForm', true); 
                        $('#password_actual').focus();
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $("#modalKo").modal();
                    window.setTimeout(modalKo, 2400);
                }
            });
        });
    });


    function cerrarModalOkContrasena(){
        $('#modalOkContrasena').modal('hide');
    }  


    $('#password_actual').change(function() {
        var password = $('#password_actual').val();    
        $.ajax({
            type: "POST",
            url: base_url + 'editar-password',
            data: {password: password},
            cache: false,
            beforeSend: function(){
                $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
            },
            success: function(respuesta){
                $('#errorForm').html('');
                var json = jQuery.parseJSON(respuesta);
                if (json.Value == 0) {
                    $("#modalKoContrasena").modal();
                    window.setTimeout(cerrarModalKoContrasena, 2400);
                    $('#password_actual').val('');
                    $('#password_actual').focus();
                }else{
                    $('#errorForm').html('');
                }                
            },
            error: function(){
                $("#modalKo").modal();
                window.setTimeout(modalKo, 2400);
            }
        });
    });


    function cerrarModalKoContrasena(){
        $('#modalKoContrasena').modal('hide');
    }  

    $(document).ready(function() {
        $('#usuario').change(function() {
            var usuario = $('#usuario').val();    
            $.ajax({
                type: "POST",
                url: base_url + 'validar-usuario',
                data: {usuario: usuario},
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    $('#errorForm').html('');
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 0) {
                        $("#modalKoUsuario").modal();
                        window.setTimeout(modalKoUsuario, 2400);
                        $('#usuario').val('');
                        $('#usuario').focus();
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $("#modalKo").modal();
                    window.setTimeout(modalKo, 2400);
                }
            });
        });


        $("#provincia").on("change",function(event){
            event.preventDefault();
            var provincia = $("#provincia").val();
            var selects = $("#localidades_list div.form-group").length;

            if(provincia != null){

                if ((provincia.length) < selects) {
                    $("#localidades_list .form-group").each(function(index){
                        var element = $(this);
                        var id = $(this).attr("data-id");
                        if ($.inArray(id,provincia)== -1) {
                            element.remove();
                        }
                    });
                }else{
                    $.each(provincia,function(key, value){
                        if(!$("#localidades_list #localidad_"+value).length){
                            var pro_name = $("#provincia").find("option[value="+value+"]").text();
                            $.ajax({
                                type: 'POST',
                                url: base_url+'frontend/ecommerce/getLocalidadesProvincia',
                                async:false,
                                data: {id:value},
                                dataType:'json',
                            }).done(function(response){
                                var dataJson = eval(response);
                                var htm = '<div class="form-group" data-id="'+value+'"><label>Localidades ('+pro_name+')</label><select id="localidad_'+value+'" class="form-control chosen-select-list" data-placeholder="Seleccione sus localidades" name="localidad['+value+'][]" multiple="" required="">';
                                $.each(dataJson.localidades,function(key,valor){
                                    htm+='<option value="'+valor.id+'">'+valor.localidad+'</option>';
                                });
                                htm+='</select></div>';
                                $("#localidades_list").append(htm);
                                
                            }).fail(function(){
                                console.log("error");
                            }).always(function(){
                                $('.chosen-select-list').select2();
                            });
                        }
                    });
                }
            }else{
                $("#localidades_list").html('');
            }
        });


    });

    $(document).ready(function() {
        $('#email').change(function() {
            var email = $('#email').val();    
            $.ajax({
                type: "POST",
                url: base_url + 'validar-email',
                data: {email: email},
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    $('#errorForm').html('');
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 0) {
                        $("#modalKoEmail").modal();
                        window.setTimeout(cerrarModalKoEmail, 2400);
                        $('#email').val('');
                        $('#email').focus();
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $("#modalKo").modal();
                    window.setTimeout(modalKo, 2400);
                }
            });
        });
    });

    $(document).on('click', '.btn-imagen-upload', function(event) {
        event.preventDefault();
        document.getElementById('upload-input-image').click();
    });



    function cerrarModalKoEmail(){
        $('#modalKoEmail').modal('hide');
    }  

    function readURLogotipo(input, imagen) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            //$('#'+imagen).attr('src', e.target.result);
            $("#"+imagen).attr("style", "background: url("+e.target.result+");background-size: contain;background-repeat: no-repeat;background-position: center;width: 224px;height: 224px;");
        };
        reader.readAsDataURL(input.files[0]);
      }

    }


    /*function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            //$('#image-user').attr('src', e.target.result);
            $("#image-user").attr('style', 'background: url('+e.target.result+');background-size: contain;background-repeat: no-repeat;background-position: center;width: 195px;height: 195px;');

        };
        reader.readAsDataURL(input.files[0]);


      }
    }*/

    

</script>