<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6 class="modal-title"><i class="fa fa-search"></i> <?php echo $result->surname.', '.$result->name ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <div class="control-group">
                <b>Usuario:</b> <?php echo $result->username ?>
            </div>
            <div class="control-group">
                <b>Email:</b> <?php echo $result->email ?>
            </div>
            <div class="control-group">
                <b>Nombre:</b> <?php echo $result->name ?>
            </div>
            <div class="control-group">
                <b>Apellido:</b> <?php echo $result->surname ?>
            </div>
            <div class="control-group">
                <b>Teléfono:</b> <?php echo $result->telephone ?>
            </div>
            <div class="control-group">
                <b>Celular:</b> <?php echo $result->mobile ?>
            </div>                              
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>