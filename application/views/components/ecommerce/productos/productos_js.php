<script type="text/javascript">   
function cargaSubcategorias(event, elemento) {

    var categoriaId = $(elemento).val();

    if ($.isNumeric(categoriaId)) {

        $.ajax({
            url: base_url + 'ecommerce/productos/jsonSubcategorias/' + categoriaId,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {

            var htm = '<option value="">Selecciona</option>';

            $("select#segundasubcategoria_id").html(htm);
            $("select#segundasubcategoria_id").select2();

            $.each(data.subcategorias, function(index, val) {
                htm += '<option value="' + val.id_subcategory + '">' + val.name + '</option>';
            });

            $("select#subcategoria_id").html(htm);
            $("select#subcategoria_id").select2();


            console.log("success");

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });

    }
    else {

        var htm = '<option value="">Selecciona</option>';
        $("select#subcategoria_id").html(htm);
        $("select#segundasubcategoria_id").html(htm);
        $("select#subcategoria_id").select2();
        $("select#segundasubcategoria_id").select2();

    }

}

function cargaSegundasSubcategorias(event, elemento) {

    var subcategoriaId = $(elemento).val();

    if ($.isNumeric(subcategoriaId)) {

        $.ajax({
            url: base_url+'ecommerce/productos/jsonSegundasSubcategorias/'+subcategoriaId,
            type: 'GET',
            dataType: 'json',
        })
        .done(function(data) {
            var htm = '<option value="">Selecciona</option>';
            $.each(data.subcategorias, function(index, val) {
                htm += '<option value="' + val.id_second_subcategory + '">'+val.name+'</option>';
            });
            console.log(data.subcategorias);
            $("select#segundasubcategoria_id").html(htm);
            $("select#segundasubcategoria_id").select2();
            console.log("success");
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        

    }

}
</script>