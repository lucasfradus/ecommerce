<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->id_shipping) ?>
            <div class="form-group">
				<label for="postal_code">Codigo Postal<span class="required">*</span></label>
				<input id="postal_code" required type="text" name="postal_code" value="<?php echo $result->postal_code ?>" class="form-control" placeholder="Codigo Postal" />
           	</div>
			<div class="form-group">
				<label for="price_shipping">Precio de Entrega<span class="required">*</span></label>
				<input id="price_shipping" required type="text" name="price_shipping" value="<?php echo $result->price_shipping ?>" class="form-control" placeholder="Precio" />
			</div>
			<?php $tags = array('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'); ?>
			<div class="form-group">
				<label for="days">Dias de Entrega<span class="required">*</span></label>
				<select id="days" required name="days[]" class="form-control chosen-select" data-placeholder="Seleccione los dias..." multiple="">
					<?php foreach ($tags as $key => $value): ?>
                        <?php $selected = '';foreach ($days as $k => $v): ?>
                            	<?php if ($v->days == $value): $selected = 'selected'; ?>
                            	<?php endif ?>
                        <?php endforeach ?>
                        <option value="<?php echo $value ?>" <?php echo $selected ?>><?php echo $value ?></option>
                    <?php endforeach ?>
				</select>
			</div>
			<br>  
			<div class="control-group">
				<div class="controls">
					<?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?>
					<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>