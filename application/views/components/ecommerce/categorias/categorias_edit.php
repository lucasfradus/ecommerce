<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id',$result->id_category) ?>
			
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