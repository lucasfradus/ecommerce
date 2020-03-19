<section class="img-product" style="background: url(<?php echo base_url().'assets/public/fondo_productos.png'; ?>);height:150px;">
    <div class="container h-100">
        <div class="row m-r align-items-center h-100">
            <div class="col-lg-4 offset-lg-7">
                <div class="font-46 text-img-products m-m" align="right">
                    <span>RECUPERAR CONTRASEÑA</span>&nbsp;<img width="50px" src="<?php echo base_url().'assets/public/productos-destacados.png'; ?>" alt="" class="">
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section-breadcrumb">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url('index')); ?>">Home</a> - 
                    <a href="<?php echo(base_url('carrito')); ?>">Recuperar contraseña</a>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="work_container">
    <p>&nbsp;</p>
    <div class="container animated fadeIn">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header" style="background: #017cff;color: #fff;">
                        RECUPERA TU CONTRASEÑA
                    </div>
                    <div class="card-body">
                        <?php if ($this->session->flashdata('success')): ?>
                            <div class="alert alert-info animated fadeInDown">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <?php echo $this->session->flashdata('success') ?>
                            </div>
                        <?php endif ?>
                        <?php if ($this->session->flashdata('error')): ?>
                            <div class="alert alert-warning animated fadeInDown">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <?php echo $this->session->flashdata('error') ?>
                            </div>
                        <?php endif ?>
                        <form method="post" action="<?php echo current_url() ?>">
                            <input type="hidden" name="enviar_form" value="1"/>
                            <div class="form-group">
                                <label>Ingrese su email <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Email" name="username" class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">RECUPERAR CONTRASEÑA</button>
                            </div>
                        </form>
                    </div>
                </div>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>