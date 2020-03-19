<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> Descuentos <?php /*echo $result->discount */?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <div class="control-group">
                <b>Rango:</b> <?php echo $result->min ?> - <?php echo $result->max ?>
            </div>
            <div class="control-group">
                <b>Descuento:</b> <?php echo $result->discount ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>