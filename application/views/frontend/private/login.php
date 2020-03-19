<section class="header-category">
    <div class="background-img-products position-relative">
        <h1  class="d-none d-md-block">LOGIN</h1>
        <h4  class="d-block d-md-none">LOGIN</h4>
    </div>
</section>
<section class="cart">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url('index')); ?>">Home</a> - 
                    <a href="<?php echo(base_url('login')); ?>">Login</a>
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
                        LOGIN
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
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="text" placeholder="Email" name="username" class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <label>Contraseña <span class="text-danger">*</span></label>
                                <input type="password" placeholder="Contraseña" name="password" class="form-control" required=""/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">INGRESAR</button>
                            </div>
                            <div class="form-group" align="center">
                                <a href="<?php echo base_url('recuperar-password') ?>">¿Olvido su contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
                <p>&nbsp;</p>
            </div>
        </div>
    </div>
</div>