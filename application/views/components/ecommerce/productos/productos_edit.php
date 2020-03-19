<div class="col-lg-12">
    <div class="element-box">
		<?php
			echo form_open_multipart(current_url(), array('class'=>""));
			echo form_hidden('enviar_form','1');
        ?>
            <div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar Cambios','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?>
                <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a><hr>
            </div>
            <div id="errorForm"></div>
			<?php echo form_hidden('id',$result->id_product) ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="code">Código <span class="required">*</span></label>
                        <input id="code" name="code" type="text" class="form-control" placeholder="Código" value="<?php echo $result->code ?>" />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="name">Nombre de producto<span class="required">*</span></label>
                        <input id="name" name="name" type="text" class="form-control" placeholder="Nombre" value="<?php echo $result->name ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Descripcion<span class="required">*</span></label>
                        <textarea id="description" rows="4" name="description" class="form-control summernote" placeholder="Descripción"><?php echo($result->description); ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categoria_id">Categoría<span class="required">*</span></label>
                        <select id="categoria_id" onchange="cargaSubcategorias(event, this)" name="categoria_id" class="form-control chosen-select">
                            <option value="">Selecciona</option>
                            <?php foreach ($categorias as $f): ?>
                                <option value="<?php echo $f->id_category ?>" <?php echo ($f->id_category == $id_category)? 'selected' : '' ?>><?php echo $f->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="subcategoria_id">Subcategoría<span class="required">*</span></label>
                        <select id="subcategoria_id" onchange="cargaSegundasSubcategorias(event, this)" name="subcategoria_id" class="form-control select2" required>
                            <option value="">Selecciona</option>
                            <?php foreach ($subcategorias as $f): ?>
                                <option value="<?php echo $f->id_subcategory ?>" <?php if($f->id_subcategory == $id_subcategory) echo 'selected' ?>><?php echo $f->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="producto_realacion">Productos Relacionados</label>
                            <select id="related_products" name="related_products[]" class="form-control" multiple="">
                                <?php foreach ($related_products as $k => $v): ?>
                                    <option value="<?php echo $v->id_product ?>" selected=""><?php echo $v->code.' '.$v->name ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">    
                        <label for="unitXbulto">Unidades por Bulto<span class="required">*</span></label>
                        <input name="unitXbulto" class="form-control" type="number" placeholder="Unidades por Bulto" value="<?php echo($result->unit_bulto > 0) ? "$result->unit_bulto" :"1" ?>" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_bulto">Stock<span class="required">*</span></label>
                        <input required id="stock" name="stock" type="number" class="form-control" min="0" value="<?php echo $result->stock ?>" placeholder="Stock" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Precio minorista Individual<span class="required">*</span></label>
                        <input name="indi_price" type="text" class="form-control" value="<?php echo $result->price_individual ?>" placeholder="Precio minorista Individual" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_bulto">Precio minorista por Bulto <span class="required">*</span></label>
                        <input name="bulto_price" type="text" class="form-control" value="<?php echo $result->price_package ?>" placeholder="Precio minorista por bulto" />
                    </div>
                </div>  
            </div>       
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group i-checks">
                        <label for="active"> ¿Es destacado?</label><br>
                        <label class="radio">
                            <input type="radio" name="destacado" value="1" <?php echo ($result->featured == 1) ? 'checked' : '' ;  ?> /> Si
                        </label> &nbsp;
                        <label class="radio">
                            <input type="radio" name="destacado" value="0" <?php echo ($result->featured == 0) ? 'checked' : '' ; ?> /> No
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group i-checks">
                        <label for="active"> ¿Es oferta?</label><br>
                        <label class="radio">
                            <input  type="radio" name="oferta" value="1" <?php echo ($result->offer == 1) ? 'checked' : '' ; ?> /> Si
                        </label> &nbsp;
                        <label class="radio">
                            <input  type="radio" name="oferta" value="0" <?php echo ($result->offer == 0) ? 'checked' : '' ; ?> /> No
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group <?php echo ($result->offer == 0 ? 'd-none' : '') ?>">    
                        <label for="offer-price">Oferta Individual</label>
                        <input type="text" class="form-control" placeholder="Precio de Oferta" name="offer-price" value="<?php echo($result->offer_price) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group <?php echo ($result->offer == 0 ? 'd-none' : '') ?>">    
                        <label for="offer-price-bulto">Oferta Bulto</label>
                        <input type="text" class="form-control" placeholder="Precio de Oferta" name="offer-price-bulto" value="<?php echo($result->offer_price_bulto) ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="iva">IVA <span class="required">*</span></label>
                        <select id="iva" name="iva" required="" class="form-control select2">
                            <option value="">Seleccionar</option>
                            <?php foreach ($ivas as $key => $value): ?>
                                <option value="<?php echo $value->id_iva ?>" <?php echo $value->id_iva == $result->id_iva ? 'selected' : '' ?>><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="height">Alto<span class="required">*</span></label>
                        <input required id="height" name="height" step=".01" type="number" class="form-control" placeholder="Centímetros" value="<?php echo $result->height ?>"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="width">Ancho<span class="required">*</span></label>
                        <input required id="width" name="width" step=".01" type="number" class="form-control" placeholder="Centímetros." value="<?php echo $result->width ?>"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="depth">Profundidad<span class="required">*</span></label>
                        <input required id="depth" name="depth" step=".01" type="number" class="form-control" placeholder="Centímetros." value="<?php echo $result->depth ?>"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="weight">Peso<span class="required">*</span></label>
                        <input required id="weight" name="weight" step=".01" type="number" class="form-control" placeholder="Gramos." value="<?php echo $result->weight ?>"/>
                    </div>
                </div>
            </div>                        
            <h6 class="subtitle-profile">IMAGEN DEL PRODUCTO</h6>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="imagen">Imagen 1<span class="required">*</span></label>
                        <input  id="imagen1" accept="image/*" name="imagen1" type="file" class="form-control" />
                        <span class="help-block">Tamaño mínimo recomendado (600px , 600px)</span><br>
                        <strong><span class="help-block text-danger">Imagen: <?php echo $result->image1 ?></span></strong>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($listpre as $list): ?>
                <?php if($list->active > 0): ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="listaprecios"><?php echo $list->name ?></label>
                            <input  id="<?php echo $list->id_list_price ?>"  name="list_price_id[]" type="text" class="form-control" value="<?php echo $list->price ?>" />
                        </div>
                    </div>
                <?php endif ?>
                <?php endforeach ?>
            </div>
            <div class="row">
            <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_differential_discount">Descuento Diferencial</label>
                        <select id="id_differential_discount"  name="id_differential_discount" class="form-control chosen-select">
                        <option value="">Seleccionar</option>
                        <?php foreach ($descuentos as $desc): 
                           $selected = ($result->id_differential_discount == $desc->id_differentias_discounts) ? 'selected':'' ;
                            ?>
                                <option <?php echo $selected ?> value="<?php echo $desc->id_differentias_discounts ?>"><?php echo $desc->name_differentias_discounts ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                </div>    
            <hr/>
            <hr>
            <div class="row">
                <div id="image_input" class="d-none">
                    <input type="file" class="form-control" name="op[]">
                </div>
                <div class="col-sm-4">
                    <h6>GALERÍA DE IMÁGENES</h6>
                    <div class="form-group">
                        <span class="help-block">Tamaño sugerido: 1024x1000 píxeles.</span>
                    </div>
                    <button type="button" class="btn btn-primary" id="image_upload"><i class="fa fa-plus"></i> AGREGAR IMAGEN</button>
                </div>
            </div>
            <div class="row mb-4" id="image_gallery">
                <?php if (count($gallery) > 0) { ?>
                    <?php foreach ($gallery as $key => $value): ?>
                        <div class="galeria_thumb col-sm-3 col-md-2 col-xs-6">
                            <div id="prev_<?php echo uniqid() ?>" style="background: url(<?php echo base_url('uploads/img_productos/'.$value->image) ?>);background-size:contain;background-position: center;background-repeat: no-repeat;height: 180px;width: 100%;"  class="img-responsive img-thumbnail"></div>
                            <a href="#" class="btn btn-danger btn-sm btn-delete-image" data-id="<?php echo $value->id_product_image ?>" data-image="img_<?php echo $value->id_product_image ?>" style="position: absolute;right: 15px;top:0;"><i class="fa fa-times"></i></a>
                        </div>
                    <?php endforeach ?>
                <?php } ?>
            </div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php $this->view('components/ecommerce/productos/productos_js') ?>

