//My Functions
$(document).on('ifChecked','input[name="expreso"]',function(event) {
    valor = $(this).val();
    if(valor == 1){
        $('#description_expreso').removeClass('d-none');
    }
    else if(valor == 0){
        $('#description_expreso').addClass('d-none');
    }
});
$(document).on("submit","[data-action='add-product-fast']",function(event) {
    event.preventDefault();
    var input_id,unit_bulto,type_id,process = true;
    input_id = $('#inputProductCart').val();
    unit_bulto= $('#unitPack').val();
    type_id = $('input[name="optionShopping"]:checked').val();
    if (process) {
        var data = {
            'enviar_form': '1',
            'id_product': input_id,
            'qty': $('#qty').val(),
            'unit_bulto': unit_bulto,
            'type_id':type_id,
        }
        $.ajax({
            type: 'POST',
            url: base_url+'frontend/ajax/insertProductCart',
            data: data,
            dataType: 'json',
        })
        .done(function(response){
            if(!response.success){
                $('#messageValidationStock').html('Sin stock disponible');
            }else{
            $('span[data-action="cart-can"]').html(response.num);
            $('#cart_total').html('$ ' + response.total);
            if($('#modalShoppingFast').length>0){
                $('#modalShoppingFast').modal('hide');
                $('#qty').val(1);
            }
            $('#modalShoppingSuccess').modal('show');
                setTimeout(function(){ 
                $('#modalShoppingSuccess').modal('hide'); 
            }, 2000);
            }
             
        })
        .fail(function (error) {
            alert("No se pudo agregar este producto.", 'error');
            console.log(error)
        }).always(function(){
            console.log('complete');
        })
    }
});

