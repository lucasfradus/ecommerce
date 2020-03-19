<div class="col-lg-12">
    <div class="element-box">
        <?php     
            echo form_open(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
            echo form_hidden('id',$result->id);
        ?>
            <div class="form-group">
                <label for="name">Nombre<span class="required">*</span></label>                                
                <input id="name" required type="text" name="name" value="<?php echo $result->name ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="usuarios">Usuarios<span class="required">*</span></label>
                <select class="form-control chosen-select" data-placeholder="Seleccione usuarios" multiple="" name="usuarios[]">
                    
                    <?php foreach ($usuarios as $key => $value): ?>
                        <?php $selected = ''; ?>
                        <?php foreach ($chat_usuarios as $c => $v): ?>
                            <?php if ($v->userid == $value->userid): ?>
                                <?php $selected = 'selected=""' ?>
                            <?php endif ?>
                        <?php endforeach ?>
                        <option value="<?php echo $value->userid ?>" <?php echo $selected; ?>><?php echo $value->username ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="form-group">
                <div class="controls">
                    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?>
                    <a class="btn btn-danger" href="javascript:window.history.back();"><i class="icon-circle-arrow-left icon-white"></i> Volver</a>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>