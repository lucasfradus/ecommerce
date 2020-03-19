<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<br>
<section class="work_titulo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="borde">
                    <div class="row">
                        <div class="col-md-12 seccion-producto_posicion_volver">
                            <ul class="seccion-productos-nav list-inline">
                                <li><a href="<?php echo base_url() ?>">Home</a></li>
                                <li> - </li>
                                <li><a href="#">Carrito de compras</a></li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <img src="<?php echo base_url('assets/public/repositorio_imagenes/linea-zapatillas.png') ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="work_container">
    <div class="container animated fadeIn">
        <div class="row">
            <?php if ($this->session->flashdata('carritoOk')): ?>
                <div class="col-lg-10 col-lg-offset-1">
                    <br>
                    <div class="alert alert-info animated fadeInDown">
                        <?php echo $this->session->flashdata('carritoOk') ?>
                    </div>
                </div>
            <?php endif ?>
            <div class="col-md-12">
                <div class="alert alert-warning">
                    GRACIAS POR SU COMPRA
                </div>
            </div>
        </div>
    </div>
</div>