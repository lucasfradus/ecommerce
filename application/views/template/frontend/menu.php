<section class="section-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 d-none d-sm-none d-md-block d-lg-block">
                <div class="row">
                    <div class="col-md-6 d-none d-sm-none d-md-none d-lg-block">
                    <span class="text-top-section"><?php if(isset($configuracion['direccion'])){echo('<i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;'.$configuracion['direccion']);} ?></span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                    </div>
                    <div class="col-md-4  text-center">
                    <span class="text-top-section"><?php if(isset($configuracion['telefono'])){echo('<i class="fas fa-phone-alt"></i>&nbsp;&nbsp;'.$configuracion['telefono']);} ?></span>
                    <span class="text-top-section"><?php if(isset($configuracion['celular'])){echo('/&nbsp;&nbsp;WHATSAPP '.$configuracion['celular']);} ?></span>
                        <span></span>
                    </div>  
                    <div class="col-md-2 d-none d-sm-none d-md-none d-lg-block">
                    <span class="text-top-section"><?php if(isset($configuracion['facebook'])){echo('<a href="'.$configuracion['facebook'].'" target=_blank><i class="text-top-section fab fa-facebook-f"></i></a>');} ?></span>
                        <span>&nbsp;&nbsp;&nbsp;</span>
                        <span class="text-top-section"><?php if(isset($configuracion['instagram'])){echo('<a href="'.$configuracion['instagram'].'" target=_blank><i class="text-top-section fab fa-instagram"></i></a>');} ?></span>
                    </div>
                </div>
            </div
            ><!--
            <div class="col-md-4 col-sm-12">
                <div class="d-none d-sm-none d-md-block d-lg-block">
                    <div class="float-right">
                        <?php if($this->session->userdata('customer_id')){ ?>
                            <span>
                                <a href="<?php echo(base_url('dashboard')); ?>"><i class="far fa-user"></i> <?php echo($this->session->userdata('customer_name')); ?></a>
                            </span>
                            <span>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                            </span>
                            <span>
                                <a data-action="logout" href="<?php echo base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
                            </span>
                        <?php }else{ ?>
                            <span>
                                <a href="#" data-target="#modalLogin" data-toggle="modal"><i class="far fa-user"></i> LOGIN</a>
                            </span>
                            <span>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                            </span>
                            <span>
                                <a href="<?php echo(base_url('registro')); ?>">REGISTRATE</a>
                            </span>
                        <?php } ?>
                    </div>
                </div>
               
            </div>
        -->
        </div>
    </div>
