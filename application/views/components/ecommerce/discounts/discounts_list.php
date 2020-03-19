<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">            
            <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/descuentos/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Descuento</a><?php } ?><hr>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="10%"><a href="#">id</a></th>
                    <th><a>Desde - Hasta</a></th>
                    <th><a href="#">Descuento</a></th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $result->id_discount_code ?></td>
                        <td><?php echo $result->min ?>-<?php echo $result->max ?></td>
                        <td><?php echo $result->discount ?>%</td>
                        <td align="right">
                            <div class="btn-group">
                                <a data-toggle="modal" href="<?php echo base_url().'ecommerce/descuentos/view/'.$result->id_discount_code ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/descuentos/edit/'.$result->id_discount_code ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                                <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/descuentos/delete/'.$result->id_discount_code ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>