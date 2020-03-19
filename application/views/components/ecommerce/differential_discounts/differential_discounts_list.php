<div class="col-lg-12">
    <div class="ibox-content">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url('ecommerce/Descuentos_diferenciales/add/') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Descuento Diferencial</a><?php } ?><hr>
        </div>
        <table id="results" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                      <th><a href="#">ID</a></th>
                      <th><a href="#">Nombre</a></th>
                      <th><a href="#">Detalles de bultos</a></th>
                      <th><a href="#">Creado</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                  <tr>
                      <td><?php echo $result->id_differentias_discounts ?></td>
                      <td><?php echo $result->name_differentias_discounts ?></td>
                      
                      <td>
                      
                      <?php foreach ($result->detalles as $detalle):?>
                        <ul>
                          <li>
                            
                            <?php echo "Minimo: ".$detalle->min_qty." - "  ?>
                            <?php echo "Máximo: ".$detalle->max_qty." - "   ?>
                            <?php echo "Descuento: ".$detalle->discount."%"  ?>
                          </li>
                      </ul>
              
                      <?php endforeach ?>
                      
                      </td>
                      <td><?php echo $result->created_at ?></td>
                    <td>
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url('ecommerce/Descuentos_diferenciales/view/'.$result->id_differentias_discounts) ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url('ecommerce/Descuentos_diferenciales/edit/'.$result->id_differentias_discounts) ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url('ecommerce/Descuentos_diferenciales/delete/'.$result->id_differentias_discounts) ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>