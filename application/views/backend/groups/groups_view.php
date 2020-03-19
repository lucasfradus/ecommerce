<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h5 class="modal-title"><i class="fa fa-search"></i> <?php echo $result->name ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <div class="control-group">
                <b>Nombre:</b> <?php echo $result->name ?>
            </div>
            <div class="control-group">
                <b>Descripcion:</b> <?php echo $result->description ?>
            </div>                                 
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>