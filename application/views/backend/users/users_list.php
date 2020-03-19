<div class="col-lg-12">
  <div class="element-box">
    <div class="text-right">
      <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'backend/users/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Usuario</a><?php } ?><hr>
    </div>
    <div class="table-responsive">
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Apellido, Nombre</th>
                    <th>Grupo</th>
                    <th>Estado</th>
                    <th>Contraseña</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            foreach ($results as $result) { ?>
            <?php if($result->active >0): ?>
            <tr>
                <td><?php echo $result->id_user ?></td>
                <td><?php echo $result->username ?></td>
                <td><?php echo $result->email ?></td>
                <td><?php echo $result->surname.", ".$result->name ?></td>
                <td><?php echo $result->nombre_grupo ?></td>
                <td><?php if($result->active==1){?><i class="fa fa-check"></i><?php } else {?><i class="fa fa-times"></i><?php }?></td>
                <td>
                    <a href="<?php echo base_url().'backend/users/cambiar_password/'.$result->id_user ?>" class="btn btn-primary"><i class="fa fa-key"></i> Cambiar </a>
                </td>
                <td align="right">
                    <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url().'backend/users/view/'.$result->id_user ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'backend/users/edit/'.$result->id_user ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarUsuario('<?php echo base_url().'backend/users/delete/'.$result->id_user ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                    </div>
                </td>
            </tr>
            <?php endif?>
            <?php } ?>
            </tbody>
        </table>
    </div>
  </div>
</div>
<script type="text/javascript">
function eleminarUsuario(link){
  var answer = confirm('Desea eliminar el registro?')
  if (answer){
    $.ajax({
            type: "GET",
            url: link,
            data: {},
            cache: false,
            success: function(){window.location.reload();}
          });
  }  
  return false;  
}
</script>