$(document).on("click","[data-action='showOrderDetail']",function(event) {
    event.preventDefault();
    var input_id,process = true;
    if (process) {
        var data = {
            'enviar_form': '1',
            'id_order': $(this).attr('data-id'),
        }
        $.ajax({
            type: 'POST',
            url: base_url+'frontend/ecommerce/getOrderProducts',
            data: data,
            dataType: 'json',
        })
        .done(function(response){
            $('#order_detail').modal('show');
            var html = '';
            var htm = '';
            var htm1 = '';
            var htm2 = '';
            var total = 0;
            var cost_shipping=0;
            var total_cost = 0;
            var subtotal = 0;
            var discount_total = 0;
            $.each( response.response, function( k, v ) {
                cost_shipping = v.shipping_price;
                subtotal = subtotal + (v.qty*v.price);
                discount_total = discount_total + parseFloat(v.discount);
                total = total + ((v.qty*v.price)-discount_total) + parseFloat(v.shipping_price);
                html = html + '<tr><td>'+(k+1)+'</td><td>'+(v.producto)+'</td><td>'+(v.type_id == 1 ? "Unidad":"Bulto")+'</td><td>'+(v.qty)+'</td><td>'+'$ '+(v.price)+'</td><td>'+'$ '+(subtotal) .toFixed(2)+'</td></tr>';
                htm1= htm1+ '<h5>Total: $ '+(parseFloat(total).toFixed(2))+'</h5>';
                htm= htm+ '<h6>Costo de Envio: $ '+(parseFloat(cost_shipping).toFixed(2))+'</h6>';
                htm2= htm2+ '<h6>Descuento: $ '+(parseFloat(discount_total).toFixed(2)) +'</h6>';
            });
            $('table#detail_table tbody').html(html);
            if(cost_shipping>0){
                if(discount_total>0){
                    $('#discount').html(htm2);
                    $('#total_detail').html(htm1);
                    $('#cost_shipping').html(htm);
                }
                else{
                    $('#discount').html('');
                    $('#total_detail').html(htm1);
                    $('#cost_shipping').html(htm);   
                }
                
            }
            else {
                if(discount_total>0){
                    $('#discount').html(htm2);
                    $('#cost_shipping').html('');
                    $('#total_detail').html(htm1);
                }
                else{
                    $('#discount').html('');
                    $('#cost_shipping').html('');
                    $('#total_detail').html(htm1);
                }
               
            }
            
        })
        .fail(function (error) {
            messageError("No se pudo agregar este producto.", 'error');
        }).always(function(){
            console.log('complete');
        })
    }
});
$(document).on("click","[data-action='add-product']",function(event) {
    event.preventDefault();
    var id,unit_bulto,type_id,process = true;
    id = $(this).attr('data-id');
    unit_bulto= $(this).attr('data-pack');
    type_id = $('input[name="optionShopping"]:checked').val();
    if (process) {
        var data = {
            'enviar_form': '1',
            'id_product': id,
            'qty': $('#qty').val(),
            'unit_bulto': unit_bulto,
            'type_id':type_id,
        }
        $.ajax({
            type: 'POST',
            url: base_url+'frontend/ajax/insertProductCart',
            data: data,
            dataType: 'json',
        })
        .done(function(response){
            if(!response.success){
                $('#messageValidationStock').html('Sin stock disponible');
            }else{
            $('span[data-action="cart-can"]').html(response.num);
            $('#cart_total').html('$ '+response.total);
            if($('#modalShoppingSuccess').length>0){
                $('#modalShoppingSuccess').modal('show');
                setTimeout(function(){ 
                    $('#modalShoppingSuccess').modal('hide'); 
                }, 2000);
            }}
        })
        .fail(function (error) {
            messageError("No se pudo agregar este producto.", 'error');
        }).always(function(){
            console.log('complete');
        })
    }
});
$(document).on("click","[data-action='open-shopping-modal']",function(event) {
    event.preventDefault();
    $('#inputProductCart').val($(this).attr('data-id'));
    $('#unitPack').val($(this).attr('data-pack'));
    $('#qty').val(1);
    $('#messageValidationStock').html('');
});
$(document).on("click","[data-action='delete_product']",function(event) {
    event.preventDefault();
    var element = $(this);
    var data = {
        delete_form: '1',
        id: $(element).attr('data-id'),
    };
    $.ajax({
        type: "POST",
        url: base_url + 'frontend/ajax/deleteProduct',
        data: data,
        dataType: 'JSON',
        cache: false,
        success: function(response) {
            $(element).closest('tr').remove();
            var cart_total  = parseFloat(response.total);
            $("#cart_total").text('$'+(cart_total.toFixed(2).toString()));
            $('#cart_menu_num').html(response.num_items);

            
            $("#shipping_cost").html('ENVÍO: $ 0.00');
            $("#total").text(cart_total.toFixed(2).toString());
            $("#shipping_total").text('TOTAL: $ '+(cart_total.toFixed(2).toString()));

            if (!$("table tbody tr").length) {
                location.reload();
            }
             calculoEnvioGratis();
             getDiscount();
        },
        error: function(){
            /*$("#modalKoEliminar").modal();
            window.setTimeout(cerrarModalKo, 2400);*/
        }
    });
});
$(document).on("ifChanged","input[data-action='applyFilters']",function(event) {
    //event.preventDefault();
    window.location.href = $(this).attr('data-url');
});
$(document).on('change', 'select#shipping_method', function (event) {
    event.preventDefault();
    changeMetodoEntrega();
});

var discount = 0;
function getDiscount()
{
    var total = parseFloat($('#total').html());
    $.ajax({
        type: 'post',
        url: base_url + 'frontend/ecommerce/getDiscount',
        data: { total:total },
        dataType: 'json',
        beforeSend: function () {
            // $("div#shipping_spinner").html('<p align="center"><i class="fa fa-spin fa-spinner fa-2x"></i></p>');
        }
    }).done(function (data) {
        var htm = '';
        var htm2 = '';
        var htm3 = '';
        if (data.success) {
            var discount_percent = parseFloat(data.response.discount);
                discount = (discount_percent/100)*total;
            var discounted_total = total - discount;
            htm = 'DESCUENTO: $ '+ (discount).toFixed(2);
            htm2 = 'TOTAL: $ '+ (discounted_total).toFixed(2); 
        }
        else {
            htm = 'DESCUENTO: $ 0.00';
            htm2 = 'TOTAL: $ '+(total.toFixed(2));
        }
        // $("input[name='discount']").val(discounted_total);
        $("#discount").html(htm);
        $("#shipping_total").html(htm2);
    }).fail(function (error) {
        console.log('error');
    }).always(function () {
        console.log('complete');
    })
}

