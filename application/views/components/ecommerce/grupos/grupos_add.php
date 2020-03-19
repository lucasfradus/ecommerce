<div class="col-lg-12">
    <div class="element-box">
        <?php     
            echo form_open(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
        ?>
            <div class="form-group">
                <label for="name">Nombre<span class="required">*</span></label>
                <input id="name" required type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="usuarios">Usuarios<span class="required">*</span></label>
                <select class="form-control chosen-select" data-placeholder="Seleccione usuarios" multiple="" name="usuarios[]">
                    <?php foreach ($usuarios as $key => $value): ?>
                        <option value="<?php echo $value->userid ?>"><?php echo $value->username ?></option>
                    <?php endforeach ?>
                </select>
            </div>                                                
            <div class="form-group">
              <div class="controls">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?> 
                <a class="btn btn-danger" href="javascript:window.history.back();"><i class="icon-circle-arrow-left icon-white"></i> Volver</a>
              </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>