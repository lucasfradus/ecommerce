<div class="col-lg-12">
    <div class="element-box">
        <?php
            echo form_open_multipart(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
        ?>
            <div class="form-group">
                <label for="descripcion">Descripcion<span class="required">*</span></label>
                <input id="descripcion" required type="text" name="descripcion" value="<?php echo set_value('descripcion'); ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="link">Link<span class="required">*</span></label>
                <input id="link" required type="text" name="link" value="<?php echo set_value('link'); ?>" placeholder="#" class="form-control" />
            </div>
            <div class="form-group">
                <label for="parent">Parent<span class="required">*</span></label>
                <select id="parent" required name="parent" class="chosen-select form-control" >
                    <option value="0">Ninguno</option>
                    <?php foreach ($parents as $f) { ?>
                        <option value="<?php echo $f->id_menu ?>"><?php echo $f->description ?></option>
                    <?php } ?>
                </select>
            </div>
         

            <div class="form-group">
                <label for="iconpath">Icono<span class="required">*</span></label>
                <input id="iconpath" required type="text" name="iconpath" value="<?php echo set_value('iconpath'); ?>" placeholder="icon-cog" class="form-control" />
            </div>
            

            <div class="form-group">
                <label for="active">Estado<span class="required">*</span></label>
                <label class="radio-inline">
                  <input type="radio" name="active" id="active" value="1" checked  /> Habilitado
                </label>
                <label class="radio-inline">
                  <input type="radio" name="active" id="active" value="0" /> Inhabilitado
                </label>
            </div>
            

            <div class="form-group">
                <label for="dashboard">Dashboard<span class="required">*</span></label>
                <label class="radio-inline">
                  <input type="radio" name="dashboard" id="dashboard" value="1" checked /> Mostrar
                </label>
                <label class="radio-inline">
                  <input type="radio" name="dashboard" id="dashboard" value="0" /> Ocultar
                </label>
            </div>
                                            
            <div class="control-group">
              <div class="controls">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?> 
                <a class="btn btn-danger" href="<?php echo base_url().'backend/'.$this->uri->segment(2); ?>"><i class="icon-circle-arrow-left icon-white"></i> Volver</a>
              </div>
            </div>

        <?php echo form_close(); ?>
    </div>
</div>