<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open_multipart(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->id_slider_marcas) ?>
			<div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
				<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-back"></i> Volver</a><hr>
            </div>
			
            <div class="form-group">
                <label for="nombre">Nombre<span>*</span></label>
                <input  id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" value="<?php echo $result->nombre_slider_marcas ?>" />
            </div>
            <div class="form-group">
                <label for="imagen">Imagen</label>
                <input id="imagen"  accept="image/*" name="imagen" type="file"  class="form-control" />
                <?php if (!empty($result->image)): ?>
                    <span class="help-text text-danger"><strong>Imagen:</strong> <?php echo $result->image ?></span>
                <?php endif ?>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>