<div class="col-lg-12">
    <div class="element-box">
	<?php     
		echo form_open(current_url(), array('class'=>""));
		echo form_hidden('enviar_form','1');
	?>
		<div id="errorForm"></div>	
        <div class="form-group">
            <label for="postal_code">Codigo Postal<span class="required">*</span></label>
            <input id="postal_code" required type="text" name="postal_code" value="" class="form-control" placeholder="Codigo Postal" />
        </div>
        <div class="form-group">
            <label for="price_shipping">Precio de Entrega<span class="required">*</span></label>
            <input id="price_shipping" required type="text" name="price_shipping" value="" class="form-control" placeholder="Precio" />
        </div>
		<?php $tags = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'); ?>
		<div class="form-group">
		    <label for="days">Dias de Entrega<span class="required">*</span></label>
		    <select id="days" required name="days[]" class="form-control chosen-select" data-placeholder="Seleccione los dias..." multiple="">
		        <?php foreach ($tags as $key => $value): ?>
		            <option value="<?php echo $value ?>"><?php echo $value ?></option>
		        <?php endforeach ?>
		    </select>
		</div>
		<br>
		<div class="control-group">
		  <div class="controls">
		    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?> 
		    <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a>
		  </div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
        $('#postal_code').change(function() {
            var postal_code = $('#postal_code').val();    
            $.ajax({
                type: "POST",
                url: base_url + 'ecommerce/envios/ValidarCodePostal/',
                data: {postal_code: postal_code},
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 0) {
                        $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></button><strong>Ocurrio un error</strong>. Ya existe este Codigo Postal.</div>');
                        $('#postal_code').val('');
                        $('#postal_code').focus();
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Ocurrio un error</strong>. Por favor intentelo nuevamente!.</div>');
                }
            });
        });
    });
</script>