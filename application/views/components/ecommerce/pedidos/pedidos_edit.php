<div class="col-lg-12">
    <div class="element-box">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
            <?php echo form_hidden('id',$result->id_order) ?>
			<div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?>
				<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-left"></i> Volver</a><hr>
            </div>
            <div class="form-group">
                <label for="estado_id">Estado</label>
                <select id="estado_id" name="estado_id" class="form-control chosen-select" >
                    <?php foreach ($estados as $f) {?>
                        <option value="<?php echo $f->id_order_status ?>" <?php if($f->id_order_status == $result->id_status) echo "selected" ?>><?php echo $f->name ?></option>
                    <?php } ?>
                </select>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>