<script type="text/javascript">
$(document).ready(function()
{
    $("#related_products").select2({
        placeholder: "Ingresa código o nombre del producto.",
        allowClear: true,
        limit: 3,
        language: {
            noResults: function()
            {
               return "No se encontraron resultados";
            }
        },
        minimumInputLength: 2,
        maximumSelectionLength: 3,
        tags: false,
        ajax: {
            url: base_url + 'ecommerce/productos/jsonRelatedProducts',
            dataType: 'json',
            type: "POST",
            quietMillis: 100,
            data: function (term)
            {
                return {
                    term: term
                };
            }
        }
    });
});

$(document).ready(function()
{
    $('#code').change(function()
    {
        var id = '<?php echo $result->id_product; ?>',
            code = $('#code').val();
        if (code.length <= 3) {
            return false;
        } 
        $.ajax({
            type: "POST",
            url: base_url + 'ecommerce/productos/ValidarCode/',
            data: {
                id: id,
                code: code
            },
            cache: false,
            dataType: 'JSON',
            beforeSend: function(){
                $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
            },
            success: function(response)
            {
                if (!response.status)
                {
                    $('#code').val('');
                    $('#code').focus();
                }

                $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></button><strong>'+response.msg+'</strong>. '+response.msj+'.</div>');         
            },
            error: function()
            {
                $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Ocurrio un error</strong>. Por favor intentelo nuevamente!.</div>');
            }
        });
    });
});

