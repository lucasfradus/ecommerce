<div class="col-lg-12">
    <div class="element-box">
        <div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Importar Excel</strong> Debe primero hacer una hoja de cálculo con los productos que desea <b>Importar</b> por este formulario con la extención <b>xls</b><br>
            <ul>
                <li>CÓDIGO</li>
                <li>NOMBRE (<i class="fa fa-info-circle"></i> Atención :  Si es un nuevo registro se agregará al listado de productos, caso contrario se actualizará)</li>
                <li>DESCRIPCIÓN</li>
                <li>CATEGORÍA</li>
                <li>SUBCATEGORÍA</li>
                <li>UNIDADES POR BULTO</li>
                <li>STOCK</li>
                <li>PRECIO INDIVIDUAL</li>
                <li>PRECIO BULTO</li>
                <li>DESTACADO (1: SI, 0: NO)</li>
                <li>OFERTA (1: SI, 0: NO) | Oferta es 1 : SI, Ingresar la Oferta Individual y la Oferta Bulto</li>
                <li>PRECIO OFERTA INDIVIDUAL</li>
                <li>PRECIO OFERTA BULTO</li>
                <li>ALTO</li>
                <li>ANCHO</li>
                <li>PROFUNDIDAD</li>
                <li>PESO</li>
                <li>IMAGEN (<i class="fa fa-info-circle"></i> Atención :  Las imagenes deben ser cargadas por FTP al directorio: <?php echo base_url('uploads/img_productos/') ?>)</li>
                <li>IVA (1 = 10.5%) ó (2 = 21.00%)</li>
                <li>LISTA DE PRECIO 1 (Precio Usuario Mayorista N° 1)</li>
                <li>LISTA DE PRECIO 2 (Precio Usuario Mayorista N° 2)</li>
                <li>LISTA DE PRECIO 3 (Precio Usuario Mayorista N° 3)</li>
                <li>LISTA DE PRECIO 4 (Precio Usuario Mayorista N° 4)</li>
                <li>LISTA DE PRECIO 5 (Precio Usuario Mayorista N° 5)</li>
            </ul>
        </div>
        <form method="post" action="<?php echo current_url() ?>" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="enviar_form" value="1">
                <div class="offset-md-7 col-md-5">
                    <div class="text-right">
                        <button class="btn btn-success" type="submit">Guardar</button>        
                        <a href="javascript:window.history.back();" class="btn btn-danger"> Volver</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Archivo de importación*</label>
                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" name="file" required=""/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>