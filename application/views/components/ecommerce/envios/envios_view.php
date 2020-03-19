<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->id_shipping) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id',$result->id_shipping) ?>
            
            <div class="form-group">
                <b>Codigo Postal:</b> <?php echo $result->postal_code ?>
            </div>
            <?php foreach($days as $r){?>
            <div class="form-group">
                <b>Dias de Entrega:</b> <?php echo $r->days ?>
            </div><?php }?>
            <div class="form-group">
                <b>Precio:</b> <?php echo $result->price_shipping ?>
            </div>
                                                                 
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>