$(document).on('change','input[type=radio][name=oferta]',function(){
    if ($(this).val() == 0) {
        $('input[name="offer-price"]').parent().addClass('d-none');
        $('input[name="offer-price-bulto"]').parent().addClass('d-none');
    }

    else {
        $('input[name="offer-price"]').parent().removeClass('d-none');
        $('input[name="offer-price-bulto"]').parent().removeClass('d-none');
    }
});

function changeColor(event, elemento) {

    var table = $("table#table_talles");
    var colores = table.find('select[name="color[]"]');

    var coloresGrupos = [];
    var coloresIds = [];

    if (colores.length) {

        colores.each(function(index, elemento) {
            var colorId = $(elemento).val();
            if ($.isNumeric(colorId)) {
                var colorNombre = $.trim($(elemento).find('option[value="'+colorId+'"]').text());
                if ($.inArray(colorNombre, coloresGrupos) === -1) {
                    coloresGrupos.push(colorNombre);
                    coloresIds.push(parseInt(colorId));
                }
            }
        });

        var coloresFilas = [];

        $("table#tableColoresList tbody tr").each(function(index, elemento) {
            var colorFila = parseInt($(elemento).attr('data-color'));
            if($.inArray(colorFila, coloresIds) === -1){
                $(elemento).remove();
            }
            coloresFilas.push(colorFila);
        });


        var htm = '';

        $.each(coloresIds, function(index, value) {

            if ($.inArray(value, coloresFilas) === -1) {
                htm += ''+
                '<tr class="regitro-color-'+value+'" data-color="'+value+'">'+
                    '<td>'+
                        coloresGrupos[index]+
                    '</td>'+
                    '<td>'+
                        '<input type="hidden" name="color_group[]" value="'+value+'">'+
                        '<input type="file" name="color_imagen['+value+'][]" onchange="changeImageValidation(this);" class="form-control" multiple="" required="">'+
                    '</td>'+
                    '<td width="25%"></td>'+
                '</tr>';
            }

        });

        $("table#tableColoresList tbody").append(htm);

    }
    else {

        $("table#tableColoresList tbody").html('');

    }

}

function agregaTalleProducto(event, elemento) {
    event.preventDefault();

    var htm = ''+
    '<tr>'+
        '<td>'+
            '<select class="form-control" name="talle[]" required="">'+
                '<option value="">Selecciona</option>';

                $.each(talles,function(index, valor) {
                    htm += '<option value="' + valor.id_size + '">' + valor.name + '</option>';
                });

    htm +=  '</select>'+
        '</td>'+
        '<td>'+
            '<select class="form-control" onchange="changeColor(event, this)" name="color[]" required="">'+
                '<option value="">Selecciona</option>';

    $.each(colores,function(index, valor) {
        htm += '<option value="' + valor.id_color + '">' + valor.name + '</option>';
    });

    htm +=  ''+
            '</select>'+
        '</td>'+
        '<td>'+
            '<input type="number" name="stock[]" class="form-control" value="0"  required="">'+
        '</td>'+
        '<td align="right">'+
            '<a href="#" class="btn btn-danger" onclick="eliminaTalleProducto(event, this)"><i class="fa fa-trash"></i></a>'+
        '</td>'+
    '</tr>';

    $("#table_talles").append(htm);

}

