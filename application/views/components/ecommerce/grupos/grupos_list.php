<div class="col-lg-12">
  <div class="element-box">
    <div class="text-right">
      <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'mensajeria/grupos/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Grupo</a><?php } ?>
    </div>
    <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
        <thead>
            <tr>
                <th><a href="#">ID</a></th>
                <th><a href="#">Nombre</a></th>
                <th width="15%">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
          <?php 
          foreach ($results as $result) { ?>
            <?php if ($issa != 1 && $result->id != 2): ?>
              
            <tr>
              <td><?php echo $result->id ?></td>
              <td><?php echo $result->name ?></td>
              <td>
                <div class="btn-group">
                  <?php if($result->id !=1){ ?>
                    <a data-toggle="modal" href="<?php echo base_url().'mensajeria/grupos/view/'.$result->id ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                    <?php if($permisos_efectivos->update == 1) { ?><a href="<?php echo base_url().'mensajeria/grupos/edit/'.$result->id ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                    <?php if($permisos_efectivos->delete == 1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'mensajeria/grupos/delete/'.$result->id ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                  <?php } ?>
                </div>
              </td>
            </tr>

            <?php endif ?>
          <?php } ?>
        </tbody>
    </table>
  </div>
</div>