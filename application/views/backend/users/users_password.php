<div class="col-lg-12">
    <div class="element-box">
        <?php
            echo form_open_multipart(current_url(), array('class'=>"",'id'=>"form-contrasena"));
            echo form_hidden('enviar_form','1');
            ?>
            <h5><?php echo $result->name.' '.$result->surname  ?></h5>
            <hr>
            <div id="errores"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nueva Contraseña:</label>
                        <input type="password" name="password" id="password" required="" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Repetir Contraseña:</label>
                        <input type="password" name="repetir_password" id="repetir_password" required="" class="form-control">
                    </div>
                </div> 
            </div>
            <div class="form-group">
                <div class="controls">
                    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?> 
                    <a class="btn btn-danger" href="<?php echo base_url().'backend/'.$this->uri->segment(2); ?>"><i class="icon-circle-arrow-left icon-white"></i> Volver</a>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).on('submit', '#form-contrasena', function(event) {
        var password = $("#password").val();
        var repetir_password = $("#repetir_password").val();
        if (password != repetir_password) {
            $("#errores").html('<div class="alert alert-warning"><i class="fa fa-times"></i> Las contraseñas no coinciden.</div>');
            return false;
        }else{
            $("#errores").html('');
        }
    });
    $(document).on('keyup', '#password, #repetir_password', function(event) {
        $("#errores").html('');
    });
</script>