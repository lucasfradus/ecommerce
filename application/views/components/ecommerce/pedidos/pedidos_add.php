<div class="col-lg-12">
    <div class="element-box">
	<?php     
		echo form_open(current_url(), array('class'=>""));
		echo form_hidden('enviar_form','1');
	?>
		<div class="text-right">
            <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?> 
		    <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a><hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="usuario_id"> Usuario Mayorista</label>
                    <select name="usuario_id" class="form-control select2" id="usersList" required="">
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="estado_id">Estado <span class="required">*</span></label>
                    <select required id="estado_id" name="estado_id" class="form-control chosen-select" >
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
                    <label for="metodo_pago_id">Método de pago <span class="text-danger">*</span></label>
                    <select required id="metodo_pago_id" name="metodo_pago_id" class="form-control select2">
                        <option value="">Selecciona</option>
                        <?php foreach($metodos_pagos as $value): ?>
                            <option value="<?php echo $value->id_payment_method ?>"><?php echo $value->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Producto:</label>
                    <select id="productList" name="product" class="form-control select2-producto">
                        <option value="">Seleccione</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <p style="margin-bottom: 7px;">&nbsp;</p>
                    <button data-action="add-product" class="btn btn-primary" disabled="" type="button" onclick="addProducto(event, this);">Agregar producto</button>
                </div>
            </div>
        </div>
        <hr>
        <table id="tablePedido" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="10%">Cantidad</th>
                    <th width="10%">Código</th>
                    <th width="40%">Producto</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                    <td width="5%">Acciones</td>
                </tr>
            </thead>
            <tbody>
                <tr class="section-products" data-section="section-tbody-products">
                    <td colspan="7" align="center">
                        Agrega productos
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-right">
            <h5>Subtotal:</h5>
            <hr>
            <div id="subtotalShop">
                <h4 data-section="sectionSubtotalPrice">$0.00</h4>
            </div>
        </div>
        <input type="hidden" id="subtotal" name="subtotal" value="0" />
    	<?php echo form_close(); ?>
	</div>
