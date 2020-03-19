<div class="col-lg-12">
    <div class="element-box">
        <div class="row">
            <div class="col-md-12">
                <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <?php echo $this->session->flashdata('success') ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="text-right">
                    <?php if($permisos_efectivos->insert==1) { ?> <a href="<?php echo base_url().'ecommerce/productos/add/' ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo producto</a><?php } ?>
                    <a href="<?php echo base_url('ecommerce/productos/export') ?>" class="btn btn-success"><i class="fa fa-file"></i> Exportar</a>
                    <a href="<?php echo base_url('ecommerce/productos/import') ?>" class="btn btn-success"><i class="fa fa-file"></i> Importar</a>
                </div>
            </div>
            <div class="col-md-12">
                <hr>
            </div>
        </div>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="5%"><a href="#">ID</a></th>
                    <th><a href="#">Codigo</a></th>
                    <th><a href="#">Nombre</a></th>
                    <th><a href="#">Precio minorista individual</a></th>
                    <th><a href="#">Precio minorista por bulto</a></th>
                    <th width="10%"><a href="#">Destacado</a></th>
                    <th width="10%"><a href="#">Oferta</a></th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $result->id_product ?></td>
                        <td><?php echo $result->code ?></td>
                        <td><?php echo $result->name ?></td>
                        <td align="right">$<?php echo $result->price_individual ?></td>
                        <td align="right">$<?php echo $result->price_package ?></td>

                        <td align="center">
                            <?php if ($result->featured == ACTIVE): ?>
                                <i class="fa fa-check"></i>
                            <?php endif ?>
                            <?php if ($result->featured == DELETE): ?>
                                <i class="fa fa-times"></i>
                            <?php endif ?>
                        </td>
                        <td align="center">
                            <?php if ($result->offer == ACTIVE): ?>
                                <i class="fa fa-check"></i>
                            <?php endif ?>
                            <?php if ($result->offer == DELETE): ?>
                                <i class="fa fa-times"></i>
                            <?php endif ?>
                        </td>
                        <td align="right">
                          <div class="btn-group">
                            <a data-toggle="modal" href="<?php echo base_url().'ecommerce/productos/view/'.$result->id_product ?>" data-target="#myModal" class="btn btn-info"><i class="fa fa-search"></i></a>
                            <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/productos/edit/'.$result->id_product ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                            <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/productos/delete/'.$result->id_product ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                          </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
function generarXmlFacebook(event, elemento)
{
    event.preventDefault();
    var productId = $(elemento).attr('data-product');
    var estadoId = $(elemento).prop('checked');
    var socialId = 1;
    var datos = {
        productId: productId,
        socialId: socialId,
        estadoId: (estadoId) ? 1 : 0,
    };
    generarXmlPixel(datos);
}
function generarXmlInstagram(event, elemento)
{
    event.preventDefault();
    var productId = $(elemento).attr('data-product');
    var estadoId = $(elemento).prop('checked');
    var socialId = 2;
    var datos = {
        productId: productId,
        socialId: socialId,
        estadoId: (estadoId) ? 1 : 0,
    };
    generarXmlPixel(datos);
}
function generarXmlPixel(datos)
{
    $.ajax({
        url: base_url + 'ecommerce/productos/generacionXml',
        type: 'POST',
        dataType: 'json',
        data: datos,
    })
    .done(function(data) {
        console.log("success");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
</script>