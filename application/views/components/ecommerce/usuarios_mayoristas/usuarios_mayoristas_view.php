<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
        <h3><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->id_users) ?></h3>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id',$result->id_users) ?>
                <div class="form-group">
                    <b>DNI/CUIT:</b> <?php echo $result->dni ?>
                </div>  
                <div class="form-group">
                    <b>Nombre:</b> <?php echo $result->name ?>&nbsp;<?php echo $result->surname ?>
                </div>
                <div class="form-group">
                    <b>Email:</b> <?php echo $result->email ?>
                </div>

                <div class="form-group">
                    <b>Teléfono:</b> <?php echo $result->phone ?>
                </div>
                         
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>