<div class="col-lg-12">
  <div class="element-box">
    <div class="text-right">
        <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'backend/menus/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Menu</a><?php } ?><hr>
    </div>
    <div class="table-responsive">
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">ID</a></th>
                    <th><a href="#">Menu</a></th>
                    <th><a href="#">Parent</a></th>
                    <th><a href="#">Icono</a></th>
                    <th><a href="#">Estado</a></th>
                    <th><a href="#">Dashboard</a></th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php 
              foreach ($results as $result) { ?>
              <tr>
                <td><?php echo $result->id ?></td>
                <td><?php echo $result->descr ?></td>
                <td><?php echo $result->parent_descr ?></td>
                <td><i class="<?php echo $result->iconpath ?>"></i></td>
                <td><?php if($result->active==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td><?php if($result->dashboard==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td width="10%" align="right">
                    <div class="btn-group">
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'backend/menus/edit/'.$result->id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'backend/menus/delete/'.$result->id ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                    </div>
                </td>
              </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>