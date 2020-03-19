<div class="col-lg-12">
    <div class="element-box">
    	<?php     
    		echo form_open_multipart(current_url(), array('class'=>""));
    		echo form_hidden('enviar_form','1');
        ?>
            <div class="text-right">
                <?php echo form_button(array('type'  =>'submit','value' =>'Guardar','name'  =>'submit','class' =>'btn btn-success'), " Guardar"); ?> 
		        <a class="btn btn-danger" href="<?php echo base_url().$this->uri->segment(1).'/'.$this->uri->segment(2); ?>"> Volver</a>
            </div>
            <div id="errorForm"></div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="code">Código <span class="required">*</span></label>
                        <input required id="code" name="code" type="text" class="form-control" placeholder="Código" />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="name">Nombre de producto<span class="required">*</span></label>
                        <input required id="name" name="name" type="text" class="form-control" placeholder="Nombre" />
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-md-12">
                    <div class="form-group">
                        <label for="description">Descripcion<span class="required">*</span></label>
                        <textarea id="description" rows="4" name="description" class="form-control summernote" placeholder="Descripción"></textarea>
                    </div>
                </div>
            </div>    
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="categoria_id">Categoría<span class="required">*</span></label>
                        <select id="categoria_id" onchange="cargaSubcategorias(event, this)" name="categoria_id" class="form-control chosen-select">
                            <option value="">Selecciona</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?php echo $categoria->id_category ?>"><?php echo $categoria->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="subcategoria_id">Subcategoría<span class="required">*</span></label>
                        <select id="subcategoria_id" onchange="cargaSegundasSubcategorias(event, this)" name="subcategoria_id" class="form-control chosen-select" required>
                            <option value="">Selecciona</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                        <div class="form-group">
                            <label for="producto_id">Productos Relacionados</label>
                            <select id="related_products"  name="related_products[]" class="form-control" multiple="">
                                <!-- <option value="">Selecciona</option>
                                <?php /*foreach($productos as $r): ?>
                                <option value="<?php echo $r->id_product ?>"><?php echo $r->name ?></option>
                                <?php endforeach*/ ?> -->
                            </select>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">    
                        <label for="unitXbulto">Unidades por Bulto<span class="required">*</span></label>
                        <input name="unitXbulto" class="form-control" type="number" placeholder="Unidades por Bulto" value="1" min="1">
                    </div>
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_bulto">Stock<span class="required">*</span></label>
                        <input required id="stock" name="stock" type="number" class="form-control" placeholder="Stock" value="" min="0" />
                    </div>
                </div> 
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Precio minorista Individual<span class="required">*</span></label>
                        <input  id="indi_price" name="indi_price" type="text" class="form-control" placeholder="Precio minorista Individual"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label  for="precio_bulto">Precio minorista por Bulto <span class="required">*</span></label>
                        <input  id="bulto_price" name="bulto_price" type="text" class="form-control" placeholder="Precio minorista por bulto" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="iva">IVA <span class="required">*</span></label>
                        <select id="iva" name="iva" required="" class="form-control select2">
                            <option value="">Seleccionar</option>
                            <?php foreach ($ivas as $key => $value): ?>
                                <option value="<?php echo $value->id_iva ?>"><?php echo $value->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group i-checks">
                        <label for="active"> ¿Es destacado?</label><br>
                        <label class="radio">
                            <input type="radio" name="destacado" id="destacado" value="1"  /> Si
                        </label> &nbsp;
                        <label class="radio">
                            <input type="radio" name="destacado" id="destacado" value="0" checked/> No
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group i-checks">
                        <label for="active"> ¿Es oferta?</label><br>
                        <label class="radio">
                            <input type="radio" name="oferta" id="oferta" value="1" /> Si
                        </label> &nbsp;
                        <label class="radio">
                            <input type="radio" name="oferta" id="oferta" value="0" checked /> No
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group d-none">    
                        <label for="offer-price">Oferta Individual</label>
                        <input type="text" class="form-control" placeholder="Precio de Oferta Individual" name="offer-price" >
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group d-none">    
                        <label for="offer-price-bulto">Oferta Bulto</label>
                        <input type="text" class="form-control" placeholder="Precio de Oferta Bulto " name="offer-price-bulto" >
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Alto<span class="required">*</span></label>
                        <input required id="height" name="height" step=".01" type="number" class="form-control" placeholder="Centímetros"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Ancho<span class="required">*</span></label>
                        <input required id="width" name="width" step=".01" type="number" class="form-control" placeholder="Centímetros"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Profundidad<span class="required">*</span></label>
                        <input required id="depth" name="depth" step=".01" type="number" class="form-control" placeholder="Centímetros"/>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio_individual">Peso<span class="required">*</span></label>
                        <input required id="weight" name="weight" step=".01" type="number" class="form-control" placeholder="Centímetros"/>
                    </div>
                </div>
            </div>
            <h6>IMAGEN DEL PRODUCTO</h6>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="imagen">Imagen 1<span class="required">*</span></label>
                        <input  id="imagen1" accept="image/*" name="imagen1" type="file" class="form-control" />
                        <span class="help-block">Tamaño mínimo recomendado (600px , 600px)</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php foreach ($listprecio as $list): ?>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="listaprecios"><?php echo $list->name ?></label>
                        <input  id="<?php echo $list->id_list_price ?>"  name="list_price_id[]" type="text" class="form-control" value=""/>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
            <div class="row">
            <div class="col-md-4">
                    <div class="form-group">
                        <label for="id_differential_discount">Descuento Diferencial</label>
                        <select id="id_differential_discount"  name="id_differential_discount" class="form-control chosen-select">
                        <option value="">Seleccionar</option>
                        <?php foreach ($descuentos as $desc): ?>
                                <option value="<?php echo $desc->id_differentias_discounts ?>"><?php echo $desc->name_differentias_discounts ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                </div>    
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
            <div class="row mb-4" id="image_gallery"></div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php $this->view('components/ecommerce/productos/productos_js') ?>
