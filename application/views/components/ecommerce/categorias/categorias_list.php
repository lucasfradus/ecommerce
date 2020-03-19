<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/categorias/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva Categoría</a><?php } ?><hr>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="10%" ><a href="#">ID</a></th>
                    <th><a href="#">nombre</a></th>
                    <th width="15%" >&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo $result->id_category ?></td>
                        <td><?php echo $result->name ?></td>
                        <td align="right" width="15%">
                          <div class="btn-group">
                            <a data-toggle="modal" href="<?php echo base_url().'ecommerce/categorias/view/'.$result->id_category ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                            <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/categorias/edit/'.$result->id_category ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                            <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/categorias/delete/'.$result->id_category ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                          </div>
                        </td>
                    </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>
