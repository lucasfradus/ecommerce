<div class="col-lg-12">
    <div class="element-box">
        <?php     
            echo form_open_multipart(current_url(), array('class'=>""));
            echo form_hidden('enviar_form','1');
        ?>
            <div class="form-group">
                <label for="url">Url<span class="required">*</span></label>
                <input id="url" required type="text" name="url" value="<?php echo $result->url ?>" class="form-control" />
            </div>
            <div class="form-group">
                <label for="imagen">Imagen<span class="required">*</span></label>
                <input id="imagen" accept="image/*" required type="file" name="imagen" class="form-control" />
            </div>
            <?php if (!empty($result->image)): ?>
                <div class="card mb-4">
                    <img src="<?php echo base_url('uploads/widgets/'.$result->image) ?>" width="150">
                </div>
            <?php endif ?>
            <div class="form-group">
                <div class="controls">
                    <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), 'Guardar'); ?> 
                    <a class="btn btn-danger" href="javascript:window.history.back();"><i class="fa fa-arrow-left"></i> Volver</a>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>