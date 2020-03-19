<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block">CONTACTO</h1>
    <h4 class="d-block d-md-none">CONTACTO</h4>
</div>
<section class="contact">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url()); ?>">Home</a> - 
                    <a href="<?php echo(base_url('contact')); ?>">Contacto</a>
                </div>
            </div>
        </div>
        <div class="row contact-content">
            <div class="col-md-5">
                <div class="contact-info">
                    <h4>Correo de contacto</h4>
                    <ul class="list-unstyled">
                        <?php if (!empty($configurations[2]->value)) : ?>
                            <li><span><i class="far fa-envelope"></i></span> &nbsp; <?php echo $configurations[2]->value; ?></li>
                        <?php endif ?>
                    </ul>
                    <h4>Síguenos</h4>
                    <ul class="list-inline">
                        <?php if (!empty($configurations[9]->value)) : ?>
                            <a href="<?php echo $configurations[9]->value; ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                        <?php endif ?>
                        <?php if (!empty($configurations[10]->value)) : ?>
                            <a href="<?php echo $configurations[10]->value; ?>" target="_blank"><i class="fab fa-twitter icon-contact"></i></a>
                        <?php endif ?>
                        <?php if (!empty($configurations[20]->value)) : ?>
                            <a href="<?php echo $configurations[20]->value; ?>" target="_blank"><i class="fab fa-instagram icon-contact"></i></a>
                        <?php endif ?>
                        <?php if (!empty($configurations[25]->value)) : ?>
                            <a href="<?php echo $configurations[25]->value; ?>" target="_blank"><i class="fab fa-youtube icon-contact"></i></a>
                        <?php endif ?>
                    </ul>
                    <h4>Ubícanos</h4>
                    <ul class="list-unstyled">
                        <?php if (!empty($configurations[6]->value)) : ?>
                            <li><span><i class="fas fa-map-marker-alt"></i></span>&nbsp; <?php echo $configurations[6]->value; ?></li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-7">
                <?php if ($this->session->flashdata('contact')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Éxito</strong> <?php echo($this->session->flashdata('contact')); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif ?>
                <form id="formContacto" action="<?php echo current_url() ?>" method="post" role="form" class="form-contact">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="last_name" placeholder="Apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="phone" placeholder="Telefono">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="message" placeholder="Mensaje" rows="5"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-send">Enviar</button>
                    </div>              
                </form>
            </div>     
        </div>
        <br>
    </div>
</section>
