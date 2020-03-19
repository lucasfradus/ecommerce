<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
			echo form_hidden('id',$result->id_category);
		?>
			<div class="form-group">
                <label class="control-label" for="categoria_id">Categoría<span class="required">*</span></label>
                <select id="categoria_id" name="categoria_id" class="form-control chosen-select" required>
                  	<?php foreach ($categorias as $f) { ?>
                    	<option value="<?php echo $f->id_category ?>" <?php if($f->id_category == $result->id_category) echo 'selected' ?>><?php echo $f->name ?></option>
                  	<?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label class="control-label" for="nombre">Nombre<span class="required">*</span></label>
                <input id="nombre" required type="text" name="nombre" value="<?php echo $result->name ?>" class="form-control" placeholder="nombre" />
            </div>
                                    
			<div class="control-group">
				<div class="controls">
					<?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?>
					<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a>
				</div>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>