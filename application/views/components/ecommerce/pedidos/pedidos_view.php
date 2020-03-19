<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <h6><i class="fa fa-search"></i></h6>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
    </div>
    <div class="modal-body">
        <div>  
            <h6>Datos de Contacto</h6>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Email:</b><br> <?php echo $result->email ?>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Telefono del contacto:</b><br> <?php echo $result->phone ?>
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Nombre del contacto:</b><br> <?php echo $result->name.' '.$result->surname ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Localidad:</b><br> <?php echo $result->Localidad ?>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Provincia:</b><br> <?php echo $result->Provincia ?>
                            </div>  
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <b>Dirección:</b><br> <?php echo $result->address ?>
                            </div>  
                        </div>
                    </div>
                    <hr>
                </div>                
                <div class="col-md-6">
                    <h6>Pedidos</h6>
                    <div class="form-group">
                        <b>Fecha:</b> <?php echo date('d/m/Y h:i a',strtotime($result->date)) ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="20%">Producto</th>
                                <th width="20%">Unidad Medida</th>
                                <th width="10%">Precio</th>
                                <th width="15%">Cantidad</th>
                                <th width="25%">Importe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $f): ?>
                                <tr>
                                    <td>
                                        <?php echo $f->producto; ?><br>
                                    </td>
                                    <td><?php echo($f->type_id == 1 ? 'Unidad':'Bulto' ) ?></td>
                                    <td align="center">$&nbsp;<?php echo number_format($f->price,2,'.',''); ?></td>
                                    <td align="center"><?php echo $f->qty; ?></td>
                                    <td align="right">$&nbsp;<?php echo number_format($f->price * $f->qty, 2,'.',''); ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <div class="form-group text-right">
                        <?php if ($result->cost_shipping > 0): ?>
                            <?php if($result->discount > 0) {?>
                                <b>Sub Total: </b> $ <?php echo $result->subtotal ?><br>
                                <b>Descuento: </b> $ <?php echo $result->discount ?><br>
                                <b>Costo de Envio: </b> $ <?php echo $result->cost_shipping ?><br>
                                <b>Total: $ <?php echo ($result->subtotal - $result->discount) + $result->cost_shipping ?></b>
                            <?php }else{ ?> 
                                <b>Sub Total: </b> $ <?php echo $result->subtotal ?><br>
                                <b>Costo de Envio: </b> $ <?php echo $result->cost_shipping ?><br>
                                <b>Total: $ <?php echo $result->subtotal + $result->cost_shipping ?></b>
                            <?php }?>
                        <?php else: ?> 
                           <?php if ($result->discount > 0){ ?>
                                <b>Sub Total: </b> $ <?php echo number_format($result->subtotal, 2,'.','') ?><br>
                                <b>Descuento: </b> $ <?php echo number_format($result->discount, 2,'.','') ?><br>
                                <b>Total: $ <?php echo number_format($result->subtotal - $result->discount, 2,'.','') ?></b>
                            <?php }else{ ?>
                                <b>Total: $ <?php echo number_format($result->subtotal, 2,'.','') ?></b>
                            <?php } ?>
                        <?php endif ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>