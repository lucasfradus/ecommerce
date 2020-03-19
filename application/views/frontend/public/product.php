<div class="background-img-products position-relative">
    <h1 class="d-none d-md-block"><?php if($result->category==''){ ?>PRODUCTOS<?php }else{ echo($result->category); } ?></h1>
    <h4 class="d-block d-md-none"><?php if($result->category==''){ ?>PRODUCTOS<?php }else{ echo($result->category); } ?></h4>
</div>
<section class="product">
    <div class="img-bot d-none d-sm-none d-lg-block d-md-none"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12 col-12 text-right">
                <div class="my-breadcrumb">
                    <a href="<?php echo(base_url()); ?>">Home</a> - 
                    <a href="<?php echo(base_url('productos')); ?>">Productos</a>
                    <?php if($result->category!=''): ?> - <a href="<?php echo(base_url('productos').'/'.$result->category_id.'/1'); ?>"><?php echo($result->category); ?></a><?php endif ?>
                </div>
            </div>
        </div>
        <div class="row " id="product_file">
            <div class="col-lg-12 col-md-12 col-12">
                <br class="d-xs-inline d-md-none">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if($this->session->flashdata('consult')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Éxito</strong> <?php echo($this->session->flashdata('consult')); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-12 col-lg-6 text-center">
                                <a id="main-fancy" href="<?php if(!empty($result->image1)){echo(base_url('uploads/img_productos').'/'.$result->image1);}?>" class="fancybox" rel="galeria">
                                    <img class="img-fluid img-product" src="<?php if(!empty($result->image1)){echo(base_url('uploads/img_productos').'/'.$result->image1);} ?>" alt="<?php echo($result->name); ?>">
                                </a>
                                <div class="col-md-12">
                                <?php if($result->galeri!=''):?>
                                <div class="carousel-thumbs mt-3">
                                    <div class="owl-carousel">
                                    <?php $galeria = explode(',',$result->galeri) ?>
                                        <?php foreach($galeria as $k => $v): ?>
                                        <div class="ficha_carousel_img" align="center">
                                            <a  class="fancybox" rel="galeria1" href="<?php echo(base_url('uploads/img_productos').'/'.$v) ?>">
                                                <div style="background: url('<?php echo(base_url('uploads/img_productos').'/'.$v) ?>');background-size: contain;background-position: center;background-repeat: no-repeat;height: 80px;max-width: 120px;"></div>
                                            </a>
                                        </div>
                                        <?php endforeach?>
                                    </div>
                                </div>
                                <?php endif ?>                
                            </div></div>
                            <div class="col-md-12 col-lg-6">
                                <br class="d-lg-block">
                                <div class="col-md-12">
                                    <div class="text-Code">Cod.: <?php echo($result->code); ?></div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="text-Name mb-3"><?php echo($result->name); ?></div>  
                                </div>
                                <div class="col-md-12 mb-5">
                                    <div class="Code"><?php echo($result->description); ?></div>
                                </div>
                                <?php if($this->session->userdata('customer_id')){ ?>
                                    <div class="col-md-12 mb-1">
                                        <div class="text-Price-Unidad">Precio. x Pack/Bulto</div>
                                        <div class="text-Price"><input type="radio" name="optionShopping" required="" value="2" checked>&nbsp;
                                            <?php if($user->id_list_price): ?>
                                                <?php echo('$ '.$result->prices[$user->id_list_price]); ?>
                                            <?php else: ?>   
                                                <?php echo('$ '.$result->price_package);  ?>
                                            <?php endif ?>
                                        </div> 
                                    </div>
                                <?php }else{ ?>
                                <div>
                                <div class="col-md-12 mb-1">
                                    <div class="text-Price-Unidad">Precio. x Unidad</div>
                                    <div class="text-Price"><input type="radio" name="optionShopping" required="" value="1"  checked> $&nbsp;<?php echo(number_format(($result->offer==1 ? $result->offer_price : $result->price_individual),2,'.',',')); ?><span class="text-PriceOffer ml-2"><?php if($result->offer==1){echo('$ '. number_format(($result->price_individual),2,'.',','));} ?></span></div>
                                </div>
                                <div class="col-md-12 mb-1">
                                    <div class="text-Price-Unidad">Precio. x Pack/Bulto</div>
                                    <div class="text-Price"><input type="radio" name="optionShopping" required="" value="2"> $&nbsp;<?php echo(number_format(($result->offer==1 ? $result->offer_price_bulto : $result->price_package),2,'.',',')); ?><span class="text-PriceOffer ml-2"><?php if($result->offer==1){echo('$ '. number_format(($result->price_package),2,'.',','));} ?></span></div>
                                </div>
                                </div>
                                <?php } ?>
                                <div class="col-md-12 mb-3">
                                    <div class="text-Unidad" data-i="<?php echo($result->unit_bulto>0 ? $result->unit_bulto : 0 ); ?>">Contiene <?php echo($result->unit_bulto>0 ? $result->unit_bulto : 0 ); ?> Unidades por bulto/pack</div>
                                </div>
                                <input id="unitPack" name="unitPack" type="hidden" value="<?php echo($result->unit_bulto>0 ? $result->unit_bulto : 0 ); ?>">
                                <div class="col-md-12">
                                    <?php if($result->stock != 0){
                                    echo '<div class="text-Stock mb-4">Stock: Disponible</div>';
                                    }else{
                                    echo '<div class="text-Stock mb-4">Stock: No Disponible</div>'; 
                                    }
                                    ?>
                                </div>
                                <hr>
                                <div class="col-md-12 mb-5">
                                    <div class="row">
                                        <div class="col-md-2 d-none d-sm-none d-md-none d-lg-block">
                                            <input class="text-center text-Qty form-control" type="number" name="qty" id="qty" min="1" value="1" required="">
                                            <span class="d-block d-sm-block d-lg-none d-md-none mb-2"></span>
                                        </div>
                                        <div class="col-md-2  d-block d-sm-block d-md-block d-lg-none">
                                                <input class="text-center text-Qty form-control form-control-block" type="number" name="qty" id="qty" min="1" value="1" required="">
                                                <span class="d-block d-sm-block d-lg-none d-md-none mb-2"></span>
                                        </div>   
                                        <div class="col-md-7">
                                            <a data-id="<?php echo($result->id_product); ?>" data-pack="<?php echo($result->unit_bulto); ?>" data-action="add-product" role="button" class="btn btn-primary btn-buy btn-lg btn-block">AÑADIR AL CARRITO</a>
                                        </div>
                                        <div class="col-md-3 mb-4">
                                            <a role="button" class="d-lg-block d-none d-md-none d-sm-none btn btn-primary btn-Consult btn-lg" data-toggle="modal" data-target="#consultModal"><i class="far fa-envelope text-white"></i></a>
                                            <a role="button" class="d-block d-md-block d-sm-block d-lg-none btn btn-primary btn-Consult btn-lg btn-block mt-2" data-toggle="modal" data-target="#consultModal"><i class="far fa-envelope text-white"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="messageValidationStock"></div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="products-related">
    <div class="container">
        <?php if ($load_Products): ?>
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 offset-md-0 col-12 mt-3 mb-5">
                    <br>
                    <h4 class="d-none d-lg-block mb-0 text-relacionado text-center">PRODUCTOS RELACIONADOS</h4>
                    <h5 class="d-none d-md-block d-lg-none mb-0 text-center text-relacionado">PRODUCTOS RELACIONADOS</h5>
                    <h5 class="d-xs-block d-md-none mb-0 text-center text-relacionado">PRODUCTOS RELACIONADOS</h5>
                    <br>
                </div>
                <?php $this->load->view('frontend/public/products_list') ?>
            </div>
        <?php endif ?>
    </div>
</section>
<div class="modal fade" id="consultModal" tabindex="-1" role="dialog" aria-labelledby="consultModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="<?php echo(base_url('producto').'/'.$result->id_product); ?>" method="POST"  enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="consultModalTitle">CONSULTA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="name-group"><i class="fas fa-user"></i></span>
                            </div>
                            <input required type="text" class="form-control" name="name" placeholder="Nombre" aria-label="name" aria-describedby="name-group">
                        </div>
                    </div>
                    <div class="col-md-6 pl-0">
                        <input required type="text" class="form-control" name="last_name" placeholder="Apellido">
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="phone-group"><i class="fas fa-phone"></i></span>
                            </div>
                            <input required type="number" class="form-control" name="phone" placeholder="Teléfono" aria-label="phone" aria-describedby="phone-group">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="email-group"><i class="fas fa-at"></i></span>
                            </div>
                            <input required type="email" class="form-control" name="email" placeholder="Correo electrónico" aria-label="email" aria-describedby="email-group">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="documentText"><i class="far fa-file-alt"></i></span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="document" name="document" aria-describedby="documentText">
                                <label class="custom-file-label" for="document">Adjunte un archivo.</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-comment"></i></span>
                            </div>
                            <textarea required name="description" class="form-control" aria-label="description" rows="3" placeholder="Comentario"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-buy"><i class="fas fa-paper-plane"></i> Enviar</button>
            </div>
        </form>
    </div>
  </div>
</div>
