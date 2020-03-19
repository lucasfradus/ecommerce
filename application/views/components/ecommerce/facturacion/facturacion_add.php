<style type="text/css">
.has-danger .select2-container--default .select2-selection--single{
    border-color: #e65252;
}
.modal-primary .modal-header{
    background: #047bf8;
    color: #fff;
    border-radius: 4px 4px 0px 0px;
}
.modal-primary .modal-title{
    color: #fff;
}
</style>
<div class="col-lg-12">
	<form onsubmit="return false;" data-form="register-invoice" action="<?php echo current_url() ?>" method="POST">
        <div class="element-box">
            <?php echo form_hidden('enviar_form','1'); ?>
    		<div class="text-right">
                <a href="#" onclick="openDialogConfirmEmail(event, this);" class="btn btn-primary">Generar y enviar por email</a>
                <a href="#" onclick="openDialogConfirm(event, this);" class="btn btn-primary">Generar e imprimir</a>
    		    <a class="btn btn-danger" href="<?php echo base_url() . $this->uri->segment(1).'/'.$this->uri->segment(2); ?>"><i class="fa fa-arrow-left"></i> Volver</a>
                <hr/>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="empresa_id"> Empresa de facturación <span class="text-danger">*</span></label>
                        <select name="empresa_id" class="form-control select2" id="empresa_id" required="">
                            <option value="">Seleccione</option>
                            <?php foreach ($empresas as $key => $value): ?>
                                <option value="<?php echo $value->id_business ?>" <?php echo $key == 0 ? 'selected' : '' ?>><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="nombre"> Nombre / Razón social <span class="text-danger">*</span></label>
                        <input name="nombre" placeholder="Nombre / Razon social" class="form-control" id="nombre" required=""/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_usuario">Tipo de usuario <span class="text-danger">*</span></label>
                        <select required id="tipo_usuario" name="tipo_usuario" class="form-control select2" >
                            <option value="">Selecciona</option>
                            <?php foreach($condiciones_afip as $estado): ?>
                                <option value="<?php echo $estado->id_condition_iva ?>"><?php echo $estado->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="documento">CUIL / DNI <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" placeholder="CUIL / DNI" name="documento" class="form-control" value="" required=""/>
                            <span class="input-group-btn">
                                <button type="button" onclick="searchCustomer(event, this)" class="btn btn-light"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="fecha"> Fecha <span class="text-danger">*</span></label>
                        <input type="date" value="<?php echo date('Y-m-d') ?>" name="fecha" class="form-control" id="fecha" required="" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="metodo_pago_id">Método de pago <span class="text-danger">*</span></label>
                        <select required id="metodo_pago_id" name="metodo_pago_id" class="form-control select2">
                            <option value="">Selecciona</option>
                            <?php foreach($metodo_pago as $value): ?>
                                <option value="<?php echo $value->id_payment_method ?>"><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="estado_id">Estado <span class="text-danger">*</span></label>
                        <select required id="estado_id" name="estado_id" class="form-control select2">
                            <option value="">Selecciona</option>
                            <?php foreach($estados as $estado): ?>
                                <option value="<?php echo $estado->id_order_status ?>"><?php echo $estado->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Producto:</label>
                        <select  id="productList" name="product" class="form-control select2-producto">
                            <option value="">Seleccione</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <p style="margin-bottom: 7px;">&nbsp;</p>
                        <button class="btn btn-primary" type="button" onclick="addProducto(event, this);">Agregar producto</button>
                    </div>
                </div>
            </div>
            <hr>
            <table id="tablePedido" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="12%">Cantidad</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th width="10%">Precio unitario</th>
                        <th width="10%">Subtotal</th>
                        <th width="10%">IVA</th>
                        <th>Total</th>
                        <th width="5%">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="section-products">
                        <td colspan="8" align="center">
                            Agrega productos
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-right">
                <h5>Subtotal:</h5>
                <hr/>
                <div id="sutotalShop">
                    <h4 data-section="sectionSubtotalPrice">$0.00</h4>
                </div>
            </div>
            <input type="hidden" id="subtotal" name="subtotal" value="0" />
    	</div>
    </form>
