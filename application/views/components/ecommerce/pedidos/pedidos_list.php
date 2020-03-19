<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">
            <a href="<?php echo base_url('ecommerce/pedidos/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo pedido</a>
        </div>
        <hr>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="5%"><a href="#">ID</a></th>
                    <th><a href="#">Pedido</a></th>
                    <th><a href="#">Cliente</a></th>
                    <th><a href="#">Importe</a></th>
                    <th><a href="#">Fecha</a></th>
                    <th><a href="#">Estado</a></th>
                    <th><a href="#">Tipo de venta</a></th>
                    <th><a href="#">Facturar</a></th>
                    <th width="15%">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result): ?>
                    <tr>
                        <td><?php echo $result->id_order ?></td>
                        <td>PED-<?php echo sprintf("%09d", $result->id_order) ?></td>
                        <td><?php echo $result->name.' '.$result->surname ?></td>
                        <td>$ <?php echo number_format( ( $result->subtotal + $result->cost_shipping - $result->discount ) , 2, '.', '') ?></td>
                        <td><?php echo date('d/m/Y h:i a', strtotime($result->created_at)) ?></td>
                        <td><?php echo $result->status ?></td>
                        <td>
                            <?php if ($result->sale_mode == SALE_DASHBOARD): ?>
                                Por Mostrador
                            <?php else: ?>
                                Ecommerce
                            <?php endif ?>
                        </td>
                        <td align="center">
                            <?php if ($result->id_status == PEDIDO_PAGADO && !is_numeric($result->id_invoice)): ?>
                                <button class="btn btn-primary" onclick="handleRegisterInvoice(event, this, '<?php echo $result->type_id ?>')" data-id="<?php echo $result->id_order ?>">
                                    <i class="fa fa-check"></i>
                                </button>
                            <?php else: ?>
                                <?php if (is_numeric($result->id_invoice)): ?>
                                    Facturado
                                <?php endif ?>
                            <?php endif ?>
                        </td>
                        <td align="right">
                            <div class="btn-group">
                                <a data-toggle="modal" href="<?php echo base_url().'ecommerce/pedidos/view/'.$result->id_order ?>" data-target="#myModalLarge" class="btn btn-info"><i class="fa fa-search"></i></a>
                                <?php if($permisos_efectivos->update==1) { ?><a href="<?php echo base_url().'ecommerce/pedidos/edit/'.$result->id_order ?>" class="btn btn-success"><i class="fa fa-edit"></i></a><?php } ?>
                                <?php if($permisos_efectivos->delete==1) { ?><a onClick="eleminarRegistro('<?php echo base_url().'ecommerce/pedidos/delete/'.$result->id_order ?>')" href="#" class="btn btn-danger"><i class="fa fa-trash-o"></i></a><?php } ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-factura-complementario" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" onsubmit="handleSubmitFactura(event, this);">
                <div class="modal-header">
                    <h6 class="modal-title">DATOS DE FACTURA</h6>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="enviar_form" value="1">
                    <input type="hidden" name="id_order" value="">
                    <div class="form-group">
                        <label>Condición en AFIP</label>
                        <select class="form-control select2" required="" name="condicion">
                            <option value="">Selecciona</option>
                            <?php foreach ($condiciones as $key => $value): ?>
                                <option value="<?php echo $value->id_condition_iva ?>"><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>DNI/CUIT</label>
                        <input type="text" placeholder="DNI/CUIT" name="cuit" class="form-control" required="" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
function handleSubmitFactura(event, elemento)
{
    event.preventDefault();
    var datos = $(elemento).serialize();

    $.ajax({
        url: base_url + 'ecommerce/pedidos/facturacion',
        type: 'POST',
        dataType: 'json',
        data: datos,
        beforeSend: function()
        {
            $(elemento)[0].reset();
            $(elemento).find('button[type="submit"]').attr('disabled', '');
            $(elemento).find('button[type="submit"]').html('<i class="fa fa-spin fa-spinner"></i> Espere...');
        }
    })
    .done(function(response)
    {
        if (response.success)
        {
            $("div#modal-factura-complementario").modal('hide');
            swal("Éxito", "Se ha facturado esta venta.", 'success');
            setTimeout(function()
            {
                window.location.reload();
            }, 1500);
        } else {
            swal("Error", response.data.message, 'error');
        }
        console.log("success");
    })
    .fail(function()
    {
        window.location.reload();
    })
    .always(function() {
        console.log("complete");
    });

}

function handleRegisterInvoice(event, elemento, tipo_cliente)
{
    event.preventDefault();
    var id_order = $(elemento).attr('data-id');

    if (tipo_cliente == '2')
    {
        $(elemento).attr('disabled', '');
        $(elemento).html('<i class="fa fa-spin fa-spinner"></i>');

        swal({
            title:  "Confirmación",
            text:   "¿Desea facturar esta venta?",
            type:   "warning",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#c9dae1",
            showCancelButton: true,
            confirmButtonColor: "#f44141",
            confirmButtonText: "Aceptar",
            closeOnConfirm: false,
            disableButtonsOnConfirm: true,
            showLoaderOnConfirm: true,
            confirmLoadingButtonColor: '#DD6B55'
        },
        function(response)
        {

            if (response)
            {
                $.ajax({
                    url: base_url + 'ecommerce/pedidos/facturacion',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id_order: id_order,
                    },
                })
                .done(function(response)
                {
                    if (response.success)
                    {
                        swal("Éxito", "Se ha facturado esta venta.", 'success');
                        $(elemento).remove();
                        setTimeout(function()
                        {
                            window.location.reload();
                        }, 1500);

                    } else {
                        swal("Aviso", response.data.message, 'error');
                        $(elemento).html('<i class="fa fa-check"></i>');
                        $(elemento).removeAttr('disabled');
                    }

                    console.log("success");
                })
                .fail(function() {
                    window.location.reload();
                })
                .always(function() {
                    console.log("complete");
                });

            } else {
                $(elemento).html('<i class="fa fa-check"></i>');
                $(elemento).removeAttr('disabled');
            }

        });

    } else {
        $("div#modal-factura-complementario").modal("show");
        $('div#modal-factura-complementario input[name="id_order"]').val(id_order);

        setTimeout(function()
        {
            $('select.select2[name="condicion"]').select2();
        }, 500);

    }
}
</script>