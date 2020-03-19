<div class="modal-content">
    <div class="modal-header modal-header-primary">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i></button>
        <h3><i class="fa fa-search"></i> <?php echo form_hidden('id_differentias_discounts',$result->id_differentias_discounts) ?></h3>
    </div>
    <div class="modal-body">
        <div class="form-horizontal">       
            <?php echo form_hidden('id_differentias_discounts',$result->id_differentias_discounts) ?>
            
                <div class="form-group">
                    <b>Nombre:</b> <?php echo $result->name_differentias_discounts ?> <br>
                    <b>Descuento aplicable por cantidad de bultos </b>
                </div> 
                <table class="table">
                
                        <thead>
                            <tr>
                            
                            <th scope="col">Cantidad Mínima</th>
                            <th scope="col">Cantidad Máxima</th>
                            <th scope="col">% Descuento</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($result->detalles as $r):  ?>
                            <tr>
                            
                                <td> <?php echo $r->min_qty ?></td>
                                <td> <?php echo $r->max_qty ?></td>
                                <td> <?php echo $r->discount ?>%</td>
                            </tr>
                            <?php endforeach  ?>     
                        </tbody>
                        </table>                          
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cerrar</button>
    </div>
</div>