$(document).on('change','select#payment_method',function (event) {
    
var select = $('select#payment_method');
console.log(select.val());
var payment_method = select.val();
    if (payment_method == 4)
    {
        $('#santander').removeClass('d-none')
    }
    else{
        $('#santander').addClass('d-none')
    }
});

function changeMetodoEntrega()
{   
    var total = parseFloat($('#total').html());
    var envio = parseFloat($('#shipping_cost').html());
    $.ajax({
    type: 'post',
    url: base_url + 'frontend/ecommerce/getDiscount',
    data: { total:total },
    dataType: 'json',
     beforeSend: function () {
            // $("div#shipping_spinner").html('<p align="center"><i class="fa fa-spin fa-spinner fa-2x"></i></p>');
    }
    }).done(function (data) {
        var htm = '';
        var htm2 = '';
        var htm3 = '';
        if (data.success) {
            var total = parseFloat($('#total').html());
            var discount_percent = parseFloat(data.response.discount);
           
                discount = (discount_percent/100)*total;
            var discounted_total = total - discount;
            htm = 'DESCUENTO: $ '+ (discount).toFixed(2);
            htm2 = 'TOTAL: $ '+ (discounted_total).toFixed(2);
            if(envio > 0 ){
                htm3 = 'ENVIO: $'+ (envio);
            }else{
                htm3 = 'ENVIO: $ 0.00';
            }
        }
        else{
            htm = 'DESCUENTO: $ 0.00';
                var total = parseFloat($('#total').html());
                htm3 = 'ENVÍO: $ 0.00';
                htm2 = 'TOTAL: $ '+(total.toFixed(2));
              
            
            
            }
            var select = $('select#shipping_method');
            var valorMinimoCompraEnvio = parseFloat($("input#freeShipping").val());
            var valorTotalVenta = parseFloat($.trim($("#total").text()));
            if (valorMinimoCompraEnvio > valorTotalVenta)
            {   $("div#shipping_container").html('');
                $('#shipping_id').val(0);
                $('#shipping').val(0);
                 var shipping_method = select.val();
                if (shipping_method != "")
                {
                    switch (shipping_method)
                    {
                        case '1':
                            calculadorMercadoEnvios();
                            break;
                        case '3':
                            createSpecificShipping();
                        case '2':
                            $('.expreso').addClass('d-none');
                        default:
                            break;
                    }
                }
            }
        $("#discount").html(htm);
        $("#shipping_total").html(htm2);
        $('#shipping_cost').html(htm3);
    }).fail(function (error) {
        console.log('error');
    }).always(function () {
        console.log('complete');
    });
    
}
function calculadorMercadoEnvios()
{
    $('.expreso').removeClass('d-none');
}
function createSpecificShipping()
{
    $('.expreso').addClass('d-none');
    var htm = '';
    var elemento = $("div#shipping_container");
    htm += '<div class="form-group">' +
        '<input type="text" id="postal_code" class="form-control" placeholder="Código postal" name="postal_code">' +
        '<input value="0" type="hidden" id="shipping_id" name="shipping_id">' +
        '</div>';
    htm += '<div class="form-group text-center">' +
        '<button type="button" onclick="getShippingSpecific(event)" class="btn btn-send">CALCULAR</button>' +
        '<div class="mt-2" id="shipping_spinner"></div>' +
        '</div>';
    htm += '<div id="shipping_alert" class="form-group">' +
        '</div>';
    elemento.html(htm);
}
function getShippingSpecific()
{
    var postal_code = $("input#postal_code").val();
    var total = parseFloat($('#total').html());

    $.ajax({
        type: 'post',
        url: base_url + 'frontend/ecommerce/getShippingSpecific',
        data: { postal_code: postal_code },
        dataType: 'json',
        beforeSend: function () {
            $("div#shipping_spinner").html('<p align="center"><i class="fa fa-spin fa-spinner fa-2x"></i></p>');
        }
    }).done(function (data) {
        var htm = '';
        var htm2 = '';
        var htm3 = '';
        if (data.success) {
            var shipping_cost = parseFloat(data.response.price_shipping);
            $('#shipping_id').val(data.response.shipping_id);
            var freeShipping = $("input#freeShipping").val();
            if(total>= freeShipping){
                htm2 = '' +
                'ENVIO GRATIS ¡por superar el minino coste para el envio!';
                htm3 = 'TOTAL: $ '+ (total-discount).toFixed(2);
            }else{
                htm2 = '' +
                'ENVÍO: $ ' + shipping_cost.toFixed(2);
                htm3 = 'TOTAL: $ '+ ((total+shipping_cost)-discount).toFixed(2);
            }    
        }
        else {
            htm = '<div class="alert alert-warning"><strong>No se puede enviar a este código postal.</strong><br> Por favor, intente con otra forma de entrega.</div>';
            htm2 = 'ENVÍO: $ 0.00';
            htm3 = 'TOTAL: $ '+(total.toFixed(2));
        }
        $("div#shipping_alert").html(htm);
        $("div#shipping_spinner").html('');
        $("#shipping_cost").html(htm2);
        $("#shipping_total").html(htm3);
    }).fail(function (error) {
        console.log('error');
    }).always(function () {
        console.log('complete');
    })
}
function calcularMercadoEnvios()
{
    var elemento = $("div#shipping_cost_container");
    var postal_code = $("input#postal_code").val();
    var total = parseFloat($('#total').html());
    $.ajax({
        type: 'post',
        url: base_url + 'frontend/ecommerce/mercadoEnvio',
        data: { postal_code: postal_code },
        dataType: 'json',
        beforeSend: function () {
            $("div#shipping_spinner").html('<p align="center"><i class="fa fa-spin fa-spinner fa-2x"></i></p>');
        }
    }).done(function (data) {
        var htm = '';
        var htm2 = '';
        var htm3 = '';
        if (data.success) {
            var shipping_cost = parseFloat(data.response.response.options[0].cost);
            var shipping_time = data.response.response.options[0].estimated_delivery_time.shipping;
            htm2 = '' +
            'ENVÍO: $ ' + shipping_cost.toFixed(2);
            htm3 = 'TOTAL: $ '+ (total+shipping_cost).toFixed(2);
            $('#shipping').val(shipping_cost);
        }
        else {
            htm = '<div class="alert alert-warning"><strong>No se puede enviar a este código postal.</strong><br> Por favor, intente con otra forma de entrega.</div>';
            htm2 = 'ENVÍO: $ 0.00';
            htm3 = 'TOTAL: $ '+(total.toFixed(2));
            $('#shipping').val(0);
        }
        $("div#shipping_alert").html(htm);
        $("div#shipping_spinner").html('');
        $("#shipping_cost").html(htm2);
        $("#shipping_total").html(htm3);
    }).fail(function (error) {
        console.log('error');
    }).always(function () {
        console.log('complete');
    })
}
function getShippingCost(event)
{
    event.preventDefault();
    var input = $("input#postal_code");
    if (input.val() != "")
    {
        var datos = calcularMercadoEnvios();
    }
    else {
        document.getElementById("postal_code").focus();
    }
}
$(document).on('change','#document',function(event){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
})

