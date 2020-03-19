<div class="col-lg-12">
    <div class="element-box">
        <div class="text-right">
            <a href="<?php echo base_url('ecommerce/facturacion/add') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nueva factura</a>
        </div>
        <hr />
        <form method="GET">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <?php echo $this->session->flashdata('success') ?>
                        </div>
                    <?php endif ?>
                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <?php echo $this->session->flashdata('error') ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fecha desde</label>
                        <input type="date" name="desde" class="form-control" value="<?php echo $this->input->get('desde') ? $this->input->get('desde') : '' ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fecha hasta</label>
                        <input type="date" name="hasta" class="form-control" value="<?php echo $this->input->get('hasta') ? $this->input->get('hasta') : '' ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>DNI o CUIT</label>
                        <input type="text" placeholder="DNI o CUIT" name="documento" class="form-control" value="<?php echo $this->input->get('documento') ? $this->input->get('documento') : '' ?>"/>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Estado</label>
                        <select name="estado" class="form-control select2">
                            <option value="">Selecciona</option>
                            <?php foreach ($estados as $key => $value): ?>
                                <option <?php echo $this->input->get('estado') == $value->id_order_status ? 'selected' : ''  ?> value="<?php echo $value->id_order_status ?>"><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Empresa de Facturación</label>
                        <select type="text" name="empresa" class="form-control select2">
                            <option value="">Selecciona</option>
                            <?php foreach ($empresas as $key => $value): ?>
                                <option <?php echo $this->input->get('empresa') == $value->id_business ? 'selected' : '' ?> value="<?php echo $value->id_business ?>"><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <p style="margin-bottom: 7px;">&nbsp;</p>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> Buscar</button>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <br>
        <table id="dataTable1" class="table table-striped table-hover table-condensed bootstrap-datatable table-bordered">
            <thead>
                <tr>
                    <th width="5%"><a href="#">Id</a></th>
                    <th><a href="#">Empresa</a></th>
                    <th><a href="#">Número Factura</a></th>
                    <th><a href="#">Venta</a></th>
                    <th><a href="#">Fecha</a></th>
                    <th><a href="#">Nombre / Razon social</a></th>
                    <th><a href="#">Importe</a></th>
                    <th><a href="#">Tipo de venta</a></th>
                    <th><a href="#">Factura</a></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($results): ?>
                    <?php foreach ($results as $key => $factura): ?>
                        <tr>
                            <td>
                                <?php echo $factura->id_invoice ?>
                            </td>
                            <td>
                                <?php echo $factura->business ?>
                            </td>
                            <td>
                                <?php echo $factura->point_sale ?>-<?php echo str_pad($factura->ticket, 8, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td>
                                <?php echo $factura->id_order ?>
                            </td>
                            <td>
                                <?php echo date('d/m/Y', strtotime($factura->created_at)) ?>
                            </td>
                            <td>
                                <?php echo $factura->name . ' ' . $factura->surname ?>
                            </td>
                            <td>
                                $ <?php echo $factura->subtotal ?>
                            </td>
                            <td>
                                <?php if ($factura->sale_mode == SALE_DASHBOARD): ?>
                                    Por Mostrador
                                <?php else: ?>
                                    Ecommerce
                                <?php endif ?>
                            </td>
                            <td align="right" width="10%">
                                <?php if (!empty($factura->filename)): ?>
                                    <a href="<?php echo base_url('uploads/comprobantes/' . $factura->filename) ?>" target="_blank" class="btn btn-danger btn-md"><i class="fa fa-file"></i> PDF</a>
                                <?php else: ?>
                                    <?php if ($factura->id_status == PEDIDO_PAGADO && !is_numeric($factura->id_invoice)): ?>
                                        <button class="btn btn-primary" style="width: 40px;" onclick="handleRegisterInvoice(event, this, '<?php echo $factura->type_id ?>')" data-id="<?php echo $factura->id_order ?>">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    <?php endif ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php endif ?>
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
        url: base_url + 'ecommerce/facturacion/facturacion',
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
        $("div#modal-factura-complementario").modal('hide');
        if (response.success)
        {
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