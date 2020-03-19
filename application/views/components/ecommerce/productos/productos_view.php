<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i> <?php echo form_hidden('id',$result->id_product) ?></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id',$result->id_product) ?>
            <div class="form-group">
                <b>Codigo:</b> <?php echo $result->code ?>
            </div>
            <div class="form-group">
                <b>Nombre:</b> <?php echo $result->name ?>
            </div>
            <div class="form-group">
                <b>Descripcion:</b> <?php echo $result->description ?>
            </div>
            <div class="form-group">
                <b>Precio minorista individual:</b> $<?php echo $result->price_individual ?>
            </div>
            <div class="form-group">
                <b>Precio minorista por bulto:</b> $<?php echo $result->price_package ?>
            </div>
            <div class="form-group">
                <b>Destacado:</b> <?php echo ($result->featured == 1)? 'Si' : 'No'  ?>
            </div>
            <div class="form-group">
                <b>Oferta:</b> <?php echo ($result->offer == 1)? 'Si' : 'No'  ?>
            </div>                        
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>