</div>
<script type="text/javascript">
    var table = $("#tablePedido"),
        dataVariants = [],
        products_list_id = [];

    function addProducto(event, elemento)
    {
        var cliente_id = $("select#usersList").val();

        if(!$.isNumeric(cliente_id))
        {
            alert("Seleccione un Usuario Mayorista Primero");

        } else {

            var producto_id = $("select#productList").val();

            if ($.isNumeric(producto_id) && $.inArray(producto_id, products_list_id) <= 0)
            {
                $.ajax({
                    url: base_url + 'ecommerce/pedidos/producto',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        cliente_id: cliente_id,
                        producto_id: producto_id,
                    },
                })
                .done(function(response)
                {
                    addProductSale(response.data);
                    setSubtotal();

                    var user_price_list_id = $('select[name="usuario_id"] option:selected').attr('data-price-list');
                    $('select[name="list[]"]').val(user_price_list_id).attr('readonly', true).css('pointer-events', 'none').trigger('change');

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
    }

    function addProductSale(data)
    {
        resetListProduct();
        addProductTable(data);
        products_list_id.push(data.producto.id_product);
    }

    function addProductTable(data)
    {
        $('[data-section="section-tbody-products"]').remove();

        var innerHtml = [
            '<tr>',
                '<td>',
                    '<input type="number" onchange="changeQty(event, this)" name="product_qty[]" required min="1" class="form-control" value="1" />',
                    '<input name="producto_id[]" value="' + data.producto.id_product + '" type="hidden" />',
                    '<input name="iva[]" value="' + data.producto.iva + '" type="hidden" />',
                    '<input name="price[]" value="' + data.precio_producto + '" type="hidden" />',
                    '<input name="id_iva[]" value="' + data.producto.id_iva + '" type="hidden" />',
                '</td>',
                '<td>',
                    ((data.producto.code !== "null" && data.producto.code !== null) ? data.producto.code : ''),
                '</td>',
                '<td>' + data.producto.name + '</td>',
                '<td data-section="section-unit-price">$ ' + data.precio_producto + '</td>',
                '<td data-section="sectionTotalPrice">$ ' + data.precio_producto + '</td>',
                '<td align="center">',
                    '<a href="#" onclick="removeProduct(event, this)" class="btn btn-danger"><i class="fa fa-trash"></i></a>',
                '</td>',
            '</tr>',
        ];

        table.find('tbody').append(innerHtml.join(''));
    }

    function resetListProduct()
    {
        $("select#productList").val('').trigger('change');
    }

    function removeProduct(event, elemento)
    {
        event.preventDefault();
        $(elemento).closest('tr').remove();
        setSubtotal();
    }

    function changeQty(event, elemento)
    {
        setSubtotal();
    }

    function resetTableProducts()
    {
        var htm = [
            '<tr class="section-products" data-section="section-tbody-products">',
                '<td colspan="7" align="center">',
                    'Agrega productos',
                '</td>',
            '</tr>'
        ];

        $("#sutotalShop").html('<h4 data-section="sectionSubtotalPrice">$0.00</h4>');

        $("table#tablePedido tbody").html(htm.join());
    }

    $(document).on('change', 'select#usersList', function()
    {
        var user_id = $(this).val();

        if ($.isNumeric(user_id))
        {
            $('button[data-action="add-product"]').removeAttr('disabled');

        } else {
            $('button[data-action="add-product"]').attr('disabled', '');

        }

        resetTableProducts();
    })

    $(function()
    {
        $("select#productList").select2({
            width: '100%',
            language: "es",
            allowClear: true,
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

        $("select#usersList").select2({
            width: '100%',
            language: "es",
            minimumInputLength: 2,
            tags: false,
            allowClear: true,
            placeholder: "Selecciona...",
            ajax: {
                url: base_url + 'ecommerce/pedidos/jsonUsuario',
                dataType: 'json',
                type: "post",
                quietMillis: 50,
                data: function (term)
                {
                    return {
                        term: term
                    };
                }
            },
            processResults: function (data)
            {
                return {
                    results: data.items
                };
            }
        });

    });

    $(document).on('change keyup', 'select[name="list[]"], input[name="product_qty[]"]', function() {
        var list_price = 0,
            product_qty = 0,
            total = 0,
            subtotal= 0;
        if ($(this).attr('name') == 'list[]') {
            var list_id = $(this).val(),

            list_price = $(this).parent().find('option[value="'+list_id+'"]').attr('data-price'),
            product_qty = $(this).closest('tr').find('input[name="product_qty[]"]').val(); 
        }

        else {
            product_qty = $(this).val(),
            // list_id = $(this).closest('tr').find('select[name="list[]"]').val();
            list_price = $(this).closest('tr').find('select[name="list[]"] option:selected').attr('data-price');
        }

        list_price = ($.isNumeric(list_price)) ? list_price : 0;
        product_qty = ($.isNumeric(product_qty)) ? product_qty : 0;
        total = list_price * product_qty;
        $(this).closest('tr').find('td[data-section="sectionTotalPrice"]').html(total);
        setSubtotal();
    });

    function setSubtotal()
    {
        var table = $("table#tablePedido");
        var subtotal = 0;

        table.find('tbody tr').each(function(index, el)
        {
            var cantidad = parseInt($(this).closest('tr').find('input[name="product_qty[]"]').val());
            var valuePrice = $.trim($(this).closest('tr').find('td[data-section="section-unit-price"]').html());
            valuePrice = $.trim(valuePrice.replace('$', ''));

            var precio = 0;
            if ($.isNumeric(valuePrice))
            {
                precio = parseFloat(valuePrice);
                $(this).closest('tr').find('td[data-section="sectionTotalPrice"]').text('$ ' + (precio * cantidad).toFixed(2));
                subtotal += (precio * cantidad);
            }

        });

        $('h4[data-section="sectionSubtotalPrice"]').html('$ ' + subtotal.toFixed(2));
        $("input#subtotal").val(subtotal.toFixed(2));
    }

    $(document).on('change', 'select[name="usuario_id"]', function() {
        if ($.isNumeric($(this).val())) {
            var price_list_id = $(this).find('option:selected').attr('data-price-list');
            $('select[name="list[]"]').val(price_list_id).trigger('change');
        }
    });

</script>