function eliminaTalleProducto(event,elemento){
    event.preventDefault();
    $(elemento).closest('tr').remove();
}

    // $(document).on("click","#cargarImagen",function(event){
    //     event.preventDefault();
    //     var uniq = 'img_' + (new Date()).getTime();
    //     $("#input_imagenes").append('<input type="file" id="'+uniq+'" name="op[]" onchange="readURL(this,\''+uniq+'\')" accept="image/x-png,image/gif,image/jpeg" class="d-none">');
    //     document.getElementById(uniq).click();
    // });

    // function readURL(input, imagen) {
    //   if (input.files && input.files[0]) {
    //     $("#galeria_imagenes").append('<div class="galeria_thumb col-sm-3 col-md-2 col-xs-6">'+
    //         '<div id="prev_'+imagen+'" class="img-responsive img-thumbnail"></div>'+
    //         '<a href="#" class="btn btn-danger btn-sm btn-delete-image" data-image="'+imagen+'" style="position: absolute; right:15px;top:0px;"><i class="fa fa-times"></i></a>'+
    //     '</div>');
    //     var reader = new FileReader();
    //     reader.onload = function (e) {
    //         $('#prev_'+imagen).attr('style', 'background:url('+e.target.result+');background-size:contain;background-position: center;background-repeat: no-repeat;height: 180px;width: 100%;');
    //     };
    //     reader.readAsDataURL(input.files[0]);
    //   }
    // }

    // function readURLImages(input, imagen) {
    //   if (input.files && input.files[0]) {
    //     var reader = new FileReader();
    //     reader.onload = function (e) {
    //         $('#prev_'+imagen).attr('style', 'background:url('+e.target.result+');background-size:contain;background-position: center;background-repeat: no-repeat;height: 160px;width: 170px;');
    //     };
    //     reader.readAsDataURL(input.files[0]);
    //   }
    // }

    // $(document).on("click",".btn-delete-image",function(event){
    //     event.preventDefault();
    //     var imagen = $(this).attr("data-image");
    //     $(this).closest("div.galeria_thumb").remove();
    //     $("#"+imagen).remove();
    // });


    $('input[name="oferta"]').on('ifChecked', function(event){
        if (event.target.value == 1) {
            $('input#precio_oferta').attr('disabled', false);
        }

        else {
            $('input#precio_oferta').attr('disabled', true);
        }
    });

    $('.agregar').click(function(){
        if ($('#medida_id').val() != '' && $('#medida_id').val() != null && $('#precio').val() != '' && $('#precio_petShop').val() != '' && $('#precio_moayorista').val() != ''){
            $('#error_medida').html('');
            var medida_id = $('#medida_id').val();
            var precio = $('#precio').val();
            var precio_petShop = $('#precio_petShop').val();
            var precio_moayorista = $('#precio_moayorista').val();
            var sel = document.getElementById('medida_id');
            var selected = sel.options[sel.selectedIndex];
            var medida = selected.getAttribute('data-medida');
            var cantidad = parseInt($('#cantidad').val()) + 1;
            $('#cantidad').val(cantidad);
            $('#medida_id').val('');
            var selectobject=document.getElementById("medida_id");
            for (var i=0; i<selectobject.length; i++){
                if (selectobject.options[i].value == medida_id)
                    {
                        var index = i;
                        selectobject.remove(i);
                    }
            }
            $('#tbody_id').append('<div id="tabla_medida_'+cantidad+'" class="row tabla-body-impar"> <div class="col-xs-3"> '+medida+' </div> <div class="col-xs-3"> '+precio+' </div> <div class="col-xs-3"> '+precio_petShop+' </div> <div class="col-xs-2"> '+precio_moayorista+' </div> <div class="col-xs-1 text-right"> <a onclick="eliminarOpcion('+cantidad+')" href="JavaScript:void(0);" class="btn btn-danger"><i class="fa fa-trash-o"></i></a> </div> </div>');
            $('#tbody_id').append('<input type="hidden" name="medida_'+cantidad+'" id="medida_'+cantidad+'" value="'+medida_id+'">');
            $('#tbody_id').append('<input type="hidden" name="medida_text'+cantidad+'" id="medida_text'+cantidad+'" value="'+medida+'">');
            $('#tbody_id').append('<input type="hidden" name="precio_'+cantidad+'" id="precio_'+cantidad+'" value="'+precio+'">');
            $('#tbody_id').append('<input type="hidden" name="precio_petShop_'+cantidad+'" id="precio_petShop_'+cantidad+'" value="'+precio_petShop+'">');
            $('#tbody_id').append('<input type="hidden" name="precio_moayorista_'+cantidad+'" id="precio_moayorista_'+cantidad+'" value="'+precio_moayorista+'">');
            $('#precio').val(' ');
            $('#precio_petShop').val(' ');
            $('#precio_moayorista').val(' ');
            $('#medida_id').focus();
        }else{
            $('#error_medida').html('<div class="alert alert-danger"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> </strong>Error.</strong> Debe completar todos los campos de precios.</div>');
            $('#medida_id').focus();
        }
    });


    function eliminarOpcion(id){
        var x = document.getElementById("medida_id");
        var orden = $('#medida_'+ id).val();
        var option = document.createElement("option");
            option.text = $('#medida_text'+ id).val();
            option.selected = "selected";
            option.value = $('#medida_'+ id).val();
            option.setAttribute('data-medida', $('#medida_text'+ id).val());
            var selectobject=document.getElementById("medida_id");
            for (var i=0; i<selectobject.length; i++){
                if (selectobject.options[i].value > orden)
                {
                    orden = i;
                    break;
                }
            }
            x.add(option, orden);

        $('#tabla_medida_'+ id).remove();
        $('#medida_'+ id).remove();
        $('#medida_text'+ id).remove();
        $('#precio_'+ id).remove();
        $('#precio_petShop_'+ id).remove();
        $('#precio_moayorista_'+ id).remove();
        $('#medida_' + id).val('');
    }

    // $(document).ready(function() {
    //     $('#categoria_id').change(function(event) {
    //         getSubcategorias();
    //     });
    // });

    $(document).ready(function() {

        var id_product = $("input[name=id]").val();

        $("#productosRelacionados").select2({
            placeholder: "Ingresa código o nombre del producto",
            allowClear: true,
            limit: 3,
            language: {
                noResults: function () {
                   return "No se encontraron resultados";
                }
            },
            minimumInputLength: 2,
            maximumSelectionLength: 3,
            tags: false,
            ajax: {
                url: base_url + 'ecommerce/productos/jsonProductosRelacion/' + id_product,
                dataType: 'json',
                type: "POST",
                quietMillis: 100,
                data: function (term) {
                    return {
                        term: term
                    };
                }
            }
        });

    });

    $(document).on("click","#image_upload",function(event)
    {
        event.preventDefault();
        var uniq = 'img_' + (new Date()).getTime();
        $("#image_input").append('<input type="file" id="'+uniq+'" name="op[]" onchange="readURL(this,\''+uniq+'\')" accept="image/x-png,image/gif,image/jpeg" class="d-none">');
        document.getElementById(uniq).click();
    });
    function readURL(input, imagen) {
      if (input.files && input.files[0]) {
        $("#image_gallery").append('<div class="galeria_thumb col-sm-3 col-md-2 col-xs-6">'+
            '<div id="prev_'+imagen+'" class="img-responsive img-thumbnail"></div>'+
            '<a href="#" class="btn btn-danger btn-sm btn-delete-image" data-image="'+imagen+'" style="position: absolute; right: 15px;top:0;"><i class="fa fa-times"></i></a>'+
        '</div>');
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#prev_'+imagen).attr('style', 'background:url('+e.target.result+');background-size:contain;background-position: center;background-repeat: no-repeat;height: 180px;width: 100%;');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    function readURLImages(input, imagen) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#prev_'+imagen).attr('style', 'background:url('+e.target.result+');background-size:contain;background-position: center;background-repeat: no-repeat;height: 160px;width: 170px;');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    $(document).on("click",".btn-delete-image",function(event){
        event.preventDefault();
        var imagen = $(this).attr("data-image");
        var id_image = $(this).attr("data-id");
        $(this).closest("div.galeria_thumb").remove();
        $("#"+imagen).remove();
        $.ajax({
            type: "POST",
            url: base_url + 'ecommerce/productos/deleteGalleryImg/',
            data: {img:id_image},
            dataType: "json",
            success: function (response) {
                console.log("success");
            }
        });
    });
</SCRIPT>