function changeProvince(event, elemento)
{
    var province = $(elemento).val();

    if ($.isNumeric(province))
    {
        $.ajax({
            url: base_url + 'frontend/ajax/locations',
            type: 'POST',
            dataType: 'json',
            data: {
                province: province,
            },
        })
        .done(function(data)
        {
            var htm = '<option value="">Selecciona</option>';
            $.each(data.locations, function(index, val)
            {
                htm += '<option value="' + val.id + '">' + val.localidad + '</option>';
            });
            $('select[data-element="locations"]').html(htm);
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    } else{
        $('[data-element="locations"]').html('<option value="">Selecciona</option>');
    }
}
function submitFastShopping(event, elemento)
{
    event.preventDefault();
    var id,process = true;
    id = $(this).attr('data-id');
    if (process) {
        var data = {
            'enviar_form': '1',
            'id_product': id,
            'qty': $('#qty').val(),
        }
        $.ajax({
            type: 'POST',
            url: base_url+'frontend/ajax/insertProductCart',
            data: data,
            dataType: 'json',
        })
        .done(function(response){
            $('#cart_cant').html(response.num_items);
            $('#cart_total').html('$ '+response.total);
            if($('#modalShoppingSuccess').length>0){
                $('#modalShoppingSuccess').modal('show');
                setTimeout(function(){ 
                    $('#modalShoppingSuccess').modal('hide'); 
                }, 2000);
            }
        })
        .fail(function (error) {
            messageError("No se pudo agregar este producto.", 'error');
        }).always(function(){
            console.log('complete');
        })
    }
    
}

function submitLogin(event, elemento)
{
    event.preventDefault();
    var datos = $(elemento).serialize();

    $.ajax({
        url: base_url + 'frontend/ajax/login',
        type: 'POST',
        dataType: 'json',
        data: datos,
        beforeSend: function()
        {
            $(elemento).find('button').attr('disabled', '');
            $(elemento).find('.section-message').html('');
        },
    })
    .done(function(data)
    {
        $(elemento).find('button').removeAttr('disabled');
        $(elemento)[0].reset();
        if (data.success)
        {
            window.location.reload();
        } else {
            var htm = '<div class="alert alert-warning"><a href="#" class="close" data-dismiss="alert">&times;</a> '+ data.message + '</div>';
            $(elemento).find('.section-message').html(htm);
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
function CalcularDescuentodiff(){
   return 0
}

function calcularSubtotalPedido(input)
{
    var elemento = $(input);
    var qty = elemento.val();

    if (elemento.val() > 0 && $.isNumeric(elemento.val())) {

        $.ajax({
            url: base_url + 'frontend/ajax/edicionProductCart',
            type: 'POST',
            data: {
                enviar_form: '1',
                cantidad: elemento.val(),
                rowid: elemento.attr('id')
            },
            dataType: 'json',
            beforeSend: function () {
                elemento.attr('readonly', '');
            },
            success: function (data)
            {
            
                var dataJson = eval(data);
                var precio_unitario = elemento.attr('data-price');

                elemento.removeAttr('readonly');
                precio_unitario = parseFloat(precio_unitario);
                qty = parseInt(qty);
                precio_unitario = precio_unitario * qty;
                

        
            
                if (data.success==true)
                {
                 
                    elemento.closest('tr').find('td .diff_discount').text('$' + precio_unitario.toFixed(2));
                    elemento.closest('td').find('span.text-danger.qty-message').text('');

                    //revalido los descuentos diferenciales
                    if(data.new_desc){
                        desc = (data.new_desc/100)*precio_unitario;
                        subtotal = precio_unitario - desc;
                        elemento.closest('tr').find('td .price').text('$' + subtotal.toFixed(2));
                        elemento.closest('tr').find('td .diff_discount').text('$' + desc.toFixed(2));
                        elemento.closest('tr').find('td .desc').text('Descuento de ' +data.new_desc+'%');
                    }else{
                        elemento.closest('tr').find('td .diff_discount').text('$0.00');
                        elemento.closest('tr').find('td .price').text('$' + precio_unitario.toFixed(2));
                        elemento.closest('tr').find('td .desc').text('');
                    }
                    console.log(data)
                }else if(data.success==false){
                    elemento.closest('td').find('span.text-danger.qty-message').text('Cantidad no disponible.');
                }

                $("#total_carrito_envio").attr("total", dataJson.total);
                $("span#total_carrito_envio").text(dataJson.total);
                $("#gastos_envio").html("0.00");
                total_carrito = dataJson.total;
                $("#cart_total").html('$ ' + dataJson.total);
                $("#total").html(dataJson.total);
                $("#shipping_cost").html('ENVÍO: $ 0.00');
                $("#shipping_total").html('TOTAL: $ ' + dataJson.total);

                $("div#section-costo-envio").html('');
                $("div#section-costo-total").html('');
                $("input#codigo_postal").val('');
                $("span.items-cart").text(data.num_items);

                elemento.val(data.cantidad);
                elemento.blur();

                calcularTotalCompra();
                calculoEnvioGratis();
                getDiscount();
                $('#shipping_method').val('');
                $('#shipping_container').html('')
            },
            error: function () {
                console.log("error");
            }
        });

    }
}

function calcularTotalCompra()
{
    var subtotal = getSubotal();
    var descuento = getDescuento();
    var envio = getCostoEnvio();
    if (descuento > 0 || envio > 0)
    {
        var pagoTotal = subtotal - descuento + envio;
        showTotal(pagoTotal);
    }
}

function getDescuento()
{
    var descuento = 0;
    if ($("input#montoDescuento").length)
    {
        descuento = $("input#montoDescuento").val();
        descuento = parseFloat(descuento);
    }
    return descuento;
}

function getCostoEnvio()
{
    var envio = 0;
    if ($("input#costo_envio").val())
    {
        envio = $("input#costo_envio").val();
        envio = parseFloat(envio);
    }
    return envio;
}

function getSubotal()
{
    var subtotal = $("#total_pagar").text().trim();
    subtotal = parseFloat(subtotal.replace(',', ''));
    return subtotal;
}

function showTotal(pagoTotal)
{
    var total = pagoTotal.toFixed(2);

    var innerHtml = [
        '<div class="pull-right">',
            '<h2 align="right">',
                '<p style="font-size:16px;">TOTAL A PAGAR:</p>',
                '$<span>' + total + '</span>',
            '</h2>',
        '</div>',
    ];

    $("div#section-costo-total").html(innerHtml.join(''));
}
$(document).ready(function() {
    $('#email').change(function() {
        var email = $('#email').val();    
        $.ajax({
            type: "POST",
            url: base_url + 'validar-email',
            data: {email: email},
            cache: false,
            beforeSend: function(){
                $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
            },
            success: function(respuesta){
                var json = jQuery.parseJSON(respuesta);
                if (json.Value == 0) {
                    $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></button><strong>Ocurrio un error</strong>. Ya existe un usuario con el ese Email.</div>');
                    $('#email').val('');
                    $('#email').focus();
                }else{
                    $('#errorForm').html('');
                }                
            },
            error: function(){
                $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Ocurrio un error</strong>. Por favor intentelo nuevamente!.</div>');
            }
        });
    });
});
$(document).ready(function() {
        $('#dni').change(function() {
            var dni = $('#dni').val();    
            $.ajax({
                type: "POST",
                url: base_url + 'validar-dni',
                data: {dni: dni},
                cache: false,
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(respuesta){
                    var json = jQuery.parseJSON(respuesta);
                    if (json.Value == 0) {
                        $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></button><strong>Ocurrio un error</strong>. Ya existe un usuario con ese Dni/CUIT.</div>');
                        $('#dni').val('');
                        $('#dni').focus();
                    }else{
                        $('#errorForm').html('');
                    }                
                },
                error: function(){
                    $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Ocurrio un error</strong>. Por favor intentelo nuevamente!.</div>');
                }
            });
        });
    });
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue',
    increaseArea: '20%' // optional
  });
});
function shopFastProduct(event, elemento)
{
    event.preventDefault();
    var product_id = $(elemento).attr('data-id');
    var unit_bulto = $(elemento).attr('data-pack');
    $("#modalShoppingFast").modal("show");
   
}

