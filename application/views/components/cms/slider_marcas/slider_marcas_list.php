<div class="col-lg-12">
    <div class="ibox-content">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url('cms/slider_marcas/add/') ?>" class="btn btn-success"><i class="fa fa-plus"></i> Nueva Marca</a><?php } ?><hr>
        </div>
        <table id="results" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    
                    <th width="10%"><a href="#">ID</a></th>
                        <th><a href="#">Nombre</a></th>
                        <th width="10%"><a href="#">Imagen</a></th>
                        <th width="15%"><a href="#">Fecha</a></th>
                        <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($results as $result) { ?>
                  <tr>
                  
                    <td><?php echo $result->id_slider_marcas ?></td>
                    <td><?php echo $result->nombre_slider_marcas ?></td>
                    <td>
                    <?php if (!empty($result->image)): ?>
                        <a href="<?php echo base_url('uploads/slider_marcas/'.$result->image) ?>" class="fancybox btn btn-primary"><i class="fa fa-picture-o"></i></a>
                    <?php endif ?>
                    </td>
                   
                    <td><?php echo $result->created_at ?></td>
                    
                    <td>
                      <div class="btn-group">
                        <a data-toggle="modal" href="<?php echo base_url('cms/slider_marcas/view/'.$result->id_slider_marcas) ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                        <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url('cms/slider_marcas/edit/'.$result->id_slider_marcas)?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                        <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url('cms/slider_marcas/delete/'.$result->id_slider_marcas)?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                      </div>
                    </td>
                  </tr>
              <?php } ?>
            </tbody>
        </table>
    </div>
</div>