</div>
<div data-action="modal-confirmation" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-primary" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación de registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro(a) de registrar esta factura?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="handleClickRegitroFactura(event, this);">Registrar</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div data-action="modal-confirmation-email" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-primary">
            <div class="modal-header">
                <h5 class="modal-title">Confirmación de registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Esta seguro(a) de registrar esta factura?</p>
                <div class="form-group">
                    <label>Ingrese el correo electrónica para enviar la factura</label>
                    <input type="email" placeholder="Email" name="email" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="handleClickRegitroFactura(event, this);">Registrar</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div data-action="modal-loader" class="modal fade" data-backdrop="false" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-primary">
            <div class="modal-header">
                <h5 class="modal-title">Registro de factura</h5>
            </div>
            <div class="modal-body">
                <p>Espere por favor...</p>
                <h1 align="center"><i class="fa fa-spin fa-spinner fa-1x"></i></h1>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var table = $("table#tablePedido"),
        dataVariants = [],
        products_list_id = [];

    function openDialogConfirm(event, elemento)
    {
        event.preventDefault();
        if (validacionForm())
        {
            $('div[data-action="modal-confirmation"]').modal('show');
        }
    }

    function openDialogConfirmEmail(event, elemento)
    {
        event.preventDefault();
        if (validacionForm())
        {
            $('div[data-action="modal-confirmation-email"]').modal('show');
        }
    }

    $(document).on('change', '.form-control', function(event) {
        event.preventDefault();
        $(this).closest('div.form-group').removeClass('has-danger');
    });

    function validacionForm()
    {
        var form = $('form[data-form="register-invoice"]');
        var formulario_valido = true;

        if (form.find('[name="empresa_id"]').val() == '')
        {
            form.find('[name="empresa_id"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (form.find('input[name="nombre"]').val() == '')
        {
            form.find('input[name="nombre"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (!$.isNumeric(form.find('[name="tipo_usuario"]').val()))
        {
            form.find('[name="tipo_usuario"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (form.find('[name="documento"]').val() == '')
        {
            form.find('[name="documento"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (form.find('[name="fecha"]').val() == '')
        {
            form.find('[name="fecha"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (!$.isNumeric(form.find('[name="metodo_pago_id"]').val()))
        {
            form.find('[name="metodo_pago_id"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (!$.isNumeric(form.find('[name="estado_id"]').val()))
        {
            form.find('[name="estado_id"]').closest('.form-group').addClass('has-danger');
            formulario_valido = false;
        }

        if (!formulario_valido)
        {
            swal('Aviso', 'Debe completar el formulario correctamente.', 'warning');
        } else {

            if (!form.find('[name="product_qty[]"]').length)
            {
                formulario_valido = false;
                swal('Aviso', 'Debe seleccionar un producto como mínimo.', 'warning');
            }
        }

        return formulario_valido;
    }

    function searchCustomer(event, elemento)
    {
        event.preventDefault();
        var input_documento = $('input[name="documento"]');

        var datos = {
            enviar_form: '1',
            documento: input_documento.val(),
        };

        if ($.isNumeric(datos.documento))
        {
            $.ajax({
                url: base_url + 'ecommerce/facturacion/consultaCuit',
                type: 'POST',
                dataType: 'json',
                data: datos,
                beforeSend: function()
                {
                    input_documento.attr('disabled', '');
                    $(elemento).attr('disabled', '');
                    $(elemento).html('<i class="fa fa-spin fa-spinner"></i>');
                },
            })
            .done(function(response)
            {
                if (response.success)
                {
                    console.log(response.data);
                } else {
                    alert(response.data.message);
                    input_documento.val('');
                }

                input_documento.removeAttr('disabled');
                $(elemento).removeAttr('disabled');
                $(elemento).html('<i class="fa fa-search"></i>');

                console.log("success");
            })
            .fail(function()
            {
                console.log("error");
            })
            .always(function()
            {
                console.log("complete");
            });
        }
    }

    function addProducto(event, elemento)
    {
        var producto_id = $("select#productList").val();

        if ($.isNumeric(producto_id) && $.inArray(producto_id, products_list_id) < 0)
        {
            $.ajax({
                url: base_url + 'ecommerce/facturacion/producto',
                type: 'POST',
                dataType: 'json',
                data: {
                    productoId: producto_id,
                },
                beforeSend: function()
                {
                    $("select#productList").val('').trigger('change');
                },
            })
            .done(function(response)
            {
                if (response.success)
                {
                    addProductSale(response.data);
                } else {
                    swal('Aviso', response.data.message, 'info');
                }
                console.log("success");
            })
            .fail(function()
            {
                console.log("error");
            })
            .always(function()
            {
                console.log("complete");
            });
        }
    }

    function addProductSale(data)
    {
        var tallesArray = [];
        var Toptions = '';

        $(".section-products").remove();

        var innetHtml = [
            '<tr>',
                '<td>',
                    '<input type="number" onchange="changeQty(event, this)" name="product_qty[]" required min="1" class="form-control" value="1" />',
                    '<input data-type="produto_id" name="product[]" value="' + data.producto_id + '" type="hidden" />',
                    '<input data-type="precio" name="precio[]" value="' + data.precio + '" type="hidden" />',
                    '<input data-type="iva" name="iva[]" value="' + data.iva + '" type="hidden" />',
                    '<input data-type="iva" name="iva_id[]" value="' + data.iva_id + '" type="hidden" />',
                '</td>',
                '<td>',
                    data.codigo,
                '</td>',
                '<td>' + data.nombre + '</td>',
                '<td>',
                    '$' + data.precio,
                '</td>',
                '<td data-section="subtotal-precio">$' + data.precio + '</td>',
                '<td data-section="subtotal-iva">',
                    '$' + calcularIgvPrecio(data.precio, data.iva).toFixed(2),
                '</td>',
                '<td data-section="subtotal-precio">',
                    '$' + data.precio,
                '</td>',
                '<td align="right">',
                    '<a href="#" onclick="removeProduct(event, this)" class="btn btn-danger"><i class="fa fa-trash"></i></a>',
                '</td>',
            '</tr>'
        ];

        table.find('tbody').append(innetHtml.join(''));
        products_list_id.push(data.producto_id);

        setSubtotal();
    }

    function handleClickRegitroFactura(event, elemento)
    {
        event.preventDefault();
        $('div.modal[data-action="modal-confirmation"]').modal("hide");

        var form = $('form[data-form="register-invoice"]');
        var datos = form.serializeArray();
        var envio_email = false;

        if ($(elemento).closest('div.modal-content').find('input[name="email"]').length)
        {
            var email = $(elemento).closest('div.modal-content').find('input[name="email"]').val();
            datos[datos.length] = { name: "email", value: email };
            envio_email = true;
        }

        $.ajax({
            url: base_url + 'ecommerce/facturacion/registroFactura',
            type: 'POST',
            dataType: 'json',
            data: datos,
            beforeSend: function()
            {
                setTimeout(function()
                {
                    $('div.modal[data-action="modal-loader"]').modal("show");
                }, 500);
            },
        })
        .done(function(response)
        {
            $('div[data-action="modal-loader"]').modal("hide");

            if (response.success)
            {
                if (envio_email)
                {
                    swal('Éxito', response.data.message, 'success');
                } else {
                    var win = window.open(response.data.filename, '_blank');
                    win.focus();
                }

                setTimeout(function()
                {
                    window.location.href = response.data.redirect;
                }, 2000);
                form[0].reset();
                $("select.select2").trigger('change');
                $("table#tablePedido tbody").html('<td colspan="8" align="center">Agrega productos</td>');
                setSubtotal();
            } else {
                alert(response.data.message);
            }

            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }

    function removeProduct(event, elemento)
    {
        event.preventDefault();
        var producto_id = $(elemento).closest('tr').find('[data-type="produto_id"]').val();

        var position_item = products_list_id.indexOf(producto_id);
        products_list_id.splice(position_item, 1);
        $(elemento).closest('tr').remove();

        setSubtotal();

        if (!table.find('tbody tr').length)
        {
            var htm = '<tr class="section-products">'+
                '<td colspan="8" align="center">'+
                    'Agrega productos'+
                '</td>'+
            '</tr>';
            table.find('tbody').html(htm);
        }
    }

    function changeQty(event, elemento)
    {
        var cantidad = parseInt($(elemento).val());

        if ($.isNumeric(cantidad) && cantidad > 0)
        {
            var precio = parseFloat($(elemento).closest('tr').find('input[data-type="precio"]').val());
            var iva = parseFloat($(elemento).closest('tr').find('input[data-type="iva"]').val());

            var subtotal_precio = cantidad * precio;
            var subtotal_iva = calcularIgvPrecio(subtotal_precio, iva);

            $(elemento).closest('tr').find('td[data-section="subtotal-iva"]').text('$' + subtotal_iva.toFixed(2));
            $(elemento).closest('tr').find('td[data-section="subtotal-precio"]').text('$' + subtotal_precio.toFixed(2));

            setSubtotal();
        }

    }

    function calcularIgvPrecio(precio, iva)
    {
        var precio_neto = parseFloat(precio) / (1 + parseFloat(iva) / 100);
        precio_neto = precio_neto.toFixed(2);
        precio_neto = parseFloat(precio_neto);
        return (precio - precio_neto);
    }

    $(function()
    {
        $("#productList").select2({
            width: '100%',
            language: "es",
            minimumInputLength: 2,
            tags: false,
            placeholder: "Selecciona...",
            ajax: {
                url: base_url + 'ecommerce/pedidos/jsonProducts',
                dataType: 'json',
                type: "post",
                quietMillis: 50,
                data: function (term){
                    return {
                        term: term
                    };
                }
            },
            processResults: function (data) {
                return {
                    results: data.items
                };
            }
        });
    });

    function setSubtotal()
    {
        var table = $("table#tablePedido");
        var subtotal = 0;

        table.find('tbody tr').each(function(index, el)
        {
            var valuePrice = $(el).closest('tr').find('td[data-section="subtotal-precio"]:eq(0)').text().trim().replace('$', '');
            var precio = 0;
            if ($.isNumeric(valuePrice))
            {
                precio = parseFloat(valuePrice);
            }
            subtotal += precio;
        });

        $('h4[data-section="sectionSubtotalPrice"]').html('$' + subtotal.toFixed(2));
        $("input#subtotal").val(subtotal.toFixed(2));
    }

</script>