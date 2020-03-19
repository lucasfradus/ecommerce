<div class="col-lg-12">
    <div class="ibox-content">
		<?php     
			echo form_open(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
		?>
			<?php echo form_hidden('id_differentias_discounts',$result->id_differentias_discounts) ?>
			<div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
				<a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-circle-left"></i> Volver</a><hr>
            </div>
			<div class="row">
				<div class="col-md-3">
					<label for="name_differentias_discounts">Nombre<span class="required">*</span></label>
						<input  id="name_differentias_discounts" name="name_differentias_discounts" type="text" class="form-control" placeholder="Nombre" value="<?php echo $result->name_differentias_discounts ?>" />
						<span class="text-danger"><?php echo form_error('name_differentias_discounts');?></span>
				</div>
				<div class="col-sm-2">
					<label for="name_differentias_discounts"> <span class="required"></span></label>
					<input type='button' value='Agregar Rango' id='add' class="form-control btn btn-primary btn-md">
				</div>
				<div class="col-sm-2">
					<label for="name_differentias_discounts"><span class="required"></span></label>
					<input type='button' value='Remover Rango' id='remove' class="form-control btn btn-danger btn-md">
				</div>
			</div>
		<br>
		<?php foreach ($result->detalles as $r):  ?>
			<div class="container" >
				Rango 
			<div class="row">
				<div class="col-md-3">
						<label for="name_differentias_discounts">Cantidad Minima<span class="required">*</span></label>
						<input required id="name_differentias_discounts" name="min[]" type="number" min="0" class="form-control" placeholder="Ej:0" value="<?php echo $r->min_qty?>"/>
					</div>
					<div class="col-sm-3">
						<label for="name_differentias_discounts">Cantidad Máxima<span class="required">*</span></label>
						<input required id="name_differentias_discounts" name="max[]" type="number" class="form-control" placeholder="Ej:5" value="<?php echo $r->max_qty ?>"/>
				</div>
				<div class="col-sm-3">
					<label for="name_differentias_discounts">% Descuento<span class="required">*</span></label>
					<input required id="name_differentias_discounts" name="desc[]" type="number" class="form-control" placeholder="Ej:10" value="<?php echo $r->discount ?>"/>
				</div>			
			</div>
		</div>
		<br>



		<?php endforeach  ?>   

	
					
		<?php echo form_close(); ?>
	</div>
</div>




<script type="text/javascript" src="<?php echo base_url('assets/frontend/extras/bootstrapvalidator/js/bootstrapValidator.js')?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
	
	});

function checkRemove() {
    if ($('div.container').length == 1) {
        $('#remove').hide();
    } else {
        $('#remove').show();
    }
};
$(document).ready(function() {
    checkRemove()
    $('#add').click(function() {
        $('div.container:last').after($('div.container:first').clone());
        checkRemove();
    });
    $('#remove').click(function() {
        $('div.container:last').remove();
        checkRemove();
    });
});
</script>