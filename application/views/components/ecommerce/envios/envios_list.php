<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/envios/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Envio</a><?php } ?><hr>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="10%"><a href="#">ID</a></th>
                    <th><a href="#">Codigo Postal</a></th>
                    <th><a href="#">Dias de entrega</a></th>
                    <th><a href="#">Precio de entrega</a></th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                <?php $days = ''; ?>
                <?php foreach($res as $r){
                  if ($result->id_shipping == $r->id_shipping) {
                    $days.= $r->days;
                  }
                } ?>
                <tr>
                    <td><?php echo $result->id_shipping ?></td>
                    <td><?php echo $result->postal_code ?></td>
                    <td><?php echo $days ?></td>
                    <td><?php echo $result->price_shipping ?></td>
                    <td align="center">
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'ecommerce/envios/view/'.$result->id_shipping ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/envios/edit/'.$result->id_shipping ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/envios/delete/'.$result->id_shipping ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>