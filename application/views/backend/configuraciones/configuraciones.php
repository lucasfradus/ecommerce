<div class="col-lg-12">
    <div class="element-box">
      	<?php     
        	echo form_open(current_url(), array('class'=>""));
        	echo form_hidden('enviar_form','1');
        	
      	?>

      	<div class="form-group text-right">
      		<?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), "<i class='fa fa-floppy-o'></i> Guardar"); ?>
      	</div>
      	<hr>
        <div class="tab-content miTab">           
          	<div class="tab-pane active" id="generales">
            	<div class="" style="padding: 30px;">
            		<div class="row">
	            		<?php foreach ($configuraciones as $f) {?>
			                <?php if ($f->input == 'textarea') {?>
			                	<div class="col-md-12">
			                		<div class="form-group">
		                  				<label for="configuracion-<?php echo $f->id_configuration ?>"><?php echo $f->name ?></label>
		                  				<textarea id="configuracion-<?php echo $f->id_configuration ?>" name="configuracion-<?php echo $f->id_configuration ?>" class="form-control"><?php echo $f->value ?></textarea>
		                			</div>
		                		</div>
			                <?php }else{ ?>
			                	<?php if ($f->input == 'radio'): ?>
			                		<div class="col-md-6">
			                			<label for="configuracion-<?php echo $f->id_configuration ?>"><?php echo $f->name ?></label>
					                	<div class="form-group">
						                    <label class="radio-inline">
						                    	<input type="<?php echo $f->input ?>" id="configuracion-<?php echo $f->id_configuration ?>" name="configuracion-<?php echo $f->id_configuration ?>" value="1" <?php echo ($f->value == '1') ? 'checked' : '' ; ?> placeholder="<?php echo $f->name ?>" /> Si
						                   	</label>

						                    <label class="radio-inline">
						                      	<input type="<?php echo $f->input ?>" id="configuracion-<?php echo $f->id_configuration ?>" name="configuracion-<?php echo $f->id_configuration ?>" value="2" <?php echo ($f->value == '2') ? 'checked' : '' ; ?> placeholder="<?php echo $f->name ?>" /> No
						                    </label>
						                </div>
						            </div>
			                	<?php else: ?>
				                	<div class="col-md-6">
					                	<div class="form-group">
						                	<label for="configuracion-<?php echo $f->id_configuration ?>"><?php echo $f->name ?></label>
						                    <div class="input-group">                  
						                      	<div class="input-group-addon"><i class="fa <?php echo $f->icon ?>"></i></div>
						                      	<input type="<?php echo $f->input ?>" id="configuracion-<?php echo $f->id_configuration ?>" name="configuracion-<?php echo $f->id_configuration ?>" value="<?php echo $f->value ?>" class="form-control" placeholder="<?php echo $f->name ?>" />
						                    </div>
						                </div>
						            </div>
			                	<?php endif ?>
			                <?php } ?>
		                <?php } ?>
	                </div>
              	</div>
          	</div>
        </div>
      <?php echo form_close(); ?>
    </div>
</div>