<script type="text/javascript">
 $(document).ready(function() {
        $("#related_products").select2({
            placeholder: "Ingresa código o nombre del producto.",
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
                url: base_url + 'ecommerce/productos/jsonRelatedProducts',
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
$(document).ready(function() {
        $('#code').change(function() {
            var code = $('#code').val();
            if (code.length <= 3) {
                return false;
            } 
            $.ajax({
                type: "POST",
                url: base_url + 'ecommerce/productos/ValidarCode/',
                data: {code: code},
                cache: false,
                dataType: 'JSON',
                beforeSend: function(){
                    $('#errorForm').html('<div class="text-center"><i class="fa fa-circle-o-notch fa-spin"></i></div>');
                },
                success: function(response){
                    console.log(response.status)
                    if (!response.status) {
                        $('#code').val('');
                        $('#code').focus();
                    }

                    $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></button><strong>'+response.msg+'</strong>. '+response.msj+'.</div>');         
                },
                error: function(){
                    $('#errorForm').html('<div class="alert alert-danger text-center"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Ocurrio un error</strong>. Por favor intentelo nuevamente!.</div>');
                }
            });
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
        $(this).closest("div.galeria_thumb").remove();
        $("#"+imagen).remove();
    });
    
    /*$('.i-checks.i-oferta').on('ifChanged', function(event) {
        // alert('checked = ' + event.target.checked);
        // alert('value = ' + event.target.value);
        // alert($('.i-checks').iCheck("updated"));
        alert($(this).iCheck());
    });*/

    $('input[name="oferta"]').on('ifChecked', function(event){
        if (event.target.value == 1) {
            $('input#precio_oferta').attr('disabled', false);
        }

        else {
            $('input#precio_oferta').attr('disabled', true).val('');
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
        $('#medida_text'+ id).remove();
        $('#precio_'+ id).remove();
        $('#precio_petShop_'+ id).remove();
        $('#precio_moayorista_'+ id).remove();
        $('#medida_' + id).val('');
    }

    function getSubcategorias(){
        var id_category = $('#categoria_id').val();
        if ($.isNumeric(id_category)) {
            var url = base_url + 'ecommerce/subcategorias/json/' + id_category;
            $.getJSON(url, function(data) {
                $("#subcategoria_id").find("option").remove();
                var options = '<option value="">Selecciona</option>';

                if(data.data){
                    $.each(data.data, function(key, val) {
                        options = options + "<option value='"+val.id_subcategory+"'>"+ val.name +"</option>";
                    });              
                }
                else{
                    options = options + "<option value='0'>Sin resultados</option>";
                }
                $("#subcategoria_id").append(options);
                $("#subcategoria_id").trigger("liszt:updated");
            });
        }
        else{
        }
    }

    function getSegundaSubcategorias(){
        var id_subcategory = $('#subcategoria_id').val();
        if ($.isNumeric(id_subcategory)) { 
            var url = base_url + 'ecommerce/segundasubcategorias/json/' + id_subcategory;
            $.getJSON(url, function(data) {
                $("#segundasubcategoria_id").find("option").remove();
                var options = '<option value="">Selecciona</option>';
                if(data.data){
                    $.each(data.data, function(key, val) {
                        options = options + "<option value='"+val.id_second_subcategory+"'>"+ val.name +"</option>";
                    });              
                }
                else{
                    options = options + "<option value='0'>Sin resultados</option>";
                }
                $("#segundasubcategoria_id").append(options);
                $("#segundasubcategoria_id").trigger("liszt:updated");
            });
        }
    }

    function getCategorias(){
        var id_category = $('#categoria_id').val();
        if ($.isNumeric(id_category)) {
            var url = base_url + 'ecommerce/categorias/json/' + id_category;
            $.getJSON(url, function(data) { console.log(data)
                $("#categoria_id").find("option").remove();
                var options = '<option value="">Selecciona</option>';
                if(data.data){
                    $.each(data.data, function(key, val) {
                        options = options + "<option value='"+val.id_subcategory+"'>"+ val.name +"</option>";
                    });              
                }
                else{
                    options = options + "<option value='0'>Sin resultados</option>";
                }
                $("#categoria_id").append(options);
                $("#categoria_id").trigger("liszt:updated");

            });

        }
        else{

        }

    }

    $(document).ready(function() {
        //getSubcategorias();
        $('#categoria_id').change(function(event) {
            getSubcategorias();             
        });

        $('#subcategoria_id').change(function(event) {
            getSegundaSubcategorias();             
        });
        $('#cargarTabla').click(function(event) {
            getCategorias();           
        });

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
                url: base_url + 'ecommerce/productos/jsonProductosRelacion',
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

    function agregarRegistroTalle() {

        var htm_select = '<select id="id_size" name="size_id[]" class="form-control chosen-select" required>' +
            '<option value="">Selecciona</option>';
            <?php /*foreach ($deportes as $deporte): ?>
                htm_select+= '<option value="<?php echo $deporte->id_sport ?>"><?php echo $deporte->name ?></option>';
            <?php endforeach*/ ?>
        htm_select+= '</select>';

        var contenido = '';

        contenido = '<tr>'+
            '<td><input type="text" name="codigo_talle[]" class="form-control" required=""></td>'+
            '<td>'+htm_select+'</td>'+
            '<td align="right" width="10%">'+
                '<button class="btn btn-danger" onclick="eliminarRegistroTalle(this)" type="button"><i class="fa fa-trash"></i></button>'+
            '</td>'+
        '</tr>';

        $('#tableTallesProducto tbody').append(contenido);
        $('select[name="size_id[]"]').select2();
    }

    function eliminarRegistroTalle(elemento){
        $(elemento).closest('tr').remove();
    }

</script>



<style type="text/css">
.tabla-header{
    font-size: 15px;
    border: solid 1px rgba(128, 128, 128, 0.32);
    margin-left: 5px;
    margin-right: 5px;
    padding: 8px;
    font-weight: bold;
}


.tabla-header a, a:hover{
  color: #2a6496;
  text-decoration: none;
}

.tabla-body-par{
    /*font-size: 15px;*/
    border: solid 1px rgba(128, 128, 128, 0.32);
    border-top-color: white;
    margin-left: 5px;
    margin-right: 5px;
    padding: 8px;
    /*font-weight: bold;*/
}

.tabla-body-impar{
    /*font-size: 15px;*/
    border: solid 1px rgba(128, 128, 128, 0.32);
    border-top-color: white;
    margin-left: 5px;
    margin-right: 5px;
    padding: 8px;
    /*font-weight: bold;*/
    background: rgb(244, 246, 250);
}

.tabla-body-par:hover{
    /*font-size: 15px;*/
    border: solid 1px rgba(128, 128, 128, 0.32);
    border-top-color: white;
    margin-left: 5px;
    margin-right: 5px;
    padding: 8px;
    /*font-weight: bold;*/
    background: rgb(244, 246, 250);
}
.tabla-body-impar:hover{
    /*font-size: 15px;*/
    border: solid 1px rgba(128, 128, 128, 0.32);
    border-top-color: white;
    margin-left: 5px;
    margin-right: 5px;
    padding: 8px;
    /*font-weight: bold;*/
    background: white;
}

</style>