</section>
<section class="section-top-menu">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-6 col-lg-4 col-sm-6" align="right">
                <a class="navbar-brand fadeIn animated logo d-md-none d-sm-none d-none d-lg-block d-xl-block" href="<?php echo(base_url('index')) ?>"><img src="<?php echo(base_url('assets/public/logo_limpieza_web.png')) ?>" class="img-fluid" width="250px"></a>
                <a class="navbar-brand fadeIn animated logo d-sm-none d-none d-md-block d-lg-none" href="<?php echo(base_url('index')) ?>"><img src="<?php echo(base_url('assets/public/logo_limpieza_web.png')) ?>" class="img-fluid" width="250px"></a>
                <a class="navbar-brand fadeIn animated logo d-none d-sm-block d-md-none d-lg-none" href="<?php echo(base_url('index')) ?>"><img src="<?php echo(base_url('assets/public/logo_limpieza_web.png')) ?>" class="img-fluid" width="250px"></a>
                <a class="navbar-brand fadeIn animated logo d-block d-sm-none d-lg-none d-md-none" href="<?php echo(base_url('index')) ?>" align="right"><img src="<?php echo(base_url('assets/public/logo_limpieza_web.png')) ?>" class="img-fluid" width="250px"></a>
            </div>
            <div class="col-6 d-inline d-sm-inline d-lg-none d-md-inline " align="right">
                <div class="cart-menu align-items-center col-lg-2 d-flex">
                    <div class="d-inline d-sm-inline d-lg-none d-md-inline">
                        <a href="<?php echo(base_url('carrito'))?>"><i class="fas fa-shopping-cart"></i></a>
                    </div>
                    <div class="d-inline d-sm-inline d-lg-none d-md-inline">
                        <span id="cart_menu_num" data-action="cart-can" class="badge rounded-circle"><?php echo(count($this->cart->contents())); ?></span>
                    </div> 
                </div>
            </div>
            <div class="col-lg-5 d-none d-sm-none d-md-none d-lg-block d-xl-block row no-gutters mt-3 align-items-center" align="center">
                <form method="GET" class="" action="<?php echo(base_url('productos'))?>">
                    <div class="input-group">
                        <input class="form-control rounded-pill py-2 pr-5 mr-1 bg-transparent shadow" required type="text" value="<?php echo($this->input->get('search')); ?>" placeholder="Buscar ...">
            
                            <span class="input-group-append">
                                <div class="input-group-text border-0 bg-transparent ml-n5"><i class="fa fa-search icon-background"></i></div>
                            </span>
                    </div>
                </form>
            </div>
            
            <div class="cart-menu align-items-center d-flex">
             <div class="sidebar-social">
                <ul>  
                    <li>
                        <a href="URL-HERE" class="cart" title="Carrito" target="_blank" rel="nofollow"><i class="fas fa-shopping-cart"></i><span>Carrito</span>
                            <span id="cart_menu_num" data-action="cart-can" class="badge rounded-circle text-size"><?php echo(count($this->cart->contents())); ?></span>
                        </a>
                    </li>          
                    <li>
                        <a href="URL-HERE" title="Login" target="_blank" rel="nofollow"><i class="fas fa-arrow-circle-right"></i></i><span>Login</span></a>
                    </li>
                            
                    <li>
                        <a href="URL-HERE" title="Registrate" target="_blank" rel="nofollow"><i class="fas fa-user"></i><span>Registrate</span></a>
                    </li>
                    
                </ul>
            </div>
              
                <!--
                <div class="d-none d-sm-none d-md-block d-lg-block">
                    <div class="float-right">
                        <?php if($this->session->userdata('customer_id')){ ?>
                            <div class="d-none d-sm-none d-lg-inline d-md-none">
                                <a href="<?php echo(base_url('dashboard')); ?>"><i class="far fa-user"></i> <?php echo($this->session->userdata('customer_name')); ?></a>
                            </div>
                           
                            <div class="d-none d-sm-none d-lg-inline d-md-none">
                                <a data-action="logout" href="<?php echo base_url('logout') ?>"><i class="fas fa-sign-out-alt"></i>Cerrar Sesión</a>
                            </div>
                        <?php }else{ ?>
                            <div class="d-none d-sm-none d-lg-inline d-md-none">
                                <a href="#" data-target="#modalLogin" data-toggle="modal"><i class="fas fa-user"></i> LOGIN</a>
                                </div>
                         
                            <div class="d-none d-sm-none d-lg-inline d-md-none">
                                <a href="<?php echo(base_url('registro')); ?>"><i class="fas fa-arrow-circle-right"></i> REGISTRATE</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                        -->
            </div>
            
        </div>
    </div>
</section>
<nav id="menu" class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <div align="right" class="col-12 d-lg-none d-md-block d-sm-block d-block">
            <button class="navbar-toggler navbar-xs" type="button" data-toggle="collapse" data-target="#menu_options" aria-controls="menu_options" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse col-lg-11" id="menu_options">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if($this->uri->segment(1)=='index'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('index')); ?>">HOME</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='productos'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('productos')); ?>">PRODUCTOS</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='ofertas'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('ofertas')); ?>">OFERTAS</a>
                    
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='como_comprar'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('como_comprar')); ?>">COMO COMPRAR</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='empresa'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('empresa')); ?>">LA EMPRESA</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='contacto'){echo('active');} ?>">
                    <a class="menu-letra  b-b-white nav-link pb-1" href="<?php echo(base_url('contacto')); ?>">CONTACTO</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav id="menub" class="navbar navbar-expand-lg fixed-top navbar-dark" style="display: none;">
    <div class="container">
        <div align="right" class="col-12 d-lg-none d-md-block d-sm-block d-block">
            <button class="navbar-toggler navbar-xs" type="button" data-toggle="collapse" data-target="#menu_options" aria-controls="menu_options" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse col-lg-11" id="menu_options">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item  <?php if($this->uri->segment(1)=='index'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('index')); ?>">HOME</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='productos'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('productos')); ?>">PRODUCTOS</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='ofertas'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('ofertas')); ?>">OFERTAS</a>
                    
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='como_comprar'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('como_comprar')); ?>">COMO COMPRAR</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='empresa'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('empresa')); ?>">LA EMPRESA</a>
                </li>
                <li class="nav-item <?php if($this->uri->segment(1)=='contacto'){echo('active');} ?>">
                    <a class="menu-letra b-b-white nav-link pb-1" href="<?php echo(base_url('contacto')); ?>">CONTACTO</a>
                </li>
            </ul>
        </div>
    </div>
</nav>