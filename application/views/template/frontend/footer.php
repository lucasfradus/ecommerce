<div id="modalShoppingFast" class="modal fade" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
        <form data-action="add-product-fast" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">AGREGAR PRODUCTO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" name="enviar_form" value="1">
                <input type="hidden" id="inputProductCart" name="id_product" value="">
                <input id="unitPack" name="unit_bulto" type="hidden" value="">
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="messageValidationStock"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cantidad:</label>
                            <input type="number" class="form-control" id="qty" name="qty" value="1" min="1" required="">
                        </div>
                    </div>
                </div>
                <?php if($this->session->userdata('customer_id')){ ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Bulto/Pack:</label>
                            <input type="radio" name="optionShopping" value="2" required="" checked>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>individual:</label>
                                <input type="radio" name="optionShopping" value="1" checked>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Bulto/Pack:</label>
                                <input type="radio" name="optionShopping" value="2" required="">
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-buy"><i class="fas fa-cart-plus"></i> AÑADIR AL CARRITO</button>
            </div>
        </form>
    </div>
  </div>
</div>
<div id="modalLogin" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="#" onsubmit="submitLogin(event, this);">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="enviar_form" value="1"/>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="text" placeholder="Email" name="usuario" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" placeholder="Contraseña" name="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <div class="section-message"></div>
                    </div>
                    <div class="form-group" align="center">
                        <a href="<?php echo base_url('recuperar-password') ?>">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<section class="footer py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 d-lg-inline d-none d-md-none d-sm-none">
                <div class="col-lg-3 offset-lg-1 d-none d-sm-none d-md-none d-lg-inline">
                    <h6 class="text-footer">Atencion al cliente</h6>
                </div>    
                <div class="col-10 d-lg-none d-md-inline d-inline d-sm-inline offset-1 offset-md-0">
                    <div class="mb-4 text-center">
                    <a  href="<?php echo(base_url('index')); ?>">
                        <img class="img-fluid" src="<?php echo(base_url('assets/public/logo_limpieza_web.png'))?>" alt="+ Limpieza">
                    </a></div>
                    <div class="footer-social-medias text-center">
                        <div class="col-md-9 d-inline d-sm-inline d-lg-none d-md-inline">
                            <span><?php if(isset($configuracion['facebook'])){echo('<a href="#"><i class="fab fa-facebook-f"></i></a>');} ?></span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span><?php if(isset($configuracion['instagram'])){echo('<a href="#"><i class="fab fa-instagram"></i></a>');} ?></span>
                        </div>
                    </div>
                    <br>
                   
                </div>    
                <ul class="list-inline">
                    <?php if(!empty($configuracion['telefono']) || !empty($configuracion['celular'])): ?>
                        <li>
                            <div class="mb-3 text-footer"><i class="fas fa-phone-alt icon-footer-size"></i>&nbsp; <?php if(!empty($configuracion['telefono'])){?><?php echo $configuracion['telefono']; ?><?php } ?>
                            <?php if(!empty($configuracion['telefono']) && !empty($configuracion['celular'])): ?><span>&nbsp;|&nbsp;</span><?php endif ?>
                            <?php if(!empty($configuracion['celular'])){ ?> <?php echo $configuracion['celular']; ?> <?php } ?></div>
                        </li>
                    <?php endif ?>
                    <?php if(!empty($configuracion['whatsapp'])): ?>
                    <li>
                        <div class="text-footer"><i class="fab fa-whatsapp icon-footer-size"></i>&nbsp; <?php echo $configuracion['whatsapp']; ?></div>
                    </li>
                    <?php endif ?>
                </ul>
                <div class="col-10 d-lg-none d-md-inline d-sm-inline d-inline offset-1 offset-md-0">
             
                </div>
                <ul class="list-inline d-inline d-sm-inline d-lg-none d-md-inline">
                        <?php if(!empty($configuracion['horario'])): ?>
                        <li>
                            <div class="mb-3 text-footer"><i class="far fa-clock icon-footer-size"></i>&nbsp; <?php echo $configuracion['horario']; ?></div>
                        </li>
                        <?php endif ?>
                        <?php if(!empty($configuracion['direccion'])): ?>
                        <li>
                            <div class="text-footer"><i class="fas fa-map-marker-alt icon-footer-size"></i>&nbsp; <?php echo $configuracion['direccion']; ?></div>
                        </li>
                        <?php endif ?>
                    </ul>
            </div>
            <div class="col-md-12 d-lg-none d-md-inline d-sm-inline d-inline">
                <div class="col-lg-3 offset-lg-1 d-none d-sm-none d-md-none d-lg-inline">
                    <h6 class="text-footer">Atencion al cliente</h6>
                </div>    
                <div class="col-10 d-lg-none d-md-inline d-inline d-sm-inline offset-1 offset-md-0">
                    <div class="mb-4 text-center">
                    <a  href="<?php echo(base_url('index')); ?>">
                        <img class="img-fluid" src="<?php echo(base_url('assets/public/logo_limpieza_web.png'))?>" alt="+ Limpieza">
                    </a></div>
                    <div class="footer-social-medias text-center">
                        <div class="col-md-9 d-inline d-sm-inline d-lg-none d-md-inline">
                            <span><?php if(isset($configuracion['facebook'])){echo('<a href="#"><i class="fab fa-facebook-f"></i></a>');} ?></span>
                            <span>&nbsp;&nbsp;&nbsp;</span>
                            <span><?php if(isset($configuracion['instagram'])){echo('<a href="#"><i class="fab fa-instagram"></i></a>');} ?></span>
                        </div>
                    </div>
                    <br>
                  
                </div>    
                <ul class="list-inline">
                <?php if(!empty($configuracion['telefono']) || !empty($configuracion['celular'])): ?>
                    <li>
                        <div class="mb-3 text-footer"><i class="fas fa-phone-alt icon-footer-size"></i>&nbsp; <?php if(!empty($configuracion['telefono'])){?><?php echo $configuracion['telefono']; ?><?php } ?><?php if(!empty($configuracion['telefono']) && !empty($configuracion['celular'])): ?><span>&nbsp;|&nbsp;</span><?php endif ?>
                        <?php if(!empty($configuracion['celular'])){ ?> <?php echo $configuracion['celular']; ?> <?php } ?></div>
                    </li>
                <?php endif ?>
                    <?php if(!empty($configuracion['whatsapp'])): ?>
                    <li>
                        <div class="text-footer"><i class="fab fa-whatsapp icon-footer-size"></i>&nbsp; <?php echo $configuracion['whatsapp']; ?></div>
                    </li>
                    <?php endif ?>
                </ul>
                <div class="col-10 d-lg-none d-md-inline d-sm-inline d-inline offset-1 offset-md-0">
                    <h6 class="">Horarios</h6>
                </div>
                <ul class="list-inline d-inline d-sm-inline d-lg-none d-md-inline">
                    <?php if(!empty($configuracion['horario'])): ?>
                    <li>
                        <div class="mb-3 text-footer"><i class="far fa-clock icon-footer-size"></i>&nbsp; <?php echo $configuracion['horario']; ?></div>
                    </li>
                    <?php endif ?>
                    <?php if(!empty($configuracion['direccion'])): ?>
                    <li>
                        <div class="text-footer"><i class="fas fa-map-marker-alt icon-footer-size"></i>&nbsp; <?php echo $configuracion['direccion']; ?></div>
                    </li>
                    <?php endif ?>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="mb-4">
                    <a class="d-none d-sm-none d-md-none d-lg-inline" href="<?php echo(base_url('index')); ?>" >
                        <img class="img-fluid" src="<?php echo(base_url('assets/public/logo_limpieza_web.png'))?>" alt="HEFER">
                    </a>
                </div>
        
            </div>
            <div class="col-lg-4">
                <div class="col-lg-3 offset-lg-1 col-md-4 d-none d-sm-none d-md-none d-lg-inline">
                    <h6 class="text-footer">Horarios</h6>
                </div>
                <ul class="list-inline d-none d-sm-none d-lg-inline d-md-none">
                    <?php if(!empty($configuracion['horario'])): ?>
                    <li>
                        <div class="mb-3 text-footer"><i class="far fa-clock icon-footer-size"></i>&nbsp; <?php echo $configuracion['horario']; ?></div>
                    </li>
                    <?php endif ?>
                    <?php if(!empty($configuracion['direccion'])): ?>
                    <li>
                        <div class="text-footer"><i class="fas fa-map-marker-alt icon-footer-size"></i>&nbsp; <?php echo $configuracion['direccion']; ?></div>
                    </li>
                    <?php endif ?>
                </ul>
            </div>       
        </div>
    </div>
</section>
<footer class="footer footer-bot">
    <div class="container">
        <div class="row align-items-center hl">
            <div class="col-md-12 mt-4">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-unstyled text-menu-footer">
                            <li class="text-footer ">&copy; HEFER - Todos los derechos reservados | <a href="https://elfiko.com/" class="text-menu-footer">Elfiko</a>
                            </li>
                        </ul>   
                    </div>
                    <div class="col-md-6 d-block d-sm-block d-md-block d-lg-block d-xl-block">
                        <ul class="list-unstyled text-menu-footer footer-nav row">
                            <li><a href="<?php echo base_url('index') ?>">HOME</a></li><span>&nbsp;|&nbsp;</span>
                            <li><a href="<?php echo base_url('productos') ?>">PRODUCTOS</a></li><span>&nbsp;|&nbsp;</span>
                            <li><a href="<?php echo base_url('como_comprar') ?>">COMO COMPRAR</a></li><span>&nbsp;|&nbsp;</span>
                            <li><a href="<?php echo base_url('empresa') ?>">QUIENES SOMOS</a></li><span>&nbsp;|&nbsp;</span>
                            <li><a href="<?php echo base_url('contacto') ?>">CONTACTO</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php $this->view('frontend/public/modal_shopping_success') ?>
