<div class="col-lg-12">
    <div class="element-box">
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th><a href="#">id</a></th>
                    <th><a href="#">imagen</a></th>
                    <th><a href="#">url</a></th>
                    <th width="10%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $result->id_widget ?></td>
                        <td>
                            <?php if (!empty($result->image)): ?>
                                <a href="<?php echo base_url('uploads/widgets/'.$result->image) ?>" class="fancybox btn btn-primary"><i class="fa fa-picture-o"></i></a>
                            <?php endif ?>
                        </td>
                        <td><?php echo $result->url ?></td>
                        <td width="15%" align="right">
                            <div class="btn-group">
                                <a data-toggle="modal" href="<?php echo base_url().'ecommerce/widget/view/'.$result->id_widget ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/widget/edit/'.$result->id_widget ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                                <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/widget/delete/'.$result->id_widget ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>